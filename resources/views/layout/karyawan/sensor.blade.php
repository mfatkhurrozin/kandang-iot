@extends('layout.main')

@section('judul')
    Halaman Pemantauan
    
@endsection

@section('isi')
<div class="reloadku" id="sensor-data">
    <div class="container" style ="text-align: center; padding-top: 20px">
        <h1 class="h2">PEMANTAUAN KONDISI LINGKUNGAN KANDANG</h1>
        <p class="h4">ini adalah website untuk pemantauan kondisi lingkungan kandang ayam</p>
    </div>
    <div class="container-sensor">
        @forelse ($sensors as $key => $sensor)
            {{-- <div class="card text-white bg-primary mb-3 align-items-center" style="width: 20rem; text-align: center; margin: 0.5rem;"> --}}
            <div class="card text-white mb-3 align-items-center" style="width: 20rem; text-align: center; margin: 0.5rem;
                @if($sensor['temperature'] < 18)
                    background-color: #dc3545; /* Blue for low temperature */
                @elseif($sensor['temperature'] > 30)
                    background-color: #dc3545; /* Red for high temperature */
                @else
                    background-color: #28a745; /* Green for normal temperature */
                @endif
            ">
                <div class="card-header" style="padding: 1em; font-size: 20px; width: 100%;">SUHU</div>
                <div class="card-body">
                    <p class="card-text">
                        @if($sensor['temperature'] < 18)
                            <span style="color: red; background-color: yellow; padding: 10px;">TERLALU RENDAH</span>
                        @elseif($sensor['temperature'] > 30)
                            <span style="color: red; background-color: yellow; padding: 10px;">TERLALU TINGGI</span>
                        @endif
                    </p>
                <h5 class="card-title" style="font-size:50px; margin-top:2rem;" id="temperature-value">{{$sensor['temperature']}}°C</h5>
                </div>
            </div>
            <div class="card text-white mb-3 align-items-center" style="width: 20rem; text-align: center; margin: 0.5rem;
                @if($sensor['humidity'] < 50)
                    background-color: #dc3545; /* Blue for low temperature */
                @elseif($sensor['humidity'] > 70)
                    background-color: #dc3545; /* Red for high temperature */
                @else
                    background-color: #28a745; /* Green for normal temperature */
                @endif
            ">
                <div class="card-header" style="padding: 1em; font-size: 20px; width: 100%;">KELEMBABAN</div>
                <div class="card-body">
                    <p class="card-text">
                        @if($sensor['humidity'] < 50)
                            <span style="color: red; background-color: yellow; padding: 10px;">TERLALU RENDAH</span>
                        @elseif($sensor['humidity'] > 70)
                            <span style="color: red; background-color: yellow; padding: 10px;">TERLALU TINGGI</span>
                        @endif
                    </p>
                <h5 class="card-title" style="font-size:50px; margin-top:2rem;" id="humidity-value">{{$sensor['humidity']}} %</h5>
                </div>
            </div>
            <div class="card text-white mb-3 align-items-center" style="width: 20rem; text-align: center; margin: 0.5rem;
                @if($sensor['lux'] < 20)
                    background-color: #dc3545; /* Blue for low temperature */
                @elseif($sensor['lux'] > 50)
                    background-color: #dc3545; /* Red for high temperature */
                @else
                    background-color: #28a745; /* Green for normal temperature */
                @endif
            ">
                <div class="card-header" style="padding: 1em; font-size: 20px; width: 100%;">INTENSITAS CAHAYA</div>
                <div class="card-body">
                    <p class="card-text">
                        @if($sensor['lux'] < 20)
                            <span style="color: red; background-color: yellow; padding: 10px;">TERLALU RENDAH</span>
                        @elseif($sensor['lux'] > 50)
                            <span style="color: red; background-color: yellow; padding: 10px;">TERLALU TINGGI</span>
                        @endif
                    </p>
                <h5 class="card-title" style="font-size:50px; margin-top:2rem;" id="lux-value">{{number_format($sensor['lux'],2)}} LX</h5>
                </div>
            </div>
            <div class="card text-white mb-3 align-items-center" style="width: 20rem; text-align: center; margin: 0.5rem;
                @if($sensor['airquality'] > 25)
                    background-color: #dc3545; /* Blue for low temperature */
                @else
                    background-color: #28a745; /* Green for normal temperature */
                @endif
            ">
                <div class="card-header" style="padding: 1em; font-size: 20px; width: 100%;">KUALITAS UDARA</div>
                <div class="card-body">
                    <p class="card-text">
                        @if($sensor['airquality'] > 25)
                            <span style="color: red; background-color: yellow; padding: 10px;">TERLALU TINGGI</span>
                        @endif
                    </p>
                <h5 class="card-title" style="font-size:50px; margin-top:2rem;" id="airquality-value"> {{number_format($sensor['airquality'],2)}} PPM</h5>
                </div>
            </div>
            <div>
                <form action="{{url('add-sensor') }}" method="POST" id="sensor-form" style="display: none;">
                    @csrf
                    <input type="text" name="suhu" value="{{$sensor['temperature']}}">
                    <input type="text" name="kelembaban" value="{{$sensor['humidity']}}">
                    <input type="text" name="cahaya" value="{{number_format($sensor['lux'],2)}}">
                    <input type="text" name="udara" value="{{number_format($sensor['airquality'],2)}}">
                    <button type="submit"></button>
                </form>
            </div>        
          @empty
          @endforelse

    </div>
    <div class="container" style ="display: flex; margin-top: -20px;">
        <div style="margin-right: 20px; align-items-center;">
            <p><b>Informasi Kondisi Normal Kandang:</b><br>
                Suhu: 18°C - 30°C<br>
                Kelembaban: 50% - 70%<br>
                Intensitas Cahaya: 20 Lux - 50 Lux<br>
                Kualitas Udara (Gas Amonia): 0 - 25 PPM
    
            </p>
        </div>
        <div style="align-items-center;">
            <p><b></b><br>
                °C adalah satuan suhu<br>
                % adalah satuan Kelembaban<br>
                LX (Lux) adalah satuan Intensitas Cahaya<br>
                PPM (Part per million) adalah satuan Gas Amonia
            </p>
        </div>
    </div>
    <div class="container-sensor">
        @forelse ($relays as $key => $relay)
            <div class="container" style="text-align: center;">
                <a href="{{url('edit-relay/'.$key)}}" class="btn btn-primary btn-lg" tabindex="-1" role="button" aria-disabled="true">
                    <i class="fas fa-cogs" style="margin-right: 5px;"></i> Ubah Status
                </a>
            </div>
            @empty
        @endforelse
    </div>
</div>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    // Fungsi untuk melakukan reload konten setiap 10 detik
    function autoReloadContent() {
        $('.reloadku').load(location.href + ' .reloadku');
    }

    // Jalankan fungsi autoReloadContent setiap 10 detik
    setInterval(autoReloadContent, 10000); // 10000 milliseconds = 10 detik
});
</script>

<script>
    // Function to automatically submit the form
    function autoSubmitForm() {
        document.getElementById('sensor-form').submit();
    }

    // Set up a timer to auto-submit the form every 20 seconds (20000 milliseconds)
    setInterval(autoSubmitForm, 3600000);
</script>
@endsection