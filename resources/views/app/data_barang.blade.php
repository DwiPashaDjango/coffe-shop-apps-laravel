@extends('layouts.app')

@section('title') Data Menu @endsection

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
            <h3 class="page__heading">Data Menu</h3>
        </div>
        <div id="err"></div>
        <div class="section-body">
            <div class="card">
                <div class="card-header">
                    @if (auth()->user()->role == 'admin')
                        <button class="btn btn-outline-primary btn-sm add"><i class="fas fa-plus"></i></button>
                        <a href="{{ url('d/barang/export') }}" class="btn btn-outline-success btn-sm ml-2 export"><i class="fas fa-file-excel"></i></a>
                    @endif
                    <a href="{{ url('d/barang/print') }}" class="btn btn-outline-danger btn-sm ml-2 print"><i class="fas fa-print"></i></a>
                </div>
                <div class="card-body p-1">
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered text-center" id="table-barang">
                            <thead>
                                <tr>
                                    <th class="text-center">Aksi</th>
                                    <th class="text-center">Kode Makanan / Minuman</th>
                                    <th class="text-center">Nama Makanan / Minuman</th>
                                    <th class="text-center">Kategori</th>
                                    <th class="text-center">Stock 1 Bulan</th>
                                    <th class="text-center">Harga Satuan</th>
                                    {{-- <th class="text-center">Aksi</th> --}}
                                </tr>
                            </thead>
                            <tbody>
                                
                            </tbody>
                            <tfoot class="text-center">
                                <tr>
                                    <th colspan="5" class="text-right">Total Pendapatan Setiap Bulan: </th>
                                    <th colspan="1" class="text-center"></th>
                                    {{-- <th colspan="1" class="text-center" id="tfoot">Rp.{{ number_format($bar->sum('harga') * $bar->sum('jumlah')) }}</th> --}}
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('modal')
<div class="modal fade" id="barangModal" tabindex="-1" aria-labelledby="barangModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="barangModalLabel"></h5>
      </div>
      <div class="modal-body">
          <form id="form-barang">
            <input type="hidden" id="id">
            <div class="row">
                <div class="col-12">
                    <div class="form-group">
                        <label for="">Nama Makanan / Minuman</label>
                        <input type="text" class="form-control" id="nm_barang">
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-group">
                        <label for="">Kategori</label>
                        <select class="form-control" id="kategori_id">
                            
                        </select>
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-group">
                        <label for="">Jumlah Stock Perhari</label>
                        <input type="text" class="form-control" id="jumlah">
                    </div>
                </div>
                <div class="col-12">
                     <div class="form-group">
                        <label for="">Harga Satuan</label>
                        <input type="text" class="form-control" id="harga">
                    </div>
                </div>
            </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary cancel" data-bs-dismiss="modal">Batal</button>
        <button type="button" class="btn btn-outline-primary store" id="tmb"></button>
      </div>
    </div>
  </div>
</div>
@endpush

@push('page_js')
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs5/dt-1.13.1/datatables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>
    <script src="{{ asset('js/pages/barang.js') }}"></script>
@endpush

