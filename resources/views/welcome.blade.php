@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <!-- En-tête avec titre et contrôles -->
        <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
            <div class="flex flex-col lg:flex-row lg:justify-between lg:items-center gap-4">
                <h1 class="text-3xl font-bold text-gray-800">
                    @if(session('langage') == 'fr')
                        Vocabulaire
                    @elseif(session('langage') == 'en')
                        Vocabulary
                    @elseif(session('langage') == 'it')
                        Vocabolario
                    @endif
                </h1>

                <!-- Contrôles de recherche et filtres -->
                <div class="flex flex-col sm:flex-row gap-3">
                    <!-- Recherche -->
                    <div class="relative">
                        <form id="globalSearchForm" class="inline">
                            <input type="text"
                                   id="searchInput"
                                   name="search"
                                   value="{{ request('search') }}"
                                   placeholder="@if(session('langage') == 'fr')Rechercher un mot...@elseif(session('langage') == 'en')Search for a word...@elseif(session('langage') == 'it')Cerca una parola...@endif"
                                   class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent w-full sm:w-64">
                        </form>
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                    </div>

                    <!-- Sélecteur de langue d'apprentissage -->
                    <select id="learningLanguage" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="en" {{ (session('learning_language', 'en') == 'en') ? 'selected' : '' }}>🇺🇸 English</option>
                        <option value="fr" {{ (session('learning_language') == 'fr') ? 'selected' : '' }}>🇫🇷 Français</option>
                        <option value="it" {{ (session('learning_language') == 'it') ? 'selected' : '' }}>🇮🇹 Italiano</option>
                    </select>

                    <!-- Filtre par difficulté -->
                    <select id="difficultyFilter" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">
                            @if(session('langage') == 'fr')
                                Toutes les difficultés
                            @elseif(session('langage') == 'en')
                                All difficulties
                            @elseif(session('langage') == 'it')
                                Tutte le difficoltà
                            @else
                                Toutes les difficultés
                            @endif
                        </option>
                        <option value="1">
                            @if(session('langage') == 'fr')
                                Facile
                            @elseif(session('langage') == 'en')
                                Easy
                            @elseif(session('langage') == 'it')
                                Facile
                            @else
                                Facile
                            @endif
                        </option>
                        <option value="2">
                            @if(session('langage') == 'fr')
                                Normal
                            @elseif(session('langage') == 'en')
                                Normal
                            @elseif(session('langage') == 'it')
                                Normale
                            @else
                                Normal
                            @endif
                        </option>
                        <option value="3">
                            @if(session('langage') == 'fr')
                                Difficile
                            @elseif(session('langage') == 'en')
                                Hard
                            @elseif(session('langage') == 'it')
                                Difficile
                            @else
                                Difficile
                            @endif
                        </option>
                    </select>
                </div>
            </div>

            <!-- Compteur de résultats et info pagination -->
            <div class="mt-4 flex flex-col sm:flex-row sm:justify-between sm:items-center gap-2 text-gray-600">
                <div>
                    <span id="resultsCount">{{ $mots->total() }}</span>
                    @if(session('langage') == 'fr')
                        mot(s) au total
                        @if(request('search'))
                            pour "{{ request('search') }}"
                        @endif
                    @elseif(session('langage') == 'en')
                        word(s) total
                        @if(request('search'))
                            for "{{ request('search') }}"
                        @endif
                    @elseif(session('langage') == 'it')
                        parola/e in totale
                        @if(request('search'))
                            per "{{ request('search') }}"
                        @endif
                    @else
                        mot(s) au total
                        @if(request('search'))
                            pour "{{ request('search') }}"
                        @endif
                    @endif
                </div>
                <div class="text-sm">
                    @if(session('langage') == 'fr')
                        Page {{ $mots->currentPage() }} sur {{ $mots->lastPage() }}
                    @elseif(session('langage') == 'en')
                        Page {{ $mots->currentPage() }} of {{ $mots->lastPage() }}
                    @elseif(session('langage') == 'it')
                        Pagina {{ $mots->currentPage() }} di {{ $mots->lastPage() }}
                    @else
                        Page {{ $mots->currentPage() }} sur {{ $mots->lastPage() }}
                    @endif
                </div>
            </div>
        </div>

        <!-- Grille des cartes de vocabulaire -->
        <div id="vocabularyGrid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach($mots as $mot)
                <div class="vocabulary-card bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition-shadow duration-300"
                     data-difficulty="{{ $mot->difficulte }}"
                     data-name-fr="{{ strtolower($mot->name_fr) }}"
                     data-name-en="{{ strtolower($mot->name_en) }}"
                     data-name-it="{{ strtolower($mot->name_it) }}">

                    <!-- Image -->
                    <div class="h-48 bg-gray-100 overflow-hidden">
                        @if($mot->cheminImg)
                            <img src="{{ asset('textures/' . $mot->cheminImg) }}"
                                 alt="{{ $mot->{'name_' . session('langage', 'fr')} }}"
                                 class="w-full h-full object-cover hover:scale-105 transition-transform duration-300">
                        @else
                            <div class="w-full h-full flex items-center justify-center bg-gray-200">
                                <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                        @endif
                    </div>

                    <!-- Contenu de la carte -->
                    <div class="p-4">
                        <!-- Nom dans la langue d'apprentissage (principal) -->
                        <h3 class="text-lg font-semibold text-blue-600 mb-2 learning-word">
                            <span class="learning-text-en" style="display: {{ session('learning_language', 'en') == 'en' ? 'inline' : 'none' }}">{{ $mot->name_en }}</span>
                            <span class="learning-text-fr" style="display: {{ session('learning_language', 'en') == 'fr' ? 'inline' : 'none' }}">{{ $mot->name_fr }}</span>
                            <span class="learning-text-it" style="display: {{ session('learning_language', 'en') == 'it' ? 'inline' : 'none' }}">{{ $mot->name_it }}</span>
                        </h3>

                        <!-- Traduction dans la langue de la page -->
                        <p class="text-gray-600 font-medium mb-3">
                            {{ $mot->{'name_' . session('langage', 'fr')} }}
                        </p>

                        <!-- Indicateur de difficulté -->
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                            <span class="text-sm text-gray-500 mr-2">
                                @if(session('langage') == 'fr')
                                    Difficulté:
                                @elseif(session('langage') == 'en')
                                    Difficulty:
                                @elseif(session('langage') == 'it')
                                    Difficoltà:
                                @endif
                            </span>
                                <div class="flex">
                                    @for($i = 1; $i <= 3; $i++)
                                        <div class="w-3 h-3 rounded-full mr-1
                                        @if($i <= $mot->difficulte)
                                            @if($mot->difficulte == 1) bg-green-500
                                            @elseif($mot->difficulte == 2) bg-yellow-500
                                            @else bg-red-500
                                            @endif
                                        @else
                                            bg-gray-300
                                        @endif
                                    "></div>
                                    @endfor
                                </div>
                            </div>

                            <!-- Badge de niveau -->
                            <span class="px-2 py-1 text-xs rounded-full font-medium
                            @if($mot->difficulte == 1) bg-green-100 text-green-800
                            @elseif($mot->difficulte == 2) bg-yellow-100 text-yellow-800
                            @else bg-red-100 text-red-800
                            @endif
                        ">
                            @if($mot->difficulte == 1)
                                    @if(session('langage') == 'fr')
                                        Facile
                                    @elseif(session('langage') == 'en')
                                        Easy
                                    @elseif(session('langage') == 'it')
                                        Facile
                                    @else
                                        Facile
                                    @endif
                                @elseif($mot->difficulte == 2)
                                    @if(session('langage') == 'fr')
                                        Normal
                                    @elseif(session('langage') == 'en')
                                        Normal
                                    @elseif(session('langage') == 'it')
                                        Normale
                                    @else
                                        Normal
                                    @endif
                                @else
                                    @if(session('langage') == 'fr')
                                        Difficile
                                    @elseif(session('langage') == 'en')
                                        Hard
                                    @elseif(session('langage') == 'it')
                                        Difficile
                                    @else
                                        Difficile
                                    @endif
                                @endif
                        </span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Message si aucun résultat -->
        <div id="noResults" class="hidden text-center py-12">
            <div class="text-gray-400 text-6xl mb-4">📚</div>
            <h3 class="text-xl font-semibold text-gray-600 mb-2">
                @if(session('langage') == 'fr')
                    Aucun mot trouvé
                @elseif(session('langage') == 'en')
                    No words found
                @elseif(session('langage') == 'it')
                    Nessuna parola trovata
                @endif
            </h3>
            <p class="text-gray-500">
                @if(session('langage') == 'fr')
                    Essayez de modifier vos critères de recherche
                @elseif(session('langage') == 'en')
                    Try adjusting your search criteria
                @elseif(session('langage') == 'it')
                    Prova a modificare i criteri di ricerca
                @endif
            </p>
        </div>

        <!-- Pagination -->
        <div class="mt-8 flex justify-center">
            @php
                // Préserver les paramètres de requête existants pour la pagination
                $currentQuery = request()->query();
            @endphp
            {{ $mots->appends($currentQuery)->links('pagination::tailwind') }}
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('searchInput');
            const difficultyFilter = document.getElementById('difficultyFilter');
            const learningLanguageSelect = document.getElementById('learningLanguage');
            const vocabularyGrid = document.getElementById('vocabularyGrid');
            const noResults = document.getElementById('noResults');
            const resultsCount = document.getElementById('resultsCount');
            const cards = document.querySelectorAll('.vocabulary-card');

            // Fonction de filtrage par difficulté avec préservation des autres paramètres
            function filterByDifficulty() {
                const selectedDifficulty = difficultyFilter.value;
                const url = new URL(window.location.href);

                if (selectedDifficulty) {
                    // Ajouter le paramètre de difficulté
                    url.searchParams.set('difficulte', selectedDifficulty);
                } else {
                    // Supprimer le paramètre de difficulté
                    url.searchParams.delete('difficulte');
                }

                // Reset pagination quand on change de difficulté
                url.searchParams.delete('page');

                window.location.href = url.toString();
            }

            // Fonction de recherche globale (Entrée)
            function globalSearch() {
                const searchTerm = searchInput.value.trim();
                const url = new URL(window.location.href);

                if (searchTerm) {
                    url.searchParams.set('search', searchTerm);
                } else {
                    url.searchParams.delete('search');
                }

                // Reset pagination lors d'une nouvelle recherche
                url.searchParams.delete('page');

                window.location.href = url.toString();
            }

            // Fonction de filtrage local (en temps réel)
            function filterCardsBySearch() {
                const searchTerm = searchInput.value.toLowerCase().trim();
                let visibleCount = 0;
                const totalCards = cards.length;

                // Si une recherche globale est active, ne pas filtrer localement
                if (new URLSearchParams(window.location.search).has('search')) {
                    return;
                }

                cards.forEach(card => {
                    const nameFr = card.dataset.nameFr;
                    const nameEn = card.dataset.nameEn;
                    const nameIt = card.dataset.nameIt;

                    // Vérifier si la recherche correspond
                    const matchesSearch = !searchTerm ||
                        nameFr.includes(searchTerm) ||
                        nameEn.includes(searchTerm) ||
                        nameIt.includes(searchTerm);

                    if (matchesSearch) {
                        card.style.display = 'block';
                        visibleCount++;
                    } else {
                        card.style.display = 'none';
                    }
                });

                // Mettre à jour le compteur pour la recherche locale uniquement
                if (searchTerm && !new URLSearchParams(window.location.search).has('search')) {
                    const originalCount = document.getElementById('resultsCount').getAttribute('data-original') || totalCards;
                    document.getElementById('resultsCount').setAttribute('data-original', originalCount);
                    document.getElementById('resultsCount').textContent = visibleCount;
                } else if (!searchTerm) {
                    const originalCount = document.getElementById('resultsCount').getAttribute('data-original');
                    if (originalCount) {
                        document.getElementById('resultsCount').textContent = originalCount;
                    }
                }

                // Afficher/masquer le message "aucun résultat"
                if (visibleCount === 0 && searchTerm && !new URLSearchParams(window.location.search).has('search')) {
                    vocabularyGrid.style.display = 'none';
                    noResults.classList.remove('hidden');
                } else {
                    vocabularyGrid.style.display = 'grid';
                    noResults.classList.add('hidden');
                }
            }

            // Fonction pour mettre à jour la langue d'apprentissage
            function updateLearningLanguage() {
                const selectedLang = learningLanguageSelect.value;

                // Cacher tous les textes d'apprentissage
                document.querySelectorAll('.learning-text-en, .learning-text-fr, .learning-text-it').forEach(el => {
                    el.style.display = 'none';
                });

                // Afficher les textes dans la langue sélectionnée
                document.querySelectorAll('.learning-text-' + selectedLang).forEach(el => {
                    el.style.display = 'inline';
                });

                // Mettre à jour la session via AJAX
                fetch('/update-learning-language', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ learning_language: selectedLang })
                }).catch(error => {
                    console.error('Erreur lors de la mise à jour de la langue:', error);
                });
            }

            // Événements
            searchInput.addEventListener('input', filterCardsBySearch);
            searchInput.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    globalSearch();
                }
            });

            // Formulaire de recherche
            document.getElementById('globalSearchForm').addEventListener('submit', function(e) {
                e.preventDefault();
                globalSearch();
            });

            difficultyFilter.addEventListener('change', filterByDifficulty);
            learningLanguageSelect.addEventListener('change', updateLearningLanguage);

            // Recherche locale en temps réel avec un léger délai
            let searchTimeout;
            searchInput.addEventListener('input', function() {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(filterCardsBySearch, 300);
            });

            // Initialiser les filtres selon l'URL
            const urlParams = new URLSearchParams(window.location.search);
            const currentDifficulty = urlParams.get('difficulte');
            const currentSearch = urlParams.get('search');

            if (currentDifficulty) {
                difficultyFilter.value = currentDifficulty;
            }

            // Stocker le nombre original pour la recherche locale
            document.getElementById('resultsCount').setAttribute('data-original', '{{ $mots->total() }}');
        });
    </script>

    <style>
        .vocabulary-card {
            transition: transform 0.2s ease-in-out;
        }

        .vocabulary-card:hover {
            transform: translateY(-2px);
        }

        /* Style pixelisé pour les textures Minecraft */
        .pixelated {
            image-rendering: -moz-crisp-edges;
            image-rendering: -webkit-crisp-edges;
            image-rendering: pixelated;
            image-rendering: crisp-edges;
            width: 80px;
            height: 80px;
            object-fit: none;
            object-position: center;
        }

        /* Cadre style Minecraft */
        .minecraft-frame {
            background: linear-gradient(135deg, #8B7355 0%, #A0895C 25%, #8B7355 50%, #6B5B48 75%, #8B7355 100%);
            padding: 4px;
            border: 2px solid #5A4A3A;
            border-radius: 2px;
            box-shadow:
                inset 2px 2px 0px rgba(255, 255, 255, 0.3),
                inset -2px -2px 0px rgba(0, 0, 0, 0.3),
                0 4px 8px rgba(0, 0, 0, 0.2);
            position: relative;
            width: 88px;
            height: 88px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .minecraft-frame::before {
            content: '';
            position: absolute;
            top: 1px;
            left: 1px;
            right: 1px;
            bottom: 1px;
            background: linear-gradient(45deg, rgba(255, 255, 255, 0.1) 0%, transparent 50%);
            pointer-events: none;
        }

        @media (max-width: 640px) {
            .vocabulary-card {
                margin-bottom: 1rem;
            }
        }

        /* Styles pour la pagination Tailwind personnalisée */
        .pagination {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 0.25rem;
        }

        .pagination .page-link {
            @apply px-3 py-2 text-sm text-gray-500 bg-white border border-gray-300 rounded-md hover:bg-gray-100 hover:text-gray-700 transition-colors duration-200;
        }

        .pagination .page-item.active .page-link {
            @apply bg-blue-500 text-white border-blue-500 hover:bg-blue-600;
        }

        .pagination .page-item.disabled .page-link {
            @apply text-gray-300 cursor-not-allowed hover:bg-white hover:text-gray-300;
        }
    </style>
@endsection
