<?php
$profesores = $data["profesores"];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="https://www.iesgrancapitan.org/wp-content/uploads/sites/2/2021/06/cropped-icono_web_GranCapitan-32x32.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="../../../css/incidencia.css">
    <link rel="stylesheet" href="../../../css/footer.css">

    <title>Añadir incidencia-Centro Educativo IES Gran Capitán</title>
</head>

<body>
    <header>
        <a href="https://www.iesgrancapitan.org" target="_blanck"><img src="https://www.iesgrancapitan.org/wp-content/uploads/sites/2/2021/06/Logo_IES_GranCapitan_header.png" alt=""></a>
        <a href="/aula/<?=$data["numAula"]?>/incidencias" title="Incidencias" class="back-arrow-view">&#8592;</a>       
        <?php
        echo "<a href=\"/admin/logout\"><i class=\"fas fa-sign-out-alt botonSesionAdmin\" title=\"Cerrar Sesión\"></i></a>";
        ?>    
    </header>
    <h1>Dep. Informática</h1>
    <div class="divMainSection">
        <main>
        <h2>Nueva Incidencia- Aula <?=$data["numAula"]?></h2>
        <?php
        if ($_SESSION["fallo"]) {
            echo "<span class=\"spanFallo\">" . $_SESSION["fallo"] . "</span>";
            $_SESSION["fallo"] = null;
        }
        ?>
        <form action="/aula/<?=$data["numAula"]?>/incidencias/add" method="post">
            <label>Descripción de la incidencia:
                <textarea name="descripcion"></textarea>
            </label>
            <label>Fecha de la incidencia:</br>
                <input type="date" name="fecha" value="<?php echo date('Y-m-d'); ?>" required>
            </label>

            <label>Fecha de fin:</br>
                <input type="date" name="fecha_fin">
            </label>
            </br>
            <input type="submit" name="addSubmit" value="Añadir">
            <a href="/aula/<?=$data["numAula"]?>/incidencias" style="background-color: #de1d1d;color: #fff;padding: 10px 20px;border: none;border-radius: 5px;cursor: pointer;font-size: 16px;">Cancelar</a>
        </form>
        </main>
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