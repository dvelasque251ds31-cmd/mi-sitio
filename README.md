# Mi sitio
 
Sitio web con PHP, PostgreSQL y Laragon. Formulario de contacto con
validación, protección CSRF y consultas preparadas.
 
## Requisitos
- Laragon (Apache + PHP 8.x) con la extensión pdo_pgsql activa
- PostgreSQL
- Git
 
## Instalación
1. Clonar el repositorio dentro de C:\laragon\www\
2. Crear el usuario y la base de datos, y ejecutar database/schema.sql
3. Copiar .env.example a .env y completar las credenciales
4. Reiniciar Laragon y abrir http://mi-sitio.test
 
## Estructura
- public/: páginas accesibles desde el navegador
- includes/: header, footer y funciones auxiliares
- config/: carga del .env y conexión PDO
- database/: script SQL de la tabla
