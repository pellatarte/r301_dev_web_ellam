# dev_web_ellam
# SkillSwap

Une app. interne qui repère les compétences cachées de chacun, transforme l'envie d'apprendre en vraies demandes, et connecte les gens autour du mentorat. Fini les talents planqués dans un coin.

> Projet en construction sur 9 séances : module **R3.01**.

---

## Stack

- **PHP 8** *le cœur du réacteur*
- **MySQL** via **PDO** *dès la séance 2, requêtes préparées obligatoires*
- **Docker** *tout tourne dans un conteneur, zéro prise de tête*

## Lancer le projet

```bash
docker compose up -d --build
```

Direction [http://localhost:8080](http://localhost:8080)

## Structure

```
skillswap/
├── cli/          # scripts PHP en ligne de commande
├── public/     
├── inc/      
└── data/         # les données
```

## Scripts CLI

Pas besoin de Docker pour ceux-là, juste PHP en local :

```bash
php cli/nom_du_script.php
```

## Avancement

- [x] **S1** — Premiers pas en PHP : CLI + premières pages dynamiques
- [x] **S2** — MySQL entre en scène (PDO, requêtes préparées)
- [ ] **S3** — 

## Auteur

**Ella MAHIEU**, BUT2 APP Informatique.
