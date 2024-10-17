@extends('layout.layout')

@section('content')

{{-- Display success message if available --}}
@if (Session::get('success')) 
    <div class="alert alert-success">
        {{ Session::get('success') }}
    </div>
@endif

<div class="container">
   <h1 class="text-center">Halaman Data Pembelian</h1>

    {{-- Add a "Tambah Pembelian" button that directs to the form page --}}
    <a href="{{ route('pembelian.tambah') }}" class="btn btn-primary">Tambah Pembelian</a>

    <table class="table table-bordered table-stripped mt-3">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Barang</th>
                <th>Harga</th>
                <th>Jumlah</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @if (count($pembelian) < 1)
                <tr>
                    <td colspan="5" class="text-center">Data Pembelian Kosong</td>
                </tr>
            @else
                @php $no = 1 @endphp
                @foreach ($pembelian as $item)
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td>{{ $item->nama_barang }}</td>
                        <td>Rp{{ number_format($item->harga, 0, '.', '.') }}</td>
                        <td class="editable" style="cursor: pointer;" onclick="showModalEdit('{{ $item->id }}', '{{ $item->jumlah }}')">
                            {{ $item->jumlah }}
                        </td>
                        <td class="d-flex">
                            {{-- Delete button --}}
                            <button class="btn btn-danger btn-sm" onclick="showModal('{{ $item->id }}', '{{ $item->nama_barang }}')">Hapus</button>
                        </td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>

    {{-- Modal for editing quantity --}}
    <div class="modal fade" id="modal_edit_jumlah" tabindex="-1" aria-labelledby="modal_edit_jumlah_label" aria-hidden="true">
        <div class="modal-dialog">
            <form id="form_edit_jumlah" method="POST">
                @csrf
                @method('PATCH')
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modal_edit_jumlah_label">Edit Jumlah Pembelian</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="jumlah" class="form-label">Jumlah: </label>
                            <input type="number" name="jumlah" id="jumlah_edit" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batalkan</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Modal for deleting --}}
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form id="form-delete-pembelian" method="POST">
            @csrf
            @method('DELETE')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Hapus Data Pembelian</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>  
                <div class="modal-body">
                    Apakah anda yakin ingin menghapus pembelian ini <span id="nama-barang"></span>?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batalkan</button>
                    <button type="submit" class="btn btn-danger">Hapus</button>
                </div>
            </div>
        </form>
    </div>
</div>

    <div class="d-flex justify-content-end">
        {{ $pembelian->links() }}
    </div>
</div>

@endsection

@push('script')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script>
        function showModalEdit(id, jumlah) {
            // Set the current quantity in the input field
            $("#jumlah_edit").val(jumlah);
            // Set the form action to the correct route
            let url = "{{ route('pembelian.update', ':id') }}";
            url = url.replace(':id', id);
            $('#form_edit_jumlah').attr('action', url);
            // Show the modal for editing
                        // Show the modal for editing
                        $("#modal_edit_jumlah").modal("show");
        }
        function showModal(id, name) {
    // Set the name of the item to be deleted in the modal
    $('#nama-barang').text(name);
    
    // Set the form action to the correct route
    let urlDelete = "{{ route('pembelian.delete', ':id') }}";
    urlDelete = urlDelete.replace(':id', id);
    $('#form-delete-pembelian').attr('action', urlDelete);
    
    // Show the modal
    $('#exampleModal').modal('show');
}
    </script>
@endpush