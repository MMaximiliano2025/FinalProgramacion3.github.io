<?php
session_start();
if (!isset($_SESSION['IDUsuario'])) {
    header('Location: ../formulario1/iniciar_sesion.php');
    exit();
}
$id_usuario = $_SESSION['IDUsuario'];
$nombre = trim($_SESSION['Nombre'] ?? 'Usuario');

$avatarUrl = '';
$avatarDir = __DIR__ . '/avatars';
foreach (['png', 'jpg', 'jpeg', 'gif'] as $ext) {
    $p = $avatarDir . '/' . $id_usuario . '.' . $ext;
    if (file_exists($p)) {
        $avatarUrl = 'avatars/' . $id_usuario . '.' . $ext;
        break;
    }
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Editar perfil</title>
    <link rel="stylesheet" href="../css/style.css">
    <!-- Cropper.js (CDN) -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css" rel="stylesheet">
</head>

<body>
    <section>
        <ul>
            <li><a href="../index.php">Inicio</a></li>
            <li><a href="../seccion1/subir_proyecto.php">Subir Proyecto</a></li>
            <li><a href="../seccion2/videojuegos.php">Videojuegos</a></li>
            <li><a href="perfil_usuario.php">Perfil Usuario</a></li>
            <li><a href="../formulario1/logout.php">Cerrar Sesión</a></li>
        </ul>
    </section>

    <main class="contenido">
        <h1>Editar perfil</h1>
        <p>Actualiza tu avatar (png, jpg, gif). Tamaño máximo 2 MB.</p>

        <?php if (!empty($_SESSION['error_profile'])): ?>
            <p class="mensaje-error"><?php echo htmlspecialchars($_SESSION['error_profile'], ENT_QUOTES);
                                        unset($_SESSION['error_profile']); ?></p>
        <?php endif; ?>
        <?php if (!empty($_SESSION['msg_profile'])): ?>
            <p class="mensaje-ok"><?php echo htmlspecialchars($_SESSION['msg_profile'], ENT_QUOTES);
                                    unset($_SESSION['msg_profile']); ?></p>
        <?php endif; ?>

        <div style="display:flex;flex-direction:column;gap:18px;">
            <div style="display:flex;align-items:center;gap:18px;">
                <?php if ($avatarUrl): ?>
                    <img src="<?php echo $avatarUrl; ?>" alt="Avatar" style="width:96px;height:96px;border-radius:50%;object-fit:cover;">
                <?php else: ?>
                    <div style="width:96px;height:96px;border-radius:50%;background:#ddd;display:flex;align-items:center;justify-content:center;font-weight:700;"><?php echo htmlspecialchars(mb_strtoupper(mb_substr($nombre, 0, 1, 'UTF-8')), ENT_QUOTES); ?></div>
                <?php endif; ?>

                <div>
                    <strong><?php echo htmlspecialchars($nombre, ENT_QUOTES); ?></strong><br>
                    <small>ID: <?php echo htmlspecialchars($id_usuario, ENT_QUOTES); ?></small>
                </div>
            </div>

            <div>
                <label for="avatar">Selecciona una imagen</label><br>
                <input type="file" id="avatar" accept="image/*"><br>
                <div id="crop-area" style="margin-top:12px;display:none;">
                    <div style="max-width:480px;">
                        <img id="preview" style="max-width:100%;display:block;">
                    </div>
                    <div style="margin-top:10px;display:flex;gap:10px;">
                        <button id="crop-upload" class="boton-personalizado">Recortar y subir</button>
                        <button id="upload-original" class="boton-personalizado" style="background:#f5f5f5;border:1px solid #e3e3e3;">Subir original</button>
                        <a href="perfil_usuario.php" class="boton-personalizado" style="background:#ffffff;border:1px solid #e3e3e3;">Cancelar</a>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>

<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const input = document.getElementById('avatar');
        const preview = document.getElementById('preview');
        const cropArea = document.getElementById('crop-area');
        const btnCrop = document.getElementById('crop-upload');
        const btnOriginal = document.getElementById('upload-original');
        let cropper = null;

        function showError(msg) {
            alert(msg);
        }

        input.addEventListener('change', function(e) {
            const file = e.target.files && e.target.files[0];
            if (!file) return;
            if (!file.type.startsWith('image/')) {
                showError('Selecciona una imagen válida.');
                return;
            }
            const url = URL.createObjectURL(file);
            preview.src = url;
            cropArea.style.display = 'block';
            if (cropper) {
                cropper.destroy();
                cropper = null;
            }
            cropper = new Cropper(preview, {
                aspectRatio: 1,
                viewMode: 1,
                autoCropArea: 1
            });
        });

        function sendBlob(blob, filename) {
            const fd = new FormData();
            fd.append('avatar', blob, filename);

            fetch('procesar_editar_perfil.php', {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: fd,
                credentials: 'same-origin'
            }).then(r => r.json()).then(data => {
                if (data.ok) {

                    window.location.reload();
                } else {
                    showError(data.message || 'Error al subir');
                }
            }).catch(err => {
                showError('Error de red: ' + err.message);
            });
        }

        btnCrop.addEventListener('click', function(e) {
            e.preventDefault();
            if (!cropper) {
                showError('No hay imagen cargada para recortar.');
                return;
            }
            cropper.getCroppedCanvas({
                width: 400,
                height: 400
            }).toBlob(function(blob) {
                const name = 'avatar_' + Date.now() + '.png';
                sendBlob(blob, name);
            }, 'image/png');
        });

        btnOriginal.addEventListener('click', function(e) {
            e.preventDefault();
            const file = input.files && input.files[0];
            if (!file) {
                showError('No hay archivo seleccionado.');
                return;
            }
            sendBlob(file, file.name);
        });
    });
</script>

</html>