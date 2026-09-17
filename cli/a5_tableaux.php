<?php
    $competences = ["PHP 8", "Docker", "SQL", "Scrum", "Git"];
    
    echo count($competences) . "\n";

    foreach($competences as $index => $competence) {
        echo $index + 1 . " : " . $competence . "\n";
    }

    sort($competences);

    foreach($competences as $index => $competence) {
        echo $index + 1 . " : " . $competence . "\n";
    }

    $competences[] = "Symfony";

    echo $competences[5] . "\n"
?>