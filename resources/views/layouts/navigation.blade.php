<header class="w-full border-b border-gray-200 dark:border-gray-700 px-4 sm:px-6 lg:px-8 py-4 relative bg-white/50 dark:bg-black/50 backdrop-blur-sm">
    <div class="flex justify-between items-center">
        <!-- Titre -->
        <h1 class="text-2xl sm:text-3xl font-semibold title-gradient">
            <a href="{{ route('home') }}" data-translate="site-title">Quiz Minecraft</a>
        </h1>

        <!-- Navigation desktop -->
        <nav class="hidden lg:flex items-center gap-3 text-sm">
            <a href="{{ route('home') }}" class="px-4 py-2 rounded-lg border border-gray-200 dark:border-gray-700 hover:border-gray-300 dark:hover:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-all duration-200 soft-shadow {{ request()->routeIs('home') ? 'bg-gray-100 dark:bg-gray-800' : '' }}" data-translate="nav-home">
                Accueil
            </a>
            <a href="/vocabulaire" class="px-4 py-2 rounded-lg border border-gray-200 dark:border-gray-700 hover:border-gray-300 dark:hover:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-all duration-200 soft-shadow" data-translate="nav-vocabulary">
                Vocabulaire
            </a>

            @auth
                <a href="/lecon/1" class="px-4 py-2 rounded-lg border border-transparent hover:border-gray-200 dark:hover:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-all duration-200" data-translate="nav-lecon1">
                    Leçon 1
                </a>
                <a href="/lecon/2" class="px-4 py-2 rounded-lg border border-transparent hover:border-gray-200 dark:hover:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-all duration-200" data-translate="nav-lecon2">
                    Leçon 2
                </a>
                <a href="{{ route('profile.edit') }}" class="px-4 py-2 rounded-lg border border-transparent hover:border-gray-200 dark:hover:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-all duration-200" data-translate="nav-compte">
                    Mon compte
                </a>

                <!-- Bouton de déconnexion -->
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="px-3 py-2 rounded-lg border border-red-200 dark:border-red-700 hover:border-red-300 dark:hover:border-red-600 hover:bg-red-50 dark:hover:bg-red-900/20 text-red-600 dark:text-red-400 hover:text-red-700 dark:hover:text-red-300 transition-all duration-200 flex items-center gap-2" title="Déconnexion" data-translate="nav-logout">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                        </svg>
                    </button>
                </form>
            @endauth

            @guest
                <a href="{{ route('login') }}" class="px-4 py-2 rounded-lg border border-transparent hover:border-gray-200 dark:hover:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-all duration-200" data-translate="nav-login">
                    Connexion
                </a>
                <a href="{{ route('register') }}" class="px-4 py-2 rounded-lg border border-[#1b1b18] dark:border-[#EDEDEC] hover:bg-[#1b1b18] dark:hover:bg-[#EDEDEC] hover:text-[#FDFDFC] dark:hover:text-[#1b1b18] transition-all duration-200" data-translate="nav-register">
                    Inscription
                </a>
            @endguest

            <!-- Sélecteur de langue -->
            <div class="relative">
                <button id="language-button" class="px-3 py-2 rounded-lg border border-gray-200 dark:border-gray-700 hover:border-gray-300 dark:hover:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-all duration-200 flex items-center gap-2">
                    <span class="flag-emoji" id="current-flag">🇫🇷</span>
                    <span id="current-lang">FR</span>
                    <svg class="w-4 h-4 transition-transform duration-200" id="language-chevron" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>

                <div id="language-dropdown" class="absolute top-full right-0 mt-2 language-dropdown bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-lg shadow-lg backdrop-blur-sm menu-transition transform origin-top-right scale-95 opacity-0 invisible z-50">
                    <div class="p-1">
                        <button class="language-option w-full px-3 py-2 rounded-md hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors duration-150 text-left" data-lang="fr">
                            <span class="flag-emoji">🇫🇷</span>
                            <span>Français</span>
                        </button>
                        <button class="language-option w-full px-3 py-2 rounded-md hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors duration-150 text-left" data-lang="en">
                            <span class="flag-emoji">🇬🇧</span>
                            <span>English</span>
                        </button>
                        <button class="language-option w-full px-3 py-2 rounded-md hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors duration-150 text-left" data-lang="it">
                            <span class="flag-emoji">🇮🇹</span>
                            <span>Italiano</span>
                        </button>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Bouton hamburger -->
        <button id="mobile-menu-button" class="lg:hidden flex items-center justify-center w-10 h-10 rounded-lg border border-gray-300 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-all duration-200">
            <div class="hamburger">
                <span class="hamburger-line line-1 block w-5 h-0.5 bg-gray-600 dark:bg-gray-300 mb-1"></span>
                <span class="hamburger-line line-2 block w-5 h-0.5 bg-gray-600 dark:bg-gray-300 mb-1"></span>
                <span class="hamburger-line line-3 block w-5 h-0.5 bg-gray-600 dark:bg-gray-300"></span>
            </div>
        </button>
    </div>

    <!-- Menu mobile -->
    <div id="mobile-menu" class="lg:hidden absolute top-full right-4 mt-2 w-64 bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-xl shadow-lg backdrop-blur-sm menu-transition transform origin-top-right scale-95 opacity-0 invisible z-50">
        <div class="p-2 space-y-1">
            <a href="{{ route('home') }}" class="block px-4 py-3 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors duration-150 text-gray-700 dark:text-gray-300 {{ request()->routeIs('home') ? 'bg-gray-100 dark:bg-gray-800' : '' }}">
                <span class="font-medium" data-translate="nav-home">Accueil</span>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1" data-translate="nav-home-desc">Page d'accueil</p>
            </a>
            <a href="/vocabulaire" class="block px-4 py-3 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors duration-150 text-gray-700 dark:text-gray-300">
                <span class="font-medium" data-translate="nav-vocabulary">Vocabulaire</span>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1" data-translate="nav-vocabulary-desc">Consulter le lexique</p>
            </a>

            @auth
                <a href="/lecon/1" class="block px-4 py-3 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors duration-150 text-gray-700 dark:text-gray-300">
                    <span class="font-medium" data-translate="nav-lecon1">Leçon 1</span>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1" data-translate="nav-lecon1-desc">Première leçon</p>
                </a>
                <a href="/lecon/2" class="block px-4 py-3 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors duration-150 text-gray-700 dark:text-gray-300">
                    <span class="font-medium" data-translate="nav-lecon2">Leçon 2</span>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1" data-translate="nav-lecon2-desc">Deuxième leçon</p>
                </a>
                <a href="{{ route('profile.edit') }}" class="block px-4 py-3 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors duration-150 text-gray-700 dark:text-gray-300">
                    <span class="font-medium" data-translate="nav-compte">Mon compte</span>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1" data-translate="nav-compte-desc">Gérer votre profil</p>
                </a>

                <!-- Déconnexion mobile -->
                <div class="border-t border-gray-200 dark:border-gray-700 pt-2 mt-2">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="block w-full px-4 py-3 rounded-lg hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors duration-150 text-left text-red-600 dark:text-red-400">
                            <span class="font-medium" data-translate="nav-logout">Déconnexion</span>
                            <p class="text-xs text-red-500 dark:text-red-400 mt-1 opacity-75" data-translate="nav-logout-desc">Quitter votre session</p>
                        </button>
                    </form>
                </div>
            @endauth

            @guest
                <div class="border-t border-gray-200 dark:border-gray-700 pt-2 mt-2">
                    <a href="{{ route('login') }}" class="block px-4 py-3 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors duration-150 text-gray-700 dark:text-gray-300">
                        <span class="font-medium" data-translate="nav-login">Connexion</span>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1" data-translate="nav-login-desc">Accéder à votre compte</p>
                    </a>
                    <a href="{{ route('register') }}" class="block px-4 py-3 rounded-lg bg-[#1b1b18] dark:bg-[#EDEDEC] text-[#FDFDFC] dark:text-[#1b1b18] hover:opacity-90 transition-opacity duration-150">
                        <span class="font-medium" data-translate="nav-register">Inscription</span>
                        <p class="text-xs opacity-75 mt-1" data-translate="nav-register-desc">Créer un compte gratuit</p>
                    </a>
                </div>
            @endguest

            <!-- Sélecteur de langue mobile -->
            <div class="border-t border-gray-200 dark:border-gray-700 pt-2 mt-2">
                <div class="px-4 py-2 text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider" data-translate="language-selector">Langue</div>
                <div class="space-y-1">
                    <button class="language-option w-full px-4 py-2 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors duration-150 text-left text-gray-700 dark:text-gray-300" data-lang="fr">
                        <span class="flag-emoji">🇫🇷</span>
                        <span>Français</span>
                    </button>
                    <button class="language-option w-full px-4 py-2 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors duration-150 text-left text-gray-700 dark:text-gray-300" data-lang="en">
                        <span class="flag-emoji">🇬🇧</span>
                        <span>English</span>
                    </button>
                    <button class="language-option w-full px-4 py-2 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors duration-150 text-left text-gray-700 dark:text-gray-300" data-lang="it">
                        <span class="flag-emoji">🇮🇹</span>
                        <span>Italiano</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</header>

<script>
    // Système de traduction
    const translations = {
        fr: {
            'site-title': 'Quiz Minecraft',
            'nav-home': 'Accueil',
            'nav-home-desc': 'Page d\'accueil',
            'nav-vocabulary': 'Vocabulaire',
            'nav-vocabulary-desc': 'Consulter le lexique',
            'nav-lecon1': 'Leçon 1',
            'nav-lecon1-desc': 'Première leçon',
            'nav-lecon2': 'Leçon 2',
            'nav-lecon2-desc': 'Deuxième leçon',
            'nav-compte': 'Mon compte',
            'nav-compte-desc': 'Gérer votre profil',
            'nav-logout': 'Déconnexion',
            'nav-logout-desc': 'Quitter votre session',
            'nav-login': 'Connexion',
            'nav-login-desc': 'Accéder à votre compte',
            'nav-register': 'Inscription',
            'nav-register-desc': 'Créer un compte gratuit',
            'language-selector': 'Langue',
            'vocab-title': 'Vocabulaire',
            'vocab-search-placeholder': 'Rechercher un mot...',
            'vocab-all-difficulties': 'Toutes les difficultés',
            'vocab-easy': 'Facile',
            'vocab-normal': 'Normal',
            'vocab-hard': 'Difficile',
            'vocab-words-total': 'mot(s) au total',
            'vocab-page': 'Page',
            'vocab-of': 'sur',
            'vocab-no-words': 'Aucun mot trouvé',
            'vocab-adjust-search': 'Essayez de modifier vos critères de recherche',
            'vocab-difficulty': 'Difficulté:'
        },
        en: {
            'site-title': 'Quiz Minecraft',
            'nav-home': 'Home',
            'nav-home-desc': 'Home page',
            'nav-vocabulary': 'Vocabulary',
            'nav-vocabulary-desc': 'Browse the lexicon',
            'nav-lecon1': 'Lesson 1',
            'nav-lecon1-desc': 'First lesson',
            'nav-lecon2': 'Lesson 2',
            'nav-lecon2-desc': 'Second lesson',
            'nav-compte': 'My account',
            'nav-compte-desc': 'Manage your profile',
            'nav-logout': 'Logout',
            'nav-logout-desc': 'End your session',
            'nav-login': 'Login',
            'nav-login-desc': 'Access your account',
            'nav-register': 'Register',
            'nav-register-desc': 'Create a free account',
            'language-selector': 'Language',
            'vocab-title': 'Vocabulary',
            'vocab-search-placeholder': 'Search for a word...',
            'vocab-all-difficulties': 'All difficulties',
            'vocab-easy': 'Easy',
            'vocab-normal': 'Normal',
            'vocab-hard': 'Hard',
            'vocab-words-total': 'word(s) total',
            'vocab-page': 'Page',
            'vocab-of': 'of',
            'vocab-no-words': 'No words found',
            'vocab-adjust-search': 'Try adjusting your search criteria',
            'vocab-difficulty': 'Difficulty:'
        },
        it: {
            'site-title': 'Quiz Minecraft',
            'nav-home': 'Home',
            'nav-home-desc': 'Pagina principale',
            'nav-vocabulary': 'Vocabolario',
            'nav-vocabulary-desc': 'Consulta il lessico',
            'nav-lecon1': 'Lezione 1',
            'nav-lecon1-desc': 'Prima lezione',
            'nav-lecon2': 'Lezione 2',
            'nav-lecon2-desc': 'Seconda lezione',
            'nav-compte': 'Il mio account',
            'nav-compte-desc': 'Gestisci il tuo profilo',
            'nav-logout': 'Disconnetti',
            'nav-logout-desc': 'Termina la sessione',
            'nav-login': 'Accesso',
            'nav-login-desc': 'Accedi al tuo account',
            'nav-register': 'Registrazione',
            'nav-register-desc': 'Crea un account gratuito',
            'language-selector': 'Lingua',
            'vocab-title': 'Vocabolario',
            'vocab-search-placeholder': 'Cerca una parola...',
            'vocab-all-difficulties': 'Tutte le difficoltà',
            'vocab-easy': 'Facile',
            'vocab-normal': 'Normale',
            'vocab-hard': 'Difficile',
            'vocab-words-total': 'parola/e in totale',
            'vocab-page': 'Pagina',
            'vocab-of': 'di',
            'vocab-no-words': 'Nessuna parola trovata',
            'vocab-adjust-search': 'Prova a modificare i criteri di ricerca',
            'vocab-difficulty': 'Difficoltà:'
        }
    };

    // Fonction pour mettre à jour les traductions
    function updateTranslations(lang) {
        const currentTranslations = translations[lang] || translations.fr;

        document.querySelectorAll('[data-translate]').forEach(element => {
            const key = element.getAttribute('data-translate');
            if (currentTranslations[key]) {
                if (element.tagName === 'INPUT' && element.type === 'text') {
                    element.placeholder = currentTranslations[key];
                } else {
                    element.textContent = currentTranslations[key];
                }
            }
        });
    }

    // Fonction pour changer de langue
    function changeLanguage(lang) {
        // Mettre à jour les traductions
        updateTranslations(lang);

        // Mettre à jour l'affichage du sélecteur
        const flags = { fr: '🇫🇷', en: '🇬🇧', it: '🇮🇹' };
        const langCodes = { fr: 'FR', en: 'EN', it: 'IT' };

        document.getElementById('current-flag').textContent = flags[lang];
        document.getElementById('current-lang').textContent = langCodes[lang];

        // Sauvegarder la préférence dans le localStorage
        localStorage.setItem('preferredLanguage', lang);

        const localeMap = {
            fr: 'fr_fr',
            en: 'en_us',
            it: 'it_it'
        };
        const locale = localeMap[lang] || 'fr_fr';

        // Mettre à jour la session via AJAX
        fetch('/change-language', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ language: locale })
        }).catch(error => {
            console.error('Erreur lors de la mise à jour de la langue:', error);
        });
    }


    // Initialisation au chargement de la page
    document.addEventListener('DOMContentLoaded', function() {
        // Récupérer la langue sauvegardée ou celle de la session

        let currentLanguage = @json(session('language', 'fr_fr'));

        const sessionToJsLang = {
            'fr_fr': 'fr',
            'en_us': 'en',
            'it_it': 'it'
        };

        const savedLang = sessionToJsLang[currentLanguage] || 'fr';

        // Appliquer les traductions
        updateTranslations(savedLang);

        // Mettre à jour l'affichage du sélecteur
        const flags = { fr: '🇫🇷', en: '🇬🇧', it: '🇮🇹' };
        const langCodes = { fr: 'FR', en: 'EN', it: 'IT' };

        document.getElementById('current-flag').textContent = flags[savedLang];
        document.getElementById('current-lang').textContent = langCodes[savedLang];

        // Gestion des clics sur les options de langue
        document.querySelectorAll('[data-lang]').forEach(button => {
            button.addEventListener('click', function() {
                const lang = this.getAttribute('data-lang');
                changeLanguage(lang);

                // Fermer les dropdowns
                const desktopDropdown = document.getElementById('language-dropdown');
                const mobileMenu = document.getElementById('mobile-menu');

                if (desktopDropdown) {
                    desktopDropdown.classList.add('scale-95', 'opacity-0');
                    setTimeout(() => {
                        desktopDropdown.classList.add('invisible');
                    }, 200);
                }

                if (mobileMenu) {
                    mobileMenu.classList.add('scale-95', 'opacity-0');
                    setTimeout(() => {
                        mobileMenu.classList.add('invisible');
                    }, 200);
                }
            });
        });
    });
</script>
