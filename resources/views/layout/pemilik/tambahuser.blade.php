@extends('layout.main')

@section('judul')
    Tabel Data User
    
@endsection

@section('isi')
<div class="container mt-2">
    <form method="POST" action="{{url('add-user')}}">
        @csrf
        <div class="form-group">
            <label for="name">Nama:</label>
            <input type="text" name="name" id="name" class="form-control">
        </div>

        <div class="form-group">
            <label for="username">Username:</label>
            <input type="text" name="username" id="username" class="form-control">
        </div>

        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" name="email" id="email" class="form-control">
        </div>

        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" name="password" id="password" class="form-control">
        </div>

        <div class="form-group">
            <label for="level">Level:</label>
            <input type="text" name="level" id="level" class="form-control">
        </div>

        
        <button type="submit" class="btn btn-primary">Tambah Pengguna</button>
    </form>

</div>

@endsection
