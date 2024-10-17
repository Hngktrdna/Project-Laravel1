<?php

//use: import file
//mengimpor file Controller. UserController dan MedicineController diimpor untuk digunakan dalam rute.
use Illuminate\Support\Facades\Route; //perintah untuk mengimpor class Route dari Laravel yang digunakan untuk mendefinisikan rute aplikasi.
use App\Http\Controllers\LandingPageController; 
use App\Http\Controllers\MedicineController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PembelianController;

//1. get -> mengambil data/mengambilkan halaman
//2. post -> manambahkkan data ke db
//3, put/patch -> mengupdate data ke db
//4. delete -> menghapus data dari db
Route::get('/', [LandingPageController::class, 'index'])->name('landing_page');

//mengelola data obat
Route::get('/data-obat', [MedicineController::class, 'index'])->name('data_obat');

Route::prefix('/obat')->name('obat.')->group(function () {
    //fitur bagian fitur
    Route::get('/data', [MedicineController::class, 'index'])->name('data');
    Route::get('/tambah', [MedicineController::class, 'create'])->name('tambah');
    Route::post('/tambah', [MedicineController::class, 'store'])->name('tambah.formulir');
    Route::delete('/delete/{id}', [MedicineController::class, 'destroy'])->name('delete');
    Route::get('/edit/{id}', [MedicineController::class, 'edit'])->name('edit');
    Route::patch('/edit/{id}', [MedicineController::class, 'update'])->name('edit.formulir');
    Route::patch('/edit/stock/{id}', [MedicineController::class, 'updateStock'])->name('edit.stock');
});

//semuanya dimulai dengan awalan /akun. Jadi, setiap URL yang diakses akan dimulai dengan akun
//->name('akun.') memberi nama dasar pada rute, jadi setiap rute akan memiliki awalan nama akun. di depannya.
Route::prefix('/akun')->name('akun.')->group(function () {
    // /akun/data adalah rute untuk menampilkan data pengguna.
    // [UserController::class, 'index'] berarti ketika rute ini dipanggil, maka method index di UserController akan dijalankan.
    // Nama rute ini adalah akun.data
    Route::get('/data', [UserController::class, 'index'])->name('data');
    Route::get('/tambah', [UserController::class, 'create'])->name('tambah');
    Route::post('/tambah', [UserController::class, 'store'])->name('tambah.akun');
    // menampilkan form edit dan hapus berdasarkan ID pengguna.
    Route::get('/edit/{id}', [UserController::class, 'edit'])->name('edit');
    //PATCH : update only certain fields of a resource, rather than replacing the entire resource.
    Route::patch('/edit/{id}', [UserController::class, 'update'])->name('edit.akun');
    Route::delete('/hapus/{id}', [UserController::class, 'destroy'])->name('delete.akun');
});


Route::get('/pembelian', [PembelianController::class, 'index'])->name('pembelian.index');
Route::get('/pembelian/tambah', [PembelianController::class, 'create'])->name('pembelian.tambah');
Route::post('/pembelian', [PembelianController::class, 'store'])->name('pembelian.store');
Route::get('/pembelian/{id}', [PembelianController::class, 'show'])->name('pembelian.show');
Route::get('/pembelian/edit/{id}', [PembelianController::class, 'edit'])->name('pembelian.edit');
Route::patch('/pembelian/edit/{id}', [PembelianController::class, 'update'])->name('pembelian.update');
Route::delete('/pembelian/delete/{id}', [PembelianController::class, 'destroy'])->name('pembelian.delete');




// Index = Menampilkan semua data dari model terkait.
// Create = Menampilkan form untuk menambahkan data baru.
// store(Request $request) = Menyimpan data baru ke dalam database.
// edit($id) = Menampilkan form untuk mengedit data yang sudah ada.
// update(Request $request, $id) = Memperbarui data yang ada dalam database.
// destroy($id) = Menghapus data dari database.