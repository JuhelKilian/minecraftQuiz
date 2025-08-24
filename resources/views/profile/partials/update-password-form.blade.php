<section>
    <header>
        <h2 class="text-lg font-medium text-[#1b1b18] dark:text-[#EDEDEC]" data-translate="password-update-title">
            Modifier le mot de passe
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400" data-translate="password-update-desc">
            Assurez-vous que votre compte utilise un mot de passe long et aléatoire pour rester sécurisé.
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('put')

        <div>
            <x-input-label for="update_password_current_password" class="text-[#1b1b18] dark:text-[#EDEDEC]">
                <span data-translate="current-password-label">Mot de passe actuel</span>
            </x-input-label>
            <x-text-input id="update_password_current_password"
                          name="current_password"
                          type="password"
                          class="input-field mt-1 block w-full"
                          autocomplete="current-password" />
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="update_password_password" class="text-[#1b1b18] dark:text-[#EDEDEC]">
                <span data-translate="new-password-label">Nouveau mot de passe</span>
            </x-input-label>
            <x-text-input id="update_password_password"
                          name="password"
                          type="password"
                          class="input-field mt-1 block w-full"
                          autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="update_password_password_confirmation" class="text-[#1b1b18] dark:text-[#EDEDEC]">
                <span data-translate="confirm-password-label">Confirmer le mot de passe</span>
            </x-input-label>
            <x-text-input id="update_password_password_confirmation"
                          name="password_confirmation"
                          type="password"
                          class="input-field mt-1 block w-full"
                          autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center gap-4">
            <button type="submit"
                    class="bg-[#1b1b18] dark:bg-[#EDEDEC] text-[#FDFDFC] dark:text-[#1b1b18] px-6 py-2 rounded-lg hover:opacity-90 transition-all duration-200 font-medium focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#1b1b18] dark:focus:ring-[#EDEDEC]">
                <span data-translate="password-save-btn">Enregistrer</span>
            </button>

            @if (session('status') === 'password-updated')
                <p x-data="{ show: true }"
                   x-show="show"
                   x-transition
                   x-init="setTimeout(() => show = false, 2000)"
                   class="text-sm text-green-600 dark:text-green-400 font-medium">
                    <span data-translate="password-saved">Enregistré.</span>
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
        // Traductions pour le formulaire de mot de passe
        const passwordTranslations = {
            fr: {
                'password-update-title': 'Modifier le mot de passe',
                'password-update-desc': 'Assurez-vous que votre compte utilise un mot de passe long et aléatoire pour rester sécurisé.',
                'current-password-label': 'Mot de passe actuel',
                'new-password-label': 'Nouveau mot de passe',
                'confirm-password-label': 'Confirmer le mot de passe',
                'password-save-btn': 'Enregistrer',
                'password-saved': 'Enregistré.'
            },
            en: {
                'password-update-title': 'Update Password',
                'password-update-desc': 'Ensure your account is using a long, random password to stay secure.',
                'current-password-label': 'Current Password',
                'new-password-label': 'New Password',
                'confirm-password-label': 'Confirm Password',
                'password-save-btn': 'Save',
                'password-saved': 'Saved.'
            },
            it: {
                'password-update-title': 'Aggiorna password',
                'password-update-desc': 'Assicurati che il tuo account utilizzi una password lunga e casuale per rimanere sicuro.',
                'current-password-label': 'Password attuale',
                'new-password-label': 'Nuova password',
                'confirm-password-label': 'Conferma password',
                'password-save-btn': 'Salva',
                'password-saved': 'Salvato.'
            }
        };

        // Fonction pour mettre à jour les traductions du mot de passe
        function updatePasswordTranslations(lang) {
            const currentTranslations = passwordTranslations[lang] || passwordTranslations.fr;

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
        updatePasswordTranslations(getCurrentLanguage());

        // Observer les changements de langue depuis localStorage
        let lastLang = localStorage.getItem('preferredLanguage');
        setInterval(() => {
            const currentLang = localStorage.getItem('preferredLanguage');
            if (currentLang && currentLang !== lastLang) {
                lastLang = currentLang;
                updatePasswordTranslations(currentLang);
            }
        }, 100);

        // Écouter l'événement storage pour les changements entre onglets
        window.addEventListener('storage', function(e) {
            if (e.key === 'preferredLanguage' && e.newValue) {
                updatePasswordTranslations(e.newValue);
            }
        });

        // Rendre la fonction disponible globalement
        window.updatePasswordTranslations = updatePasswordTranslations;
    });
</script>
