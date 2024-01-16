@extends('layout.main')

@section('judul')
    Halaman Pengendali
    
@endsection

@section('isi')
<div id="sensor-data">
    @if (session('status'))
        <h4 class="alert alert-warning mb-2">{{session('status')}}</h4>
    @endif
    <div class="container" style ="text-align: center; padding-top: 20px">
        <h1 class="h2">PENGENDALIAN KONDISI LINGKUNGAN KANDANG</h1>
        <p class="h4">ini adalah halaman untuk pengendalian kondisi lingkungan kandang ayam</p>
    </div>
    @forelse ($sensors as $key => $sensor)
    @empty
    @endforelse
    @forelse ($relays as $key => $relay)
    <div class="container-sensor">
            <div class="card text-white bg-primary mb-3 align-items-center" style="width: 20rem; text-align: center; margin: 0.5rem;">
                <div class="card-header" style="padding: 1em; font-size: 20px; width: 100%;">
                    PEMANAS <br>
                <span style="font-size: 10px;">Pengendali Suhu dan Kelembaban</span></div>
                <div class="card-body">
                    <h5 class="card-title" style="font-size:50px; margin-top:3rem;">
                        <span id="status">
                            @if ($relay['relay1'] === '0' || $sensor['temperature'] < 18)
                                ON
                            @else
                                OFF
                            @endif
                        </span>
                    </h5>
                <p class="card-text"></p>
                </div>
            </div>
            <div class="card text-white bg-secondary mb-3 align-items-center" style="width: 20rem; text-align: center; margin: 0.5rem;">
                <div class="card-header" style="padding: 1em; font-size: 20px; width: 100%;">
                    PENDINGIN <br>
                <span style="font-size: 10px;">Pengendali Suhu dan Kelembaban</span></div>
                <div class="card-body">
                    <h5 class="card-title" style="font-size:50px; margin-top:3rem;">
                        <span id="status">
                            @if ($relay['relay1'] === '0' || $sensor['temperature'] > 30)
                                ON
                            @else
                                OFF
                            @endif
                        </span>
                    </h5>
                <p class="card-text"></p>
                </div>
            </div>
            <div class="card text-white bg-success mb-3 align-items-center" style="width: 20rem; text-align: center; margin: 0.5rem;">
                <div class="card-header" style="padding: 1em; font-size: 20px; width: 100%;">
                    LAMPU <br>
                <span style="font-size: 10px;">Pengendali Intensitas Cahaya</span></div>
                <div class="card-body">
                    <h5 class="card-title" style="font-size:50px; margin-top:3rem;">
                        <span id="status">
                            @if ($relay['relay1'] === '0' || $sensor['lux'] < 30)
                                ON
                            @else
                                OFF
                            @endif
                        </span>
                    </h5>
                <p class="card-text"></p>
                </div>
            </div>
            <div class="card text-white bg-danger mb-3 align-items-center" style="width: 20rem; text-align: center; margin: 0.5rem;">
                <div class="card-header" style="padding: 1em; font-size: 20px; width: 100%;">
                    KIPAS <br>
                <span style="font-size: 10px;">Pengendali Kualitas Udara</span></div>
                <div class="card-body">
                    <h5 class="card-title" style="font-size:50px; margin-top:3rem;">
                        <span id="status">
                            @if ($relay['relay1'] === '0' || $sensor['airquality'] > 25)
                                ON
                            @else
                                OFF
                            @endif
                        </span>
                    </h5>
                <p class="card-text"></p>
                </div>
            </div>
            
        </div>
        <div class="container" style="text-align: center;">
            <a href="{{url('edit-relay/'.$key)}}" class="btn btn-primary btn-lg" tabindex="-1" role="button" aria-disabled="true">
                <i class="fas fa-cogs" style="margin-right: 5px;"></i> Ubah Status
            </a>
        </div>
        @empty
        @endforelse
</div>
@endsection