<section class="space-y-6">
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100" data-translate="delete-account-title">
            {{ __('Delete Account') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400" data-translate="delete-account-warning">
            {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.') }}
        </p>
    </header>

    <x-danger-button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
        data-translate="delete-account-button"
    >{{ __('Delete Account') }}</x-danger-button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
            @csrf
            @method('delete')

            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100" data-translate="delete-confirm-title">
                {{ __('Are you sure you want to delete your account?') }}
            </h2>

            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400" data-translate="delete-confirm-warning">
                {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
            </p>

            <div class="mt-6">
                <x-input-label for="password" value="{{ __('Password') }}" class="sr-only" />

                <x-text-input
                    id="password"
                    name="password"
                    type="password"
                    class="mt-1 block w-3/4"
                    placeholder="{{ __('Password') }}"
                    data-translate-placeholder="password-placeholder"
                />

                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>

            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')" data-translate="cancel-button">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-danger-button class="ms-3" data-translate="delete-account-button">
                    {{ __('Delete Account') }}
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</section>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Définition des traductions pour cette page
        const deleteAccountTranslations = {
            fr: {
                'delete-account-title': 'Supprimer le compte',
                'delete-account-warning': 'Une fois votre compte supprimé, toutes ses ressources et données seront définitivement supprimées. Avant de supprimer votre compte, veuillez télécharger toutes les données ou informations que vous souhaitez conserver.',
                'delete-account-button': 'Supprimer le compte',
                'delete-confirm-title': 'Êtes-vous sûr de vouloir supprimer votre compte ?',
                'delete-confirm-warning': 'Une fois votre compte supprimé, toutes ses ressources et données seront définitivement supprimées. Veuillez saisir votre mot de passe pour confirmer que vous souhaitez supprimer définitivement votre compte.',
                'password-placeholder': 'Mot de passe',
                'cancel-button': 'Annuler'
            },
            en: {
                'delete-account-title': 'Delete Account',
                'delete-account-warning': 'Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.',
                'delete-account-button': 'Delete Account',
                'delete-confirm-title': 'Are you sure you want to delete your account?',
                'delete-confirm-warning': 'Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.',
                'password-placeholder': 'Password',
                'cancel-button': 'Cancel'
            },
            it: {
                'delete-account-title': 'Elimina account',
                'delete-account-warning': 'Una volta eliminato il tuo account, tutte le sue risorse e dati saranno eliminati permanentemente. Prima di eliminare il tuo account, scarica tutti i dati o le informazioni che desideri conservare.',
                'delete-account-button': 'Elimina account',
                'delete-confirm-title': 'Sei sicuro di voler eliminare il tuo account?',
                'delete-confirm-warning': 'Una volta eliminato il tuo account, tutte le sue risorse e dati saranno eliminati permanentemente. Inserisci la tua password per confermare che desideri eliminare permanentemente il tuo account.',
                'password-placeholder': 'Password',
                'cancel-button': 'Annulla'
            }
        };

        // Fonction pour mettre à jour les traductions de cette page
        function updateDeleteAccountTranslations(lang) {
            const currentTranslations = deleteAccountTranslations[lang] || deleteAccountTranslations.fr;

            // Mettre à jour tous les éléments avec data-translate
            document.querySelectorAll('[data-translate]').forEach(element => {
                const key = element.getAttribute('data-translate');
                if (currentTranslations[key]) {
                    element.textContent = currentTranslations[key];
                }
            });

            // Mettre à jour le placeholder du champ password
            const passwordInput = document.querySelector('[data-translate-placeholder="password-placeholder"]');
            if (passwordInput && currentTranslations['password-placeholder']) {
                passwordInput.placeholder = currentTranslations['password-placeholder'];
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
        updateDeleteAccountTranslations(currentLang);

        // Observer les changements de langue via localStorage
        let lastLang = localStorage.getItem('preferredLanguage');
        setInterval(() => {
            const newLang = localStorage.getItem('preferredLanguage');
            if (newLang && newLang !== lastLang) {
                lastLang = newLang;
                updateDeleteAccountTranslations(newLang);
            }
        }, 100);

        // Écouter l'événement storage pour les changements entre onglets
        window.addEventListener('storage', function(e) {
            if (e.key === 'preferredLanguage' && e.newValue) {
                updateDeleteAccountTranslations(e.newValue);
            }
        });

        // Rendre la fonction disponible globalement si nécessaire
        window.updateDeleteAccountTranslations = updateDeleteAccountTranslations;
    });
</script>
