@extends('layouts/admin')

@section('admin-content')
    <div class="admin-container">
        <p class="text-2xl font-semibold">Users Seteguk Kopi</p>

        <div class="flex">
            <table class="">
                <thead>
                    <tr class="bg-primary">
                        <th class="w-5">No</th>
                        <th>Nama User</th>
                        <th>Role</th>
                        <th>Email</th>
                        <th>Jenis Kelamin</th>
                        <th>No Hp</th>
                        <th class="w-[360px]">Alamat</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody class="bg-white">
                    @foreach ($data_user as $index => $item)
                    <tr>
                        <td class="text-center">{{ $index + 1 }}</td>
                        <td>{{ $item->name_user }}</td>
                        <td>{{ $item->role }}</td>
                        <td>{{ $item->email }}</td>
                        <td>{{ $item->user_jenis_kelamin }}</td>
                        <td>{{ $item->no_hp }}</td>
                        <td class="text-xs">{{ $item->alamat }}</td>
                        <td class="w-8">
                            <div>
                                <div class="flex gap-2">
                                    <a class="edit-button rounded-md text-white text-xs bg-yellow-500 p-2 px-4" href="" data-id="{{ $item->id }}" data-role="{{ $item->role }}">
                                        Edit
                                    </a>
                                    <form action="/delete_user/{{ $item->id }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button class="rounded-md text-white text-xs bg-red-500 p-2" 
                                                onclick="return confirm('Anda yakin akan menghapus {{ $item->name_user }}?')">
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
    

    <!-- Modal Edit -->
    <div id="editModal" class="hidden">
        <div class="modal-content w-[440px] bg-white p-8 rounded-lg shadow-md m-auto h-auto">
            <div class="flex justify-between items-center">
                <h1 class="text-lg font-semibold mb-4">Edit Role User</h1>
                <button id="closeEditModalButton" class="p-2">
                    <h1 class="text-lg font-semibold mb-4">x</h1>
                </button>
            </div>
            
            <form id="editJenisForm" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-4">
                    <label for="edit_role_user" class="block text-sm font-medium text-gray-700">Role User</label>
                    <select class="mt-1 w-full text-sm font-medium shadow-sm sm:text-sm border-gray-300 rounded-md" name="role" id="edit_role_user">
                        <option value="" disabled selected hidden>Pilih Role</option>
                        <option value="pemilik">Pemilik</option>
                        <option value="admin">Pegawai/Admin</option>
                        <option value="user">User</option>
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
        // Open edit modal
        document.querySelectorAll('.edit-button').forEach(button => {
            button.addEventListener('click', function(event) {
                event.preventDefault();
                const id = this.getAttribute('data-id');
                const role = this.getAttribute('data-role');
                // const kopiId = this.getAttribute('data-kopi');
                // document.getElementById('edit_jenis').value = nama;
                document.getElementById('edit_role_user').value = role;
                document.getElementById('editJenisForm').setAttribute('action', '/edit-user/' + id);
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