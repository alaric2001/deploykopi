@section('Title', 'Registration')
<x-guest-layout>
    <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
        @csrf

        <!-- Name -->
        {{-- <div>
            <x-input-label for="name" :value="__('Nickname')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name"/>
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div> --}}

        <div class="flex gap-2 justify-between mt-4">
            {{-- Nickname --}}
            <div>
                <x-input-label for="name" :value="__('Nickname')" />
                {{-- <label for='nickname' class="block font-medium text-sm text-gray-700  ">Nickname</label> --}}
                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name"/>
                <x-input-error :messages="$errors->get('name')" class="mt-1" />
            </div>

            {{-- Jenis Kelamin --}}
            <div class="">
                <label for='user_jenis_kelamin' class="block font-medium text-sm text-gray-700  ">Jenis Kelamin</label>
                {{-- <input type="text" name='user_jenis_kelamin' class="border-gray-300       focus:border-indigo-500 focus:ring-indigo-500  rounded-md shadow-sm block mt-1 w-full"> --}}
                <select name="jk" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" id="" required>
                    <option value="" disabled selected hidden></option>
                    <option value="Laki-Laki">Laki-laki</option>
                    <option value="Perempuan">Perempuan</option>
                    {{-- <option value="Perempuan">Bigender</option>
                    <option value="Perempuan">Transgender</option>
                    <option value="Perempuan">Genderfluid</option> --}}
                </select>
            </div>
        </div>
        

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-1" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-1" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="mt-4">
            <label for='no_hp' class="block font-medium text-sm text-gray-700  ">Nomor Telp</label>
            <input type="number" name='no_hp' required class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full">
        </div>

        <div class="mt-4">
            <label for='user_foto' class="block font-medium text-sm text-gray-700  ">Foto Profile</label>
            <input type="file" name='user_foto' required class="p-1 border border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full">
            @if ($errors->has('user_foto'))
                <div class="text-red-600 text-xs my-1">
                    {{ $errors->first('user_foto') }} 
                    {{-- Bukti bayar harus jpg/jpeg/png --}}
                </div>
            @endif
        </div>

        {{-- <div class="mt-4">
            <label for='alamat' class="block font-medium text-sm text-gray-700  ">Alamat</label>
            <textarea name="alamat" id="" cols="30" rows="" required class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full"></textarea>
        </div> --}}

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
