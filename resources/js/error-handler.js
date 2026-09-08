window.FriendlyErrorHandler = (() => {
    let toastEl = null;

    const MESSAGES = {
        400: { title: 'Requête invalide', body: 'Les données envoyées n\'ont pas été comprises. Veuillez vérifier et réessayer.' },
        401: { title: 'Connexion requise', body: 'Vous devez vous connecter pour accéder à cette page.' },
        403: { title: 'Accès refusé', body: 'Vous n\'avez pas les droits pour effectuer cette opération.' },
        404: { title: 'Non trouvé', body: 'L\'élément ou la page demandé n\'est pas disponible.' },
        405: { title: 'Méthode non supportée', body: 'La requête a été envoyée de manière incorrecte.' },
        413: { title: 'Données trop volumineuses', body: 'Le fichier ou les données dépassent la limite autorisée.' },
        419: { title: 'Session expirée', body: 'La session a expiré. Vous allez être redirigé vers la connexion.' },
        429: { title: 'Trop de requêtes', body: 'Trop de requêtes envoyées. Patientez quelques instants puis réessayez.' },
        500: { title: 'Erreur inattendue', body: 'Une erreur s\'est produite lors de l\'opération. Le problème a été enregistré, veuillez réessayer.' },
        503: { title: 'Maintenance en cours', body: 'Le service est en cours de mise à jour, veuillez réessayer plus tard.' },
    };

    function messageFor(status) {
        return MESSAGES[status] ?? {
            title: 'Erreur inattendue',
            body: 'Une erreur s\'est produite lors de l\'opération. Le problème a été enregistré, veuillez réessayer.',
        };
    }

    function ensureToast() {
        if (toastEl) {
            return toastEl;
        }

        const style = document.createElement('style');
        style.id = 'friendly-error-style';
        style.textContent = `
            #friendly-error-toast {
                position: fixed;
                inset-inline-start: 1rem;
                top: 1rem;
                z-index: 99999;
                max-width: 24rem;
                background: #7f1d1d;
                color: #fef2f2;
                border: 1px solid #fecaca;
                border-radius: 0.75rem;
                padding: 0.9rem 1.1rem;
                font-family: Tahoma, 'Segoe UI', Arial, sans-serif;
                font-size: 0.9rem;
                line-height: 1.6;
                box-shadow: 0 12px 32px rgba(0, 0, 0, 0.35);
                opacity: 0;
                transform: translateY(-12px);
                transition: opacity 0.2s, transform 0.2s;
                box-sizing: border-box;
            }
            #friendly-error-toast.is-visible {
                opacity: 1;
                transform: translateY(0);
            }
            #friendly-error-toast .friendly-error-title {
                font-weight: bold;
                margin-bottom: 0.25rem;
            }
            #friendly-error-toast .friendly-error-close {
                float: inline-end;
                background: transparent;
                border: 0;
                color: inherit;
                font-size: 1.1rem;
                line-height: 1;
                cursor: pointer;
                padding: 0 0.25rem;
            }
        `;
        document.head.appendChild(style);

        const toast = document.createElement('div');
        toast.id = 'friendly-error-toast';
        toast.setAttribute('dir', 'ltr');
        document.body.appendChild(toast);

        toastEl = toast;

        return toast;
    }

    function showError(status) {
        const toast = ensureToast();
        const { title, body } = messageFor(status);

        toast.innerHTML = `
            <button type="button" class="friendly-error-close" aria-label="Fermer">&times;</button>
            <div class="friendly-error-title">${title}</div>
            <div>${body}</div>
        `;

        toast.querySelector('.friendly-error-close').addEventListener('click', () => {
            toast.classList.remove('is-visible');
        });

        toast.classList.add('is-visible');

        setTimeout(() => toast.classList.remove('is-visible'), 6000);
    }

    function registerLivewireHook() {
        if (typeof window.Livewire?.interceptMessage !== 'function') {
            return false;
        }

        window.Livewire.interceptMessage(({ onError }) => {
            onError?.(({ response, preventDefault }) => {
                const status = response?.status;
                console.error('[friendly-error] Livewire request failed', { status });

                if (typeof preventDefault === 'function') {
                    preventDefault();
                }

                showError(status);

                if (status === 419) {
                    setTimeout(() => window.location.reload(), 1500);
                }
            });
        });

        return true;
    }

    function boot(attempts = 0) {
        if (registerLivewireHook()) {
            return;
        }

        if (attempts >= 100) {
            return;
        }

        setTimeout(() => boot(attempts + 1), 100);
    }

    window.addEventListener('error', (event) => {
        console.error('[friendly-error] uncaught error', event.error ?? event.message);
    });

    return { boot };
})();

window.FriendlyErrorHandler.boot();