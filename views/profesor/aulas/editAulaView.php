<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="https://www.iesgrancapitan.org/wp-content/uploads/sites/2/2021/06/cropped-icono_web_GranCapitan-32x32.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="../../../css/aula.css">
    <link rel="stylesheet" href="../../../css/footer.css">
    <title>Editar Aula-Centro Educativo IES Gran Capitán</title>
</head>

<body>
    <header>
        <a href="https://www.iesgrancapitan.org" target="_blanck"><img src="https://www.iesgrancapitan.org/wp-content/uploads/sites/2/2021/06/Logo_IES_GranCapitan_header.png" alt=""></a>
        <a href="/admin/aulas/" title="Aulas" class="back-arrow-view">&#8592;</a>       
        <?php
        echo "<a href=\"/admin/logout\"><i class=\"fas fa-sign-out-alt botonSesionAdmin\" title=\"Cerrar Sesión\"></i></a>";
        ?>
    </header>
    <h1>Dep. Informática</h1>
    <div class="divMainSection">
        <main>
        <div class="divProfIncidencias">
            <div class="divFormAddEdit">
                <h2>Editar Aula</h2>
                <?php
                if ($_SESSION["fallo"]) {
                    echo "<span class=\"spanFallo\">" . $_SESSION["fallo"] . "</span>";
                    $_SESSION["fallo"] = null;
                }
                ?>
            <form action="/admin/aulas/edit/<?= $data["id"] ?>" method="post">
    <label>Número del aula:
        <input type="number" name="numAula" id="numAula" value="<?= htmlspecialchars($data["numAula"]) ?>" required>
    </label>
    <br>
    <label>Selecciona los grupos (puede dejarse vacío):
        <?php foreach ($data["allGrupos"] as $grupo): ?>
            <input type="checkbox" name="grupo_id[]" value="<?= $grupo['id'] ?>"
                <?php if (in_array($grupo['id'], array_column($data['selectedGrupos'], 'id'))) echo 'checked'; ?>>
            <?= htmlspecialchars($grupo['nombre_grupo']) ?><br>
        <?php endforeach; ?>
    </label>
    <br>
    <label>Número de mesas:
        <input type="number" name="numMesas" id="numMesas" value="<?= htmlspecialchars($data["numMesas"]) ?>" required>
    </label>
    <br>
    <input type="submit" name="editSubmit" value="Editar">
    <a href="/admin/aulas/" class="cancel-button">Cancelar</a>
</form>



            </div>
            <div class="divIncidencias">
                <h2>Incidencias</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Equipo ID</th>
                            <th>Fecha de inicio</th>
                            <th>Fecha de solución</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            foreach ($data["incidencias"] as $key => $incidencia) {
                                echo "<tr class=\"Incidencias\">";
                                echo "<td>".$incidencia['descripcion']."</td>";
                                echo "<td>".$incidencia['fecha']."</td>";
                                echo "<td>".$incidencia['fecha_solucion']."</td>";
                                echo "<td><a href=\"/admin/incidencias/edit/".$incidencia["id"]."\">Editar</a></td>";
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