@extends('layout.main')

@section('judul', 'Tabel Data User')

@section('isi')
<div class="container mt-2">
    @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
    <button class="primary-btn" id="show-popup"> <i class="fas fa-plus"></i> Tambah User</button>
    <div id="popup-background"></div>
    <div id="popup-form" class="popup" style="color: white;">
        <h2 style="text-align: center; margin: 15px;">Form Tambah User</h2>
        <form method="POST" action="{{url('add-user')}}">
            @csrf
            <div class="form-group">
                <label for="name">Nama:</label>
                <input type="text" name="name" id="name" class="form-control">
                @error('name')
                    <div class="text-danger">{{ $message }}</div>
                 @enderror
            </div>
                
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" name="username" id="username" class="form-control">
                @error('username')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
    
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" name="email" id="email" class="form-control">
                @error('email')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
    
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" name="password" id="password" class="form-control">
                @error('password')
                    <div class="text-danger">{{ $message }}</div>
                @enderror    
            </div>
            
            <div class="form-group">
                <label for="level">Level:</label>
                <select name="level" id="level" class="form-control">
                    <option value="1">Pemilik</option>
                    <option value="2">Karyawan</option>
                </select>
            </div>            
    
            <div class="form-group center-button">
                <button type="submit" class="primary-btn">Tambah User</button>
                <button class="btn btn-secondary" style="margin: 10px;" id="cancel-button">Batal</button>
            </div>
        </form>
    </div>

    <div class="table-responsive">
    <table class="table table-bordered mt-3">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Username</th>
                <th>Email</th>
                <th>Role</th>
                <!-- Tambahkan kolom lain sesuai kebutuhan -->
                <th>Aksi</th> <!-- Kolom untuk aksi seperti Edit dan Hapus -->
            </tr>
        </thead>
        <tbody>
            @php
                $no = 1; // Inisialisasi nomor urut
            @endphp
            @foreach ($userdata as $user)
            <tr>
                <td>{{ $no++ }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->username }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->level }}</td>
                <!-- Tambahkan kolom lain sesuai kebutuhan -->
                <td>
                    <a href="{{ url('edit-user/'.$user->id) }}" class="btn btn-sm btn-primary"><i class="fas fa-edit"></i> Edit</a>
                    <button class="btn btn-sm btn-danger delete-user-button" data-user-id="{{ $user->id }}"><i class="fas fa-trash-alt"></i> Hapus</button>
                    <!-- Modal dialog konfirmasi penghapusan -->
                    <div id="delete-confirm-modal" class="modal">
                        <div class="modal-dialog">
                            <div class="modal-content" style=" background: #152A38; color:white; outline: none; border: none;">
                                <div class="modal-header" style="outline: none; border: none;">
                                    <h5 class="modal-title">Konfirmasi Hapus User</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body" style="outline: none; border: none;">
                                    <p>Anda yakin ingin menghapus user ini?</p>
                                </div>
                                <div class="modal-footer" style="outline: none; border: none;">
                                    <form action="{{ route('users.destroy', $user->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Hapus</button>
                                    </form>
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{ $userdata->links('pagination::bootstrap-4') }}
    </div>
</div>
<script>
    const showButton = document.getElementById("show-popup");
    const popupBackground = document.getElementById("popup-background");
    const popupForm = document.getElementById("popup-form");

    showButton.addEventListener("click", function() {
        popupBackground.style.display = "block";
        popupForm.style.display = "block";
    });

    // Fungsi untuk menyembunyikan pop-up
    function hidePopup() {
        popupBackground.style.display = "none";
        popupForm.style.display = "none";
    }

    // Tombol Batal
    const cancelButton = document.getElementById("cancel-button");
    if (cancelButton) {
        cancelButton.addEventListener("click", function(event) {
            event.preventDefault(); // Menghentikan default action dari tombol (form submission)
            hidePopup();
            
            // Hilangkan pesan kesalahan
            const errorMessages = document.querySelectorAll('.text-danger');
            errorMessages.forEach(function (errorMessage) {
                errorMessage.innerHTML = '';
            });
        });
    }

    // Jika terdapat pesan kesalahan, tampilkan pop-up form
    @if($errors->any())
        popupBackground.style.display = "block";
        popupForm.style.display = "block";
    @endif
</script>

<script>
    const deleteButtons = document.querySelectorAll(".delete-user-button");
    const deleteConfirmModal = document.getElementById("delete-confirm-modal");

    deleteButtons.forEach(function (button) {
        button.addEventListener("click", function() {
            const userId = button.getAttribute("data-user-id");
            showDeleteConfirmModal(userId);
        });
    });

    function showDeleteConfirmModal(userId) {
        const deleteForm = deleteConfirmModal.querySelector("form");
        deleteForm.action = "{{ route('users.destroy', '') }}" + "/" + userId;
        deleteConfirmModal.style.display = "block";
    }

    deleteConfirmModal.addEventListener("hidden.bs.modal", function() {
        const deleteForm = deleteConfirmModal.querySelector("form");
        deleteForm.action = ""; // Clear the action
    });
</script>
<script>
    // Fungsi untuk menutup modal konfirmasi delete
    function hideDeleteConfirmModal() {
        const deleteConfirmModal = document.getElementById("delete-confirm-modal");
        deleteConfirmModal.style.display = "none";
    }

    // Tambahkan event listener ke tombol "Batal" pada modal konfirmasi delete
    const cancelDeleteButton = document.querySelector("#delete-confirm-modal .btn-secondary");
    cancelDeleteButton.addEventListener("click", hideDeleteConfirmModal);
</script>

@endsection
