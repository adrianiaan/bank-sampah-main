<!DOCTYPE html>

<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default"
    data-assets-path="../../assets/" data-template="horizontal-menu-template">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>{{ env('app_name') }}</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('img/laravel.png') }}" />

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
</head>

<body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-navbar-full layout-horizontal layout-without-menu">
        <div class="layout-container">
            <!-- Navbar -->

            <nav class="layout-navbar navbar navbar-expand-xl align-items-center bg-navbar-theme" id="layout-navbar">
                <div class="container-xxl">
                    <div class="navbar-brand app-brand demo d-none d-xl-flex py-0 me-4">
                        <a href="index.html" class="app-brand-link">
                            <img src="{{ asset('img/laravel.png') }}" alt="Logo" class="app-brand-logo demo"
                                style="width: 45px; height:45px;">
                            <span class="app-brand-text demo menu-text fw-bold ms-2">{{ env('app_name') }}</span>
                        </a>

                        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-xl-none">
                            <i class="mdi mdi-close align-middle"></i>
                        </a>
                    </div>

                    <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
                        <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
                            <i class="mdi mdi-menu mdi-24px"></i>
                        </a>
                    </div>

                    <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
                        <ul class="navbar-nav flex-row align-items-center ms-auto">
                            <!-- Search -->

                            <!-- /Search -->

                            <!-- Language -->

                            <!--/ Language -->

                            <!-- Style Switcher -->
                            <li class="nav-item me-1 me-xl-0">
                                <a class="nav-link btn btn-text-secondary rounded-pill btn-icon style-switcher-toggle hide-arrow"
                                    href="javascript:void(0);">
                                    <i class="mdi mdi-24px"></i>
                                </a>
                            </li>
                            <li class="nav-item navbar-search-wrapper me-1 me-xl-0">
                                <a class="nav-link" href="{{ route('login') }}">
                                    Login <i class="mdi mdi-login mdi-24px scaleX-n1-rtl"></i>
                                </a>
                            </li>
                            <!--/ Style Switcher -->

                            <!-- Quick links  -->

                            <!-- Quick links -->

                            <!-- Notification -->

                            <!--/ Notification -->

                            <!-- User -->

                            <!--/ User -->
                        </ul>
                    </div>

                    <!-- Search Small Screens -->
                    <div class="navbar-search-wrapper search-input-wrapper container-xxl d-none">
                        <input type="text" class="form-control search-input border-0" placeholder="Search..."
                            aria-label="Search..." />
                        <i class="mdi mdi-close search-toggler cursor-pointer"></i>
                    </div>
                </div>
            </nav>

            <!-- / Navbar -->

            <!-- Layout container -->
            <div class="layout-page">
                <!-- Content wrapper -->
                <div class="content-wrapper">

                    <!-- / Menu -->

                    <!-- Content -->

                    <div class="container-xxl flex-grow-1 container-p-y">
                        <h4 class="fw-bold py-3 mb-4">Kalkulator Bank Sampah</h4>


                        <div class="row mb-5">

                            <div class="w-100"></div>
                            <div class="col-md">
                                <div class="card card-action mb-4">
                                    <div class="card-body">
                                        <form action="{{ route('riwayat.store') }}" method="post"
                                            id="form-input-riwayat">
                                            @csrf
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="form-floating form-floating-outline mb-3">
                                                        <input class="form-control" id="name" type="text"
                                                            name="name" placeholder="Name" autofocus />
                                                        <label for="name">Name</label>
                                                        <span class="text-danger name_error"></span>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="form-floating form-floating-outline mb-3">
                                                        <input class="form-control" id="no_telepon" type="number"
                                                            name="no_telepon" placeholder="No Telepon" autofocus />
                                                        <label for="No Telepon">No Telepon</label>
                                                        <span class="text-danger no_telepon_error"></span>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="form-floating form-floating-outline mb-3">
                                                        <select name="jenis_sampah_id" id="jenis_sampah_id"
                                                            class="form-control">
                                                            <option value="">--pilih--</option>

                                                        </select>
                                                        <label for="name">Jenis Sampah</label>
                                                        <span class="text-danger jenis_sampah_id_error"></span>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="mb-3">
                                                        <div class="input-group input-group-merge ">

                                                            <div class="form-floating form-floating-outline">
                                                                <input type="number" class="form-control"
                                                                    name="lama_penyimpanan" id="lama_penyimpanan"
                                                                    placeholder="499"
                                                                    aria-label="Amount (to the nearest dollar)"
                                                                    min="1" />
                                                                <label>Lama Penyipanan</label>
                                                            </div>
                                                            <span class="input-group-text">Hari</span>
                                                        </div>
                                                        <span class="text-danger harga_error "></span>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="mb-3">
                                                        <div class="input-group input-group-merge ">
                                                            <span class="input-group-text">Kg</span>
                                                            <div class="form-floating form-floating-outline">
                                                                <input type="number" class="form-control"
                                                                    name="jumlah_kg" id="jumlah_kg" placeholder="499"
                                                                    aria-label="Amount (to the nearest dollar)"
                                                                    min="1" />
                                                                <label>Jumlah Kg</label>
                                                            </div>
                                                        </div>
                                                        <span class="text-danger harga_error "></span>
                                                    </div>
                                                </div>
                                                <div class="col-6">

                                                    <div class="mb-3">
                                                        <div class="input-group input-group-merge ">
                                                            <span class="input-group-text">Rp</span>
                                                            <div class="form-floating form-floating-outline">
                                                                <input class="form-control" id="total_biaya"
                                                                    type="text" name="total_biaya"
                                                                    placeholder="total_biaya" autofocus readonly />
                                                                <label>Total Uang Yang Di Terima</label>
                                                            </div>
                                                        </div>
                                                        <span class="text-danger harga_error "></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="float-end">
                                                <button type="submit" class="btn btn-primary">Submit</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md">
                                <div class="card card-action mb-4">
                                    <div class="card-header">
                                        <h5 class="h5">Detail Transaksi</h5>
                                    </div>
                                    <div class="card-body" id="detail">

                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="container-xxl flex-grow-1 container-p-y">
                        <h4 class="fw-bold py-3 mb-4">Dashboard</h4>


                        <div class="row mb-5">

                            <div class="w-100"></div>
                            <div class="col-md-8">
                                <div class="card card-action mb-4">
                                    <div class="card-header">
                                        <h5 class="h5">Riwayat Transaksi Terakhir</h5>
                                    </div>
                                    <div class="card-body">
                                        {{ $dataTable->table() }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card card-action mb-4">
                                    <div class="card-header">
                                        <h5 class="h5">Grafik Trend Sampah</h5>
                                    </div>
                                    <div class="card-body">
                                        {!! $chart->container() !!}
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <!--/ Content -->

                    <!-- Footer -->
                    <footer class="content-footer footer bg-footer-theme">
                        <div class="container-xxl">
                            <div
                                class="footer-container d-flex align-items-center justify-content-between py-3 flex-md-row flex-column">
                                <div class="mb-2 mb-md-0">
                                    ©
                                    <script>
                                        document.write(new Date().getFullYear());
                                    </script>
                                    , made with by
                                    <a href="https://pixinvent.com" target="_blank"
                                        class="footer-link fw-medium">Adrian Akhmad Firdaus</a>
                                </div>

                            </div>
                        </div>
                    </footer>
                    <!-- / Footer -->

                    <div class="content-backdrop fade"></div>
                </div>
                <!--/ Content wrapper -->
            </div>

            <!--/ Layout container -->
        </div>
    </div>

    <!-- Overlay -->
    <div class="layout-overlay layout-menu-toggle"></div>

    <!-- Drag Target Area To SlideIn Menu On Small Screens -->
    <div class="drag-target"></div>

    <!--/ Layout wrapper -->

    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->
    <script src="{{ asset('assets/vendor/libs/jquery/jquery.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/popper/popper.js') }}"></script>
    <script src="{{ asset('assets/vendor/js/bootstrap.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/node-waves/node-waves.js') }}"></script>

    <script src="{{ asset('assets/vendor/libs/hammer/hammer.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/i18n/i18n.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/typeahead-js/typeahead.js') }}"></script>

    <script src="{{ asset('assets/vendor/js/menu.js') }}"></script>
    <!-- endbuild -->

    <!-- Vendors JS -->
    <script src="{{ asset('assets/vendor/libs/block-ui/block-ui.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/sortablejs/sortable.js') }}"></script>


    <!-- Main JS -->
    <script src="{{ asset('assets/js/main.js') }}"></script>

    <!-- Page JS -->
    <script src="{{ asset('assets/js/cards-actions.js') }}"></script>
    <script>
        let url = `{{ url('/') }}`;
    </script>
    <script src="{{ asset('js/frontend.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js') }}"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.0.3/css/buttons.dataTables.min.css">
    <script src="https://cdn.datatables.net/buttons/1.0.3/js/dataTables.buttons.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.0.3/css/buttons.dataTables.min.css">
    <script src="https://cdn.datatables.net/buttons/1.0.3/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js" charset="utf-8"></script>
    <script src="{{ asset('/vendor/datatables/buttons.server-side.js') }}"></script>
    {{ $dataTable->scripts() }}
    {!! $chart->script() !!}
    <script src="{{ asset('assets/vendor/libs/toastr/toastr.js') }}"></script>
    <script>
        $(document).ready(function() {
            toastr.options = {
                "closeButton": true,
                "debug": false,
                "newestOnTop": false,
                "progressBar": true,
                "positionClass": "toast-top-right",
                "preventDuplicates": false,
                "onclick": null,
                "showDuration": "300",
                "hideDuration": "1000",
                "timeOut": "5000",
                "extendedTimeOut": "1000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            };
        });
    </script>
</body>

</html>
