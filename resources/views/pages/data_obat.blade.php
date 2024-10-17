@extends('layout.layout')
{{-- extends : import blade --}}

@section('content')
    <table class="table table-bordered table-stripped">
        <thead>
            <tr>
                <th>#</th>
                <th>Nama Obat</th>
                <th>Jenis</th>
                <th>Harga</th>
                <th>Stok</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>1. </td>
                <td>Paracetamol</td>
                <td>Tablet</td>
                <td>Rp5.000,00</td>
                <td>20</td>
            </tr>
        </tbody>
    </table>
@endsection