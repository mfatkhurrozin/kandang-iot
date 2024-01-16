<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use illuminate\Support\Facades\Auth;
use App\Models\SensorData;
use Kreait\Firebase\Contract\Database;
use App\Http\Controllers\Controller;
use PDF; //library pdf
use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;

class LaporanController extends Controller
{
    public function __construct(Database $database)
    {
        $this->database = $database;
        $this->tablesensor = 'kandang/sensor';
        $this->tablerelay = 'kandang/relay';
        $this->tablelaporan = 'kandang/laporan';
    }

    public function indexLaporan(Request $request)
    {
        $inputtanggalAwal = $request->input('tanggalAwal');
        $inputtanggalAkhir = $request->input('tanggalAkhir');    
        $sensordata = $this->database->getReference($this->tablelaporan)->getValue();
    
        if ($inputtanggalAwal && $inputtanggalAkhir) {
            $filteredData = array_filter($sensordata, function ($item) use ($inputtanggalAwal, $inputtanggalAkhir) {
                $itemDate = Carbon::parse($item['timestamp'])->format('Y-m-d');
                return ($itemDate >= $inputtanggalAwal && $itemDate <= $inputtanggalAkhir);
            });
        } else {
            $filteredData = $sensordata;
        }
    
        // Pagination
        $perPage = 10;
        $currentPage = request()->get('page', 1);
        $pagedData = array_slice($filteredData, ($currentPage - 1) * $perPage, $perPage);
        $sensordata = new LengthAwarePaginator($pagedData, count($filteredData), $perPage, $currentPage, [
            'path' => url()->current(),
        ]);
    
        return view('layout.pemilik.laporanpemilik', compact('sensordata'))->with([
            'users' => Auth::user(),
        ]);
    }
    

    public function cetakPDF(Request $request)
    {
        $inputtanggalAwal = $request->input('tanggalAwal');
        $inputtanggalAkhir = $request->input('tanggalAkhir');  
        $sensordata = $this->database->getReference($this->tablelaporan)->getValue();
    
        if ($inputtanggalAwal && $inputtanggalAkhir) {
            $filteredData = array_filter($sensordata, function ($item) use ($inputtanggalAwal, $inputtanggalAkhir) {
                $itemDate = Carbon::parse($item['timestamp'])->format('Y-m-d');
                return ($itemDate >= $inputtanggalAwal && $itemDate <= $inputtanggalAkhir);
            });
        } else {
            $filteredData = $sensordata;
        }

        $data = [
            'title' => 'Laporan Pemantauan Kondisi Kandang',
            'sensordata' => $filteredData,
            'tanggal_download' => Carbon::now()->format('d/m/Y H:i:s')
        ];

        $pdf = PDF::loadView('layout.pemilik.laporan_pdf', $data);
        return $pdf->download('laporan.pdf');
    }
    
}
