@extends('layout')

@section('title', 'Usuario')

@section('content')
    <div class="container mx-auto py-8 px-4">
        <div class="max-w-md mx-auto bg-white shadow-md rounded-md overflow-hidden">
            <div class="p-6 space-y-6 md:space-y-10">
                <div class="flex flex-col space-y-6 md:space-y-14">
                    <div>
                        <div class="flex justify-center">
                            <img src="{{ asset('storage/img/avatar.png') }}" alt="Avatar Image" class="h-14 md:h-20">
                        </div>
                        <div class="flex flex-col items-center">
                            <span id="name" class="font-bold text-base md:text-lg">{{ $user->name }}</span>
                            <span id="username" class="text-gray-600 text-sm md:text-base">{{ $user->username }}</span>
                        </div>
                    </div>
                    <div class="space-y-2 md:space-y-3">
                        <div class="flex items-center">
                            <i class="fa-solid fa-at"></i>
                            <span id="email"
                                class="w-2/3 text-gray-800 ml-2 text-sm md:text-base">{{ $user->email }}</span>
                        </div>
                        <div class="flex items-center">
                            <i class="fa-solid fa-cake-candles"></i>
                            <span id="birthday"
                                class="w-2/3 text-gray-800 ml-3 text-sm md:text-base">{{ \Carbon\Carbon::parse($user->birthday)->format('d/m/Y') }}</span>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-100 p-4 rounded-lg">
                    @if ($user->tasks->isEmpty())
                        <p class="text-gray-500 text-sm md:text-base">No hay tareas disponibles.</p>
                    @else
                        <h2 class="font-semibold mb-2 text-sm md:text-base">
                            @if ($user->rol == 'participant')
                                Tareas del usuario:
                            @else
                                Tareas que supervisa:
                            @endif
                        </h2>
                        <ol class="list-decimal pl-6 space-y-1 md:space-y-2 text-sm md:text-base">
                            @foreach ($user->tasks as $task)
                                <li>
                                    <span class="font-bold">{{ $task->name }}</span>
                                    @if ($user->rol == 'participant')
                                        @php
                                            $score = $task->scores->where('user_id', $user->id)->first();
                                        @endphp
                                        - Puntuación:
                                        @if ($score)
                                            <span class="font-bold">{{ $score->points }}</span>
                                        @else
                                            <span class="font-bold">0</span>
                                        @endif
                                    @endif

                                </li>
                            @endforeach
                        </ol>
                    @endif
                </div>
            </div>
        </div>
    </div>


@endsection

@section('scripts')
    {{-- @vite('resources/js/user/show.js') --}}
@endsection
