<?php
$reservas = $data["reservas"];
$profesores = $data["profesores"];
$equipos = $data["equipos"];
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Andres">
    <link rel="icon" href="https://www.iesgrancapitan.org/wp-content/uploads/sites/2/2021/06/cropped-icono_web_GranCapitan-32x32.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="../../css/reserva.css">
    <link rel="stylesheet" href="../../css/footer.css">
    <title>Reservas-Centro Educativo IES Gran Capitán</title>
    <script>
        function confirmDelete(reservaId) {
            const confirmation = confirm("¿Estás seguro de que deseas eliminar esta reserva?");
            if (confirmation) {
                window.location.href = "/admin/reservas/delete/" + reservaId;
            }
        }
    </script>
</head>

<body>
    <header>
        <a href="https://www.iesgrancapitan.org" target="_blanck"><img src="https://www.iesgrancapitan.org/wp-content/uploads/sites/2/2021/06/Logo_IES_GranCapitan_header.png" alt=""></a>
        <a href="/" title="Página de Inicio" class="back-arrow-view">&#8592;</a>
        <?php
        echo "<a href=\"/admin/logout\"><i class=\"fas fa-sign-out-alt botonSesionAdmin\" title=\"Cerrar Sesión\"></i></a>";
        ?>
    </header>
    <h1>Dep. Informática</h1>
    <div class="divMainSection">
        <main>
            <h2 class="subtitulo">Reservas</h2>
            <div>
                <form action="/admin/reservas/" method="post" class="formBuscar">
                    <div>
                        <input type="text" name="busqueda" placeholder="Nombre del profesor" value="<?php echo isset($data["valueInput"]) ? $data["valueInput"] : ""; ?>">
                        <input type="submit" name="buscar" value="Buscar">
                    </div>
                </form>
            </div>
            <div class="reservas">
                <?php
                foreach ($reservas as $key => $reserva) {
                    $profesorName = "";
                    $equipoName = "";
                    foreach ($profesores as $key => $profesor) {
                        if ($profesor["id"] == $reserva["profesores_id"]) {
                            $profesorName = $profesor["nombre"];
                        }
                    }
                    foreach ($equipos as $key => $equipo) {
                        if ($equipo["id"] == $reserva["equipos_id"]) {
                            $equipoName = $equipo["codigo"];
                        }
                    }
                    echo "<div class=\"reserva\">";
                    echo "<div class= \"titulo\">";
                    echo "<h2 style=\"margin: 5px 0 0 0;\">Cod. de equipo: " . $equipoName . "</h2>";
                    echo "<div class= \"deleteEdit\">";
                    echo "<a href=\"/admin/reservas/edit/" . $reserva["id"] . "\"><span class=\"material-symbols-outlined edit\">edit</span></a>";
                    echo "<a href=\"#\" onclick=\"confirmDelete(" . $reserva["id"] . ")\"><span class=\"material-symbols-outlined del\">delete</span></a>";
                    echo "</div>";
                    echo "</div>";
                    echo "<p>".$reserva["observaciones"]."</p>";
                    $fecha_inicio = date("d/m/Y", strtotime($reserva['fecha_inicio']));
                    $fecha_final = date("d/m/Y", strtotime($reserva['fecha_final']));
                    echo "<p>Fecha de inicio: $fecha_inicio</p>";
                    echo "<p>Fecha final: $fecha_final</p>";
                    echo "<p>Reserva de: " . ucfirst($profesorName) . "</p>";
                    echo "</div>";
                }
                ?>
            </div>
            <?php
            echo "<a href=\"/admin/reservas/add\" class= \"enlaceAdd\">+</a>";
            ?>
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