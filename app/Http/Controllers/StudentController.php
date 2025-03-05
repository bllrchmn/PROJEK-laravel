<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
class StudentController extends Controller
{
   public function index()
   {
    $students = DB::table('students')->get();

    // dd($students);
    return view('student.index', compact('students'));
   }
}
