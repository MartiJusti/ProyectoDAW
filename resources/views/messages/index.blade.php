@extends('layout')

@section('title', 'Mensajes')

@section('content')
    <div class="max-w-md mx-auto p-4 bg-white rounded-lg shadow-lg mt-10">
        <div id="users-list"></div>
    </div>
@endsection

@section('scripts')
    @vite('resources/js/messages/index.js')
@endsection
