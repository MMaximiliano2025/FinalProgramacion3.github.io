<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Videojuegos</title>
    <link rel="stylesheet" href="../css/style.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/p5.js/1.6.0/p5.js"></script>
</head>

<?php session_start(); ?>
<section>
    <ul>
        <li><a href="../index.php">Inicio</a></li>
        <li><a href="../seccion1/subir_proyecto.php">Subir Proyecto</a></li>
        <li><a href="#">Videojuegos</a></li>
        <li><a href="../seccion3/perfil_usuario.php">Perfil Usuario</a></li>
        <?php if (isset($_SESSION['IDUsuario'])): ?>
            <li><a href="../formulario1/logout.php">Cerrar Sesión</a></li>
        <?php else: ?>
            <li><a href="../formulario1/iniciar_sesion.php">Iniciar Sesión</a></li>
            <li><a href="../formulario2/registro.php">Registrarse</a></li>
        <?php endif; ?>
    </ul>
</section>
<section class="seccion-juego">
    <h1>Slime - Videojuego Unity</h1>
    <div class="juego-contenedor">
        <iframe src="Juego/index.html" width="1280" height="720" frameborder="0" allowfullscreen></iframe>
    </div>
    <div class="descripcion-juego">
        <p>Sobrevive, pues eres un Slime, al igual que tus enemigos.</p>
    </div>

    </body>

</html>