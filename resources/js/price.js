const price = (() => {
    const grid = document.getElementById('packagesGrid');

    const selectPackage = (button) => {
        const card = button.closest('.package-card');
        if (!card || !grid) {
            return;
        }

        const packName = card.dataset.packName;
        const classesCount = card.dataset.classes;
        const totalPrice = card.dataset.price;
        const phone = grid.dataset.waPhone || '';

        if (!phone) {
            return;
        }

        const message = `Bonjour,\nJe souhaite m'inscrire au : *${packName}*\n- Nombre de cours : ${classesCount}\n- Prix total : ${totalPrice}€\n\nMerci de me contacter pour planifier les créneaux et commencer.`;

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

    return { selectPackage };
})();