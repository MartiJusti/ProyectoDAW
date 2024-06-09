@extends('layout')

@section('title', 'Calendario')

@section('styles')
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.css" rel="stylesheet">
    @vite('resources/css/calendar/style.css')
@endsection

@section('content')
    <div class="max-w-4xl mx-auto mt-8">
        <div id="calendar" class="p-4 bg-white rounded-2xl shadow-xl"></div>
    </div>
@endsection

@section('scripts')
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.js'></script>
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/locales-all.min.js'></script>

    @vite('resources/js/calendar/index.js')
@endsection
