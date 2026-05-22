<?php
declare(strict_types=1);

/**
 * ╔══════════════════════════════════════════════════════════════════╗
 * ║   AGRE AGENCY — Portfolio & Vitrine Web                          ║
 * ║   Auteur  : Ange-Kevin Agré | agrekevin09@gmail.com              ║
 * ║   Stack   : PHP 8 · HTML5 · Tailwind CSS · Vanilla JS ES6+      ║
 * ║   Version : 1.2 | 2026 — AJAX + contact.php                     ║
 * ╚══════════════════════════════════════════════════════════════════╝
 *
 * Le formulaire de contact est géré entièrement côté client (fetch)
 * et délégué à contact.php qui répond en JSON. Ce fichier ne traite
 * aucune donnée POST.
 */
?>
<!DOCTYPE html>
<html lang="fr" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- SEO Meta -->
    <title>Agre Agency — Développeur Web Full-Stack & Fondateur | Ange-Kevin Agré</title>
    <meta name="description" content="Agre Agency — Création de sites web, applications sur mesure et solutions numériques innovantes. Basé à Angers & Toulouse. Disponible pour alternance 2026.">
    <meta name="author" content="Ange-Kevin Agré">
    <meta name="keywords" content="développeur web, PHP 8, Tailwind CSS, JavaScript, alternance 2026, BTS SIO, agence web, Angers, Toulouse">

    <!-- Open Graph -->
    <meta property="og:title" content="Agre Agency — Développeur Web & Fondateur">
    <meta property="og:description" content="Création de sites, applications web et logiciels sur mesure avec expertise en sécurité web.">
    <meta property="og:type" content="website">
    <meta property="og:image" content="assets/images/photo_agre.png">

    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="assets/images/favicon.svg">

    <!-- Google Fonts : Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Font Awesome 6 (icônes) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer">

    <!-- Tailwind CSS (CDN play) avec palette personnalisée -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        turquoise: '#2AC1C4',
                        petrol: '#134B5F',
                        'sky-blue': '#5BC0DE',
                        anthracite: '#3D4439',
                        'dark-bg': '#071e2b',
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif']
                    },
                    backgroundImage: {
                        'gradient-agre': 'linear-gradient(135deg, #134B5F, #2AC1C4)',
                    },
                },
            },
        };
    </script>

    <!-- Feuille de styles custom (curseur, animations, composants) -->
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body class="antialiased">

    <!-- ══════════════════════════════════════════════════════════
         CURSEUR PERSONNALISÉ
         Deux divs positionnées en fixed, animées via JS/CSS.
         ══════════════════════════════════════════════════════════ -->
    <div class="cursor-dot" aria-hidden="true"></div>
    <div class="cursor-ring" aria-hidden="true"></div>


    <!-- ══════════════════════════════════════════════════════════
         HEADER / NAVBAR — Fixe, devient glass au scroll
         ══════════════════════════════════════════════════════════ -->
    <header id="navbar" class="fixed top-0 left-0 right-0 z-50 transition-all">
        <nav class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between gap-6">

            <!-- Logo + nom de l'agence -->
            <a href="#hero" class="flex items-center gap-3 flex-shrink-0 group">
                <img src="assets/images/favicon.svg"
                    alt="Logo Agre Agency"
                    class="h-9 w-9 transition-transform group-hover:scale-110">
                <span class="font-bold text-lg text-white tracking-tight">
                    Agre <span class="text-turquoise">Agency</span>
                </span>
            </a>

            <!-- Liens desktop -->
            <ul class="hidden lg:flex items-center gap-7">
                <li><a href="#hero" class="nav-link">Accueil</a></li>
                <li><a href="#about" class="nav-link">À propos</a></li>
                <li><a href="#expertise" class="nav-link">Expertise</a></li>
                <li><a href="#services" class="nav-link">Services</a></li>
                <li><a href="#projects" class="nav-link">Projets</a></li>
                <li><a href="#contact" class="nav-link">Contact</a></li>
            </ul>

            <!-- CTA Navbar -->
            <a href="#contact"
                class="hidden lg:inline-flex btn-primary text-sm py-2.5 px-5">
                <i class="fas fa-rocket text-xs"></i>
                Démarrer un projet
            </a>

            <!-- Hamburger mobile -->
            <button id="menu-toggle"
                class="lg:hidden flex flex-col items-center justify-center w-10 h-10 rounded-lg bg-petrol/40 border border-turquoise/20 text-sky-blue"
                aria-label="Ouvrir le menu" aria-expanded="false">
                <i id="icon-open" class="fas fa-bars  text-lg"></i>
                <i id="icon-close" class="fas fa-times text-lg hidden"></i>
            </button>
        </nav>

        <!-- Menu mobile déroulant -->
        <div id="mobile-menu" class="lg:hidden border-t border-white/5 bg-dark-bg/95 backdrop-blur-xl">
            <ul class="flex flex-col px-6 py-4 gap-1">
                <li><a href="#hero" class="nav-link block py-3 border-b border-white/5">Accueil</a></li>
                <li><a href="#about" class="nav-link block py-3 border-b border-white/5">À propos</a></li>
                <li><a href="#expertise" class="nav-link block py-3 border-b border-white/5">Expertise</a></li>
                <li><a href="#services" class="nav-link block py-3 border-b border-white/5">Services</a></li>
                <li><a href="#projects" class="nav-link block py-3 border-b border-white/5">Projets</a></li>
                <li><a href="#contact" class="nav-link block py-3 border-b border-white/5">Contact</a></li>
                <li class="pt-3">
                    <a href="#contact" class="btn-primary w-full justify-center">
                        <i class="fas fa-rocket text-xs"></i> Démarrer un projet
                    </a>
                </li>
            </ul>
        </div>
    </header>


    <main>
        <!-- ══════════════════════════════════════════════════════
             § HERO — Accueil
             ══════════════════════════════════════════════════════ -->
        <section id="hero" class="hero-bg min-h-screen flex items-center pt-24 pb-16">
            <!-- Orbes décoratives -->
            <div class="orb orb-1"></div>
            <div class="orb orb-2"></div>

            <div class="relative z-10 max-w-7xl mx-auto px-6 w-full">
                <div class="grid lg:grid-cols-2 gap-16 items-center">

                    <!-- Texte Hero -->
                    <div>
                        <!-- Badge disponibilité alternance -->
                        <div class="badge-dispo mb-6 w-fit" data-animate="fade">
                            Disponible pour alternance — 2026/2028
                        </div>

                        <!-- Surtitre géographique -->
                        <p class="text-sky-blue/70 font-medium tracking-widest uppercase text-sm mb-3"
                            data-animate data-delay="1">
                            <i class="fas fa-map-marker-alt mr-1"></i>
                            Angers — Toulouse
                        </p>

                        <!-- Titre principal -->
                        <h1 class="text-4xl sm:text-5xl lg:text-6xl font-black text-white leading-tight mb-4"
                            data-animate data-delay="2">
                            Développeur web<br>
                            &amp; Fondateur d'<span class="gradient-text">Agre Agency</span>
                        </h1>

                        <!-- Effet de frappe dynamique -->
                        <p class="text-xl sm:text-2xl font-semibold text-sky-blue mb-5 h-8"
                            data-animate data-delay="3">
                            <span id="typing-text"></span>
                        </p>

                        <!-- Sous-titre -->
                        <p class="text-white/75 text-lg mb-3 leading-relaxed max-w-xl"
                            data-animate data-delay="3">
                            Création de sites, applications web et logiciels sur mesure,
                            avec une expertise en <strong class="text-turquoise">sécurité web</strong>.
                        </p>

                        <!-- Paragraphe accroche -->
                        <p class="text-white/55 mb-10 max-w-xl leading-relaxed"
                            data-animate data-delay="4">
                            Je conçois, dépanne et fais évoluer des solutions digitales innovantes
                            pour les entreprises, artisans et associations.
                        </p>

                        <!-- Boutons CTA -->
                        <div class="flex flex-wrap gap-4 mb-10" data-animate data-delay="5">
                            <a href="#contact" class="btn-primary">
                                <i class="fas fa-envelope"></i>
                                Me contacter
                            </a>
                            <a href="#services" class="btn-outline">
                                <i class="fas fa-arrow-down"></i>
                                Voir les services
                            </a>
                        </div>

                        <!-- Mention géographique bas de Hero -->
                        <p class="text-white/40 text-sm flex items-start gap-2" data-animate="fade">
                            <i class="fas fa-location-dot text-turquoise mt-0.5"></i>
                            Basé à Toulouse et Angers, j'interviens dans toute l'Occitanie,
                            les Pays de la Loire et à distance dans toute la France.
                        </p>
                    </div>

                    <!-- Carte code décorative -->
                    <div class="hidden lg:flex justify-center items-center" data-animate="right" data-delay="3">
                        <div class="hero-code-card w-full max-w-md font-mono text-sm">
                            <!-- Barre de titre macOS-style -->
                            <div class="code-bar px-4 py-3 flex items-center gap-2 border-b border-white/5">
                                <span class="code-dot bg-[#ff5f57]"></span>
                                <span class="code-dot bg-[#febc2e]"></span>
                                <span class="code-dot bg-[#28c840]"></span>
                                <span class="ml-4 text-white/30 text-xs">AgencyDev.php</span>
                            </div>
                            <!-- Snippet PHP avec coloration syntaxique -->
                            <div class="p-6 leading-relaxed text-[13px]">
                                <p class="syn-comment">// Agre Agency — Stack 2026</p>
                                <br>
                                <p>
                                    <span class="syn-keyword">class </span>
                                    <span class="syn-class">AgencyDev</span>
                                    <span class="text-white"> {</span>
                                </p>
                                <p class="pl-4">
                                    <span class="syn-keyword">protected </span>
                                    <span class="syn-type">string </span>
                                    <span class="syn-variable">$name</span>
                                    <span class="text-white"> = </span>
                                    <span class="syn-string">"Ange-Kevin Agré"</span>;
                                </p>
                                <br>
                                <p class="pl-4">
                                    <span class="syn-keyword">protected </span>
                                    <span class="syn-type">array </span>
                                    <span class="syn-variable">$stack</span>
                                    <span class="text-white"> = [</span>
                                </p>
                                <p class="pl-8"><span class="syn-string">"PHP 8"</span>, <span class="syn-string">"Tailwind CSS"</span>,</p>
                                <p class="pl-8"><span class="syn-string">"MySQL"</span>, <span class="syn-string">"JavaScript ES6+"</span>,</p>
                                <p class="pl-8"><span class="syn-string">"PWA"</span>, <span class="syn-string">"Sécurité Web"</span></p>
                                <p class="pl-4 text-white">];</p>
                                <br>
                                <p class="pl-4">
                                    <span class="syn-keyword">public function </span>
                                    <span class="syn-fn">getMotivation</span>
                                    <span class="text-white">(): </span>
                                    <span class="syn-type">string</span>
                                </p>
                                <p class="pl-4 text-white">{</p>
                                <p class="pl-8">
                                    <span class="syn-keyword">return </span>
                                    <span class="syn-string">"Code. Design. Innovate."</span>;
                                </p>
                                <p class="pl-4 text-white">}</p>
                                <p class="text-white">}</p>
                                <br>
                                <p>
                                    <span class="syn-variable">$dev</span>
                                    <span class="text-white"> = </span>
                                    <span class="syn-keyword">new </span>
                                    <span class="syn-class">AgencyDev</span>
                                    <span class="text-white">();</span>
                                </p>
                                <p class="syn-comment mt-2">// ✓ Disponible pour alternance 2026</p>
                            </div>
                        </div>
                    </div>

                </div><!-- /grid -->

                <!-- Indicateur scroll -->
                <div class="flex justify-center mt-16" data-animate="fade">
                    <a href="#services"
                        class="flex flex-col items-center gap-2 text-white/35 hover:text-turquoise transition-colors text-xs tracking-widest uppercase">
                        <span>Découvrir</span>
                        <i class="fas fa-chevron-down animate-bounce"></i>
                    </a>
                </div>
            </div>
        </section>


        <!-- ══════════════════════════════════════════════════════
             § SERVICES
             ══════════════════════════════════════════════════════ -->
        <section id="services" class="py-24 bg-dark-bg">
            <div class="max-w-7xl mx-auto px-6">

                <!-- En-tête section -->
                <div class="text-center mb-16" data-animate>
                    <span class="section-tag"><i class="fas fa-cogs text-xs"></i> Services</span>
                    <h2 class="text-3xl sm:text-4xl font-bold text-white mt-4 mb-3">
                        Ce que je réalise pour vous
                    </h2>
                    <div class="section-divider mx-auto mb-4"></div>
                    <p class="text-white/55 max-w-xl mx-auto">
                        Des solutions digitales sur mesure, de la conception au déploiement.
                    </p>
                </div>

                <!-- Grille de cartes -->
                <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">

                    <!-- Carte 1 : Projets créatifs -->
                    <article class="service-card" data-animate data-delay="1">
                        <div class="service-icon">🎨</div>
                        <h3 class="text-white font-bold text-lg mb-3">Projets Créatifs</h3>
                        <p class="text-white/55 text-sm leading-relaxed">
                            Développement d'applications interactives et ludiques qui captivent
                            vos utilisateurs et reflètent votre identité.
                        </p>
                    </article>

                    <!-- Carte 2 : Création de site -->
                    <article class="service-card" data-animate data-delay="2">
                        <div class="service-icon">🌐</div>
                        <h3 class="text-white font-bold text-lg mb-3">Création de Site</h3>
                        <p class="text-white/55 text-sm leading-relaxed">
                            Sites web professionnels sur mesure et clés en main : vitrines,
                            e-commerces, PWA — codés de zéro pour des performances optimales.
                        </p>
                    </article>

                    <!-- Carte 3 : Développement web -->
                    <article class="service-card" data-animate data-delay="3">
                        <div class="service-icon">⚙️</div>
                        <h3 class="text-white font-bold text-lg mb-3">Développement Web</h3>
                        <p class="text-white/55 text-sm leading-relaxed">
                            Solutions sur mesure avec les dernières technologies :
                            PHP 8, Tailwind CSS, JavaScript ES6+, architectures MVC et API REST.
                        </p>
                    </article>

                    <!-- Carte 4 : Hébergement & DNS -->
                    <article class="service-card" data-animate data-delay="4">
                        <div class="service-icon">🔒</div>
                        <h3 class="text-white font-bold text-lg mb-3">Hébergement & DNS</h3>
                        <p class="text-white/55 text-sm leading-relaxed">
                            Dépannage nom de domaine, configuration hébergement, DNS, certificat
                            SSL et mise en place d'emails professionnels sécurisés.
                        </p>
                    </article>
                </div><!-- /grille -->

                <!-- CTA centré -->
                <div class="text-center" data-animate>
                    <a href="#contact" class="btn-primary text-base py-4 px-8">
                        <i class="fas fa-file-invoice-dollar"></i>
                        Demander un devis gratuit
                    </a>
                </div>

            </div>
        </section>


        <!-- ══════════════════════════════════════════════════════
             § EXPERTISE — Compétences techniques
             ══════════════════════════════════════════════════════ -->
        <section id="expertise"
            class="py-24"
            style="background: linear-gradient(180deg, #071e2b 0%, #0a2535 50%, #071e2b 100%);">
            <div class="max-w-7xl mx-auto px-6">

                <div class="text-center mb-16" data-animate>
                    <span class="section-tag"><i class="fas fa-code text-xs"></i> Expertise</span>
                    <h2 class="text-3xl sm:text-4xl font-bold text-white mt-4 mb-3">
                        Mon stack technique
                    </h2>
                    <div class="section-divider mx-auto mb-4"></div>
                    <p class="text-white/55 max-w-xl mx-auto">
                        Un profil polyvalent, du front-end au back-end, avec une sensibilité UX et
                        une culture de la sécurité.
                    </p>
                </div>

                <div class="grid md:grid-cols-3 gap-10">

                    <!-- Frontend -->
                    <div data-animate="left" data-delay="1">
                        <h3 class="text-turquoise font-bold uppercase tracking-widest text-xs mb-5 flex items-center gap-2">
                            <i class="fas fa-desktop"></i> Front-End
                        </h3>
                        <div class="space-y-4">
                            <?php
                            $frontSkills = [
                                'HTML5 / CSS3'     => 92,
                                'Tailwind CSS'     => 88,
                                'JavaScript ES6+'  => 82,
                                'UI / UX Design'   => 78,
                            ];
                            foreach ($frontSkills as $label => $level): ?>
                                <div>
                                    <div class="flex justify-between text-sm text-white/70 mb-1.5">
                                        <span><?= $label ?></span>
                                        <span class="text-turquoise font-semibold"><?= $level ?>%</span>
                                    </div>
                                    <div class="skill-bar-track">
                                        <div class="skill-bar-fill" data-width="<?= $level ?>"></div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <!-- Backend -->
                    <div data-animate data-delay="2">
                        <h3 class="text-turquoise font-bold uppercase tracking-widest text-xs mb-5 flex items-center gap-2">
                            <i class="fas fa-server"></i> Back-End
                        </h3>
                        <div class="space-y-4">
                            <?php
                            $backSkills = [
                                'PHP 8 / MVC'     => 85,
                                'MySQL / PDO'     => 83,
                                'REST API'        => 76,
                                'Sécurité Web'    => 80,
                            ];
                            foreach ($backSkills as $label => $level): ?>
                                <div>
                                    <div class="flex justify-between text-sm text-white/70 mb-1.5">
                                        <span><?= $label ?></span>
                                        <span class="text-turquoise font-semibold"><?= $level ?>%</span>
                                    </div>
                                    <div class="skill-bar-track">
                                        <div class="skill-bar-fill" data-width="<?= $level ?>"></div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <!-- Outils & autre -->
                    <div data-animate="right" data-delay="3">
                        <h3 class="text-turquoise font-bold uppercase tracking-widest text-xs mb-5 flex items-center gap-2">
                            <i class="fas fa-tools"></i> Outils & Méthodes
                        </h3>
                        <div class="space-y-4">
                            <?php
                            $toolSkills = [
                                'Git / GitHub'    => 84,
                                'Figma / Design'  => 70,
                                'PWA / SEO'       => 75,
                                'Linux / XAMPP'   => 78,
                            ];
                            foreach ($toolSkills as $label => $level): ?>
                                <div>
                                    <div class="flex justify-between text-sm text-white/70 mb-1.5">
                                        <span><?= $label ?></span>
                                        <span class="text-turquoise font-semibold"><?= $level ?>%</span>
                                    </div>
                                    <div class="skill-bar-track">
                                        <div class="skill-bar-fill" data-width="<?= $level ?>"></div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>

                </div><!-- /grid -->

                <!-- Badges technos (visuels rapides) -->
                <div class="mt-14 flex flex-wrap justify-center gap-3" data-animate>
                    <?php
                    $badges = ['PHP 8', 'MySQL', 'Tailwind CSS', 'JavaScript', 'HTML5', 'CSS3', 'Git', 'GitHub', 'PWA', 'REST API', 'MVC', 'XAMPP', 'Figma', 'SEO', 'Linux'];
                    foreach ($badges as $badge): ?>
                        <span class="tech-badge"><?= $badge ?></span>
                    <?php endforeach; ?>
                </div>

            </div>
        </section>


        <!-- ══════════════════════════════════════════════════════
             § TÉMOIGNAGES — Slider interactif
             ══════════════════════════════════════════════════════ -->
        <section id="testimonials" class="py-24 bg-dark-bg">
            <div class="max-w-7xl mx-auto px-6">

                <div class="text-center mb-14" data-animate>
                    <span class="section-tag"><i class="fas fa-quote-left text-xs"></i> Témoignages</span>
                    <h2 class="text-3xl sm:text-4xl font-bold text-white mt-4 mb-3">
                        Ce qu'ils disent d'Agre Agency
                    </h2>
                    <div class="section-divider mx-auto"></div>
                </div>

                <!-- Slider -->
                <div class="testimonials-wrapper relative" data-animate>
                    <div id="testimonials-track" class="testimonials-track">

                        <?php
                        /* Données des témoignages — centralisées pour faciliter la maintenance */
                        $testimonials = [
                            [
                                'name'   => 'Sebre Esperance',
                                'role'   => 'Agent de petite enfance',
                                'city'   => 'Toulouse',
                                'photo'  => 'assets/images/photo_maman1.jpg',
                                'stars'  => 5,
                                'text'   => 'Avant j\'avais des difficultés pour maîtriser les outils numériques, mais grâce à l\'accompagnement d\'Agre Agency, aujourd\'hui je maîtrise parfaitement. Je suis désormais autonome sur mon ordinateur.',
                            ],
                            [
                                'name'   => 'Don Jacob',
                                'role'   => 'Cadre administratif',
                                'city'   => 'Abidjan',
                                'photo'  => 'assets/images/photo_papa2.jpg',
                                'stars'  => 5,
                                'text'   => 'Je le suis depuis longtemps dans son parcours. C\'est un profil déterminé qui sait proposer des solutions techniques pertinentes pour les entrepreneurs.',
                            ],
                            [
                                'name'   => 'Youssef',
                                'role'   => 'Étudiant',
                                'city'   => 'UCO Angers',
                                'photo'  => 'assets/images/photo_youssef4.jpeg',
                                'stars'  => 5,
                                'text'   => 'Je recommande Agre Agency pour son professionnalisme, son adaptabilité, sa pédagogie et sa persévérance à trouver les solutions à nos problèmes de code.',
                            ],
                            [
                                'name'   => 'Daniel Sossa',
                                'role'   => 'Software Engineer Big Data',
                                'city'   => 'Abidjan',
                                'photo'  => 'assets/images/photo_sossa5.jpeg',
                                'stars'  => 5,
                                'text'   => 'J\'ai fait appel à Agre Agency pour collaborer sur le projet d\'une application (gestion du front-end). C\'est quelqu\'un de très motivé qui va au-delà de ses tâches initiales pour la réussite du projet.',
                            ],
                        ];
                        foreach ($testimonials as $t): ?>
                            <div class="testimonial-card">
                                <div class="testimonial-inner">
                                    <!-- Étoiles -->
                                    <div class="stars mb-4">
                                        <?= str_repeat('★', $t['stars']) ?>
                                    </div>
                                    <!-- Texte du témoignage -->
                                    <blockquote class="text-white/75 text-sm leading-relaxed mb-6 relative z-10">
                                        <?= htmlspecialchars($t['text'], ENT_QUOTES, 'UTF-8') ?>
                                    </blockquote>
                                    <!-- Auteur -->
                                    <div class="flex items-center gap-3">
                                        <img src="<?= htmlspecialchars($t['photo'], ENT_QUOTES, 'UTF-8') ?>"
                                            alt="Photo de <?= htmlspecialchars($t['name'], ENT_QUOTES, 'UTF-8') ?>"
                                            class="w-11 h-11 rounded-full object-cover avatar-gradient-border">
                                        <div>
                                            <p class="text-white font-semibold text-sm">
                                                <?= htmlspecialchars($t['name'], ENT_QUOTES, 'UTF-8') ?>
                                            </p>
                                            <p class="text-sky-blue/70 text-xs">
                                                <?= htmlspecialchars($t['role'], ENT_QUOTES, 'UTF-8') ?> — <?= htmlspecialchars($t['city'], ENT_QUOTES, 'UTF-8') ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>

                    </div><!-- /track -->
                </div><!-- /wrapper -->

                <!-- Contrôles du slider -->
                <div class="flex items-center justify-center gap-6 mt-8">
                    <button id="slider-prev" class="slider-nav-btn" aria-label="Témoignage précédent">
                        <i class="fas fa-chevron-left text-sm"></i>
                    </button>

                    <div id="slider-dots" class="flex items-center gap-2"></div>

                    <button id="slider-next" class="slider-nav-btn" aria-label="Témoignage suivant">
                        <i class="fas fa-chevron-right text-sm"></i>
                    </button>
                </div>

            </div>
        </section>


        <!-- ══════════════════════════════════════════════════════
             § PROJETS — Réalisations majeures
             ══════════════════════════════════════════════════════ -->
        <section id="projects"
            class="py-24"
            style="background: linear-gradient(180deg, #071e2b 0%, #0b2535 100%);">
            <div class="max-w-7xl mx-auto px-6">

                <div class="text-center mb-16" data-animate>
                    <span class="section-tag"><i class="fas fa-briefcase text-xs"></i> Réalisations</span>
                    <h2 class="text-3xl sm:text-4xl font-bold text-white mt-4 mb-3">
                        Réalisations majeures
                    </h2>
                    <div class="section-divider mx-auto mb-4"></div>
                    <p class="text-white/55 max-w-xl mx-auto">
                        Des projets concrets qui illustrent ma capacité à livrer des solutions
                        complètes et performantes.
                    </p>
                </div>

                <div class="grid md:grid-cols-2 gap-8">

                    <!-- Projet 1 : AGRE Custom -->
                    <article class="project-card" data-animate="left" data-delay="1"
                        onclick="openModal('custom')" data-cursor="pointer"
                        role="button" tabindex="0"
                        aria-label="Voir le projet AGRE Custom">
                        <img src="assets/images/custom_site.jpg" alt="AGRE Custom — Site e-commerce sur mesure">
                        <div class="project-overlay">
                            <div class="flex flex-wrap gap-2 mb-3">
                                <span class="tech-badge">PHP 8</span>
                                <span class="tech-badge">MySQL</span>
                                <span class="tech-badge">Tailwind</span>
                                <span class="tech-badge">PWA</span>
                            </div>
                            <h3 class="text-white text-2xl font-bold mb-1">AGRE Custom</h3>
                            <p class="text-white/60 text-sm mb-4">Plateforme web complète sur mesure</p>
                            <div class="project-reveal">
                                <button class="btn-primary text-sm py-2.5 px-5">
                                    <i class="fas fa-eye text-xs"></i> Voir le projet
                                </button>
                            </div>
                        </div>
                    </article>

                    <!-- Projet 2 : Fitness Tracker -->
                    <article class="project-card" data-animate="right" data-delay="2"
                        onclick="openModal('fitness')" data-cursor="pointer"
                        role="button" tabindex="0"
                        aria-label="Voir le projet Fitness Tracker">
                        <img src="assets/images/fitness_apps.jpeg" alt="Fitness Tracker — Application PWA de suivi sportif">
                        <div class="project-overlay">
                            <div class="flex flex-wrap gap-2 mb-3">
                                <span class="tech-badge">PHP 8</span>
                                <span class="tech-badge">MySQL</span>
                                <span class="tech-badge">Chart.js</span>
                                <span class="tech-badge">JS ES6+</span>
                            </div>
                            <h3 class="text-white text-2xl font-bold mb-1">Fitness Tracker</h3>
                            <p class="text-white/60 text-sm mb-4">Application de suivi sportif & santé</p>
                            <div class="project-reveal">
                                <button class="btn-primary text-sm py-2.5 px-5">
                                    <i class="fas fa-eye text-xs"></i> Voir le projet
                                </button>
                            </div>
                        </div>
                    </article>

                    <!-- Projet 3 : FacturePro -->
                    <article class="project-card" data-animate="left" data-delay="3"
                        onclick="openModal('facturepro')" data-cursor="pointer"
                        role="button" tabindex="0"
                        aria-label="Voir le projet FacturePro">
                        <img src="assets/images/facturepro_site.jpg" alt="FacturePro — SaaS de facturation pour auto-entrepreneurs">
                        <div class="project-overlay">
                            <div class="flex flex-wrap gap-2 mb-3">
                                <span class="tech-badge">React</span>
                                <span class="tech-badge">Supabase</span>
                                <span class="tech-badge">Tailwind</span>
                                <span class="tech-badge">IA</span>
                            </div>
                            <h3 class="text-white text-2xl font-bold mb-1">FacturePro</h3>
                            <p class="text-white/60 text-sm mb-4">SaaS de facturation pour auto-entrepreneurs</p>
                            <div class="project-reveal">
                                <button class="btn-primary text-sm py-2.5 px-5">
                                    <i class="fas fa-eye text-xs"></i> Voir le projet
                                </button>
                            </div>
                        </div>
                    </article>

                    <!-- Projet 4 : Chatbot IA -->
                    <article class="project-card" data-animate="right" data-delay="4"
                        onclick="openModal('chatbot')" data-cursor="pointer"
                        role="button" tabindex="0"
                        aria-label="Voir le projet Chatbot IA Agre Agency">
                        <img src="assets/images/chatbot.jpg" alt="Chatbot IA — Assistant multilingue avec Claude API">
                        <div class="project-overlay">
                            <div class="flex flex-wrap gap-2 mb-3">
                                <span class="tech-badge">Claude API</span>
                                <span class="tech-badge">PHP</span>
                                <span class="tech-badge">JavaScript</span>
                                <span class="tech-badge">Multilingue</span>
                            </div>
                            <h3 class="text-white text-2xl font-bold mb-1">Chatbot IA</h3>
                            <p class="text-white/60 text-sm mb-4">Assistant IA multilingue avec Claude API</p>
                            <div class="project-reveal">
                                <button class="btn-primary text-sm py-2.5 px-5">
                                    <i class="fas fa-eye text-xs"></i> Voir le projet
                                </button>
                            </div>
                        </div>
                    </article>

                </div>
            </div>
        </section>


        <!-- ══════════════════════════════════════════════════════
             § À PROPOS — Vision & Parcours
             ══════════════════════════════════════════════════════ -->
        <section id="about" class="py-24 bg-dark-bg">
            <div class="max-w-7xl mx-auto px-6">

                <!-- En-tête -->
                <div class="text-center mb-16" data-animate>
                    <span class="section-tag"><i class="fas fa-user text-xs"></i> À propos</span>
                    <h2 class="text-3xl sm:text-4xl font-bold text-white mt-4 mb-3">
                        La Vision Agre Agency & Mon Parcours
                    </h2>
                    <div class="section-divider mx-auto"></div>
                </div>

                <!-- Grid principal : texte gauche / photo droite -->
                <div class="grid lg:grid-cols-2 gap-16 items-start">

                    <!-- Colonne gauche : Vision + Timeline -->
                    <div>
                        <!-- Accroche recruteurs -->
                        <div class="bg-petrol/30 border border-turquoise/20 rounded-2xl p-5 mb-8"
                            data-animate="left" data-delay="1">
                            <p class="text-turquoise font-semibold flex items-center gap-2 mb-2">
                                <i class="fas fa-star text-sm"></i>
                                Pour les recruteurs
                            </p>
                            <p class="text-white/80 text-sm leading-relaxed italic">
                                "Je suis le candidat idéal pour apporter des solutions concrètes à votre équipe technique — rigueur, autonomie, et passion du code."
                            </p>
                        </div>

                        <!-- Vision -->
                        <div data-animate="left" data-delay="2">
                            <h3 class="text-xl font-bold text-white mb-4 flex items-center gap-2">
                                <span class="w-6 h-6 rounded bg-turquoise/20 flex items-center justify-center">
                                    <i class="fas fa-lightbulb text-turquoise text-xs"></i>
                                </span>
                                L'idée Agre Agency
                            </h3>
                            <div class="text-white/65 text-sm leading-7 space-y-3">
                                <p>
                                    Agre Agency est né d'une conviction profonde : le numérique doit être accessible
                                    à tous. De l'artisan local qui veut sa première vitrine en ligne à l'entreprise
                                    qui cherche une application métier robuste, je conçois des solutions qui
                                    <strong class="text-sky-blue">résolvent de vrais problèmes</strong>.
                                </p>
                                <p>
                                    Ma passion pour le développement nourrit un désir constant d'apprendre et de
                                    transmettre. Mon projet à long terme est de faire évoluer cette structure en une
                                    <strong class="text-turquoise">agence de développement de référence</strong>,
                                    capable d'accompagner entreprises, particuliers et étudiants par l'apport de
                                    solutions innovantes. Pour moi, chaque ligne de code est une opportunité de
                                    créer de la valeur et de simplifier le quotidien.
                                </p>
                                <p>
                                    Chaque projet que je livre allie une rigueur technique absolue à une sensibilité
                                    humaine profonde. Je mise sur une architecture propre, une sécurité renforcée et
                                    des performances optimales, tout en garantissant une expérience utilisateur
                                    claire et un accompagnement pédagogique sur mesure.
                                </p>
                            </div>
                        </div>

                        <!-- Timeline parcours -->
                        <div class="mt-10" data-animate="left" data-delay="3">
                            <h3 class="text-xl font-bold text-white mb-6 flex items-center gap-2">
                                <span class="w-6 h-6 rounded bg-turquoise/20 flex items-center justify-center">
                                    <i class="fas fa-graduation-cap text-turquoise text-xs"></i>
                                </span>
                                Parcours académique
                            </h3>

                            <div class="space-y-0">
                                <?php
                                $timeline = [
                                    [
                                        'period' => '2025 — 2026',
                                        'label'  => 'Diplôme d\'Université',
                                        'detail' => 'Année Préparatoire aux Études Universitaires',
                                        'place'  => 'UCO Angers',
                                        'icon'   => 'fa-university',
                                        'active' => true,
                                    ],
                                    [
                                        'period' => '2023 — 2025',
                                        'label'  => 'BTS Développeur d\'applications',
                                        'detail' => 'Spécialité Informatique',
                                        'place'  => 'Abidjan, Côte d\'Ivoire',
                                        'icon'   => 'fa-laptop-code',
                                        'active' => false,
                                    ],
                                    [
                                        'period' => '2022 — 2023',
                                        'label'  => 'Baccalauréat Général',
                                        'detail' => 'Spécialités scientifiques',
                                        'place'  => 'Abidjan, Côte d\'Ivoire',
                                        'icon'   => 'fa-school',
                                        'active' => false,
                                    ],
                                ];
                                foreach ($timeline as $item): ?>
                                    <div class="timeline-item">
                                        <div class="timeline-dot"></div>
                                        <div class="bg-petrol/20 border border-white/5 rounded-xl p-4 hover:border-turquoise/20 transition-colors">
                                            <div class="flex items-start justify-between gap-3">
                                                <div>
                                                    <span class="text-turquoise text-xs font-bold tracking-wider">
                                                        <?= htmlspecialchars($item['period'], ENT_QUOTES, 'UTF-8') ?>
                                                    </span>
                                                    <h4 class="text-white font-semibold mt-0.5">
                                                        <?= htmlspecialchars($item['label'], ENT_QUOTES, 'UTF-8') ?>
                                                    </h4>
                                                    <p class="text-white/50 text-sm">
                                                        <?= htmlspecialchars($item['detail'], ENT_QUOTES, 'UTF-8') ?>
                                                        — <em><?= htmlspecialchars($item['place'], ENT_QUOTES, 'UTF-8') ?></em>
                                                    </p>
                                                </div>
                                                <div class="w-9 h-9 flex-shrink-0 rounded-lg bg-turquoise/10 border border-turquoise/20 flex items-center justify-center">
                                                    <i class="fas <?= $item['icon'] ?> text-turquoise text-sm"></i>
                                                </div>
                                            </div>
                                            <?php if ($item['active']): ?>
                                                <span class="mt-2 inline-flex items-center gap-1.5 text-xs text-emerald-400 font-semibold">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                                                    En cours
                                                </span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div><!-- /col gauche -->

                    <!-- Colonne droite : Photo -->
                    <div class="flex flex-col items-center gap-8 min-w-0" data-animate="right" data-delay="2">
                        <div class="relative w-full flex justify-center">
                            <!-- Halo décoratif derrière la photo -->
                            <div class="absolute inset-0 rounded-3xl"
                                style="background: radial-gradient(circle, rgba(42,193,196,0.15) 0%, transparent 70%);
                                        transform: scale(1.15); filter: blur(30px);"></div>
                            <img src="assets/images/photo_agre.png"
                                alt="Ange-Kevin Agré — Fondateur d'Agre Agency"
                                class="relative w-72 lg:w-96 max-w-full rounded-3xl object-cover shadow-2xl"
                                style="border: 2px solid rgba(42,193,196,0.25);">
                        </div>

                        <!-- Stats rapides -->
                        <div class="grid grid-cols-3 gap-4 w-full max-w-sm">
                            <?php
                            $stats = [
                                ['value' => '3+',  'label' => 'Ans de pratique'],
                                ['value' => '10+', 'label' => 'Projets réalisés'],
                                ['value' => '2',   'label' => 'Pôles géo.'],
                            ];
                            foreach ($stats as $s): ?>
                                <div class="bg-petrol/30 border border-white/8 rounded-xl p-4 text-center">
                                    <p class="text-turquoise font-black text-2xl"><?= $s['value'] ?></p>
                                    <p class="text-white/50 text-xs mt-1"><?= $s['label'] ?></p>
                                </div>
                            <?php endforeach; ?>
                        </div>

                        <!-- Lien LinkedIn -->
                        <a href="https://www.linkedin.com/in/ange-kevin-agre-a03b3a386"
                            target="_blank" rel="noopener noreferrer"
                            class="btn-outline w-full max-w-sm justify-center">
                            <i class="fab fa-linkedin text-[#0A66C2]"></i>
                            Voir mon profil LinkedIn
                        </a>
                    </div><!-- /col droite -->

                </div>
            </div>
        </section>


        <!-- ══════════════════════════════════════════════════════
             § FAQ — Accordéon interactif
             ══════════════════════════════════════════════════════ -->
        <section id="faq"
            class="py-24"
            style="background: linear-gradient(180deg, #0a2535 0%, #071e2b 100%);">
            <div class="max-w-3xl mx-auto px-6">

                <div class="text-center mb-14" data-animate>
                    <span class="section-tag"><i class="fas fa-question-circle text-xs"></i> FAQ</span>
                    <h2 class="text-3xl sm:text-4xl font-bold text-white mt-4 mb-3">
                        Questions fréquentes
                    </h2>
                    <div class="section-divider mx-auto"></div>
                </div>

                <div class="space-y-0 rounded-2xl overflow-hidden border border-white/6"
                    data-animate data-delay="1">
                    <?php
                    $faqs = [
                        [
                            'q' => 'Intervenez-vous sur Angers et Toulouse ?',
                            'a' => 'Oui, je suis basé sur ces deux pôles géographiques (Pays de la Loire et Occitanie), mais j\'interviens également à distance pour des projets dans toute la France et à l\'international.',
                        ],
                        [
                            'q' => 'Faites-vous de la création de site internet ?',
                            'a' => 'Absolument. De la conception du design jusqu\'au déploiement, je réalise des sites vitrines, des e-commerces et des applications web (PWA) sur mesure, codés de zéro pour des performances optimales.',
                        ],
                        [
                            'q' => 'Quel est le prix d\'une création d\'application ou de site ?',
                            'a' => 'Chaque projet digital est unique. Le tarif dépend des fonctionnalités requises, de la complexité de l\'architecture et du design. Contactez-moi pour obtenir un devis gratuit et détaillé adapté à vos besoins.',
                        ],
                        [
                            'q' => 'Assurez-vous la maintenance et la sécurité ?',
                            'a' => 'Oui, la sécurité est au cœur de mes développements (requêtes préparées PDO, chiffrement, protection CSRF). Je propose également des forfaits de maintenance pour mettre à jour vos systèmes et garantir leur stabilité.',
                        ],
                        [
                            'q' => 'Pourquoi choisir Agre Agency ?',
                            'a' => 'Pour l\'alliance entre une rigueur technique approfondie (code clean, architectures modernes) et une véritable écoute pédagogique. Mon objectif n\'est pas seulement de livrer un produit, mais d\'accompagner votre transition numérique.',
                        ],
                    ];
                    foreach ($faqs as $i => $faq): ?>
                        <div class="faq-item bg-petrol/20 hover:bg-petrol/30 transition-colors">
                            <button class="faq-question w-full text-left px-6 py-5 flex items-center justify-between gap-4">
                                <span class="text-white font-medium text-sm sm:text-base flex items-start gap-3">
                                    <span class="text-turquoise font-bold text-sm mt-0.5 flex-shrink-0">
                                        <?= str_pad((string)($i + 1), 2, '0', STR_PAD_LEFT) ?>
                                    </span>
                                    <?= htmlspecialchars($faq['q'], ENT_QUOTES, 'UTF-8') ?>
                                </span>
                                <i class="fas fa-plus faq-icon text-sm"></i>
                            </button>
                            <div class="faq-answer">
                                <div class="px-6 pb-5 pl-14 text-white/60 text-sm leading-7">
                                    <?= htmlspecialchars($faq['a'], ENT_QUOTES, 'UTF-8') ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

            </div>
        </section>


        <!-- ══════════════════════════════════════════════════════
             § CONTACT — Formulaire & informations
             ══════════════════════════════════════════════════════ -->
        <section id="contact" class="py-24 bg-dark-bg">
            <div class="max-w-7xl mx-auto px-6">

                <div class="text-center mb-16" data-animate>
                    <span class="section-tag"><i class="fas fa-paper-plane text-xs"></i> Contact</span>
                    <h2 class="text-3xl sm:text-4xl font-bold text-white mt-4 mb-3">
                        Parlons de votre projet
                    </h2>
                    <div class="section-divider mx-auto mb-4"></div>
                    <p class="text-white/55 max-w-xl mx-auto">
                        Une idée ? Un besoin ? Un bug urgent ? Écrivez-moi, je réponds
                        dans les <strong class="text-turquoise">24 heures</strong>.
                    </p>
                </div>

                <div class="grid lg:grid-cols-2 gap-12 items-start">

                    <!-- Informations de contact -->
                    <div data-animate="left">
                        <h3 class="text-white font-bold text-xl mb-6">Coordonnées</h3>

                        <div class="space-y-4 mb-8">
                            <?php
                            $contacts = [
                                ['icon' => 'fa-envelope',   'label' => 'Email',     'value' => 'agrekevin09@gmail.com',  'href' => 'mailto:agrekevin09@gmail.com'],
                                ['icon' => 'fa-phone',      'label' => 'Téléphone', 'value' => '+33 07 84 80 73 04',      'href' => 'tel:+33784807304'],
                                ['icon' => 'fa-map-marker', 'label' => 'Zones',     'value' => 'Angers • Toulouse • France entière', 'href' => null],
                            ];
                            foreach ($contacts as $c): ?>
                                <div class="flex items-center gap-4 p-4 bg-petrol/20 border border-white/5 rounded-xl hover:border-turquoise/20 transition-colors">
                                    <div class="w-10 h-10 bg-turquoise/10 border border-turquoise/20 rounded-lg flex items-center justify-center flex-shrink-0">
                                        <i class="fas <?= $c['icon'] ?> text-turquoise text-sm"></i>
                                    </div>
                                    <div>
                                        <p class="text-white/40 text-xs uppercase tracking-widest"><?= $c['label'] ?></p>
                                        <?php if ($c['href']): ?>
                                            <a href="<?= htmlspecialchars($c['href'], ENT_QUOTES, 'UTF-8') ?>"
                                                class="text-white font-medium text-sm hover:text-turquoise transition-colors">
                                                <?= htmlspecialchars($c['value'], ENT_QUOTES, 'UTF-8') ?>
                                            </a>
                                        <?php else: ?>
                                            <p class="text-white font-medium text-sm"><?= htmlspecialchars($c['value'], ENT_QUOTES, 'UTF-8') ?></p>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>

                        <!-- Réseaux sociaux -->
                        <h3 class="text-white font-bold mb-4">Retrouvez-moi sur</h3>
                        <div class="flex flex-wrap gap-3">
                            <a href="https://www.linkedin.com/in/ange-kevin-agre-a03b3a386"
                                target="_blank" rel="noopener noreferrer"
                                class="social-link" aria-label="LinkedIn">
                                <i class="fab fa-linkedin-in"></i>
                            </a>
                            <a href="https://github.com/Boneho-dev"
                                target="_blank" rel="noopener noreferrer"
                                class="social-link" aria-label="GitHub">
                                <i class="fab fa-github"></i>
                            </a>
                            <a href="https://www.facebook.com/profile.php?id=61580092377799&locale=fr_FR"
                                target="_blank" rel="noopener noreferrer"
                                class="social-link" aria-label="Facebook">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                        </div>
                    </div><!-- /col info -->

                    <!-- Formulaire -->
                    <div data-animate="right">

                        <!-- Feedback injecté dynamiquement par main.js après la requête fetch() -->
                        <div id="form-feedback" class="hidden mb-6" role="alert" aria-live="polite"></div>

                        <form id="contact-form" method="POST" action="#contact" novalidate
                            class="bg-petrol/20 border border-white/8 rounded-2xl p-8 space-y-5">

                            <!-- Honeypot anti-spam (masqué CSS) -->
                            <div style="display:none" aria-hidden="true">
                                <input type="text" name="hp_field" tabindex="-1" autocomplete="off">
                            </div>

                            <div class="grid sm:grid-cols-2 gap-5">
                                <div>
                                    <label class="block text-white/60 text-xs font-semibold uppercase tracking-widest mb-2" for="name">
                                        Votre nom *
                                    </label>
                                    <input type="text" id="name" name="name" required
                                        class="form-input"
                                        placeholder="Jean Dupont"
                                        value="<?= htmlspecialchars($_POST['name'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
                                </div>
                                <div>
                                    <label class="block text-white/60 text-xs font-semibold uppercase tracking-widest mb-2" for="email">
                                        Votre email *
                                    </label>
                                    <input type="email" id="email" name="email" required
                                        class="form-input"
                                        placeholder="jean@exemple.fr"
                                        value="<?= htmlspecialchars($_POST['email'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
                                </div>
                            </div>

                            <div>
                                <label class="block text-white/60 text-xs font-semibold uppercase tracking-widest mb-2" for="subject">
                                    Sujet *
                                </label>
                                <input type="text" id="subject" name="subject" required
                                    class="form-input"
                                    placeholder="Création d'un site vitrine"
                                    value="<?= htmlspecialchars($_POST['subject'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
                            </div>

                            <div>
                                <label class="block text-white/60 text-xs font-semibold uppercase tracking-widest mb-2" for="message">
                                    Message *
                                </label>
                                <textarea id="message" name="message" rows="5" required
                                    class="form-input resize-none"
                                    placeholder="Décrivez votre projet ou votre besoin…"><?= htmlspecialchars($_POST['message'] ?? '', ENT_QUOTES, 'UTF-8') ?></textarea>
                            </div>

                            <button type="submit" name="contact_submit" class="btn-primary w-full justify-center py-4 text-base">
                                <i class="fas fa-paper-plane"></i>
                                Envoyer le message
                            </button>

                            <p class="text-white/25 text-xs text-center">
                                * Champs obligatoires. Vos données ne sont pas partagées.
                            </p>
                        </form>
                    </div><!-- /col form -->

                </div>
            </div>
        </section>

    </main>


    <!-- ══════════════════════════════════════════════════════════
         FOOTER
         ══════════════════════════════════════════════════════════ -->
    <footer class="border-t border-white/6"
        style="background: linear-gradient(180deg, #050f17, #071e2b);">
        <div class="max-w-7xl mx-auto px-6 py-12">
            <div class="grid md:grid-cols-3 gap-10 mb-10">

                <!-- Logo + description -->
                <div>
                    <a href="#hero" class="flex items-center gap-3 mb-4 w-fit">
                        <img src="assets/images/favicon.svg" alt="Logo Agre Agency" class="h-8 w-8">
                        <span class="font-bold text-white text-lg">Agre <span class="text-turquoise">Agency</span></span>
                    </a>
                    <p class="text-white/45 text-sm leading-relaxed">
                        Création de sites, applications web et solutions numériques sur mesure.
                        Basé à Angers &amp; Toulouse.
                    </p>
                </div>

                <!-- Liens rapides -->
                <div>
                    <h4 class="text-white font-semibold mb-4 text-sm uppercase tracking-widest">Navigation</h4>
                    <ul class="space-y-2">
                        <?php
                        $footerLinks = [
                            ['href' => '#hero',      'label' => 'Accueil'],
                            ['href' => '#services',  'label' => 'Services'],
                            ['href' => '#projects',  'label' => 'Projets'],
                            ['href' => '#about',     'label' => 'À propos'],
                            ['href' => '#contact',   'label' => 'Contact'],
                        ];
                        foreach ($footerLinks as $link): ?>
                            <li>
                                <a href="<?= $link['href'] ?>"
                                    class="text-white/45 hover:text-turquoise transition-colors text-sm flex items-center gap-2">
                                    <i class="fas fa-chevron-right text-[9px] text-turquoise/50"></i>
                                    <?= $link['label'] ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>

                <!-- Réseaux & contact -->
                <div>
                    <h4 class="text-white font-semibold mb-4 text-sm uppercase tracking-widest">Me retrouver</h4>
                    <div class="flex gap-3 mb-5">
                        <a href="https://www.linkedin.com/in/ange-kevin-agre-a03b3a386"
                            target="_blank" rel="noopener noreferrer"
                            class="social-link" aria-label="LinkedIn">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                        <a href="https://github.com/Boneho-dev"
                            target="_blank" rel="noopener noreferrer"
                            class="social-link" aria-label="GitHub">
                            <i class="fab fa-github"></i>
                        </a>
                        <a href="https://www.facebook.com/profile.php?id=61580092377799&locale=fr_FR"
                            target="_blank" rel="noopener noreferrer"
                            class="social-link" aria-label="Facebook">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="mailto:agrekevin09@gmail.com"
                            class="social-link" aria-label="Email">
                            <i class="fas fa-envelope"></i>
                        </a>
                    </div>
                    <a href="tel:+33784807304"
                        class="text-white/45 hover:text-turquoise transition-colors text-sm flex items-center gap-2">
                        <i class="fas fa-phone text-turquoise/60 text-xs"></i>
                        +33 07 84 80 73 04
                    </a>
                </div>

            </div>

            <!-- Barre de copyright -->
            <div class="border-t border-white/6 pt-6 flex items-center justify-center text-white/30 text-xs">
                <p>© <?= date('Y') ?> Agre Agency — Ange-Kevin Agré. Tous droits réservés.</p>
            </div>
        </div>
    </footer>


    <!-- ══════════════════════════════════════════════════════════
         MODALES PROJETS (cachées par défaut, ouvertes via JS)
         ══════════════════════════════════════════════════════════ -->

    <!-- Modale : AGRE Custom -->
    <div id="modal-custom" class="modal-backdrop" role="dialog" aria-modal="true" aria-labelledby="modal-custom-title">
        <div class="modal-box w-full">
            <!-- Image bannière -->
            <div class="relative h-56 overflow-hidden rounded-t-2xl">
                <img src="assets/images/custom_site.jpg"
                    alt="AGRE Custom" class="w-full h-full object-cover">
                <div class="absolute inset-0"
                    style="background: linear-gradient(to top, #0b2535 0%, transparent 60%);">
                </div>
                <button onclick="closeModal('custom')"
                    class="absolute top-4 right-4 w-9 h-9 bg-black/50 border border-white/15 rounded-full flex items-center justify-center text-white hover:bg-black/80 transition-colors"
                    aria-label="Fermer">
                    <i class="fas fa-times text-sm"></i>
                </button>
            </div>

            <div class="p-8">
                <span class="section-tag text-xs mb-3 inline-flex">
                    <i class="fas fa-globe"></i> Site web
                </span>
                <h2 id="modal-custom-title" class="text-2xl font-bold text-white mb-3">
                    AGRE Custom
                </h2>
                <p class="text-white/65 text-sm leading-7 mb-6">
                    Site e-commerce complet développé à Angers. La plateforme intègre une gestion
                    de contenu dynamique, un catalogue de produits interactif et une interface client
                    fluide. Le site est optimisé pour les performances (Core Web Vitals), le SEO et
                    respecte les bonnes pratiques de sécurité web (requêtes préparées PDO,
                    protection CSRF).
                </p>

                <!-- Stack technique -->
                <h3 class="text-white/40 text-xs uppercase tracking-widest mb-3">Stack technique</h3>
                <div class="flex flex-wrap gap-2 mb-6">
                    <?php foreach (['PHP 8', 'MySQL / PDO', 'Tailwind CSS', 'JavaScript ES6+', 'PWA', 'SEO On-page', 'MVC Architecture', 'API REST'] as $tag): ?>
                        <span class="tech-badge"><?= $tag ?></span>
                    <?php endforeach; ?>
                </div>

                <!-- Fonctionnalités clés -->
                <h3 class="text-white/40 text-xs uppercase tracking-widest mb-3">Fonctionnalités</h3>
                <ul class="space-y-2 mb-8">
                    <?php foreach (
                        [
                            'Design responsive & accessibilité WCAG',
                            'Mode PWA — installable sur mobile',
                            'Tableau de bord administrateur',
                            'Formulaire de devis sécurisé',
                            'Optimisation des performances (Lighthouse 90+)',
                        ] as $feat
                    ): ?>
                        <li class="flex items-start gap-2 text-white/60 text-sm">
                            <i class="fas fa-check text-turquoise text-xs mt-1 flex-shrink-0"></i>
                            <?= $feat ?>
                        </li>
                    <?php endforeach; ?>
                </ul>

                <div class="flex flex-wrap gap-3">
                    <a href="#contact" onclick="closeModal('custom')" class="btn-primary">
                        <i class="fas fa-rocket text-xs"></i> Démarrer un projet similaire
                    </a>
                    <a href="https://agre.page.gd/custom/"
                        target="_blank" rel="noopener noreferrer"
                        class="btn-outline">
                        <i class="fas fa-external-link-alt text-xs"></i> Voir le projet
                    </a>
                    <button onclick="closeModal('custom')" class="btn-outline">
                        <i class="fas fa-times text-xs"></i> Fermer
                    </button>
                </div>
            </div>
        </div>
    </div><!-- /modal-custom -->


    <!-- Modale : Fitness Tracker -->
    <div id="modal-fitness" class="modal-backdrop" role="dialog" aria-modal="true" aria-labelledby="modal-fitness-title">
        <div class="modal-box w-full">
            <!-- Image bannière -->
            <div class="relative h-56 overflow-hidden rounded-t-2xl">
                <img src="assets/images/fitness_apps.jpeg"
                    alt="Fitness Tracker" class="w-full h-full object-cover">
                <div class="absolute inset-0"
                    style="background: linear-gradient(to top, #0b2535 0%, transparent 60%);">
                </div>
                <button onclick="closeModal('fitness')"
                    class="absolute top-4 right-4 w-9 h-9 bg-black/50 border border-white/15 rounded-full flex items-center justify-center text-white hover:bg-black/80 transition-colors"
                    aria-label="Fermer">
                    <i class="fas fa-times text-sm"></i>
                </button>
            </div>

            <div class="p-8">
                <span class="section-tag text-xs mb-3 inline-flex">
                    <i class="fas fa-mobile-alt"></i> Application web
                </span>
                <h2 id="modal-fitness-title" class="text-2xl font-bold text-white mb-3">
                    Fitness Tracker
                </h2>
                <p class="text-white/65 text-sm leading-7 mb-6">
                    Application Web (PWA) installable sans passer par les stores. Elle propose un
                    suivi sportif complet avec graphiques dynamiques (Chart.js), un fil d'actualité
                    communautaire (posts, likes, commentaires), une messagerie privée, et une section
                    vidéos de sport. Architecture sécurisée avec hachage bcrypt et sessions PHP.
                </p>

                <!-- Stack technique -->
                <h3 class="text-white/40 text-xs uppercase tracking-widest mb-3">Stack technique</h3>
                <div class="flex flex-wrap gap-2 mb-6">
                    <?php foreach (['PHP 8', 'MySQL / PDO', 'Chart.js', 'Tailwind CSS', 'JavaScript ES6+', 'Bcrypt Auth', 'AJAX / Fetch API', 'PWA'] as $tag): ?>
                        <span class="tech-badge"><?= $tag ?></span>
                    <?php endforeach; ?>
                </div>

                <!-- Fonctionnalités clés -->
                <h3 class="text-white/40 text-xs uppercase tracking-widest mb-3">Fonctionnalités</h3>
                <ul class="space-y-2 mb-8">
                    <?php foreach (
                        [
                            'Tableau de bord avec graphiques interactifs (Chart.js)',
                            'Suivi multi-activités (cardio, musculation, yoga…)',
                            'Authentification sécurisée bcrypt + sessions',
                            'Notifications de rappel entraînement',
                            'Export des données en CSV',
                        ] as $feat
                    ): ?>
                        <li class="flex items-start gap-2 text-white/60 text-sm">
                            <i class="fas fa-check text-turquoise text-xs mt-1 flex-shrink-0"></i>
                            <?= $feat ?>
                        </li>
                    <?php endforeach; ?>
                </ul>

                <div class="flex flex-wrap gap-3">
                    <a href="#contact" onclick="closeModal('fitness')" class="btn-primary">
                        <i class="fas fa-rocket text-xs"></i> Démarrer un projet similaire
                    </a>
                    <a href="https://agre.page.gd/fitness/"
                        target="_blank" rel="noopener noreferrer"
                        class="btn-outline">
                        <i class="fas fa-external-link-alt text-xs"></i> Voir le projet
                    </a>
                    <button onclick="closeModal('fitness')" class="btn-outline">
                        <i class="fas fa-times text-xs"></i> Fermer
                    </button>
                </div>
            </div>
        </div>
    </div><!-- /modal-fitness -->


    <!-- Modale : FacturePro -->
    <div id="modal-facturepro" class="modal-backdrop" role="dialog" aria-modal="true" aria-labelledby="modal-facturepro-title">
        <div class="modal-box w-full">
            <div class="relative h-56 overflow-hidden rounded-t-2xl">
                <img src="assets/images/facturepro_site.jpg" alt="FacturePro" class="w-full h-full object-cover">
                <div class="absolute inset-0" style="background: linear-gradient(to top, #0b2535 0%, transparent 60%);"></div>
                <button onclick="closeModal('facturepro')"
                    class="absolute top-4 right-4 w-9 h-9 bg-black/50 border border-white/15 rounded-full flex items-center justify-center text-white hover:bg-black/80 transition-colors"
                    aria-label="Fermer"><i class="fas fa-times text-sm"></i></button>
            </div>
            <div class="p-8">
                <span class="section-tag text-xs mb-3 inline-flex"><i class="fas fa-file-invoice"></i> SaaS</span>
                <h2 id="modal-facturepro-title" class="text-2xl font-bold text-white mb-3">FacturePro</h2>
                <p class="text-white/65 text-sm leading-7 mb-6">
                    SaaS de facturation conçu pour les auto-entrepreneurs français. Génération rapide de factures
                    et devis conformes à la législation française, gestion des clients, historique et export PDF.
                    Interface intuitive, authentification sécurisée et intégration IA pour descriptions
                    intelligentes. Backend assure persistance des données et conformité RGPD.
                </p>
                <h3 class="text-white/40 text-xs uppercase tracking-widest mb-3">Stack technique</h3>
                <div class="flex flex-wrap gap-2 mb-6">
                    <?php foreach (['React', 'Supabase', 'JavaScript ES6+', 'Tailwind CSS', 'Authentication', 'PDF Generation', 'API REST'] as $tag): ?>
                        <span class="tech-badge"><?= $tag ?></span>
                    <?php endforeach; ?>
                </div>
                <h3 class="text-white/40 text-xs uppercase tracking-widest mb-3">Fonctionnalités</h3>
                <ul class="space-y-2 mb-8">
                    <?php foreach (
                        [
                            'Création & personnalisation de factures/devis',
                            'Gestion dynamique de clients et prestations',
                            'Génération IA de descriptions de services',
                            'Export PDF instantané aux normes françaises',
                            'Dashboard de suivi — statistiques & historique',
                            'Authentification sécurisée & chiffrement données',
                            'Mode hors-ligne synchronisation cloud',
                        ] as $feat
                    ): ?>
                        <li class="flex items-start gap-2 text-white/60 text-sm">
                            <i class="fas fa-check text-turquoise text-xs mt-1 flex-shrink-0"></i>
                            <?= $feat ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
                <div class="flex flex-wrap gap-3">
                    <a href="https://agre.page.gd/portfolio/#contact" onclick="closeModal('facturepro')" class="btn-primary">
                        <i class="fas fa-rocket text-xs"></i> Démarrer un projet similaire
                    </a>
                    <a href="https://agre.page.gd/facture/" target="_blank" rel="noopener noreferrer" class="btn-outline">
                        <i class="fas fa-external-link-alt text-xs"></i> Voir le projet
                    </a>
                    <button onclick="closeModal('facturepro')" class="btn-outline">
                        <i class="fas fa-times text-xs"></i> Fermer
                    </button>
                </div>
            </div>
        </div>
    </div><!-- /modal-facturepro -->


    <!-- Modale : Chatbot IA -->
    <div id="modal-chatbot" class="modal-backdrop" role="dialog" aria-modal="true" aria-labelledby="modal-chatbot-title">
        <div class="modal-box w-full">
            <div class="relative h-56 overflow-hidden rounded-t-2xl">
                <img src="assets/images/chatbot.jpg" alt="Chatbot IA — Agre Agency" class="w-full h-full object-cover">
                <div class="absolute inset-0" style="background: linear-gradient(to top, #0b2535 0%, transparent 60%);"></div>
                <button onclick="closeModal('chatbot')"
                    class="absolute top-4 right-4 w-9 h-9 bg-black/50 border border-white/15 rounded-full flex items-center justify-center text-white hover:bg-black/80 transition-colors"
                    aria-label="Fermer"><i class="fas fa-times text-sm"></i></button>
            </div>
            <div class="p-8">
                <span class="section-tag text-xs mb-3 inline-flex"><i class="fas fa-robot"></i> IA</span>
                <h2 id="modal-chatbot-title" class="text-2xl font-bold text-white mb-3">Chatbot IA — Agre Agency</h2>
                <p class="text-white/65 text-sm leading-7 mb-6">
                    Chatbot intelligent multilingue (FR/EN) intégrant Claude API pour répondre intelligemment
                    aux questions visiteurs. Navigation fluide par cartes (Services, Projets, Tarifs, À propos,
                    Message libre). Design premium avec animations fluides, dégradé teal/turquoise, responsive.
                    Backend PHP gère appels sécurisés à Claude, frontend vanilla assure performance.
                    Démonstration intégration IA en production.
                </p>
                <h3 class="text-white/40 text-xs uppercase tracking-widest mb-3">Stack technique</h3>
                <div class="flex flex-wrap gap-2 mb-6">
                    <?php foreach (['Claude API', 'PHP', 'JavaScript Vanilla', 'HTML5', 'CSS3', 'Multilingue FR/EN', 'Responsive'] as $tag): ?>
                        <span class="tech-badge"><?= $tag ?></span>
                    <?php endforeach; ?>
                </div>
                <h3 class="text-white/40 text-xs uppercase tracking-widest mb-3">Fonctionnalités</h3>
                <ul class="space-y-2 mb-8">
                    <?php foreach (
                        [
                            'Navigation persistante par cartes interactives',
                            'Basculement instantané FR ↔ EN',
                            'Intégration Claude API — réponses intelligentes',
                            'Suggestions contextuelles & fallback contact auto',
                            'Design glassmorphism & animations CSS3',
                            'Responsive parfait (mobile, tablet, desktop)',
                            'Mode production — zéro dépendances externes',
                        ] as $feat
                    ): ?>
                        <li class="flex items-start gap-2 text-white/60 text-sm">
                            <i class="fas fa-check text-turquoise text-xs mt-1 flex-shrink-0"></i>
                            <?= $feat ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
                <div class="flex flex-wrap gap-3">
                    <a href="https://agre.page.gd/portfolio/#contact" onclick="closeModal('chatbot')" class="btn-primary">
                        <i class="fas fa-rocket text-xs"></i> Démarrer un projet similaire
                    </a>
                    <a href="https://agre.page.gd/chatbot/frontend/index.html" target="_blank" rel="noopener noreferrer" class="btn-outline">
                        <i class="fas fa-external-link-alt text-xs"></i> Voir le projet
                    </a>
                    <button onclick="closeModal('chatbot')" class="btn-outline">
                        <i class="fas fa-times text-xs"></i> Fermer
                    </button>
                </div>
            </div>
        </div>
    </div><!-- /modal-chatbot -->


    <!-- ══════════════════════════════════════════════════════════
         BOUTON RETOUR EN HAUT
         Apparaît en bas à droite après 400px de scroll.
         ══════════════════════════════════════════════════════════ -->
    <button id="back-to-top"
        onclick="window.scrollTo({ top: 0, behavior: 'smooth' })"
        aria-label="Retour en haut de page"
        class="fixed bottom-6 right-6 z-50 w-12 h-12 rounded-full flex items-center justify-center
                   shadow-lg transition-all duration-300 opacity-0 translate-y-4 pointer-events-none">
        <i class="fas fa-arrow-up text-sm"></i>
    </button>

    <!-- ══════════════════════════════════════════════════════════
         SCRIPTS
         ══════════════════════════════════════════════════════════ -->
    <script src="assets/js/main.js" defer></script>

</body>

</html>