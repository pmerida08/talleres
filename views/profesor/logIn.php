<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Autentificación-Centro Educativo IES Gran Capitán</title>
    <link rel="icon" href="https://www.iesgrancapitan.org/wp-content/uploads/sites/2/2021/06/cropped-icono_web_GranCapitan-32x32.png" type="image/x-icon">
    <link rel="stylesheet" href="../css/logIn.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <script src="../script/logIn.js"></script>
    <link rel="stylesheet" href="../css/footer.css">
</head>

<body>
    <header>
    <a href="https://www.iesgrancapitan.org" target="_blanck"><img src="https://www.iesgrancapitan.org/wp-content/uploads/sites/2/2021/06/Logo_IES_GranCapitan_header.png" alt=""></a>
    <a href="/" class="back-arrow-view"  title="Página de Inicio">&#8592;</a>        
   </header>
    <h2>Formulario de Autentificación</h2>
    <?php
    if ($_SESSION["fallo"]) {
        echo "<span class=\"spanFallo\">".$_SESSION["fallo"]."</span>";
        $_SESSION["fallo"] = null;
    }
    ?>
    <form action="/login/" method="POST">
        <div>
            <label for="user">Nombre de Usuario:</label>
            <input type="text" id="user" name="user" required>
        </div>
        <div>
        <label for="password">Contraseña:</label>
        <div class="password-container">
            <input type="password" id="password" name="password" required>
            <span id="toggle-password" class="toggle-password">👁️</span>
        </div>
    </div>
        <div>
            <button type="submit">Autentificar</button>
        </div>
    </form>
    <a href="<?= CLIENT->createAuthUrl() ?>" class="enlaceSesionGoogle">
        <img src="https://developers.google.com/identity/images/g-logo.png" alt="Google Logo" class="google-icon">
        Iniciar con Google
    </a>
    <footer>
        <div class="contact-info">
            IES Gran Capitán 2023 · Avda Arcos de la Frontera s/n, Córdoba(Spain) · Tel: 957379710
        </div>
        <div class="social-icons">
            <a href="https://twitter.com/ies_grancapitan" class="social-icon"><i class="fab fa-twitter"></i></a>
            <a href="https://www.iesgrancapitan.org/#top" class="social-icon"><i class="fab fa-instagram"></i></a>
            <a href="https://www.facebook.com/iesgrancapitan" class="social-icon"><i class="fab fa-facebook-square"></i></a>
        </div>
    </footer> 
</body>

</html>