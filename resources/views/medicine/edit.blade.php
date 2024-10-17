@extends('layout.layout')

@section('content')
<h1 class="text-center mt-4">Halaman Edit Obat</h1>
<form action="{{ route('obat.edit.formulir', $medicine['id']) }}" method="POST" class="card-p-5">
    {{-- 1. Tag <form> attr action & method
            Method:
            - GET : form tujuan mencari data (search)
            - POST : form tujuan menambahkan/menghapus/mengubah
            Action : route memproses data
            - Arahkan route yang akan menangani proses data ke db-nya
            - Jika GET : arahkan ke route yang sama dengan route yang menampilkan blade ini
            - Jika POST : arahkan ke route baru dengan httpmethod sesuai tujuan POST (tambah), PATCH (ubah), DELETE (hapus)
          2. Jika form method POST : @csrf(token untuk mengirim data menggunakan method POST)
          3. Input attr name (isi disamakan dengan column di migration)
          4. Button/input type submit
    --}}
    @csrf
    @method('PATCH')
    @if (Session::get('success'))
        <div class="alert alert-success">
            {{ Session::get('success')}}
        </div>
    @endif
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $errors)
                    <li>{{ $errors }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="mb-3 row">
        <label for="name" class="col-sm-2 col-form-label">Nama Obat : </label>
        <div class="col-sm-10">
            <input type="text" class="form-control" id="name" name="name" value="{{ $medicine['name'] }}">
        </div>
    </div>
    <div class="mb-3 row">
        <label for="type" class="col-sm-2 col-form-label">Jenis Obat :</label>
        <div class="col-sm-10">
            <select class="form-select" id="type" name="type"> <option selected disabled hidden Pilih </option>
                <option value="tablet" {{ $medicine['type'] == 'tablet' ? 'selected' : '' }}>Tablet</option>
                <option value="sirup" {{ $medicine['type'] == 'sirup' ? 'selected' : '' }}>Sirup</option>
                <option value="kapsul" {{ $medicine['type'] == 'kapsul' ? 'selected' : '' }}>Kapsul</option>
            </select>
        </div>
    </div>
    <div class="mb-3 row">
        <label for="price" class="col-sm-2 col-form-label">Harga Obat : </label>
        <div class="col-sm-10">
            <input type="number" class="form-control" id="price" name="price" value="{{ $medicine['price'] }}">
        </div>
    </div>
    <button type="submit" class="btn btn-primary mt-3">Tambah Data</button>
</form>
@endsection