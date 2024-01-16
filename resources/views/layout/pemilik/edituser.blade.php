@extends('layout.main')

@section('judul')

@endsection

@section('isi')
    <div class="container mt-2">
        <div id="popup-background" style="display: block"></div>
        <div class="form-edit">
            <h2 style="text-align: center; margin: 15px;">Form Edit User</h2>
            <form method="POST" action="{{ route('users.update', $userdata->id) }}">
                @csrf
                @method('PUT')
    
                <div class="form-group">
                    <label for="name">Nama:</label>
                    <input type="text" name="name" id="name" class="form-control" value="{{ $userdata->name }}">
                    @error('name')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
    
                <div class="form-group">
                    <label for="username">Username:</label>
                    <input type="text" name="username" id="username" class="form-control" value="{{ $userdata->username }}">
                    @error('username')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
    
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" name="email" id="email" class="form-control" value="{{ $userdata->email }}">
                    @error('email')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
    
                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" name="password" id="password" class="form-control">
                    <a style="font-size: 12px;">(Biarkan kosong jika tidak ingin mengubah)</a>
                </div>
                <div class="form-group">
                    <label for="level">Level:</label>
                    <select name="level" id="level" class="form-control">
                        <option value="1" @if($userdata->level == 1) selected @endif>Pemilik</option>
                        <option value="2" @if($userdata->level == 2) selected @endif>Karyawan</option>
                    </select>
                </div>               
                <div class="form-group center-button">
                    <button type="submit" class="primary-btn">Simpan</button>
                    <button class="btn btn-secondary" style="margin: 10px;" id="cancel-button">Batal</button>
                </div>
            </form>
        </div>
    </div>
    <script>
        // Function to clear validation errors
        function clearValidationErrors() {
            var errorMessages = document.querySelectorAll('.text-danger');
            errorMessages.forEach(function (element) {
                element.innerHTML = '';
            });
        }

        // Add an event listener to the background overlay to close the form when clicking outside
        document.getElementById("popup-background").addEventListener("click", function(event) {
            if (event.target === this) {
                clearValidationErrors(); // Clear validation errors
                window.history.back();
            }
        });

        // Add an event listener to the "Batal" button to close the form and clear validation errors
        document.getElementById("cancel-button").addEventListener("click", function(event) {
            clearValidationErrors(); // Clear validation errors
            window.history.back();
        });
    </script>
@endsection
