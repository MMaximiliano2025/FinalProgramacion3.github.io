<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subir Proyecto</title>
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>
    <?php session_start(); ?>
    <section>
        <ul>
            <li><a href="../index.php">Inicio</a></li>
            <li><a href="../seccion1/subir_proyecto.php">Subir Proyecto</a></li>
            <li><a href="../seccion2/videojuegos.php">Videojuegos</a></li>
            <li><a href="#">Perfil Usuario</a></li>
            <?php if (isset($_SESSION['IDUsuario'])): ?>
                <li><a href="../formulario1/logout.php">Cerrar Sesión</a></li>
            <?php else: ?>
                <li><a href="../formulario1/iniciar_sesion.php">Iniciar Sesión</a></li>
                <li><a href="../formulario2/registro.php">Registrarse</a></li>
            <?php endif; ?>
        </ul>
    </section>

    <section class="contenido">
        <h1>Panel de Usuario</h1>
        <p>En esta página verás tu nombre, tu estado y algunas recomendaciones útiles para usar la web.</p>

        <?php
        $nombre_sesion = trim($_SESSION['Nombre'] ?? '');
        $id_usuario = $_SESSION['IDUsuario'] ?? '';
        $inicial = mb_strtoupper(mb_substr($nombre_sesion, 0, 1, 'UTF-8')) ?: 'U';

        $avatarUrl = '';
        if ($id_usuario) {
            $avatarDir = __DIR__ . '/avatars';
            foreach (['png', 'jpg', 'jpeg', 'gif'] as $ext) {
                $p = $avatarDir . '/' . $id_usuario . '.' . $ext;
                if (file_exists($p)) {
                    $avatarUrl = 'avatars/' . $id_usuario . '.' . $ext;
                    break;
                }
            }
        }
        ?>

        <div class="perfil-header">
            <?php if ($avatarUrl): ?>
                <img src="<?php echo $avatarUrl; ?>" alt="Avatar" class="perfil-avatar">
            <?php else: ?>
                <div class="perfil-avatar" aria-hidden="true"><?php echo htmlspecialchars($inicial, ENT_QUOTES); ?></div>
            <?php endif; ?>

            <div class="perfil-usuario-info">
                <div class="nombre"><?php echo $nombre_sesion !== '' ? htmlspecialchars($nombre_sesion, ENT_QUOTES) : 'Usuario'; ?></div>
                <div class="sub">ID: <?php echo htmlspecialchars($id_usuario ?: '—', ENT_QUOTES); ?></div>
            </div>

            <div class="perfil-actions">
                <a href="editar_perfil.php" class="boton-personalizado boton-editar">Editar perfil</a>
            </div>
        </div>

        <div class="hero-info" style="margin-top: 24px;">
            <div class="hero-card">
                <h3>Tu nombre</h3>
                <p><?php echo htmlspecialchars($_SESSION['Nombre'] ?? 'Usuario', ENT_QUOTES); ?></p>
            </div>
            <div class="hero-card">
                <h3>ID de usuario</h3>
                <p><?php echo htmlspecialchars($_SESSION['IDUsuario'] ?? 'No disponible', ENT_QUOTES); ?></p>
            </div>
            <div class="hero-card">
                <h3>Estado</h3>
                <p>Sesión activa. Ya puedes explorar el juego y subir proyectos.</p>
            </div>
        </div>

        <div class="hero-info" style="margin-top: 28px;">
            <div class="hero-card">
                <h3>Consejo</h3>
                <p>Sube tu proyecto para tener una página de muestra y demostrar tu trabajo.</p>
            </div>
            <div class="hero-card">
                <h3>Próximo paso</h3>
                <p>Visita la sección de videojuegos para probar la integración de Unity en el sitio.</p>
            </div>
            <div class="hero-card">
                <h3>Sugerencia</h3>
                <p>Usa el mismo nombre que aparece aquí al enviar tus datos para mayor consistencia.</p>
            </div>
        </div>

        <div class="perfil-enlaces" style="margin-top: 30px; text-align: left;">
            <h2>Qué puedes hacer aquí</h2>
            <ul>
                <li>Ver tu identidad dentro del sitio.</li>
                <li>Leer recomendaciones útiles para usar el proyecto.</li>
                <li>Ver tu estado de sesión.</li>
                <li>Entender qué se espera en la parte de entrega universitaria.</li>
            </ul>
        </div>
    </section>
</body>

</html>