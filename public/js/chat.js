document.addEventListener('DOMContentLoaded', function() {
    // Funcionalidad de búsqueda
    const searchInput = document.getElementById('search-chats');
    const chatItems = document.querySelectorAll('.chat-item');
    
    if (searchInput) {
        searchInput.addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            
            chatItems.forEach(item => {
                const text = item.textContent.toLowerCase();
                if (text.includes(searchTerm)) {
                    item.style.display = 'block';
                } else {
                    item.style.display = 'none';
                }
            });
            
            // Verificar si hay resultados visibles
            checkVisibleResults();
        });
    }
    
    function checkVisibleResults() {
        const chatList = document.getElementById('chat-list');
        if (!chatList) return;
        
        let visibleItems = 0;
        chatItems.forEach(item => {
            if (item.style.display !== 'none') {
                visibleItems++;
            }
        });
        
        // Si no hay resultados, mostrar mensaje
        if (visibleItems === 0 && chatItems.length > 0) {
            // Verificar si ya existe el mensaje
            if (!document.getElementById('no-results-message')) {
                const noResults = document.createElement('div');
                noResults.id = 'no-results-message';
                noResults.className = 'p-8 text-center';
                noResults.innerHTML = `
                    <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-100 mb-4">
                        <i class="fas fa-search text-gray-400 text-xl"></i>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900">No se encontraron resultados</h3>
                    <p class="mt-1 text-gray-500">Prueba con otros términos de búsqueda</p>
                `;
                chatList.appendChild(noResults);
            }
        } else {
            // Eliminar mensaje si existe
            const noResultsMessage = document.getElementById('no-results-message');
            if (noResultsMessage) {
                noResultsMessage.remove();
            }
        }
    }
    
    // Funcionalidad para botones de ordenar y filtrar
    const sortButton = document.getElementById('sort-button');
    if (sortButton) {
        sortButton.addEventListener('click', function() {
            // Alternar entre ordenar por más reciente o más antiguo
            const isDescending = this.querySelector('i').classList.contains('fa-sort-amount-down');
            
            if (isDescending) {
                // Cambiar a ascendente
                this.querySelector('i').classList.replace('fa-sort-amount-down', 'fa-sort-amount-up');
                this.querySelector('span').textContent = 'Antiguos';
                sortChats(false);
            } else {
                // Cambiar a descendente
                this.querySelector('i').classList.replace('fa-sort-amount-up', 'fa-sort-amount-down');
                this.querySelector('span').textContent = 'Recientes';
                sortChats(true);
            }
        });
    }
    
    function sortChats(descending) {
        const chatList = document.getElementById('chat-list');
        if (!chatList) return;
        
        const items = Array.from(chatItems);
        
        items.sort((a, b) => {
            const dateA = a.querySelector('.text-gray-500').textContent.trim();
            const dateB = b.querySelector('.text-gray-500').textContent.trim();
            
            // Este es un ordenamiento simple basado en el texto de tiempo relativo
            // Para un ordenamiento más preciso se necesitaría un valor de fecha
            if (descending) {
                return dateA.localeCompare(dateB) * -1;
            } else {
                return dateA.localeCompare(dateB);
            }
        });
        
        // Reordenar los elementos en el DOM
        items.forEach(item => {
            chatList.appendChild(item);
        });
    }
    
    // Animación de entrada para los elementos de chat
    chatItems.forEach((item, index) => {
        item.style.opacity = '0';
        item.style.transform = 'translateY(20px)';
        item.style.transition = 'opacity 0.3s ease, transform 0.3s ease';
        
        setTimeout(() => {
            item.style.opacity = '1';
            item.style.transform = 'translateY(0)';
        }, 100 + index * 50);
    });
}); 