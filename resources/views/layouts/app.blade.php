<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

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
@include('layouts.navigation')

<!-- Page Heading -->
@isset($header)
    <header class="bg-white dark:bg-gray-800 shadow">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            {{ $header }}
        </div>
    </header>
@endisset

<!-- Page Content -->
<main class="flex-1">
    @yield('content')
</main>

<script>
    // Script pour le menu mobile et les langues (à adapter selon vos besoins)
    document.addEventListener('DOMContentLoaded', function() {
        const mobileMenuButton = document.getElementById('mobile-menu-button');
        const mobileMenu = document.getElementById('mobile-menu');
        const hamburger = mobileMenuButton?.querySelector('.hamburger');

        if (mobileMenuButton && mobileMenu) {
            mobileMenuButton.addEventListener('click', function() {
                const isOpen = !mobileMenu.classList.contains('invisible');

                if (isOpen) {
                    // Fermer
                    mobileMenu.classList.add('scale-95', 'opacity-0');
                    setTimeout(() => {
                        mobileMenu.classList.add('invisible');
                    }, 200);
                    hamburger?.classList.remove('hamburger-open');
                } else {
                    // Ouvrir
                    mobileMenu.classList.remove('invisible');
                    setTimeout(() => {
                        mobileMenu.classList.remove('scale-95', 'opacity-0');
                    }, 10);
                    hamburger?.classList.add('hamburger-open');
                }
            });
        }

        // Gestion du dropdown de langue
        const languageButton = document.getElementById('language-button');
        const languageDropdown = document.getElementById('language-dropdown');

        if (languageButton && languageDropdown) {
            languageButton.addEventListener('click', function() {
                const isOpen = !languageDropdown.classList.contains('invisible');

                if (isOpen) {
                    languageDropdown.classList.add('scale-95', 'opacity-0');
                    setTimeout(() => {
                        languageDropdown.classList.add('invisible');
                    }, 200);
                } else {
                    languageDropdown.classList.remove('invisible');
                    setTimeout(() => {
                        languageDropdown.classList.remove('scale-95', 'opacity-0');
                    }, 10);
                }
            });
        }

        // Fermer les menus en cliquant à l'extérieur
        document.addEventListener('click', function(event) {
            if (mobileMenu && !mobileMenuButton?.contains(event.target) && !mobileMenu.contains(event.target)) {
                mobileMenu.classList.add('scale-95', 'opacity-0');
                setTimeout(() => {
                    mobileMenu.classList.add('invisible');
                }, 200);
                hamburger?.classList.remove('hamburger-open');
            }

            if (languageDropdown && !languageButton?.contains(event.target) && !languageDropdown.contains(event.target)) {
                languageDropdown.classList.add('scale-95', 'opacity-0');
                setTimeout(() => {
                    languageDropdown.classList.add('invisible');
                }, 200);
            }
        });
    });
</script>
</body>
</html>
