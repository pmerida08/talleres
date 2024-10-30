<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon"
        href="https://www.iesgrancapitan.org/wp-content/uploads/sites/2/2021/06/cropped-icono_web_GranCapitan-32x32.png"
        type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="../../../css/grupo.css">
    <link rel="stylesheet" href="../../../css/footer.css">
    <title>Editar Grupo-Centro Educativo IES Gran Capitán</title>
</head>

<body>
    <header>
        <a href="https://www.iesgrancapitan.org" target="_blanck"><img
                src="https://www.iesgrancapitan.org/wp-content/uploads/sites/2/2021/06/Logo_IES_GranCapitan_header.png"
                alt=""></a>
        <a href="/admin/grupos/" title="Grupos" class="back-arrow-view">&#8592;</a>
        <?php
        echo "<a href=\"/admin/logout\"><i class=\"fas fa-sign-out-alt botonSesionAdmin\" title=\"Cerrar Sesión\"></i></a>";
        ?>
    </header>
    <h1>Dep. Informática</h1>
    <div class="divMainSection">
        <main>
            <h2>Editar Grupo</h2>
            <?php
            if ($_SESSION["fallo"]) {
                echo "<span class=\"spanFallo\">" . $_SESSION["fallo"] . "</span>";
                $_SESSION["fallo"] = null;
            }
            ?>
            <form action="/admin/grupos/edit/<?= $data["id"] ?>" method="post">
                <label>Dame el nombre del grupo:
                    <input type="text" name="nombre_grupo" id="nombre_grupo" value="<?= $data["nombre_grupo"] ?>"
                        required>
                </label>


                <label>Selecciona un aula: <br>
                    <select name="aula" id="aula">
                        <?php foreach ($data["aulas"] as $aula): ?>
                            <option value="<?= htmlspecialchars($aula['id']); ?>" <?= ($data["aulaId"] === $aula['id']) ? 'selected' : ''; ?>>
                                <?= htmlspecialchars($aula['num_aula']); ?>
                            </option>
                        <?php endforeach; ?>
                        <option value=""></option>
                    </select>


                </label>

                <input type="submit" name="editSubmit" value="Editar">
                <a href="/admin/grupos/"
                    style="background-color: #de1d1d;color: #fff;padding: 10px 20px;border: none;border-radius: 5px;cursor: pointer;font-size: 16px;">Cancelar</a>
            </form>
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
        <p>© 2021 IES Gran Capitán</p>
    </footer>
</body>