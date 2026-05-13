<div id="myModal" class="hidden">
    <div class="modal-content w-[440px] bg-white p-8 rounded-lg shadow-md m-auto h-auto">
        <div class="flex justify-between items-center">
            <h1 class="text-lg font-semibold mb-4">Tambah Ingredient Kopi</h1>
            <button id="closeModalButton" class="p-2">
                <h1 class="text-lg font-semibold mb-4">x</h1>
            </button>
        </div>
        
        <form action="/add-ingredient" method="POST">
            @csrf
            <div class="mb-4">
                <label for="jenis" class="block text-sm font-medium text-gray-700">Nama Bahan Kopi</label>
                {{-- <input type="text" name="bahan" id="bahan" class="mt-1 focus:ring-secondary focus:border-secondary w-full shadow-sm sm:text-sm border-gray-300 rounded-md" required> --}}
                <select class="mt-1 w-full text-sm font-mediumshadow-sm sm:text-sm border-gray-300 rounded-md" name="bahan" id="bahan" required>
                    <option value="" disabled selected hidden>Pilih Bahan Kopi</option>
                    @foreach ($rawingredient as $data)
                        <option value="{{ $data->id }}">{{ $data->nama }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-4">
                <label for="Nama Kopi" class="block text-sm font-medium text-gray-700">Nama Menu Kopi</label>
                <select class="mt-1 w-full text-sm font-mediumshadow-sm sm:text-sm border-gray-300 rounded-md" name="nama_kopi" id="nama_kopi" required>
                    <option value="" disabled selected hidden>Pilih Menu Kopi</option>
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
            <h1 class="text-lg font-semibold mb-4">Edit Ingredient Kopi</h1>
            <button id="closeEditModalButton" class="p-2">
                <h1 class="text-lg font-semibold mb-4">x</h1>
            </button>
        </div>
        
        <form id="editBahanForm" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label for="edit_bahan" class="block text-sm font-medium text-gray-700">Nama Bahan Kopi</label>
                {{-- <input type="text" name="bahan" id="edit_bahan" class="mt-1 focus:ring-secondary focus:border-secondary w-full shadow-sm sm:text-sm border-gray-300 rounded-md"> --}}
                <select class="mt-1 w-full text-sm font-mediumshadow-sm sm:text-sm border-gray-300 rounded-md" name="bahan" id="edit_bahan">
                    <option value="" disabled selected hidden>Pilih Bahan Kopi</option>
                    @foreach ($rawingredient as $data)
                        <option value="{{ $data->id }}">{{ $data->nama }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-4">
                <label for="edit_nama_kopi" class="block text-sm font-medium text-gray-700">Nama Menu Kopi</label>
                <select class="mt-1 w-full text-sm font-medium shadow-sm sm:text-sm border-gray-300 rounded-md" name="nama_kopi" id="edit_nama_kopi">
                    <option value="" disabled selected hidden>Pilih Menu Kopi</option>
                    @foreach ($kopi as $data)
                        <option value="{{ $data->id }}">{{ $data->jenis_kopi }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex justify-end gap-2">
                <button id="closeEditModalButton" class="bg-secondary text-primary px-4 py-2 rounded-md hover:bg-secondary_hover">Batal</button>
                <button type="submit" class="bg-primary text-secondary px-4 py-2 rounded-md hover:bg-[#ddc79e]">Update</button>
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
    document.querySelectorAll('.edit-bahan-button').forEach(button => {
        button.addEventListener('click', function(event) {
            event.preventDefault();
            const id = this.getAttribute('data-id_bahan');
            const nama = this.getAttribute('data-nama_bahan');
            const namaingredient = this.getAttribute('data-ingredient');
            const kopiId = this.getAttribute('data-nama_kopi');
            document.getElementById('edit_bahan').value = namaingredient;
            document.getElementById('edit_nama_kopi').value = kopiId;
            document.getElementById('editBahanForm').setAttribute('action', '/edit-ingredient/' + id);
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