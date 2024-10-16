<?php
$incidencias = $data["incidencias"];
$profesores = $data["profesores"];
$aulas = $data["aulas"];
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
    <link rel="stylesheet" href="../../css/incidencia.css">
    <link rel="stylesheet" href="../../css/footer.css">
    <title>Incidencias-Centro Educativo IES Gran Capitán</title>
    <script>
        function confirmDelete(incidenciaId) {
            const confirmation = confirm("¿Estás seguro de que deseas eliminar esta incidencia?");
            if (confirmation) {
                window.location.href = "/admin/incidencias/delete/" + incidenciaId;
            }
        }
    </script>
</head>

<body>
    <header>
        <a href="https://www.iesgrancapitan.org" target="_blanck"><img src="https://www.iesgrancapitan.org/wp-content/uploads/sites/2/2021/06/Logo_IES_GranCapitan_header.png" alt=""></a>
        <a href="/" class="back-arrow-view">&#8592;</a>
        <a href="/" title="Página de Inicio" class="back-arrow-view">&#8592;</a>       
        <?php
        echo "<a href=\"/admin/logout\"><i class=\"fas fa-sign-out-alt botonSesionAdmin\" title=\"Cerrar Sesión\"></i></a>";
        ?>
    </header>
    <h1>Dep. Informática</h1>
    <div class="divMainSection">
        <main>
            <h2>Incidencias</h2>
            <div class="incidencias">
                <?php
                foreach ($incidencias as $key => $incidencia) {
                    echo "<div class=\"incidencia\">";
                    echo "<div class= \"titulo\">";
                    foreach ($aulas as $key => $aula) {
                        if ($aula["id"] == $incidencia["aulas_id"]) {
                            echo "<h3>Aula afectada: " . $aula["num_aula"] . "</h3>";
                        }
                    }
                    echo "<div class= \"deleteEdit\">";
                    echo "<a href=\"/admin/incidencias/edit/" . $incidencia["id"] . "\"><span class=\"material-symbols-outlined edit\">edit</span></a>";
                    echo "<a href=\"#\" onclick=\"confirmDelete(" . $incidencia['id'] . ")\"><span class=\"material-symbols-outlined del\">delete</span></a>";
                    echo "</div>";
                    echo "</div>";
                    echo "<p>Descripcion: " . $incidencia["descripcion"] . "</p>";
                    $fecha = date("d/m/Y", strtotime($incidencia['fecha']));
                    $fechaSolucion = !empty($incidencia['fecha_solucion']) ? date("d/m/Y", strtotime($incidencia['fecha_solucion'])) : "No solucionado";
                    echo "<p>Fecha de la incidencia: $fecha</p>";
                    echo "<p>Fecha de la solución: $fechaSolucion</p>";
                    foreach ($profesores as $key => $profesor) {
                        if ($profesor["id"] == $incidencia["profesores_id"]) {
                            echo "<p>Profesor encargado: " . ucfirst($profesor["nombre"]) . "</p>";
                        }
                    }
                    echo "</div>";
                }
                ?>
            </div>
            <?php
            echo "<a href=\"/admin/incidencias/add\" class= \"enlaceAdd\">+</a>";
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
                <li> <a href="/admin/reservas/">Reservas</a></li>
                <li> <a href="/admin/incidencias/" id="seleccionado">Incidencias</a></li>
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