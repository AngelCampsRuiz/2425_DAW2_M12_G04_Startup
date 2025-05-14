# Servidor de Señalización para WebRTC

Este servidor actúa como intermediario para establecer conexiones WebRTC entre clientes, permitiendo videollamadas peer-to-peer.

## Características

- Registro de usuarios
- Gestión de solicitudes de llamada (iniciar, aceptar, rechazar, finalizar)
- Control de estados de llamada
- Notificaciones en tiempo real

## Requisitos

- Node.js (v14 o superior)
- npm (v6 o superior)

## Instalación

1. Clona este repositorio o descarga los archivos
2. Instala las dependencias:

```bash
npm install
```

## Uso

### Iniciar el servidor

Para iniciar el servidor en modo desarrollo con reinicio automático:

```bash
npm run dev
```

Para iniciar el servidor en modo producción:

```bash
npm start
```

Por defecto, el servidor se ejecuta en el puerto 3000. Para cambiar el puerto, configura la variable de entorno `PORT`:

```bash
PORT=5000 npm start
```

## Integración con el cliente

### Eventos del cliente al servidor

- `register`: Registrar un usuario con un nombre
- `call`: Iniciar una llamada a otro usuario
- `accept_call`: Aceptar una llamada entrante
- `reject`: Rechazar una llamada entrante
- `end`: Finalizar una llamada activa

### Eventos del servidor al cliente

- `register_response`: Respuesta al intento de registro
- `user_list`: Lista actualizada de usuarios
- `incoming_call`: Notificación de llamada entrante
- `call_response`: Respuesta al intento de llamada
- `call_accepted`: Notificación de llamada aceptada
- `call_rejected`: Notificación de llamada rechazada
- `call_ended`: Notificación de llamada finalizada

## Ejemplo de conexión desde el cliente

```javascript
// Conectar al servidor de señalización
const socket = io('http://localhost:3000');

// Registrar usuario
socket.emit('register', 'NombreUsuario');

// Escuchar respuesta de registro
socket.on('register_response', (response) => {
  if (response.success) {
    console.log('Registro exitoso');
  } else {
    console.error(response.message);
  }
});

// Obtener lista de usuarios
socket.on('user_list', (users) => {
  console.log('Usuarios conectados:', users);
});
```

## Licencia

MIT

## Configuración del servidor Socket.io para videollamadas

### Requisitos
- Node.js instalado (v14 o superior)
- NPM instalado

### Configuración
1. Configurar la URL del servidor Socket.io en el archivo `.env` de Laravel:
   ```
   SOCKET_SERVER_URL=http://localhost:3000
   ```

2. Iniciar el servidor de señalización Socket.io:
   ```
   npm start
   ```
   o
   ```
   node server.js
   ```

3. Para desarrollo con recarga automática:
   ```
   npm run dev
   ```

4. Asegurarse de que ambos servidores estén funcionando:
   - Servidor Laravel (PHP): Generalmente en el puerto 8000 o el que uses con Artisan
   - Servidor Socket.io (Node.js): Puerto 3000 por defecto

### Configuración de entorno

Añade la siguiente variable a tu archivo `.env` de Laravel:

```
# Configuración de Socket.io para videollamadas
SOCKET_SERVER_URL=http://localhost:3000
```

Para entornos de producción, usa la URL completa del servidor Socket.io:

```
SOCKET_SERVER_URL=https://tu-dominio.com:3000
```

Si estás utilizando HTTPS en producción, asegúrate de que el servidor Socket.io también esté configurado con SSL.

### Solución de problemas de conexión Socket.io

Si experimentas problemas de conexión con Socket.io:

1. Verifica que el servidor Socket.io esté ejecutándose (`npm start`)
2. Confirma que la URL configurada en `.env` sea accesible desde el navegador
3. Si usas HTTPS en producción, asegúrate de configurar Socket.io con SSL también
4. Para entornos de producción, considera usar un proxy inverso como Nginx para servir tanto Laravel como Socket.io

### Acceso desde diferentes dispositivos

Para pruebas en red local, usa la IP de tu máquina en lugar de localhost:

1. Averigua tu dirección IP local (por ejemplo, 192.168.1.10)
2. Configura en `.env`:
   ```
   SOCKET_SERVER_URL=http://192.168.1.10:3000
   ```
3. Asegúrate de que los puertos necesarios estén abiertos en el firewall
