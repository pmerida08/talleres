<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="https://www.iesgrancapitan.org/wp-content/uploads/sites/2/2021/06/cropped-icono_web_GranCapitan-32x32.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="../../../css/profesor.css">
    <script src="../../../script/logIn.js "></script>
    <link rel="stylesheet" href="../../../css/footer.css">
    <title>Editar Profesor-Centro Educativo IES Gran Capitán</title>
</head>

<body>
    <header>
        <a href="https://www.iesgrancapitan.org" target="_blanck"><img src="https://www.iesgrancapitan.org/wp-content/uploads/sites/2/2021/06/Logo_IES_GranCapitan_header.png" alt=""></a>
        <a href="/admin/profesores/" title="Profesores" class="back-arrow-view">&#8592;</a>
        <?php
        echo "<a href=\"/admin/logout\"><i class=\"fas fa-sign-out-alt botonSesionAdmin\" title=\"Cerrar Sesión\"></i></a>";
        ?>
    </header>
    <h1>Dep. Informática</h1>
    <div class="divMainSection">
        <main>
        <div class="divProfReservas">
            <div class="divFormAddEdit">
                <h2>Editar Profesor</h2>
                <?php
                if ($_SESSION["fallo"]) {
                    echo "<span class=\"spanFallo\">" . $_SESSION["fallo"] . "</span>";
                    $_SESSION["fallo"] = null;
                }
                ?>
                <form action="/admin/profesores/edit/<?= $data["id"] ?>" method="post" class="formAddEdit">
                    <label>Escriba el nombre:<br>
                        <input type="text" style="width: 100%;" name="nombre" value="<?= $data["nombre"] ?>">
                    </label>
                    <br>
                    <label>Escriba el email:<br>
                        <input type="email" style="width: 100%;" name="email" value="<?= $data["email"] ?>">
                    </label>
                    <br>
                    <label for="password">Contraseña:</label>
                    <div class="password-container" style="width: 100%;">
                        <input type="password" style="width: 100%;" id="password" name="contrasena" required>
                        <span id="toggle-password" class="toggle-password">👁️</span>
                    </div>
                    <br>
                    <input type="submit" name="editSubmit" value="Editar">
                    <a href="/admin/profesores/" style="background-color: #de1d1d;color: #fff;padding: 10px 20px;border: none;border-radius: 5px;cursor: pointer;font-size: 16px;">Cancelar</a>
                </form>      
            </div>
            <div class="divReservas">
                <h2>Reservas</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Equipo ID</th>
                            <th>Fecha de inicio</th>
                            <th>Fecha final</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            foreach ($data["reservas"] as $key => $reserva) {
                                echo "<tr class=\"reserva\">";
                                foreach ($data["equipos"] as $key => $equipo) {
                                    if ($equipo["id"] == $reserva['equipos_id']) {
                                        echo "<td>".$equipo["codigo"]."</td>";
                                    }
                                }
                                echo "<td>".$reserva['fecha_inicio']."</td>";
                                echo "<td>".$reserva['fecha_final']."</td>";
                                echo "<td><a href=\"/admin/reservas/edit/".$reserva["id"]."\">Editar</a></td>";
                                echo "</tr>";
                            }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
        </main>
        <section>
            <h2>Gestiones</h2>
            <ul>
                <li> <a href="/admin/aulas/">Gestión de aulas</a></li>
                <li> <a href="/admin/equipos/">Gestión de equipos</a></li>
                <li> <a href="/admin/alumnos/">Gestión de alumnos</a></li>
                <li> <a href="/admin/profesores/" id="seleccionado">Gestión de profesores</a></li>
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