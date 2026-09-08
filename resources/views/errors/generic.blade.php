@php
    $code = $status ?? 500;
    $hint = $hint ?? null;

    [$title, $message] = match ($code) {
        400 => ['Requête invalide', 'La requête envoyée est incompréhensible ou non autorisée. Veuillez vérifier et revenir au tableau de bord.'],
        401 => ['Connexion requise', 'Vous devez vous connecter pour accéder à cette page.'],
        403 => ['Accès refusé', 'Vous n\'avez pas les droits d\'accès à cette page. Vous pouvez contacter l\'administrateur si c\'est une erreur.'],
        404 => ['Page non trouvée', 'La page que vous recherchez n\'est pas disponible ou a été déplacée vers une autre adresse.'],
        405 => ['Méthode non supportée', 'La méthode de requête utilisée n\'est pas supportée pour cette page.'],
        413 => ['Données trop volumineuses', 'Les données ou le fichier envoyé dépassent la limite autorisée. Essayez de réduire la taille ou de l\'envoyer par lots.'],
        419 => ['Session expirée', 'Votre session a expiré en raison d\'une inactivité prolongée. Veuillez revenir et réessayer.'],
        429 => ['Trop de requêtes', 'Vous avez envoyé un nombre excessif de requêtes en peu de temps. Patientez quelques instants puis réessayez.'],
        500 => ['Erreur inattendue', 'Une erreur inattendue s\'est produite lors de l\'opération. Le problème a été enregistré et sera résolu prochainement, veuillez réessayer.'],
        503 => ['Maintenance en cours', 'Nous mettons actuellement à jour le service. Veuillez revenir dans quelques instants.'],
        default => ['Erreur inattendue', 'Une erreur inattendue s\'est produite lors de l\'opération. Le problème a été enregistré et sera résolu prochainement, veuillez réessayer.'],
    };
@endphp
<!DOCTYPE html>
<html lang="fr" dir="ltr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex,nofollow">
    <title>{{ $code }} - {{ $title }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: Tahoma, 'Segoe UI', Arial, sans-serif;
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #e2e8f0;
            padding: 1rem;
        }
        .card {
            background: #1e293b;
            border: 1px solid #334155;
            border-radius: 1rem;
            padding: 3rem 2.5rem;
            max-width: 34rem;
            width: 100%;
            text-align: center;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.45);
        }
        .code {
            font-size: 3.5rem;
            font-weight: bold;
            color: #f59e0b;
            line-height: 1;
            margin-bottom: 0.75rem;
        }
        h1 { font-size: 1.4rem; margin-bottom: 0.75rem; color: #f8fafc; }
        p { font-size: 1rem; line-height: 1.8; color: #94a3b8; }
        .hint {
            margin-top: 1rem;
            padding: 0.75rem 1rem;
            background: #fef3c7;
            color: #92400e;
            border-radius: 0.5rem;
        }
        .actions { margin-top: 2rem; }
        .actions a {
            display: inline-block;
            padding: 0.7rem 1.6rem;
            background: #f59e0b;
            color: #0f172a;
            font-weight: bold;
            text-decoration: none;
            border-radius: 0.5rem;
            transition: background 0.2s;
        }
        .actions a:hover { background: #fbbf24; }
    </style>
</head>
<body>
    <div class="card">
        <div class="code">{{ $code }}</div>
        <h1>{{ $title }}</h1>
        <p>{{ $message }}</p>
        @if ($hint)
            <p class="hint">{{ $hint }}</p>
        @endif
        <div class="actions">
            <a href="{{ url('/') }}">Retour à l'accueil</a>
        </div>
    </div>
</body>
</html>