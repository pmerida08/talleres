<?php
$numero_pc = $data['numero_pc'] ?? null;
$alumnos = $data['alumnos'] ?? [];
$equipo = $data['equipo'] ?? null;
$error = $data['error'] ?? null;
$searchQuery = $data['valueInput'] ?? '';
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Asignar PC a Alumno</title>
    <link rel="stylesheet" href="/css/equipo.css">
    <link rel="stylesheet" href="/css/footer.css">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <script>
        function confirmClear() {
            return confirm("¿Estás seguro de que deseas limpiar todas las asignaciones de este PC?");
        }
    </script>
</head>

<body>
    <header>
        <a href="https://www.iesgrancapitan.org" target="_blank">
            <img src="https://www.iesgrancapitan.org/wp-content/uploads/sites/2/2021/06/Logo_IES_GranCapitan_header.png"
                alt="Logo IES Gran Capitán">
        </a>
        <a href="/admin/equipos/" title="Volver a Equipos" class="back-arrow-view">&#8592;</a>
    </header>

    <h1>Asignar PC a Alumno</h1>

    <div class="divMainSection">
        <main>
            <div class="equipos">
                <div class="equipo">
                    <div class="titulo">
                        <h2><?= htmlspecialchars($equipo["codigo"]) ?></h2>
                    </div>
                </div>
            </div>

            <?php if ($error): ?>
                <p style="color:red; text-align:center;"><?= htmlspecialchars($error) ?></p>
            <?php endif; ?>

            <div class="search-form">
                <form action="/asignarPc/pc/<?= htmlspecialchars($numero_pc) ?>" method="post">
                    <div>
                        <input type="text" name="busqueda" value="<?= htmlspecialchars($searchQuery) ?>" placeholder="Buscar alumno...">
                        <input type="submit" name="buscar" value="Buscar">
                    </div>
                </form>
            </div>

            <div class="alumnos">
                <?php if (!empty($alumnos)): ?>
                    <?php foreach ($alumnos as $alumno): ?>
                        <div class="alumno">
                            <h3><?= htmlspecialchars($alumno['nombre']) ?></h3>
                            <p><?= htmlspecialchars($alumno['email']) ?></p>
                            <form action="/asignarPc/pc/<?= htmlspecialchars($numero_pc) ?>/asignar" method="post">
                                <input type="hidden" name="alumno_id" value="<?= $alumno['id'] ?>">
                                <input type="submit" class="asignar-button" value="Asignar PC">
                            </form>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>Por favor, realiza una búsqueda.</p>
                <?php endif; ?>
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
            <a href="https://twitter.com/ies_grancapitan" class="social-icon" target="_blank">
                <i class="fab fa-twitter"></i></a>
            <a href="https://www.instagram.com/iesgrancapitan/" class="social-icon" target="_blank">
                <i class="fab fa-instagram"></i></a>
            <a href="https://www.facebook.com/iesgrancapitan" class="social-icon" target="_blank">
                <i class="fab fa-facebook-square"></i></a>
        </div>
    </footer>
</body>

</html>