/* ============================================================
   Ar-Rahman Academy — landing page scripts
   ============================================================ */

/* ============================================================
   EVENT DELEGATION — one click handler for the whole page
   (replaces inline onclick handlers so globals aren't needed)
   ============================================================ */
document.addEventListener('click', (e) => {
    /* Scroll-to-form CTAs */
    if (e.target.closest('[data-scroll-to-form]')) {
        scrollToForm();

        return;
    }

    /* FAQ accordion */
    const faqToggle = e.target.closest('[data-faq-toggle]');
    if (faqToggle) {
        toggleFaq(faqToggle);

        return;
    }

    /* Dropdown toggle (Nos cours / Ressources) */
    if (e.target.closest('.nav-toggle')) {
        const item = e.target.closest('.nav-item');
        const wasOpen = item.classList.contains('open');
        document.querySelectorAll('.nav-item.open').forEach((i) => {
            i.classList.remove('open');
            i.querySelector('.nav-toggle')?.setAttribute('aria-expanded', 'false');
        });
        if (!wasOpen) {
            item.classList.add('open');
            item.querySelector('.nav-toggle')?.setAttribute('aria-expanded', 'true');
        }

        return;
    }

    /* Mobile menu toggle */
    if (e.target.closest('#hamburger')) {
        toggleMenu();

        return;
    }

    /* Theme toggle */
    if (e.target.closest('[data-theme-toggle]')) {
        toggleTheme();

        return;
    }

    /* Close dropdowns when clicking outside */
    if (!e.target.closest('.nav-item') && !e.target.closest('#hamburger')) {
        document.querySelectorAll('.nav-item.open').forEach((i) => i.classList.remove('open'));
    }

    /* Scroll to top */
    if (e.target.closest('#scrollTop')) {
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }
});

/* Close mobile menu when a link inside it is clicked */
document.addEventListener('click', (e) => {
    if (!e.target.closest('.mobile-menu a')) return;

    document.getElementById('mobileMenu').classList.remove('open');
    document.getElementById('hamburger')?.classList.remove('is-active');
    document.body.style.overflow = '';
});

/* ============================================================
   THEME
   The initial theme is set by the inline bootstrap script in
   layouts/landing.blade.php so it is applied before first paint; this
   only handles toggling and persistence.
   ============================================================ */
const THEME_STORAGE_KEY = 'theme';

function currentTheme() {
    return document.documentElement.getAttribute('data-theme') === 'dark' ? 'dark' : 'light';
}

function applyTheme(theme) {
    document.documentElement.setAttribute('data-theme', theme);

    try {
        window.localStorage.setItem(THEME_STORAGE_KEY, theme);
    } catch (error) {
        /* Storage unavailable (private mode): the theme still applies for this page. */
    }
}

function toggleTheme() {
    applyTheme(currentTheme() === 'dark' ? 'light' : 'dark');
}

/* Follow the system preference until the visitor picks a theme themselves. */
window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', (event) => {
    let stored = null;

    try {
        stored = window.localStorage.getItem(THEME_STORAGE_KEY);
    } catch (error) {
        stored = null;
    }

    if (stored === 'light' || stored === 'dark') return;

    document.documentElement.setAttribute('data-theme', event.matches ? 'dark' : 'light');
});

/* ============================================================
   SCROLL TO FORM
   ============================================================ */
function scrollToForm() {
    const form = document.getElementById('trial-form');
    if (form) form.scrollIntoView({ behavior: 'smooth', block: 'start' });

    document.getElementById('mobileMenu').classList.remove('open');
    document.getElementById('hamburger')?.classList.remove('is-active');
    document.body.style.overflow = '';
}

/* ============================================================
   MOBILE MENU
   ============================================================ */
function toggleMenu() {
    const menu = document.getElementById('mobileMenu');
    const hamburger = document.getElementById('hamburger');
    const isOpen = menu.classList.toggle('open');

    hamburger.classList.toggle('is-active', isOpen);

    /* Prevent body scroll while mobile menu is open */
    document.body.style.overflow = isOpen ? 'hidden' : '';
}

/* Close the mobile menu when clicking outside */
document.addEventListener('click', (e) => {
    const menu = document.getElementById('mobileMenu');
    const hamburger = document.getElementById('hamburger');

    if (!menu || !menu.classList.contains('open')) return;
    if (e.target.closest('#mobileMenu') || e.target.closest('#hamburger')) return;

    menu.classList.remove('open');
    hamburger.classList.remove('is-active');
    document.body.style.overflow = '';
});

/* ============================================================
   FAQ
   ============================================================ */
function toggleFaq(el) {
    const item = el.closest('.faq-item');
    const isOpen = item.classList.contains('open');

    document.querySelectorAll('.faq-item').forEach((i) => i.classList.remove('open'));
    if (!isOpen) item.classList.add('open');
}

/* ============================================================
   NAVBAR scroll
   ============================================================ */
window.addEventListener('scroll', () => {
    document.getElementById('navbar').classList.toggle('scrolled', window.scrollY > 60);
    document.getElementById('scrollTop').classList.toggle('visible', window.scrollY > 400);
}, { passive: true });

/* ============================================================
   FORM SUBMIT — Laravel backend (contact_submissions table).
   A Google Sheets hook is optional: set GOOGLE_SHEETS_FORM_URL
   in config/services.php to also forward the payload.
   ============================================================ */
const contactForm = document.getElementById('trialForm');

/* Copy comes from "إعدادات الصفحة الرئيسية" so an admin can change the
   toasts and the button label without touching this file. */
const FORM_COPY = {
    success: contactForm?.dataset.successText || 'Votre demande a été envoyée avec succès ! Nous vous contacterons dans les 24 heures ✓',
    error: contactForm?.dataset.errorText || 'Une erreur est survenue, veuillez réessayer',
    received: contactForm?.dataset.receivedText || 'Votre demande a été reçue ! Nous vous contacterons bientôt ✓',
    loading: contactForm?.dataset.loadingText || 'Envoi en cours...',
    submit: document.getElementById('submitBtn')?.textContent.trim() || 'Envoyer ma demande et attendre le contact',
};

contactForm?.addEventListener('submit', async (e) => {
    e.preventDefault();

    const btn = document.getElementById('submitBtn');
    btn.disabled = true;
    btn.innerHTML = spinnerHtml(FORM_COPY.loading);

    const scheduleText = document.getElementById('schedule').value.trim();
    const schedule = scheduleText ? [scheduleText] : [];

    const payload = {
        student_name: document.getElementById('studentName').value,
        parent_name: document.getElementById('parentName').value,
        student_age: document.getElementById('studentAge').value,
        phone: document.getElementById('phone').value,
        email: document.getElementById('email').value,
        level: document.getElementById('level').value,
        schedule,
        message: document.getElementById('message').value,
    };

    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') ?? '';

    try {
        const response = await fetch(contactForm.dataset.url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                Accept: 'application/json',
            },
            body: JSON.stringify(payload),
        });

        if (!response.ok) {
            let message = FORM_COPY.error;
            try {
                const data = await response.json();
                message = data.errors ? Object.values(data.errors).flat()[0] : (data.message ?? message);
            } catch (_) {
                /* keep default message */
            }
            showToast('⚠️ ' + message);
            resetButton(btn);

            return;
        }

        /* Google Sheets hook (GAS Web App URL) */
        const googleUrl = contactForm.dataset.googleUrl;
        if (googleUrl) {
            await fetch(googleUrl, {
                method: 'POST',
                mode: 'no-cors',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({
                    studentName: payload.student_name,
                    parentName: payload.parent_name,
                    studentAge: payload.student_age,
                    phone: payload.phone,
                    email: payload.email,
                    level: payload.level,
                    schedule: schedule.join(', '),
                    message: payload.message,
                    timestamp: new Date().toLocaleString('fr-FR'),
                }),
            });
        }

        showToast(FORM_COPY.success);
        contactForm.reset();
    } catch (_) {
        showToast(FORM_COPY.received);
    }

    resetButton(btn);
});

function spinnerHtml(label) {
    return `<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="animation:spin 1s linear infinite"><path d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" stroke-dasharray="60" stroke-dashoffset="15"/></svg> ${label}`;
}

function submitButtonHtml() {
    const icon = '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>';

    return `${icon} ${FORM_COPY.submit}`;
}

function resetButton(btn) {
    btn.disabled = false;
    btn.innerHTML = submitButtonHtml();
}

function showToast(msg) {
    document.getElementById('toastMsg').textContent = msg;
    const t = document.getElementById('toast');
    t.classList.add('show');
    setTimeout(() => t.classList.remove('show'), 4000);
}

function initTeachersCarousel() {
    const carousel = document.getElementById('teachersCarousel');
    const track = document.getElementById('teachersGrid');
    const pagination = carousel?.querySelector('.teachers-pagination');

    if (!carousel || !track || !pagination) return;

    // Clean up any previously cloned cards
    track.querySelectorAll('.teacher-card.is-clone').forEach((el) => el.remove());

    const originalCards = [...track.querySelectorAll('.teacher-card')];
    const totalOriginal = originalCards.length;
    if (totalOriginal < 2) return;

    const AUTOPLAY_MS = 3500;
    const TICK_LEAD_MS = 1200;
    const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    let currentIndex = 0;
    let step = 0;
    let autoTimer = null;
    let firstTimer = null;
    let isPaused = false;
    let isAnimating = false;

    const perPage = () => {
        if (window.matchMedia('(max-width: 768px)').matches) return 1;
        if (window.matchMedia('(max-width: 1024px)').matches) return 2;
        return 3;
    };

    // Clone cards to achieve seamless infinite loop
    const setupClones = () => {
        track.querySelectorAll('.teacher-card.is-clone').forEach((el) => el.remove());
        const visible = perPage();
        const cloneCount = Math.min(visible + 1, totalOriginal);
        for (let i = 0; i < cloneCount; i += 1) {
            const clone = originalCards[i].cloneNode(true);
            clone.classList.add('is-clone');
            clone.setAttribute('aria-hidden', 'true');
            // Clone buttons inside should scroll to form too
            track.appendChild(clone);
        }
    };

    const measure = () => {
        const first = originalCards[0];
        const second = originalCards[1] || track.querySelector('.teacher-card.is-clone');
        if (first && second) {
            step = second.offsetLeft - first.offsetLeft;
        } else if (first) {
            step = first.offsetWidth + 24;
        }
        if (step <= 0 && first) {
            step = first.getBoundingClientRect().width + 24;
        }
    };

    const updateBullets = () => {
        const bullets = pagination.querySelectorAll('.teachers-pagination-bullet');
        const activeMod = currentIndex % totalOriginal;
        bullets.forEach((bullet, idx) => {
            const isActive = idx === activeMod;
            const distance = Math.abs(idx - activeMod);
            bullet.classList.toggle('is-active', isActive);
            bullet.classList.toggle('is-near', distance === 1);
            bullet.setAttribute('aria-current', isActive ? 'true' : 'false');
        });
    };

    const applyTransform = (withTransition = true) => {
        measure();
        track.style.transition = withTransition ? 'transform 0.55s cubic-bezier(0.25, 1, 0.5, 1)' : 'none';
        track.style.transform = `translateX(-${currentIndex * step}px)`;
        updateBullets();
    };

    const initPagination = () => {
        pagination.replaceChildren();
        for (let i = 0; i < totalOriginal; i += 1) {
            const bullet = document.createElement('button');
            bullet.type = 'button';
            bullet.className = `teachers-pagination-bullet${i === 0 ? ' is-active' : ''}`;
            bullet.setAttribute('aria-label', `Professeur ${i + 1} sur ${totalOriginal}`);
            bullet.setAttribute('aria-current', i === 0 ? 'true' : 'false');
            bullet.addEventListener('click', () => {
                if (isAnimating) return;
                currentIndex = i;
                applyTransform(true);
                resetAuto();
            });
            pagination.append(bullet);
        }
    };

    const nextCard = () => {
        if (isPaused || isAnimating) return;
        isAnimating = true;
        currentIndex += 1;
        applyTransform(true);
    };

    track.addEventListener('transitionend', (e) => {
        if (e.target !== track) return;
        isAnimating = false;
        if (currentIndex >= totalOriginal) {
            currentIndex = currentIndex % totalOriginal;
            applyTransform(false);
            void track.offsetHeight; // Force reflow
        }
    });

    const startAuto = () => {
        if (prefersReducedMotion || autoTimer || firstTimer) return;
        firstTimer = window.setTimeout(() => {
            firstTimer = null;
            nextCard();
            autoTimer = window.setInterval(nextCard, AUTOPLAY_MS);
        }, TICK_LEAD_MS);
    };

    const stopAuto = () => {
        if (firstTimer) {
            window.clearTimeout(firstTimer);
            firstTimer = null;
        }
        if (autoTimer) {
            window.clearInterval(autoTimer);
            autoTimer = null;
        }
    };

    const resetAuto = () => {
        stopAuto();
        startAuto();
    };

    // Touch swipe handling
    let touchStartX = 0;
    let touchEndX = 0;
    carousel.addEventListener('touchstart', (e) => {
        isPaused = true;
        touchStartX = e.changedTouches[0].screenX;
    }, { passive: true });

    carousel.addEventListener('touchend', (e) => {
        isPaused = false;
        touchEndX = e.changedTouches[0].screenX;
        const diff = touchStartX - touchEndX;
        if (Math.abs(diff) > 40) {
            if (diff > 0) {
                // Swipe left -> next card
                if (!isAnimating) {
                    isAnimating = true;
                    currentIndex += 1;
                    applyTransform(true);
                }
            } else {
                // Swipe right -> prev card
                if (!isAnimating) {
                    isAnimating = true;
                    if (currentIndex === 0) {
                        currentIndex = totalOriginal;
                        applyTransform(false);
                        void track.offsetHeight;
                    }
                    currentIndex -= 1;
                    applyTransform(true);
                }
            }
            resetAuto();
        }
    }, { passive: true });

    carousel.addEventListener('mouseenter', () => { isPaused = true; });
    carousel.addEventListener('mouseleave', () => { isPaused = false; });
    carousel.addEventListener('focusin', () => { isPaused = true; });
    carousel.addEventListener('focusout', () => { isPaused = false; });
    document.addEventListener('visibilitychange', () => {
        if (document.hidden) stopAuto(); else startAuto();
    });

    const init = () => {
        setupClones();
        initPagination();
        measure();
        carousel.classList.add('is-ready');
        applyTransform(false);
        startAuto();
    };

    init();

    window.addEventListener('resize', () => {
        setupClones();
        currentIndex = currentIndex % totalOriginal;
        applyTransform(false);
    }, { passive: true });

    window.addEventListener('load', () => {
        measure();
        applyTransform(false);
    }, { once: true });
}

function initTrustMobileTabs() {
    const tabsContainer = document.querySelector('[data-trust-tabs]');
    const trustGrid = document.querySelector('.trust-grid');
    if (!tabsContainer || !trustGrid) return;

    const tabButtons = tabsContainer.querySelectorAll('.trust-tab-btn');
    const panes = trustGrid.querySelectorAll('[data-trust-pane]');

    tabButtons.forEach((btn) => {
        btn.addEventListener('click', () => {
            const target = btn.dataset.tab;
            tabButtons.forEach((b) => {
                const isActive = b === btn;
                b.classList.toggle('is-active', isActive);
                b.setAttribute('aria-selected', isActive ? 'true' : 'false');
            });
            panes.forEach((pane) => {
                const isActive = pane.dataset.trustPane === target;
                pane.classList.toggle('is-tab-active', isActive);
            });
            trustGrid.setAttribute('data-active-tab', target);
        });
    });
}

function initTrustVideosColumn() {
    const column = document.querySelector('[data-trust-videos]');
    const wrap = column?.closest('.trust-videos-wrap');

    if (!column || !wrap) return;

    const update = () => {
        const atBottom = column.scrollTop + column.clientHeight >= column.scrollHeight - 8;
        wrap.classList.toggle('has-more', column.scrollHeight > column.clientHeight + 4 && !atBottom);
    };

    column.addEventListener('scroll', update, { passive: true });
    window.addEventListener('resize', update, { passive: true });
    window.addEventListener('load', update, { once: true });
    window.setTimeout(update, 800);

    update();
}

function initHeroVideo() {
    const video = document.querySelector('[data-hero-video]');

    if (!video) return;

    const muteBtn = document.querySelector('[data-hero-mute]');
    const icoSound = muteBtn?.querySelector('[data-hero-ico-sound]');
    const icoMuted = muteBtn?.querySelector('[data-hero-ico-muted]');
    const soundLabel = muteBtn?.querySelector('[data-hero-sound-label]');

    let visitorChose = false;

    const play = () => {
        const attempt = video.play();

        if (attempt !== undefined && typeof attempt.catch === 'function') {
            attempt.catch(() => { /* blocked until the visitor interacts */ });
        }
    };

    const setSound = (on) => {
        video.muted = !on;

        if (!muteBtn) return;

        muteBtn.classList.toggle('is-muted', !on);
        muteBtn.setAttribute('aria-pressed', on ? 'true' : 'false');
        muteBtn.setAttribute('aria-label', on ? 'Couper le son' : 'Activer le son');
        if (icoSound) icoSound.hidden = !on;
        if (icoMuted) icoMuted.hidden = on;
        if (soundLabel) soundLabel.textContent = on ? 'Couper le son' : 'Activer le son';
    };

    const enableSound = () => {
        if (visitorChose) return;

        setSound(true);
        play();
    };

    muteBtn?.addEventListener('click', (event) => {
        event.stopPropagation();
        visitorChose = true;
        setSound(video.muted);
        if (video.paused) play();
    });

    video.addEventListener('click', () => {
        visitorChose = true;
        if (video.paused) {
            setSound(true);
            play();
        } else {
            video.pause();
        }
    });

    ['pointerdown', 'touchstart', 'keydown', 'wheel'].forEach((evt) => {
        window.addEventListener(evt, enableSound, { once: true, passive: true });
    });

    setSound(false);

    if (!video.hasAttribute('autoplay')) return;

    video.muted = false;
    const attempt = video.play();

    if (attempt === undefined || typeof attempt.then !== 'function') return;

    attempt
        .then(() => { if (!visitorChose) setSound(true); })
        .catch(() => {
            if (visitorChose) return;
            setSound(false);
            play();
        });
}

initTeachersCarousel();
initTrustVideosColumn();
initTrustMobileTabs();
initHeroVideo();
