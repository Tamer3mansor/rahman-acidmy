window.FriendlyErrorHandler=(()=>{let e=null,t={400:{title:`Requête invalide`,body:`Les données envoyées n'ont pas été comprises. Veuillez vérifier et réessayer.`},401:{title:`Connexion requise`,body:`Vous devez vous connecter pour accéder à cette page.`},403:{title:`Accès refusé`,body:`Vous n'avez pas les droits pour effectuer cette opération.`},404:{title:`Non trouvé`,body:`L'élément ou la page demandé n'est pas disponible.`},405:{title:`Méthode non supportée`,body:`La requête a été envoyée de manière incorrecte.`},413:{title:`Données trop volumineuses`,body:`Le fichier ou les données dépassent la limite autorisée.`},419:{title:`Session expirée`,body:`La session a expiré. Vous allez être redirigé vers la connexion.`},429:{title:`Trop de requêtes`,body:`Trop de requêtes envoyées. Patientez quelques instants puis réessayez.`},500:{title:`Erreur inattendue`,body:`Une erreur s'est produite lors de l'opération. Le problème a été enregistré, veuillez réessayer.`},503:{title:`Maintenance en cours`,body:`Le service est en cours de mise à jour, veuillez réessayer plus tard.`}};function n(e){return t[e]??{title:`Erreur inattendue`,body:`Une erreur s'est produite lors de l'opération. Le problème a été enregistré, veuillez réessayer.`}}function r(){if(e)return e;let t=document.createElement(`style`);t.id=`friendly-error-style`,t.textContent=`
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
            #friendly-error-toast .friendly-error-debug {
                margin-top: 0.5rem;
                font-family: Consolas, 'Courier New', monospace;
                font-size: 0.75rem;
                color: #fecaca;
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
        `,document.head.appendChild(t);let n=document.createElement(`div`);return n.id=`friendly-error-toast`,n.setAttribute(`dir`,`ltr`),document.body.appendChild(n),e=n,n}function i(e){let t=r(),{title:i,body:a}=n(e);t.innerHTML=`
            <button type="button" class="friendly-error-close" aria-label="Fermer">&times;</button>
            <div class="friendly-error-title">${i}</div>
            <div>${a}</div>
            <div class="friendly-error-debug">${e==null||e===0?`Le serveur n'a pas répondu (erreur réseau). Vérifiez la console.`:`HTTP ${e}`}</div>
        `,t.querySelector(`.friendly-error-close`).addEventListener(`click`,()=>{t.classList.remove(`is-visible`)}),t.classList.add(`is-visible`),setTimeout(()=>t.classList.remove(`is-visible`),6e3)}function a(){return typeof window.Livewire?.interceptMessage==`function`&&(window.Livewire.interceptMessage(({onError:e})=>{e?.(({response:e,preventDefault:t})=>{let n=e?.status;console.error(`[friendly-error] Livewire request failed`,{status:n}),typeof t==`function`&&t(),i(n),n===419&&setTimeout(()=>window.location.reload(),1500)})}),!0)}function o(e=0){a()||e>=100||setTimeout(()=>o(e+1),100)}return window.addEventListener(`error`,e=>{console.error(`[friendly-error] uncaught error`,e.error??e.message)}),{boot:o}})(),window.FriendlyErrorHandler.boot();