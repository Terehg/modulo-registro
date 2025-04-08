# Nombre de tu Proyecto Laravel

Modulo de registros de datos de producción con gestión de Turnos.

## Requisitos

Asegúrate de tener instalado lo siguiente en el sistema:

- PHP (versión mínima requerida 8.1)
- Composer (para la gestión de dependencias de PHP)
- Node.js y npm (para la gestión de dependencias de frontend, se implementa Vite/npm en el proyecto)
- Base de datos (MySQL)

## Instalación

Sigue estos pasos para configurar el proyecto localmente:

1.  **Clonar el repositorio:**
   

2.  **Copiar el archivo de entorno:**
    ```bash
    cp .env.example .env
    ```

3.  **Configurar las variables de entorno:**
    Abre el archivo `.env` y configura las siguientes variables según tu entorno local:
    ```
    APP_NAME=NombreDeTuApp
    APP_ENV=local
    APP_KEY=
    APP_DEBUG=true
    APP_URL=http://localhost



4.  **Instalar las dependencias de PHP:**
    ```bash
    composer install
    ```

5.  **Instalar las dependencias de frontend (Vite/npm):**
    ```bash
    npm install
   
    ```

6.  **Generar la clave de la aplicación (si no lo hiciste antes):**
    ```bash
    php artisan key:generate
    ```

7.  **Ejecutar las migraciones de la base de datos:**
    ```bash
    php artisan migrate 
    ```

8.  **Compilar los assets de frontend si utilizas Vite/npm:**
    ```bash
    npm run dev
    ```

9.  **Configurar el directorio público (si es necesario para servidor web).**

10. **Iniciar el servidor de desarrollo de Laravel:**
    ```bash
    php artisan serve
  
