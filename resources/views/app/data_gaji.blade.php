@extends('layouts.app')

@section('title') Data Gaji Karyawan @endsection

@push('css')
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs5/dt-1.13.1/datatables.min.css"/>
  <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css"/>
  <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/bootstrap.min.css"/>
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
  <style>
    .dataTables_wrapper {
        font-family: sans-serif;
        font-size: 30px;
        position: relative;
        clear: both;
        *zoom: 1;
        zoom: 1;
        align-content: center;
        line-height: 1.5;
        margin-bottom: 15px;
    }
    tfoot tr td {
        float: right;
    }
    .select2-container--default .select2-selection--single{
        padding:6px;
        position: relative;
    }

  </style>
@endpush

@section('content')
    <section class="section">
        <div class="section-header">
            @if (auth()->user()->role == 'admin')
                <h3 class="page__heading">Data Gaji Karyawan</h3>
            @else
                <h3 class="page__heading">Data Gaji {{auth()->user()->name}}</h3>
            @endif
        </div>
        <div class="section-body">
            <div id="err"></div>
            @if (auth()->user()->role == 'Karyawan')
                <div class="alert alert-info my-2">
                    Silahkan Print Slip Gaji Perbulan Dan Berikan Ke Admin Untuk Mengambil Gaji Anda
                </div>
            @endif
            <div class="card">
                @if (auth()->user()->role == 'admin')
                    <div class="card-header">
                        <button class="btn btn-outline-primary btn-sm add"><i class="fas fa-plus"></i></button>
                    </div>
                @endif
                <div class="card-body p-1">
                    @if (auth()->user()->role == 'admin')
                        <div class="table-responsive">
                            <table class="table table-bordered text-center" id="table-gaji">
                                <thead>
                                    <tr>
                                        <th class="text-center">Aksi</th>
                                        <th class="text-center">Tanggal Keluar Gaji</th>
                                        <th class="text-center">Nama Karyawan</th>
                                        <th class="text-center">NIK Karyawan</th>
                                        <th class="text-center">Email Karyawan</th>
                                        <th class="text-center">No Telephone</th>
                                        <th class="text-center">Besar Gaji</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="6" class="text-right">Total Pembayaran Gaji Karyawan : </th>
                                        <th colspan="" class="text-center"></th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-bordered text-center" id="table-gaji-role">
                                <thead>
                                    <tr>
                                        <th class="text-center">Aksi</th>
                                        <th class="text-center">Tanggal Keluar Gaji</th>
                                        <th class="text-center">Nama Karyawan</th>
                                        <th class="text-center">NIK Karyawan</th>
                                        <th class="text-center">Email Karyawan</th>
                                        <th class="text-center">No Telephone</th>
                                        <th class="text-center">Besar Gaji</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="6" class="text-right">Total Gaji Anda : </th>
                                        <th colspan="" class="text-center"></th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
@endsection

@push('modal')
<div class="modal fade" id="gajiModal" tabindex="-1" aria-labelledby="gajiModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="gajiModalLabel"></h5>
      </div>
      <div class="modal-body">
        <form id="form-gaji">
            <input type="hidden" readonly id="id">
            <div class="row">
                <div class="col-6">
                    <div class="form-group">
                        <label for="">Karaywan</label>
                        <select class="form-control" id="users_id">
                            <option selected>-- Pilih --</option>
                            @foreach ($user as $us)
                                <option value="{{ $us->id }}">{{ $us->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label for="">Nominal Gaji</label>
                        <input type="text" class="form-control" id="gaji">
                    </div>
                </div>
            </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        <button type="button" class="btn btn-primary" id="btn"></button>
      </div>
    </div>
  </div>
</div>
@endpush

@push('page_js')
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs5/dt-1.13.1/datatables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>
    <script src="{{ asset('js/pages/gaji.js') }}"></script>
@endpush
