<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;

class UserController extends Controller
{
    public function index()
    {
        $userdata = User::orderBy('id')->paginate(5);
        return view('layout.pemilik.user', compact('userdata'))->with([
            'users' => Auth::user(),
        ]);
    }

    public function create()
    {
        return view('layout.pemilik.tambahuser')->with([
            'users' => Auth::user(),
        ]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'level' => 'required|string|max:2',
        ], [
            'name.required' => 'Nama harus diisi.',
            'username.required' => 'Username harus diisi.',
            'email.required' => 'Email harus diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah digunakan.',
            'password.required' => 'Password harus diisi.',
            'password.min' => 'Password minimal harus 6 karakter.',
            'level.required' => 'Level harus diisi.',
            'level.max' => 'Level maksimal 2 karakter.',
        ]);

        $validatedData['password'] = Hash::make($validatedData['password']);
        User::create($validatedData);
        if ($validatedData) {
            return redirect('user-data')->with('success', 'Pengguna berhasil ditambahkan');
        } 
        else {
            return redirect()->back()->withErrors($validatedData)->withInput();
        }
    }


    public function edit($id)
    {
        $userdata = User::findOrFail($id);
        $user = User::find($id);
        return view('layout.pemilik.edituser', compact('userdata'))->with([
            'users' => Auth::user(),
        ]);
    }

    public function update(Request $request, $id)
    {
        $user = User::find($id);
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'nullable|min:6',
            'level' => 'required|string|max:2',
        ], [
            'name.required' => 'Nama harus diisi.',
            'username.required' => 'Username harus diisi.',
            'email.required' => 'Email harus diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah digunakan.',
            'password.min' => 'Password minimal harus 6 karakter.',
            'level.required' => 'Level harus diisi.',
            'level.max' => 'Level maksimal 2 karakter.',
        ]);

        if ($request->has('password')) {
            $validatedData['password'] = Hash::make($validatedData['password']);
        } else {
            unset($validatedData['password']);
        }
        $user->update($validatedData);

        if ($validatedData) {
            // Validation passed, proceed with updating the user
            return redirect('user-data')->with('success', 'Data pengguna berhasil diperbarui');
        } else {
            // Validation failed, redirect back with errors
            return redirect()->back()->withErrors($validatedData)->withInput();
        }
    }

    public function delete($id)
    {
        $user = User::find($id);
        if (!$user) {
            return redirect()->back()->with('error', 'Pengguna tidak ditemukan.');
        }
        $user->delete();
        return redirect('user-data')->with('success', 'Pengguna berhasil dihapus.');
    }

}
