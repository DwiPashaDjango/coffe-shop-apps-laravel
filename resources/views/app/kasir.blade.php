@extends('layouts.app')

@section('title') Kasir @endsection

@push('css')
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs5/dt-1.13.1/datatables.min.css"/>
  <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css"/>
  <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/bootstrap.min.css"/>
  <style>
    .dataTables_wrapper {
        font-family: sans-serif;
        font-size: 20px;
        position: relative;
        clear: both;
        *zoom: 1;
        zoom: 1;
        align-content: center
    }
    .qty {
        width: 50px;
        outline: none;
        border: none;
    }
    #total {
        width: 90%;
        height: 50%;
        outline: none;
    }
    #kembalian {
        outline: none;
        border: none;
    }
  </style>
@endpush

@section('content')
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">Kasir</h3>
        </div>
        <div class="section-body">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <input type="text" class="form-control" id="nm_pembeli" placeholder="Masukan Nama Pembeli">
                        </div>
                        <div class="col-6">
                            <select class="form-control" id="barang_id">
                                <option selected>-- Pilih --</option>
                            </select>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end">
                        <button class="btn btn-outline-secondary btn-md mt-3 batal mr-2">Batal</button>
                        <button class="btn btn-outline-primary btn-md mt-3 bayar">Pesan</button>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body p-1">
                    <div class="table-responsive">
                        <table class="table table-bordered text-center" id="table-kasir">
                            <thead>
                                <tr>
                                    <th class="text-center">Aksi</th>
                                    <th class="text-center">Kode</th>
                                    <th class="text-center">Nama Pembeli</th>
                                    <th class="text-center">Makanan / Minuman</th>
                                    <th class="text-center">Qty</th>
                                    <th class="text-center">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                
                            </tbody>
                            <tfoot>
                                <th colspan="5" class="text-right">Total Pembayaran : </th>
                                <th colspan="1" class="text-center"></th>
                            </tfoot>
                        </table>
                        <div class="d-flex justify-content-end mr-4 mt-3">
                            <p>Uang Pembayaran : </p>
                            <span><input type="text" class="ml-3" id="total"></span>
                        </div>
                        <div class="d-flex justify-content-end mr-4">
                            <p>Total Kembalian : </p>
                            <span><input type="text" readonly class="ml-3" id="kembalian"></span>
                        </div>
                        <div class="d-flex justify-content-end mr-4">
                            <button class="btn btn-secondary btn-md my-2 mr-2">Batal</button>
                            <button class="btn btn-primary btn-md my-2 bayar">Bayar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('page_js')
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs5/dt-1.13.1/datatables.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>
    <script src="{{ asset('js/pages/kasir.js') }}"></script>
@endpush
