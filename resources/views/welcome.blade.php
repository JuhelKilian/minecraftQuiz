<!DOCTYPE html>
<html lang="{{ session('language', 'fr') }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Quiz Minecraft</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .minecraft-title {
            background: url('/images/grass_block.png') repeat;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-size: 40%;
        }

        /* Animation pour le menu burger */
        .menu-transition {
            transition: all 0.2s ease-in-out;
        }

        /* Animation pour l'icône hamburger */
        .hamburger-line {
            transition: all 0.3s ease-in-out;
            transform-origin: center;
        }

        .hamburger-open .line-1 {
            transform: rotate(45deg) translate(5px, 5px);
        }

        .hamburger-open .line-2 {
            opacity: 0;
        }

        .hamburger-open .line-3 {
            transform: rotate(-45deg) translate(7px, -6px);
        }

        /* Amélioration des ombres */
        .soft-shadow {
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
        }

        /* Gradient subtil pour le titre */
        .title-gradient {
            background: linear-gradient(135deg, #1b1b18 0%, #2d2d28 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .dark .title-gradient {
            background: linear-gradient(135deg, #EDEDEC 0%, #ffffff 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* Styles pour le sélecteur de langue */
        .language-dropdown {
            min-width: 120px;
        }

        .language-option {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .flag-emoji {
            font-size: 1.1em;
        }
    </style>

</head>
<body class="bg-[#FDFDFC] dark:bg-[#0a0a0a] text-[#1b1b18] dark:text-[#EDEDEC] flex flex-col min-h-screen font-['Instrument_Sans']">

<header class="w-full border-b border-gray-200 dark:border-gray-700 px-4 sm:px-6 lg:px-8 py-4 relative bg-white/50 dark:bg-black/50 backdrop-blur-sm">
    <div class="flex justify-between items-center">
        <!-- Titre -->
        <h1 class="text-2xl sm:text-3xl font-semibold title-gradient" data-translate="site-title">Quiz Minecraft</h1>

        <!-- Navigation desktop -->
        <nav class="hidden md:flex items-center gap-3 text-sm">
            @guest
                <a href="/vocabulaire" class="px-4 py-2 rounded-lg border border-gray-200 dark:border-gray-700 hover:border-gray-300 dark:hover:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-all duration-200 soft-shadow" data-translate="nav-vocabulary">Vocabulaire</a>
                <a href="/login" class="px-4 py-2 rounded-lg border border-transparent hover:border-gray-200 dark:hover:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-all duration-200" data-translate="nav-login">Connexion</a>
                <a href="/register" class="px-4 py-2 rounded-lg border border-[#1b1b18] dark:border-[#EDEDEC] hover:bg-[#1b1b18] dark:hover:bg-[#EDEDEC] hover:text-[#FDFDFC] dark:hover:text-[#1b1b18] transition-all duration-200" data-translate="nav-register">Inscription</a>
            @endguest

            @auth
                <a href="/vocabulaire" data-translate="nav-vocabulary" class="px-4 py-2 rounded-lg border border-gray-200
                dark:border-gray-700 hover:border-gray-300 dark:hover:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-all duration-200 soft-shadow">
                    Vocabulaire</a>
                <a href="/lecon/1" data-translate="nav-lecon1" class="px-4 py-2 rounded-lg border border-transparent hover:border-gray-200
                dark:hover:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-all duration-200">
                    Leçon 1</a>
                <a href="/lecon/2" data-translate="nav-lecon2" class="px-4 py-2 rounded-lg border border-transparent hover:border-gray-200
                 dark:hover:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-all duration-200">
                    Leçon 2</a>
                <a href="/profile" data-translate="nav-compte" class="px-4 py-2 rounded-lg border border-[#1b1b18] dark:border-[#EDEDEC]
                hover:bg-[#1b1b18] dark:hover:bg-[#EDEDEC] hover:text-[#FDFDFC] dark:hover:text-[#1b1b18] transition-all duration-200">
                    Mon compte</a>
            @endauth

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
        <button id="mobile-menu-button" class="md:hidden flex items-center justify-center w-10 h-10 rounded-lg border border-gray-300 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-all duration-200">
            <div class="hamburger">
                <span class="hamburger-line line-1 block w-5 h-0.5 bg-gray-600 dark:bg-gray-300 mb-1"></span>
                <span class="hamburger-line line-2 block w-5 h-0.5 bg-gray-600 dark:bg-gray-300 mb-1"></span>
                <span class="hamburger-line line-3 block w-5 h-0.5 bg-gray-600 dark:bg-gray-300"></span>
            </div>
        </button>
    </div>

    <!-- Menu mobile -->
    <div id="mobile-menu" class="md:hidden absolute top-full right-4 mt-2 w-64 bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-xl shadow-lg backdrop-blur-sm menu-transition transform origin-top-right scale-95 opacity-0 invisible z-50">
        <div class="p-2 space-y-1">
            @guest
                <a href="/vocabulaire" class="block px-4 py-3 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors duration-150 text-gray-700 dark:text-gray-300">
                    <span class="font-medium" data-translate="nav-vocabulary">Vocabulaire</span>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1" data-translate="nav-vocabulary-desc">Consulter le lexique</p>
                </a>
                <a href="/login" class="block px-4 py-3 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors duration-150 text-gray-700 dark:text-gray-300">
                    <span class="font-medium" data-translate="nav-login">Connexion</span>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1" data-translate="nav-login-desc">Accéder à votre compte</p>
                </a>
                <a href="/register" class="block px-4 py-3 rounded-lg bg-[#1b1b18] dark:bg-[#EDEDEC] text-[#FDFDFC] dark:text-[#1b1b18] hover:opacity-90 transition-opacity duration-150">
                    <span class="font-medium" data-translate="nav-register">Inscription</span>
                    <p class="text-xs opacity-75 mt-1" data-translate="nav-register-desc">Créer un compte gratuit</p>
                </a>
            @endguest

            @auth
                <a href="/vocabulaire" class="block px-4 py-3 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors duration-150 text-gray-700 dark:text-gray-300">
                    <span class="font-medium" data-translate="nav-vocabulary">Vocabulaire</span>
                </a>
                <a href="/lecon/1" class="block px-4 py-3 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors duration-150 text-gray-700 dark:text-gray-300">
                    <span class="font-medium" data-translate="nav-lecon1">Leçon 1</span>
                </a>
                <a href="/lecon/2" class="block px-4 py-3 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors duration-150 text-gray-700 dark:text-gray-300">
                    <span class="font-medium" data-translate="nav-lecon2">Leçon 2</span>
                </a>
                <a href="/profile" class="block px-4 py-3 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors duration-150 text-gray-700 dark:text-gray-300">
                    <span class="font-medium" data-translate="nav-compte">Mon compte</span>
                </a>
            @endauth

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

<!-- Contenu principal amélioré -->
<main class="flex flex-col items-center justify-center flex-1 text-center px-4 sm:px-6 lg:px-0 py-12 sm:py-16 lg:py-24">
    <div class="max-w-4xl mx-auto">
        <!-- Titre principal avec gradient -->
        <h2 class="text-4xl sm:text-5xl lg:text-6xl font-bold mb-6 leading-tight">
            <span data-translate="welcome">Bienvenue sur</span> <br class="hidden sm:inline">
            <span class="minecraft-title" data-translate="site-title">Quiz Minecraft</span> !
        </h2>

        <!-- Description améliorée -->
        <p class="mb-8 text-lg text-gray-600 dark:text-gray-300 max-w-2xl mx-auto leading-relaxed" data-translate="description">
            Apprends le français, l'anglais ou l'italien avec les items et blocs de Minecraft.
        </p>

        <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
            {{-- Utilisateur NON connecté --}}
            @guest
                <a href="{{ route('login') }}"
                   class="group bg-[#1b1b18] dark:bg-[#EDEDEC] text-[#FDFDFC] dark:text-[#1b1b18] px-8 py-4 rounded-xl hover:opacity-90 transition-all duration-200 text-lg font-medium soft-shadow hover:scale-105 flex items-center">
                    <span data-translate="btn-login">Se connecter</span>
                    <svg class="w-5 h-5 ml-2 group-hover:translate-x-1 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                    </svg>
                </a>

                <a href="{{ route('vocabulaire.index') }}"
                   class="px-8 py-4 rounded-xl border border-gray-300 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-all duration-200 text-lg font-medium hover:scale-105"
                   data-translate="btn-explore">
                    Explorer le vocabulaire
                </a>
            @endguest

            {{-- Utilisateur CONNECTÉ --}}
            @auth
                <a href="{{ route('lecon.index') }}"
                   class="group bg-[#1b1b18] dark:bg-[#EDEDEC] text-[#FDFDFC] dark:text-[#1b1b18] px-8 py-4 rounded-xl hover:opacity-90 transition-all duration-200 text-lg font-medium soft-shadow hover:scale-105 flex items-center">
                    <span data-translate="btn-lecon">Faire une leçon</span>
                    <svg class="w-5 h-5 ml-2 group-hover:translate-x-1 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                    </svg>
                </a>

                <a href="{{ route('vocabulaire.index') }}"
                   class="px-8 py-4 rounded-xl border border-gray-300 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-all duration-200 text-lg font-medium hover:scale-105"
                   data-translate="btn-explore">
                    Explorer le vocabulaire
                </a>
            @endauth
        </div>

        <!-- Statistiques ou features -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mt-16 max-w-2xl mx-auto">
            <div class="text-center p-4">
                <div class="text-2xl font-bold text-[#1b1b18] dark:text-[#EDEDEC] mb-2">3</div>
                <div class="text-sm text-gray-600 dark:text-gray-400" data-translate="stat-languages">Langues disponibles</div>
            </div>
            <div class="text-center p-4">
                <div class="text-2xl font-bold text-[#1b1b18] dark:text-[#EDEDEC] mb-2">1190</div>
                <div class="text-sm text-gray-600 dark:text-gray-400" data-translate="stat-items">Items Minecraft</div>
            </div>
            <div class="text-center p-4">
                <div class="text-2xl font-bold text-[#1b1b18] dark:text-[#EDEDEC] mb-2">1549821568+</div>
                <div class="text-sm text-gray-600 dark:text-gray-400" data-translate="stat-difficulties">Heures de mes vacances sacrifiées</div>
            </div>
        </div>
    </div>
</main>

<!-- Footer amélioré -->
<footer class="w-full text-center p-6 sm:p-8 text-sm text-gray-500 dark:text-gray-400 border-t border-gray-200 dark:border-gray-700">
    <div class="max-w-4xl mx-auto">
        <p class="mt-2 text-xs" data-translate="footer">Fait avec ❤️ (et de la bière dans le sang)</p>
    </div>
</footer>

<!-- Script pour menu mobile et sélecteur de langue -->
<script>
    console.log("{{ session('language', 'fr') }}");
    // Configuration des traductions
    const translations = {
        fr: {
            'site-title': 'Quiz Minecraft',
            'nav-vocabulary': 'Vocabulaire',
            'nav-vocabulary-desc': 'Consulter le lexique',
            'nav-lecon1': 'Leçon 1',
            'nav-lecon2': 'Leçon 2',
            'nav-compte': 'Mon compte',
            'nav-login': 'Connexion',
            'nav-login-desc': 'Accéder à votre compte',
            'nav-register': 'Inscription',
            'nav-register-desc': 'Créer un compte',
            'language-selector': 'Langue',
            'welcome': 'Bienvenue sur',
            'description': 'Apprends le français, l\'anglais ou l\'italien avec les items et blocs de Minecraft.',
            'btn-login': 'Se connecter',
            'btn-explore': 'Explorer le vocabulaire',
            'btn-lecon': 'Faire une leçon',
            'stat-languages': 'Langues disponibles',
            'stat-items': 'Items Minecraft',
            'stat-difficulties': 'Heures de mes vacances sacrifiées',
            'footer': 'Fait avec ❤️ (et de la bière dans le sang)',
        },
        en: {
            'site-title': 'Minecraft Quiz',
            'nav-vocabulary': 'Vocabulary',
            'nav-vocabulary-desc': 'Browse the lexicon',
            'nav-lecon1': 'Lesson 1',
            'nav-lecon2': 'Lesson 2',
            'nav-compte': 'My account',
            'nav-login': 'Login',
            'nav-login-desc': 'Access your account',
            'nav-register': 'Sign up',
            'nav-register-desc': 'Create an account',
            'language-selector': 'Language',
            'welcome': 'Welcome to',
            'description': 'Learn French, English or Italian with Minecraft items and blocks.',
            'btn-login': 'Log in',
            'btn-explore': 'Explore vocabulary',
            'btn-lecon': 'Take a lesson',
            'stat-languages': 'Available languages',
            'stat-items': 'Minecraft Items',
            'stat-difficulties': 'Hours of my vacation sacrificed',
            'footer': 'Made with ❤️ (with beer in the blood)'
        },
        it: {
            'site-title': 'Quiz Minecraft',
            'nav-vocabulary': 'Vocabolario',
            'nav-vocabulary-desc': 'Consulta il lessico',
            'nav-lecon1': 'Lezione 1',
            'nav-lecon2': 'Lezione 2',
            'nav-compte': 'Il mio conto',
            'nav-login': 'Accesso',
            'nav-login-desc': 'Accedi al tuo account',
            'nav-register': 'Registrazione',
            'nav-register-desc': 'Crea un account',
            'language-selector': 'Lingua',
            'welcome': 'Benvenuto su',
            'description': 'Impara il francese, l\'inglese o l\'italiano con gli oggetti e blocchi di Minecraft.',
            'btn-login': 'Accedi',
            'btn-explore': 'Esplora il vocabolario',
            'btn-lecon': 'Fare una lezione',
            'stat-languages': 'Lingue disponibili',
            'stat-items': 'Oggetti Minecraft',
            'stat-difficulties': 'Ore della mia vacanza sacrificate',
            'footer': 'Fatto con ❤️ (e birra nel sangue)'
        }
    };

    const languageFlags = {
        fr: { flag: '🇫🇷', code: 'FR' },
        en: { flag: '🇬🇧', code: 'EN' },
        it: { flag: '🇮🇹', code: 'IT' }
    };

    // Traduire du
    let currentLanguage = @json(session('language', 'fr_fr'));

    const sessionToJsLang = {
        'fr_fr': 'fr',
        'en_us': 'en',
        'it_it': 'it'
    };

    currentLanguage = sessionToJsLang[currentLanguage] || 'fr';

    document.addEventListener('DOMContentLoaded', function() {
        // Éléments du DOM
        const btn = document.getElementById('mobile-menu-button');
        const menu = document.getElementById('mobile-menu');
        const hamburger = btn.querySelector('.hamburger');
        const languageBtn = document.getElementById('language-button');
        const languageDropdown = document.getElementById('language-dropdown');
        const languageChevron = document.getElementById('language-chevron');
        const currentFlag = document.getElementById('current-flag');
        const currentLang = document.getElementById('current-lang');

        // Initialiser la langue au chargement
        initializeLanguage();

        // Toggle menu mobile
        btn.addEventListener('click', function(e) {
            e.stopPropagation();
            toggleMobileMenu();
        });

        function toggleMobileMenu() {
            const isOpen = !menu.classList.contains('opacity-0');

            if (isOpen) {
                menu.classList.add('scale-95', 'opacity-0', 'invisible');
                hamburger.classList.remove('hamburger-open');
            } else {
                menu.classList.remove('scale-95', 'opacity-0', 'invisible');
                menu.classList.add('scale-100', 'opacity-100', 'visible');
                hamburger.classList.add('hamburger-open');
                languageDropdown.classList.add('scale-95', 'opacity-0', 'invisible');
                languageChevron.style.transform = 'rotate(0deg)';
            }
        }

        // Toggle dropdown langue desktop
        languageBtn.addEventListener('click', function(e) {
            e.stopPropagation();
            toggleLanguageDropdown();
        });

        function toggleLanguageDropdown() {
            const isOpen = !languageDropdown.classList.contains('opacity-0');

            if (isOpen) {
                languageDropdown.classList.add('scale-95', 'opacity-0', 'invisible');
                languageChevron.style.transform = 'rotate(0deg)';
            } else {
                languageDropdown.classList.remove('scale-95', 'opacity-0', 'invisible');
                languageDropdown.classList.add('scale-100', 'opacity-100', 'visible');
                languageChevron.style.transform = 'rotate(180deg)';
                menu.classList.add('scale-95', 'opacity-0', 'invisible');
                hamburger.classList.remove('hamburger-open');
            }
        }

        // Gestion des clics sur les options de langue
        document.addEventListener('click', function(e) {
            if (e.target.closest('[data-lang]')) {
                const lang = e.target.closest('[data-lang]').getAttribute('data-lang');
                changeLanguage(lang);

                // Fermer les dropdowns
                languageDropdown.classList.add('scale-95', 'opacity-0', 'invisible');
                languageChevron.style.transform = 'rotate(0deg)';
                menu.classList.add('scale-95', 'opacity-0', 'invisible');
                hamburger.classList.remove('hamburger-open');
            }
        });

        // Fermer les dropdowns si on clique ailleurs
        document.addEventListener('click', function(e) {
            if (!menu.contains(e.target) && !btn.contains(e.target)) {
                menu.classList.add('scale-95', 'opacity-0', 'invisible');
                hamburger.classList.remove('hamburger-open');
            }

            if (!languageDropdown.contains(e.target) && !languageBtn.contains(e.target)) {
                languageDropdown.classList.add('scale-95', 'opacity-0', 'invisible');
                languageChevron.style.transform = 'rotate(0deg)';
            }
        });

        // Fermer les dropdowns au resize
        window.addEventListener('resize', function() {
            if (window.innerWidth >= 768) {
                menu.classList.add('scale-95', 'opacity-0', 'invisible');
                hamburger.classList.remove('hamburger-open');
            }
            languageDropdown.classList.add('scale-95', 'opacity-0', 'invisible');
            languageChevron.style.transform = 'rotate(0deg)';
        });

        // Fonction pour initialiser la langue au chargement
        function initializeLanguage() {
            if (currentLanguage && translations[currentLanguage]) {
                updateLanguageDisplay(currentLanguage);
                updateTranslations(currentLanguage);
            }
        }

        // Fonction pour changer de langue
        function changeLanguage(lang) {
            if (!translations[lang]) return;

            currentLanguage = lang;

            // Mettre à jour l'affichage
            updateLanguageDisplay(lang);
            updateTranslations(lang);

            // Envoyer la nouvelle langue au serveur
            updateServerLanguage(lang);
        }

        // Mettre à jour l'affichage du sélecteur de langue
        function updateLanguageDisplay(lang) {
            currentFlag.textContent = languageFlags[lang].flag;
            currentLang.textContent = languageFlags[lang].code;
            document.documentElement.lang = lang;
        }

        // Mettre à jour les traductions
        function updateTranslations(lang) {
            document.querySelectorAll('[data-translate]').forEach(element => {
                const key = element.getAttribute('data-translate');
                if (translations[lang][key]) {
                    element.textContent = translations[lang][key];
                }
            });
        }

        // Envoyer la langue au serveur via AJAX
        function updateServerLanguage(lang) {
            // Convertir le code langue court vers les codes complets
            const localeMap = {
                'fr': 'fr_fr',
                'en': 'en_us',
                'it': 'it_it'
            };

            const locale = localeMap[lang] || 'fr_fr';

            fetch('/change-language', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    language: locale
                })
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        console.log('Langue mise à jour en session:', locale);
                    } else {
                        console.error('Erreur lors de la mise à jour de la langue');
                    }
                })
                .catch(error => {
                    console.error('Erreur lors de la requête:', error);
                });
        }
    });
</script>

</body>
</html>
