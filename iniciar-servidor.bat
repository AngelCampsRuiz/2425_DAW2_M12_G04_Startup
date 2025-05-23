@echo off
echo Iniciando servidor de senalizacion para videollamadas...
echo.

:: Comprobar si Node.js está instalado
where node >nul 2>nul
if %ERRORLEVEL% NEQ 0 (
    echo ERROR: Node.js no esta instalado.
    echo Por favor, instala Node.js desde https://nodejs.org/
    echo.
    pause
    exit /b 1
)

:: Comprobar si las dependencias están instaladas
if not exist node_modules (
    echo Instalando dependencias...
    call npm install express socket.io cors
)

:: Iniciar servidor
echo Iniciando servidor en http://localhost:3000
echo Para detener el servidor presiona Ctrl+C
echo.
node server.js

pause
