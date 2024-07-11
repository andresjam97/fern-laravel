<?php

namespace App\Http\Controllers\Imports;

use App\Http\Controllers\Controller;
use App\Imports\BooksImport;
use App\Imports\EmployeesImport;
use App\Imports\QuestionsImport;
use App\Imports\SchoolsImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ImportsController extends Controller
{
    function employeVw() {
        return view('imports.employeesImport');
    }

    public function importEmployes(Request $request)
    {
        try {
            Excel::import(new EmployeesImport, $request->file('adjunto'));
            return back()->with('success', '¡Importación exitosa!');
        } catch (\Exception $e) {
            return back()->with('error', 'Error en la importación: ' . $e->getMessage());
        }
    }


    function bookVw() {
        return view('imports.booksImport');
    }

    function importBooks(Request $request) {
        try{
        Excel::import(new BooksImport, $request->file('adjunto'));

        return back()->with('success', '¡Importación exitosa!');
    } catch (\Exception $e) {
        return back()->with('error', 'Error en la importación: ' . $e->getMessage());
    }

    }


    function schoolVw() {
        return view('imports.schoolsImport');
    }

    function importSchools(Request $request) {
        try {
            Excel::import(new SchoolsImport, $request->file('adjunto'));
            return back()->with('success', '¡Importación exitosa!');
        }catch (\Exception $e) {
            return back()->with('error', 'Error en la importación: ' . $e->getMessage());
        }

    }


    function questionsVw() {
        return view('imports.questionsImport');
    }

    function importQuestions(Request $request) {
        try {
            Excel::import(new QuestionsImport, $request->file('adjunto'));
            return back()->with('success', '¡Importación exitosa!');
        }catch (\Exception $e) {
            return back()->with('error', 'Error en la importación: ' . $e->getMessage());
        }

    }


    
}
