<?php
// Lista de libros desde MySQL.
// La conexión se configura con variables de entorno: así el mismo código sirve
// en cualquier servidor y la contraseña no está en el código.
$host = getenv('DB_HOST') ?: 'localhost';
$db   = getenv('DB_NAME') ?: 'biblioteca';
$user = getenv('DB_USER') ?: 'biblioteca';
$pass = getenv('DB_PASSWORD') ?: '';

$libros = null;
try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass,
                   [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    $libros = $pdo->query('SELECT titulo, autor, anio FROM libros ORDER BY titulo')
                  ->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    // El motivo va al log (docker logs); el visitante solo ve un aviso.
    error_log('[biblioteca] No se puede conectar con MySQL en ' . $host . ': ' . $e->getMessage());
    http_response_code(500);
}
function h($t) { return htmlspecialchars((string)$t, ENT_QUOTES, 'UTF-8'); }
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Libros · Biblioteca del aula</title>
  <link rel="stylesheet" href="css/estilo.css">
</head>
<body>
  <header>
    <img src="img/logo.svg" alt="" width="48" height="48">
    <h1>Biblioteca del aula</h1>
    <nav><a href="index.html">Inicio</a> · <a href="libros.php">Libros</a> · <a href="contacto.html">Contacto</a></nav>
  </header>
  <main>
    <h2>Libros</h2>
<?php if ($libros === null): ?>
    <p class="aviso">No se puede conectar con la base de datos.</p>
<?php else: ?>
    <table>
      <tr><th>Título</th><th>Autor</th><th>Año</th></tr>
<?php foreach ($libros as $l): ?>
      <tr><td><?= h($l['titulo']) ?></td><td><?= h($l['autor']) ?></td><td><?= h($l['anio']) ?></td></tr>
<?php endforeach; ?>
    </table>
    <p>Servido por PHP <?= h(PHP_VERSION) ?> · base de datos en <?= h($host) ?></p>
<?php endif; ?>
  </main>
  <footer>Despliegue de Aplicaciones Web · 2º DAW</footer>
</body>
</html>
