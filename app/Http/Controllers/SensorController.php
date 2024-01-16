<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Kreait\Firebase\Contract\Database;
use illuminate\Support\Facades\Auth;
use App\Models\SensorData;

class SensorController extends Controller
{
    public function __construct(Database $database)
    {
        $this->database = $database;
        $this->tablesensor = 'kandang/sensor';
        $this->tablerelay = 'kandang/relay';
    }

    public function index()
    {
        $sensors = $this->database->getReference($this->tablesensor)->getValue();

        $relays = $this->database->getReference($this->tablerelay)->getValue();
        return view('layout.karyawan.sensor', compact('sensors','relays'))->with([
            'users' => Auth::user(),
        ]);
    }


    public function store(Request $request)
{
    $data = $request->validate([
        'suhu' => 'required|numeric',
        'kelembaban' => 'required|numeric',
        'cahaya' => 'required|numeric',
        'udara' => 'required|numeric',
        // 'tanggal' => 'required|date',
    ]);

    SensorData::create($data);

    return redirect('sensors');
}

}

