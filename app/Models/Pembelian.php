<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembelian extends Model
{
    use HasFactory;

    // Specify the table name if it's not the plural of the model
    protected $table = 'pembelian';
    
    // Define the columns you want to allow for mass assignment
    protected $fillable = ['medicine_id', 'nama_barang', 'harga', 'jumlah', 'total']; // Include medicine_id
}
