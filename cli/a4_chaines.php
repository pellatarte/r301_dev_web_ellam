<?php
    $prenom = "Camille";
    $nom = "Marchand";

    $initPrenom = substr($prenom, 0, 1);
    $initNom = substr($nom, 0, 1);

    echo $initPrenom . "." . $initNom . ". \n";
    echo strtolower($prenom) . "." . strtolower($nom) . "@skillswap.fr \n";
    echo strtoupper($nom);

    $prenom = "Elodie";

    echo strlen($prenom) . "\n";

    $prenom = "Élodie";

    echo strlen($prenom). "\n"; 

    /* on nous ressort qu'il y a un caractère en plus à cause de l'accent aigu */
?>