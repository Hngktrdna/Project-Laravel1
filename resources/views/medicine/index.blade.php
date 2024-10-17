@extends('layout.layout')

@section('content')
    @if (Session::get('success'))
        <div class="alert alert-success">
            {{ Session::get('success') }}
        </div>
    @endif

    <div class="container">

        <form action="{{ route('data_obat') }}" method="GET" class="me-2">
            <input type="hidden" name="sort_stock" value="1">
            <button type="submit" class="btn btn-primary">Urutkan Stok</button>
        </form>


        <table class="table table-bordered table-stripped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nama Obat</th>
                    <th>Jenis</th>
                    <th>Harga</th>
                    <th>Stok</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @if (count($medicines) < 1)
                    <tr>
                        <td colspan="6" class="text-center">Data Obat Kosong</td>
                    </tr>
                @else
                    @foreach ($medicines as $index => $item)
                        <tr>
                            <td>{{ ($medicines->currentPage() - 1) * $medicines->perPage() + ($index + 1) }}</td>
                            <td>{{ $item['name'] }}</td>
                            <td>{{ $item['type'] }}</td>
                            <td>Rp{{ number_format($item['price'], 0, '.', '.') }}</td>
                            <td class="{{ $item['stock'] <= 3 ? 'bg-danger text-white' : '' }}" style="cursor: pointer"
                                onclick="showModalStock('{{ $item->id }}', '{{ $item->stock }}')">{{ $item['stock'] }}
                            </td>
                            <td class="d-flex">
                                <a href={{ route('obat.edit', $item['id']) }} class="btn btn-primary me-2">Edit</a>
                                <button class="btn btn-danger btn-sm"
                                    onclick="showModal('{{ $item->id }}', '{{ $item->name }}')">Hapus</button>
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>

        {{-- Modal Hapus --}}

        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <form id="form-delete-obat" method="POST">
                    @csrf
                    {{-- menimpa method="POST" diganti menjadi delete, sesuai dengan http
                method untul menghapus data- --}}
                    @method('DELETE')
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Hapus Data Obat</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            Apakah anda yakin ingin menghapus obat <span id="nama-obat"></span>?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batalkan</button>
                            <button type="submit" class="btn btn-danger" id="confirm-delete">Hapus</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        {{-- Modal edit stok --}}

        <div class="modal fade" id="modal_edit_stock" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <form id="form_edit_stock" method="POST">
                    @csrf
                    {{-- menimpa method="POST" diganti menjadi delete, sesuai dengan http
                method untul menghapus data- --}}
                    @method('PATCH')
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Edit Stok Obat</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="stock" class="form-label">Stok: </label>
                                <input type="number" name="stock" id="stok_edit" class="form-control">
                                @if (Session::get('failed'))
                                    <small class="text-danger">{{ Session::get('failed') }}</small>
                                @endif
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batalkan</button>
                            <button type="submit" class="btn btn-danger" id="confirm-delete">Edit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="d-flex justify-content-end">
            {{-- links = memunculkan button pagination --}}
            {{ $medicines->links() }}
        </div>
    </div>
@endsection

@push('script')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script>
        function showModal(id, name) {

            // ini untuk url delete-nya (Route)
            let urlDelete = '{{ route('obat.delete', ':id') }}';
            urlDelete = urlDelete.replace(":id", id);

            // Ini untuk action attribut-nya
            $('#form-delete-obat').attr('action', urlDelete);

            // Ini untuk show modalnya
            $('#exampleModal').modal('show');

            // Ini untuk mengisi modalnya
            $('#nama-obat').text(name);
        }

        function showModalStock(id, stock) {
            // Mengisi stock yang dikirim ke input yang id-nya stok_edit
            $("#stok_edit").val(stock);
            // ambil route patch stock
            let url = "{{ route('obat.edit.stock', ':id') }}";
            // isi path dinamis :id dengan id dari parameter($item->id)
            url = url.replace(":id", id);
            // url tadi dikirim ke action
            $('#form_edit_stock').attr('action', url);
            // tampilkan modal
            $("#modal_edit_stock").modal("show");
        }

        @if (Session::get('failed'))
            //Jika halaman HTML-nya sudah selesai load cdn, jalankan di dalamnya
            $(document).ready(function() {
                // id dari with failed 'id' controller redirect back
                let id = "{{ Session::get ('id') }}";
                // Stock dari with failed 'stock' controller redirect back
                let stock = "{{ Session::get ('stock') }}";
                // Panggil func showModalStock dengan data id dan stock di atas
                showModalStock(id, stock);
            });
        @endif
    </script>
@endpush