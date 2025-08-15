import { updateChartsTheme } from './charts.js';

// Theme Toggler
const themeSwitch = document.getElementById('theme-switch');
const htmlEl = document.documentElement;
const sunIcon = document.getElementById('sun-icon');
const moonIcon = document.getElementById('moon-icon');

const setTheme = (theme) => {
    htmlEl.setAttribute('data-bs-theme', theme);
    if (theme === 'dark') {
        sunIcon.classList.remove('d-none');
        moonIcon.classList.add('d-none');
    } else {
        moonIcon.classList.remove('d-none');
        sunIcon.classList.add('d-none');
    }
    localStorage.setItem('theme', theme);
    updateChartsTheme(theme); // Update charts when theme changes
};

themeSwitch.addEventListener('click', () => {
    const currentTheme = htmlEl.getAttribute('data-bs-theme');
    const newTheme = currentTheme === 'light' ? 'dark' : 'light';
    setTheme(newTheme);
});

// Initial Load
const savedTheme = localStorage.getItem('theme') || 'light';
setTheme(savedTheme);
