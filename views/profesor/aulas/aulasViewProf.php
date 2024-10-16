<?php
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
    <link rel="stylesheet" href="../../css/aula.css">
    <link rel="stylesheet" href="../../css/footer.css">
    <title>Aulas-Centro Educativo IES Gran Capitán</title>
    <script>
        function confirmDelete(aulaId) {
            const confirmation = confirm("¿Estás seguro de que deseas eliminar este aula?");
            if (confirmation) {
                window.location.href = "/admin/aulas/delete/" + aulaId;
            }
        }
    </script>
</head>

<body>
    <header>
        <a href="https://www.iesgrancapitan.org" target="_blanck"><img src="https://www.iesgrancapitan.org/wp-content/uploads/sites/2/2021/06/Logo_IES_GranCapitan_header.png" alt=""></a>
        <a href="/" class="back-arrow-view" title="Página de Inicio">&#8592;</a>
        <?php
        echo "<a href=\"/admin/logout\"><i class=\"fas fa-sign-out-alt botonSesionAdmin\" title=\"Cerrar Sesión\"></i></a>";
        ?>
    </header>
    <h1>Dep. Informática</h1>
    <div class="divMainSection">
        <main>
            <h2 class="subtitulo">Aulas</h2>
            <div class="acciones">
                <a href="/admin/aulas/add">Añadir aula</a>
            </div>
            <div class="aulas">
                <?php
                foreach ($aulas as $aula) {
                    $grupos = $aula["grupos"];

                    echo "<div class=\"aula\">";
                    echo "<div class=\"titulo\">";
                    echo "<h2>" . $aula["num_aula"] . "</h2>";
                    echo "<div class=\"deleteEdit\">";
                    echo "<a href='/aula/" . $aula["id"] . "' class='aula-link'>";
                    echo "<span class=\"material-symbols-outlined view\">visibility</span>";
                    echo "</a>";
                    echo "<a href='/admin/aulas/edit/" . $aula["id"] . "' class='aula-link'>";
                    echo "<span class=\"material-symbols-outlined edit\">edit</span>";
                    echo "</a>";
                    echo "<span class=\"material-symbols-outlined del\" onclick=\"confirmDelete(" . $aula["id"] . ")\">delete</span>";
                    echo "</div>";
                    echo "</div>";

                    echo "<p><strong>Grupos Asignados:</strong> ";
                    if (!empty($grupos)) {
                        $gruposNombre = [];
                        foreach ($grupos as $grupo) {
                            $gruposNombre[] = $grupo["nombre_grupo"];
                        }
                        echo "<span class=\"grupo\">" . implode(", ", $gruposNombre) . "</span>";
                    } else {
                        echo "No hay grupos asignados.";
                    }
                    echo "</p>";

                    echo "</div>";
                }
                ?>
            </div>
        </main>
        <section>
            <h2>Gestiones</h2>
            <ul>
                <li> <a href="/admin/aulas/" id="seleccionado">Gestión de aulas</a></li>
                <li> <a href="/admin/equipos/">Gestión de equipos</a></li>
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