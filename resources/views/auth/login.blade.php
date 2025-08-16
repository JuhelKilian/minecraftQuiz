<!DOCTYPE html>
<html lang="{{ session('language', 'fr') }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@lang('Connexion') - Quiz Minecraft</title>
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

        /* Styles pour le checkbox */
        .checkbox-custom {
            width: 1rem;
            height: 1rem;
            border-radius: 0.25rem;
            border: 1px solid #d1d5db;
            background-color: white;
            transition: all 0.15s ease-in-out;
        }

        .dark .checkbox-custom {
            background-color: #111827;
            border-color: #374151;
        }

        .checkbox-custom:checked {
            background-color: #1b1b18;
            border-color: #1b1b18;
        }

        .dark .checkbox-custom:checked {
            background-color: #EDEDEC;
            border-color: #EDEDEC;
        }

        /* Styles pour les alertes de statut */
        .status-alert {
            background-color: #dcfce7;
            border: 1px solid #bbf7d0;
            color: #166534;
            padding: 0.75rem;
            border-radius: 0.5rem;
            font-size: 0.875rem;
            margin-bottom: 1rem;
        }

        .dark .status-alert {
            background-color: #065f46;
            border-color: #059669;
            color: #d1fae5;
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
            Connectez-vous à votre compte
        </p>
    </div>

    <!-- Formulaire de connexion -->
    <div class="w-full sm:max-w-md px-6 py-8 bg-white dark:bg-gray-900 shadow-lg soft-shadow rounded-xl">

        <!-- Status de session (messages de succès) -->
        @if (session('status'))
            <div class="status-alert" data-translate="session-status">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}" id="login-form">
            @csrf

            <!-- Adresse Email -->
            <div>
                <label for="email" class="block font-medium text-sm text-gray-700 dark:text-gray-300 mb-2" data-translate="label-email">
                    Adresse Email
                </label>
                <input id="email" class="input-field block mt-1 w-full @error('email') input-error @enderror"
                       type="email"
                       name="email"
                       value="{{ old('email') }}"
                       required
                       autofocus
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
                       autocomplete="current-password" />
                @error('password')
                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- Se souvenir de moi -->
            <div class="block mt-4">
                <label for="remember_me" class="inline-flex items-center">
                    <input id="remember_me"
                           type="checkbox"
                           class="checkbox-custom focus:ring-2 focus:ring-[#1b1b18] dark:focus:ring-[#EDEDEC] focus:ring-offset-0"
                           name="remember">
                    <span class="ml-2 text-sm text-gray-600 dark:text-gray-400" data-translate="remember-me">
                        Se souvenir de moi
                    </span>
                </label>
            </div>

            <div class="flex items-center justify-between mt-6">
                @if (Route::has('password.request'))
                    <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
                       href="{{ route('password.request') }}"
                       data-translate="forgot-password">
                        Mot de passe oublié ?
                    </a>
                @endif

                <button type="submit" class="bg-[#1b1b18] dark:bg-[#EDEDEC] text-[#FDFDFC] dark:text-[#1b1b18] px-6 py-2 rounded-lg hover:opacity-90 transition-all duration-200 font-medium focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#1b1b18] dark:focus:ring-[#EDEDEC]">
                    <span data-translate="btn-login">Se connecter</span>
                </button>
            </div>
        </form>

        <!-- Séparateur -->
        <div class="mt-6 pt-6 border-t border-gray-200 dark:border-gray-700 text-center">
            <p class="text-sm text-gray-600 dark:text-gray-400">
                <span data-translate="no-account">Pas encore de compte ?</span>
                <a href="{{ route('register') }}" class="font-medium text-[#1b1b18] dark:text-[#EDEDEC] hover:underline ml-1" data-translate="create-account">
                    Créer un compte
                </a>
            </p>
        </div>
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
            'subtitle': 'Connectez-vous à votre compte',
            'label-email': 'Adresse Email',
            'label-password': 'Mot de passe',
            'remember-me': 'Se souvenir de moi',
            'forgot-password': 'Mot de passe oublié ?',
            'btn-login': 'Se connecter',
            'no-account': 'Pas encore de compte ?',
            'create-account': 'Créer un compte',
            'back-home': '← Retour à l\'accueil'
        },
        en: {
            'site-title': 'Minecraft Quiz',
            'subtitle': 'Sign in to your account',
            'label-email': 'Email Address',
            'label-password': 'Password',
            'remember-me': 'Remember me',
            'forgot-password': 'Forgot your password?',
            'btn-login': 'Sign in',
            'no-account': 'Don\'t have an account?',
            'create-account': 'Create account',
            'back-home': '← Back to home'
        },
        it: {
            'site-title': 'Quiz Minecraft',
            'subtitle': 'Accedi al tuo account',
            'label-email': 'Indirizzo Email',
            'label-password': 'Password',
            'remember-me': 'Ricordami',
            'forgot-password': 'Password dimenticata?',
            'btn-login': 'Accedi',
            'no-account': 'Non hai ancora un account?',
            'create-account': 'Crea account',
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
