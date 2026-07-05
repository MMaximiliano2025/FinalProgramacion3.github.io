<?php
session_start();
require_once __DIR__ . '/../base_de_datos/base_de_datos.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: registro.php');
    exit();
}

$nombre = trim($_POST['Nombre'] ?? '');
$apellido = trim($_POST['Apellido'] ?? '');
$email = trim($_POST['CorreoElectronico'] ?? '');
$contrasena = $_POST['Contrasena'] ?? '';

if ($nombre === '' || $apellido === '' || $email === '' || $contrasena === '') {
    $_SESSION['error_registro'] = 'Rellena todos los campos.';
    header('Location: registro.php');
    exit();
}

$stmt = $myconn->prepare("SELECT IDUsuario FROM registro_usuarios WHERE CorreoElectronico = ? LIMIT 1");
if (!$stmt) {
    $_SESSION['error_registro'] = 'Error interno (prepare).';
    header('Location: registro.php');
    exit();
}
$stmt->bind_param('s', $email);
$stmt->execute();
$res = $stmt->get_result();
if ($res && $res->num_rows > 0) {
    $_SESSION['error_registro'] = 'El correo ya está registrado.';
    header('Location: registro.php');
    exit();
}

$hash = password_hash($contrasena, PASSWORD_DEFAULT);
$insert = $myconn->prepare("INSERT INTO registro_usuarios (`Nombre`, `Apellido`, `CorreoElectronico`, `Contraseña`) VALUES (?, ?, ?, ?)");
if (!$insert) {
    $_SESSION['error_registro'] = 'Error interno (prepare insert).';
    header('Location: registro.php');
    exit();
}
$insert->bind_param('ssss', $nombre, $apellido, $email, $hash);
$ok = $insert->execute();

if ($ok) {
    $_SESSION['msg_registro'] = 'Registro correcto. Ya puedes iniciar sesión.';
    header('Location: ../formulario1/iniciar_sesion.php');
    exit();
} else {
    $_SESSION['error_registro'] = 'Error al guardar el registro.';
    header('Location: registro.php');
    exit();
}

?>
