<?php
require_once __DIR__ . '/../includes/funciones.php';
 
// Solo se muestra justo después de un envío exitoso
if (empty($_SESSION['enviado'])) {
    header('Location: contacto.php');
    exit;
}
unset($_SESSION['enviado']);
 
$titulo = 'Gracias';
require __DIR__ . '/../includes/header.php';
?>
<h1>¡Gracias!</h1>
<p class="exito">Recibimos tu mensaje. Te responderemos lo antes posible.</p>
<p><a href="index.php">Volver al inicio</a> · <a href="contacto.php">Enviar otro mensaje</a></p>
<?php require __DIR__ . '/../includes/footer.php'; ?>
