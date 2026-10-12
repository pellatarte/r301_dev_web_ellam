-- TP2 — SkillSwap — Partie B : requêtes SQL
--
-- Les requêtes ci-dessous sont les requêtes à exécuter dans Adminer.
-- Elles ne contiennent aucun résultat inventé : les résultats sont ceux de la base.
-- Moteur visé : MySQL 8.x.
--
-- Schéma utilisé par le sujet :
--   competence (avec libelle et categorie_id)
--   categorie (avec libelle)
--   collaborateur (avec une date d'arrivée)
--   maitrise (relation collaborateur <-> competence)
--
-- Si DESCRIBE révèle un nom de colonne différent pour la date d'arrivée ou
-- les clés de maitrise, remplacer uniquement ce nom dans les requêtes concernées.

/* ========================================================================== */
/* B1 — RECONNAÎTRE LE TERRAIN                                               */
/* ========================================================================== */

-- Explorer les tables présentes dans la base.
SHOW TABLES;

-- Explorer la structure des tables utiles et les clés étrangères.
DESCRIBE competence;
DESCRIBE categorie;
DESCRIBE collaborateur;
DESCRIBE maitrise;

-- Question 1 — La table qui relie les collaborateurs aux compétences est
-- maitrise. Elle porte le lien via collaborateur_id et competence_id, ainsi
-- qu'une information complémentaire propre à ce lien (à lire dans DESCRIBE
-- maitrise, par exemple un niveau ou une date selon le schéma fourni).
-- La requête suivante permet de vérifier les colonnes réellement présentes.
SHOW COLUMNS FROM maitrise;

-- Question 2 — session_mentorat est un nom explicite qui évite l'ambiguïté
-- avec le mot session (réservé ou générique selon les outils SQL) et précise
-- qu'il s'agit d'une session de mentorat.
-- Vérification de l'existence et de la structure de la table :
DESCRIBE session_mentorat;

-- Question 3 — Nombre de lignes de la table maitrise.
SELECT COUNT(*) AS nombre_lignes_maitrise
FROM maitrise;

/* ========================================================================== */
/* B2 — PREMIÈRES SÉLECTIONS                                                 */
/* ========================================================================== */

-- 1. Toutes les compétences, triées par libellé.
SELECT *
FROM competence
ORDER BY libelle ASC;

-- 2. Les compétences dont le libellé contient « SQL ».
SELECT *
FROM competence
WHERE libelle LIKE '%SQL%'
ORDER BY libelle ASC;

-- 3. Les collaborateurs arrivés après le 1er janvier 2022,
--    du plus récent au plus ancien.
-- Le sujet emploie ici la colonne date_arrivee du schéma SkillSwap.
SELECT *
FROM collaborateur
WHERE date_arrivee > '2022-01-01'
ORDER BY date_arrivee DESC;

/* ========================================================================== */
/* B3 — JOINTURE AVEC LA CATÉGORIE                                           */
/* ========================================================================== */

-- Le préfixe c. désigne competence et cat. désigne categorie :
-- les deux tables ont une colonne libelle.
SELECT
    c.libelle   AS competence,
    cat.libelle AS categorie
FROM competence AS c
JOIN categorie AS cat
    ON cat.id = c.categorie_id
ORDER BY c.libelle ASC;

/* ========================================================================== */
/* B4 — COMPTER LES PERSONNES QUI MAÎTRISENT CHAQUE COMPÉTENCE                */
/* ========================================================================== */

-- 1. Première version demandée : JOIN (INNER JOIN).
-- Elle ne conserve que les compétences qui ont au moins une ligne dans
-- maitrise. COUNT(*) compte les lignes de la jointure.
SELECT
    c.libelle AS competence,
    COUNT(*)  AS nombre_personnes
FROM competence AS c
JOIN maitrise AS m
    ON m.competence_id = c.id
GROUP BY c.id, c.libelle
ORDER BY c.libelle ASC;

-- 2. Compter le nombre total de compétences, puis comparer avec la liste
--    produite par l'INNER JOIN.
SELECT COUNT(*) AS nombre_competences
FROM competence;

-- Compétences absentes de la première requête (donc sans ligne de maitrise).
SELECT
    c.id,
    c.libelle
FROM competence AS c
LEFT JOIN maitrise AS m
    ON m.competence_id = c.id
WHERE m.competence_id IS NULL
ORDER BY c.libelle ASC;

-- 3. Correction : LEFT JOIN et COUNT(m.competence_id).
-- Il faut compter une colonne de maitrise, et non COUNT(*), afin qu'une
-- compétence sans maîtrise obtienne 0 plutôt que 1.
SELECT
    c.id,
    c.libelle AS competence,
    COUNT(m.competence_id) AS nombre_personnes
FROM competence AS c
LEFT JOIN maitrise AS m
    ON m.competence_id = c.id
GROUP BY c.id, c.libelle
ORDER BY c.libelle ASC;

-- Variante de B4 avec la catégorie, utile pour la requête de l'après-midi.
SELECT
    c.id,
    c.libelle   AS competence,
    cat.libelle AS categorie,
    COUNT(m.competence_id) AS nombre_personnes
FROM competence AS c
JOIN categorie AS cat
    ON cat.id = c.categorie_id
LEFT JOIN maitrise AS m
    ON m.competence_id = c.id
GROUP BY c.id, c.libelle, cat.id, cat.libelle
ORDER BY c.libelle ASC;

/* ========================================================================== */
/* B5 — REQUÊTES FACULTATIVES                                               */
/* ========================================================================== */

-- 1. Les trois compétences les mieux couvertes.
SELECT
    c.id,
    c.libelle AS competence,
    COUNT(m.competence_id) AS nombre_personnes
FROM competence AS c
LEFT JOIN maitrise AS m
    ON m.competence_id = c.id
GROUP BY c.id, c.libelle
ORDER BY nombre_personnes DESC, c.libelle ASC
LIMIT 3;

-- 2. Pour chaque catégorie, le nombre de compétences qu'elle contient.
SELECT
    cat.id,
    cat.libelle AS categorie,
    COUNT(c.id) AS nombre_competences
FROM categorie AS cat
LEFT JOIN competence AS c
    ON c.categorie_id = cat.id
GROUP BY cat.id, cat.libelle
ORDER BY cat.libelle ASC;

-- 3. Les collaborateurs qui ne maîtrisent aucune compétence.
SELECT
    co.*
FROM collaborateur AS co
WHERE NOT EXISTS (
    SELECT 1
    FROM maitrise AS m
    WHERE m.collaborateur_id = co.id
)
ORDER BY co.id ASC;

/* ========================================================================== */
/* RAPPEL                                                                    */
/* ========================================================================== */

-- La requête de référence à réutiliser pour remplacer nb_maitrises dans les
-- pages PHP est la requête LEFT JOIN de B4 (celle qui compte
-- m.competence_id). Ne pas placer ce fichier dans sql/ : le sujet demande
-- notes/mes-requetes.sql, car les fichiers de sql/ sont rejoués par MySQL.
