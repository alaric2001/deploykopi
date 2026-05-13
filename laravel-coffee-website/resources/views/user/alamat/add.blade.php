@extends('layouts.user')
@section('judul', 'Tambah Alamat')
@section('content')
    <div class="pt-[60px] flex flex-col items-center lg:flex lg:justify-center h-screen">
        <div class="mb-1 p-2 font-semibold text-secondary">
            Tambah Alamat Pengiriman
        </div>

        <div class="flex flex-col gap-1 w-[90%]">
            <div class="p-3 bg-white border rounded-[10px]">
                <form action="/add-alamat" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-4">
                        <label for="kecamatan" class="block text-sm font-medium text-gray-700">Kecamatan</label>
                        <select class="mt-1 w-full text-xs font-medium shadow-sm sm:text-sm border-gray-300 rounded-md" name="kecamatan" id="kecamatan" required>
                            <option value="" disabled selected hidden>Pilih Kecamatan</option>
                            @foreach ($data_kec as $data)
                                <option value="{{ $data->nama_kec }}">{{ $data->nama_kec }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-4">
                        <label for="kelurahan" class="block text-sm font-medium text-gray-700">Kelurahan</label>
                        <select class="mt-1 w-full text-xs font-medium shadow-sm sm:text-sm border-gray-300 rounded-md" name="kelurahan" id="kelurahan" disabled required>
                            <option value="" disabled selected hidden>Pilih Kelurahan</option>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label for="kode_pos" class="block text-sm font-medium text-gray-700">Kodepos</label>
                        <input type="number" name="kode_pos" id="kode_pos" class="text-xs mt-1 focus:ring-secondary focus:border-secondary w-full shadow-sm sm:text-sm border-gray-300 rounded-md" placeholder="Masukkan Kodepos" required>
                    </div>
                    <div class="mb-4">
                        <label for="detail_alamat" class="block text-sm font-medium text-gray-700">Detail Alamat</label>
                        <textarea name="detail_alamat" id="detail_alamat" cols="30" rows="4" class="text-xs focus:ring-secondary focus:border-secondary w-full shadow-sm sm:text-sm border border-gray-300 rounded-md" placeholder="Masukkan Detail Alamat" required></textarea>
                    </div>

                    <div class="flex justify-end">
                        <div>
                            <a href="/alamat" id="" class="text-sm bg-secondary text-primary px-4 py-2 rounded-md hover:bg-secondary_hover">Batal</a>
                            <button type="submit" class="text-sm bg-primary text-secondary px-4 py-2 rounded-md hover:bg-[#ddc79e]">Tambah</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var kecamatanSelect = document.getElementById('kecamatan');
            var kelurahanSelect = document.getElementById('kelurahan');

            kecamatanSelect.addEventListener('change', function () {
                var kecamatanNama = this.value;
                fetchKelurahan(kecamatanNama);
            });

            function fetchKelurahan(kecamatanNama) {
                fetch(`/get-kelurahan/${kecamatanNama}`)
                    .then(response => response.json())
                    .then(data => {
                        kelurahanSelect.disabled = false;
                        kelurahanSelect.innerHTML = '<option value="" disabled selected hidden>Pilih Kelurahan</option>';
                        data.forEach(function(kel) {
                            kelurahanSelect.innerHTML += `<option value="${kel.nama_kel}">${kel.nama_kel}</option>`;
                        });
                    })
                    .catch(error => console.error('Error:', error));
            }
        });
    </script>
@endsection
