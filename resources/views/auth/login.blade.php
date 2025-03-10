<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login CEPSTORE</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f1f1f1;
        }
        .login-section {
            min-height: 100vh;
        }
        .login-card {
            border: none;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        .login-image {
            background-color: #2196f3;
            color: white;
            padding: 40px;
            text-align: center;
        }
        .login-image img {
            width: 150px;
            margin-bottom: 20px;
        }
        .login-form {
            padding: 40px;
        }
        .login-form a {
            text-decoration: none;
        }
    </style>
</head>
<body>

<div class="container login-section d-flex justify-content-center align-items-center">
    <div class="row login-card w-75">
        <!-- Form Section -->
        <div class="col-md-6 login-form">
            <div class="text-center mb-4">
                <img src="https://myekbis.jeb.polinela.ac.id/assets/img/about.svg" alt="Login Image" width="120">
                <h3 class="mt-3">Login CEPSTORE</h3>
                <p>Silahkan Login Ke Akun Anda</p>
            </div>
            <form method="POST" action="{{ route('login') }}">
    @csrf

    <!-- Email -->
    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input id="email" type="email" name="email" class="form-control" value="{{ old('email') }}" required autofocus autocomplete="username">
    </div>
 

    <!-- Password -->
    <div class="mb-3 position-relative">
    <label for="password" class="form-label">Password</label>
    <input id="password" type="password" name="password" class="form-control pe-5" required autocomplete="current-password">
    <span class="position-absolute top-50 translate-middle-y end-0 me-3" style="cursor: pointer;" onclick="togglePassword()">
        <i id="eyeIcon" class="fa fa-eye"></i>
    </span>
</div>

<!-- Font Awesome CDN (untuk ikon mata) -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

<script>
function togglePassword() {
    const passwordInput = document.getElementById('password');
    const eyeIcon = document.getElementById('eyeIcon');
    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        eyeIcon.classList.remove('fa-eye');
        eyeIcon.classList.add('fa-eye-slash');
    } else {
        passwordInput.type = 'password';
        eyeIcon.classList.remove('fa-eye-slash');
        eyeIcon.classList.add('fa-eye');
    }
}
</script>

<style>
/* Agar ikon mata berada di dalam input */
.position-relative .form-control {
    padding-right: 2.5rem; /* ruang untuk ikon */
}

.position-relative span {
    height: 100%;
    display: flex;
    align-items: center;
}
</style>

    
    <!-- Remember Me -->
    <div class="form-group d-flex justify-content-between align-items-center">
        <div>
            <input id="remember_me" type="checkbox" name="remember">
            <label for="remember_me">Remember me</label>
        </div>
        <a href="{{ route('password.request') }}">Lupa Password?</a>
    </div>

    <!-- Button -->
    <div class="d-grid mb-3">
        <button type="submit" class="btn btn-primary">Login</button>
    </div>

    <!-- Register -->
    <div class="text-center">
        Belum punya akun? <a href="{{ route('register') }}" class="text-danger">Sign Up</a>
    </div>
</form>

        </div>
        <!-- Welcome Section -->
        <div class="col-md-6 login-image d-flex flex-column justify-content-center align-items-center">
            <h3 class="mb-3">Selamat Datang Di Perusahaan CEPSKY</h3>
            <img src="https://blogger.googleusercontent.com/img/b/R29vZ2xl/AVvXsEiXV5c-UbMWn1ezE4Wx1WBmX_4FhURz7-tySuD0J_CE44PYHMh4z6g1eD47Da803dFjNFl1DQ3ZuKLGuOigPhB-LetMLLAyi1I9ZogDTHwUT2pymP3nQChxsDqFJh7ZicUILyEd2e3vGq7E1s4D2r5c0sd83Y-DQQ8wKte4YfL4dK-1HmG38ZV3KGDtI0a1/s320/vector-billal.png" alt="Avatar" class="rounded-circle mb-3" width="120">
            <p>Silahkan login dan anda akan diarahkan ke bagian Dashboard kami. Terima Kasih.</p>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>