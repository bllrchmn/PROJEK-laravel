<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Teacher;

class DashboardController extends Controller
{
    public function index()
    {
        $visitorCount = Student::count(); // Jumlah siswa
        $teacherCount = Teacher::count(); // Jumlah guru
    
        $students = Student::all(); // Ambil semua siswa
        $teachers = Teacher::all(); // Ambil semua guru
    
        return view('backend.dashboard.index', compact('visitorCount', 'teacherCount', 'students', 'teachers'));
    }

}
