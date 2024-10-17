 @extends('layout.layout') {{--meng-extend file layout yang ada di folder layout --}}

 @section('content') {{-- mendefinisikan sebuah bagian (section) dari konten yang akan dimasukkan ke dalam layout utama. --}}

{{-- memeriksa apakah ada pesan success (sukses) di data session. Jika ada, maka akan menampilkan pesan sukses di dalam box alert. --}}
    @if (Session::get('success')) 
        <div class="alert alert-success">
            {{ Session::get('success') }}
        </div>
    @endif

    <div class="container">
       <h1 class="text-center">Halaman Data Pengguna</h1>

        {{-- tombol berlabel "Tambah Akun" yang mengarah ke route akun.tambah. Route ini akan membawa pengguna ke halaman untuk menambah akun pengguna baru.--}}
        <a href="{{ route('akun.tambah') }}" class="btn btn-primary">Tambah Akun</a>


        <table class="table table-bordered table-stripped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @if (count($users) < 1)
                    <tr>
                        <td colspan="6" class="text-center">Data Pengguna Kosong</td>
                    </tr>
                @else
                    @php $no = 1 @endphp
                    @foreach ($users as $index => $item)
                        <tr>
                            <td>{{ $no++ }}</td>
                            <td>{{ $item['name'] }}</td>
                            <td>{{ $item['email'] }}</td>
                            <td>{{ $item['role'] }}</td>
                            <td class="d-flex">
                                {{-- mengarahkan pengguna ke route akun.edit, di mana pengguna bisa mengedit informasi akun. --}}
                                <a href={{ route('akun.edit', $item['id']) }} class="btn btn-primary me-2">Edit</a>

                                <button class="btn btn-danger btn-sm"
                                {{-- fungsi showModal() untuk membuka modal konfirmasi penghapusan akun. --}}
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
                <form id="form-delete-akun" method="POST">
                    @csrf
                    @method('DELETE')
                
                    {{-- menimpa method="POST" diganti menjadi delete, sesuai dengan http
                method untuk menghapus data- --}}
                    {{-- @method('DELETE') --}}
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Hapus Data Akun</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>  
                        <div class="modal-body">
                            Apakah anda yakin ingin menghapus akun ini <span id="nama-akun"></span>?

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batalkan</button>
                            <button type="submit" class="btn btn-danger">Hapus</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        
        {{-- Modal edit stok --}}

        <div class="modal fade" id="modal_edit_stock" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <form id="form_edit_pengguna" method="POST">
                    @csrf
                    {{-- menimpa method="POST" diganti menjadi delete, sesuai dengan http
                method untul menghapus data- --}}
                    @method('PATCH')
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Kelola Data Pengguna</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batalkan</button>
                            <button type="submit" class="btn btn-danger" id="confirm-delete">Edit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script>
        function showModal(id, name) {

        // ini untuk url delete-nya (Route)
        let urlDelete = "{{ route('akun.delete.akun', ':id') }}";
        urlDelete = urlDelete.replace(':id', id);

        // Ini untuk action attribut-nya
        $('#form-delete-akun').attr('action', urlDelete);

        // Ini untuk show modalnya
        $('#exampleModal').modal('show');

        // Ini untuk mengisi modalnya dengan nama akun
        $('#nama-akun').text(name);
        }


        
    </script>
@endpush