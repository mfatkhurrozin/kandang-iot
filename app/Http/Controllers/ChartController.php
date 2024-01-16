<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use illuminate\Support\Facades\Auth;
use App\Models\SensorData;
use Kreait\Firebase\Contract\Database;
use App\Http\Controllers\Controller;
use Carbon\Carbon;

class ChartController extends Controller
{
    public function __construct(Database $database)
    {
        $this->database = $database;
        $this->tablesensor = 'kandang/sensor';
        $this->tablerelay = 'kandang/relay';
        $this->tablelaporan = 'kandang/laporan';
    }
    
    public function indexChart()
    {
        $sensordata = $this->database->getReference($this->tablelaporan)->getValue();
        return view('layout.pemilik.chartdata', compact('sensordata'))->with([
            'users' => Auth::user(),
        ]);
    }
}
