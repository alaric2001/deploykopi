@extends('layouts/admin')

@section('admin-content')
    <div class="admin-container">
        <p class="text-2xl font-semibold">Manajemen Nama dan Stok Ingredient Kopi</p>

        <div class="flex justify-end">
            <button id="openModalButton" class="rounded-md text-secondary border-secondary border font-medium text-xs bg-primary p-2 px-4 hover:bg-[#ddc79e]">
                + Tambah Ingredient Kopi
            </button>
        </div>

        <div class="flex mt-4">
            <table>
                <thead>
                    <tr class="bg-primary">
                        <th class="w-5">No</th>
                        <th>Nama Ingredient Kopi</th>
                        <th class="w-24">Stok</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody class="bg-white">
                    @foreach ($raw_ingredient as $index => $item)
                        <tr>
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td>{{ $item->nama }}</td>
                            <td>
                                <div class="flex justify-center">
                                    {{ $item->stok }}
                                </div>
                            </td>
                            <td class="w-8">
                                <div class="flex gap-2">
                                    <a class="rounded-md text-white text-xs bg-yellow-500 p-2 px-4 edit-button" href="" data-id="{{ $item->id }}" data-nama="{{ $item->nama }}" data-stokingredient="{{ $item->stok }}">
                                        Edit
                                    </a>
                                    <form action="/delete-rawingredient/{{ $item->id }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button class="rounded-md text-white text-xs bg-red-500 p-2" 
                                                onclick="return confirm('Anda yakin akan menghapus Ingredient {{ $item->nama }}?')">
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

    <!-- Modal -->
    @include('admin.ingredient_kopi.modal_raw_ingredient')
@endsection