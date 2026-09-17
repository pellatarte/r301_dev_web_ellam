<?php
    
    function libelleNiveau($niveau) {
        $libelle = match ($niveau) {
            1 => "Notions",
            2 => "Débutant",
            3 => "Intermédiaire",
            4 => "Confirmé",
            5 => "Expert",
        };
    }
    
    $nombre = 0;

    do {
        $saisie = readline("Quel est votre niveau (un chiffre entre 1 et 5 est attendu) : ");
            if (is_numeric($saisie) and ($saisie >= 1 and $saisie <= 5)) {
                $nombre = (int) $saisie;
            } 
            else {
                echo "réessayez avec un nombre entre 1 et 5...";
            }
    } while ($nombre < 1 or $nombre > 5);
    
?>
