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

    /* Mobile menu toggle */
    if (e.target.closest('#hamburger')) {
        toggleMenu();

        return;
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
});

/* ============================================================
   SCROLL TO FORM
   ============================================================ */
function scrollToForm() {
    const form = document.getElementById('trial-form');
    if (form) form.scrollIntoView({ behavior: 'smooth', block: 'start' });

    document.getElementById('mobileMenu').classList.remove('open');
}

/* ============================================================
   MOBILE MENU
   ============================================================ */
function toggleMenu() {
    document.getElementById('mobileMenu').classList.toggle('open');
}

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

contactForm?.addEventListener('submit', async (e) => {
    e.preventDefault();

    const btn = document.getElementById('submitBtn');
    btn.disabled = true;
    btn.innerHTML = spinnerHtml('جاري الإرسال...');

    const schedule = [];
    document.querySelectorAll('.sched-option input:checked').forEach((cb) => schedule.push(cb.value));

    const payload = {
        student_name: document.getElementById('studentName').value,
        parent_name: document.getElementById('parentName').value,
        student_age: document.getElementById('studentAge').value,
        phone: document.getElementById('phone').value,
        email: document.getElementById('email').value,
        level: document.querySelector('input[name="level"]:checked')?.value || '',
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
            let message = 'حدث خطأ، حاول مرة أخرى';
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
                    timestamp: new Date().toLocaleString('ar-EG'),
                }),
            });
        }

        showToast('تم إرسال طلبك بنجاح! سنتواصل معك خلال 24 ساعة ✓');
        contactForm.reset();
    } catch (_) {
        showToast('تم استلام طلبك! سنتواصل معك قريباً ✓');
    }

    resetButton(btn);
});

function spinnerHtml(label) {
    return `<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="animation:spin 1s linear infinite"><path d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" stroke-dasharray="60" stroke-dashoffset="15"/></svg> ${label}`;
}

function submitButtonHtml() {
    const icon = '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>';

    return `${icon} أرسل طلبي وسأنتظر التواصل`;
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