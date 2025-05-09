// Function to toggle dark mode
function toggleDarkMode() {
    if (document.documentElement.classList.contains('dark')) {
        document.documentElement.classList.remove('dark');
        localStorage.setItem('darkMode', 'light');
        updateDarkModeIcon(false);
    } else {
        document.documentElement.classList.add('dark');
        localStorage.setItem('darkMode', 'dark');
        updateDarkModeIcon(true);
    }
}

// Function to update the icon
function updateDarkModeIcon(isDark) {
    const moonIcon = document.getElementById('moonIcon');
    const sunIcon = document.getElementById('sunIcon');
    
    if (moonIcon && sunIcon) {
        if (isDark) {
            moonIcon.classList.add('hidden');
            sunIcon.classList.remove('hidden');
        } else {
            moonIcon.classList.remove('hidden');
            sunIcon.classList.add('hidden');
        }
    }
}

// Check for saved dark mode preference immediately when script loads
const darkMode = localStorage.getItem('darkMode');
if (darkMode === 'dark' || (!darkMode && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
    document.documentElement.classList.add('dark');
    updateDarkModeIcon(true);
} else {
    document.documentElement.classList.remove('dark');
    updateDarkModeIcon(false);
}

// Listen for changes in system dark mode preference
window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', e => {
    if (!localStorage.getItem('darkMode')) {
        if (e.matches) {
            document.documentElement.classList.add('dark');
            updateDarkModeIcon(true);
        } else {
            document.documentElement.classList.remove('dark');
            updateDarkModeIcon(false);
        }
    }
}); 