<?php
$referer = $_SERVER['HTTP_REFERER'] ;


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon"
        href="https://www.iesgrancapitan.org/wp-content/uploads/sites/2/2021/06/cropped-icono_web_GranCapitan-32x32.png"
        type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="../../../css/equipo.css">
    <link rel="stylesheet" href="../../../css/footer.css">
    <title>Editar Equipo-Centro Educativo IES Gran Capitán</title>
</head>

<body>
    <header>
        <a href="https://www.iesgrancapitan.org" target="_blanck"><img
                src="https://www.iesgrancapitan.org/wp-content/uploads/sites/2/2021/06/Logo_IES_GranCapitan_header.png"
                alt=""></a>
        <a href="<?= $_SERVER['HTTP_REFERER'] ?>" title="Equipos" class="back-arrow-view">&#8592;</a>
        <?php
        echo "<a href=\"/admin/logout\"><i class=\"fas fa-sign-out-alt botonSesionAdmin\" title=\"Cerrar Sesión\"></i></a>";
        ?>
    </header>
    <h1>Dep. Informática</h1>
    <div class="divMainSection">
        <main>
            <h2>Editar Equipo</h2>
            <?php
            if ($_SESSION["fallo"]) {
                echo "<span class=\"spanFallo\">" . $_SESSION["fallo"] . "</span>";
                $_SESSION["fallo"] = null;
            }
            ?>
            <form action="/admin/equipos/edit/<?= $data["id"] ?>" method="post" enctype="multipart/form-data">
                <label>Dame el código:
                    <input type="text" name="codigo" id="codigo" value="<?= $data["codigo"] ?>" required>
                </label>
                <label>Dame una descripción:</br>
                    <textarea name="descripcion" id="descripcion" id="" required><?= $data["descripcion"] ?></textarea>
                </label>
                <label>Dame la referencia de la junta de andalucía:
                    <input type="text" name="referenciaJa" id="referenciaJa" value="<?= $data["referencia_ja"] ?>">
                    <label>Dame una imagen:
                        <input type="file" id="imagen" name="imagen">
                    </label>
                    <br>
                    <label>Selecciona un estado:
                        <select name="estado" id="estado">
                            <?php
                            foreach ($data["estados"] as $estado) {
                                echo "<option value='" . $estado["id"] . "'";
                                if ($data['estado'] === $estado["id"]) {
                                    echo " selected";
                                }
                                echo ">" . $estado["estado"] . "</option>";
                            }
                            ?>
                        </select>
                    </label>
                    <label>Selecciona el Aula:
                        <select name="aula_id" id="aula_id">
                            <?php
                            foreach ($data["aulas"] as $aula) {
                                echo "<option value='" . $aula["id"] . "'";
                                if (isset($data['ubicacion']) && $data['ubicacion']['aulas_id'] === $aula["id"]) {
                                    echo " selected";
                                }
                                echo ">" . $aula["num_aula"] . "</option>";
                            }
                            ?>
                        </select>
                    </label>

                    <label>Selecciona el Puesto:
                        <input type="number" name="puesto" id="puesto" value="<?= $data['ubicacion']['puesto'] ?? '' ?>"
                            min="1">
                    </label>

                    <input type="submit" name="editSubmit" value="Editar">
                    <a href="/admin/equipos/"
                        style="background-color: #de1d1d;color: #fff;padding: 10px 20px;border: none;border-radius: 5px;cursor: pointer;font-size: 16px;">Cancelar</a>
            </form>
            <br><br><br><br>
            <?php if (!empty($data['alumnosAsignados'])): ?>
                <h3>Alumnos Asignados:</h3>
                <ul>
                    <?php foreach ($data['alumnosAsignados'] as $alumno): ?>
                        <li>
                            <?= htmlspecialchars($alumno['nombre']) ?>
                            <form action="/admin/equipos/edit/<?= $data['id'] ?>/borrarAlumno" method="POST"
                                style="display:inline;">
                                <input type="hidden" name="alumno_id" value="<?= $alumno['id'] ?>">
                                <button type="submit" title="Eliminar" aria-label="Eliminar alumno" class="btn-eliminar">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <p>No hay alumnos asignados a este equipo.</p>
            <?php endif; ?>


            <a href="/asignarPc/pc/<?= $data['id'] ?>" class="button-style">
                Añadir alumnos</a>
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
            <a href="https://www.facebook.com/iesgrancapitan" class="social-icon"><i
                    class="fab fa-facebook-square"></i></a>
        </div>
    </footer>
</body>

</html>