<li class="nav-item">
    <a href="{{'home'}}" class="nav-link">
        <i class="nav-icon fas fa-tachometer-alt"></i>
      <p>
        Beranda
      </p>
    </a>
</li>

@if ($users->level ==1)
<li class="nav-header">KELOLA KANDANG</li>
<li class="nav-item">
  <a href="{{url('chart-data')}}" class="nav-link">
      <i class="nav-icon fas fa-chart-line"></i>
    <p>
      Chart
    </p>
  </a>
</li>

<li class="nav-item">
  <a href="{{url('laporan-data')}}" class="nav-link">
      <i class="nav-icon fas fa-table"></i>
    <p>
      Laporan
    </p>
  </a>
</li>

<li class="nav-item">
  <a href="{{url('user-data')}}" class="nav-link">
      <i class="nav-icon fas fa-chart-line"></i>
    <p>
      User
    </p>
  </a>
</li>

@elseif ($users->level==2)
<li class="nav-header">KELOLA KANDANG</li>
<li class="nav-item">
  <a href="{{'sensors'}}" class="nav-link">
      <i class="nav-icon fas fa-cloud-sun"></i>
    <p>
      Pemantauan
    </p>
  </a>
</li>
<li class="nav-item">
  <a href="{{'relays'}}" class="nav-link">
      <i class="nav-icon fas fa-tools"></i>
    <p>
      Pengendalian
    </p>
  </a>
</li>

@endif