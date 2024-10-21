<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="https://www.iesgrancapitan.org/wp-content/uploads/sites/2/2021/06/cropped-icono_web_GranCapitan-32x32.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="../../../css/alumno.css">
    <link rel="stylesheet" href="../../../css/footer.css">
    <title>Editar Alumno-Centro Educativo IES Gran Capitán</title>
</head>

<body>
    <header>
        <a href="https://www.iesgrancapitan.org" target="_blanck"><img src="https://www.iesgrancapitan.org/wp-content/uploads/sites/2/2021/06/Logo_IES_GranCapitan_header.png" alt=""></a>
        <a href="/admin/alumnos/" title="Alumnos" class="back-arrow-view">&#8592;</a>       
        <?php
        echo "<a href=\"/admin/logout\"><i class=\"fas fa-sign-out-alt botonSesionAdmin\" title=\"Cerrar Sesión\"></i></a>";
        ?>
    </header>
    <h1>Dep. Informática</h1>
    <div class="divMainSection">
        <main>
        <h2>Editar Alumno</h2>
        <?php
        if ($_SESSION["fallo"]) {
            echo "<span class=\"spanFallo\">" . $_SESSION["fallo"] . "</span>";
            $_SESSION["fallo"] = null;
        }
        ?>
        <form action="/admin/alumnos/edit/<?= $data["id"] ?>" method="post" class="formAddEdit">
            <label>Escriba el nombre:<br>
                <input type="text" name="nombre" value="<?= $data["nombre"] ?>">
            </label>
            <br>
            <label>Escriba el email:<br>
                <input type="email" name="email" value="<?= $data["email"] ?>">
            </label>
            <br>
            <label>Seleccione el grupo:<br>
                <select name="grupo">
                    <option value=""></option>
                    <?php
                    foreach ($data["grupos"] as $grupo) {
                        $selected = ($grupo["id"] == $data["grupo_id"]) ? 'selected' : '';
                        echo "<option value=\"" . $grupo["id"] . "\" $selected>" . $grupo["nombre_grupo"] . "</option>";
                    }
                    ?>
                </select>
            </label>
            <br>
            <!-- <label>Escriba la contraseña:<br>
                <input type="password" name="contrasena" required>
            </label> -->
            <br>
            <!-- <label>Dar permisos para posicionar equipos:<br>
                <?php
                $selectedSi = ($data["activo"] > 0) ? 'selected' : '';
                $selectedNo = ($data["activo"] <= 0 || $data["activo"] === null) ? 'selected' : '';
                ?>
                <select name="activo">
                    <option value="1" <?php echo $selectedSi; ?>>Si</option>
                    <option value="0" <?php echo $selectedNo; ?>>No</option>
                </select>

            </label> -->
            <br>
            <input type="submit" name="editSubmit" value="Editar">
            <a href="/admin/alumnos/" style="background-color: #de1d1d;color: #fff;padding: 10px 20px;border: none;border-radius: 5px;cursor: pointer;font-size: 16px;">Cancelar</a>
        </form>
        </main>
        <section>
            <h2>Gestiones</h2>
            <ul>
                <li> <a href="/admin/aulas/">Gestión de aulas</a></li>
                <li> <a href="/admin/equipos/">Gestión de equipos</a></li>
                <li> <a href="/admin/alumnos/" id="seleccionado">Gestión de alumnos</a></li>
                <li> <a href="/admin/profesores/">Gestión de profesores</a></li>
                <li> <a href="/admin/grupos/">Gestión de grupos</a></li>
                <li> <a href="/admin/reservas/">Reservas</a></li>
                <li> <a href="/admin/incidencias/">Incidencias</a></li>
            </ul>
        </section>
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