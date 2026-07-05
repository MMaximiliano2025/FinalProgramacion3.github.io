
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subir Proyecto</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <?php
    // Configuración
    $tamano_maximo = 2 * 1024 * 1024; 
    $tipos_permitidos = ['image/jpeg', 'image/png', 'image/gif'];

    if (isset($_FILES['userfile'])) {
        $archivo = $_FILES['userfile'];
        $extension = strtolower(pathinfo($archivo['name'], PATHINFO_EXTENSION));

        if (!in_array($archivo['type'], $tipos_permitidos) || !in_array($extension, ['jpg', 'jpeg', 'png', 'gif'])) {
            echo "<p style='color:#721c24; text-align:center;'>Archivo no permitido. Solo imágenes JPG, PNG o GIF.</p>";
        } elseif ($archivo['size'] > $tamano_maximo) {
            echo "<p style='color:#721c24; text-align:center;'>Archivo demasiado grande. Máximo 2 MB.</p>";
        } else {
            $nombre_usuario = isset($_POST['cadenatexto']) ? trim($_POST['cadenatexto']) : '';
            if (empty($nombre_usuario)) {
                $nombre_usuario = pathinfo($archivo['name'], PATHINFO_FILENAME);
            }
            $nombre_usuario = preg_replace("/[^a-zA-Z0-9_-]/", "_", $nombre_usuario);
            $nombre_final = $nombre_usuario . '.' . $extension;

            if (!move_uploaded_file($archivo['tmp_name'], 'subidas/' . $nombre_final)) {
                echo "<p style='color:#721c24; text-align:center;'>Error al subir el archivo.</p>";
            }
        }
    }
    ?>

    <?php session_start(); ?>
    <section>
        <ul>
            <li><a href="../index.php">Inicio</a></li>
            <li><a href="#">Subir Proyecto</a></li>
            <li><a href="../seccion2/videojuegos.php">Videojuegos</a></li>
            <li><a href="../seccion3/perfil_usuario.php">Perfil Usuario</a></li>
            <?php if (isset($_SESSION['IDUsuario'])): ?>
                <li><a href="../formulario1/logout.php">Cerrar Sesión</a></li>
            <?php else: ?>
                <li><a href="../formulario1/iniciar_sesion.php">Iniciar Sesión</a></li>
                <li><a href="../formulario2/registro.php">Registrarse</a></li>
            <?php endif; ?>
        </ul>
    </section>

    <div class="caja-centrada">
        <form action="" method="post" enctype="multipart/form-data">
            <input type="text" name="cadenatexto" placeholder="Nombre del proyecto" maxlength="100">
            
            <div class="area-archivo">
                <input type="file" id="archivo" name="userfile" accept=".jpg,.jpeg,.png,.gif">
                <label for="archivo" class="boton-personalizado">Seleccionar archivo</label>
            </div>

            <input type="submit" value="Sube Proyecto" class="boton-personalizado">
        </form>
    </div>

    <h2 style="text-align: center; margin-top: 2rem;">Archivos subidos:</h2>
    <div class="galeria-imagenes">
        <?php
        if (is_dir('subidas')) {
            $archivos = array_diff(scandir('subidas'), ['.', '..']);
            foreach ($archivos as $a) {
                echo "<div class='caja'>";
                echo "<img src='subidas/$a' alt='Imagen subida'>";
                echo "<span>$a</span>";
                echo "</div>";
            }
        }
        ?>
    </div>
</body>
</html>