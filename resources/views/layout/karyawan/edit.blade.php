@extends('layout.main')

@section('judul')
    Halaman Pengendalian
@endsection

@section('isi')
<form action="{{url('update-relay/'.$key)}}" method="POST">
    @csrf
    @method('PUT')
    <div class="container-sensor">
        <div class="card text-black mb-3 " style="width: 16rem; margin: 0.5rem;">
            <div class="card-header bg-primary" style="padding: 1em; font-size: 20px; text-align: center; color: white;">
                PEMANAS <br>
                <span style="font-size: 10px;">Pengendali Suhu dan Kelembaban</span></div>
            <div class="card-body" style="background-color: white;">
                <div class="form-check form-switch" style="font-size: 40px;">
                    <input class="form-check-input" type="checkbox" id="statusSwitch1" name="relay" value="{{$editdata['relay1']}}" <?php if ($editdata['relay1'] === '0') { echo 'checked'; } ?> onchange="ubahstatus1(this.checked)">
                    <label class="form-check-label" for="statusSwitch"><span id="status1" >{{$editdata['relay1'] === '0' ? 'ON' : 'OFF'}}</span></label>
                    <input type="hidden" name="relay1" value="{{$editdata['relay1']}}">
                </div>
            </div>
        </div>

        <div class="card text-black mb-3" style="width: 16rem; margin: 0.5rem;">
            <div class="card-header bg-secondary" style="padding: 1em; font-size: 20px; text-align: center; color: white;">
                PENDINGIN <br>
                <span style="font-size: 10px;">Pengendali Suhu dan Kelembaban</span></div>
            <div class="card-body" style="background-color: white;">
                <div class="form-check form-switch" style="font-size: 40px">
                    <input class="form-check-input" type="checkbox" id="statusSwitch2" name="relay" value="{{$editdata['relay2']}}" <?php if ($editdata['relay2'] === '0') { echo 'checked'; } ?> onchange="ubahstatus2(this.checked)">
                    <label class="form-check-label" for="statusSwitch"><span id="status2" >{{$editdata['relay2'] === '0' ? 'ON' : 'OFF'}}</span></label>
                    <input type="hidden" name="relay2" value="{{$editdata['relay2']}}">
                </div>
            </div>
        </div>

        <div class="card text-black mb-3" style="width: 16rem; margin: 0.5rem;">
            <div class="card-header bg-success" style="padding: 1em; font-size: 20px; text-align: center; color: white;">
                LAMPU <br>
                <span style="font-size: 10px;">Pengendali Intensitas Cahaya</span></div>
            <div class="card-body" style="background-color: white;">
                <div class="form-check form-switch" style="font-size: 40px">
                    <input class="form-check-input" type="checkbox" id="statusSwitch3" name="relay" value="{{$editdata['relay3']}}" <?php if ($editdata['relay3'] === '0') { echo 'checked'; } ?> onchange="ubahstatus3(this.checked)">
                    <label class="form-check-label" for="statusSwitch"><span id="status3" >{{$editdata['relay3'] === '0' ? 'ON' : 'OFF'}}</span></label>
                    <input type="hidden" name="relay3" value="{{$editdata['relay3']}}">
                </div>
            </div>
        </div>

        <div class="card text-black mb-3" style="width: 16rem; margin: 0.5rem;">
            <div class="card-header bg-danger" style="padding: 1em; font-size: 20px; text-align: center; color: white;">
                KIPAS <br>
                <span style="font-size: 10px;">Pengendali Kualitas Udara</span></div>
            <div class="card-body" style="background-color: white;">
                <div class="form-check form-switch" style="font-size: 40px">
                    <input class="form-check-input" type="checkbox" id="statusSwitch4" name="relay" value="{{$editdata['relay4']}}" <?php if ($editdata['relay4'] === '0') { echo 'checked'; } ?> onchange="ubahstatus4(this.checked)">
                    <label class="form-check-label" for="statusSwitch"><span id="status4" >{{$editdata['relay4'] === '0' ? 'ON' : 'OFF'}}</span></label>
                    <input type="hidden" name="relay4" value="{{$editdata['relay4']}}">
                </div>
            </div>
        </div>
    </div>
    <div class="container-sensor">
        <button type="submit" class="btn btn-success" style="margin-right: 10px;">
            <i class="fas fa-save" style="margin-right: 5px;"></i> Simpan
        </button>
        <a href="{{'relays'}}" class="btn btn-secondary">
            <i class="fas fa-times" style="margin-right: 5px;"></i> Batal
        </a>
    </div>
</form>
{{-- <a href="{{url('relays')}}" class="btn btn-sm btn-danger float-end">Back</a>           --}}

<script type="text/javascript">
    function ubahstatus1(value) {
        const statusElement = document.getElementById('status1');
        statusElement.innerHTML = value === '1' ? 'ON' : 'OFF';
    }

    function ubahstatus2(value) {
        const statusElement = document.getElementById('status2');
        statusElement.innerHTML = value === '1' ? 'ON' : 'OFF';
    }

    function ubahstatus3(value) {
        const statusElement = document.getElementById('status3');
        statusElement.innerHTML = value === '1' ? 'ON' : 'OFF';
    }

    function ubahstatus4(value) {
        const statusElement = document.getElementById('status4');
        statusElement.innerHTML = value === '1' ? 'ON' : 'OFF';
    }
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
<script>
    function toggleRelayValue(checkbox, relayName, statusId) {
        const relayInput = document.querySelector(`input[name="${relayName}"]`);
        relayInput.value = checkbox.checked ? '0' : '1';

        // Mengubah status hanya jika tombol relay yang diubah
        const statusElement = document.getElementById(statusId);
        statusElement.innerHTML = checkbox.checked ? 'ON' : 'OFF';
    }

    function setupToggleListener(checkboxId, relayName, statusId) {
        const statusSwitch = document.getElementById(checkboxId);
        statusSwitch.addEventListener('change', function () {
            toggleRelayValue(this, relayName, statusId);
        });
    }

    // Mendengarkan perubahan untuk setiap tombol
    setupToggleListener('statusSwitch1', 'relay1', 'status1');
    setupToggleListener('statusSwitch2', 'relay2', 'status2');
    setupToggleListener('statusSwitch3', 'relay3', 'status3');
    setupToggleListener('statusSwitch4', 'relay4', 'status4');
</script>

@endsection