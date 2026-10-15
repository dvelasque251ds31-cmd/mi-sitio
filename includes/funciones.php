<?php
declare(strict_types=1);
 
// Inicia la sesión una sola vez (token CSRF y mensajes de error)
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
 
/** Escapa texto para imprimirlo en HTML (previene XSS). */
function e(string $texto): string
{
    return htmlspecialchars($texto, ENT_QUOTES, 'UTF-8');
}
 
/** Devuelve el token CSRF de la sesión; lo crea si no existe. */
function csrf_token(): string
{
    if (empty($_SESSION['csrf'])) {
        $_SESSION['csrf'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf'];
}
