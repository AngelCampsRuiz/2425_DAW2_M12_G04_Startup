<p align="center">
  <img src="https://www.ejemplo.com/nextgen-logo.png" width="400" alt="NextGen Logo">
</p>

<h1 align="center">NextGen - Plataforma de Conexión Educativa</h1>

<p align="center">
  <img src="https://img.shields.io/badge/version-1.0.0-blue.svg" alt="Version">
  <img src="https://img.shields.io/badge/license-MIT-green.svg" alt="License">
  <img src="https://img.shields.io/badge/PHP-8.2-777BB4.svg" alt="PHP">
  <img src="https://img.shields.io/badge/Laravel-12-FF2D20.svg" alt="Laravel">
</p>

<p align="center">
  Conectando estudiantes y empresas para crear oportunidades de futuro
</p>

## 🚀 Sobre NextGen

NextGen es una plataforma innovadora diseñada para conectar estudiantes con empresas, facilitando la búsqueda de prácticas y oportunidades laborales. Nuestro objetivo es crear un puente entre el mundo académico y profesional, permitiendo a las empresas encontrar talento joven y a los estudiantes iniciar su carrera profesional.

### ✨ Características Principales

- **Perfiles Personalizados**: Tanto estudiantes como empresas pueden crear perfiles detallados
- **Publicación de Ofertas**: Las empresas pueden publicar oportunidades de prácticas y trabajo
- **Sistema de Solicitudes**: Los estudiantes pueden aplicar a las ofertas directamente
- **Chat Integrado**: Comunicación directa entre estudiantes y empresas
- **Sistema de Valoraciones**: Evaluación de experiencias para mejorar la transparencia
- **Panel de Administración**: Gestión completa del sistema por los administradores
- **Categorización de Ofertas**: Sistema intuitivo de categorías y subcategorías

## 💻 Tecnologías Utilizadas

- **Backend**: Laravel 12, PHP 8.2
- **Frontend**: Blade, JavaScript
- **Base de datos**: MySQL
- **Autenticación**: Laravel Sanctum
- **Comunicación en tiempo real**: Pusher

## 📋 Requisitos del Sistema

- PHP >= 8.2
- Composer
- Node.js y NPM
- MySQL o compatible
- Servidor web (Apache/Nginx)

## 🛠️ Instalación

```bash
# Clonar el repositorio
git clone https://github.com/tu-usuario/nextgen.git
cd nextgen

# Instalar dependencias de PHP
composer install

# Instalar dependencias de JavaScript
npm install

# Configurar el entorno
cp .env.example .env
php artisan key:generate

# Configurar la base de datos en el archivo .env
# Luego ejecutar migraciones y seeders
php artisan migrate --seed

# Compilar assets
npm run dev

# Iniciar el servidor
php artisan serve
```

## 👥 Roles de Usuario

- **Estudiantes**: Buscan y aplican a ofertas, gestionan su perfil educativo
- **Empresas**: Publican ofertas, gestionan solicitudes, evalúan estudiantes
- **Administradores**: Gestionan usuarios, categorías y contenido de la plataforma

## 📊 Estructura del Proyecto

La aplicación sigue una estructura MVC con:

- Modelos para estudiantes, empresas, publicaciones, solicitudes, chats, etc.
- Controladores específicos para cada área funcional
- Vistas separadas por roles de usuario
- Rutas protegidas según el tipo de usuario

## 👨‍💻 Equipo de Desarrollo

- **Juanjo** - *Desarrollador*
- **Àngel** - *Desarrollador*
- **Deiby** - *Desarrollador*
- **Aina** - *Desarrolladora*
- **Mario** - *Desarrollador*

## 📄 Licencia

Este proyecto está licenciado bajo la Licencia MIT - vea el archivo [LICENSE](LICENSE) para más detalles.

## 🙏 Agradecimientos

- A nuestros profesores y mentores por su guía
- A todos los que han probado la aplicación y proporcionado feedback
- A la comunidad de Laravel por sus recursos y documentación
