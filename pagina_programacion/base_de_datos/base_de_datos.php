<?php
$host = 'localhost';
$usuario = 'root';
$contraseña = '';
$nombre_BD = 'registro_usuarios_db';

$myconn = new mysqli($host, $usuario, $contraseña, $nombre_BD);

if ($myconn->connect_error) {
    die('Error al conectar a la Base de Datos: ' . $myconn->connect_error);
}

$myconn->set_charset('utf8');
?>