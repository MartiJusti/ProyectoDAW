@extends('layout')

@section('title', 'Perfil de Usuario')

@section('content')
    <div class="container mx-auto py-8 px-4">
        <div id="account-info" class="max-w-md mx-auto bg-white shadow-md rounded-md overflow-hidden">
            <div class="p-6 space-y-6 md:space-y-10">
                <div class="flex flex-col space-y-6 md:space-y-14">
                    <div>
                        <div class="flex justify-center">
                            <img src="{{ asset('storage/img/avatar.png') }}" alt="Avatar Image" class="h-14 md:h-20">
                        </div>
                        <div class="flex flex-col items-center">
                            <span id="name" class="font-bold text-base md:text-lg"></span>
                            <span id="username" class="text-gray-600 text-sm md:text-base"></span>
                        </div>
                    </div>
                    <div class="space-y-2 md:space-y-3">
                        <div class="flex items-center">
                            <i class="fa-solid fa-at"></i>
                            <span id="email" class="w-2/3 text-gray-800 ml-2 text-sm md:text-base"></span>
                        </div>
                        <div class="flex items-center">
                            <i class="fa-solid fa-cake-candles"></i>
                            <span id="birthday" class="w-2/3 text-gray-800 ml-3 text-sm md:text-base"></span>
                        </div>
                    </div>

                    <div class="flex flex-col md:flex-row gap-3 md:gap-0 items-end justify-end space-x-2">
                        <a id="edit-link" href="{{route('users.account-edit')}}"
                            class="bg-yellow-500 hover:bg-[#d9a507] text-white py-1 px-3 md:py-2 md:px-4 rounded-xl focus:outline-none cursor-pointer">
                            Editar cuenta
                        </a>
                        <button id="delete-btn"
                            class="bg-red-500 text-white py-1 px-3 md:py-2 md:px-4 rounded-xl hover:bg-red-600 focus:outline-none">
                            Borrar cuenta
                        </button>
                    </div>
                    <div>
                        <div id="tasks-scores"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection

@section('scripts')
    @vite('resources/js/user/account.js')
@endsection
