<?php
$grupos = [];
foreach ($data["grupos"] as $grupo) {
    $grupos[] = $grupo["nombre_grupo"];
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aula <?= $data["numAula"] ?>-Centro Educativo IES Gran Capitán</title>
    <link rel="icon" href="https://www.iesgrancapitan.org/wp-content/uploads/sites/2/2021/06/cropped-icono_web_GranCapitan-32x32.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <script src="../script/aulaView.js"></script>
    <link rel="stylesheet" href="../css/aula.css">
    <link rel="stylesheet" href="../css/footer.css">
    <style>
        #mesasAlumnos {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            flex-direction: row;
        }
    </style>
</head>

<body>
    <header>
        <a href="https://www.iesgrancapitan.org" target="_blanck"><img src="https://www.iesgrancapitan.org/wp-content/uploads/sites/2/2021/06/Logo_IES_GranCapitan_header.png" alt=""></a>
        <?php
        if ($_SESSION["perfil"] == "profesor") {
            echo "<a href=\"/aula/" . $data["numAula"] . "/incidencias\" class=\"botonVerIncidencias\">Ver incidencias</a>";
            echo "<a href=\"/admin/aulas/\" class=\"botonGestionDatos\">Gestión de Datos</a>";
            echo "<a href=\"/admin/logout\"><i class=\"fas fa-sign-out-alt botonSesionAdmin\"></i></a>";
            echo "<a href=\"" . $_SERVER['HTTP_REFERER'] . "\" class=\"back-arrow-view\" title=\"Página de Inicio\" style=\"right: 420px;\">&#8592;</a>";
        } else if ($_SESSION["perfil"] == "alumno") {
            echo "<a href=\"/aula/" . $data["numAula"] . "/incidencias\" class=\"botonVerIncidenciasAlumno\">Ver incidencias</a>";
            echo "<a href=\"/admin/logout\"><i class=\"fas fa-sign-out-alt botonSesionAdmin\"></i></a>";
            echo "<a href=\"" . $_SERVER['HTTP_REFERER'] . "\" class=\"back-arrow-view\" title=\"Página de Inicio\" style=\"right: 420px;\">&#8592;</a>";
        } else {
            echo "<a href=\"/aula/" . $data["numAula"] . "/incidencias\" class=\"botonVerIncidenciasInvitado\">Ver incidencias</a>";
            echo "<a href=\"/login/\" class=\"botonSesionAdmin\">Iniciar Sesión</a>";
            echo "<a href=\"" . $_SERVER['HTTP_REFERER'] . "\" class=\"back-arrow-view\" title=\"Página de Inicio\" style=\"right: 420px;\">&#8592;</a>";
        }
        ?>
    </header>
    <h1>Dep. Informática</h1>
    <h2>Aula <?= $data["numAula"] ?><?php echo $grupos ? " - " . implode(", ", $grupos) : ''; ?></h2>
    <div class="divMainSection">
        <div id="aula">

            <div id="mesasAlumnos">
                <?php
                $contadorPuestos = 0;
                for ($puesto = 1; $puesto <= $data["numMesas"] * 2; $puesto++) {
                    $css = "";
                    if ($contadorPuestos / 2 == 4) {
                        if ($data["numMesas"] % 4 != 0) {
                            for ($i = $data["numMesas"] % 4; $i < 4; $i++) {
                                echo "<div style=\"flex: 20%;\">";
                                echo "</div>";
                            }
                        }
                    }
                    if ($contadorPuestos % 2 === 0) {
                        echo "<div class= \"tituloMesa\">";
                        echo "<h4 style=\"margin: 10px 0 0 0;\">Mesa " . ($puesto + 1) / 2 . "</h4>";
                        echo "<div class=\"mesa\" style=\"display:flex;\">";
                    }
                    foreach ($data["equipos"] as $equipo) {
                        if (!empty($data["ubicaciones"])) {
                            foreach ($data["ubicaciones"] as $ubicacion) {
                                if ($ubicacion['puesto'] == $puesto) {
                                    if ($ubicacion['equipos_id'] == $equipo['id']) {
                                        foreach ($data["estadosEquipos"] as $estadoEquipo) {
                                            if ($equipo["t_estados_id"] == $estadoEquipo["id"]) {
                                                $css = $estadoEquipo["css"];
                                                break;
                                            }
                                        }
                                    }
                                    break;
                                }
                            }
                        }
                    }
                    echo "<div class=\"puesto\" style=\"$css\">";
                    echo "<form action=\"/admin/ubicacion/change\" method=\"post\" class=\"formClaseEquipo\">";
                    if ($_SESSION["perfil"] != "invitado") { ?>
                        <select class="equipo" name="equipos_id">
                        <?php
                    } else {
                        echo "<select class=\"equipo\" name=\"equipos_id\" disabled title=\"" . $info . "\">"; // TODO
                    }
                    echo '<option value=""></option>';
                    $descripcion = "";
                    $editar = "";
                    foreach ($data["equipos"] as $key => $equipo) {
                        $info = "Equipo: " . $equipo["codigo"] . ", Referencia Junta And: " . $equipo["referencia_ja"] . ", Descripción: " . $equipo["descripcion"] . ", Estado: " . $data["estadosEquipos"][$equipo["t_estados_id"]]["estado"];
                        $selected = '';
                        if (!empty($data["ubicaciones"])) {
                            foreach ($data["ubicaciones"] as $ubicacion) {
                                if ($ubicacion['puesto'] == $puesto) {
                                    if ($ubicacion['equipos_id'] == $equipo['id']) {
                                        $selected = 'selected';

                                        $editar = "<a href=\"/admin/equipos/edit/" . $equipo["id"] . "\"><span class=\"material-symbols-outlined edit\">edit</span></a>";
                                    }
                                    break;
                                }
                            }
                        }
                        echo '<option value="' . $equipo['id'] . '" ' . $selected . ' title="' . $info . '">' . $equipo['codigo'] . '</option>';
                    }
                        ?>
                        </select>
                        <input type="hidden" name="puesto" value="<?= $puesto ?>">
                        <input type="hidden" name="idAula" value="<?= $data["idAula"] ?>">

                        <?php
                        if ($_SESSION["perfil"] == "profesor") {
                            echo $editar;
                        }
                        ?>

                    <?php
                    echo "</form>";
                    echo "</div>";

                    if ($contadorPuestos % 2 === 1 || $puesto === $data["numMesas"] * 2) {
                        echo "</div>";
                        echo "</div>";
                    }

                    $contadorPuestos++;
                }
                    ?>
            </div>
        </div>
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