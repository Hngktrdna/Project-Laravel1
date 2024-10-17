<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

// Index = Menampilkan semua data dari model terkait.
// Create = Menampilkan form untuk menambahkan data baru.
// store(Request $request) = Menyimpan data baru ke dalam database.
// edit($id) = Menampilkan form untuk mengedit data yang sudah ada.
// update(Request $request, $id) = Memperbarui data yang ada dalam database.
// destroy($id) = Menghapus data dari database.
class UserController extends Controller
{
    // 1. Show all users
    //Mengambil semua data pengguna dari model User menggunakan User::all() dan mengirimkannya ke view akun.akun dengan menggunakan fungsi compact().
    
    // Compact() = membuat array dari variabel yang telah didefinisikan sebelumnya. berguna ketika ingin mengirim beberapa variabel ke tampilan (view) dari controller.
    public function index()
    {
        $users = User::all();
        return view('akun.akun', compact('users'));
    }

    // 2. Show the form to create a new user
    public function create()
    {
        return view('akun.create');
    }

    // 3. Store the new user data to the database
    //menyimpan data pengguna baru ke dalam database.
    public function store(Request $request)
    {
        $request->validate([
            'name' => "required",
            'email' => "required",
            'password' => "required",
            'role' => "required",
        ]);

        ////Menggunakan User::create() untuk menyimpan data pengguna baru.
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'role' => $request->role
        ]);

        //Setelah berhasil, akan mengalihkan kembali ke route akun.data dengan pesan sukses.
        return redirect()->route('akun.data')->with('success', 'User berhasil ditambah.');

    }

    // 4. Show the form to edit a user
    //Menampilkan form untuk mengedit data pengguna yang ada.
    public function edit($id)
    {
        //Mencari pengguna berdasarkan id menggunakan User::find($id) dan mengembalikan view akun.edit dengan data pengguna yang ditemukan.
        $user = User::find($id);
        return view('akun.edit', compact('user'));
    }

    // 5. Update the user data in the database
    //memperbarui data pengguna dalam database.
    public function update(Request $request, $id)
    {
        //Mencari pengguna berdasarkan id.
        $user = User::find($id);

        //Melakukan validasi pada data yang diterima.
        $request->validate([
            'name' => "required",
            'email' => "required",
            'password' => "required",
            'role' => "required",
        ]);

        //Menggunakan $user->update() untuk memperbarui data pengguna.
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'role' => $request->role
        ]);

        return redirect()->route('akun.data')->with('success', 'User berhasil diupdate.');
    }

    // 6. Delete a user from the database
    public function destroy($id)
    {
        // Temukan akun berdasarkan ID
        // Mencari pengguna berdasarkan id menggunakan User::findOrFail($id), yang akan menghasilkan error jika pengguna tidak ditemukan.
        $user = User::findOrFail($id);

        // Hapus akun
        $user->delete();

        // Redirect ke halaman data pengguna dengan pesan sukses
        return redirect()->route('akun.data')->with('success', 'Akun berhasil dihapus.');
    }

}
