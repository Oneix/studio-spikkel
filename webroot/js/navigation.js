const menuButton = document.querySelector('.menu-button');
const menu = document.querySelector('#hoofdmenu');

if (menuButton && menu) {
    const mobile = window.matchMedia('(max-width: 980px)');
    const setExpanded = (expanded) => {
        menuButton.setAttribute('aria-expanded', String(expanded));
        menu.hidden = mobile.matches && !expanded;
    };
    const updateMenu = () => {
        menuButton.hidden = !mobile.matches;
        setExpanded(false);
    };

    menuButton.addEventListener('click', () => {
        setExpanded(menuButton.getAttribute('aria-expanded') !== 'true');
    });
    menu.addEventListener('keydown', (event) => {
        if (event.key === 'Escape' && mobile.matches) {
            setExpanded(false);
            menuButton.focus();
        }
    });
    mobile.addEventListener('change', updateMenu);
    updateMenu();
}

const holiday = document.querySelector('dialog[data-holiday-key]');
if (holiday && typeof holiday.showModal === 'function') {
    const key = `spikkel-vakantie-${holiday.dataset.holidayKey}`;
    let seen = false;
    try {
        seen = sessionStorage.getItem(key) === '1';
    } catch {
        // The notice can still be read if browser storage is unavailable.
    }
    if (!seen) {
        holiday.showModal();
        holiday.addEventListener('close', () => {
            try {
                sessionStorage.setItem(key, '1');
            } catch {
                // The banner remains visible after closing the dialog.
            }
        });
    }
}
