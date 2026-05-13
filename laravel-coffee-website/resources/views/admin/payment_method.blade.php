@extends('layouts/admin')

@section('admin-content')
    <div class="admin-container">
        <p class="text-2xl font-semibold">Manajemen Metode Pembayaran</p>

        <div class="flex justify-end">
            <button id="open_modal_create_payment" class="rounded-md text-primary border-primary border font-medxium text-xs bg-secondary p-2 px-4 hover:bg-secondary_hover">
                + Tambah Metode
            </button>
        </div>

        <div class="flex">
            <table class="">
                <thead>
                    <tr class="bg-primary">
                        <th class="w-5">No</th>
                        <th>Jenis Payment</th>
                        <th>Nama</th>
                        <th>Atas Nama</th>
                        <th>No Rek/Hp</th>
                        <th class=" w-[160px]">Foto</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody class="bg-white">
                    @foreach ($datas as $index => $item)
                    <tr>
                        <td class="text-center">{{ $index + 1 }}</td>
                        <td>{{ $item->jenis }}</td>
                        <td>{{ $item->nama }}</td>
                        <td>{{ $item->atas_nama }}</td>
                        <td>{{ $item->nomor }}</td>
                        <td class=" ">
                            <center>
                                @if ($item->foto)
                                    <img class="" src="{{ asset('images/' . $item->foto) }}" alt="foto qris">
                                @else
                                    -
                                @endif
                            </center>
                            
                        </td>

                        <td class="w-8">
                            <div>
                                <div class="flex gap-2">
                                    <a class="rounded-md text-white text-xs bg-yellow-500 p-2 px-4 open_modal_edit_payment" href="" 
                                    data-id="{{ $item->id }}" data-nama="{{ $item->nama }}" 
                                    data-an="{{ $item->atas_nama }}" data-no='{{ $item->nomor }}'
                                    data-foto='{{ $item->foto }}' data-jenis="{{ $item->jenis }}">
                                        Edit
                                    </a>
                                    <form action="/delete_metode/{{ $item->id }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button class="rounded-md text-white text-xs bg-red-500 p-2" 
                                                onclick="return confirm('Anda yakin akan menghapus metode {{ $item->nama }}?')">
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
    


<!-- Modal Create Metode Payment-->
    <div id="myModal" class="hidden" enctype="multipart/form-data">
        
        <div class="modal-content w-[440px] bg-white p-8 rounded-lg shadow-md m-auto h-auto">
            <div class="flex justify-between items-center">
                <h1 class="text-lg font-semibold mb-4">Tambah Metode Pembayaran</h1>
                <button id="close_modal_create_payment" class="p-2">
                    <h1 class="text-lg font-semibold mb-4">x</h1>
                </button>
            </div>
            
            <form action="/add-payment_method" method="POST" enctype="multipart/form-data"  >
                @csrf
                <div class="mb-4">
                    <label for="jenis_payment" class="block text-sm font-medium text-gray-700">Jenis Payment</label>
                    <select class="mt-1 w-full text-sm font-mediumshadow-sm sm:text-sm border-gray-300 rounded-md" name="jenis_payment" id="pilih_jenis_kopi" onchange="TombolPilihJenis()" required>
                        <option value="" disabled selected hidden>Pilih Jenis</option>
                        <option value="Bank">Bank</option>
                        <option value="E-Wallet">E-Wallet</option>
                        <option value="Qris">Qris</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label for="nama" class="block text-sm font-medium text-gray-700">Nama Bank/E-Wallet/Qris</label>
                    <input required type="text" name="nama" id="nama" class="mt-1 focus:ring-secondary focus:border-secondary w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                </div>

                <div class="mb-4">
                    <label for="atas_nama" class="block text-sm font-medium text-gray-700">Atas Nama</label>
                    <input required type="text" name="atas_nama" id="atas_nama" class="mt-1 focus:ring-secondary focus:border-secondary w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                </div>

                <div id='input_nomor' class="mb-4 hidden">
                    <label for="nomor" class="block text-sm font-medium text-gray-700">Nomor Rekening/HP</label>
                    <input type="number" name="nomor" id="create_nomor" class="mt-1 focus:ring-secondary focus:border-secondary w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                </div>

                <div id="qris_input" class="mb-4 hidden">
                    <label for="foto_qris" class="block text-sm font-medium text-gray-700">Foto Qris</label>
                    <input type="file" name="foto_qris" id="input_foto_qris" class="mt-1 p-1 focus:ring-secondary focus:border-secondary w-full shadow-sm sm:text-sm border border-gray-300 rounded-md">
                </div>
                
                <div class="flex justify-end gap-2">
                    <div>
                        <button id="close_modal_create_payment" class="bg-secondary text-primary px-4 py-2 rounded-md hover:bg-secondary_hover">Batal</button>
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
                <h1 class="text-lg font-semibold mb-4">Edit Metode Pembayaran</h1>
                <button id="close_modal_edit_payment" class="p-2">
                    <h1 class="text-lg font-semibold mb-4">x</h1>
                </button>
            </div>
            
            <form id="edit_metode_pembayaran_form" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="mb-4">
                    <label for="jenis_payment" class="block text-sm font-medium text-gray-700">Jenis Payment</label>
                    <select class="mt-1 w-full text-sm font-mediumshadow-sm sm:text-sm border-gray-300 rounded-md" name="jenis_payment" id="edit_jenis" onchange="toggleTableInput()">
                        <option value="" disabled selected hidden>Pilih Jenis</option>
                        <option value="Bank">Bank</option>
                        <option value="E-Wallet">E-Wallet</option>
                        <option value="Qris">Qris</option>
                        {{-- @foreach ($datas as $data)
                            <option value="{{ $data->jenis }}">{{ $data->jenis }}</option>
                        @endforeach --}}
                    </select>
                </div>

                <div class="mb-4">
                    <label for="nama" class="block text-sm font-medium text-gray-700">Nama Bank/E-Wallet/Qris</label>
                    <input type="text" name="nama" id="edit_nama" class="mt-1 focus:ring-secondary focus:border-secondary w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                </div>

                <div class="mb-4">
                    <label for="atas_nama" class="block text-sm font-medium text-gray-700">Atas Nama</label>
                    <input type="text" name="atas_nama" id="edit_atas_nama" class="mt-1 focus:ring-secondary focus:border-secondary w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                </div>

                <div id='input_edit_nomor' class="mb-4 hidden">
                    <label for="nomor" class="block text-sm font-medium text-gray-700">Nomor Rekening/HP</label>
                    <input type="number" name="nomor" id="edit_nomor" class="mt-1 focus:ring-secondary focus:border-secondary w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                </div>

                <div id="input_edit_qris" class="mb-4 hidden">
                    <label for="foto_qris" class="block text-sm font-medium text-gray-700">Foto Qris</label>
                    <input type="file" name="foto_qris" id="edit_foto_qris" class="mt-1 p-1 focus:ring-secondary focus:border-secondary w-full shadow-sm sm:text-sm border border-gray-300 rounded-md">
                </div>

                <div class="flex justify-end gap-2">
                    {{-- <div> --}}
                        <button id="close_modal_edit_payment" class="bg-secondary text-primary px-4 py-2 rounded-md hover:bg-secondary_hover">Batal</button>
                        <button type="submit" class="bg-primary text-secondary px-4 py-2 rounded-md hover:bg-[#ddc79e]">Update</button>
                    {{-- </div> --}}
                </div>
            </form>
        </div>
    </div>


{{-- JavaScript Area --}}
    <script>
        // Open modal when button clicked
        document.getElementById('open_modal_create_payment').addEventListener('click', function() {
            document.getElementById('myModal').classList.remove('hidden');
            document.getElementById('myModal').classList.add('bg-[#0000006f]', 'fixed', 'top-0', 'left-0', 'w-full', 'h-full', 'flex', 'items-center', 'justify-center');
        });

        // Close modal when close button clicked
        document.getElementById('close_modal_create_payment').addEventListener('click', function() {
            document.getElementById('myModal').classList.add('hidden');
            document.getElementById('myModal').classList.remove('bg-[#0000006f]', 'fixed', 'top-0', 'left-0', 'w-full', 'h-full', 'flex', 'items-center', 'justify-center');
        });

        // const modalOverlay = document.getElementById('modalOverlay');
        // const modal = document.getElementById('myModal');

        // Open edit modal
        document.querySelectorAll('.open_modal_edit_payment').forEach(button => {
            button.addEventListener('click', function(event) {
                event.preventDefault();
                const id = this.getAttribute('data-id');
                const jenis = this.getAttribute('data-jenis');
                const nama = this.getAttribute('data-nama');
                const no = this.getAttribute('data-no');
                const foto = this.getAttribute('data-foto');
                const an = this.getAttribute('data-an');

                document.getElementById('edit_metode_pembayaran_form').setAttribute('action', '/edit-payment_method/' + id);
                document.getElementById('edit_jenis').value = jenis;
                document.getElementById('edit_nama').value = nama;
                document.getElementById('edit_atas_nama').value = an;
                document.getElementById('edit_foto_qris').placeholder = foto;
                document.getElementById('edit_nomor').value = no;

                document.getElementById('editModal').classList.remove('hidden');
                document.getElementById('editModal').classList.add('bg-[#0000006f]', 'fixed', 'top-0', 'left-0', 'w-full', 'h-full', 'flex', 'items-center', 'justify-center');
            });
        });

        // Close edit modal
        document.getElementById('close_modal_edit_payment').addEventListener('click', function() {
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

    <script>
        function TombolPilihJenis() {
                var pilih_jenis = document.getElementById("pilih_jenis_kopi");
                var input_qris = document.getElementById("qris_input");
                
                if (pilih_jenis.value == "Qris") {
                    input_qris.classList.remove('hidden');
                    document.getElementById("input_nomor").classList.add('hidden');
                    document.getElementById("input_foto_qris").required = true;
                    document.getElementById("create_nomor").required = false;
                    // input_qris.classList.add('flex', 'flex-row', 'items-center', 'gap-2');
                } 
                else {
                    input_qris.classList.add('hidden');
                    document.getElementById("input_nomor").classList.remove('hidden');
                    document.getElementById("input_foto_qris").required = false;
                    document.getElementById("create_nomor").required = true;
                    // input_qris.classList.remove('flex', 'flex-row', 'items-center', 'gap-2');
                }
            }
    </script>
{{-- Buka form untuk input qris atau no rek/hp --}}
    <script>
        

        function toggleTableInput() {
            var edit_jenis = document.getElementById("edit_jenis");
            var input_edit_qris = document.getElementById("input_edit_qris");
            
            if (edit_jenis.value === "Qris") {
                input_edit_qris.classList.remove('hidden');
                document.getElementById("input_edit_nomor").classList.add('hidden');
                // input_qris.classList.add('flex', 'flex-row', 'items-center', 'gap-2');
            } 
            else {
                input_edit_qris.classList.add('hidden');
                document.getElementById("input_edit_nomor").classList.remove('hidden');
                // input_qris.classList.remove('flex', 'flex-row', 'items-center', 'gap-2');
            }
        }
    </script>
@endsection