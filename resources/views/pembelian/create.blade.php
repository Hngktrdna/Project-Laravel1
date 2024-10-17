@extends('layout.layout')

@section('content')

    @if (Session::get('success'))
        <div class="alert alert-success">
            {{ Session::get('success') }}
        </div>
    @endif

    @if (Session::get('failed'))
        <div class="alert alert-danger">
            {{ Session::get('failed') }}
        </div>
    @endif

    <div class="container">
        <h1 class="text-center">Tambah Pembelian</h1>
        <br>    

        <!-- Kembali ke Data Pembelian Button -->
        <div class="mb-3">
            <a href="{{ route('pembelian.index') }}" class="btn btn-secondary">Kembali ke Data Pembelian</a>
        </div>

        <table class="table table-bordered table-stripped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nama Obat</th>
                    <th>Jenis</th>
                    <th>Harga</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @if (count($medicines) < 1)
                    <tr>
                        <td colspan="5" class="text-center">Data Pembelian Kosong</td>
                    </tr>
                @else
                    @foreach ($medicines as $index => $item)
                        <tr>
                            <td>{{ ($medicines->currentPage() - 1) * $medicines->perPage() + ($index + 1) }}</td>
                            <td>{{ $item['name'] }}</td>
                            <td>{{ $item['type'] }}</td>
                            <td>Rp{{ number_format($item['price'], 0, '.', '.') }}</td>
                            <td>
                                <form action="{{ route('pembelian.store') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="medicine_id" value="{{ $item->id }}">
                                    <button type="submit" class="btn btn-success btn-sm">Submit Pembelian</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>

        {{-- <div class="d-flex justify-content-end">
            {{ $medicines->links() }}
        </div> --}}
    </div>
@endsection

@push('script')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script>
        function showModal(id, name) {
            let urlDelete = '{{ route('obat.delete', ':id') }}';
            urlDelete = urlDelete.replace(":id", id);
            $('#form-delete-obat').attr('action', urlDelete);
            $('#exampleModal').modal('show');
            $('#nama-obat').text(name);
        }

        @if (Session::get('failed'))
            $(document).ready(function() {
                let id = "{{ Session::get('id') }}";
                let stock = "{{ Session::get('stock') }}";
                showModalStock(id, stock);
            });
        @endif
    </script>
@endpush
    