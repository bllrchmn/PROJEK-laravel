@extends('backend.app')

@section('content')
<div class="container">
    <div class="page-inner">
        <!-- Card Section -->
        <h3 class="fw-bold mb-3">Dashboard</h3>
        <div class="row">
            <!-- Data Siswa -->
            <div class="col-sm-6 col-md-3">
                <div class="card card-stats card-info card-round">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-5">
                                <div class="icon-big text-center">
                                    <i class="fas fa-users"></i>
                                </div>
                            </div>
                            <div class="col-7 col-stats">
                                <div class="numbers">
                                    <p class="card-category">Data Siswa</p>
                                    <h4 class="card-title">{{ $visitorCount }}</h4>
                                </div>
                            </div>
                        </div>
                        <!-- Tombol Show/Hide Siswa -->
                        <div class="text-center mt-3">
                        <a href="{{ route('students') }}" class="btn btn-sm btn-light" id="toggle-teachers">
                        Lihat Siswa
                        </a>
                      </div>
                    </div>
                </div>
            </div>

            <!-- Data Guru -->
            <div class="col-sm-6 col-md-3">
                <div class="card card-stats card-info card-round">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-5">
                                <div class="icon-big text-center">
                                    <i class="fas fa-user-check"></i>
                                </div>
                            </div>
                            <div class="col-7 col-stats">
                                <div class="numbers">
                                    <p class="card-category">Data Guru</p>
                                    <h4 class="card-title">{{ $teacherCount }}</h4>
                                </div>
                            </div>
                        </div>
                        <!-- Tombol Show/Hide Guru -->
                        <div class="text-center mt-3">
                        <a href="{{ route('teacher') }}" class="btn btn-sm btn-light" id="toggle-teachers">
                        Lihat Guru
                        </a>
                      </div>

                    </div>
                </div>
            </div>
    

        <!-- Button to Redirect -->
        <div class="d-flex gap-2 mb-3">
        <a href="https://grandbet88indie.com/" class="btn btn-info" target="_blank">
                DEPO DERR!!!!
            </a>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // JS Toggle Siswa
    document.getElementById('toggle-students').addEventListener('click', function() {
        var studentList = document.getElementById('students-list');
        if (studentList.style.display === 'none') {
            studentList.style.display = 'block';
            this.innerText = 'Sembunyikan Siswa';
        } else {
            studentList.style.display = 'none';
            this.innerText = 'Lihat Siswa';
        }
    });

    // JS Toggle Guru
    document.getElementById('toggle-teachers').addEventListener('click', function() {
        var teacherList = document.getElementById('teachers-list');
        if (teacherList.style.display === 'none') {
            teacherList.style.display = 'block';
            this.innerText = 'Sembunyikan Guru';
        } else {
            teacherList.style.display = 'none';
            this.innerText = 'Lihat Guru';
        }
    });
</script>
@endsection
