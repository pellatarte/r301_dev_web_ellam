<?php

// Partie 1 : cette fonction échappe le texte avant de l'afficher en HTML.
function echapper(string $texte): string
{
    return htmlspecialchars($texte, ENT_QUOTES, 'UTF-8');
}

// Partie 2 : je choisis le badge à afficher selon le nombre de maîtrises.
function obtenirBadge(int $nombre): array
{
    if ($nombre === 0) {
        return [
            'texte' => 'Personne ne la maîtrise',
            'classe' => 'badge-personne',
        ];
    }

    if ($nombre <= 2) {
        return [
            'texte' => 'Peu couverte',
            'classe' => 'badge-peu',
        ];
    }

    return [
        'texte' => 'Bien couverte',
        'classe' => 'badge-bien',
    ];
}

?>