<?php
session_start();
require_once __DIR__ . '/../base_de_datos/base_de_datos.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: iniciar_sesion.php');
    exit();
}

$email = trim($_POST['CorreoElectronico'] ?? '');
$contrasena = $_POST['Contrasena'] ?? '';

if ($email === '' || $contrasena === '') {
    $_SESSION['error_login'] = 'Rellena ambos campos.';
    header('Location: iniciar_sesion.php');
    exit();
}

$stmt = $myconn->prepare("SELECT * FROM registro_usuarios WHERE CorreoElectronico = ? LIMIT 1");
if (!$stmt) {
    $_SESSION['error_login'] = 'Error interno (prepare).';
    header('Location: iniciar_sesion.php');
    exit();
}
$stmt->bind_param('s', $email);
$stmt->execute();
$res = $stmt->get_result();

if (!$res || $res->num_rows === 0) {
    $_SESSION['error_login'] = 'Credenciales incorrectas.';
    header('Location: iniciar_sesion.php');
    exit();
}

$row = $res->fetch_assoc();

$hash = null;
if (isset($row['Contrasena'])) $hash = $row['Contrasena'];
elseif (isset($row['Contraseña'])) $hash = $row['Contraseña'];
elseif (isset($row['contrasena'])) $hash = $row['contrasena'];
elseif (isset($row['password'])) $hash = $row['password'];

if (!$hash || !password_verify($contrasena, $hash)) {
    $_SESSION['error_login'] = 'Credenciales incorrectas.';
    header('Location: iniciar_sesion.php');
    exit();
}

$_SESSION['IDUsuario'] = $row['IDUsuario'] ?? $row['id'] ?? null;
$_SESSION['Nombre'] = $row['Nombre'] ?? '';

header('Location: ../index.php');
exit();

?>
