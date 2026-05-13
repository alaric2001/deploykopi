<div id="myModal" class="hidden">
    <div class="modal-content w-[440px] bg-white p-8 rounded-lg shadow-md m-auto h-auto">
        <div class="flex justify-between items-center">
            <h1 class="text-lg font-semibold mb-4">Tambah Jenis Kopi</h1>
            <button id="closeModalButton" class="p-2">
                <h1 class="text-lg font-semibold mb-4">x</h1>
            </button>
        </div>
        
        <form action="/add-rawjeniskopi" method="POST">
            @csrf
            <div class="mb-4">
                <label for="jenis" class="block text-sm font-medium text-gray-700">Nama Jenis Kopi</label>
                <input type="text" name="nama" id="jenis" class="mt-1 focus:ring-secondary focus:border-secondary w-full shadow-sm sm:text-sm border-gray-300 rounded-md" required>
            </div>
            <div class="mb-4">
                <label for="stokjenis" class="block text-sm font-medium text-gray-700">Stok Jenis Kopi</label>
                <input type="number" name="stok" id="stokjenis" class="mt-1 focus:ring-secondary focus:border-secondary w-full shadow-sm sm:text-sm border-gray-300 rounded-md" required>
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
            <h1 class="text-lg font-semibold mb-4">Edit Jenis Kopi</h1>
            <button id="closeEditModalButton" class="p-2">
                <h1 class="text-lg font-semibold mb-4">x</h1>
            </button>
        </div>
        
        <form id="editJenisForm" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label for="edit_jenis" class="block text-sm font-medium text-gray-700">Nama Jenis Kopi</label>
                <input type="text" name="nama" id="edit_jenis" class="mt-1 focus:ring-secondary focus:border-secondary w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
            </div>
            <div class="mb-4">
                <label for="editstokjenis" class="block text-sm font-medium text-gray-700">Stok Jenis Kopi</label>
                <input type="number" name="stok" id="editstokjenis" class="mt-1 focus:ring-secondary focus:border-secondary w-full shadow-sm sm:text-sm border-gray-300 rounded-md" required>
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
            const stok = this.getAttribute('data-stokjeniskopi');
            // const kopiId = this.getAttribute('data-kopi');
            document.getElementById('edit_jenis').value = nama;
            document.getElementById('editstokjenis').value = stok;
            document.getElementById('editJenisForm').setAttribute('action', '/edit-rawjeniskopi/' + id);
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