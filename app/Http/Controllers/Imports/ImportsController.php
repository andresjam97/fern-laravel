<?php

namespace App\Http\Controllers\Imports;

use App\Http\Controllers\Controller;
use App\Imports\BooksImport;
use App\Imports\EmployeesImport;
use App\Imports\SchoolsImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ImportsController extends Controller
{
    function employeVw() {
        return view('imports.employeesImport');
    }

    function importEmployes(Request $request) {

        Excel::import(new EmployeesImport, $request->file('adjunto'));

        return redirect('/')->with('success', 'All good!');
    }


    function bookVw() {
        return view('imports.booksImport');
    }

    function importBooks(Request $request) {
        Excel::import(new BooksImport, $request->file('adjunto'));

        return redirect('/')->with('success', 'All good!');
    }


    function schoolVw() {
        return view('imports.schoolsImport');
    }

    function importSchools(Request $request) {
        Excel::import(new SchoolsImport, $request->file('adjunto'));

        return redirect('/')->with('success', 'All good!');
    }
}
