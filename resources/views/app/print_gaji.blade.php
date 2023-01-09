<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <title>Print Slip Gaji {{ Carbon\Carbon::now()->translatedFormat('F Y'); }}</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/@sweetalert2/theme-bootstrap-4/bootstrap-4.css">
    <!-- Bootstrap 4.1.1 -->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css"/>
    <!-- Ionicons -->
    <link href="//fonts.googleapis.com/css?family=Lato&display=swap" rel="stylesheet">
    <link href="{{ asset('assets/css/@fortawesome/fontawesome-free/css/all.css') }}" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="{{ asset('assets/css/iziToast.min.css') }}">
    <link href="{{ asset('assets/css/sweetalert.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets/css/select2.min.css') }}" rel="stylesheet" type="text/css"/>
    <!-- Template CSS -->
    <link rel="stylesheet" href="{{ asset('web/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('web/css/components.css')}}">

    <style>
        body {
            background-color: whitesmoke;
        }
    </style>
</head>
<body>

<div id="app">
    <div class="main-wrapper main-wrapper-1">
        <div class="container mt-5 mb-5">
            <div class="row">
                <div class="container">
                    <div class="col-md-12">
                        <div class="text-center lh-1 mb-2">
                            <h6 class="fw-bold">Nama Toko</h6> <span class="fw-normal mb-2">Daftar Gaji {{ $data->name }} Bulan {{date('F,Y')}}</span>
                        </div>
                        <div class="d-flex justify-content-end"> <span>Status    :  Karyawan</span> </div>
                        <div class="row">
                            <div class="col-md-10">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div> <span class="fw-bolder">NIK         : </span> <small class="ms-3">{{$data->user->nik}}</small> </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div> <span class="fw-bolder">Nama        : </span> <small class="ms-3">{{$data->user->name}}</small> </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div> <span class="fw-bolder">No Telephone : </span> <small class="ms-3">{{ $data->user->telp }}</small> </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div> <span class="fw-bolder">Alamat       : </span> <small class="ms-3">{{$data->user->alamat}}</small> </div>
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="mt-4 table table-striped table-bordered">
                                    <thead class="bg-secondary">
                                        <tr>
                                            <th scope="col text-white">No</th>
                                            <th scope="col text-white">Tanggal Keluar Gaji</th>
                                            <th scope="col text-white">Nama</th>
                                            <th scope="col text-white">NIK</th>
                                            <th scope="col text-white">No Telephone</th>
                                            <th scope="col text-white">Alamat</th>
                                            <th scope="col text-white">Besar Gaji</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $no = 1;
                                        @endphp
                                        @foreach ($gj as $dt)
                                            <tr>
                                                <th scope="row">{{$no++}}</th>
                                                <td>{{date('d F Y', strtotime($dt->tgl_keluar))}}</td>
                                                <td>{{$dt->user->name}}</td>
                                                <td>{{$dt->user->nik}}</td>
                                                <td>{{$dt->user->telp}}</td>
                                                <td>{{$dt->user->alamat}}</td>
                                                <td>Rp.{{number_format($dt->gaji)}}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <th colspan="6" class="text-right">Total Gaji Yang Harus Di Bayarkan : </th>
                                        <th colspan="1">Rp.{{number_format($dt->gaji)}}</th>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="d-flex justify-content-start ml-5">
                                    <div class="d-flex flex-column mt-4"> <span class="fw-bolder text-center">TTD</span> <span class="fw-bolder mb-5 text-center">Admin</span> <span class="mt-5 text-center">Admin</span> </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="d-flex justify-content-end mr-5">
                                    <div class="d-flex flex-column mt-4"> <span class="fw-bolder text-center">{{date('d,F,Y')}}</span> <span class="fw-bolder mb-5">Kepada Admin Nama Toko</span> <span class="mt-5 text-center">{{$data->user->name}}</span> </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@include('profile.change_password')
@include('profile.edit_profile')

</body>
<script src="{{ asset('assets/js/jquery.min.js') }}"></script>
<script src="{{ asset('assets/js/popper.min.js') }}"></script>
<script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/js/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/js/iziToast.min.js') }}"></script>
<script src="{{ asset('assets/js/select2.min.js') }}"></script>
<script src="{{ asset('assets/js/jquery.nicescroll.js') }}"></script>

<!-- Template JS File -->
<script src="{{ asset('web/js/stisla.js') }}"></script>
<script src="{{ asset('web/js/scripts.js') }}"></script>
<script src="{{ mix('assets/js/profile.js') }}"></script>
<script src="{{ mix('assets/js/custom/custom.js') }}"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{ asset('js/pages/edit-profile.js') }}"></script>
<script>
    window.print()
</script>
</html>

