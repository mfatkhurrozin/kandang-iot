@extends('layout.main')

@section('judul')
    Halaman Beranda
    
@endsection

@section('isi')
<div class="card">
    <div class="card-header">
      <h3 class="card-title">Selamat Datang, {{ $users->name}}</h3>

      <div class="card-tools">
        <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
          <i class="fas fa-minus"></i>
        </button>
        <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
          <i class="fas fa-times"></i>
        </button>
      </div>
    </div>
    <div class="card-body">
      <div class="alert alert-success">
        <h3 class="text-center">Selamat Datang di Beranda Kandang Ayam Petelur!</h3>
        <p class="text-justify">
           Ini adalah tempat di mana Anda dapat mengelola kandang ayam petelur Anda dengan cara yang cerdas dan efisien. Dengan alat canggih dan informasi real-time, kami memudahkan Anda dalam memantau dan mengelola kandang ayam petelur Anda.
        </p>
        <p class="text-center">
            <i class="fas fa-egg" style="font-size: 48px;"></i>
        </p>
    </div>
    </div>
    <!-- /.card-body -->
    <div class="card-footer">
  </div>
    
@endsection