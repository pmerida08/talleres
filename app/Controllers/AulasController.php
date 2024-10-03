<?php

namespace App\Controllers;

use App\Models\Aulas;
use App\Models\Equipos;
use App\Models\Ubicacion;
use App\Models\Incidencias;
use App\Models\Grupos;

class AulasController extends BaseController
{
    public function mostrarAulas()
    {
        $aulas = Aulas::getInstancia();
        $grupos = Grupos::getInstancia();
        $allAulas = $aulas->getAll();
        $gruposNombrePorId1 = [];
        $gruposNombrePorId2 = [];

        foreach ($allAulas as $aula) {
            $aulaId = $aula['id'];
            $gruposNombrePorId1[$aulaId] = $grupos->getNombrePorAulaId1($aulaId);
            $gruposNombrePorId2[$aulaId] = $grupos->getNombrePorAulaId2($aulaId);
        }

        $data = [
            "aulas" => $allAulas,
            "grupo1" => $gruposNombrePorId1,
            "grupo2" => $gruposNombrePorId2
        ];
        $this->renderHtml("../views/aulasView.php", $data);
    }


    public function adminViewAulas()
    {
        $aulas = Aulas::getInstancia();
        $grupos = Grupos::getInstancia();
        $allAulas = $aulas->getAll();
        $gruposNombrePorId1 = [];
        $gruposNombrePorId2 = [];

        foreach ($allAulas as $aula) {
            $aulaId = $aula['id'];
            $gruposNombrePorId1[$aulaId] = $grupos->getNombrePorAulaId1($aulaId);
            $gruposNombrePorId2[$aulaId] = $grupos->getNombrePorAulaId2($aulaId);
        }

        $data = [
            "aulas" => $allAulas,
            "grupo1" => $gruposNombrePorId1,
            "grupo2" => $gruposNombrePorId2
        ];
        $this->renderHtml("../views/profesor/aulas/aulasViewProf.php", $data);
    }

    public function editAula($url)
    {
        $numero = explode("/", $url);
        $numero = end($numero);

        $aulas = Aulas::getInstancia();
        $incidencias = Incidencias::getInstancia();
        $grupos = Grupos::getInstancia();
        if (isset($_POST) && !empty($_POST)) {
            // if (empty($_POST['numAula']) || empty($_POST['grupo']) || empty($_POST['numMesas'])) {
            if (empty($_POST['numAula']) || empty($_POST['numMesas'])) {
                $_SESSION["fallo"] = "Completa todos los campos";
                header("Location: /admin/aulas/edit/$numero");
                exit();
            }

            $aulas->setId($numero);
            $aulas->setnumAula($_POST["numAula"]);

            if (isset($_POST['grupo']) && count($_POST['grupo']) >= 2) {
                $grupos->actualizarGruposPorAulaId($numero, $_POST['grupo'][0], $_POST['grupo'][1]);
            } elseif (isset($_POST['grupo'][0])) {
                $grupos->actualizarGruposPorAulaId($numero, $_POST['grupo'][0], null);
            } else {
                $grupos->actualizarGruposPorAulaId($numero, null, null);
            }
            $aulas->setNumMesas($_POST["numMesas"]);
            $aulas->edit();
            $grupos->edit();

            header("Location: /admin/aulas/");
        }
        $data = [
            "id" => $numero,
            "numAula" => $aulas->getnumAula($numero)[0]["num_aula"],
            "grupo1" => isset($grupos->getNombrePorAulaId1($numero)[0]["nombre"]) ? $grupos->getNombrePorAulaId1($numero)[0]["nombre"] : "",
            "grupo2" => isset($grupos->getNombrePorAulaId2($numero)[0]["nombre"]) ? $grupos->getNombrePorAulaId2($numero)[0]["nombre"] : "",
            "numMesas" => $aulas->getNumMesas($numero)[0]["num_mesas"],
            "allGrupos" => $grupos->getAll(),
            "incidencias" => $incidencias->getPorAulaId($numero)
        ];
        $this->renderHtml("../views/profesor/aulas/editAulaView.php", $data);
    }

    public function addAula()
    {

        $aulas = Aulas::getInstancia();
        $grupos = Grupos::getInstancia();

        if (isset($_POST) && !empty($_POST)) {
            if (empty($_POST['numAula']) ||  empty($_POST['numMesas'])) {
                $_SESSION["fallo"] = "Completa todos los campos";
                header("Location: /admin/aulas/add");
                exit();
            }
            $aulas->setnumAula($_POST["numAula"]);
            $aulas->setNumMesas($_POST["numMesas"]);
            $aulas->setNumMesas($_POST["numMesas"]);
            $aulas->set();
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
        $aulas->delete($numero);
        header("Location: /admin/aulas/");
    }

    public function equipoAulaView($url)
    {
        $numero = explode("/", $url);
        $numero = end($numero);

        $ubicacion = Ubicacion::getInstancia();
        $aula = Aulas::getInstancia();
        $equipos = Equipos::getInstancia();
        $grupos = Grupos::getInstancia();

        if (strtolower($grupos->getNombrePorAulaId1($numero) == "departamento") || strtolower($grupos->getNombrePorAulaId2($numero) == "departamento")) {
            $data = [
                "idAula" => $numero,
                "ubicaciones" => $ubicacion->getUbicacionPorId($numero),
                "numMesas" => $aula->getNumMesas($numero)[0]["num_mesas"],
                "numAula" => $aula->getnumAula($numero)[0]["num_aula"],
                "grupo1" => $grupos->getNombrePorAulaId1($numero)[0]["nombre"],
                "grupo2" => $grupos->getNombrePorAulaId2($numero)[0]["nombre"],
                "grupos" => $grupos->getAll(),
                "equipos" => $equipos->getAll(),
                "estadosEquipos" => $equipos->getAllEstados()
            ];
            $this->renderHtml("../views/aulaEquipo_view_Departamento.php", $data);
        } else {
            $data = [
                "idAula" => $numero,
                "ubicaciones" => $ubicacion->getUbicacionPorId($numero),
                "numMesas" => $aula->getNumMesas($numero)[0]["num_mesas"],
                "numAula" => $aula->getnumAula($numero)[0]["num_aula"],
                "grupo1" => $grupos->getNombrePorAulaId1($numero)[0]["nombre"],
                "grupo2" => $grupos->getNombrePorAulaId2($numero)[0]["nombre"],
                "grupos" => $grupos->getAll(),
                "equipos" => $equipos->getAll(),
                "estadosEquipos" => $equipos->getAllEstados()
            ];
            $this->renderHtml("../views/aulaEquipo_view.php", $data);
        }
    }
}
