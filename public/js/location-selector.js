document.addEventListener('DOMContentLoaded', function() {
    // Datos de provincias y ciudades de España
    const provinciasYCiudades = {
        'Álava': ['Vitoria-Gasteiz', 'Amurrio', 'Llodio', 'Salvatierra'],
        'Albacete': ['Albacete', 'Hellín', 'Villarrobledo', 'Almansa', 'La Roda'],
        'Alicante': ['Alicante', 'Elche', 'Torrevieja', 'Orihuela', 'Benidorm', 'Alcoy', 'San Vicente del Raspeig', 'Elda', 'Dénia'],
        'Almería': ['Almería', 'Roquetas de Mar', 'El Ejido', 'Níjar', 'Adra', 'Vícar', 'Huércal-Overa'],
        'Asturias': ['Oviedo', 'Gijón', 'Avilés', 'Siero', 'Langreo', 'Mieres', 'Castrillón'],
        'Ávila': ['Ávila', 'Arévalo', 'Arenas de San Pedro', 'Candeleda', 'Las Navas del Marqués'],
        'Badajoz': ['Badajoz', 'Mérida', 'Don Benito', 'Almendralejo', 'Villanueva de la Serena', 'Zafra', 'Montijo'],
        'Barcelona': ['Barcelona', 'Hospitalet de Llobregat', 'Badalona', 'Terrassa', 'Sabadell', 'Mataró', 'Santa Coloma de Gramenet', 'Cornellà de Llobregat', 'Sant Boi de Llobregat', 'Manresa'],
        'Burgos': ['Burgos', 'Aranda de Duero', 'Miranda de Ebro', 'Briviesca', 'Medina de Pomar'],
        'Cáceres': ['Cáceres', 'Plasencia', 'Navalmoral de la Mata', 'Coria', 'Trujillo', 'Miajadas'],
        'Cádiz': ['Cádiz', 'Jerez de la Frontera', 'Algeciras', 'San Fernando', 'Chiclana de la Frontera', 'El Puerto de Santa María', 'Sanlúcar de Barrameda', 'La Línea de la Concepción', 'Rota'],
        'Cantabria': ['Santander', 'Torrelavega', 'Castro-Urdiales', 'Camargo', 'Piélagos', 'El Astillero', 'Santa Cruz de Bezana'],
        'Castellón': ['Castellón de la Plana', 'Vila-real', 'Burriana', 'La Vall d\'Uixó', 'Benicarló', 'Vinaròs', 'Almassora'],
        'Ciudad Real': ['Ciudad Real', 'Puertollano', 'Tomelloso', 'Alcázar de San Juan', 'Valdepeñas', 'Manzanares', 'Daimiel'],
        'Córdoba': ['Córdoba', 'Lucena', 'Puente Genil', 'Montilla', 'Priego de Córdoba', 'Cabra', 'Palma del Río', 'Baena'],
        'Cuenca': ['Cuenca', 'Tarancón', 'Motilla del Palancar', 'San Clemente', 'Las Pedroñeras'],
        'Gerona': ['Gerona', 'Figueras', 'Blanes', 'Lloret de Mar', 'Olot', 'Salt', 'Palafrugell', 'Sant Feliu de Guíxols'],
        'Granada': ['Granada', 'Motril', 'Almuñécar', 'Armilla', 'Maracena', 'Loja', 'Baza', 'Guadix'],
        'Guadalajara': ['Guadalajara', 'Azuqueca de Henares', 'Alovera', 'Cabanillas del Campo', 'El Casar'],
        'Guipúzcoa': ['San Sebastián', 'Irún', 'Errenteria', 'Eibar', 'Zarautz', 'Arrasate', 'Hernani', 'Tolosa'],
        'Huelva': ['Huelva', 'Lepe', 'Almonte', 'Isla Cristina', 'Ayamonte', 'Moguer', 'La Palma del Condado'],
        'Huesca': ['Huesca', 'Barbastro', 'Monzón', 'Fraga', 'Jaca', 'Sabiñánigo'],
        'Islas Baleares': ['Palma de Mallorca', 'Calvià', 'Ibiza', 'Manacor', 'Santa Eulalia del Río', 'Llucmajor', 'Mahón', 'Ciutadella de Menorca'],
        'Jaén': ['Jaén', 'Linares', 'Andújar', 'Úbeda', 'Martos', 'Alcalá la Real', 'Bailén', 'La Carolina'],
        'La Coruña': ['La Coruña', 'Santiago de Compostela', 'Ferrol', 'Narón', 'Oleiros', 'Carballo', 'Arteixo', 'Ribeira'],
        'La Rioja': ['Logroño', 'Calahorra', 'Arnedo', 'Haro', 'Lardero', 'Alfaro', 'Nájera'],
        'Las Palmas': ['Las Palmas de Gran Canaria', 'San Bartolomé de Tirajana', 'Telde', 'Arrecife', 'Santa Lucía de Tirajana', 'Arucas', 'Puerto del Rosario'],
        'León': ['León', 'Ponferrada', 'San Andrés del Rabanedo', 'Villaquilambre', 'Astorga', 'La Bañeza', 'Bembibre'],
        'Lérida': ['Lérida', 'Balaguer', 'Tàrrega', 'Mollerussa', 'Cervera', 'La Seu d\'Urgell', 'Solsona'],
        'Lugo': ['Lugo', 'Monforte de Lemos', 'Viveiro', 'Vilalba', 'Sarria', 'Ribadeo', 'Foz'],
        'Madrid': ['Madrid', 'Móstoles', 'Alcalá de Henares', 'Fuenlabrada', 'Leganés', 'Getafe', 'Alcorcón', 'Torrejón de Ardoz', 'Parla', 'Alcobendas'],
        'Málaga': ['Málaga', 'Marbella', 'Mijas', 'Vélez-Málaga', 'Fuengirola', 'Torremolinos', 'Benalmádena', 'Estepona', 'Rincón de la Victoria', 'Antequera'],
        'Murcia': ['Murcia', 'Cartagena', 'Lorca', 'Molina de Segura', 'Alcantarilla', 'Yecla', 'Águilas', 'Cieza', 'Torre-Pacheco', 'Totana'],
        'Navarra': ['Pamplona', 'Tudela', 'Barañáin', 'Valle de Egüés', 'Burlada', 'Zizur Mayor', 'Estella-Lizarra', 'Tafalla'],
        'Orense': ['Orense', 'Verín', 'O Barco de Valdeorras', 'O Carballiño', 'Xinzo de Limia', 'Allariz'],
        'Palencia': ['Palencia', 'Aguilar de Campoo', 'Guardo', 'Venta de Baños', 'Villamuriel de Cerrato', 'Dueñas'],
        'Pontevedra': ['Vigo', 'Pontevedra', 'Vilagarcía de Arousa', 'Redondela', 'Cangas', 'Marín', 'Ponteareas', 'A Estrada'],
        'Salamanca': ['Salamanca', 'Santa Marta de Tormes', 'Béjar', 'Ciudad Rodrigo', 'Villamayor', 'Carbajosa de la Sagrada', 'Peñaranda de Bracamonte'],
        'Santa Cruz de Tenerife': ['Santa Cruz de Tenerife', 'San Cristóbal de La Laguna', 'Arona', 'Adeje', 'Granadilla de Abona', 'Puerto de la Cruz', 'Los Realejos', 'La Orotava'],
        'Segovia': ['Segovia', 'Cuéllar', 'El Espinar', 'San Ildefonso', 'Cantalejo', 'Carbonero el Mayor'],
        'Sevilla': ['Sevilla', 'Dos Hermanas', 'Alcalá de Guadaíra', 'Utrera', 'Écija', 'Mairena del Aljarafe', 'Los Palacios y Villafranca', 'La Rinconada', 'Carmona', 'Coria del Río'],
        'Soria': ['Soria', 'Almazán', 'El Burgo de Osma', 'Covaleda', 'Ólvega', 'San Leonardo de Yagüe'],
        'Tarragona': ['Tarragona', 'Reus', 'Tortosa', 'Cambrils', 'Salou', 'Valls', 'El Vendrell', 'Vila-seca'],
        'Teruel': ['Teruel', 'Alcañiz', 'Andorra', 'Calamocha', 'Utrillas', 'Monreal del Campo'],
        'Toledo': ['Toledo', 'Talavera de la Reina', 'Illescas', 'Seseña', 'Torrijos', 'Ocaña', 'Madridejos', 'Consuegra'],
        'Valencia': ['Valencia', 'Gandía', 'Torrent', 'Paterna', 'Sagunto', 'Alzira', 'Mislata', 'Burjassot', 'Ontinyent', 'Aldaia'],
        'Valladolid': ['Valladolid', 'Medina del Campo', 'Laguna de Duero', 'Arroyo de la Encomienda', 'Tordesillas', 'Tudela de Duero', 'Íscar'],
        'Vizcaya': ['Bilbao', 'Barakaldo', 'Getxo', 'Portugalete', 'Santurtzi', 'Basauri', 'Leioa', 'Galdakao', 'Durango', 'Sestao'],
        'Zamora': ['Zamora', 'Benavente', 'Toro', 'Morales del Vino', 'Villaralbo', 'Puebla de Sanabria'],
        'Zaragoza': ['Zaragoza', 'Calatayud', 'Utebo', 'Ejea de los Caballeros', 'Cuarte de Huerva', 'Tarazona', 'La Almunia de Doña Godina']
    };

    // Obtener referencias a los elementos del DOM
    const provinciaSelect = document.getElementById('provincia');
    const ciudadSelect = document.getElementById('ciudad');
    
    // Si no existen los elementos, salir
    if (!provinciaSelect || !ciudadSelect) return;
    
    // Llenar el select de provincias
    Object.keys(provinciasYCiudades).sort().forEach(provincia => {
        const option = document.createElement('option');
        option.value = provincia;
        option.textContent = provincia;
        provinciaSelect.appendChild(option);
    });
    
    // Función para actualizar las ciudades según la provincia seleccionada
    function actualizarCiudades() {
        // Limpiar el select de ciudades
        ciudadSelect.innerHTML = '<option value="">Selecciona una ciudad</option>';
        
        const provinciaSeleccionada = provinciaSelect.value;
        if (provinciaSeleccionada && provinciasYCiudades[provinciaSeleccionada]) {
            // Llenar el select de ciudades con las ciudades de la provincia seleccionada
            provinciasYCiudades[provinciaSeleccionada].sort().forEach(ciudad => {
                const option = document.createElement('option');
                option.value = ciudad;
                option.textContent = ciudad;
                ciudadSelect.appendChild(option);
            });
            
            // Habilitar el select de ciudades
            ciudadSelect.disabled = false;
        } else {
            // Si no hay provincia seleccionada, deshabilitar el select de ciudades
            ciudadSelect.disabled = true;
        }
    }
    
    // Asignar el evento change al select de provincias
    provinciaSelect.addEventListener('change', actualizarCiudades);
    
    // Inicializar el select de ciudades
    actualizarCiudades();
});
