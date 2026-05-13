{{-- <table class="w-[300px] border-none">
    <tbody class=" border-none">
        <tr>
            <td class="font-bold border-none">Stok Gula</td>
            <td class="border-none">
                <div class="flex flex-row items-center gap-1">
                    <button id="activateGulaButton" class="rounded-md text-sm text-white bg-green-500 py-1 px-2 hover:bg-green-600">
                        Tersedia
                    </button>
                    <button id="deactivateGulaButton" class="rounded-md text-sm text-white bg-red-500 py-1 px-5 hover:bg-red-600">
                        Habis
                    </button>
                </div>
            </td>
        </tr>
        <tr>
            <td class="font-bold border-none">Stok Susu</td>
            <td class="border-none">
                <div class="flex flex-row items-center gap-1">
                    <button id="activateSusuButton" class="rounded-md text-sm text-white bg-green-500 py-1 px-2 hover:bg-green-600">
                        Tersedia
                    </button>
                    <button id="deactivateSusuButton" class="rounded-md text-sm text-white bg-red-500 py-1 px-5 hover:bg-red-600">
                        Habis
                    </button>
                </div>
            </td>
        </tr>
        <tr>
            <td class="font-bold border-none">Stok Krimer</td>
            <td class="border-none">
                <div class="flex flex-row items-center gap-1">
                    <button id="activateKrimerButton" class="rounded-md text-sm text-white bg-green-500 py-1 px-2 hover:bg-green-600">
                        Tersedia
                    </button>
                    <button id="deactivateKrimerButton" class="rounded-md text-sm text-white bg-red-500 py-1 px-5 hover:bg-red-600">
                        Habis
                    </button>
                </div>
            </td>
        </tr>
    </tbody>
</table> --}}

<table class="w-[300px] border-none">

    @foreach ($rawingredient as $data)
        @php
            $ingredientItem = $bahan_bahan->where('rawingredient_id', $data->id)->first();
        @endphp

        <tbody class=" border-none">
            {{-- Optional berfungsi seperti PLUCK untuk mengambil nilai dari kolom tertentu dalam sebuah koleksi data--}}
            @if (optional($ingredientItem)->rawingredient_id)
                <tr>
                    <td class="font-bold border-none">
                        {{ $data->nama }} Orderable
                    </td>
                    <td class="border-none">
                        <div class="flex flex-row items-center gap-1">
                            <button id="activate{{ $data->id }}Button" class="rounded-md text-sm text-white {{ optional($ingredientItem)->available == 1  ? 'bg-green-500 hover:bg-green-600' : 'bg-green-300' }} py-1 px-4">
                                Yes
                            </button>
                            <button id="deactivate{{ $data->id }}Button" class="rounded-md text-sm text-white  py-1 px-4 {{ optional($ingredientItem)->available != 1 ? 'bg-red-500 hover:bg-red-600' : 'bg-red-300' }}">
                                No
                            </button>
                        </div>
                    </td>
                </tr>
            @endif
        </tbody>
    @endforeach
</table> 

<script>
@foreach ($rawingredient as $data)
        @php
            $ingredientItem = $bahan_bahan->where('rawingredient_id', $data->id)->first();
        @endphp
        @if (optional($ingredientItem)->rawingredient_id)
            document.getElementById('activate{{ $data->id }}Button').addEventListener('click', function() {
                fetch('/update_stok_ingredient', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ rawingredient_id: {{ $data->id }}, status: 1 })
                }).then(response => {
                    if (response.ok) {
                        window.location.reload();
                    }
                });
            });

            document.getElementById('deactivate{{ $data->id }}Button').addEventListener('click', function() {
                fetch('/update_stok_ingredient', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ rawingredient_id: {{ $data->id }}, status: 2 })
                }).then(response => {
                    if (response.ok) {
                        window.location.reload();
                    }
                });
            });
        @endif
    @endforeach
</script>
    

{{-- <script>
    document.getElementById('activateGulaButton').addEventListener('click', function() {
        fetch('/update_stok_ingredient', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ nama_bahan: 'Gula', status: 1 })
        }).then(response => {
            if (response.ok) {
                window.location.reload();
            }
        });
    });

    document.getElementById('deactivateGulaButton').addEventListener('click', function() {
        fetch('/update_stok_ingredient', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ nama_bahan: 'Gula', status: 2 })
        }).then(response => {
            if (response.ok) {
                window.location.reload();
            }
        });
    });
</script>

<script>
    document.getElementById('activateSusuButton').addEventListener('click', function() {
        fetch('/update_stok_ingredient', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ nama_bahan: 'Susu', status: 1 })
        }).then(response => {
            if (response.ok) {
                window.location.reload();
            }
        });
    });

    document.getElementById('deactivateSusuButton').addEventListener('click', function() {
        fetch('/update_stok_ingredient', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ nama_bahan: 'Susu', status: 2 })
        }).then(response => {
            if (response.ok) {
                window.location.reload();
            }
        });
    });
</script>

<script>
    document.getElementById('activateKrimerButton').addEventListener('click', function() {
        fetch('/update_stok_ingredient', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ nama_bahan: 'Krimer', status: 1 })
        }).then(response => {
            if (response.ok) {
                window.location.reload();
            }
        });
    });

    document.getElementById('deactivateKrimerButton').addEventListener('click', function() {
        fetch('/update_stok_ingredient', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ nama_bahan: 'Krimer', status: 2 })
        }).then(response => {
            if (response.ok) {
                window.location.reload();
            }
        });
    });
</script> --}}