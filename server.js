const express = require('express');
const http = require('http');
const socketIO = require('socket.io');
const cors = require('cors');
const path = require('path');
require('dotenv').config();

const app = express();
const server = http.createServer(app);

// Importar rutas de Stripe
const stripeRoutes = require('./routes/stripe');

// Configuración mejorada de socket.io con CORS más permisivo
const io = socketIO(server, {
  cors: {
    origin: "*", // Permitir cualquier origen para desarrollo
    methods: ["GET", "POST"],
    allowedHeaders: ["my-custom-header"],
    credentials: true
  },
  transports: ['websocket', 'polling'],
  pingTimeout: 60000, // Aumentar timeout para conexiones lentas
  pingInterval: 25000 // Intervalo de ping para mantener la conexión activa
});

// Middleware
app.use(cors({
  origin: '*', // Permitir cualquier origen para desarrollo
  methods: ['GET', 'POST'],
  allowedHeaders: ['Content-Type', 'Authorization']
}));
app.use(express.json());
app.use(express.static(path.join(__dirname, 'client')));

// Rutas de Stripe
app.use('/api/stripe', stripeRoutes);

// Ruta básica
app.get('/', (req, res) => {
  res.sendFile(path.join(__dirname, 'client', 'index.html'));
});

// Agregar ruta para comprobar que el servidor está funcionando
app.get('/api/status', (req, res) => {
  res.json({ status: 'Servidor activo', timestamp: new Date() });
});

// Almacenamiento de usuarios conectados
const users = {};

// Conexión de socket
io.on('connection', (socket) => {
  console.log('Usuario conectado:', socket.id);

  // Evento de registro de usuario
  socket.on('register', (username) => {
    console.log(`Usuario ${username} registrado`);

    // Verificar si el nombre de usuario ya está en uso
    const existingUser = Object.values(users).find(user => user.username === username);

    if (existingUser) {
      // Notificar al cliente que el nombre ya está en uso
      socket.emit('register_response', {
        success: false,
        message: 'Nombre de usuario ya en uso'
      });
      return;
    }

    // Registrar el usuario
    users[socket.id] = {
      id: socket.id,
      username: username,
      inCall: false
    };

    // Notificar éxito al cliente
    socket.emit('register_response', {
      success: true,
      message: 'Registro exitoso'
    });

    // Notificar a todos los usuarios sobre la lista actualizada
    io.emit('user_list', Object.values(users).map(user => ({
      id: user.id,
      username: user.username,
      inCall: user.inCall
    })));
  });

  // Evento de inicio de llamada
  socket.on('call', (data) => {
    const caller = users[socket.id];
    const targetUser = Object.values(users).find(user => user.username === data.target);

    if (!caller) {
      socket.emit('call_response', {
        success: false,
        message: 'No estás registrado'
      });
      return;
    }

    if (!targetUser) {
      socket.emit('call_response', {
        success: false,
        message: 'Usuario destino no encontrado'
      });
      return;
    }

    if (targetUser.inCall) {
      socket.emit('call_response', {
        success: false,
        message: 'Usuario destino ocupado en otra llamada'
      });
      return;
    }

    console.log(`Llamada de ${caller.username} a ${targetUser.username}`);

    // Actualizar estado de llamada
    caller.inCall = true;
    users[socket.id] = caller;

    // Notificar al usuario destino sobre la llamada entrante
    io.to(targetUser.id).emit('incoming_call', {
      from: caller.username,
      signalData: data.signalData
    });

    socket.emit('call_response', {
      success: true,
      message: 'Llamada iniciada'
    });

    // Actualizar lista de usuarios
    io.emit('user_list', Object.values(users).map(user => ({
      id: user.id,
      username: user.username,
      inCall: user.inCall
    })));
  });

  // Evento para aceptar llamada
  socket.on('accept_call', (data) => {
    const receiver = users[socket.id];
    const caller = Object.values(users).find(user => user.username === data.from);

    if (!receiver || !caller) {
      return;
    }

    console.log(`${receiver.username} aceptó la llamada de ${caller.username}`);

    // Actualizar estado
    receiver.inCall = true;
    users[socket.id] = receiver;

    // Notificar al llamante que la llamada fue aceptada
    io.to(caller.id).emit('call_accepted', {
      signalData: data.signalData
    });

    // Actualizar lista de usuarios
    io.emit('user_list', Object.values(users).map(user => ({
      id: user.id,
      username: user.username,
      inCall: user.inCall
    })));
  });

  // Evento para rechazar llamada
  socket.on('reject', (data) => {
    const receiver = users[socket.id];
    const caller = Object.values(users).find(user => user.username === data.from);

    if (!receiver || !caller) {
      return;
    }

    console.log(`${receiver.username} rechazó la llamada de ${caller.username}`);

    // Actualizar estado
    caller.inCall = false;

    // Notificar rechazo
    io.to(caller.id).emit('call_rejected', {
      username: receiver.username
    });

    // Actualizar lista de usuarios
    io.emit('user_list', Object.values(users).map(user => ({
      id: user.id,
      username: user.username,
      inCall: user.inCall
    })));
  });

  // Evento para finalizar llamada
  socket.on('end', (data) => {
    const user = users[socket.id];

    if (!user) {
      return;
    }

    console.log(`${user.username} finalizó la llamada`);

    // Buscar al otro participante (si existe)
    const otherUser = Object.values(users).find(u =>
      u.username === data.target && u.inCall);

    // Actualizar estados
    user.inCall = false;
    users[socket.id] = user;

    // Notificar al otro usuario si existe
    if (otherUser) {
      otherUser.inCall = false;
      io.to(otherUser.id).emit('call_ended', {
        username: user.username
      });
    }

    // Actualizar lista de usuarios
    io.emit('user_list', Object.values(users).map(user => ({
      id: user.id,
      username: user.username,
      inCall: user.inCall
    })));
  });

  // Gestionar desconexión
  socket.on('disconnect', () => {
    const user = users[socket.id];

    if (!user) {
      return;
    }

    console.log(`Usuario desconectado: ${user.username}`);

    // Si el usuario estaba en una llamada, notificar al otro participante
    if (user.inCall) {
      const otherUser = Object.values(users).find(u =>
        u.inCall && u.id !== socket.id);

      if (otherUser) {
        otherUser.inCall = false;
        io.to(otherUser.id).emit('call_ended', {
          username: user.username,
          reason: 'disconnected'
        });
      }
    }

    // Eliminar al usuario
    delete users[socket.id];

    // Actualizar lista de usuarios
    io.emit('user_list', Object.values(users).map(user => ({
      id: user.id,
      username: user.username,
      inCall: user.inCall
    })));
  });
});

// Puerto del servidor
const PORT = process.env.PORT || 3000;
server.listen(PORT, () => {
  console.log(`Servidor de señalización ejecutándose en el puerto ${PORT}`);
});