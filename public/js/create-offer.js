// Asegurarnos de que el script solo se ejecute una vez
const initializeForm = () => {
    // Obtener los elementos una sola vez
    const categoriaSelect = document.getElementById('categoria_id');
    const subcategoriaSelect = document.getElementById('subcategoria_id');

    // Función para limpiar y establecer una opción por defecto en el select
    const resetSelect = (select, defaultText) => {
        select.innerHTML = '';
        const defaultOption = document.createElement('option');
        defaultOption.value = '';
        defaultOption.textContent = defaultText;
        select.appendChild(defaultOption);
    };

    // Función para cargar subcategorías
    const loadSubcategorias = async (categoriaId) => {
        try {
            // Resetear el select de subcategorías
            resetSelect(subcategoriaSelect, 'Cargando subcategorías...');

            if (!categoriaId) {
                resetSelect(subcategoriaSelect, 'Primero selecciona una categoría');
                return;
            }

            // Realizar la petición
            const response = await fetch(`/empresa/get-subcategorias/${categoriaId}`);
            
            if (!response.ok) {
                throw new Error(`Error HTTP: ${response.status}`);
            }

            const subcategorias = await response.json();

            // Resetear el select antes de añadir nuevas opciones
            resetSelect(subcategoriaSelect, 'Selecciona una subcategoría');

            // Usar un Set para mantener track de IDs únicos
            const addedIds = new Set();

            // Añadir las subcategorías únicas
            subcategorias.forEach(subcategoria => {
                if (!addedIds.has(subcategoria.id)) {
                    addedIds.add(subcategoria.id);
                    const option = document.createElement('option');
                    option.value = subcategoria.id;
                    option.textContent = subcategoria.nombre_subcategoria;
                    subcategoriaSelect.appendChild(option);
                }
            });

            if (subcategorias.length === 0) {
                resetSelect(subcategoriaSelect, 'No hay subcategorías disponibles');
            }

        } catch (error) {
            console.error('Error:', error);
            resetSelect(subcategoriaSelect, 'Error al cargar subcategorías');
        }
    };

    // Remover event listeners existentes clonando el elemento
    const newCategoriaSelect = categoriaSelect.cloneNode(true);
    categoriaSelect.parentNode.replaceChild(newCategoriaSelect, categoriaSelect);

    // Añadir el nuevo event listener
    newCategoriaSelect.addEventListener('change', (e) => {
        loadSubcategorias(e.target.value);
    });

    // Si hay una categoría seleccionada al cargar la página
    if (newCategoriaSelect.value) {
        loadSubcategorias(newCategoriaSelect.value);
    }
};

// Asegurarnos de que el script solo se ejecute una vez cuando el DOM esté listo
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initializeForm);
} else {
    initializeForm();
}
