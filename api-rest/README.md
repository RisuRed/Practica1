# Proyecto de API REST en PHP

Este es un proyecto de ejemplo que implementa una API REST básica en PHP utilizando el patrón MVC (Model-View-Controller) y autenticación con tokens JWT.

## Estructura de archivos

- **api-rest/**
  - **Controllers/**
    - `login.php`: Contiene el controlador UserController y su método login() para la autenticación.
  - **Helpers/**
    - `app.php`: Carga las variables de entorno desde el archivo `.env`.
    - `token.php`: Define la clase TokenHandler para generar y verificar tokens JWT.
  - **lib/**
    - `Route.php`: Define la clase Route para gestionar rutas y controladores.
  - **Models/**
    (Definir modelos si es necesario)
  - **Public/**
    - `index.php`: Punto de entrada que define rutas y maneja solicitudes.
  - `.ENV`: Archivo de configuración con variables de entorno.
  - `composer.json`: Archivo de configuración de Composer para cargar dependencias.

## Configuración

1. Clona este repositorio en tu servidor o ambiente local.
2. Crea un archivo `.env` en el directorio raíz basado en el contenido proporcionado.
3. Ejecuta `composer install` para instalar las dependencias (Firebase JWT y Dotenv).

## Uso

1. Define tus rutas en `Public/index.php` usando la clase `Route`.
2. Implementa tus controladores en el directorio `Controllers/`.
3. Asegúrate de mantener segura la clave secreta `SECRET_PRIVATE_KEY` en el archivo `.env`.
4. Personaliza la autenticación y la lógica de negocios según tus necesidades.

## Consideraciones

- Actualiza las credenciales de autenticación en `token.php` para un manejo seguro de las contraseñas.
- Mantén tus dependencias actualizadas y sigue las mejores prácticas de seguridad.
- Configura un servidor web adecuado (como Apache o Nginx) para desplegar tu API en producción.

## Contribución

Si deseas contribuir a este proyecto, ¡eres bienvenido! Puedes crear un pull request con tus mejoras.
