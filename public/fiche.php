<?php

// Partie 1 : je charge les fonctions et la liste des compétences.
require_once __DIR__ . '/../inc/fonctions.php';

$competences = require __DIR__ . '/../data/competences.php';

// Partie 2 : je prépare les variables qui serviront à afficher la page.
$competenceTrouvee = null;
$messageErreur = null;

// Le ?? évite une erreur si id n'existe pas dans l'URL.
$idRecu = $_GET['id'] ?? null;

// Partie 3 : je vérifie ce que l'utilisateur a mis dans l'URL.
if ($idRecu === null) {
    $messageErreur = 'Identifiant absent. Essayez par exemple avec ?id=3.';
} elseif (!is_string($idRecu) || !ctype_digit($idRecu)) {
    $messageErreur = 'Identifiant invalide : il doit être un nombre entier.';
} else {
    $idRecherche = (int) $idRecu;

    // Partie 4 : je cherche la compétence qui a cet identifiant.
    foreach ($competences as $competence) {
        if ($competence['id'] === $idRecherche) {
            $competenceTrouvee = $competence;
            break;
        }
    }

    if ($competenceTrouvee === null) {
        $messageErreur = 'Aucune compétence ne correspond à cet identifiant.';
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SkillSwap — Fiche compétence</title>

    <!-- Partie 5 : les couleurs utilisées pour les badges. -->
    <style>
        body {
            max-width: 800px;
            margin: 2rem auto;
            padding: 0 1rem;
            font-family: Arial, sans-serif;
            line-height: 1.5;
        }

        .badge {
            display: inline-block;
            padding: 0.2rem 0.5rem;
            border-radius: 0.3rem;
        }

        .badge-personne {
            background: #f8d7da;
            color: #842029;
        }

        .badge-peu {
            background: #fff3cd;
            color: #664d03;
        }

        .badge-bien {
            background: #d1e7dd;
            color: #0f5132;
        }

        .erreur {
            color: #842029;
        }
    </style>
</head>
<body>
    <h1>Fiche de compétence</h1>

    <!-- Partie 6 : j'affiche la fiche ou un message d'erreur. -->
    <?php if ($messageErreur !== null): ?>
        <p class="erreur"><?= echapper($messageErreur) ?></p>
    <?php else: ?>
        <?php $badge = obtenirBadge((int) $competenceTrouvee['nb_maitrises']); ?>

        <h2><?= echapper($competenceTrouvee['libelle']) ?></h2>

        <p>
            <strong>Catégorie :</strong>
            <?= echapper($competenceTrouvee['categorie']) ?>
        </p>

        <p>
            <strong>Description :</strong>
            <?= echapper($competenceTrouvee['description']) ?>
        </p>

        <p>
            <strong>Nombre de maîtrises :</strong>
            <?= (int) $competenceTrouvee['nb_maitrises'] ?>
        </p>

        <p>
            <strong>Couverture :</strong>
            <span class="badge <?= echapper($badge['classe']) ?>">
                <?= echapper($badge['texte']) ?>
            </span>
        </p>
    <?php endif; ?>

    <p><a href="index.php">Retour à l’accueil</a></p>
</body>
</html>
