@extends('layouts/admin')

@section('admin-content')
    <div class="admin-container">
        <p class="text-2xl font-semibold">Manajemen Menu Kopi</p>

        <div class="flex justify-end">
            <button id="openModalButton" class="rounded-md text-secondary border-secondary border font-medium text-xs bg-primary p-2 px-4 hover:bg-[#ddc79e]">
                + Tambah Menu Kopi
            </button>
        </div>

        <div class="flex">
            <table class="">
                <thead>
                    <tr class="bg-primary">
                        <th class="w-5">No</th>
                        <th class="w-[140px]">Menu Kopi</th>
                        <th class="w-[80px]">Stok</th>
                        <th class="w-[140px]">Harga</th>
                        <th class="w-[80px]">Diskon</th>
                        <th class="w-[140px]">Gambar</th>
                        <th class="">Deskripsi</th>
                        <th class="w-8">Action</th>
                    </tr>
                </thead>
                <tbody class="bg-white">
                    @foreach ($kopi as $index => $item)
                    <tr>
                        <td class="text-center">{{ $index + 1 }}</td>
                        <td>{{ $item->jenis_kopi }}</td>
                        <td class="">{{ $item->stok }}</td>
                        <td>
                            @if($item->diskon > 0)
                                <s class="text-xs">Rp. {{ number_format($item->harga, 0, ',', '.') }}</s><br>
                                Rp. {{ number_format($item->harga * (1 - $item->diskon / 100), 0, ',', '.') }}
                            @else
                                Rp. {{ number_format($item->harga, 0, ',', '.') }}
                            @endif
                        </td>
                        <td>
                            @if($item->diskon > 0)
                                {{$item->diskon}} %
                            @else
                                -
                            @endif
                        </td>
                        
                        <td>
                            <img class="" src="{{ asset('images/' . $item->foto) }}" alt="gambar kopi">
                        </td>
                        <td class="text-xs">{{ $item->deskripsi }}</td>
                        <td>
                            <div>
                                <div class="flex gap-2">
                                    <button class="rounded-md text-white text-xs bg-yellow-500 p-2 px-4 tombol_edit"
                                            data-id="{{ $item->id }}" data-jenis="{{ $item->jenis_kopi }}" data-stok="{{ $item->stok }}"
                                            data-harga='{{ $item->harga }}' data-gambar='{{ $item->foto }}' data-deskripsi='{{ $item->deskripsi }}'
                                            data-diskon="{{ $item->diskon }}">
                                        Edit
                                    </button>
                                    <form action="/delete_kopi/{{ $item->id }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button class="rounded-md text-white text-xs bg-red-500 p-2" 
                                                onclick="return confirm('Anda yakin akan menghapus Menu {{ $item->jenis_kopi }}?')">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal -->
    <div id="myModal" class="hidden">
        <div class="modal-content w-[440px] bg-white p-8 rounded-lg shadow-md m-auto h-auto">
            <div class="flex justify-between items-center">
                <h1 class="text-lg font-semibold mb-4">Tambah Menu Kopi</h1>
                <button id="closeModalButton" class="p-2">
                    <h1 class="text-lg font-semibold mb-4">x</h1>
                </button>
            </div>
            
            <form action="/add_kopi" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-4">
                    <label for="jenis_kopi" class="block text-sm font-medium text-gray-700">Nama Menu Kopi</label>
                    <input required type="text" name="jenis_kopi" id="jenis_kopi" class="mt-1 focus:ring-secondary focus:border-secondary w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                </div>
                <div class="mb-4">
                    <label for="stok_kopi" class="block text-sm font-medium text-gray-700">Stok Kopi</label>
                    <input required type="number" name="stok_kopi" id="stok_kopi" class="mt-1 focus:ring-secondary focus:border-secondary w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                </div>
                <div class="mb-4">
                    <label for="diskon_kopi" class="block text-sm font-medium text-gray-700">Diskon Kopi</label>
                    <input type="number" name="diskon_kopi" id="diskon_kopi" class="mt-1 focus:ring-secondary focus:border-secondary w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                </div>
                <div class="mb-4">
                    <label for="harga_kopi" class="block text-sm font-medium text-gray-700">Harga Menu Kopi</label>
                    <input required type="number" name="harga_kopi" id="harga_kopi" class="mt-1 focus:ring-secondary focus:border-secondary w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                </div>
                <div class="mb-4">
                    <label for="deskripsi" class="block text-sm font-medium text-gray-700">Deskripsi</label>
                    <textarea name="deskripsi" id="deskripsi" id="" cols="43" rows="1" class="focus:ring-secondary focus:border-secondary w-full shadow-sm sm:text-sm border border-gray-300 rounded-md"></textarea>
                </div>
                <div class="mb-4">
                    <label for="gambar_kopi" class="block text-sm font-medium text-gray-700">Gambar Minuman</label>
                    <input required type="file" name="gambar_kopi" id="gambar_kopi" class="mt-1 p-1 focus:ring-secondary focus:border-secondary w-full shadow-sm sm:text-sm border border-gray-300 rounded-md">
                </div>

                <div class="flex justify-end">
                    <div>
                        <a href="" id="closeModalButton" class="bg-secondary text-primary px-4 py-2 rounded-md hover:bg-secondary_hover">Batal</a>
                        <button type="submit" class="bg-primary text-secondary px-4 py-2 rounded-md hover:bg-[#ddc79e]">Simpan</button>
                    </div>
                    
                </div>
            </form>
        </div>
    </div>
    

    <!-- Modal Edit -->
    <div id="modal_edit" class="hidden">
        <div class="modal-content w-[440px] bg-white p-8 rounded-lg shadow-md m-auto h-auto">
            <div class="flex justify-between items-center">
                <h1 class="text-lg font-semibold mb-4">Edit Menu Kopi</h1>
                <button id="closeEditModalButton" class="p-2">
                    <h1 class="text-lg font-semibold mb-4">x</h1>
                </button>
            </div>
            
            <form id="form_edit_kopi" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="mb-4">
                    <label for="jenis_edit" class="block text-sm font-medium text-gray-700">Nama Menu Kopi</label>
                    <input type="text" name="jenis_kopi" id="jenis_edit" class="mt-1 focus:ring-secondary focus:border-secondary w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                </div>
                <div class="mb-4">
                    <label for="stok_kopi" class="block text-sm font-medium text-gray-700">Stok Kopi</label>
                    <input required type="number" name="stok_edit" id="stok_edit" class="mt-1 focus:ring-secondary focus:border-secondary w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                </div>
                <div class="mb-4">
                    <label for="diskon_kopi" class="block text-sm font-medium text-gray-700">Diskon Kopi</label>
                    <input required type="number" name="diskon_edit" id="diskon_edit" class="mt-1 focus:ring-secondary focus:border-secondary w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                </div>
                <div class="mb-4">
                    <label for="harga_kopi" class="block text-sm font-medium text-gray-700">Harga Menu Kopi</label>
                    <input type="number" name="harga_kopi" id="harga_edit" class="mt-1 focus:ring-secondary focus:border-secondary w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                </div>
                <div class="mb-4">
                    <label for="deskripsi" class="block text-sm font-medium text-gray-700">Deskripsi</label>
                    <textarea name="deskripsi" id="deskripsi_edit" id="" cols="43" rows="4" class="focus:ring-secondary focus:border-secondary w-full shadow-sm sm:text-sm border border-gray-300 rounded-md"></textarea>
                </div>
                <div class="mb-4">
                    <label for="gambar_kopi" class="block text-sm font-medium text-gray-700">Gambar Minuman</label>
                    <input type="file" name="gambar_kopi" id="gambar_edit" class="mt-1 p-1 focus:ring-secondary focus:border-secondary w-full shadow-sm sm:text-sm border border-gray-300 rounded-md">
                </div>
                

                <div class="flex justify-end">
                    <div>
                        <a href="" id="closeEditModalButton" class="bg-secondary text-primary px-4 py-2 rounded-md hover:bg-secondary_hover">Batal</a>
                        <button type="submit" class="bg-primary text-secondary px-4 py-2 rounded-md hover:bg-[#ddc79e]">Update</button>
                    </div>
                </div>
            </form>
        </div>
    </div>



    <script>
        // Open modal when button clicked
        document.getElementById('openModalButton').addEventListener('click', function() {
            document.getElementById('myModal').classList.remove('hidden');
            document.getElementById('myModal').classList.add('bg-[#0000006f]', 'fixed', 'top-0', 'left-0', 'w-full', 'h-full', 'flex', 'items-center', 'justify-center');
        });

        // Close modal when close button clicked
        document.getElementById('closeModalButton').addEventListener('click', function() {
            document.getElementById('myModal').classList.add('hidden');
            document.getElementById('myModal').classList.remove('bg-[#0000006f]', 'fixed', 'top-0', 'left-0', 'w-full', 'h-full', 'flex', 'items-center', 'justify-center');
        });

        // Open edit modal
        document.querySelectorAll('.tombol_edit').forEach(button => {
            button.addEventListener('click', function(event) {
                event.preventDefault();
                const id = this.getAttribute('data-id')
                const jenis_kopi = this.getAttribute('data-jenis');
                const diskon = this.getAttribute('data-diskon');
                const stok = this.getAttribute('data-stok');
                const harga = this.getAttribute('data-harga');
                const gambar = this.getAttribute('data-gambar');
                const desk = this.getAttribute('data-deskripsi');
                document.getElementById('jenis_edit').value = jenis_kopi;
                document.getElementById('diskon_edit').value = diskon;
                document.getElementById('stok_edit').value = stok;
                document.getElementById('harga_edit').value =harga;
                document.getElementById('gambar_edit').placeholder = gambar;
                document.getElementById('deskripsi_edit').value = desk;

                document.getElementById('form_edit_kopi').setAttribute('action', '/update_kopi/' + id);
                document.getElementById('modal_edit').classList.remove('hidden');
                document.getElementById('modal_edit').classList.add('bg-[#0000006f]', 'fixed', 'top-0', 'left-0', 'w-full', 'h-full', 'flex', 'items-center', 'justify-center');
            });
        });

        // Close edit modal
        document.getElementById('closeEditModalButton').addEventListener('click', function() {
            document.getElementById('modal_edit').classList.add('hidden');
            document.getElementById('modal_edit').classList.remove('bg-[#0000006f]', 'fixed', 'top-0', 'left-0', 'w-full', 'h-full', 'flex', 'items-center', 'justify-center');
        });

        // Close modal if click outside of it
        window.onclick = function(event) {
            if (event.target == document.getElementById('myModal')) {
                document.getElementById('myModal').classList.add('hidden');
            }
            if (event.target == document.getElementById('modal_edit')) {
                document.getElementById('modal_edit').classList.add('hidden');
            }
        }
    </script>
    
@endsection