<?php

namespace App\Controllers;

use App\Models\Reservas;
use App\Models\Equipos;
use App\Models\Profesores;
use App\Models\Ubicacion;

class ReservasController extends BaseController
{
    public function reservasView()
    {
        $profesores = Profesores::getInstancia();
        $equipos = Equipos::getInstancia();
        $reservas = Reservas::getInstancia();
        if (isset($_POST["buscar"])) {
            $data = [
                "profesores" => $profesores->getAll(),
                "equipos" => $equipos->getAll(),
                "reservas" => $reservas->getReservasPorProfesorId($profesores->getIdPorNombre($_POST["busqueda"])[0]["id"]),
                "valueInput" => $_POST["busqueda"]
            ];
        } else {
            $data = [
                "profesores" => $profesores->getAll(),
                "equipos" => $equipos->getAll(),
                "reservas" => $reservas->getAll()
            ];
        }
        $this->renderHtml("../views/profesor/reservas/reservasView.php", $data);
    }

    public function reservaAdd()
    {
        $reservas = Reservas::getInstancia();
        $equipos = Equipos::getInstancia();
        $profesores = Profesores::getInstancia();
        $ubicaciones = Ubicacion::getInstancia();
        if (isset($_POST) && !empty($_POST)) {
            if (empty($_POST['fecha_inicio']) || empty($_POST['fecha_fin']) || empty($_POST['id_equipo']) || empty($_POST['id_profesor'])) {
                $_SESSION["fallo"] = "Completa todos los campos";
                header("Location: /admin/reservas/add");
                exit();
            }
            
            $fecha_inicio = $_POST['fecha_inicio'];
            $fecha_fin = $_POST['fecha_fin'];

            if ((strtotime($fecha_fin) <= strtotime($fecha_inicio))) {
                $_SESSION["fallo"] = "La fecha final no puede ser anterior a la de inicio";
                header("Location: /admin/reservas/add");
                exit();
            }

            
            if ($equipos->getEstado($_POST['id_equipo'])[0]["t_estados_id"] == 2) {
                $_SESSION["fallo"] = "El equipo seleccionado esta roto";
                header("Location: /admin/reservas/add");
                exit();
            }

            $fechaFinEquipoReservado = $reservas->getFechaFinalIdEquipo($_POST['id_equipo']);
            $fechaFinEquipoReservado = end($fechaFinEquipoReservado);

            if ($fechaFinEquipoReservado) {
                if (strtotime($fecha_inicio) <= strtotime($fechaFinEquipoReservado["fecha_final"])) {
                    $_SESSION["fallo"] = "Este equipo ya está reservado en esta fecha";
                    header("Location: /admin/reservas/add");
                    exit();
                }
            }
            $reservas->setFechaInicio($_POST["fecha_inicio"]);
            $reservas->setFechaFinal($_POST['fecha_fin']);
            $reservas->setEquiposId($_POST['id_equipo']);
            $reservas->setProfesoresId($_POST['id_profesor']);
            $reservas->setObservaciones($_POST['observaciones']);
            $reservas->set();
            header("Location: /admin/reservas/");
        }

        $data = [
            "equipos" => $equipos->getAll(),
            "profesores" => $profesores->getAll(),
            "EquiposUbicacion" => $ubicaciones->getIdEquipos()
        ];
        $this->renderHtml("../views/profesor/reservas/addReservaView.php", $data);
    }

    public function reservaEdit($url)
    {
        $numero = explode("/", $url);
        $numero = end($numero);

        $equipos = Equipos::getInstancia();
        $reservas = Reservas::getInstancia();
        
        if (isset($_POST) && !empty($_POST)) {
            if (empty($_POST['fecha_inicio']) || empty($_POST['fecha_fin']) || empty($_POST['id_equipo']) || empty($_POST['id_profesor'])) {
                $_SESSION["fallo"] = "Completa todos los campos";
                header("Location: /admin/reservas/edit/$numero");
                exit();
            }

            $fecha_inicio = $_POST['fecha_inicio'];
            $fecha_fin = $_POST['fecha_fin'];

            if (strtotime($fecha_fin) <= strtotime($fecha_inicio)) {
                $_SESSION["fallo"] = "La fecha final no puede ser anterior a la de inicio";
                header("Location: /admin/reservas/edit/$numero");
                exit();
            }

            if ($equipos->getEstado($_POST['id_equipo'])[0]["t_estados_id"] == 2) {
                $_SESSION["fallo"] = "El equipo seleccionado esta roto";
                header("Location: /admin/reservas/edit/$numero");
                exit();
            }
            
            $reservasCoincidentes = $reservas->getReservasPorEquipoId($_POST['id_equipo'], $numero);

            var_dump($reservasCoincidentes);
            echo "</br>";
            echo "</br>";
            foreach ($reservasCoincidentes as $key => $reserva) {
                var_dump($reserva);
                echo "</br>";
                echo "</br>";
                $fechaFinEquipoReservado = $reservas->getFechaFinalIdEquipo($reserva["equipos_id"], $numero);
                var_dump($fechaFinEquipoReservado);
                echo "</br>";
                echo "</br>";
                $fechaFinEquipoReservado = end($fechaFinEquipoReservado);
                var_dump($fechaFinEquipoReservado);
                echo "</br>";
                echo "</br>";
                var_dump($fecha_inicio);
                if ($fechaFinEquipoReservado) {
                    if (strtotime($fecha_inicio) <= strtotime($fechaFinEquipoReservado["fecha_final"])) {
                        $_SESSION["fallo"] = "Este equipo ya está reservado en esta fecha";
                        header("Location: /admin/reservas/edit/$numero");
                        exit();
                    }
                }
            }

            $reservas->setId($numero);
            $reservas->setFechaInicio($_POST["fecha_inicio"]);
            $reservas->setFechaFinal($_POST['fecha_fin']);
            $reservas->setEquiposId($_POST['id_equipo']);
            $reservas->setProfesoresId($_POST['id_profesor']);
            $reservas->setObservaciones($_POST['observaciones']);
            $reservas->edit();
            header("Location: /admin/reservas/");
        }
        $equipos = Equipos::getInstancia();
        $profesores = Profesores::getInstancia();
        $ubicaciones = Ubicacion::getInstancia();

        $arrayEquipos = $equipos->getAll();
        $arrayIdEquiposReservados = $reservas->getEquiposIdAll();
        $arrayEquiposConUbicacion = $ubicaciones->getIdEquipos();
        $idEquipoActual = $reservas->getEquiposId($numero)[0]["equipos_id"];

        foreach ($arrayEquipos as $equipo) {
            $idEquipo = $equipo["id"];
            $encontrado = false;
            foreach ($arrayIdEquiposReservados as $id) {
                if ($id["equipos_id"] == $idEquipo && $id["equipos_id"] != $idEquipoActual) {
                    $encontrado = true;
                    break;
                }
            }
            foreach ($arrayEquiposConUbicacion as $id) {
                if ($id["equipos_id"] == $idEquipo) {
                    $encontrado = true;
                    break;
                }
            }
            if (!$encontrado) {
                $equiposFiltrados[] = $equipo;
            }
        }

        $equiposFiltrados = array_values($equiposFiltrados);

        $data = [
            "id" => $numero,
            "fechaInicio" => $reservas->getFechaInicio($numero)[0]['fecha_inicio'],
            "fechaFin" => $reservas->getFechaFinal($numero)[0]['fecha_final'],
            "equipoActual" => $reservas->getEquiposId($numero)[0]["equipos_id"],
            "observaciones" => $reservas->getObservaciones($numero)[0]["observaciones"],
            "profesorActual" => $reservas->getProfesoresId($numero)[0]["profesores_id"],
            "equipos" => $equiposFiltrados,
            "profesores" => $profesores->getAll(),
            "reserva" => $reservas->getEquiposIdAll()
        ];
        $this->renderHtml("../views/profesor/reservas/editReservaView.php", $data);
    }

    public function reservaDel($url){
        $numero = explode("/", $url);
        $numero = end($numero);

        $reservas = Reservas::getInstancia();
        $reservas->delete($numero);
        header("Location: /admin/reservas/");
    }
}
