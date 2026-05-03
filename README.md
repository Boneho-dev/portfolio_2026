# Agre Agency - Portfolio Professionnel 2026

## Présentation

Portfolio professionnel de **NIONDJUI BONEHO ANGE-KEVIN AGRE**, développeur d'applications Web Full-Stack et fondateur d'Agre Agency.

Le site présente les compétences techniques, les réalisations et les services proposés. Il sert à la fois de vitrine personnelle pour une recherche d'alternance (rentrée 2026) et de point de contact pour des projets clients.

Basé à Angers, le développeur intervient dans toute la France et à l'international.

---

## Stack technique

| Technologie     | Usage                                                   |
| --------------- | ------------------------------------------------------- |
| PHP 8           | Traitement serveur, endpoint de contact, logique métier |
| HTML5           | Structure sémantique de la page                         |
| Tailwind CSS    | Système de design, mise en page responsive              |
| JavaScript ES6+ | Interactions, animations, requêtes AJAX                 |
| PHPMailer 7     | Envoi des emails via SMTP Gmail                         |
| Composer        | Gestion des dépendances PHP                             |

---

## Fonctionnalités

**Formulaire de contact sécurisé**

L'envoi de messages est géré par un endpoint dédié (`contact.php`) qui utilise PHPMailer pour l'acheminement via SMTP. Les entrées utilisateur sont assainies avec `htmlspecialchars` et `filter_var`. Un champ honeypot protège contre les soumissions automatisées.

**Communication asynchrone**

La soumission du formulaire utilise l'API Fetch (AJAX). La page ne se recharge pas. Le serveur répond en JSON. Le résultat est affiché dynamiquement sans interruption de navigation.

**Interface responsive**

La mise en page s'adapte à tous les formats d'écran via Tailwind CSS. Le curseur est personnalisé sur les environnements pointeur précis. Les animations au défilement sont gérées par l'API IntersectionObserver.

---

## Projets liés

**AGRE Custom**

Plateforme e-commerce développée à Angers. Elle intègre une gestion de contenu dynamique, un catalogue de produits interactif et une interface client optimisée pour les performances (Core Web Vitals, SEO, protection CSRF).

Lien : https://agre-custom-production.up.railway.app

**Fitness Tracker**

Application Web progressive (PWA) installable sans store. Elle propose un suivi sportif avec graphiques dynamiques (Chart.js), un fil d'actualité communautaire, une messagerie privée et une section vidéos. Authentification sécurisée par hachage bcrypt et sessions PHP.

Lien : https://fitness-pwa-production.up.railway.app

---

## Installation

### Prérequis

- Serveur Apache avec PHP 8 ou supérieur (XAMPP recommandé en local)
- Extension OpenSSL activée dans `php.ini`
- Composer installé

### Étapes

**1. Cloner le dépôt**

```bash
git clone https://github.com/Boneho-dev/portfolio_2026.git
cd portfolio_2026
```

**2. Installer les dépendances PHP**

```bash
php composer.phar install
```

**3. Configurer l'envoi d'emails**

Copier ou créer le fichier `config/mailer.php` à partir du modèle ci-dessous, puis renseigner le mot de passe d'application Gmail.

```php
<?php
define('MAIL_TO',           'agrekevin09@gmail.com');
define('MAIL_NAME',         'Ange-Kevin Agré — Agre Agency');
define('MAILER_HOST',       'smtp.gmail.com');
define('MAILER_PORT',       587);
define('MAILER_USERNAME',   'agrekevin09@gmail.com');
define('MAILER_PASSWORD',   'VOTRE_MOT_DE_PASSE_APPLICATION');
define('MAILER_FROM_EMAIL', 'agrekevin09@gmail.com');
define('MAILER_FROM_NAME',  'Agre Agency — Portfolio');
define('MAILER_CHARSET',    'UTF-8');
```

**4. Lancer le projet**

Déposer le dossier dans le répertoire `htdocs` de XAMPP et démarrer les modules Apache. Le site est accessible à l'adresse `http://localhost/portfolio_2026`.

---

## Structure du projet

```
portfolio_2026/
├── assets/
│   ├── css/
│   │   └── style.css
│   ├── images/
│   └── js/
│       └── main.js
├── config/
│   └── mailer.php
├── vendor/
├── contact.php
├── index.php
├── composer.json
└── composer.lock
```

---

## Contact

**NIONDJUI BONEHO ANGE-KEVIN AGRE**
Développeur Web Full-Stack — Fondateur d'Agre Agency

Email : agrekevin09@gmail.com
Localisation : Angers, France
LinkedIn : https://www.linkedin.com/in/ange-kevin-agre-a03b3a386
GitHub : https://github.com/Boneho-dev
