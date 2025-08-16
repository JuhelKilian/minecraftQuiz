<!DOCTYPE html>
<html lang="{{ session('language', 'fr') }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@lang('Inscription') - Quiz Minecraft</title>
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

        /* Animation pour le sélecteur de langue */
        .menu-transition {
            transition: all 0.2s ease-in-out;
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

        /* Styles pour les inputs */
        .input-field {
            border: 1px solid #d1d5db;
            border-radius: 0.5rem;
            padding: 0.75rem;
            font-size: 0.875rem;
            transition: all 0.15s ease-in-out;
            background-color: white;
        }

        .dark .input-field {
            background-color: #111827;
            border-color: #374151;
            color: #f9fafb;
        }

        .input-field:focus {
            outline: none;
            border-color: #1b1b18;
            box-shadow: 0 0 0 3px rgba(27, 27, 24, 0.1);
        }

        .dark .input-field:focus {
            border-color: #EDEDEC;
            box-shadow: 0 0 0 3px rgba(237, 237, 236, 0.1);
        }

        .input-error {
            border-color: #ef4444;
        }

        .input-error:focus {
            border-color: #ef4444;
            box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.1);
        }
    </style>
</head>

<body class="bg-[#FDFDFC] dark:bg-[#0a0a0a] text-[#1b1b18] dark:text-[#EDEDEC] font-['Instrument_Sans']">

<!-- Sélecteur de langue en position fixe -->
<div class="fixed top-4 right-4 z-50">
    <div class="relative">
        <button id="language-button" class="px-3 py-2 rounded-lg border border-gray-200 dark:border-gray-700 hover:border-gray-300 dark:hover:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-all duration-200 flex items-center gap-2 bg-white/80 dark:bg-black/80 backdrop-blur-sm">
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
</div>

<div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0">
    <!-- Logo/Titre -->
    <div class="mb-8 text-center">
        <a href="/" class="inline-block">
            <h1 data-translate="site-title" class="text-4xl font-bold minecraft-title mb-2">Quiz Minecraft</h1>
        </a>
        <p class="text-sm text-gray-600 dark:text-gray-400" data-translate="subtitle">
            Créer votre compte pour commencer
        </p>
    </div>

    <!-- Formulaire d'inscription -->
    <div class="w-full sm:max-w-md px-6 py-8 bg-white dark:bg-gray-900 shadow-lg soft-shadow rounded-xl">
        <form method="POST" action="{{ route('register') }}" id="register-form">
            @csrf

            <!-- Champ langue caché -->
            <input type="hidden" id="langue" name="langue" value="{{ session('language', 'fr_fr') }}">

            <!-- Prénom -->
            <div>
                <label for="name" class="block font-medium text-sm text-gray-700 dark:text-gray-300 mb-2" data-translate="label-firstname">
                    Prénom
                </label>
                <input id="name" class="input-field block mt-1 w-full @error('name') input-error @enderror"
                       type="text"
                       name="name"
                       value="{{ old('name') }}"
                       required
                       autofocus
                       autocomplete="given-name" />
                @error('name')
                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- Nom de famille (facultatif) -->
            <div class="mt-4">
                <label for="nomFamille" class="block font-medium text-sm text-gray-700 dark:text-gray-300 mb-2" data-translate="label-lastname">
                    Nom de famille
                </label>
                <input id="nomFamille" class="input-field block mt-1 w-full @error('nomFamille') input-error @enderror"
                       type="text"
                       name="nomFamille"
                       value="{{ old('nomFamille') }}"
                       autocomplete="family-name" />
                @error('nomFamille')
                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1" data-translate="optional">Facultatif</p>
            </div>

            <!-- Adresse Email -->
            <div class="mt-4">
                <label for="email" class="block font-medium text-sm text-gray-700 dark:text-gray-300 mb-2" data-translate="label-email">
                    Adresse Email
                </label>
                <input id="email" class="input-field block mt-1 w-full @error('email') input-error @enderror"
                       type="email"
                       name="email"
                       value="{{ old('email') }}"
                       required
                       autocomplete="username" />
                @error('email')
                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- Mot de passe -->
            <div class="mt-4">
                <label for="password" class="block font-medium text-sm text-gray-700 dark:text-gray-300 mb-2" data-translate="label-password">
                    Mot de passe
                </label>
                <input id="password" class="input-field block mt-1 w-full @error('password') input-error @enderror"
                       type="password"
                       name="password"
                       required
                       autocomplete="new-password" />
                @error('password')
                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- Confirmation du mot de passe -->
            <div class="mt-4">
                <label for="password_confirmation" class="block font-medium text-sm text-gray-700 dark:text-gray-300 mb-2" data-translate="label-password-confirm">
                    Confirmer le mot de passe
                </label>
                <input id="password_confirmation" class="input-field block mt-1 w-full @error('password_confirmation') input-error @enderror"
                       type="password"
                       name="password_confirmation"
                       required
                       autocomplete="new-password" />
                @error('password_confirmation')
                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center justify-between mt-6">
                <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
                   href="{{ route('login') }}"
                   data-translate="already-registered">
                    Déjà inscrit ?
                </a>

                <button type="submit" class="bg-[#1b1b18] dark:bg-[#EDEDEC] text-[#FDFDFC] dark:text-[#1b1b18] px-6 py-2 rounded-lg hover:opacity-90 transition-all duration-200 font-medium focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#1b1b18] dark:focus:ring-[#EDEDEC]">
                    <span data-translate="btn-register">S'inscrire</span>
                </button>
            </div>
        </form>
    </div>

    <!-- Lien retour accueil -->
    <div class="mt-6">
        <a href="/" class="text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 transition-colors duration-150" data-translate="back-home">
            ← Retour à l'accueil
        </a>
    </div>
</div>

<script>
    // Configuration des traductions
    const translations = {
        fr: {
            'site-title': 'Quiz Minecraft',
            'subtitle': 'Créer votre compte pour commencer',
            'label-firstname': 'Prénom',
            'label-lastname': 'Nom de famille',
            'label-email': 'Adresse Email',
            'label-password': 'Mot de passe',
            'label-password-confirm': 'Confirmer le mot de passe',
            'optional': 'Facultatif',
            'already-registered': 'Déjà inscrit ?',
            'btn-register': 'S\'inscrire',
            'back-home': '← Retour à l\'accueil'
        },
        en: {
            'site-title': 'Minecraft Quiz',
            'subtitle': 'Create your account to get started',
            'label-firstname': 'First Name',
            'label-lastname': 'Last Name',
            'label-email': 'Email Address',
            'label-password': 'Password',
            'label-password-confirm': 'Confirm Password',
            'optional': 'Optional',
            'already-registered': 'Already registered?',
            'btn-register': 'Register',
            'back-home': '← Back to home'
        },
        it: {
            'site-title': 'Quiz Minecraft',
            'subtitle': 'Crea il tuo account per iniziare',
            'label-firstname': 'Nome',
            'label-lastname': 'Cognome',
            'label-email': 'Indirizzo Email',
            'label-password': 'Password',
            'label-password-confirm': 'Conferma Password',
            'optional': 'Facoltativo',
            'already-registered': 'Già registrato?',
            'btn-register': 'Registrati',
            'back-home': '← Torna alla home'
        }
    };

    const languageFlags = {
        fr: { flag: '🇫🇷', code: 'FR' },
        en: { flag: '🇬🇧', code: 'EN' },
        it: { flag: '🇮🇹', code: 'IT' }
    };

    // Récupérer la langue de session
    let currentLanguage = @json(session('language', 'fr_fr'));

    const sessionToJsLang = {
        'fr_fr': 'fr',
        'en_us': 'en',
        'it_it': 'it'
    };

    currentLanguage = sessionToJsLang[currentLanguage] || 'fr';

    document.addEventListener('DOMContentLoaded', function() {
        const languageBtn = document.getElementById('language-button');
        const languageDropdown = document.getElementById('language-dropdown');
        const languageChevron = document.getElementById('language-chevron');
        const currentFlag = document.getElementById('current-flag');
        const currentLang = document.getElementById('current-lang');
        const langueInput = document.getElementById('langue');

        // Initialiser la langue au chargement
        initializeLanguage();

        // Toggle dropdown langue
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
            }
        }

        // Gestion des clics sur les options de langue
        document.addEventListener('click', function(e) {
            if (e.target.closest('[data-lang]')) {
                const lang = e.target.closest('[data-lang]').getAttribute('data-lang');
                changeLanguage(lang);

                // Fermer le dropdown
                languageDropdown.classList.add('scale-95', 'opacity-0', 'invisible');
                languageChevron.style.transform = 'rotate(0deg)';
            }
        });

        // Fermer le dropdown si on clique ailleurs
        document.addEventListener('click', function(e) {
            if (!languageDropdown.contains(e.target) && !languageBtn.contains(e.target)) {
                languageDropdown.classList.add('scale-95', 'opacity-0', 'invisible');
                languageChevron.style.transform = 'rotate(0deg)';
            }
        });

        // Fonction pour initialiser la langue au chargement
        function initializeLanguage() {
            if (currentLanguage && translations[currentLanguage]) {
                updateLanguageDisplay(currentLanguage);
                updateTranslations(currentLanguage);
                updateHiddenLanguageField(currentLanguage);
            }
        }

        // Fonction pour changer de langue
        function changeLanguage(lang) {
            if (!translations[lang]) return;

            currentLanguage = lang;

            // Mettre à jour l'affichage
            updateLanguageDisplay(lang);
            updateTranslations(lang);
            updateHiddenLanguageField(lang);

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

        // Mettre à jour le champ caché de langue
        function updateHiddenLanguageField(lang) {
            const localeMap = {
                'fr': 'fr_fr',
                'en': 'en_us',
                'it': 'it_it'
            };
            langueInput.value = localeMap[lang] || 'fr_fr';
        }

        // Envoyer la langue au serveur via AJAX
        function updateServerLanguage(lang) {
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
