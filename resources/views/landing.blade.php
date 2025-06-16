<!DOCTYPE html>
<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default"
    data-assets-path="../../assets/" data-template="horizontal-menu-template">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>{{ env('app_name') }}</title>

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('img/favicon.png') }}" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap"
        rel="stylesheet" />

    <!-- Icons -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/fonts/materialdesignicons.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/fonts/fontawesome.css') }}" />
    <!-- Menu waves for no-customizer fix -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/node-waves/node-waves.css') }}" />
    <!-- CDN untuk Material Design Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@mdi/font/css/materialdesignicons.min.css" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/rtl/core.css') }}" class="template-customizer-core-css" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/rtl/theme-default.css') }}"
        class="template-customizer-theme-css" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/toastr/toastr.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/demo.css') }}" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/typeahead-js/typeahead.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/spinkit/spinkit.css') }}" />

    <!-- Page CSS -->

    <!-- Helpers -->
    <script src="{{ asset('assets/vendor/js/helpers.js') }}"></script>

    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Template customizer: To hide customizer set displayCustomizer value false in config.js.  -->
    {{-- <script src="{{ asset('assets/vendor/js/template-customizer.js') }}"></script> --}}
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="{{ asset('assets/js/config.js') }}"></script>

    <link rel="stylesheet" href="{{ asset('css/landing-page.css') }}" />
</head>

<body>
    <!-- Navbar -->
<nav class="navbar">
    <div class="logo">
        <!-- Replace Laravel logo with app logo or smaller image -->
        <img src="{{ asset('img/logo.png') }}" alt="Logo" />
        <!-- Removed app name text to avoid extra left alignment -->
    </div>
    <div class="nav-links">
        <a href="{{ route('login') }}" class="login">Masuk</a>
        <a href="{{ route('register') }}" class="register">Daftar</a>
    </div>
</nav>

    <!-- Hero Section -->
    <section class="hero" style="padding: 3rem 2rem; background-color: #c6e2c6; text-align: center;">
        <h1>
            <span class="highlight-green">Mulai Jaga Bumi</span><br/>
            <span class="highlight-black">Jadwalkan Penjemputan Sampah </span><span class="highlight-blue">& Dapatkan Saldo</span>
        </h1>
        <p>
            Jaga Lingkungan, Tukar Sampah Jadi Saldo yang Bisa Dicairkan dan Nikmati Hadiah!
        </p>
        <button class="btn-primary" style="padding: 0.75rem 1.5rem; font-weight: 700;" onclick="window.location.href='{{ route('register') }}'">Mulai Sekarang</button>
    </section>

    <!-- Features Section -->
    <section class="features">
        <div class="feature-card">
            <i class="mdi mdi-recycle"></i>
            <h3>Manajemen Jenis Sampah</h3>
            <p>Mengelola berbagai jenis sampah dengan mudah dan efisien untuk mendukung proses daur ulang.</p>
        </div>
        <div class="feature-card">
            <i class="mdi mdi-account-multiple"></i>
            <h3>Manajemen Pengguna</h3>
            <p>Memudahkan pengelolaan pengguna dengan fitur role-based access control dan interaksi yang aman.</p>
        </div>
        <div class="feature-card">
            <i class="mdi mdi-calendar-clock"></i>
            <h3>Jadwal Penjemputan</h3>
            <p>Atur dan pantau jadwal penjemputan sampah secara real-time untuk kenyamanan pengguna.</p>
        </div>
    </section>

    <!-- How It Works Section -->
    <section class="how-it-works">
        <h2>Cara Kerja RecyclePay</h2>
        <div class="steps">
            <div class="step">
                <div class="icon mdi mdi-account-plus"></div>
                <h4>Registrasi</h4>
                <p>Melakukan Registrasi jika belum memiliki akun</p>
            </div>
            <div class="step">
                <div class="icon mdi mdi-calendar-clock"></div>
                <h4>Jadwalkan Penjemputan</h4>
                <p>Melakukan penjadwalan penjemputan sampah</p>
            </div>
            <div class="step">
                <div class="icon mdi mdi-file-document"></div>
                <h4>Isi Form Transaksi</h4>
                <p>Melakukan pengisian form transaksi sampah</p>
            </div>
            <div class="step">
                <div class="icon mdi mdi-check-decagram"></div>
                <h4>Verifikasi Admin</h4>
                <p>Admin memverifikasi sampah yang dijemput sesuai form transaksi</p>
            </div>
            <div class="step">
                <div class="icon mdi mdi-cash-multiple"></div>
                <h4>Saldo Diterima</h4>
                <p>Masyarakat menerima saldo langsung di akun mereka</p>
            </div>
        </div>
    </section>

    <!-- Roles Section -->
    <section class="roles">
        <h2>Peran dalam RecyclePay</h2>
        <div class="role-cards">
            <div class="role-card">
                <div class="icon mdi mdi-account-tie"></div>
                <h4>Super Admin</h4>
                <p>Mengelola seluruh sistem, termasuk pengguna, RecyclePay, dan memastikan ekosistem berjalan dengan baik.</p>
            </div>
            <div class="role-card">
                <div class="icon mdi mdi-domain"></div>
                <h4>Kepala Dinas Lingkungan</h4>
                <p>Memantau dan memastikan pengelolaan sampah serta pelaksanaan program berjalan sesuai regulasi dan kebijakan.</p>
            </div>
            <div class="role-card">
                <div class="icon mdi mdi-account-multiple"></div>
                <h4>End User</h4>
                <p>Masyarakat yang dapat mendaftar, meminta penjemputan sampah, dan menukar sampah menjadi saldo di dalam aplikasi.</p>
            </div>
        </div>
    </section>

    <!-- Final Call to Action -->
    <section class="final-cta">
        <h2>Siap Mengubah Sampahmu Jadi Berkah?</h2>
        <p>Bergabunglah dengan RecyclePay dan lihat bagaimana aplikasi ini bisa membuat sampahmu bernilai!</p>
        <button class="btn-primary" onclick="window.location.href='{{ route('register') }}'">Mulai Perjalanan RecyclePay-mu</button>
    </section>

    <!-- Footer -->
<footer class="footer">
    <p>© 2024 {{ env('app_name') }} Mengubah sampah menjadi berkah untuk masa depan yang lebih hijau.</p>
</footer>
</body>

</html>
