<?php

namespace App\Http\Controllers\Orders;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Employe;
use App\Models\Orders\OrderDetail;
use App\Models\Orders\OrderHead;
use App\Models\School;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ordersController extends Controller
{
    function index() {
        $empleados = Employe::all();
        return view('orders.orders-index', ['empleados' => $empleados]);
    }

    function createOrder(Request $request) {
        $order = new OrderHead();
        $order->tipo = $request->tipo_solicitud;
        $order->estado = 'ABIERTO';
        $order->fecha_requerida = $request->fecha;
        $order->id_colegio = 1;
        $order->user_id = auth()->user()->id;
        $order->save();

        return redirect()->route('orders-details', $order->id)->with('alerta', [
            'tipo' => 'success',
            'titulo' => 'Exito',
            'texto' => 'Se creo el pedido con el ID '.$order->id
        ]);

    }

    function orderDetails($id) {
        $order = OrderHead::find($id);
        return view('orders.orders-details',['order' => $order]);
    }

    function getorderDetails($id) {
        $datos = OrderDetail::query();
        $datos = $datos->where('id_head', $id);

        return DataTables::of($datos)
        ->addColumn('destroy', function($row) {
            $btn = '<button class="btn btn-danger btn-sm" onclick="destroy('.$row->id.')"><i class="fas fa-delete-left"></i></button>';
            return $btn;
        })

        ->addColumn('manage', function($row) {
            $btn = ' <div class="btn-group" role="group" aria-label="Botones de Colores">
                        <button type="button" class="btn btn-outline-primary return" data-id="'.$row->id.'" ><i class="fas fa-arrow-rotate-left"></i></button>
                        <button type="button" class="btn btn-outline-success sell" data-id="'.$row->id.'" ><i class="fab fa-sellsy"></i></button>
                        <button type="button" class="btn btn-outline-danger pending" data-id="'.$row->id.'"><i class="fas fa-hourglass-half"></i></button>
                    </div>';
            return $btn;
        })
        ->rawColumns(['destroy','manage'])
        ->make(true);
    }

    function getOrders() {
        $datos = OrderHead::query();

        return DataTables::of($datos)
        ->addColumn('detalles', function($row) {
            $btn = '<button class="btn btn-info btn-sm ver" data-id="'.$row->id.'"><i class="fas fa-search"></i></button>';
            return $btn;
        })

        ->addColumn('editar', function($row) {

            $btn = '<a class="btn btn-warning btn-sm" href="/orders/'.$row->id.'"><i class="fas fa-pencil"></i></a>';

            return $btn;
        })

        ->addColumn('confirm', function($row) {
            if ($row->is_confirmed) {
                $btn = 'N/A';

            } else {
                $btn = '<button class="btn btn-success btn-sm confirm" data-id="'.$row->id.'"><i class="fas fa-check"></i></button>';
            }
            return $btn;
        })


        ->addColumn('manage', function($row) {
            $btn = '<button class="btn btn-primary btn-sm manage" data-id="'.$row->id.'"><i class="fas fa-list-check"></i></button>';
            return $btn;
        })

        ->addColumn('confirmed-orders', function($row) {
            $btn = '<button class="btn btn-secondary btn-sm" onclick="confirmed-orders('.$row->id.')"><i class="fas fa-truck-fast"></i></button>';
            return $btn;
        })

        ->addColumn('albaran', function($row) {
            $btn = '<button class="btn btn-outline-info btn-sm" onclick="albaran('.$row->id.')"><i class="fas fa-truck-ramp-box"></i></button>';
            return $btn;
        })

        ->addColumn('document', function($row) {
            $btn = '<button class="btn btn-outline-primary btn-sm" onclick="document('.$row->id.')"><i class="fas fa-file"></i></button>';
            return $btn;
        })
        ->rawColumns(['detalles','editar','confirm','manage','confirmed-orders','albaran','document'])
        ->make(true);
    }

    function orderDetailsInsert(Request $request) {
        try {
            $detalle = new OrderDetail();
            $detalle->id_head = $request->identify;

            if($request->otros == 'Si'){
                $book = new Book();
                $book->name = $request->bookName;
                $book->price = $request->bookPrice;
                $book->save();

                $detalle->id_book = $book->id;
            }
            else{
                $detalle->id_book = 1;
            }
            $detalle->quantity =  $request->quantity;
            $detalle->save();

            return response('ok',200);
        } catch (\Throwable $th) {
            return response($th->getMessage(), 500);
        }
    }

    function sendOrderDetails(Request $request) {
        try {
            $order = OrderHead::find($request->id);
            $order->estado = 'FINALIZADO';
            $order->save();
            return response('ok',200);
        } catch (\Throwable $th) {
            return response($th->getMessage(), 500);
        }

    }


    function getSchools(Request $request, $id) {
        $sugerenciasFiltradas = School::where('name', 'like', '%' . $request->term . '%')
            ->where('employe_id', $id)
            ->select('id','name')
            ->toArray();

        return response()->json($sugerenciasFiltradas);
    }


    function orderConfirmDelivery($id) {

        try {
            $order = OrderHead::find($id);
            $order->is_confirmed = true;
            $order->save();
            return response('ok',200);
        } catch (\Throwable $th) {
            return response($th->getMessage(), 500);

        }


    }


    function orderManagementAproveView() {
        return view('orders.orders-management-aprove');
    }




}
