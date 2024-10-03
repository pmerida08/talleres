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
        function confirmDelete(incidenciaId, numAula) {
            const confirmation = confirm("¿Estás seguro de que deseas eliminar esta incidencia?");
            if (confirmation) {
                window.location.href = "/aula/"+numAula+"/incidencias/delete/" + incidenciaId;
            }
        }
    </script>
    <style>
        table {
            width: 80%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        thead {
            background-color: #0772b9;
            color: white;
        }

        th,
        td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
    </style>
</head>

<body>
    <header>
        <a href="https://www.iesgrancapitan.org" target="_blanck"><img src="https://www.iesgrancapitan.org/wp-content/uploads/sites/2/2021/06/Logo_IES_GranCapitan_header.png" alt=""></a>
        <?php
        if ($_SESSION["perfil"] == "profesor") {
            echo "<a href=\"/admin/aulas/\" class=\"botonGestionDatos\">Gestión de Datos</a>";
            echo "<a href=\"/admin/logout\"><i class=\"fas fa-sign-out-alt botonSesionAdmin\"></i></a>";
            echo "<a href=\"/aula/". $data["idAula"] ."\" class=\"back-arrow-view arrow-incidenciaAula\">&#8592;</a>";
        } else if ($_SESSION["perfil"] == "alumno") {
            echo "<a href=\"/admin/logout\"><i class=\"fas fa-sign-out-alt botonSesionAdmin\"></i></a>";
            echo "<a style=\"right: 80px;\" href=\"/aula/". $data["idAula"] ."\" class=\"back-arrow-view arrow-incidenciaAula\">&#8592;</a>";
        } else {
            echo "<a href=\"/login/\" class=\"botonSesionAdmin\">Iniciar Sesión</a>";
            echo "<a style=\"right: 80px;\" href=\"/aula/". $data["idAula"] ."\" class=\"back-arrow-view arrow-incidenciaAula\">&#8592;</a>";
        }
        ?>
    </header>
    <h1>Dep. Informática</h1>
    <div class="divMainSection">
        <main>
            <h2>Aula <?= $data["numAula"] ?> - Incidencias</h2>
            <div class="incidencias" style="flex-direction: column;">
                <?php if ($_SESSION["perfil"] == "profesor") {?>
                <a href="/aula/<?=$data["numAula"]?>/incidencias/add">Añadir Incidencia</a>
                <?php }?>
                <table>
                    <thead>
                        <tr>
                            <th>Descripcion</th>
                            <th>Fecha de la incidencia</th>
                            <th>Fecha de la solución</th>
                            <th>Profesor encargado</th>
                            <?php
                            if ($_SESSION["perfil"] == "profesor") {
                                echo "<th></th>";
                            }
                            ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($incidencias as $key => $incidencia) {
                            echo "<tr>";
                            echo "<td>" . $incidencia["descripcion"] . "</td>";
                            $fecha = date("d/m/Y", strtotime($incidencia['fecha']));
                            $fechaSolucion = !empty($incidencia['fecha_solucion']) ? date("d/m/Y", strtotime($incidencia['fecha_solucion'])) : "No solucionado";
                            echo "<td>$fecha</td>";
                            echo "<td>$fechaSolucion</td>";
                            foreach ($profesores as $key => $profesor) {
                                if ($profesor["id"] == $incidencia["profesores_id"]) {
                                    echo "<td>" . ucfirst($profesor["nombre"]) . "</td>";
                                }
                            }
                            if ($_SESSION["perfil"] == "profesor") {
                                echo "<td><a href=\"/aula/".$data["numAula"]."/incidencias/edit/".$incidencia["id"]."\">Editar</a>
                                        <a style=\"background-color:red;\" href=\"#\" onclick=\"confirmDelete(" . $incidencia["id"] . ", '" . $data["numAula"] . "')\">Borrar</a></td>";
                            }
                            echo "</tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </main>
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