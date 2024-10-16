<?php
$grupos = $data["grupos"];
$aulas = $data["aulas"];
$aulasGrupos = $data["aulasGrupos"];


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Pablo">
    <link rel="icon" href="https://www.iesgrancapitan.org/wp-content/uploads/sites/2/2021/06/cropped-icono_web_GranCapitan-32x32.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <title>Equipos-Centro Educativo IES Gran Capitán</title>
    <link rel="stylesheet" href="../../css/grupo.css">
    <link rel="stylesheet" href="../../css/footer.css">
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
            <h2>Grupos</h2>
            <div class="divbusquedaExportarImportar">
                <form action="/admin/grupos/" method="post">
                    <div>
                        <input type="text" name="busqueda" value="<?php echo isset($data["valueInput"]) ? $data["valueInput"] : ""; ?>">
                        <input type="submit" name="buscar" value="Buscar">
                    </div>
                </form>

                <a href="/admin/grupos/add" class="enlaceAdd">Añadir Grupo</a>

            </div>
            <div class="grupos">
                <?php
                foreach ($grupos as $key => $grupo) {
                    $css = "";
                ?>
                    <div class="grupo">
                        <div class="grupo-header">
                            <h3><?php echo $grupo["nombre_grupo"]; ?></h3>
                            <div class="grupo-header-buttons">
                                <a href="/admin/grupos/edit/<?php echo $grupo["id"]; ?>" title="Editar">
                                    <span class="material-symbols-outlined edit">edit</span>
                                </a>
                                <a href="javascript:confirmDelete(<?php echo $grupo["id"]; ?>)" title="Eliminar"><span class="material-symbols-outlined del">delete</span></a>
                            </div>
                        </div>
                        <div class="grupo-body">
                            <?php
                            foreach ($aulasGrupos as $k) {
                                if ($k["grupo_id"] == $grupo["id"]) {
                                    foreach ($aulas as $a) {
                                        if ($a["id"] == $k["aula_id"]) {
                                            echo "<p>Aula: " . $a["num_aula"] . "</p>";
                                        }
                                    }
                                }
                            }
                            ?>
                        </div>
                    </div>
                <?php
                }
                ?>
            </div>
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