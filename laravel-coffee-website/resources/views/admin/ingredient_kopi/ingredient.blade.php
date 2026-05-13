@extends('layouts/admin')

@section('admin-content')

    <div class="admin-container">
        <p class="text-2xl font-semibold">Manajemen Ingredient Kopi Display in Menu</p>

        <div class="flex justify-end">
            <button id="openModalButton" class="rounded-md text-secondary border-secondary border font-medium text-xs bg-primary p-2 px-4 hover:bg-[#ddc79e]">
                + Add Ingredient To Menu
            </button>
        </div>

        {{-- Tombol untuk mengatur orderable menu berdasarkan Ingredient --}}
        @include('admin.ingredient_kopi.btn_ingredient_orderable')

        <div class="flex mt-4">
            <table>
                <thead>
                    <tr class="bg-primary">
                        <th class="w-5">No</th>
                        <th>Ingredients</th>
                        <th>Menu Kopi</th>
                        <th class="w-36">Menu Orderable</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody class="bg-white">
                    @foreach ($bahan_bahan as $index => $item)
                        <tr>
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td>{{ $item->raw_ingredient->nama }}</td>
                            <td>{{ $item->kopi->jenis_kopi }}</td>
                            <td>{{ $item->available == 1 ? 'Yes' : 'No' }}</td>
                            <td class="w-8">
                                <div class="flex gap-2">
                                    <a class="rounded-md text-white text-xs bg-yellow-500 p-2 px-4 edit-bahan-button" href="" data-id_bahan="{{ $item->id }}" 
                                        data-nama_bahan="{{ $item->nama_bahan }}" data-nama_kopi="{{ $item->kopi->id }}"
                                        data-ingredient='{{ $item->raw_ingredient->id }}'>
                                        Edit
                                    </a>
                                    <form action="/delete-ingredient/{{ $item->id }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button class="rounded-md text-white text-xs bg-red-500 p-2" 
                                                onclick="return confirm('Anda yakin akan menghapus Ingredient {{ $item->raw_ingredient->nama }} pada Menu {{ $item->kopi->jenis_kopi }}?')">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    @include('admin.ingredient_kopi.modal_ingredient')
@endsection