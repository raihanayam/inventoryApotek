<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('pages.User.index', compact('users'));
    }

    public function create()
    {
        return view('pages.User.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            "name" => "required|string|max:255",
            "email" => "required|email|unique:users,email",
            "password" => "required|min:6|confirmed",
            "role" => "required|in:admin,pengurus_gudang",
            "No_Wa" => "nullable|string|max:20",
        ], [
            "name.required" => "Nama wajib diisi.",
            "email.required" => "Email wajib diisi.",
            "email.unique" => "Email sudah digunakan.",
            "password.required" => "Password wajib diisi.",
            "password.confirmed" => "Konfirmasi password tidak cocok.",
            "password.min" => "Password minimal diisi dengan 6 karakter.",
            "role.required" => "Role wajib dipilih.",
        ]);

        User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
            'role' => $validatedData['role'],
            'No_Wa' => $validatedData['No_Wa'] ?? null,
        ]);

        return redirect('/user')->with('success', 'User berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('pages.User.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validatedData = $request->validate([
            "name" => "required|string|max:255",
            "email" => "required|email|unique:users,email," . $id,
            "password" => "nullable|min:6|confirmed",
            "role" => "required|in:admin,pengurus_gudang",
            "No_Wa" => "nullable|string|max:20",
        ], [
            "name.required" => "Nama wajib diisi.",
            "email.required" => "Email wajib diisi.",
            "email.unique" => "Email sudah digunakan.",
            "password.confirmed" => "Konfirmasi password tidak cocok.",
            "password.min" => "Password minimal diisi dengan 6 karakter.",
            "role.required" => "Role wajib dipilih.",
        ]);
        
        $user->update([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'role' => $validatedData['role'],
            'No_Wa' => $validatedData['No_Wa'] ?? null,
            'password' => $request->filled('password')
                ? Hash::make($validatedData['password'])
                : $user->password,
        ]);

        return redirect('/user')->with('success', 'User berhasil diperbarui.');
    }

    public function delete($id)
    {
        User::where('id', $id)->delete();
        return redirect('/user')->with('success', 'User berhasil dihapus.');
    }
}
