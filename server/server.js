const express = require('express');
const http = require('http');
const path = require('path');
const { Server } = require('socket.io');

const app = express();
const server = http.createServer(app);
const io = new Server(server, {
    cors: {
        origin: '*',
        methods: ['GET', 'POST']
    }
});

// Servir archivos estáticos desde la carpeta client
app.use(express.static(path.join(__dirname, '../client')));

// Almacenar usuarios conectados
const users = {};

io.on('connection', (socket) => {
    console.log('Usuario conectado:', socket.id);

    // Registrar usuario
    socket.on('register', (username) => {
        users[socket.id] = {
            id: socket.id,
            name: username
        };
        
        // Emitir lista actualizada de usuarios a todos
        io.emit('users', Object.values(users));
        console.log(`Usuario ${username} registrado con ID ${socket.id}`);
    });

    // Manejar llamada
    socket.on('call-user', (data) => {
        const { to, offer } = data;
        
        // Emitir evento de llamada al destinatario
        io.to(to).emit('call-made', {
            offer,
            from: socket.id
        });
        
        console.log(`Llamada de ${socket.id} a ${to}`);
    });

    // Manejar respuesta a llamada
    socket.on('make-answer', (data) => {
        const { to, answer } = data;
        
        // Enviar respuesta al llamante
        io.to(to).emit('answer-made', {
            answer,
            from: socket.id
        });
        
        console.log(`Respuesta de ${socket.id} a ${to}`);
    });

    // Manejar candidatos ICE
    socket.on('ice-candidate', (data) => {
        const { to, candidate } = data;
        
        // Reenviar candidato ICE al otro peer
        io.to(to).emit('ice-candidate', {
            candidate,
            from: socket.id
        });
    });

    // Rechazar llamada
    socket.on('reject-call', (data) => {
        const { to } = data;
        
        // Notificar al llamante que la llamada fue rechazada
        io.to(to).emit('call-rejected');
        
        console.log(`Llamada rechazada de ${socket.id} a ${to}`);
    });

    // Usuario ocupado
    socket.on('busy', (data) => {
        const { to } = data;
        
        // Notificar al llamante que el usuario está ocupado
        io.to(to).emit('user-busy');
        
        console.log(`Usuario ${socket.id} ocupado, no puede responder a ${to}`);
    });

    // Finalizar llamada
    socket.on('end-call', (data) => {
        const { to } = data;
        
        // Notificar al otro usuario que la llamada ha finalizado
        io.to(to).emit('call-ended');
        
        console.log(`Llamada finalizada entre ${socket.id} y ${to}`);
    });

    // Desconexión
    socket.on('disconnect', () => {
        console.log('Usuario desconectado:', socket.id);
        
        // Eliminar usuario de la lista
        if (users[socket.id]) {
            delete users[socket.id];
            
            // Emitir lista actualizada de usuarios
            io.emit('users', Object.values(users));
            
            // Notificar a todos los usuarios sobre la desconexión
            io.emit('user-disconnected', socket.id);
        }
    });
});

// Iniciar servidor
const PORT = process.env.PORT || 3000;
server.listen(PORT, () => {
    console.log(`Servidor iniciado en puerto ${PORT}`);
}); 