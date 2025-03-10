<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class StudentController extends Controller
{

    public function index(Request $request)
    {
        // Ambil kata kunci pencarian dari form
        $search = $request->query('search');

        // Jika ada keyword, filter data
        $students = Student::query()
            ->when($search, function ($query, $search) {
                return $query->where('name', 'like', '%' . $search . '%')
                             ->orWhere('email', 'like', '%' . $search . '%')
                             ->orWhere('class', 'like', '%' . $search . '%');
            })
            ->orderBy('name', 'asc') // Urutkan data
            ->paginate(2); // Ambil data

        // Kirim data ke view
        return view('backend.student.index', compact('students'));
    }


    public function create()
    {
        return view('backend.student.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|unique:students,email',
            'phone'   => 'required|string|max:15',
            'class'   => 'required|string|max:50',
            'address' => 'required|string|max:255',
            'gender'  => 'required|in:L,P',
            'status'  => 'required|in:Active,Inactive',
            'photo'   => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $validatedData = $validator->validated();

        // Jika ada file foto yang diunggah, simpan
        if ($request->hasFile('photo')) {
            $validatedData['photo'] = $this->uploadPhoto($request->file('photo'));
        }

        // Simpan data ke database
        Student::create($validatedData);
        return redirect()->route('students')->with('success', 'Berhasil menambahkan data siswa!');

        // session()->flash('success', 'Data siswa berhasil ditambahkan!');
        // return redirect()->route('students');
    }

    public function edit($id)
    {
        $student = Student::findOrFail($id);
        return view('backend.student.edit', compact('student'));
    }

    public function update(Request $request, $id)
    {
        $student = Student::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|unique:students,email,' . $id,
            'phone'   => 'required|string|max:15',
            'class'   => 'required|string|max:50',
            'address' => 'required|string|max:255',
            'gender'  => 'required|in:L,P',
            'status'  => 'required|in:Active,Inactive',
            'photo'   => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $validatedData = $validator->validated();

        // Jika ada file foto baru yang diunggah, hapus foto lama dan simpan yang baru
        if ($request->hasFile('photo')) {
            if ($student->photo) {
                $this->deleteOldPhoto($student->photo);
            }
            $validatedData['photo'] = $this->uploadPhoto($request->file('photo'));
        }

        // Update data siswa
        $student->update($validatedData);

        session()->flash('success', 'Data siswa berhasil diperbarui!');
        return redirect()->route('students');
    }

    public function destroy($id)
    {
        $student = Student::findOrFail($id);

        // Hapus foto jika ada
        if ($student->photo) {
            $this->deleteOldPhoto($student->photo);
        }

        // Hapus data siswa
        $student->delete();

        session()->flash('success', 'Data siswa berhasil dihapus!');
        return redirect()->route('students');
    }

    /**
     * Fungsi untuk mengunggah foto ke folder 'backend/images'
     */
    private function uploadPhoto($file)
    {
        $folderPath = public_path('backend/images');

        // Buat folder jika belum ada
        if (!File::exists($folderPath)) {
            File::makeDirectory($folderPath, 0777, true, true);
        }

        // Buat nama unik untuk file
        $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        $file->move($folderPath, $fileName);

        return $fileName;
    }

    /**
     * Fungsi untuk menghapus foto lama
     */
    private function deleteOldPhoto($fileName)
    {
        $filePath = public_path('backend/images/' . $fileName);
        if (File::exists($filePath)) {
            File::delete($filePath);
 }
}
}