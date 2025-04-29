document.addEventListener('DOMContentLoaded', function() {
    // Añadir animaciones suaves a los elementos
    const items = document.querySelectorAll('.divide-y > div');
    items.forEach((item, index) => {
        item.style.opacity = '0';
        item.style.transform = 'translateY(20px)';
        setTimeout(() => {
            item.style.transition = 'all 0.3s ease-out';
            item.style.opacity = '1';
            item.style.transform = 'translateY(0)';
        }, index * 100);
    });
}); 