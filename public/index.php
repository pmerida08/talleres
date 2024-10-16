<?php
require_once "../vendor/autoload.php";
require_once "../bootstrap.php";

use App\Core\Router;
use App\Controllers\AulasController;
use App\Controllers\AdminController;
use App\Controllers\AlumnosController;
use App\Controllers\EquiposController;
use App\Controllers\UbicacionController;
use App\Controllers\ReservasController;
use App\Controllers\IncidenciasController;
use App\Controllers\ProfesoresController;
use App\Controllers\GruposController;

session_start();

if (!isset($_SESSION['perfil'])) {
    $_SESSION['perfil'] = "invitado";
}
if (!isset($_SESSION["fallo"])) {
    $_SESSION["fallo"] = null;
}

$router = new Router();

// Aulas
$router->add(
    array(
        "name" => "home",
        "path" => "/^\/$/",
        "action" => [AulasController::class, "mostrarAulas"],
        "auth" => ["profesor", "alumno", "invitado"]
    )
);

$router->add([
    'name' => 'Editar Aula',
    'path' => '/^\/admin\/aulas\/edit\/\d*$/',
    'action' => [AulasController::class, 'editAula'],
    "auth" => ["profesor"]
]);

$router->add([
    'name' => 'Añadir Aula',
    'path' => '/^\/admin\/aulas\/add$/',
    'action' => [AulasController::class, 'addAula'],
    "auth" => ["profesor"]
]);

$router->add([
    'name' => 'Borrar Aula',
    'path' => '/^\/admin\/aulas\/delete\/\d*$/',
    'action' => [AulasController::class, 'deleteAula'],
    "auth" => ["profesor"]
]);

$router->add([
    'name' => 'Mostrar clase con equipos',
    'path' => '/^\/aula\/\d*$/',
    'action' => [AulasController::class, 'equipoAulaView'],
    "auth" => ["profesor", "alumno", "invitado"]
]);

// Admin

$router->add(
    array(
        "name" => "AdminView",
        "path" => "/^\/admin\/aulas\/$/",
        "action" => [AulasController::class, "adminViewAulas"],
        "auth" => ["profesor"]
    )
);

$router->add(
    array(
        "name" => "AdminSesion",
        "path" => "/^\/login\/(\?.+)?$/",
        "action" => [AdminController::class, "adminLogIn"],
        "auth" => ["invitado"]
    )
);

$router->add(
    array(
        "name" => "AdminCerrarSesion",
        "path" => "/^\/admin\/logout$/",
        "action" => [AdminController::class, "adminLogOut"],
        "auth" => ["profesor", "alumno"]
    )
);

$router->add(
    array(
        "name" => "home",
        "path" => "/^\/admin\/equipos\/$/",
        "action" => [EquiposController::class, "adminViewEquipos"],
        "auth" => ["profesor"]
    )
);

// Equipos

$router->add([
    'name' => 'Editar equipo',
    'path' => '/^\/admin\/equipos\/edit\/\d*$/',
    'action' => [EquiposController::class, 'editEquipo'],
    "auth" => ["profesor"]
]);

$router->add([
    'name' => 'Añadir equipo',
    'path' => '/^\/admin\/equipos\/add$/',
    'action' => [EquiposController::class, 'addEquipo'],
    "auth" => ["profesor"]
]);

$router->add([
    'name' => 'Borrar equipo',
    'path' => '/^\/admin\/equipos\/delete\/\d*$/',
    'action' => [EquiposController::class, 'deleteEquipo'],
    "auth" => ["profesor"]
]);

// Ubicacion
$router->add([
    'name' => 'Cambiar ubicación del equipo',
    'path' => '/^\/admin\/ubicacion\/change$/',
    'action' => [UbicacionController::class, 'ubicacionChage'],
    "auth" => ["profesor", "alumno"]
]);

$router->add([
    'name' => 'Añadir equipo en masa',
    'path' => '/^\/admin\/equipos\/addMasivo$/',
    'action' => [EquiposController::class, 'addMasivaEquipos'],
    "auth" => ["profesor"]
]);

$router->add([
    'name' => 'Mostrar Formulario Asignación de PC',
    'path' => '/^\/asignarPc\/pc\/(\d+)$/',
    'action' => [EquiposController::class, 'mostrarFormularioAsignacion'],
    'auth' => ['profesor']
]);

$router->add([
    'name' => 'Borrar Alumno de PC',
    'path' => '/^\/admin\/equipos\/edit\/(\d+)\/borrarAlumno$/',
    'action' => [EquiposController::class, 'borrarAlumno'],
    'auth' => ['profesor']
]);

$router->add([
    'name' => 'Asignar PC a Alumno',
    'path' => '/^\/asignarPc\/pc\/(\d+)\/asignar$/',
    'action' => [EquiposController::class, 'asignarPc'],
    'auth' => ['profesor']
]);


// Reservas

$router->add([
    'name' => 'Reservas View',
    'path' => '/^\/admin\/reservas\/$/',
    'action' => [ReservasController::class, 'reservasView'],
    "auth" => ["profesor"]
]);

$router->add([
    'name' => 'Reservas Add View',
    'path' => '/^\/admin\/reservas\/add$/',
    'action' => [ReservasController::class, 'reservaAdd'],
    "auth" => ["profesor"]
]);

$router->add([
    'name' => 'Reservas Edit View',
    'path' => '/^\/admin\/reservas\/edit\/\d*$/',
    'action' => [ReservasController::class, 'reservaEdit'],
    "auth" => ["profesor"]
]);

$router->add([
    'name' => 'Reservas delete View',
    'path' => '/^\/admin\/reservas\/delete\/\d*$/',
    'action' => [ReservasController::class, 'reservaDel'],
    "auth" => ["profesor"]
]);

// Incidencias

$router->add([
    'name' => 'Incidencias View',
    'path' => '/^\/admin\/incidencias\/$/',
    'action' => [IncidenciasController::class, 'incidenciasView'],
    "auth" => ["profesor"]
]);

$router->add([
    'name' => 'Incidencias Add View',
    'path' => '/^\/admin\/incidencias\/add$/',
    'action' => [IncidenciasController::class, 'incidenciaAdd'],
    "auth" => ["profesor"]
]);

$router->add([
    'name' => 'Incidencias Edit View',
    'path' => '/^\/admin\/incidencias\/edit\/\d*$/',
    'action' => [IncidenciasController::class, 'incidenciaEdit'],
    "auth" => ["profesor"]
]);

$router->add([
    'name' => 'Incidencias Add View',
    'path' => '/^\/aula\/\d*\/incidencias\/add$/',
    'action' => [IncidenciasController::class, 'incidenciaAddPorAula'],
    "auth" => ["profesor"]
]);

$router->add([
    'name' => 'Incidencias Edit View',
    'path' => '/^\/aula\/\d*\/incidencias\/edit\/\d*$/',
    'action' => [IncidenciasController::class, 'incidenciaEditPorAula'],
    "auth" => ["profesor"]
]);

$router->add([
    'name' => 'Incidencias delete View',
    'path' => '/^\/aula\/\d*\/incidencias\/delete\/\d*$/',
    'action' => [IncidenciasController::class, 'incidenciaDelPorAula'],
    "auth" => ["profesor"]
]);

$router->add([
    'name' => 'Incidencias delete View',
    'path' => '/^\/admin\/incidencias\/delete\/\d*$/',
    'action' => [IncidenciasController::class, 'incidenciaDel'],
    "auth" => ["profesor"]
]);

$router->add([
    'name' => 'Incidencias view por aula',
    'path' => '/^\/aula\/\d*\/incidencias*$/',
    'action' => [IncidenciasController::class, 'incidenciaViewAula'],
    "auth" => ["profesor", "alumno", "invitado"]
]);
// Alumnos

$router->add([
    'name' => 'Alumnos View',
    'path' => '/^\/admin\/alumnos\/$/',
    'action' => [AlumnosController::class, 'alumnosView'],
    "auth" => ["profesor"]
]);

$router->add([
    'name' => 'Alumnos exportar',
    'path' => '/^\/admin\/alumnos\/exportar\/$/',
    'action' => [AlumnosController::class, 'alumnosExportar'],
    "auth" => ["profesor"]
]);

$router->add([
    'name' => 'Alumnos Importar',
    'path' => '/^\/admin\/alumnos\/importar\/$/',
    'action' => [AlumnosController::class, 'alumnosImportar'],
    "auth" => ["profesor"]
]);


$router->add([
    'name' => 'Alumnos Add View',
    'path' => '/^\/admin\/alumnos\/add$/',
    'action' => [AlumnosController::class, 'alumnoAdd'],
    "auth" => ["profesor"]
]);

$router->add([
    'name' => 'Alumnos edit View',
    'path' => '/^\/admin\/alumnos\/edit\/\d*$/',
    'action' => [AlumnosController::class, 'alumnoEdit'],
    "auth" => ["profesor"]
]);

$router->add([
    'name' => 'Alumnos delete View',
    'path' => '/^\/admin\/alumnos\/delete\/\d*$/',
    'action' => [AlumnosController::class, 'alumnosDel'],
    "auth" => ["profesor"]
]);

// Profesores

$router->add([
    'name' => 'Profesores View',
    'path' => '/^\/admin\/profesores\/$/',
    'action' => [ProfesoresController::class, 'profesoresView'],
    "auth" => ["profesor"]
]);

$router->add([
    'name' => 'Profesores exportar',
    'path' => '/^\/admin\/profesores\/exportar\/$/',
    'action' => [ProfesoresController::class, 'profesoresExportar'],
    "auth" => ["profesor"]
]);

$router->add([
    'name' => 'Profesores Importar',
    'path' => '/^\/admin\/profesores\/importar\/$/',
    'action' => [ProfesoresController::class, 'profesoresImportar'],
    "auth" => ["profesor"]
]);


$router->add([
    'name' => 'Profesores Add View',
    'path' => '/^\/admin\/profesores\/add$/',
    'action' => [ProfesoresController::class, 'profesorAdd'],
    "auth" => ["profesor"]
]);

$router->add([
    'name' => 'Profesores edit View',
    'path' => '/^\/admin\/profesores\/edit\/\d*$/',
    'action' => [ProfesoresController::class, 'profesorEdit'],
    "auth" => ["profesor"]
]);

$router->add([
    'name' => 'Profesores delete View',
    'path' => '/^\/admin\/profesores\/delete\/\d*$/',
    'action' => [ProfesoresController::class, 'profesoresDel'],
    "auth" => ["profesor"]
]);

// Grupos

$router->add([
    'name' => 'Grupos View',
    'path' => '/^\/admin\/grupos\/$/',
    'action' => [GruposController::class, 'adminViewGrupos'],
    "auth" => ["profesor"]
]);

$router->add([
    'name' => 'Grupos Add View',
    'path' => '/^\/admin\/grupos\/add$/',
    'action' => [GruposController::class, 'addGrupo'],
    "auth" => ["profesor"]
]);

$router->add([
    'name' => 'Grupos edit View',
    'path' => '/^\/admin\/grupos\/edit\/\d*$/',
    'action' => [GruposController::class, 'editGrupo'],
    "auth" => ["profesor"]
]);



$request = $_SERVER['REQUEST_URI'];
$route = $router->match($request);

if ($route) {
    if (in_array($_SESSION['perfil'], $route['auth'])) {
        $className = $route['action'][0];
        $classMethod = $route['action'][1];
        $object = new $className;
        $object->$classMethod($request);
    } else {
        exit(http_response_code(401));
    }
} else {
    exit(http_response_code(404));
}
