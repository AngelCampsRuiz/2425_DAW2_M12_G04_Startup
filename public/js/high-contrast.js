/**
 * High Contrast Mode Functionality
 * 
 * This script enables high contrast mode for accessibility.
 * It toggles CSS classes for high contrast and saves the user preference in localStorage.
 */

document.addEventListener('DOMContentLoaded', function() {
    // Check if high contrast mode is already enabled
    const highContrastEnabled = localStorage.getItem('highContrastMode') === 'true';
    
    // Apply high contrast if it was previously enabled
    if (highContrastEnabled) {
        document.body.classList.add('high-contrast-mode');
    }
    
    // Find high contrast toggle button if it exists in the page
    const highContrastToggle = document.getElementById('high-contrast-toggle');
    
    if (highContrastToggle) {
        // Update button state
        updateButtonState(highContrastToggle, highContrastEnabled);
        
        // Add click event listener
        highContrastToggle.addEventListener('click', function() {
            toggleHighContrast();
        });
    }
});

/**
 * Toggles high contrast mode on/off
 */
function toggleHighContrast() {
    const body = document.body;
    const isHighContrast = body.classList.contains('high-contrast-mode');
    
    // Toggle the class
    if (isHighContrast) {
        body.classList.remove('high-contrast-mode');
        localStorage.setItem('highContrastMode', 'false');
    } else {
        body.classList.add('high-contrast-mode');
        localStorage.setItem('highContrastMode', 'true');
    }
    
    // Update any toggle buttons in the page
    const highContrastToggle = document.getElementById('high-contrast-toggle');
    if (highContrastToggle) {
        updateButtonState(highContrastToggle, !isHighContrast);
    }
}

/**
 * Updates the toggle button state
 * @param {HTMLElement} button - The toggle button element
 * @param {boolean} enabled - Whether high contrast is enabled
 */
function updateButtonState(button, enabled) {
    if (enabled) {
        button.setAttribute('aria-pressed', 'true');
        button.classList.add('active');
    } else {
        button.setAttribute('aria-pressed', 'false');
        button.classList.remove('active');
    }
} 