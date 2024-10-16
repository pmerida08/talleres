<?php
$alumnos = $data["alumnos"];
$grupos = $data["grupos"];

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Andres">
    <link rel="icon" href="https://www.iesgrancapitan.org/wp-content/uploads/sites/2/2021/06/cropped-icono_web_GranCapitan-32x32.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-FAi8qMrqe5W10ZjKsj0xM8zqlv2FsHu0zjZ1dOYrX0QCG1dX/njHnXe1cNpjPq3jnl6mODWto9jM7o5GHgO9tw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="../../css/alumno.css">
    <link rel="stylesheet" href="../../css/footer.css">
    <title>Alumnos-Centro Educativo IES Gran Capitán</title>
    <script>
        function confirmDelete(alumnoId) {
            const confirmation = confirm("¿Estás seguro de que deseas eliminar este alumno?");
            if (confirmation) {
                window.location.href = "/admin/alumnos/delete/" + alumnoId;
            }
        }

        function mostrarInputFile() {
            document.getElementById('formArchivo').style.display = 'block';
        }

        function submitForm() {
            document.getElementById('formArchivo').submit();
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
            <h2 class="subtitulo">Alumnos</h2>
            <div class="divbusquedaExportarImportar">
                <form action="/admin/alumnos/" method="post">
                    <div>
                        <input type="text" name="busqueda" value="<?php echo isset($data["valueInput"]) ? $data["valueInput"] : ""; ?>">
                        <input type="submit" name="buscar" value="Buscar">
                    </div>
                </form>
                <a href="/admin/alumnos/exportar/">
                    <i class="fas fa-file-export"></i>
                    Exportar
                </a>
                <a href="#" onclick="mostrarInputFile()">
                    <i class="fas fa-file-import"></i>
                    Importar
                </a>

                <form id="formArchivo" action="/admin/alumnos/importar/" method="post" enctype="multipart/form-data" style="display: none;">
                    <input type="file" id="archivoCvs" name="archivoCvs" onchange="submitForm()">
                </form>
            </div>
            <div class="alumnos">
                <?php
                foreach ($alumnos as $key => $alumno) {
                    echo "<div class=\"alumno\">";
                    echo "<div class= \"titulo\">";
                    echo "<h2>" . ucfirst($alumno["nombre"]) . "</h2>";
                    echo "<div class= \"deleteEdit\">";
                    echo "<a href=\"/admin/alumnos/edit/" . $alumno["id"] . "\"><span class=\"material-symbols-outlined edit\">edit</span></a>";
                    echo "<a href=\"#\" onclick=\"confirmDelete(" . $alumno["id"] . ")\"><span class=\"material-symbols-outlined del\">delete</span></a>";
                    echo "</div>";
                    echo "</div>";
                    echo "<p>" . $alumno["email"] . "</p>";
                    foreach ($grupos as $grupo) {
                        if ($grupo["id"] == $alumno["grupo_id"]) {
                            echo "<p>Grupo: " . $grupo["nombre_grupo"] . "</p>";
                        }
                    }
                    echo "</div>";
                }
                ?>
            </div>
            <?php
            echo "<a href=\"/admin/alumnos/add\" class= \"enlaceAdd\">+</a>";
            ?>
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