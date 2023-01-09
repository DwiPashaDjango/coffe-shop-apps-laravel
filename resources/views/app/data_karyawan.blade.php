@extends('layouts.app')

@section('title') Data Karyawan @endsection

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
  </style>
@endpush

@section('content')
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">Data karyawan</h3>
        </div>
        <div class="section-body">
            <div id="mes"></div>
            <div class="card">
                <div class="card-header">
                    <button class="btn btn-outline-primary btn-sm add"><i class="fas fa-plus"></i></button>
                    <button class="btn btn-outline-success btn-sm ml-2"><i class="fas fa-file-excel"></i></button>
                </div>
                <div class="card-body p-1">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover text-center" id="table-karyawan">
                            <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th class="text-center">Nama</th>
                                    <th class="text-center">Nik</th>
                                    <th class="text-center">Umur</th>
                                    <th class="text-center">No Hp</th>
                                    <th class="text-center">Alamat</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('modal')
<div class="modal fade" id="userModal" tabindex="-1" aria-labelledby="userModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="userModalLabel"></h5>
      </div>
      <div class="modal-body">
        <div id="err"></div>
        <form>
          <div class="row">
            <div class="col-6">
              <div class="form-group">
                <label for="">Nama</label>
                <input type="text" id="name" class="form-control">
              </div>
            </div>
            <div class="col-6">
              <div class="form-group">
                <label for="">Email</label>
                <input type="email" id="email" class="form-control">
              </div>
            </div>
            <div class="col-6">
              <div class="form-group">
                <label for="">Nik</label>
                <input type="nik" id="nik" class="form-control">
              </div>
            </div>
            <div class="col-6">
              <div class="form-group" id="pw">
                <label for="">Password</label>
                <input type="password" id="password" class="form-control">
              </div>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary batal"  data-bs-dismiss="modal">Batal</button>
        <button type="button" class="btn btn-outline-primary store" id="store">Tambah</button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="activateUser" tabindex="-1" aria-labelledby="activateUserLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="activateUserLabel"></h5>
      </div>
      <div class="modal-body">
        <div id="err"></div>
        <form>
          <input type="hidden" readonly readonly id="id">
          <div class="row">
            <div class="col-12">
              <div class="form-group">
                <label for="">Masukan Kata Sandi Baru Untuk Mengaktifkan User</label>
                <input type="password" id="password" class="form-control">
              </div>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-success activate">Aktifasi</button>
      </div>
    </div>
  </div>
</div>
@endpush

@push('page_js')
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs5/dt-1.13.1/datatables.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>
    <script src="{{ asset('js/pages/karyawan.js') }}"></script>
@endpush
