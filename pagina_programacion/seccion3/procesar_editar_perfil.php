<?php
session_start();
if (!isset($_SESSION['IDUsuario'])) {
    // Si es AJAX, devolver error JSON
    $isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
    if ($isAjax) {
        header('Content-Type: application/json; charset=utf-8', true, 401);
        echo json_encode(['ok' => false, 'message' => 'No autenticado']);
        exit();
    }
    header('Location: ../formulario1/iniciar_sesion.php');
    exit();
}

$id = $_SESSION['IDUsuario'];

$isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
if ($_SERVER['REQUEST_METHOD'] !== 'POST' || empty($_FILES['avatar'])) {
    if ($isAjax) {
        header('Content-Type: application/json; charset=utf-8', true, 400);
        echo json_encode(['ok' => false, 'message' => 'No se envió ninguna imagen.']);
        exit();
    }
    $_SESSION['error_profile'] = 'No se envió ninguna imagen.';
    header('Location: editar_perfil.php');
    exit();
}

$file = $_FILES['avatar'];
if ($file['error'] !== UPLOAD_ERR_OK) {
    if ($isAjax) {
        header('Content-Type: application/json; charset=utf-8', true, 400);
        echo json_encode(['ok' => false, 'message' => 'Error al subir el archivo.']);
        exit();
    }
    $_SESSION['error_profile'] = 'Error al subir el archivo.';
    header('Location: editar_perfil.php');
    exit();
}

$maxSize = 2 * 1024 * 1024; // 2MB
if ($file['size'] > $maxSize) {
    if ($isAjax) {
        header('Content-Type: application/json; charset=utf-8', true, 400);
        echo json_encode(['ok' => false, 'message' => 'El archivo excede el tamaño máximo (2 MB).']);
        exit();
    }
    $_SESSION['error_profile'] = 'El archivo excede el tamaño máximo (2 MB).';
    header('Location: editar_perfil.php');
    exit();
}

$finfo = new finfo(FILEINFO_MIME_TYPE);
$mime = $finfo->file($file['tmp_name']);
$allowed = ['image/png' => 'png', 'image/jpeg' => 'jpg', 'image/gif' => 'gif'];
if (!isset($allowed[$mime])) {
    if ($isAjax) {
        header('Content-Type: application/json; charset=utf-8', true, 400);
        echo json_encode(['ok' => false, 'message' => 'Tipo de archivo no permitido. Usa PNG, JPG o GIF.']);
        exit();
    }
    $_SESSION['error_profile'] = 'Tipo de archivo no permitido. Usa PNG, JPG o GIF.';
    header('Location: editar_perfil.php');
    exit();
}

$ext = $allowed[$mime];
$avatarDir = __DIR__ . '/avatars';
if (!is_dir($avatarDir)) {
    mkdir($avatarDir, 0755, true);
}

foreach (['png', 'jpg', 'jpeg', 'gif'] as $e) {
    $old = $avatarDir . '/' . $id . '.' . $e;
    if (file_exists($old) && $e !== $ext) @unlink($old);
}

$target = $avatarDir . '/' . $id . '.' . $ext;
if (!move_uploaded_file($file['tmp_name'], $target)) {
    if ($isAjax) {
        header('Content-Type: application/json; charset=utf-8', true, 500);
        echo json_encode(['ok' => false, 'message' => 'No se pudo guardar la imagen.']);
        exit();
    }
    $_SESSION['error_profile'] = 'No se pudo guardar la imagen.';
    header('Location: editar_perfil.php');
    exit();
}

// Permisos
@chmod($target, 0644);

if ($isAjax) {
    header('Content-Type: application/json; charset=utf-8');
    $avatarPath = 'avatars/' . $id . '.' . $ext;
    echo json_encode(['ok' => true, 'message' => 'Avatar actualizado correctamente.', 'avatar' => $avatarPath]);
    exit();
}

$_SESSION['msg_profile'] = 'Avatar actualizado correctamente.';
header('Location: editar_perfil.php');
exit();
