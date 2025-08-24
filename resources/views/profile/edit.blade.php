<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-[#1b1b18] dark:text-[#EDEDEC] leading-tight" data-translate="profile-title">
            {{ __('Votre profil') }}
        </h2>
    </x-slot>

    <!-- Styles personnalisés repris de la page de connexion -->
    <style>
        .minecraft-title {
            background: url('/images/grass_block.png') repeat;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-size: 40%;
        }

        .menu-transition {
            transition: all 0.2s ease-in-out;
        }

        .soft-shadow {
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
        }

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
    </style>

    <div class="py-6 bg-[#FDFDFC] dark:bg-[#0a0a0a] min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-900 soft-shadow rounded-xl border border-gray-100 dark:border-gray-700">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white dark:bg-gray-900 soft-shadow rounded-xl border border-gray-100 dark:border-gray-700">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white dark:bg-gray-900 soft-shadow rounded-xl border border-gray-100 dark:border-gray-700">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Définition des traductions pour le titre de la page profil
            const profileTranslations = {
                fr: {
                    'profile-title': 'Votre profil'
                },
                en: {
                    'profile-title': 'Your profile'
                },
                it: {
                    'profile-title': 'Il tuo profilo'
                }
            };

            // Fonction pour mettre à jour les traductions de cette page
            function updateProfileTranslations(lang) {
                const currentTranslations = profileTranslations[lang] || profileTranslations.fr;

                // Mettre à jour le titre
                const titleElement = document.querySelector('[data-translate="profile-title"]');
                if (titleElement && currentTranslations['profile-title']) {
                    titleElement.textContent = currentTranslations['profile-title'];
                }
            }

            // Appliquer les traductions initiales selon la langue de la session
            let currentLanguage = @json(session('language', 'fr_fr'));

            const sessionToJsLang = {
                'fr_fr': 'fr',
                'en_us': 'en',
                'it_it': 'it'
            };

            const currentLang = sessionToJsLang[currentLanguage] || 'fr';
            updateProfileTranslations(currentLang);

            // Observer les changements de langue via localStorage
            let lastLang = localStorage.getItem('preferredLanguage');
            setInterval(() => {
                const newLang = localStorage.getItem('preferredLanguage');
                if (newLang && newLang !== lastLang) {
                    lastLang = newLang;
                    updateProfileTranslations(newLang);
                }
            }, 100);

            // Écouter l'événement storage pour les changements entre onglets
            window.addEventListener('storage', function(e) {
                if (e.key === 'preferredLanguage' && e.newValue) {
                    updateProfileTranslations(e.newValue);
                }
            });

            // Rendre la fonction disponible globalement si nécessaire
            window.updateProfileTranslations = updateProfileTranslations;
        });
    </script>
</x-app-layout>
