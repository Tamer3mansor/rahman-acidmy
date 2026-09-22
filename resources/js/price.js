const price = (() => {
    const grid = document.getElementById('packagesGrid');
    const filter = document.getElementById('durationFilter');

    const formatMoney = (value) => Number(value).toFixed(2).replace('.', ',');
    const moneyAttr = (value) => Number(value).toFixed(2);

    const currentDuration = () => {
        if (!filter) {
            return 60;
        }

        const active = filter.querySelector('.duration-option.active');

        return active ? Number(active.dataset.duration) : 60;
    };

    const recomputeCard = (card, minutes) => {
        const classes = Number(card.dataset.classes);
        const rate = Number(card.dataset.rate);
        const factor = minutes / 60;
        const total = classes * factor * rate;
        const perLesson = Math.round((total / classes) * 100) / 100;

        card.dataset.price = moneyAttr(total);

        const amount = card.querySelector('.price-amount');
        if (amount) {
            amount.textContent = formatMoney(total);
        }

        const perLessonEl = card.querySelector('.per-lesson-val');
        if (perLessonEl) {
            perLessonEl.textContent = formatMoney(perLesson);
        }

        const generalRate = Number(card.dataset.generalRate || 0);
        const general = classes * factor * generalRate;
        const generalEl = card.querySelector('.price-general');
        if (generalEl) {
            generalEl.textContent = formatMoney(general) + '€';
            generalEl.dataset.priceGeneral = moneyAttr(general);
        }
    };

    const refreshPrices = (minutes) => {
        if (!grid) {
            return;
        }

        grid.querySelectorAll('.package-card').forEach((card) => recomputeCard(card, minutes));
    };

    const selectDuration = (button) => {
        if (!filter) {
            return;
        }

        filter.querySelectorAll('.duration-option').forEach((btn) => btn.classList.toggle('active', btn === button));
        refreshPrices(Number(button.dataset.duration));
    };

    if (filter) {
        filter.addEventListener('click', (event) => {
            const btn = event.target.closest('.duration-option');
            if (btn) {
                selectDuration(btn);
            }
        });
    }

    const selectPackage = (button) => {
        const card = button.closest('.package-card');
        if (!card || !grid) {
            return;
        }

        const packName = card.dataset.packName;
        const classesCount = card.dataset.classes;
        const totalPrice = card.dataset.price;
        const phone = card.dataset.waPhone || grid.dataset.waPhone || '';
        const duration = currentDuration();

        if (!phone) {
            return;
        }

        const message = `Bonjour,\nJe souhaite m'inscrire au : *${packName}*\n- Nombre de cours : ${classesCount}\n- Durée : ${duration} min\n- Prix total : ${totalPrice}€\n\nMerci de me contacter pour planifier les créneaux et commencer.`;

        window.open(`https://wa.me/${phone}?text=${encodeURIComponent(message)}`, '_blank');
    };

    if (grid) {
        grid.addEventListener('click', (event) => {
            const btn = event.target.closest('[data-select-package]');
            if (btn) {
                selectPackage(btn);
            }
        });
    }

    return { selectPackage, selectDuration };
})();