@extends('layouts/admin')

@section('admin-content')
    <div class="admin-container">
        <p class="text-2xl font-semibold">Jenis Kopi In Menu</p>

        <div class="flex justify-end">
            <button id="openModalButton" class="rounded-md text-secondary border-secondary border font-medium text-xs bg-primary p-2 px-4 hover:bg-[#ddc79e]">
                + Add Jenis Kopi To Menu
            </button>
        </div>

        {{-- Tombol untuk mengatur orderable menu berdasarkan jenis kopi --}}
        @include('admin.jenis_kopi.btn_jeniskopi_orderable')

        <div class="flex mt-4">
            <table>
                <thead>
                    <tr class="bg-primary">
                        <th class="w-5">No</th>
                        <th>Jenis Kopi</th>
                        <th>Menu</th>
                        <th class="w-36">Menu Orderable</th>
                        {{-- <th class="w-36">Stok Jenis Kopi</th> --}}
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody class="bg-white">
                    @foreach ($jeniskopi as $index => $item)
                    <tr>
                        <td class="text-center">{{ $index + 1 }}</td>
                        {{-- <td>{{ $item->nama_jenis }}</td> --}}
                        <td>{{ $item->raw_jeniskopi ? $item->raw_jeniskopi->nama : 'Tidak Ada data' }}</td>
                        <td>{{ $item->kopi->jenis_kopi }}</td>
                        <td>
                            <div class="flex justify-center">
                                {{ $item->ready == 1 ? 'Yes' : 'No' }}
                            </div>
                        </td>
                        {{-- <td>
                            <div class="flex justify-center">
                                {{ $item->raw_jeniskopi->stok }}
                            </div>
                        </td> --}}
                        <td class="w-8">
                            <div class="flex gap-2">
                                <a class="rounded-md text-white text-xs bg-yellow-500 p-2 px-4 edit-button" href="" data-id="{{ $item->id }}" 
                                    data-nama="{{ $item->nama_jenis }}" data-jeniskopi="{{ $item->raw_jeniskopi->id }}" 
                                    data-kopi="{{ $item->kopi->id }}">
                                    Edit
                                </a>
                                <form action="/delete_jenis/{{ $item->id }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button class="rounded-md text-white text-xs bg-red-500 p-2" 
                                            onclick="return confirm('Anda yakin akan menghapus Jenis Kopi {{ $item->nama_jenis }} pada Menu {{ $item->kopi->jenis_kopi }}?')">
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
    @include('admin.jenis_kopi.modal_jeniskopi')
    
@endsection