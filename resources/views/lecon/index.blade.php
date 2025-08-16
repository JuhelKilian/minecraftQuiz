@extends('layouts.app')

@section('content')
    <div class="flex flex-col items-center justify-center min-h-screen bg-gray-100 dark:bg-[#1b1b18]">
        <div class="bg-white dark:bg-[#2b2b28] p-8 rounded-xl shadow-lg max-w-lg text-center">
            <h1 class="text-3xl font-bold mb-6 text-gray-900 dark:text-white">Faire une leçon</h1>
            <p class="text-gray-700 dark:text-gray-300 mb-4">
                Ici, tu pourras bientôt lancer des exercices interactifs pour apprendre le vocabulaire de Minecraft en italien 🇮🇹.
            </p>
            <a href="{{ route('vocabulaire.index') }}"
               class="inline-block mt-4 px-6 py-3 rounded-xl bg-[#1b1b18] text-white dark:bg-[#EDEDEC] dark:text-[#1b1b18] hover:opacity-90 transition">
                Revenir au vocabulaire
            </a>
        </div>
    </div>
@endsection
