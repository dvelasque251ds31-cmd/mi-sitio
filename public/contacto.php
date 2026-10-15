<?php
$titulo = 'Contacto';
require __DIR__ . '/../includes/header.php';
 
// Recuperar errores y datos previos (se muestran una sola vez)
$errores = $_SESSION['errores'] ?? [];
$viejo   = $_SESSION['viejo'] ?? [];
unset($_SESSION['errores'], $_SESSION['viejo']);
?>
<h1>Contacto</h1>
 
<?php if ($errores): ?>
    <ul class="errores">
        <?php foreach ($errores as $error): ?>
            <li><?= e($error) ?></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>
 
<form action="procesar.php" method="post" novalidate>
    <input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">
 
    <label for="nombre">Nombre</label>
    <input type="text" id="nombre" name="nombre" maxlength="100"
           value="<?= e($viejo['nombre'] ?? '') ?>" required>
 
    <label for="email">Correo electrónico</label>
    <input type="email" id="email" name="email" maxlength="150"
           value="<?= e($viejo['email'] ?? '') ?>" required>
 
    <label for="mensaje">Mensaje</label>
    <textarea id="mensaje" name="mensaje" rows="5"
              required><?= e($viejo['mensaje'] ?? '') ?></textarea>
 
    <button type="submit">Enviar</button>
</form>
 
<?php require __DIR__ . '/../includes/footer.php'; ?>
