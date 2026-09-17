<?php
    $prenom = "Camille";
    $nom = "Marchand";

    $initPrenom = substr($prenom, 0, 1);
    $initNom = substr($nom, 0, 1);

    echo $initPrenom . "." . $initNom . ". \n";
    echo strtolower($prenom) . "." . strtolower($nom) . "@skillswap.fr \n";
    echo strtoupper($nom);

    $prenom = "Elodie";

    echo strlen($prenom);

    $prenom = "Élodie";

    echo strlen($prenom);
?>