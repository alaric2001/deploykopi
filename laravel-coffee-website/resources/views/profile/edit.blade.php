<x-app-layout>
    
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profile') }} {{ Auth::user()->name_user }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class=" p-4 sm:p-8 bg-white shadow sm:rounded-lg gap-1">
                <h2 class="text-lg font-medium text-gray-900 mb-2">
                    {{ __('Edit Photo Profile') }}
                </h2>
                <div class="flex justify-between items-center">
                    <img class="w-[100px] h-[100px] object-cover rounded-[50%]" src="{{ asset('images/'. Auth::user()->user_foto) }}" alt="">
                    <div class="">
                        <form class="flex flex-col gap-2" action="/edit-pp" id="form_edit_kopi" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="w-[270px]">
                                <input placeholder="{{ Auth::user()->user_foto }}" type="file" name="foto_pp" id="foto_pp" class="p-1 focus:ring-secondary focus:border-secondary w-full shadow-sm sm:text-sm border border-gray-300 rounded-md">
                            </div>
                            @if ($errors->has('foto_pp'))
                                <div class="text-red-600 text-xs my-1">
                                    {{ $errors->first('foto_pp') }} 
                                    {{-- Bukti bayar harus jpg/jpeg/png --}}
                                </div>
                            @endif
                            <x-primary-button class="w-[70px]">{{ __('Save') }}</x-primary-button>
                        </form>
                    </div>
                </div>
                
                
            </div>
            

            <form method="POST" action="{{ route('logout') }}" class="py-2 px-2 font-semibold ">
                @csrf
                <button type="submit" class="w-full py-2 bg-[#baa785] hover:bg-[#82755d] hover:text-[#FFE5B6] rounded-md">Logout</button>
            </form>

            <div class="p-4 sm:p-8 bg-white  shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white  shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white  shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
