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
