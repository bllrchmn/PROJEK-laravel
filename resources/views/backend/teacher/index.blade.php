@extends('backend.app')

@section('content')

<div class="container d-flex justify-content-center">
    <div class="col-lg-10">
    
        {{-- Search Bar Minimalis --}}
        <form action="{{ route('teacher') }}" method="GET" class="mb-4">
            <div class="position-relative">
                <input type="text" 
                       name="search" 
                       class="form-control form-control-sm rounded-pill ps-4 pe-5 shadow-sm border-light" 
                       placeholder="Cari nama atau email guru..." 
                       value="{{ request('search') }}">

                <button type="submit" class="btn btn-link position-absolute top-50 end-0 translate-middle-y me-3 p-0">
                    <i class="fas fa-search text-secondary"></i>
                </button>

                @if(request('search'))
                <a href="{{ route('teacher') }}" class="btn btn-link position-absolute top-50 end-0 translate-middle-y me-5 p-0">
                    <i class="fas fa-times-circle text-danger"></i>
                </a>
                @endif
            </div>
        </form>

        {{-- Judul --}}
        <h3 class="fw-bold mb-3 text-center">Halaman Guru</h3>

        <div class="d-flex justify-content-between mb-3">
            <a href="{{ route('dashboard') }}" class="btn btn-info">Kembali</a>
            <a href="{{ route('teacher.create') }}" class="btn btn-info">+ Tambah Teacher</a>
        </div>

        {{-- Notifikasi Berhasil --}}
        @if(session('success'))
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                Swal.fire({
                    title: "Berhasil!",
                    text: "{{ session('success') }}",
                    icon: "success",
                    confirmButtonText: "OK"
                });
            });
        </script>
        @endif

        {{-- Tabel Guru --}}
       {{-- Tabel Guru --}}
<div class="card shadow-sm">
    <div class="card-body p-2">
        <div class="table-responsive" style="overflow-y: auto; max-height: 400px;">
            <table class="table table-hover table-striped table-bordered table-sm text-center small table-cyan align-middle">
                <thead class="table-info">
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Telepon</th>
                        <th>Foto</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($teachers as $index => $teacher)
                    <tr>
                        <td>{{ ($teachers->currentPage() - 1) * $teachers->perPage() + $index + 1 }}</td>
                        <td class="text-start">{{ $teacher->name }}</td>
                        <td>{{ $teacher->email }}</td>
                        <td>{{ $teacher->phone }}</td>
                        <td>
                            @if($teacher->photo)
                                <img src="{{ asset('backend/images/' . $teacher->photo) }}" 
                                     alt="Foto Guru" 
                                     class="rounded-circle teacher-photo" 
                                     width="40" 
                                     height="40" 
                                     style="object-fit: cover; cursor: pointer;"
                                     data-src="{{ asset('backend/images/' . $teacher->photo) }}">
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>
                            <span class="badge bg-{{ $teacher->status == 'Aktif' ? 'success' : 'danger' }}">
                                {{ $teacher->status }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('teacher.edit', $teacher->id) }}" class="btn btn-warning btn-sm">
                                <i class="fas fa-edit"></i>
                            </a>
                            <button type="button" class="btn btn-danger btn-sm delete-btn" data-url="{{ route('teacher.destroy', $teacher->id) }}">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted">Tidak ada data guru</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- Pagination DI LUAR TABEL --}}
<div class="d-flex justify-content-center mt-3">
    {{ $teachers->onEachSide(1)->links('vendor.pagination.bootstrap-5') }}
</div>

    </div>
</div>

{{-- Modal Foto --}}
<div class="modal fade" id="photoModal" tabindex="-1" aria-labelledby="photoModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0 shadow">
      <div class="modal-header border-0">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body p-0 text-center">
        <img src="" id="modalImage" class="w-100 rounded-3" style="object-fit: contain; max-height: 500px;" alt="Foto Guru">
        <button type="button" class="btn btn-sm btn-secondary mt-3" data-bs-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>

{{-- SweetAlert --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Hapus data
        document.querySelectorAll('.delete-btn').forEach(button => {
            button.addEventListener('click', function() {
                confirmDelete(this.getAttribute('data-url'));
            });
        });

        // Buka modal gambar
        document.querySelectorAll('.teacher-photo').forEach(img => {
            img.addEventListener('click', function() {
                const src = this.getAttribute('data-src');
                document.getElementById('modalImage').src = src;
                const myModal = new bootstrap.Modal(document.getElementById('photoModal'));
                myModal.show();
            });
        });
    });

    function confirmDelete(url) {
        Swal.fire({
            title: "Yakin ingin menghapus?",
            text: "Data yang dihapus tidak dapat dikembalikan!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6",
            confirmButtonText: "Ya, Hapus!",
            cancelButtonText: "Batal"
        }).then((result) => {
            if (result.isConfirmed) {
                let form = document.createElement('form');
                form.method = 'POST';
                form.action = url;

                let csrfInput = document.createElement('input');
                csrfInput.type = 'hidden';
                csrfInput.name = '_token';
                csrfInput.value = @json(csrf_token());

                let methodInput = document.createElement('input');
                methodInput.type = 'hidden';
                methodInput.name = '_method';
                methodInput.value = 'DELETE';

                form.appendChild(csrfInput);
                form.appendChild(methodInput);
                document.body.appendChild(form);
                form.submit();
            }
        });
    }
</script>

{{-- Custom CSS --}}
<style>
    .table-cyan thead {
        background-color: #e0f7fa;
    }

    .table-cyan tbody tr {
        background-color: #f1fbfc;
    }

    input.form-control:focus {
        border-color: #86b7fe;
        box-shadow: 0 0 0 0.15rem rgba(13, 110, 253, 0.15);
    }

    input.form-control {
        transition: all 0.2s ease-in-out;
    }

    .btn-link i:hover {
        color: #0d6efd;
        transition: color 0.2s;
    }

    .position-relative .btn-link {
        height: 24px;
        width: 24px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    table th, table td {
        white-space: nowrap;
        padding: 6px 10px;
    }

    .rounded-circle {
        object-fit: cover;
    }

    .modal-body img {
        max-width: 100%;
        height: auto;
    }
</style>

@endsection
