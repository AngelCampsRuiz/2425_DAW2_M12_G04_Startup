const express = require('express');
const path = require('path');
const app = express();

// Servir archivos estáticos desde la carpeta 'client'
app.use(express.static(path.join(__dirname, 'client')));

// Ruta para la página principal
app.get('/', (req, res) => {
    res.sendFile(path.join(__dirname, 'client', 'index.html'));
});

// Ruta para la página de prueba
app.get('/test', (req, res) => {
    res.sendFile(path.join(__dirname, 'client', 'test.html'));
});

// Puerto para el servidor de archivos estáticos (diferente del servidor de señalización)
const PORT = 8080;
app.listen(PORT, () => {
    console.log(`Servidor de archivos estáticos ejecutándose en http://localhost:${PORT}`);
}); 