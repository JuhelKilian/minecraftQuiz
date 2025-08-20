@extends('layouts.app')

@section('content')
    @php
        $langue = session('langage', 'fr');
        $placeholderSearch = $langue == 'fr' ? 'Rechercher un mot...' : ($langue == 'en' ? 'Search for a word...' : 'Cerca una parola...');
        $tooltipSearch = $langue == 'fr' ? 'Rechercher dans tous les mots' : ($langue == 'en' ? 'Search in all words' : 'Cerca in tutte le parole');
        $titreVocab = $langue == 'fr' ? 'Vocabulaire' : ($langue == 'en' ? 'Vocabulary' : 'Vocabolario');
        $toutesD = $langue == 'fr' ? 'Toutes les difficultés' : ($langue == 'en' ? 'All difficulties' : 'Tutte le difficoltà');
        $facile = $langue == 'fr' ? 'Facile' : ($langue == 'en' ? 'Easy' : 'Facile');
        $normal = $langue == 'fr' ? 'Normal' : ($langue == 'en' ? 'Normal' : 'Normale');
        $difficile = $langue == 'fr' ? 'Difficile' : ($langue == 'en' ? 'Hard' : 'Difficile');
    @endphp

    <div class="container mx-auto px-4 py-8">
        <!-- En-tête avec titre et contrôles -->
        <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
            <div class="flex flex-col lg:flex-row lg:justify-between lg:items-center gap-4">
                <h1 class="text-3xl font-bold text-gray-800" data-translate="vocabulary_title">{{ $titreVocab }}</h1>

                <!-- Contrôles de recherche et filtres -->
                <div class="flex flex-col sm:flex-row gap-3">
                    <!-- Recherche -->
                    <div class="relative">
                        <form id="globalSearchForm" class="inline">
                            <input type="text"
                                   id="searchInput"
                                   name="search"
                                   value="{{ request('search') }}"
                                   placeholder="{{ $placeholderSearch }}"
                                   data-translate="search_placeholder"
                                   class="px-4 py-2 pr-12 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent w-full sm:w-64">
                        </form>
                        <button type="button"
                                id="globalSearchBtn"
                                onclick="globalSearch()"
                                class="absolute inset-y-0 right-0 pr-3 flex items-center hover:bg-gray-100 rounded-r-lg transition-colors duration-200 cursor-pointer group"
                                title="{{ $tooltipSearch }}"
                                data-translate="search_tooltip">
                            <svg class="h-5 w-5 text-gray-400 group-hover:text-blue-500 transition-colors duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </button>
                    </div>

                    <!-- Sélecteur de langue d'apprentissage -->
                    <select id="learningLanguage" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="en" {{ (session('learning_language', 'en') == 'en') ? 'selected' : '' }}>🇺🇸 English</option>
                        <option value="fr" {{ (session('learning_language') == 'fr') ? 'selected' : '' }}>🇫🇷 Français</option>
                        <option value="it" {{ (session('learning_language') == 'it') ? 'selected' : '' }}>🇮🇹 Italiano</option>
                    </select>

                    <!-- Filtre par difficulté -->
                    <select id="difficultyFilter" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="" data-translate="all_difficulties">{{ $toutesD }}</option>
                        <option value="1" data-translate="easy">{{ $facile }}</option>
                        <option value="2" data-translate="normal">{{ $normal }}</option>
                        <option value="3" data-translate="hard">{{ $difficile }}</option>
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
                    <div class="aspect-square bg-gray-100 overflow-hidden">
                        @if($mot->cheminImg)
                            <img src="{{ asset('textures/' . $mot->cheminImg) }}"
                                 alt="{{ $mot->{'name_' . session('langage', 'fr')} }}"
                                 class="w-full h-full object-cover hover:scale-105 transition-transform duration-300 [image-rendering:pixelated]">
                        @else
                            <div class="w-full h-full flex items-center justify-center bg-gray-200">
                                <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
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
                            @switch(session('language', 'fr_fr'))
                                @case('fr_fr')
                                    {{ $mot->name_fr }}
                                    @break
                                @case('en_us')
                                    {{ $mot->name_en }}
                                    @break
                                @case('it_it')
                                    {{ $mot->name_it }}
                                    @break
                                @default
                                    {{ $mot->name_fr }}
                            @endswitch
                        </p>

                        <!-- Indicateur de difficulté -->
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                            <span class="text-sm text-gray-500 mr-2" data-translate="difficulty">
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
            <h3 class="text-xl font-semibold text-gray-600 mb-2" data-translate="no_words_found">
                @if(session('langage') == 'fr')
                    Aucun mot trouvé
                @elseif(session('langage') == 'en')
                    No words found
                @elseif(session('langage') == 'it')
                    Nessuna parola trovata
                @endif
            </h3>
            <p class="text-gray-500" data-translate="try_adjusting">
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

            // Séparation


        const vocabularyTranslations = {
            fr: {
                'vocabulary_title': 'Vocabulaire',
                'search_placeholder': 'Rechercher un mot...',
                'search_tooltip': 'Rechercher dans tous les mots',
                'all_difficulties': 'Toutes les difficultés',
                'easy': 'Facile',
                'normal': 'Normal',
                'hard': 'Difficile',
                'difficulty': 'Difficulté:',
                'words_total': 'mot(s) au total',
                'words_for': 'pour',
                'page_of': 'Page {current} sur {total}',
                'no_words_found': 'Aucun mot trouvé',
                'try_adjusting': 'Essayez de modifier vos critères de recherche'
            },
            en: {
                'vocabulary_title': 'Vocabulary',
                'search_placeholder': 'Search for a word...',
                'search_tooltip': 'Search in all words',
                'all_difficulties': 'All difficulties',
                'easy': 'Easy',
                'normal': 'Normal',
                'hard': 'Hard',
                'difficulty': 'Difficulty:',
                'words_total': 'word(s) total',
                'words_for': 'for',
                'page_of': 'Page {current} of {total}',
                'no_words_found': 'No words found',
                'try_adjusting': 'Try adjusting your search criteria'
            },
            it: {
                'vocabulary_title': 'Vocabolario',
                'search_placeholder': 'Cerca una parola...',
                'search_tooltip': 'Cerca in tutte le parole',
                'all_difficulties': 'Tutte le difficoltà',
                'easy': 'Facile',
                'normal': 'Normale',
                'hard': 'Difficile',
                'difficulty': 'Difficoltà:',
                'words_total': 'parola/e in totale',
                'words_for': 'per',
                'page_of': 'Pagina {current} di {total}',
                'no_words_found': 'Nessuna parola trovata',
                'try_adjusting': 'Prova a modificare i criteri di ricerca'
            }
        };

        // Fonction pour mettre à jour les traductions de la page vocabulaire
        function updateVocabularyTranslations(lang) {
            const currentTranslations = vocabularyTranslations[lang] || vocabularyTranslations.fr;

            // Titre principal - chercher spécifiquement le titre avec l'attribut data-translate
            const titleElement = document.querySelector('h1[data-translate="vocabulary_title"]') || document.querySelector('h1');
            if (titleElement) {
                titleElement.textContent = currentTranslations['vocabulary_title'];
            }

            // Placeholder de recherche
            const searchInput = document.getElementById('searchInput');
            if (searchInput) {
                searchInput.placeholder = currentTranslations['search_placeholder'];
            }

            // Tooltip de recherche
            const searchBtn = document.getElementById('globalSearchBtn');
            if (searchBtn) {
                searchBtn.title = currentTranslations['search_tooltip'];
            }

            // Options de difficulté
            const difficultyFilter = document.getElementById('difficultyFilter');
            if (difficultyFilter) {
                const options = difficultyFilter.options;
                if (options[0]) options[0].textContent = currentTranslations['all_difficulties'];
                if (options[1]) options[1].textContent = currentTranslations['easy'];
                if (options[2]) options[2].textContent = currentTranslations['normal'];
                if (options[3]) options[3].textContent = currentTranslations['hard'];
            }

            // Labels de difficulté dans les cartes
            document.querySelectorAll('.vocabulary-card').forEach(card => {
                // Label "Difficulté:" ou "Difficulty:" ou "Difficoltà:"
                const difficultyLabel = card.querySelector('span[data-translate="difficulty"]');
                if (difficultyLabel) {
                    difficultyLabel.textContent = currentTranslations['difficulty'];
                }

                // Badges de difficulté - chercher par classe et position
                const difficultyBadge = card.querySelector('span.px-2.py-1.text-xs.rounded-full.font-medium');
                if (difficultyBadge && card.dataset.difficulty) {
                    const difficulty = parseInt(card.dataset.difficulty);
                    if (difficulty === 1) {
                        difficultyBadge.textContent = currentTranslations['easy'];
                    } else if (difficulty === 2) {
                        difficultyBadge.textContent = currentTranslations['normal'];
                    } else if (difficulty === 3) {
                        difficultyBadge.textContent = currentTranslations['hard'];
                    }
                }
            });

            // Message "aucun résultat"
            const noResultsTitle = document.querySelector('#noResults h3');
            const noResultsText = document.querySelector('#noResults p');
            if (noResultsTitle) {
                noResultsTitle.textContent = currentTranslations['no_words_found'];
            }
            if (noResultsText) {
                noResultsText.textContent = currentTranslations['try_adjusting'];
            }

            // Compteur de résultats - mettre à jour seulement le texte, pas le nombre
            updateResultsCounter(lang);

            // Pagination - mettre à jour seulement le texte, pas les numéros
            updatePaginationText(lang);
        }

        // Fonction pour mettre à jour le compteur de résultats
        function updateResultsCounter(lang) {
            const currentTranslations = vocabularyTranslations[lang] || vocabularyTranslations.fr;
            const resultsContainer = document.querySelector('.mt-4.flex.flex-col div:first-child');

            if (resultsContainer) {
                const resultsCountElement = document.getElementById('resultsCount');
                const searchTerm = new URLSearchParams(window.location.search).get('search');

                if (resultsCountElement) {
                    const count = resultsCountElement.textContent;
                    let newText = `${count} ${currentTranslations['words_total']}`;

                    if (searchTerm) {
                        newText += ` ${currentTranslations['words_for']} "${searchTerm}"`;
                    }

                    // Remplacer tout le contenu en gardant le nombre
                    const textNodes = Array.from(resultsContainer.childNodes).filter(node => node.nodeType === 3);
                    textNodes.forEach(node => {
                        if (node.textContent.includes('mot') || node.textContent.includes('word') || node.textContent.includes('parola')) {
                            resultsContainer.removeChild(node);
                        }
                    });

                    // Ajouter le nouveau texte
                    const textAfterCount = document.createTextNode(` ${currentTranslations['words_total']}`);
                    resultsCountElement.parentNode.insertBefore(textAfterCount, resultsCountElement.nextSibling);

                    if (searchTerm) {
                        const searchText = document.createTextNode(` ${currentTranslations['words_for']} "${searchTerm}"`);
                        textAfterCount.parentNode.insertBefore(searchText, textAfterCount.nextSibling);
                    }
                }
            }
        }

        // Fonction pour mettre à jour le texte de pagination
        function updatePaginationText(lang) {
            const currentTranslations = vocabularyTranslations[lang] || vocabularyTranslations.fr;
            const paginationInfo = document.querySelector('.mt-4.flex.flex-col div:last-child');

            if (paginationInfo) {
                const text = paginationInfo.textContent;
                // Extraire les numéros avec une regex
                const match = text.match(/(\d+).*(\d+)/);
                if (match) {
                    const [, current, total] = match;
                    const newText = currentTranslations['page_of']
                        .replace('{current}', current)
                        .replace('{total}', total);
                    paginationInfo.textContent = newText;
                }
            }
        }

        // Écouter les changements de langue depuis la navigation
        document.addEventListener('DOMContentLoaded', function() {
            // Fonction pour détecter les changements de langue
            function handleLanguageChange() {
                // Obtenir la langue actuelle depuis la session Laravel
                let currentLanguage = @json(session('language', 'fr_fr'));

                const sessionToJsLang = {
                    'fr_fr': 'fr',
                    'en_us': 'en',
                    'it_it': 'it'
                };

                const currentLang = sessionToJsLang[currentLanguage] || 'fr';

                // Appliquer les traductions
                updateVocabularyTranslations(currentLang);
            }

            // Appliquer les traductions initiales
            handleLanguageChange();

            // Observer les changements dans le localStorage pour détecter les changements de langue
            let lastLang = localStorage.getItem('preferredLanguage');
            setInterval(() => {
                const currentLang = localStorage.getItem('preferredLanguage');
                if (currentLang && currentLang !== lastLang) {
                    lastLang = currentLang;
                    updateVocabularyTranslations(currentLang);
                }
            }, 100);

            // Alternative : écouter l'événement storage (fonctionne entre onglets)
            window.addEventListener('storage', function(e) {
                if (e.key === 'preferredLanguage' && e.newValue) {
                    updateVocabularyTranslations(e.newValue);
                }
            });
        });

        // Rendre la fonction disponible globalement si nécessaire
        window.updateVocabularyTranslations = updateVocabularyTranslations;
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
