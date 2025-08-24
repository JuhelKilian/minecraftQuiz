<section>
    <header>
        <h2 class="text-lg font-medium text-[#1b1b18] dark:text-[#EDEDEC]" data-translate="profile-info-title">
            Informations du profil
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400" data-translate="profile-info-desc">
            Mettez à jour les informations de votre compte et votre adresse email.
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="name" class="text-[#1b1b18] dark:text-[#EDEDEC]">
                <span data-translate="profile-name-label">Nom</span>
            </x-input-label>
            <x-text-input id="name"
                          name="name"
                          type="text"
                          class="input-field mt-1 block w-full"
                          :value="old('name', $user->name)"
                          required
                          autofocus
                          autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="email" class="text-[#1b1b18] dark:text-[#EDEDEC]">
                <span data-translate="profile-email-label">Email</span>
            </x-input-label>
            <x-text-input id="email"
                          name="email"
                          type="email"
                          class="input-field mt-1 block w-full"
                          :value="old('email', $user->email)"
                          required
                          autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-[#1b1b18] dark:text-[#EDEDEC]">
                        <span data-translate="email-unverified">Votre adresse email n'est pas vérifiée.</span>

                        <button form="send-verification"
                                class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-[#1b1b18] dark:hover:text-[#EDEDEC] rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#1b1b18] dark:focus:ring-[#EDEDEC] dark:focus:ring-offset-gray-800 transition-colors duration-200">
                            <span data-translate="resend-verification">Cliquez ici pour renvoyer l'email de vérification.</span>
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600 dark:text-green-400">
                            <span data-translate="verification-sent">Un nouveau lien de vérification a été envoyé à votre adresse email.</span>
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="flex items-center gap-4">
            <button type="submit"
                    class="bg-[#1b1b18] dark:bg-[#EDEDEC] text-[#FDFDFC] dark:text-[#1b1b18] px-6 py-2 rounded-lg hover:opacity-90 transition-all duration-200 font-medium focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#1b1b18] dark:focus:ring-[#EDEDEC]">
                <span data-translate="profile-save-btn">Enregistrer</span>
            </button>

            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }"
                   x-show="show"
                   x-transition
                   x-init="setTimeout(() => show = false, 2000)"
                   class="text-sm text-green-600 dark:text-green-400 font-medium">
                    <span data-translate="profile-saved">Enregistré.</span>
                </p>
            @endif
        </div>
    </form>
</section>

<style>
    /* Styles pour les inputs - cohérents avec la page de connexion */
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

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Traductions pour le formulaire de profil
        const profileTranslations = {
            fr: {
                'profile-info-title': 'Informations du profil',
                'profile-info-desc': 'Mettez à jour les informations de votre compte et votre adresse email.',
                'profile-name-label': 'Nom',
                'profile-email-label': 'Email',
                'email-unverified': 'Votre adresse email n\'est pas vérifiée.',
                'resend-verification': 'Cliquez ici pour renvoyer l\'email de vérification.',
                'verification-sent': 'Un nouveau lien de vérification a été envoyé à votre adresse email.',
                'profile-save-btn': 'Enregistrer',
                'profile-saved': 'Enregistré.'
            },
            en: {
                'profile-info-title': 'Profile Information',
                'profile-info-desc': 'Update your account\'s profile information and email address.',
                'profile-name-label': 'Name',
                'profile-email-label': 'Email',
                'email-unverified': 'Your email address is unverified.',
                'resend-verification': 'Click here to re-send the verification email.',
                'verification-sent': 'A new verification link has been sent to your email address.',
                'profile-save-btn': 'Save',
                'profile-saved': 'Saved.'
            },
            it: {
                'profile-info-title': 'Informazioni del profilo',
                'profile-info-desc': 'Aggiorna le informazioni del tuo account e l\'indirizzo email.',
                'profile-name-label': 'Nome',
                'profile-email-label': 'Email',
                'email-unverified': 'Il tuo indirizzo email non è verificato.',
                'resend-verification': 'Clicca qui per inviare nuovamente l\'email di verifica.',
                'verification-sent': 'Un nuovo link di verifica è stato inviato al tuo indirizzo email.',
                'profile-save-btn': 'Salva',
                'profile-saved': 'Salvato.'
            }
        };

        // Fonction pour mettre à jour les traductions du profil
        function updateProfileTranslations(lang) {
            const currentTranslations = profileTranslations[lang] || profileTranslations.fr;

            document.querySelectorAll('[data-translate]').forEach(element => {
                const key = element.getAttribute('data-translate');
                if (currentTranslations[key]) {
                    element.textContent = currentTranslations[key];
                }
            });
        }

        // Fonction pour récupérer la langue actuelle
        function getCurrentLanguage() {
            let currentLanguage = @json(session('language', 'fr_fr'));

            const sessionToJsLang = {
                'fr_fr': 'fr',
                'en_us': 'en',
                'it_it': 'it'
            };

            return sessionToJsLang[currentLanguage] || 'fr';
        }

        // Initialiser les traductions
        updateProfileTranslations(getCurrentLanguage());

        // Observer les changements de langue depuis localStorage
        let lastLang = localStorage.getItem('preferredLanguage');
        setInterval(() => {
            const currentLang = localStorage.getItem('preferredLanguage');
            if (currentLang && currentLang !== lastLang) {
                lastLang = currentLang;
                updateProfileTranslations(currentLang);
            }
        }, 100);

        // Écouter l'événement storage pour les changements entre onglets
        window.addEventListener('storage', function(e) {
            if (e.key === 'preferredLanguage' && e.newValue) {
                updateProfileTranslations(e.newValue);
            }
        });

        // Rendre la fonction disponible globalement
        window.updateProfileTranslations = updateProfileTranslations;
    });
</script>
