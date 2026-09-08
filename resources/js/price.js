const price = (() => {
    let currentDuration = 30;

    const picker = document.getElementById('durationPicker');
    const grid = document.getElementById('packagesGrid');

    const setDuration = (duration) => {
        currentDuration = duration;

        if (picker) {
            picker.querySelectorAll('.duration-btn').forEach((btn) => {
                btn.classList.toggle('active', parseInt(btn.dataset.duration, 10) === duration);
            });
        }

        if (grid) {
            grid.querySelectorAll('.package-card').forEach((card) => {
                card.querySelectorAll('.price-duration').forEach((block) => {
                    block.hidden = parseInt(block.dataset.duration, 10) !== duration;
                });
            });
        }

        document.querySelectorAll('.duration-label-text').forEach((el) => {
            const label = el.dataset[`durationLabel${duration}`];
            if (label) {
                el.textContent = label;
            }
        });
    };

    const selectPackage = (button) => {
        const card = button.closest('.package-card');
        if (!card || !grid) {
            return;
        }

        const packName = card.dataset.packName;
        const classesCount = card.dataset.classes;
        const totalPrice = card.dataset[`price${currentDuration}`];
        const phone = grid.dataset.waPhone || '';

        if (!phone) {
            return;
        }

        const message = `Bonjour,\nJe souhaite m'inscrire au : *${packName}*\n- Nombre de cours : ${classesCount} cours\n- Durée du cours : ${currentDuration} minutes\n- Prix total : ${totalPrice}€\n\nMerci de me contacter pour planifier les créneaux et commencer.`;

        window.open(`https://wa.me/${phone}?text=${encodeURIComponent(message)}`, '_blank');
    };

    if (picker) {
        picker.addEventListener('click', (event) => {
            const btn = event.target.closest('.duration-btn');
            if (btn && btn.dataset.duration) {
                setDuration(parseInt(btn.dataset.duration, 10));
            }
        });
    }

    if (grid) {
        grid.addEventListener('click', (event) => {
            const btn = event.target.closest('[data-select-package]');
            if (btn) {
                selectPackage(btn);
            }
        });
    }

    return { setDuration };
})();