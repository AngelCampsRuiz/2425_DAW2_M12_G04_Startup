// Tailwind Config para toda la aplicación
window.tailwind = window.tailwind || {};
window.tailwind.config = {
    theme: {
        extend: {
            colors: {
                primary: '#7705B6',
                'primary-dark': '#5E0490',
                secondary: '#4A90E2',
                'secondary-dark': '#3A7BC8'
            },
            animation: {
                'fadeIn': 'fadeIn 0.3s ease-in-out',
                'fadeOut': 'fadeOut 0.2s ease-in-out',
            },
            keyframes: {
                fadeIn: {
                    '0%': { opacity: '0', transform: 'translateY(-10px)' },
                    '100%': { opacity: '1', transform: 'translateY(0)' }
                },
                fadeOut: {
                    '0%': { opacity: '1', transform: 'translateY(0)' },
                    '100%': { opacity: '0', transform: 'translateY(-10px)' }
                }
            }
        }
    }
}; 