<?php

// Partie 1 : je charge mes fonctions et mes compétences.
require_once __DIR__ . '/../inc/fonctions.php';

$competences = require __DIR__ . '/../data/competences.php';

// Partie 2 : je prépare les données pour les statistiques.
$categories = array_unique(array_column($competences, 'categorie'));
sort($categories);

$nombreCompetences = count($competences);
$nombreCategories = count($categories);
$moyenneMaitrises = 0;

if ($nombreCompetences > 0) {
    $nombresDeMaitrises = array_column($competences, 'nb_maitrises');
    $moyenneMaitrises = array_sum($nombresDeMaitrises) / $nombreCompetences;
}

// Partie 3 : je lis le filtre et le tri demandés dans l'URL.
$categorieChoisie = $_GET['categorie'] ?? '';
$triDemande = ($_GET['tri'] ?? '') === 'maitrises';

// Je commence avec toutes les compétences.
$competencesAffichees = $competences;

// Partie 4 : si une catégorie est donnée, je filtre la liste.
if ($categorieChoisie !== '') {
    $competencesAffichees = array_filter(
        $competencesAffichees,
        function (array $competence) use ($categorieChoisie): bool {
            return $competence['categorie'] === $categorieChoisie;
        }
    );
}

// Partie 5 : le tri fait remonter les compétences les plus maîtrisées.
if ($triDemande) {
    usort(
        $competencesAffichees,
        function (array $competenceA, array $competenceB): int {
            return $competenceB['nb_maitrises'] <=> $competenceA['nb_maitrises'];
        }
    );
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SkillSwap — Accueil</title>

    <!-- Partie 6 : quelques styles pour rendre la page plus lisible. -->
    <style>
        body {
            max-width: 900px;
            margin: 2rem auto;
            padding: 0 1rem;
            font-family: Arial, sans-serif;
            line-height: 1.5;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 1rem;
        }

        th,
        td {
            padding: 0.7rem;
            border: 1px solid #ccc;
            text-align: left;
        }

        th {
            background: #f2f2f2;
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

        nav a {
            margin-right: 0.8rem;
        }
    </style>
</head>

<body>
    <!-- Partie 7 : le titre et le message d'accueil. -->
    <h1>SkillSwap</h1>

    <p>Bienvenue sur SkillSwap, la plateforme de partage de compétences.</p>

    <!-- La date et la version sont générées par PHP. -->
    <p>Date du jour : <?= echapper(date('d/m/Y')) ?></p>
    <p>Version de PHP : <?= echapper(PHP_VERSION) ?></p>

    <!-- Partie 8 : les statistiques de l'extension B6.1. -->
    <h2>Statistiques</h2>

    <ul>
        <li>Nombre total de compétences : <?= $nombreCompetences ?></li>
        <li>Nombre de catégories distinctes : <?= $nombreCategories ?></li>
        <li>
            Moyenne des maîtrises :
            <?= number_format($moyenneMaitrises, 1, ',', ' ') ?>
        </li>
    </ul>

    <!-- Partie 9 : les liens de filtre par catégorie. -->
    <h2>Liste des compétences</h2>

    <nav aria-label="Filtrer par catégorie">
        <a href="index.php">Toutes</a>

        <?php foreach ($categories as $categorie): ?>
            <a href="index.php?categorie=<?= rawurlencode($categorie) ?>">
                <?= echapper($categorie) ?>
            </a>
        <?php endforeach; ?>
    </nav>

    <!-- Partie 10 : lien pour trier par nombre de maîtrises. -->
    <p>
        <a href="index.php?<?= http_build_query([
                                'categorie' => $categorieChoisie,
                                'tri' => 'maitrises',
                            ]) ?>">
            Trier par maîtrises décroissantes
        </a>
    </p>

    <!-- Partie 11 : je signale les catégories invalides ou sans résultat. -->
    <?php if (
        $categorieChoisie !== ''
        && !in_array($categorieChoisie, $categories, true)
    ): ?>
        <p>Cette catégorie n'existe pas.</p>
    <?php elseif (count($competencesAffichees) === 0): ?>
        <p>Aucune compétence à afficher.</p>
    <?php else: ?>

        <!-- Partie 12 : le tableau de compétences commence ici. -->
        <table>
            <thead>
                <tr>
                    <th>Libellé</th>
                    <th>Catégorie</th>
                    <th>Personnes qui maîtrisent</th>
                    <th>Couverture</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($competencesAffichees as $competence): ?>
                    <?php $badge = obtenirBadge((int) $competence['nb_maitrises']); ?>

                    <tr>
                        <td>
                            <a href="fiche.php?id=<?= (int) $competence['id'] ?>">
                                <?= echapper($competence['libelle']) ?>
                            </a>
                        </td>
                        <td><?= echapper($competence['categorie']) ?></td>
                        <td><?= (int) $competence['nb_maitrises'] ?></td>
                        <td>
                            <span class="badge <?= echapper($badge['classe']) ?>">
                                <?= echapper($badge['texte']) ?>
                            </span>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</body>

</html>