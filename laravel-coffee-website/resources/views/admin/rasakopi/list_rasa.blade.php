@extends('layouts/admin')

@section('admin-content')
    <div class="admin-container">
        <p class="text-2xl font-semibold">Manajemen Jenis Kopi</p>

        <div class="flex justify-end">
            <button id="openModalButton" class="rounded-md text-secondary border-secondary border font-medium text-xs bg-primary p-2 px-4 hover:bg-[#ddc79e]">
                + Tambah Jenis Kopi
            </button>
        </div>
        
        <div class="flex">
            <table class="">
                <thead>
                    <tr class="bg-primary">
                        <th class="w-5">No</th>
                        <th>Jenis Kopi</th>
                        <th>Rasa Kopi</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody class="bg-white">
                    @foreach ($rasakopi as $index => $item)
                    <tr>
                        <td class="text-center">{{ $index + 1 }}</td>
                        <td>{{ $item->nama_rasa }}</td>
                        <td>{{ $item->kopi->jenis_kopi }}</td>
                        <td class="w-8">
                            <div>
                                <div class="flex gap-2">
                                    <a class="rounded-md text-white text-xs bg-yellow-500 p-2 px-4 edit-button" href="" data-id="{{ $item->id }}" data-nama="{{ $item->nama_rasa }}" data-kopi="{{ $item->kopi->id }}">
                                        Edit
                                    </a>
                                    <form action="/delete_rasa/{{ $item->id }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button class="rounded-md text-white text-xs bg-red-500 p-2" 
                                                onclick="return confirm('Anda yakin akan menghapus Jenis Kopi {{ $item->nama_rasa }}?')">
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
                <h1 class="text-lg font-semibold mb-4">Tambah Jenis Kopi</h1>
                <button id="closeModalButton" class="p-2">
                    <h1 class="text-lg font-semibold mb-4">x</h1>
                </button>
            </div>
            
            <form action="/add-rasakopi" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="rasa" class="block text-sm font-medium text-gray-700">Nama Jenis Kopi</label>
                    <input type="text" name="rasa" id="rasa" class="mt-1 focus:ring-secondary focus:border-secondary w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                </div>
                <div class="mb-4">
                    <label for="Nama Kopi" class="block text-sm font-medium text-gray-700">Nama Rasa Kopi</label>
                    <select class="mt-1 w-full text-sm font-mediumshadow-sm sm:text-sm border-gray-300 rounded-md" name="nama_kopi" id="nama_kopi" onchange="toggleTableInput()" required>
                        <option value="" disabled selected hidden>Pilih Rasa Kopi</option>
                        @foreach ($kopi as $data)
                            <option value="{{ $data->id }}">{{ $data->jenis_kopi }}</option>
                        @endforeach
                    </select>
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
    <div id="editModal" class="hidden">
        <div class="modal-content w-[440px] bg-white p-8 rounded-lg shadow-md m-auto h-auto">
            <div class="flex justify-between items-center">
                <h1 class="text-lg font-semibold mb-4">Edit Rasa Kopi</h1>
                <button id="closeEditModalButton" class="p-2">
                    <h1 class="text-lg font-semibold mb-4">x</h1>
                </button>
            </div>
            
            <form id="editRasaForm" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-4">
                    <label for="edit_rasa" class="block text-sm font-medium text-gray-700">Nama Jenis Kopi</label>
                    <input type="text" name="rasa" id="edit_rasa" class="mt-1 focus:ring-secondary focus:border-secondary w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                </div>
                <div class="mb-4">
                    <label for="edit_nama_kopi" class="block text-sm font-medium text-gray-700">Nama Rasa Kopi</label>
                    <select class="mt-1 w-full text-sm font-medium shadow-sm sm:text-sm border-gray-300 rounded-md" name="nama_kopi" id="edit_nama_kopi" required>
                        <option value="" disabled selected hidden>Pilih Rasa Kopi</option>
                        @foreach ($kopi as $data)
                            <option value="{{ $data->id }}">{{ $data->jenis_kopi }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex justify-end gap-2">
                    {{-- <div> --}}
                        <button id="closeEditModalButton" class="bg-secondary text-primary px-4 py-2 rounded-md hover:bg-secondary_hover">Batal</button>
                        <button type="submit" class="bg-primary text-secondary px-4 py-2 rounded-md hover:bg-[#ddc79e]">Update</button>
                    {{-- </div> --}}
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

        // const modalOverlay = document.getElementById('modalOverlay');
        // const modal = document.getElementById('myModal');

        // Open edit modal
        document.querySelectorAll('.edit-button').forEach(button => {
            button.addEventListener('click', function(event) {
                event.preventDefault();
                const id = this.getAttribute('data-id');
                const nama = this.getAttribute('data-nama');
                const kopiId = this.getAttribute('data-kopi');
                document.getElementById('edit_rasa').value = nama;
                document.getElementById('edit_nama_kopi').value = kopiId;
                document.getElementById('editRasaForm').setAttribute('action', '/edit-rasakopi/' + id);
                document.getElementById('editModal').classList.remove('hidden');
                document.getElementById('editModal').classList.add('bg-[#0000006f]', 'fixed', 'top-0', 'left-0', 'w-full', 'h-full', 'flex', 'items-center', 'justify-center');
            });
        });

        // Close edit modal
        document.getElementById('closeEditModalButton').addEventListener('click', function() {
            document.getElementById('editModal').classList.add('hidden');
            document.getElementById('editModal').classList.remove('bg-[#0000006f]', 'fixed', 'top-0', 'left-0', 'w-full', 'h-full', 'flex', 'items-center', 'justify-center');
        });

        // Close modal if click outside of it
        window.onclick = function(event) {
            if (event.target == document.getElementById('myModal')) {
                document.getElementById('myModal').classList.add('hidden');
            }
            if (event.target == document.getElementById('editModal')) {
                document.getElementById('editModal').classList.add('hidden');
            }
        }
    </script>
@endsection