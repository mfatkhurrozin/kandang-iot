<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Kreait\Firebase\Contract\Database;
use illuminate\Support\Facades\Auth;

class RelayController extends Controller
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
    
        return view('layout.karyawan.relay', compact('relays', 'sensors'))->with([
            'users' => Auth::user(),
        ]);
    }
    

    public function edit($id)
    {
        $key = $id;
        $editdata = $this->database->getReference($this->tablerelay)->getChild($key)->getValue();
        if ($editdata) {
            return view('layout.karyawan.edit', compact('editdata','key'))->with([
                'users' => Auth::user(),
            ]);
        } else {
            return redirect('relays');
        }
    }

    public function update(Request $request, $id)
    {
        $key = $id;
        $updateData = [
            'relay1' => $request->relay1,
            'relay2' => $request->relay2,
            'relay3' => $request->relay3,
            'relay4' => $request->relay4,
        ];
        $res_updated = $this->database->getReference($this->tablerelay.'/'.$key)->update($updateData);
        if ($res_updated) {
            return redirect('relays')->with('status','Status Alat Telah Berubah');
        } else {
            return redirect('relays')->with('status','Status Tidak Berubah');
        }
    }
}