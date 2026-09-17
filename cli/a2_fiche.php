<?php
    $prenom = "Ella";
    $nom = "MAHIEU";
    $service = "informatique";

    echo 'Ce collaborateur est appelé $nom $prenom et travaille au service $service \n ';
    echo "Ce collaborateur s'appelle $nom $prenom et travaille au service $service \n";
    echo "Ce collaborateur s'appelle " . $nom . " " . $prenom . " "  . "et travaille au service " . $service . "\n";

    /* Les guillemets simples retournent le texte "bêtement" sans interpréter les variables */
?>
