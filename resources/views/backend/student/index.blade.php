@extends('backend.app')

@section('content')

<div class="container d-flex justify-content-center">
    <div class="col-lg-10">

        {{-- Search Bar --}}
        <form action="{{ route('students') }}" method="GET" class="mb-4">
            <div class="position-relative">
                <input type="text" 
                       name="search" 
                       class="form-control form-control-sm rounded-pill ps-4 pe-5 shadow-sm border-light" 
                       placeholder="Cari nama, email, atau kelas siswa..." 
                       value="{{ request('search') }}">
                <button type="submit" 
                        class="btn btn-link position-absolute top-50 end-0 translate-middle-y me-3 p-0">
                    <i class="fas fa-search text-secondary"></i>
                </button>
                @if(request('search'))
                <a href="{{ route('students') }}" 
                   class="btn btn-link position-absolute top-50 end-0 translate-middle-y me-5 p-0">
                    <i class="fas fa-times-circle text-danger"></i>
                </a>
                @endif
            </div>
        </form>

        {{-- Judul --}}
        <h3 class="fw-bold mb-3 text-center">Halaman Mahasiswa</h3>

        {{-- Tombol Tambah --}}
        <div class="d-flex justify-content-between mb-3">
            <a href="{{ route('dashboard') }}" class="btn btn-info">Kembali</a>
            <a href="{{ route('teacher.create') }}" class="btn btn-info">+ Tambah Student</a>
        </div>

        {{-- Notifikasi Berhasil --}}
        @if(session('success'))
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                Swal.fire({
                    title: "Berhasil!",
                    text: "{{ session('success') }}",
                    icon: "success",
                    showConfirmButton: false,
                    timer: 2000,
                    timerProgressBar: true
                });
            });
        </script>
        @endif

        {{-- Tabel Data --}}
        <div class="card shadow-sm">
            <div class="card-body p-2">
                <div class="table-responsive" style="overflow-y: auto; max-height: 400px;">
                    <table class="table table-hover table-striped table-bordered table-sm text-center small align-middle">
                        <thead class="table-info">
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Kelas</th>
                                <th>Gender</th>
                                <th>Status</th>
                                <th>Foto</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($students as $index => $student)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td class="text-start">{{ $student->name }}</td>
                                <td>{{ $student->email }}</td>
                                <td><span class="badge bg-primary">{{ $student->class }}</span></td>
                                <td>
                                    <span class="badge bg-{{ $student->gender == 'L' ? 'info' : 'warning' }}">
                                        <i class="fas fa-{{ $student->gender == 'L' ? 'male' : 'female' }}"></i> {{ $student->gender }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge bg-{{ $student->status == 'Active' ? 'success' : 'danger' }}">
                                        <i class="fas fa-{{ $student->status == 'Active' ? 'check-circle' : 'times-circle' }}"></i>
                                        {{ $student->status == 'Active' ? 'Aktif' : 'Tidak Aktif' }}
                                    </span>
                                </td>
                                <td>
                                    @if($student->photo)
                                        <img src="{{ asset('backend/images/' . $student->photo) }}" alt="Foto Siswa" class="rounded-circle" width="40" height="40">
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('students.edit', $student->id) }}" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                                    <form action="{{ route('students.destroy', $student->id) }}" method="POST" class="d-inline" onsubmit="return confirmDelete(event, this)">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted">Tidak ada data siswa</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                    {{ $students->links() }}
                </div>
            </div>
        </div>

    </div>
</div>

{{-- SweetAlert Delete --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function confirmDelete(event, form) {
        event.preventDefault();
        Swal.fire({
            title: 'Yakin ingin menghapus?',
            text: "Data yang dihapus tidak bisa dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    }
</script>

{{-- Custom CSS --}}
<style>
    .table thead { background-color: #e0f7fa; }
    .table tbody tr { background-color: #f9fcfd; }
    input.form-control:focus { border-color: #86b7fe; box-shadow: 0 0 0 0.15rem rgba(13, 110, 253, 0.15); }
    .position-relative .btn-link { height: 24px; width: 24px; display: flex; align-items: center; justify-content: center; }
    .btn-link i:hover { color: #0d6efd; }
    table th, table td { white-space: nowrap; padding: 6px 10px; }
    img.rounded-circle { object-fit: cover; width: 40px; height: 40px; }
</style>

@endsection
