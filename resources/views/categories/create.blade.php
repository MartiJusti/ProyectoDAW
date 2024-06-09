@extends('layout')

@section('title', 'Crear categoría')

@section('content')
    <div class="min-h-screen flex items-center justify-center py-12 px-4 md:px-8">
        <div class="max-w-md w-full space-y-8">
            <div></div>
            <div>
                <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
                    Nueva categoría
                </h2>
            </div>
            <form id="category-form" class="mt-8 space-y-6">
                @csrf
                <div class="rounded-md shadow-sm -space-y-px">
                    <div class="mb-4">
                        <label for="name" class="sr-only">Nombre de Categoría</label>
                        <input id="name" name="name" type="text" required
                            class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-t-lg focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 text-sm"
                            placeholder="Categoría">
                    </div>
                    <div>
                        <label for="description" class="sr-only">Descripción</label>
                        <input id="description" name="description" type="text" required
                            class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-b-lg focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 text-sm"
                            placeholder="Descripción">
                    </div>
                </div>

                <div>
                    <button id="category-btn" type="submit"
                        class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-2xl text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Añadir categoría
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    @vite('resources/js/categories/create.js')
@endsection
