<?php
declare(strict_types=1);

require_once __DIR__ . '/../includes/funciones.php';
require_once __DIR__ . '/../config/database.php';

// 1. Solo se acepta POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: contacto.php');
    exit;
}

// 2. Verificar el token CSRF
$tokenEnviado = (string) ($_POST['csrf'] ?? '');
$tokenSesion  = (string) ($_SESSION['csrf'] ?? '');

if ($tokenSesion === '' || !hash_equals($tokenSesion, $tokenEnviado)) {
    http_response_code(403);
    exit('Solicitud no válida. Vuelve al formulario e inténtalo de nuevo.');
}

// 3. Limpiar los datos recibidos (Reto 1: Agregado $asunto)
$nombre  = trim((string) ($_POST['nombre']  ?? ''));
$email   = trim((string) ($_POST['email']   ?? ''));
$asunto  = trim((string) ($_POST['asunto']  ?? ''));
$mensaje = trim((string) ($_POST['mensaje'] ?? ''));

// 4. Validar (Reto 1: Validar $asunto obligatorio y máx 150 caracteres)
$errores = [];

if ($nombre === '' || mb_strlen($nombre) > 100) {
    $errores[] = 'El nombre es obligatorio y no puede superar 100 caracteres.';
}
if (mb_strlen($email) > 150 || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errores[] = 'Ingresa un correo electrónico válido (máximo 150 caracteres).';
}
if ($asunto === '' || mb_strlen($asunto) > 150) {
    $errores[] = 'El asunto es obligatorio y no puede superar 150 caracteres.';
}
if (mb_strlen($mensaje) < 10 || mb_strlen($mensaje) > 2000) {
    $errores[] = 'El mensaje debe tener entre 10 y 2000 caracteres.';
}

// 5. Si hay errores, volver al formulario conservando lo escrito (Reto 1: Incluido 'asunto')
if ($errores) {
    $_SESSION['errores'] = $errores;
    $_SESSION['viejo']   = compact('nombre', 'email', 'asunto', 'mensaje');
    header('Location: contacto.php');
    exit;
}

// 6. Guardar en PostgreSQL con consulta preparada (Reto 1: Incluida columna y valor :asunto)
try {
    $sql = 'INSERT INTO mensajes (nombre, email, asunto, mensaje)
            VALUES (:nombre, :email, :asunto, :mensaje)';
    $stmt = db()->prepare($sql);
    $stmt->execute([
        ':nombre'  => $nombre,
        ':email'   => $email,
        ':asunto'  => $asunto,
        ':mensaje' => $mensaje,
    ]);
} catch (PDOException $e) {
    error_log('Error al guardar mensaje: ' . $e->getMessage());
    $_SESSION['errores'] = [
        'No pudimos guardar tu mensaje. Inténtalo de nuevo más tarde.',
    ];
    $_SESSION['viejo']   = compact('nombre', 'email', 'asunto', 'mensaje');
    header('Location: contacto.php');
    exit;
}

// 7. Éxito: renovar el token y redirigir (Post/Redirect/Get)
unset($_SESSION['csrf']);
$_SESSION['enviado'] = true;
header('Location: gracias.php');
exit;