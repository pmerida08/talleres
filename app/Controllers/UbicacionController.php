<?php

namespace App\Controllers;

use App\Models\Ubicacion;

class UbicacionController extends BaseController
{
    public function ubicacionChage(){
        if (isset($_POST)) {
            $ubicacion = Ubicacion::getInstancia();
            if (empty($_POST["equipos_id"])) {
                $ubicacion->deletePorPuestoYIdAula($_POST["puesto"], $_POST["idAula"]);
                header("Location: /aula/".$_POST["idAula"]);
            }
            if ($ubicacion->existeUbicacionPorPuesto($_POST["puesto"], $_POST["idAula"])) {
                if ($ubicacion->existeUbicacionPorEquipo($_POST["equipos_id"])) {
                    $ubicacion->delete($_POST["equipos_id"]);
                }
                $ubicacion->setPuesto($_POST["puesto"]);
                $ubicacion->setAulas_id($_POST["idAula"]);
                $ubicacion->setEquipos_id($_POST["equipos_id"]);
                $ubicacion->edit();
            }else{
                if ($ubicacion->existeUbicacionPorEquipo($_POST["equipos_id"])) {
                    $ubicacion->delete($_POST["equipos_id"]);
                }
                $ubicacion->setPuesto($_POST["puesto"]);
                $ubicacion->setAulas_id($_POST["idAula"]);
                $ubicacion->setEquipos_id($_POST["equipos_id"]);
                $ubicacion->set();
            }
            header("Location: /aula/".$_POST["idAula"]);
        }else{
        header("Location: /");
    }
    }
}

