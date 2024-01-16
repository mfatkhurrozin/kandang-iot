
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Aplikasi Pengelola Kandang</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('/') }}plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('/') }}dist/css/adminlte.min.css">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  <link href="<https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css>" rel="stylesheet" />
  <style>
    .container-sensor{
        width: auto;
        height: auto;
        margin: 50px auto;
        padding: 20px;
        font-family: Poppins, "Helvetica Neue", arial, sans-serif;
        display: flex;
        justify-content: center;
    }

    #popup-background {
      display: none;
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0, 0, 0, 0.5); /* Warna latar belakang buram dengan transparansi */
      z-index: 9998; /* Harus lebih rendah dari popup untuk menutupi latar belakang */
    }

    .popup {
      display: none;
      position: fixed;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      background: #152A38;
      padding: 20px;
      box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.5);
      z-index: 9999;
      width: 400px; /* Atur lebar sesuai kebutuhan */
      height: auto; /* Atur tinggi sesuai kebutuhan */
      color: white;
    }

    .form-edit {
      position: fixed;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      background: #152A38;
      padding: 20px;
      box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.5);
      z-index: 9999;
      width: 400px; /* Atur lebar sesuai kebutuhan */
      height: auto; /* Atur tinggi sesuai kebutuhan */
      color: white;
    }

    #edit-popup-background {
      display: none;
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0, 0, 0, 0.5); /* Warna latar belakang buram dengan transparansi */
      z-index: 9998; /* Harus lebih rendah dari popup untuk menutupi latar belakang */
    }


    .center-button {
      display: flex;
      justify-content: center;
      align-items: center;
     }

     .modal .close {
      display: none;
    }

    /* Atur warna garis tabel */
    .table-bordered, .table-bordered th, .table-bordered td {
      border: 1px solid #000; /* Warna hitam (#000) dengan ketebalan 1px */
    }

    .primary-btn {
        background-color: #FFD700; /* Warna latar belakang */
        color: black; /* Warna teks */
        outline: none; /* Menghilangkan outline */
        border: none; /* Menghilangkan border */
        display: inline-block;
        font-weight: 400;
        text-align: center;
        white-space: nowrap;
        vertical-align: middle;
        user-select: none;
        border: 1px solid transparent;
        padding: 0.375rem 0.75rem;
        font-size: 1rem;
        line-height: 1.5;
        border-radius: 0.25rem;
        transition: color 0.15s ease-in-out, background-color 0.15s ease-in-out, border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
    }


    @media (max-width: 768px) {
        .container-sensor {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
        }

        .card {
            width: 100%;
            margin: 1rem;
        }

        .popup {
          width: 80%; /* Atur ulang lebar pop-up */
          height: auto; /* Atur ulang tinggi pop-up agar menyesuaikan konten */
          top: 40%; /* Atur ulang posisi top */
          padding: 10px; /* Atur ulang padding */
          transform: translate(-50%, -40%);
        }
        .form-edit {
          width: 80%; /* Atur ulang lebar pop-up */
          height: auto; /* Atur ulang tinggi pop-up agar menyesuaikan konten */
          top: 40%; /* Atur ulang posisi top */
          padding: 10px; /* Atur ulang padding */
          transform: translate(-50%, -40%);
        }
    }

   

</style >
</head>
<body class="hold-transition sidebar-mini">
<!-- Site wrapper -->
<div class="wrapper">
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <li class="nav-item">
            <a class="nav-link" href="{{ url('logout')}}" role="button">
                <i class="nav-icon fas fa-sign-out-alt"></i> logout
            </a>
        </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4" style="background-color: #152A38;">
    <!-- Brand Logo -->
    <a href="{{'home'}}" class="brand-link">
      <img src="{{ asset('/') }}dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">Kandangku</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{ asset('/') }}dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">
            {{ $users->name}}
          </a>
        </div>
      </div>


      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          @include('layout.menu')
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper" style="background-color: #F9F5EB;">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>
                @yield('judul')
            </h1>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
        @yield('isi')
      <!-- /.card -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <footer class="main-footer">
    <strong>Copyright &copy; 2023 Kandangku</strong>
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="{{ asset('/') }}plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('/') }}plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="{{ asset('/') }}dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{ asset('/') }}dist/js/demo.js"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
</body>
</html>
