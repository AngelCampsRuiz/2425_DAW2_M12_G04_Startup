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
    
    if (isDark) {
        moonIcon.classList.add('hidden');
        sunIcon.classList.remove('hidden');
    } else {
        moonIcon.classList.remove('hidden');
        sunIcon.classList.add('hidden');
    }
}

// Check for saved dark mode preference
document.addEventListener('DOMContentLoaded', () => {
    const darkMode = localStorage.getItem('darkMode');
    if (darkMode === 'dark') {
        document.documentElement.classList.add('dark');
        updateDarkModeIcon(true);
    } else {
        updateDarkModeIcon(false);
    }
}); 