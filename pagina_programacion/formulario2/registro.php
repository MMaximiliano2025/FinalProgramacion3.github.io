<?php
session_start();
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Registrarse</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../css/login_modal.css">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" crossorigin="anonymous" />
</head>

<body>
    <div class="fondo-modal" style="display:flex;">
        <div class="modal-inicio">
            <button class="boton-cerrar" onclick="window.location.href='../index.php'" aria-label="Cerrar">&times;</button>
            <h1>Registrarse</h1>

            <form method="post" action="Procesar.php" onsubmit="return validarFormulario()" autocomplete="on" novalidate>
                <div class="grupo-formulario">
                    <input type="text" name="Nombre" placeholder="Nombre" required>
                </div>

                <div class="grupo-formulario">
                    <input type="text" name="Apellido" placeholder="Apellido" required>
                </div>

                <div class="grupo-formulario">
                    <input type="email" name="CorreoElectronico" placeholder="Correo electrónico" required>
                </div>

                <div class="grupo-formulario contrasena-contenedor">
                    <input type="password" name="Contrasena" id="contrasena" placeholder="Introduce la contraseña" required>
                    <button type="button" class="boton-alternar" onclick="alternarContrasena('contrasena', this)" aria-label="Mostrar contraseña">
                        <i class="fas fa-eye"></i>
                    </button>
                </div>

                <div class="grupo-formulario contrasena-contenedor">
                    <input type="password" name="Contrasena2" id="contrasena2" placeholder="Repite la contraseña" required>
                    <button type="button" class="boton-alternar" onclick="alternarContrasena('contrasena2', this)" aria-label="Mostrar contraseña">
                        <i class="fas fa-eye"></i>
                    </button>
                </div>

                <div class="acciones-formulario">
                    <input type="submit" value="Registrarse">
                </div>

                <div class="enlace-iniciar" style="margin-top:12px; font-size:0.98rem; text-align:center;">
                    ¿Ya tienes cuenta?
                    <a href="Login.php" style="color:#ffd600; font-weight:700; text-decoration:none; margin-left:6px;">Iniciar sesión</a>
                </div>

                <div class="wrapper-sociales">
                    <div class="opciones-sociales">Otras opciones de registro</div>
                    <div class="formulario-sociales">
                        <a href="https://accounts.google.com/" target="_blank" class="google" rel="noopener"><i class="fab fa-google"></i></a>
                        <a href="https://appleid.apple.com/" target="_blank" class="apple" rel="noopener"><i class="fab fa-apple"></i></a>
                        <a href="https://www.facebook.com/r.php" target="_blank" class="facebook" rel="noopener"><i class="fab fa-facebook-f"></i></a>
                        <a href="https://twitter.com/i/flow/signup" target="_blank" class="twitter" rel="noopener"><i class="fab fa-twitter"></i></a>
                        <a href="https://www.instagram.com/accounts/emailsignup/" target="_blank" class="instagram" rel="noopener"><i class="fab fa-instagram"></i></a>
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

        function validarFormulario() {
            const contrasena = document.getElementById('contrasena').value;
            const contrasena2 = document.getElementById('contrasena2').value;
            if (contrasena !== contrasena2) {
                alert("Las contraseñas no coinciden.");
                return false;
            }
            if (contrasena.length < 8) {
                alert("La contraseña debe tener al menos 8 caracteres.");
                return false;
            }
            return true;
        }
    </script>
</body>

</html>