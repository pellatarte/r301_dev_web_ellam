<?php

// Partie 1 : je crée une compétence toute seule pour commencer.
$competence = [
    'id' => 1,
    'libelle' => 'PHP 8',
    'categorie' => 'Développement',
    'nb_maitrises' => 4,
];

// Partie 2 : j'affiche la phrase demandée.
echo $competence['libelle']
    . ' (' . $competence['categorie'] . ') — '
    . $competence['nb_maitrises']
    . " personnes la maîtrisent.\n";

// Partie 3 : ici je regarde chaque clé et chaque valeur.
echo "\nJe parcours la compétence :\n";

foreach ($competence as $cle => $valeur) {
    echo $cle . ' : ' . $valeur . "\n";
}

// Partie 4 : maintenant je fais une liste de trois compétences.
$competences = [
    [
        'id' => 1,
        'libelle' => 'PHP 8',
        'categorie' => 'Développement',
        'nb_maitrises' => 4,
    ],
    [
        'id' => 2,
        'libelle' => 'HTML',
        'categorie' => 'Web',
        'nb_maitrises' => 6,
    ],
    [
        'id' => 3,
        'libelle' => 'Git',
        'categorie' => 'Outils',
        'nb_maitrises' => 2,
    ],
];

// Partie 5 : j'affiche seulement le libellé de chacune.
echo "\nLes libellés :\n";

foreach ($competences as $competence) {
    echo $competence['libelle'] . "\n";
}

// Partie 6 : version courte avec array_column et array_sum.
$nombresDeMaitrises = array_column($competences, 'nb_maitrises');
$total = array_sum($nombresDeMaitrises);

echo "\nTotal avec les fonctions PHP : $total\n";

// Partie 7 : je refais le total avec une boucle pour vérifier.
$total = 0;

foreach ($competences as $competence) {
    $total += $competence['nb_maitrises'];
}

echo "Total avec foreach : $total\n";