<?php
// Obtener datos del formulario
$username = isset($_POST['username']) ? $_POST['username'] : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';

// Verificar si se han enviado datos
if (!empty($username) && !empty($password)) {
    $usuarioCorrecto = ($username === 'minichatadmin');
    $contrasenaCorrecta = ($password === 'Donner2008.Fender2008.');

    if ($usuarioCorrecto && $contrasenaCorrecta) {
        // Inicio de sesión exitoso, restablecer intentos fallidos
        echo 'Inicio de sesión exitoso';
    } else {
        // Bloquear la IP y mostrar mensaje
        bloquearIP($ip, $ipsBloqueadas);
        echo 'Nombre de usuario o contraseña incorrectos. Tu IP ha sido bloqueada por 24 horas.';
    }
} else {
    echo 'Por favor, proporciona un nombre de usuario y una contraseña.';
}

// Función para obtener la dirección IP del usuario
function obtenerDireccionIP() {
    // Puedes ajustar esta función según tu entorno de servidor
    return $_SERVER['REMOTE_ADDR'];
}

// Función para verificar si una IP está bloqueada
function ipEstaBloqueada($ip, $ipsBloqueadas) {
    return isset($ipsBloqueadas[$ip]) && (time() - $ipsBloqueadas[$ip]) < $GLOBALS['tiempoBloqueo'];
}

// Función para bloquear una IP
function bloquearIP($ip, &$ipsBloqueadas) {
    $ipsBloqueadas[$ip] = time();
}
?>