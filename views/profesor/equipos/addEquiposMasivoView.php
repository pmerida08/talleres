<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Añadir Equipos en Masa - IES Gran Capitán</title>
    <link rel="icon" href="https://www.iesgrancapitan.org/wp-content/uploads/sites/2/2021/06/cropped-icono_web_GranCapitan-32x32.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="../../css/equipo.css">
    <link rel="stylesheet" href="../../css/footer.css">
</head>

<body>
    <header>
        <a href="https://www.iesgrancapitan.org" target="_blank"><img src="https://www.iesgrancapitan.org/wp-content/uploads/sites/2/2021/06/Logo_IES_GranCapitan_header.png" alt="Logo IES Gran Capitán"></a>
        <a href="/admin/equipos/" title="Equipos" class="back-arrow-view">&#8592;</a>
        <?php
        echo "<a href=\"/admin/logout\"><i class=\"fas fa-sign-out-alt botonSesionAdmin\" title=\"Cerrar Sesión\"></i></a>";
        ?>
    </header>
    <h1>Dep. Informática</h1>
    <div class="divMainSection">
        <main>
            <h2>Añadir Equipos en Masa</h2>
            <?php
            if ($_SESSION["fallo"]) {
                echo "<span class=\"spanFallo\">" . $_SESSION["fallo"] . "</span>";
                $_SESSION["fallo"] = null;
            }
            ?>
            <form action="/admin/equipos/addMasivo" method="post">
                <label>Código
                    <input type="text" name="codigo" required>
                </label>
                <br>
                <label>Descripción
                    <textarea name="descripcion" required></textarea>
                </label>
                <label>Número de equipos:
                    <input type="number" name="numeroEquipos" min="1" required>
                </label>
                <br>
                <label>Selecciona un estado:
                    <select name="estado" required>
                        <?php
                        foreach ($data["estados"] as $estado) {
                            echo "<option value=\"" . $estado["id"] . "\">" . $estado["estado"] . "</option>";
                        }
                        ?>
                    </select>
                </label>
                <br>
                <input type="submit" value="Añadir Equipos">
                <a href="/admin/equipos/" class="cancelar">Cancelar</a>
            </form>
        </main>
        <section>
            <h2>Gestiones</h2>
            <ul>
                <li> <a href="/admin/aulas/">Gestión de aulas</a></li>
                <li> <a href="/admin/equipos/" id="seleccionado">Gestión de equipos</a></li>
                <li> <a href="/admin/alumnos/">Gestión de alumnos</a></li>
                <li> <a href="/admin/profesores/">Gestión de profesores</a></li>
                <li> <a href="/admin/grupos/">Gestión de grupos</a></li>

                <li> <a href="/admin/reservas/">Reservas</a></li>
                <li> <a href="/admin/incidencias/">Incidencias</a></li>
            </ul>
        </section>
    </div>
    <footer>
        <div class="contact-info">
            IES Gran Capitán 2023 · Avda Arcos de la Frontera s/n, Córdoba (Spain) · Tel: 957379710
        </div>
        <div class="social-icons">
            <a href="https://twitter.com/ies_grancapitan" class="social-icon"><i class="fab fa-twitter"></i></a>
            <a href="https://www.iesgrancapitan.org/#top" class="social-icon"><i class="fab fa-instagram"></i></a>
            <a href="https://www.facebook.com/iesgrancapitan" class="social-icon"><i class="fab fa-facebook-square"></i></a>
        </div>
    </footer>
</body>

</html>