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
                        {{-- <th>Action</th> --}}
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

                        {{-- <td class="w-8">
                            <div>
                                <div class="flex gap-2">
                                    <a class="rounded-md text-white text-xs bg-yellow-500 p-2 px-4 edit-button" href="" data-id="{{ $item->id }}" data-nama="{{ $item->nama_rasa }}" data-kopi="{{ $item->kopi->id }}">
                                        Edit
                                    </a>
                                    <form action="/delete_rasa/{{ $item->id }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button class="rounded-md text-white text-xs bg-red-500 p-2" 
                                                onclick="return confirm('Anda yakin akan menghapus Rasa {{ $item->nama_rasa }}?')">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </td> --}}
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    
@endsection