<?php
$equipos = $data["equipos"];
$profesores = $data["profesores"];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="https://www.iesgrancapitan.org/wp-content/uploads/sites/2/2021/06/cropped-icono_web_GranCapitan-32x32.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="../../css/reserva.css">
    <link rel="stylesheet" href="../../css/footer.css">
    <title>Añadir reserva-Centro Educativo IES Gran Capitán</title>
</head>

<body>
    <header>
        <a href="https://www.iesgrancapitan.org" target="_blanck"><img src="https://www.iesgrancapitan.org/wp-content/uploads/sites/2/2021/06/Logo_IES_GranCapitan_header.png" alt=""></a>
        <a href="/admin/reservas/" title="Reservas" class="back-arrow-view">&#8592;</a>
        <?php
        echo "<a href=\"/admin/logout\"><i class=\"fas fa-sign-out-alt botonSesionAdmin\" title=\"Cerrar Sesión\"></i></a>";
        ?>
    </header>
    <h1>Dep. Informática</h1>
    <div class="divMainSection">
        <main>
        <h2>Nueva Reserva</h2>
        <?php
        if ($_SESSION["fallo"]) {
            echo "<span class=\"spanFallo\">" . $_SESSION["fallo"] . "</span>";
            $_SESSION["fallo"] = null;
        }
        ?>
        <form action="/admin/reservas/add" method="post" style="margin-bottom: 20px;">
            <label for="select_equipo">Selecciona un equipo:</label>
            <select name="id_equipo" id="id_equipo" required>
                <?php
                foreach ($equipos as $equipo) {
                    echo "<option value=\"" . $equipo["id"] . "\">" . $equipo["codigo"] . "</option>";
                }
                ?>
            </select>
            <br>
            <label for="select_profesor">Selecciona un profesor:</label>
            <select name="id_profesor" id="id_profesor" required>
                <?php
                foreach ($profesores as $profesor) {
                    $selected = "";
                    if ($profesor["id"] ==  $_SESSION["idPerfil"]) {
                        $selected = "selected";
                    }
                    echo "<option value=\"" . $profesor["id"] . "\" $selected>" . ucfirst($profesor["nombre"]) . "</option>";
                }
                ?>
            </select>
            <br>
            <label for="observaciones">Observaciones:</label>
            <textarea name="observaciones" id="observaciones"></textarea>
            <br>
            <label for="fecha_inicio">Fecha de inicio (mínimo: día siguiente al actual):</label>
            <input type="date" name="fecha_inicio" id="fecha_inicio" min="<?php echo date('Y-m-d', strtotime('0 day')); ?>" required>
            <br>
            <label for="fecha_fin">Fecha de fin:</label>
            <input type="date" name="fecha_fin" id="fecha_fin" min="<?php echo date('Y-m-d', strtotime('+1 day')); ?>" required>
            <br><br>
            <input type="submit" name="addSubmit" value="Añadir">
            <a href="/admin/reservas/" style="background-color: #de1d1d;color: #fff;padding: 10px 20px;border: none;border-radius: 5px;cursor: pointer;font-size: 16px;">Cancelar</a>
        </form>
        </main>
        <section>
            <h2>Gestiones</h2>
            <ul>
                <li> <a href="/admin/aulas/">Gestión de aulas</a></li>
                <li> <a href="/admin/equipos/">Gestión de equipos</a></li>
                <li> <a href="/admin/alumnos/">Gestión de alumnos</a></li>
                <li> <a href="/admin/profesores/">Gestión de profesores</a></li>
                <li> <a href="/admin/grupos/">Gestión de grupos</a></li>
                <li> <a href="/admin/reservas/" id="seleccionado">Reservas</a></li>
                <li> <a href="/admin/incidencias/">Incidencias</a></li>
            </ul>
        </section>
    </div>
    <footer style="bottom: auto;">
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