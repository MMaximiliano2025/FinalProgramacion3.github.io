<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio</title>
    <link rel="stylesheet" href="./css/style.css">
</head>

<body>
    <?php session_start(); ?>
    <section>
        <ul>
            <li><a href="#">Inicio</a></li>
            <li><a href="./seccion1/subir_proyecto.php">Subir Proyecto</a></li>
            <li><a href="./seccion2/videojuegos.php">Videojuegos</a></li>
            <li><a href="./seccion3/perfil_usuario.php">Perfil Usuario</a></li>
            <?php if (isset($_SESSION['IDUsuario'])): ?>
                <li><a href="./formulario1/logout.php">Cerrar Sesión</a></li>
            <?php else: ?>
                <li><a href="./formulario1/iniciar_sesion.php">Iniciar Sesión</a></li>
                <li><a href="./formulario2/registro.php">Registrarse</a></li>
            <?php endif; ?>
        </ul>
    </section>

    <section class="hero">
        <div class="hero-text">
            <p class="eyebrow">Proyecto universitario</p>
            <h1>Slime Unity + PHP en una sola entrega</h1>
            <p>Una página web para la universidad con juego integrado, login, registro y soporte de base de datos.</p>
        </div>
        <div class="hero-info">
            <div class="hero-card">
                <h3>Tecnologías</h3>
                <p>Unity, PHP, MySQL, HTML y CSS.</p>
            </div>
            <div class="hero-card">
                <h3>Objetivo</h3>
                <p>Mostrar un juego Unity dentro de un sitio con autenticación y datos.</p>
            </div>
            <div class="hero-card">
                <h3>Funcionalidad</h3>
                <p>Login, registro, perfil de usuario y subida de proyecto.</p>
            </div>
        </div>
    </section>
</body>

</html>