<?php

namespace App\Http\Controllers;
use App\Models\Medicine;
use Illuminate\Http\Request;

class MedicineController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $orderStock = $request->sort_stock ? 'stock' : 'name';
        $medicines = Medicine::where('name', 'LIKE', '%'. $request->search_obat. '%')->orderBy($orderStock, 'ASC')->simplePaginate(5)->appends($request->all());
        //all() = mengambil semua data
        //orderBy() = mengurutkan
        //asc = A-Z, 0-9
        //dec = Z-A, 9-0
        // operator =, >, <, >=, <=, !=, LIKE
        // '%' depan = kata belakang
        // '%' belakang = kata depan
        //kalau ambil semua data tapi ada proses filter sebelumnya, all nya ganti jadi get
        //simplePaginate() = memisahkan data dengan pagination, angka 5 menunjukkan jumlah data per halaman

        // fungsi where= mencari column namenya
        //compact() : mengirim data ke view (isinya sama dengan $)
        return view('medicine.index', compact ('medicines'));

    }

    /**
     * C : menampilkan
     */
    public function create()
    {
        //
        return view('medicine.create');
    }

    /**
     * C : create, menambahkan data ke db/eksekusi
     */
    public function store(Request $request)
    {
        // validasi data agar pengguna mengisi input form ga asal asalan dan wajib diisi
        $request->validate([
            'name' => 'required|max:100',
            'type' => 'required|min:3',
            'price' => 'required|numeric',
            'stock' => 'required|numeric',
        ], [
            'name.required' => 'Nama harus diisi',
            'type.required' => 'Tipe Obat harus diisi',
            'price.required' => 'Harga Obat harus diisi',
            'stock.required' => 'Stok Obat harus diisi',
            'name.max' => 'Nama Obat maksimal 100 Karakter',
            'type.min' => 'Tipe Obat minimal 3 Karakter',
            'price.numeric' => 'Harga Obat harus angka',
            'stock.numeric' => 'Stok Obat harus angka',
        ]);

        //
        Medicine::create(attributes:[
            'name' => $request->name,
            'type' => $request->type,
            'price' => $request->price,
            'stock' => $request->stock
        ]);
        return redirect()->back()->with('success', 'Data obat berhasil ditambahkan.');
    }

    /**
     * R : read, menampilkan data spesifik (data cuma 1)
     */
    public function show(string $id)
    {
        //
    }

    /**
     * U : update, menampilkan form untuk mengedit data
     */
    public function edit(string $id)
    {
       $medicine = Medicine::where('id', $id)->first();
       return view('medicine.edit', compact('medicine'));
    }

    /**
     * U : Update, mengupdate data ke db/eksekusi formulir edit
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => "required",
            'type' => "required",
            'price' => "required",

        ]);

        Medicine::where('id', $id)->update([
            'name' => $request->name,
            'type' => $request->type,
            'price' => $request->price,
        ]);
        return redirect()->route('obat.data')->with('success', 'Berhasil mengupdate data obat.');
    }

    public function updateStock(Request $request, $id){
        // untuk modal tanpa ajax, tidak suppoer validasi, jadi gunakan isset untuk pengecekan requirednya
        if(isset($request->stock) == FALSE){
            $dataSebelumnya = Medicine::where('id', $id)->first();
            // kembali dengan pesan, id sebelumnya, dan stock sebelumnya (stock awal)
            return redirect()->back()->with([
                'failed'=> 'Stok tidak boleh kosong!',
                'id' => $id,
                'stock' => $dataSebelumnya->stock,
            ]);
        }
        Medicine::where('id', $id)->update([
            'stock' => $request->stock,
        ]);

        return redirect()->back()->with('success', 'Berhasil mengupdate stok obat.');
    }

        // jika tidak kosong, langsung update stocknya

    /**
     * D : delete, menghapus data adri db
     */
    public function destroy($id)
    {
        $deleteData = Medicine::where('id', $id)->delete();
        if ($deleteData) {
            return redirect()->back()->with('success', 'Data obat berhasil di hapus');
        }else {
            return redirect()->back()->with('error', 'Data obat gagal di hapus');
        }
    }
}