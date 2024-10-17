<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pembelian;
use App\Models\Medicine;


class PembelianController extends Controller
{
    public function index()
{
    // Retrieve paginated records from the pembelian table
    $pembelian = Pembelian::paginate(50); // Adjust the number as needed
    
    // Pass the retrieved data to the view
    return view('pembelian.index', compact('pembelian'));
}

    /**
     * C : menampilkan
     */
    public function create()
    {
        $medicines = Medicine::paginate(50); // Fetch medicines from the database
        $pembelian = Pembelian::all(); // Fetch pembelian records from the database
        return view('pembelian.create', compact('medicines', 'pembelian')); // Pass both variables to the view
    }




    /**
     * C : create, menambahkan data ke db/eksekusi
     */
    public function store(Request $request)
    {
        // Validate the input
        $request->validate([
            'medicine_id' => 'required|exists:medicines,id'
        ]);

        // Find the selected medicine by its ID
        $medicine = Medicine::find($request->medicine_id);

        // Calculate total
        $jumlah = 1; // You can change this based on your requirement
        $harga = $medicine->price;
        $total = $jumlah * $harga;

        // Check if the purchase entry already exists
        $existingPembelian = Pembelian::where('medicine_id', $request->medicine_id)->first();

        if ($existingPembelian) {
            // Update the existing record
            $existingPembelian->jumlah += $jumlah; // Increase the quantity
            $existingPembelian->total += $total; // Update the total
            $existingPembelian->save(); // Save the changes
        } else {
            // Create a new purchase entry (Pembelian)
            Pembelian::create([
                'medicine_id' => $request->medicine_id,
                'nama_barang' => $medicine->name,
                'jumlah' => $jumlah,
                'harga' => $harga,
                'total' => $total,
            ]);
        }

        // Return the same page with a success message
        return redirect()->back()->with('success', 'Pembelian berhasil ditambahkan.');
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
        //    
    }

    /**
     * U : Update, mengupdate data ke db/eksekusi formulir edit
     */
    public function update(Request $request, $id)
{
    // Validate the input
    $request->validate([
        'jumlah' => 'required|integer|min:1',
    ]);

    // Find the existing Pembelian record
    $pembelian = Pembelian::findOrFail($id);

    // Update the jumlah
    $pembelian->jumlah = $request->jumlah;
    $pembelian->total = $pembelian->harga * $request->jumlah; // Update total based on new quantity
    $pembelian->save(); // Save the changes

    // Redirect back with a success message
    return redirect()->route('pembelian.index')->with('success', 'Jumlah berhasil diperbarui.');
}

    public function updateStock(Request $request, $id){
        // 
    }

        // jika tidak kosong, langsung update stocknya

    /**
     * D : delete, menghapus data dari db
     */
    public function destroy($id)
    {
        // Find the purchase by ID and delete it
    $pembelian = Pembelian::findOrFail($id);
    $pembelian->delete();

    // Redirect back with a success message
    return redirect()->route('pembelian.index')->with('success', 'Pembelian berhasil dihapus.');
    }
}