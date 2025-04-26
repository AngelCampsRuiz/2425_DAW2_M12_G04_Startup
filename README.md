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
