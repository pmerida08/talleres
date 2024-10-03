<?php
$aulas = $data["aulas"];
$grupo1 = $data["grupo1"];
$grupo2 = $data["grupo2"];
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Andres">
    <link rel="icon" href="https://www.iesgrancapitan.org/wp-content/uploads/sites/2/2021/06/cropped-icono_web_GranCapitan-32x32.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="../css/aula.css">
    <link rel="stylesheet" href="../css/footer.css">
    <title>Centro Educativo IES Gran Capitán</title>
</head>

<body>
    <header>
        <a href="https://www.iesgrancapitan.org" target="_blanck"><img src="https://www.iesgrancapitan.org/wp-content/uploads/sites/2/2021/06/Logo_IES_GranCapitan_header.png" alt=""></a>
        <?php
        if ($_SESSION["perfil"] == "profesor") {
            echo "<a href=\"/admin/aulas/\" class=\"botonGestionDatos\">Gestión de Datos</a>";
            echo "<a href=\"/admin/logout\"><i class=\"fas fa-sign-out-alt botonSesionAdmin\"></i></a>";
        } else if ($_SESSION["perfil"] == "alumno") {
            echo "<a href=\"/admin/logout\"><i class=\"fas fa-sign-out-alt botonSesionAdmin\"></i></a>";
        } else {
            echo "<a href=\"/login/\" class=\"botonSesionAdmin\">Iniciar Sesión</a>";
        }
        ?>
    </header>
    <h1>Dep. Informática</h1>
    <h2 class="subtitulo">Aulas</h2>
    <div class="divMainSection" style="margin: 0 auto;">
        <div class="aulas">
            <?php
            foreach ($aulas as $key => $aula) {
                echo "<a href=\"/aula/" . $aula["id"] . "\">";
                echo "<div class=\"aula\">";
                echo "<h2>" . $aula["num_aula"] . "</h2>";
                echo isset($grupo1[$aula["id"]][0]["nombre"]) ? "<p>" . $grupo1[$aula["id"]][0]["nombre"] : '' . "</p>";
                echo isset($grupo2[$aula["id"]][0]["nombre"]) ? "<p>" . $grupo2[$aula["id"]][0]["nombre"] : '' . "</p>";
                echo "</div>";
                echo "</a>";
            }
            ?>
        </div>
    </div>
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