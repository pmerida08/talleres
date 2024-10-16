<?php
$equipos = $data["equipos"];
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Equipos - Centro Educativo IES Gran Capitán</title>
    <link rel="icon"
        href="https://www.iesgrancapitan.org/wp-content/uploads/sites/2/2021/06/cropped-icono_web_GranCapitan-32x32.png"
        type="image/x-icon">
    <link rel="stylesheet" href="/css/equipo.css">
    <link rel="stylesheet" href="/css/footer.css">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined&display=swap" />
    <script>
        function confirmDelete(equipoId) {
            const confirmation = confirm("¿Estás seguro de que deseas eliminar este equipo?");
            if (confirmation) {
                window.location.href = "/admin/equipos/delete/" + equipoId;
            }
        }

        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.equipo').forEach(function (element) {
                element.addEventListener('click', function () {
                    this.classList.toggle('active');
                });
            });
        });
    </script>
</head>

<body>
    <header>
        <a href="https://www.iesgrancapitan.org" target="_blank">
            <img src="https://www.iesgrancapitan.org/wp-content/uploads/sites/2/2021/06/Logo_IES_GranCapitan_header.png"
                 alt="Logo IES Gran Capitán">
        </a>
        <a href="/" title="Página de Inicio" class="back-arrow-view">&#8592;</a>
        <?php
        echo "<a href=\"/admin/logout\"><i class=\"fas fa-sign-out-alt botonSesionAdmin\" title=\"Cerrar Sesión\"></i></a>";
        ?>
    </header>
    <h1>Dep. Informática</h1>
    <div class="divMainSection">
        <main>
            <h2>Equipos</h2>
            <div class="divbusquedaExportarImportar">
                <form action="/admin/equipos/" method="post">
                    <div style="display: flex; align-items: center;">
                        <input type="text" name="busqueda"
                            value="<?php echo isset($data["valueInput"]) ? htmlspecialchars($data["valueInput"]) : ""; ?>">
                        <input type="submit" name="buscar" value="Buscar">
                        <a href="/admin/equipos/add" class="button-style">+</a>
                        <a href="/admin/equipos/addMasivo" class="button-style">Añadir PC en masa</a>
                    </div>
                </form>
            </div>

            <div class="equipos">
                <?php
                foreach ($equipos as $equipo) {
                    $css = "";
                    foreach ($data["estados"] as $estado) {
                        if ($equipo["t_estados_id"] == $estado["id"]) {
                            $css = $estado["css"];
                        }
                    }
                    echo "<div class=\"equipo\" style=\"" . htmlspecialchars($css) . "\">";
                    echo "<div class=\"titulo\">";
                    echo "<h3>" . htmlspecialchars($equipo["codigo"]) . "</h3>";
                    echo "<div class=\"deleteEdit\">";
                    echo "<a href=\"/admin/equipos/edit/" . $equipo["id"] . "\"><span class=\"material-symbols-outlined edit\" title=\"Editar\">edit</span></a>";
                    echo "<a href=\"#\" onclick=\"confirmDelete(" . $equipo['id'] . ")\"><span class=\"material-symbols-outlined del\" title=\"Eliminar\">delete</span></a>";
                    echo "</div>";
                    echo "</div>";
                    
                    echo "<p>" . htmlspecialchars($equipo["descripcion"]) . "</p>";
                    
                    $existeUbicacion = false;
                    foreach ($data["ubicaciones"] as $ubicacion) {
                        if ($ubicacion["equipos_id"] == $equipo["id"]) {
                            foreach ($data["aulas"] as $aula) {
                                if ($aula["id"] == $ubicacion["aulas_id"]) {
                                    echo "<p>Ubicación: Aula " . htmlspecialchars($aula["num_aula"]) . "</p>";
                                    $existeUbicacion = true;
                                    break;
                                }
                            }
                            if ($existeUbicacion) {
                                break;
                            }
                        }
                    }
                    if (!$existeUbicacion) {
                        echo "<p>Ubicación: No asignada</p>";
                    }

                    if ($equipo["referencia_ja"]) {
                        echo "<p>Referencia Junta Andalucía: <i>" . htmlspecialchars($equipo["referencia_ja"]) . "</i></p>";
                    } else {
                        echo "<p>Referencia: No hay referencia</p>";
                    }

                    echo "<div class=\"contenido-oculto\">";
                    echo "<div style=\"display:flex; flex-direction: column; align-items: flex-start; padding:10px\">";

                    if (!empty($equipo['alumnos'])) {
                        $nombres = array_map(function ($alumno) {
                            return $alumno['nombre'];
                        }, $equipo['alumnos']);

                        $nombresString = implode(', ', $nombres);

                        echo "<p><strong>Alumnos asignados:</strong> " . htmlspecialchars($nombresString) . "</p>";
                    } else {
                        echo "<p>Alumnos asignados: Ninguno</p>";
                    }

                    if ($equipo["imagen"]) {
                        echo "<img src=\"/imagenes/" . htmlspecialchars($equipo["imagen"]) . "\" alt=\"Imagen del equipo\" style=\"height: 100px; width: auto; margin-top: 10px;\">";
                    } else {
                        echo "<p>Imagen: No hay imagen disponible</p>";
                    }

                    echo "</div>";
                    echo "</div>";
                    echo "</div>";
                }
                ?>
            </div>
        </main>
        <section>
            <h2>Gestiones</h2>
            <ul>
                <li><a href="/admin/aulas/">Gestión de aulas</a></li>
                <li><a href="/admin/equipos/" id="seleccionado">Gestión de equipos</a></li>
                <li><a href="/admin/alumnos/">Gestión de alumnos</a></li>
                <li><a href="/admin/profesores/">Gestión de profesores</a></li>
                <li><a href="/admin/grupos/">Gestión de grupos</a></li>
                <li><a href="/admin/reservas/">Reservas</a></li>
                <li><a href="/admin/incidencias/">Incidencias</a></li>
            </ul>
        </section>
    </div>
    <footer>
        <div class="contact-info">
            IES Gran Capitán 2023 · Avda Arcos de la Frontera s/n, Córdoba (Spain) · Tel: 957379710
        </div>
        <div class="social-icons">
            <a href="https://twitter.com/ies_grancapitan" class="social-icon" target="_blank"><i class="fab fa-twitter"></i></a>
            <a href="https://www.instagram.com/iesgrancapitan/" class="social-icon" target="_blank"><i class="fab fa-instagram"></i></a>
            <a href="https://www.facebook.com/iesgrancapitan" class="social-icon" target="_blank"><i
                    class="fab fa-facebook-square"></i></a>
        </div>
    </footer>
</body>

</html>
