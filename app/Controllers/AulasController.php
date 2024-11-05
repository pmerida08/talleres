<?php

namespace App\Controllers;

use App\Models\Aulas;
use App\Models\Equipos;
use App\Models\Ubicacion;
use App\Models\Incidencias;
use App\Models\Grupos;

class AulasController extends BaseController
{



    public function adminViewAulas()
    {
        $aulas = Aulas::getInstancia();
        $aulasList = $aulas->getAll();

        foreach ($aulasList as &$aula) {
            $aula["grupos"] = $aulas->getGrupos($aula["id"]);
        }

        $data = ["aulas" => $aulasList];
        $this->renderHtml("../views/profesor/aulas/aulasViewProf.php", $data);
    }

    public function mostrarAulas()
    {
        $aulas = Aulas::getInstancia();
        $aulasList = $aulas->getAll(); // Obtiene todas las aulas

        foreach ($aulasList as &$aula) {
            $aula["grupos"] = $aulas->getGrupos($aula["id"]); // Obtener los grupos por aula
        }

        $data = ["aulas" => $aulasList];
        $this->renderHtml("../views/aulasView.php", $data);
    }

    public function editAula($url)
    {
        $numero = explode("/", $url);
        $numero = end($numero);

        $aulas = Aulas::getInstancia();
        $grupos = Grupos::getInstancia();
        $incidencias = Incidencias::getInstancia();


        if (isset($_POST) && !empty($_POST)) {
            if (empty($_POST['numAula']) || empty($_POST['numMesas'])) {
                $_SESSION["fallo"] = "Completa todos los campos obligatorios";
                header("Location: /admin/aulas/edit/$numero");
                exit();
            }

            $aulas->setId($numero);
            $aulas->setnumAula($_POST["numAula"]);
            $aulas->setNumMesas($_POST["numMesas"]);
            $aulas->edit();
            $aulas->eliminarGrupos($numero);

            if (isset($_POST['grupo_id']) && !empty($_POST['grupo_id'])) {
                foreach ($_POST['grupo_id'] as $grupoId) {
                    $aulas->asignarGrupo($numero, $grupoId);
                }
            }

            header("Location: /admin/aulas/");
            exit();
        }

        $data = [
            "id" => $numero,
            "numAula" => $aulas->getnumAula($numero)[0]["num_aula"],
            "numMesas" => $aulas->getNumMesas($numero)[0]["num_mesas"],
            "allGrupos" => $grupos->getAll(),
            "selectedGrupos" => $aulas->getGrupos($numero),
            "incidencias" => $incidencias->getPorAulaId($numero)

        ];

        $this->renderHtml("../views/profesor/aulas/editAulaView.php", $data);
    }





    public function addAula()
    {
        $aulas = Aulas::getInstancia();
        $grupos = Grupos::getInstancia();

        if (isset($_POST) && !empty($_POST)) {
            if (empty($_POST['numAula']) ||  empty($_POST['grupo_id']) || empty($_POST['numMesas'])) {
                $_SESSION["fallo"] = "Completa todos los campos";
                header("Location: /admin/aulas/add");
                exit();
            }

            $aulas->setnumAula($_POST["numAula"]);
            $aulas->setNumMesas($_POST["numMesas"]);
            $aulaId = $aulas->set();

            foreach ($_POST['grupo_id'] as $grupoId) {
                $aulas->asignarGrupo($aulaId, $grupoId);
            }

            header("Location: /admin/aulas/");
        }

        $data = [
            "allGrupos" => $grupos->getAll()
        ];
        $this->renderHtml("../views/profesor/aulas/addAulaView.php", $data);
    }





    public function deleteAula($url)
    {
        $numero = explode("/", $url);
        $numero = end($numero);
        $aulas = Aulas::getInstancia();
        $aulas->delete();
        header("Location: /admin/aulas/");
    }

    public function equipoAulaView($url)
    {
        $numero = explode("/", $url);
        $numero = end($numero);

        $ubicacion = Ubicacion::getInstancia();
        $aula = Aulas::getInstancia();
        $equipos = Equipos::getInstancia();

        if (strtolower($aula->getGrupos($numero) == "departamento")) {
            $data = [
                "idAula" => $numero,
                "ubicaciones" => $ubicacion->getUbicacionPorId($numero),
                "numMesas" => $aula->getNumMesas($numero)[0]["num_mesas"],
                "numAula" => $aula->getnumAula($numero)[0]["num_aula"],
                "grupos" => $aula->getGrupos($numero),
                "equipos" => $equipos->getAll(),
                "estadosEquipos" => $equipos->getAllEstados(),
            ];
            $this->renderHtml("../views/aulaEquipo_view_Departamento.php", $data);
        } else {
            $data = [
                "idAula" => $numero,
                "ubicaciones" => $ubicacion->getUbicacionPorId($numero),
                "numMesas" => $aula->getNumMesas($numero)[0]["num_mesas"],
                "numAula" => $aula->getnumAula($numero)[0]["num_aula"],
                "grupos" => $aula->getGrupos($numero),
                "equipos" => $equipos->getAll(),
                "estadosEquipos" => $equipos->getAllEstados(),
            ];
            $this->renderHtml("../views/aulaEquipo_view.php", $data);
        }
    }
}
