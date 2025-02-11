document.addEventListener('DOMContentLoaded', function () {
    const themeToggleBtn = document.getElementById('theme-toggle');
    const themeIcon = document.getElementById('theme-icon');
    const htmlElement = document.documentElement;

    // Check for saved theme in localStorage
    const savedTheme = localStorage.getItem('theme');
    if (savedTheme === 'dark') {
        htmlElement.classList.add('dark');
        themeIcon.textContent = '☀️'; // Sun icon for light mode
    } else {
        htmlElement.classList.remove('dark');
        themeIcon.textContent = '🌙'; // Moon icon for dark mode
    }

    // Toggle theme on button click
    themeToggleBtn.addEventListener('click', function () {
        htmlElement.classList.toggle('dark');
        const isDarkMode = htmlElement.classList.contains('dark');
        localStorage.setItem('theme', isDarkMode ? 'dark' : 'light');
        themeIcon.textContent = isDarkMode ? '☀️' : '🌙';
    });
});