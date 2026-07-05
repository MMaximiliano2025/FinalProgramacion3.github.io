<?php
session_start();

if (isset($_SESSION['IDUsuario'])) {
    header("Location: ../index.php");
    exit();
}

$error = "";
if (isset($_SESSION['error_login'])) {
    $error = $_SESSION['error_login'];
    unset($_SESSION['error_login']);
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Iniciar Sesión</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../css/login_modal.css">


    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
        integrity="sha512-Avb2QiuDEEvB4bZJYdft2mNjVShBftLdPG8FJ0V7irTLQ8Uo0qcPxh4Plq7G5tGm0rU+1SPhVotteLpBERwTkw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
    <div class="fondo-modal" role="dialog" aria-modal="true">
        <div class="modal-inicio">
            <button class="boton-cerrar" onclick="window.location.href='../index.php'" aria-label="Cerrar">&times;</button>
            <h1>Inicio de sesión</h1>

            <?php if ($error): ?>
                <p class="mensaje-error"><?php echo htmlspecialchars($error, ENT_QUOTES); ?></p>
            <?php endif; ?>

            <form method="post" action="Login_procesar.php" autocomplete="on" novalidate>
                <div class="grupo-formulario">
                    <input type="email" name="CorreoElectronico" placeholder="Correo electrónico" required
                        value="<?php echo htmlspecialchars($_POST['CorreoElectronico'] ?? '', ENT_QUOTES); ?>">
                </div>

                <div class="grupo-formulario contrasena-contenedor">
                    <input type="password" name="Contrasena" id="contrasena" placeholder="Contraseña" required>
                    <button type="button" class="boton-alternar" onclick="alternarContrasena('contrasena', this)" aria-label="Mostrar contraseña">
                        <i class="fas fa-eye"></i>
                    </button>
                </div>

                <div class="acciones-formulario">
                    <input type="submit" value="Iniciar Sesión">
                </div>

                <div class="enlace-registrarse">
                    ¿No tienes cuenta? <a href="Formulario.php">Registrarse</a>
                </div>

                <div class="wrapper-sociales">
                    <div class="opciones-sociales">Otras opciones de inicio de sesión</div>
                    <div class="formulario-sociales">
                        <a href="https://accounts.google.com/" target="_blank" class="google" rel="noopener"><i class="fab fa-google"></i></a>
                        <a href="https://appleid.apple.com/" target="_blank" class="apple" rel="noopener"><i class="fab fa-apple"></i></a>
                        <a href="https://www.facebook.com/login/" target="_blank" class="facebook" rel="noopener"><i class="fab fa-facebook-f"></i></a>
                        <a href="https://twitter.com/login" target="_blank" class="twitter" rel="noopener"><i class="fab fa-twitter"></i></a>
                        <a href="https://www.instagram.com/accounts/login/" target="_blank" class="instagram" rel="noopener"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        function alternarContrasena(id, btn) {
            const input = document.getElementById(id);
            const icon = btn.querySelector('i');
            if (input.type === "password") {
                input.type = "text";
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = "password";
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }
    </script>
</body>

</html>