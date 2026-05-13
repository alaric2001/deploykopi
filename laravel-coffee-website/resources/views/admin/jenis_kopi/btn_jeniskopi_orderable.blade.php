<div class="flex flex-col mt-4 gap-2">
    {{-- <div class="flex flex-row items-center gap-1">
        <p class="font-bold text-lg mr-2">Robusta Orderable</p>
        <button id="activateRobustaButton" class="rounded-md text-sm text-white bg-green-500 py-1 px-4 hover:bg-green-600">
            Yes
        </button>
        <button id="deactivateRobustaButton" class="rounded-md text-sm text-white bg-red-500 py-1 px-4 hover:bg-red-600">
            No
        </button>
    </div>

    <div class="flex flex-row items-center gap-1">
        <p class="font-bold text-lg mr-3">Arabica Orderable</p>

        <button id="activateArabicaButton" class="rounded-md text-sm text-white bg-green-500 py-1 px-4 hover:bg-green-600">
            Yes
        </button>
        <button id="deactivateArabicaButton" class="rounded-md text-sm text-white bg-red-500 py-1 px-4 hover:bg-red-600">
            No
        </button>
    </div> --}}

    {{-- @if($jeniskopi->first()->nama_jenis == 'Robusta') --}}

    <table class="w-[300px] border-none">

        @foreach ($rawjeniskopi as $data)
            @php
                $jenisKopiItem = $jeniskopi->where('id_rawjeniskopi', $data->id)->first();
            @endphp

            <tbody class=" border-none">
                @if (optional($jenisKopiItem)->id_rawjeniskopi)
                    <tr>
                        <td class="font-bold border-none">
                            {{ $data->nama }} Orderable
                        </td>
                        <td class="border-none">
                            <div class="flex flex-row items-center gap-1">
                                <button id="activate{{ $data->id }}Button" class="rounded-md text-sm text-white {{ optional($jenisKopiItem)->ready == 1  ? 'bg-green-500 hover:bg-green-600' : 'bg-green-300' }} py-1 px-4">
                                    Yes
                                </button>
                                <button id="deactivate{{ $data->id }}Button" class="rounded-md text-sm text-white  py-1 px-4 {{ optional($jenisKopiItem)->ready != 1 ? 'bg-red-500 hover:bg-red-600' : 'bg-red-300' }}">
                                    No
                                </button>
                            </div>
                        </td>
                    </tr>
                @endif
            </tbody>
        @endforeach
    </table>   
    
    {{-- @foreach ($rawjeniskopi as $data)
        @php
            $jenisKopiItem = $jeniskopi->where('id_rawjeniskopi', $data->id)->first();
        @endphp
        @if (optional($jenisKopiItem)->id_rawjeniskopi)
            <div class="flex flex-row items-center gap-1">
                <p class="font-bold text-lg mr-2">{{ $data->nama }} Orderable</p>
                <button id="activate{{ $data->id }}Button" class="rounded-md text-sm text-white {{ optional($jenisKopiItem)->ready == 1  ? 'bg-green-500 hover:bg-green-600' : 'bg-green-300' }} py-1 px-4">
                    Yes
                </button>
                <button id="deactivate{{ $data->id }}Button" class="rounded-md text-sm text-white  py-1 px-4 {{ optional($jenisKopiItem)->ready != 1 ? 'bg-red-500 hover:bg-red-600' : 'bg-red-300' }}">
                    No
                </button>
            </div>
        @endif
        
    @endforeach --}}
    
    
</div>

<script>
    // document.getElementById('activateRobustaButton').addEventListener('click', function() {
    //     fetch('/update_jenis_kopi_status', {
    //         method: 'POST',
    //         headers: {
    //             'Content-Type': 'application/json',
    //             'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
    //         },
    //         // body: JSON.stringify({ nama_jenis: 'Robusta', status: 1 })
    //         body: JSON.stringify({ id_rawjeniskopi: 1, status: 1 })
    //     }).then(response => {
    //         if (response.ok) {
    //             window.location.reload();
    //         }
    //     });
    // });

    // document.getElementById('deactivateRobustaButton').addEventListener('click', function() {
    //     fetch('/update_jenis_kopi_status', {
    //         method: 'POST',
    //         headers: {
    //             'Content-Type': 'application/json',
    //             'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
    //         },
    //         body: JSON.stringify({ id_rawjeniskopi: 1, status: 2 })
    //     }).then(response => {
    //         if (response.ok) {
    //             window.location.reload();
    //         }
    //     });
    // });

    // document.getElementById('activateArabicaButton').addEventListener('click', function() {
    //     fetch('/update_jenis_kopi_status', {
    //         method: 'POST',
    //         headers: {
    //             'Content-Type': 'application/json',
    //             'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
    //         },
    //         body: JSON.stringify({ id_rawjeniskopi: 2, status: 1 })
    //     }).then(response => {
    //         if (response.ok) {
    //             window.location.reload();
    //         }
    //     });
    // });

    // document.getElementById('deactivateArabicaButton').addEventListener('click', function() {
    //     fetch('/update_jenis_kopi_status', {
    //         method: 'POST',
    //         headers: {
    //             'Content-Type': 'application/json',
    //             'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
    //         },
    //         body: JSON.stringify({ id_rawjeniskopi: 2, status: 2 })
    //     }).then(response => {
    //         if (response.ok) {
    //             window.location.reload();
    //         }
    //     });
    // });
    
    @foreach ($rawjeniskopi as $data)
        @php
            $jenisKopiItem = $jeniskopi->where('id_rawjeniskopi', $data->id)->first();
        @endphp
        @if (optional($jenisKopiItem)->id_rawjeniskopi)
            document.getElementById('activate{{ $data->id }}Button').addEventListener('click', function() {
                fetch('/update_jenis_kopi_status', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ id_rawjeniskopi: {{ $data->id }}, status: 1 })
                }).then(response => {
                    if (response.ok) {
                        window.location.reload();
                    }
                });
            });

            document.getElementById('deactivate{{ $data->id }}Button').addEventListener('click', function() {
                fetch('/update_jenis_kopi_status', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ id_rawjeniskopi: {{ $data->id }}, status: 2 })
                }).then(response => {
                    if (response.ok) {
                        window.location.reload();
                    }
                });
            });
        @endif
    @endforeach
</script>
