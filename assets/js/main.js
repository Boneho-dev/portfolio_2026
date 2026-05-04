/**
 * ╔══════════════════════════════════════════════════════════════╗
 * ║       AGRE AGENCY — Main JavaScript (ES6+)                   ║
 * ║  Auteur : Ange-Kevin Agré | agrekevin09@gmail.com            ║
 * ║  Modules : Curseur, Navbar, Slider, Modales, FAQ, Animations ║
 * ╚══════════════════════════════════════════════════════════════╝
 */

'use strict';

/* ════════════════════════════════════════════════════════════════
   Entrée principale — on attend que le DOM soit totalement chargé
   ════════════════════════════════════════════════════════════════ */
document.addEventListener('DOMContentLoaded', () => {

    initCursor();
    initNavbar();
    initMobileMenu();
    initActiveNavLinks();
    initScrollAnimations();
    initSkillBars();
    initTestimonialsSlider();
    initProjectModals();
    initFaqAccordion();
    initTypingEffect();
    initSmoothScroll();
    initContactForm();
    initBackToTop();

});

/* ── ① CURSEUR PERSONNALISÉ ──────────────────────────────────────
   Le point (.cursor-dot) suit la souris immédiatement.
   L'anneau (.cursor-ring) suit avec un léger lag via rAF pour
   un effet fluide et premium.                                       */
function initCursor() {
    const dot  = document.querySelector('.cursor-dot');
    const ring = document.querySelector('.cursor-ring');

    /* On masque les éléments si le device n'a pas de souris précise */
    if (!dot || !ring || window.matchMedia('(pointer: coarse)').matches) return;

    let mouseX = window.innerWidth / 2;
    let mouseY = window.innerHeight / 2;
    let ringX  = mouseX;
    let ringY  = mouseY;

    /* Le point suit instantanément */
    document.addEventListener('mousemove', (e) => {
        mouseX = e.clientX;
        mouseY = e.clientY;
        dot.style.left = `${mouseX}px`;
        dot.style.top  = `${mouseY}px`;
    });

    /* L'anneau rattrape la position avec inertie (~12% par frame) */
    (function animateRing() {
        ringX += (mouseX - ringX) * 0.12;
        ringY += (mouseY - ringY) * 0.12;
        ring.style.left = `${ringX}px`;
        ring.style.top  = `${ringY}px`;
        requestAnimationFrame(animateRing);
    })();

    /* Appliquer la classe hover sur les éléments interactifs */
    document.querySelectorAll('a, button, [data-cursor="pointer"], label').forEach(el => {
        el.addEventListener('mouseenter', () => document.body.classList.add('cursor-hover'));
        el.addEventListener('mouseleave', () => document.body.classList.remove('cursor-hover'));
    });

    /* Masquer le curseur quand la souris quitte la fenêtre */
    document.addEventListener('mouseleave', () => {
        dot.style.opacity  = '0';
        ring.style.opacity = '0';
    });
    document.addEventListener('mouseenter', () => {
        dot.style.opacity  = '1';
        ring.style.opacity = '1';
    });
}

/* ── ② NAVBAR — effet blur au scroll ────────────────────────────
   La classe `.scrolled` active le fond verre et l'ombre portée.     */
function initNavbar() {
    const navbar = document.getElementById('navbar');
    if (!navbar) return;

    const onScroll = () => navbar.classList.toggle('scrolled', window.scrollY > 80);

    window.addEventListener('scroll', onScroll, { passive: true });
    onScroll(); /* appliquer dès le chargement si la page est déjà scrollée */
}

/* ── ③ MENU MOBILE ───────────────────────────────────────────────  */
function initMobileMenu() {
    const toggle    = document.getElementById('menu-toggle');
    const menu      = document.getElementById('mobile-menu');
    const iconOpen  = document.getElementById('icon-open');
    const iconClose = document.getElementById('icon-close');

    if (!toggle || !menu) return;

    toggle.addEventListener('click', () => {
        const isOpen = menu.classList.contains('open');
        menu.classList.toggle('open', !isOpen);
        iconOpen?.classList.toggle('hidden', !isOpen);
        iconClose?.classList.toggle('hidden', isOpen);
        toggle.setAttribute('aria-expanded', String(!isOpen));
    });

    /* Fermer en cliquant sur un lien */
    menu.querySelectorAll('a').forEach(link => {
        link.addEventListener('click', () => {
            menu.classList.remove('open');
            iconOpen?.classList.remove('hidden');
            iconClose?.classList.add('hidden');
            toggle.setAttribute('aria-expanded', 'false');
        });
    });
}

/* ── ④ LIEN NAV ACTIF selon la section visible ───────────────────  */
function initActiveNavLinks() {
    const sections = [...document.querySelectorAll('section[id]')];
    const links    = [...document.querySelectorAll('.nav-link[href^="#"]')];

    const onScroll = () => {
        const scrollMid = window.scrollY + window.innerHeight / 3;
        let active = sections[0];

        sections.forEach(section => {
            if (scrollMid >= section.offsetTop) active = section;
        });

        links.forEach(link => {
            link.classList.toggle('active', link.getAttribute('href') === `#${active?.id}`);
        });
    };

    window.addEventListener('scroll', onScroll, { passive: true });
    onScroll();
}

/* ── ⑤ ANIMATIONS AU SCROLL (IntersectionObserver) ──────────────
   Chaque élément portant [data-animate] entre dans le viewport
   et reçoit la classe `.animate-in` qui déclenche la transition.    */
function initScrollAnimations() {
    const targets = document.querySelectorAll('[data-animate]');
    if (!targets.length) return;

    const observer = new IntersectionObserver(
        (entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('animate-in');
                    observer.unobserve(entry.target); /* animation unique */
                }
            });
        },
        { threshold: 0.1, rootMargin: '0px 0px -60px 0px' }
    );

    targets.forEach(el => observer.observe(el));
}

/* ── ⑥ BARRES DE COMPÉTENCES ──────────────────────────────────────
   Les barres `.skill-bar-fill` sont initialement à width:0.
   Quand elles entrent dans le viewport, on applique la largeur
   cible stockée dans data-width (en pourcentage).                   */
function initSkillBars() {
    const bars = document.querySelectorAll('.skill-bar-fill');
    if (!bars.length) return;

    const observer = new IntersectionObserver(
        (entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const target = entry.target.dataset.width || '0';
                    entry.target.style.width = target + '%';
                    observer.unobserve(entry.target);
                }
            });
        },
        { threshold: 0.3 }
    );

    bars.forEach(bar => observer.observe(bar));
}

/* ── ⑦ SLIDER TÉMOIGNAGES ────────────────────────────────────────
   - Sur mobile  : 1 carte visible.
   - Sur desktop : 2 cartes visibles.
   - Auto-play pausé au survol, repris à la sortie.
   - Support du swipe tactile.                                        */
function initTestimonialsSlider() {
    const track = document.getElementById('testimonials-track');
    const dotsEl = document.getElementById('slider-dots');
    const prevBtn = document.getElementById('slider-prev');
    const nextBtn = document.getElementById('slider-next');

    if (!track) return;

    const cards = [...track.querySelectorAll('.testimonial-card')];
    if (!cards.length) return;

    let currentIndex  = 0;
    let visibleCount  = window.innerWidth >= 768 ? 2 : 1;
    let maxIndex      = Math.max(0, cards.length - visibleCount);
    let autoPlayTimer = null;
    const dots        = [];

    /* Générer les points indicateurs */
    if (dotsEl) {
        for (let i = 0; i <= maxIndex; i++) {
            const dot = document.createElement('button');
            dot.className     = 'slider-dot w-2';
            dot.style.width   = '8px';
            dot.setAttribute('aria-label', `Témoignage ${i + 1}`);
            if (i === 0) dot.classList.add('active');
            dot.addEventListener('click', () => goToSlide(i));
            dotsEl.appendChild(dot);
            dots.push(dot);
        }
    }

    function syncDots() {
        dots.forEach((d, i) => d.classList.toggle('active', i === currentIndex));
    }

    function goToSlide(index) {
        currentIndex = Math.max(0, Math.min(index, maxIndex));
        /* Déplacement : chaque carte occupe 100/visibleCount % de largeur */
        track.style.transform = `translateX(-${currentIndex * (100 / visibleCount)}%)`;
        syncDots();
    }

    const next = () => goToSlide(currentIndex >= maxIndex ? 0 : currentIndex + 1);
    const prev = () => goToSlide(currentIndex <= 0 ? maxIndex : currentIndex - 1);

    prevBtn?.addEventListener('click', prev);
    nextBtn?.addEventListener('click', next);

    /* Auto-play toutes les 4,5 secondes */
    const startAuto = () => { autoPlayTimer = setInterval(next, 4500); };
    const stopAuto  = () => clearInterval(autoPlayTimer);

    startAuto();
    track.closest('.testimonials-wrapper')?.addEventListener('mouseenter', stopAuto);
    track.closest('.testimonials-wrapper')?.addEventListener('mouseleave', startAuto);

    /* Recalculer lors du redimensionnement */
    window.addEventListener('resize', () => {
        const newVisible = window.innerWidth >= 768 ? 2 : 1;
        if (newVisible !== visibleCount) {
            visibleCount = newVisible;
            maxIndex     = Math.max(0, cards.length - visibleCount);
            goToSlide(0);
        }
    });

    /* Swipe tactile (seuil 50px) */
    let touchStartX = 0;
    track.addEventListener('touchstart', e => { touchStartX = e.touches[0].clientX; }, { passive: true });
    track.addEventListener('touchend',   e => {
        const delta = touchStartX - e.changedTouches[0].clientX;
        if (Math.abs(delta) > 50) delta > 0 ? next() : prev();
    });
}

/* ── ⑧ MODALES PROJETS ───────────────────────────────────────────
   openModal / closeModal sont exposées globalement pour les onclick. */
function initProjectModals() {

    function openModal(id) {
        const modal = document.getElementById(`modal-${id}`);
        if (!modal) return;
        modal.style.display = 'flex';
        /* On laisse un frame pour que la transition opacity soit visible */
        requestAnimationFrame(() => {
            requestAnimationFrame(() => modal.classList.add('show'));
        });
        document.body.style.overflow = 'hidden';
    }

    function closeModal(id) {
        const modal = document.getElementById(`modal-${id}`);
        if (!modal) return;
        modal.classList.remove('show');
        setTimeout(() => {
            modal.style.display = 'none';
            document.body.style.overflow = '';
        }, 380);
    }

    /* Exposer globalement (appelé via onclick dans le HTML) */
    window.openModal  = openModal;
    window.closeModal = closeModal;

    /* Clic sur le fond sombre = fermeture */
    document.querySelectorAll('.modal-backdrop').forEach(modal => {
        modal.addEventListener('click', e => {
            if (e.target === modal) closeModal(modal.id.replace('modal-', ''));
        });
    });

    /* Touche Échap = fermeture de toutes les modales ouvertes */
    document.addEventListener('keydown', e => {
        if (e.key !== 'Escape') return;
        document.querySelectorAll('.modal-backdrop.show').forEach(modal => {
            closeModal(modal.id.replace('modal-', ''));
        });
    });
}

/* ── ⑨ ACCORDÉON FAQ ─────────────────────────────────────────────
   Un seul item ouvert à la fois. max-height gère l'animation CSS.   */
function initFaqAccordion() {
    document.querySelectorAll('.faq-question').forEach(question => {
        question.addEventListener('click', () => {
            const item   = question.closest('.faq-item');
            const answer = item.querySelector('.faq-answer');
            const isOpen = item.classList.contains('open');

            /* Fermer tous */
            document.querySelectorAll('.faq-item.open').forEach(openItem => {
                openItem.classList.remove('open');
                openItem.querySelector('.faq-answer').style.maxHeight = '0';
            });

            /* Ouvrir l'item cliqué si il était fermé */
            if (!isOpen) {
                item.classList.add('open');
                answer.style.maxHeight = answer.scrollHeight + 'px';
            }
        });
    });
}

/* ── ⑩ EFFET DE FRAPPE — Hero ────────────────────────────────────
   Affiche des phrases en boucle avec un effet typewriter.           */
function initTypingEffect() {
    const el = document.getElementById('typing-text');
    if (!el) return;

    const phrases = [
        'Développeur Web Full-Stack',
        'Expert PHP 8 & JavaScript',
        'UI/UX Designer',
        'Fondateur d\'Agre Agency',
    ];

    let phraseIndex = 0;
    let charIndex   = 0;
    let isDeleting  = false;
    let speed       = 80;

    function type() {
        const current = phrases[phraseIndex];

        el.textContent = isDeleting
            ? current.slice(0, charIndex - 1)
            : current.slice(0, charIndex + 1);

        charIndex = isDeleting ? charIndex - 1 : charIndex + 1;

        if (!isDeleting && charIndex === current.length + 1) {
            /* Fin de frappe → pause avant d'effacer */
            isDeleting = true;
            speed = 2600;
        } else if (isDeleting && charIndex === 0) {
            /* Fin d'effacement → phrase suivante */
            isDeleting  = false;
            phraseIndex = (phraseIndex + 1) % phrases.length;
            speed       = 300;
        } else {
            speed = isDeleting ? 42 : 80;
        }

        setTimeout(type, speed);
    }

    type();
}

/* ── ⑪ SCROLL DOUX sur les ancres internes ───────────────────── */
function initSmoothScroll() {
    document.querySelectorAll('a[href^="#"]').forEach(link => {
        link.addEventListener('click', e => {
            const target = document.querySelector(link.getAttribute('href'));
            if (!target) return;
            e.preventDefault();
            target.scrollIntoView({ behavior: 'smooth', block: 'start' });
        });
    });
}

/* ── ⑫ BOUTON RETOUR EN HAUT ─────────────────────────────────────
   Apparaît après 400px de scroll, disparaît en revenant en haut.   */
function initBackToTop() {
    const btn = document.getElementById('back-to-top');
    if (!btn) return;

    const onScroll = () => btn.classList.toggle('visible', window.scrollY > 400);

    window.addEventListener('scroll', onScroll, { passive: true });
    onScroll();
}

/* ── ⑬ FORMULAIRE CONTACT — AJAX fetch vers contact.php ─────────
   Architecture :
     1. preventDefault() → aucun rechargement de page
     2. fetch('contact.php') avec FormData
     3. Réponse JSON : { status, message }
     4. UX : spinner pendant l'envoi, feedback coloré, reset du form  */
function initContactForm() {
    const form      = document.getElementById('contact-form');
    const feedback  = document.getElementById('form-feedback');
    const submitBtn = form?.querySelector('[type="submit"]');

    if (!form || !submitBtn) return;

    /* ── showFeedback(type, message) ───────────────────────────���─
       type : 'success' | 'error' | 'invalid'
       - Succès    → turquoise via CSS [data-type="success"]
       - Erreur    → rouge
       - Invalide  → ambre
       - Animation : feedbackIn à l'entrée, feedbackOut avant masquage
       - Succès    → disparaît automatiquement après 7 s               */
    let hideTimer = null;

    function showFeedback(type, message) {
        if (!feedback) return;

        /* Annuler un éventuel timer de masquage précédent */
        clearTimeout(hideTimer);
        feedback.classList.remove('hiding');

        /* Classes Tailwind pour erreur et invalide (succès géré en CSS pur) */
        const twClasses = {
            error   : 'bg-red-500/10   border-red-500/30   text-red-400',
            invalid : 'bg-amber-500/10 border-amber-500/30 text-amber-400',
        };
        const icons = {
            success : 'fa-check-circle',
            error   : 'fa-exclamation-circle',
            invalid : 'fa-exclamation-triangle',
        };

        /* Réinitialiser les classes, puis appliquer le style du type courant */
        feedback.className = `mb-6 p-4 border rounded-xl text-sm flex items-center gap-3 ${twClasses[type] ?? ''}`;
        feedback.dataset.type = type; /* déclenche le CSS turquoise sur [data-type="success"] */
        feedback.innerHTML = `
            <i class="fas ${icons[type] ?? icons.error} text-xl flex-shrink-0"></i>
            <p class="font-medium leading-snug">${message}</p>`;

        /* Afficher + lancer feedbackIn */
        feedback.classList.remove('hidden');
        feedback.scrollIntoView({ behavior: 'smooth', block: 'nearest' });

        /* Auto-masquage pour le succès : feedbackOut → hidden après 7 s */
        if (type === 'success') {
            hideTimer = setTimeout(() => {
                feedback.classList.add('hiding');
                /* Attendre la fin de feedbackOut (400 ms) avant de masquer */
                setTimeout(() => {
                    feedback.classList.add('hidden');
                    feedback.classList.remove('hiding');
                }, 420);
            }, 7000);
        }
    }

    form.addEventListener('submit', async (e) => {
        e.preventDefault(); /* ← empêche le rechargement de la page */

        console.log('[Agre Agency] Formulaire soumis — début fetch()');

        /* ── État de chargement ── */
        const originalHTML    = submitBtn.innerHTML;
        submitBtn.disabled    = true;
        submitBtn.innerHTML   = '<i class="fas fa-spinner fa-spin mr-2"></i> Envoi en cours…';
        feedback.classList.add('hidden'); /* masquer un éventuel feedback précédent */

        try {
            const response = await fetch('./contact.php', {
                method : 'POST',
                body   : new FormData(form),
            });

            /* Lire le corps brut d'abord — permet de logger en cas de non-JSON */
            const rawText = await response.text();
            console.log('[Agre Agency] Réponse brute (HTTP', response.status, ') :', rawText);

            let data;
            try {
                data = JSON.parse(rawText);
            } catch (jsonErr) {
                console.error('[Agre Agency] Réponse non-JSON — extrait :', rawText.substring(0, 600));
                throw new Error(`Réponse serveur invalide (HTTP ${response.status})`);
            }

            console.log('[Agre Agency] Réponse serveur parsée :', data);

            if (data.status === 'success') {
                showFeedback('success', data.message ?? 'Message envoyé ! Je vous répondrai dans les 24h.');
                form.reset(); /* vider tous les champs */
            } else if (data.status === 'invalid') {
                showFeedback('invalid', data.message ?? 'Veuillez remplir tous les champs correctement.');
            } else {
                showFeedback('error', data.message ?? "Une erreur est survenue. Contactez-moi directement : agrekevin09@gmail.com");
            }

        } catch (err) {
            /* Erreur réseau ou réponse non-JSON (ex : erreur PHP fatale) */
            console.error('[Agre Agency] Erreur fetch :', err);
            showFeedback('error', 'Erreur réseau. Vérifiez votre connexion ou contactez-moi par email.');
        } finally {
            /* Restaurer le bouton dans tous les cas */
            submitBtn.disabled  = false;
            submitBtn.innerHTML = originalHTML;
        }
    });
}
