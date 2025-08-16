<x-guest-layout>
    <!-- Sélecteur de langue en haut à droite -->
    <div class="absolute top-4 right-4">
        <div class="relative">
            <select id="language-selector" onchange="changeLanguage(this.value)" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm text-sm">
                <option value="fr" {{ app()->getLocale() == 'fr' ? 'selected' : '' }}>🇫🇷 FR</option>
                <option value="en" {{ app()->getLocale() == 'en' ? 'selected' : '' }}>🇺🇸 EN</option>
                <option value="it" {{ app()->getLocale() == 'it' ? 'selected' : '' }}>🇮🇹 IT</option>
            </select>
        </div>
    </div>

    <form method="POST" action="{{ route('register') }}" id="register-form">
        @csrf

        <!-- Champ langue caché qui sera rempli automatiquement -->
        <input type="hidden" id="langue" name="langue" value="{{
            Cookie::get('locale') == 'en' ? 'en_us' :
            (Cookie::get('locale') == 'it' ? 'it_it' : 'fr_fr')
        }}">

        <!-- Prénom -->
        <div>
            <x-input-label for="name" :value="__('Prénom')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="given-name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Nom de famille (facultatif) -->
        <div class="mt-4">
            <x-input-label for="nomFamille" :value="__('Nom de famille')" />
            <x-text-input id="nomFamille" class="block mt-1 w-full" type="text" name="nomFamille" :value="old('nomFamille')" autocomplete="family-name" />
            <x-input-error :messages="$errors->get('nomFamille')" class="mt-2" />
            <p class="text-sm text-gray-500 mt-1">{{ __('Facultatif') }}</p>
        </div>

        <!-- Adresse Email -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Adresse Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Mot de passe -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Mot de passe')" />
            <x-text-input id="password" class="block mt-1 w-full"
                          type="password"
                          name="password"
                          required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirmation du mot de passe -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirmer le mot de passe')" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                          type="password"
                          name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('login') }}">
                {{ __('Déjà inscrit ?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('S\'inscrire') }}
            </x-primary-button>
        </div>
    </form>

    <script>
        function changeLanguage(locale) {
            // Définir le cookie de langue
            document.cookie = `locale=${locale}; path=/; max-age=${60 * 60 * 24 * 30}`; // 30 jours

            // Mettre à jour le champ caché du formulaire
            const langueMapping = {
                'en': 'en_us',
                'it': 'it_it',
                'fr': 'fr_fr'
            };
            document.getElementById('langue').value = langueMapping[locale];

            // Rediriger vers la même page avec la nouvelle langue
            window.location.href = `{{ url()->current() }}?lang=${locale}`;
        }
    </script>
</x-guest-layout>
