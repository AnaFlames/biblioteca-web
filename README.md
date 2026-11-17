# biblioteca-web

Web de ejemplo para las prácticas de Docker de **Despliegue de Aplicaciones Web** (2º DAW).

| Archivo | Qué es |
|---|---|
| `index.html`, `contacto.html` | Páginas estáticas |
| `css/`, `img/` | Estilos y logotipo |
| `libros.php` | Lista de libros leída de MySQL (PDO) |
| `bd/biblioteca.sql` | Tabla y datos de ejemplo (no se publica en la web) |

`libros.php` lee la conexión de variables de entorno: `DB_HOST`, `DB_NAME`, `DB_USER` y `DB_PASSWORD`.
Necesita la extensión de PHP `pdo_mysql`.
