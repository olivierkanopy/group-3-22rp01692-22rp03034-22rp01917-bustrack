// Basic JavaScript functionality
document.addEventListener('DOMContentLoaded', function() {
    // Handle mobile menu toggle
    const mobileMenuButton = document.querySelector('[data-mobile-menu]');
    const mobileMenu = document.querySelector('[data-mobile-menu-panel]');

    if (mobileMenuButton && mobileMenu) {
        mobileMenuButton.addEventListener('click', function() {
            const isHidden = mobileMenu.classList.contains('hidden');
            if (isHidden) {
                mobileMenu.classList.remove('hidden');
            } else {
                mobileMenu.classList.add('hidden');
            }
        });
    }

    // Handle dropdowns
    const dropdownButtons = document.querySelectorAll('[data-dropdown-toggle]');
    dropdownButtons.forEach(button => {
        button.addEventListener('click', function() {
            const target = document.querySelector(`#${this.getAttribute('data-dropdown-toggle')}`);
            if (target) {
                const isHidden = target.classList.contains('hidden');
                if (isHidden) {
                    target.classList.remove('hidden');
                } else {
                    target.classList.add('hidden');
                }
            }
        });
    });
});
