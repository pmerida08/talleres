<?php

namespace App\Controllers;

use App\Models\Grupos;
use App\Models\Aulas;

class GruposController extends BaseController
{
    public function adminViewGrupos()
    {
        $aulas = Aulas::getInstancia();
        $grupos = Grupos::getInstancia();

        $data = [
            "grupos" => $grupos->getAll(),
            "aulas" => $aulas->getAll(),
            "aulasGrupos" => $aulas->getAllAulasGrupos()
        ];
        $this->renderHtml("../views/profesor/grupos/gruposViewProf.php", $data);
    }

    public function addGrupo()
    {
        $grupos = Grupos::getInstancia();
        $aulas = Aulas::getInstancia();
        if (isset($_POST) && !empty($_POST)) {
            if (empty($_POST['nombre_grupo']) || empty($_POST['aula'])) {
                $_SESSION["fallo"] = "Completa todos los campos";
                header("Location: /admin/grupos/add");
                exit();
            }
            $grupos->setNombre($_POST['nombre_grupo']);
            $aulas->asignarGrupo($_POST['aula'], $grupos->getId());
            $grupos->set();
            $aulas->set();
            $_SESSION["exito"] = "Grupo guardado";
            header("Location: /admin/grupos/");
            exit();
        }
        $data = [
            "aulas" => $aulas->getAll(),
            "grupos" => $grupos->getAll(),
        ];
        $this->renderHtml("../views/profesor/grupos/addGrupoView.php", $data);
    }

    public function editGrupo($url)
    {
        $numero = explode("/", $url);
        $numero = end($numero);

        $grupos = Grupos::getInstancia();
        $aulas = Aulas::getInstancia();
        if (isset($_POST) && !empty($_POST)) {
            if (empty($_POST['nombre_grupo'])) {
                $_SESSION["fallo"] = "Completa todos los campos";
                header("Location: /admin/grupos/edit/$numero");
                exit();
            }

            $grupos->setId($numero);
            $grupos->setNombre($_POST['nombre_grupo']);

            $aulaId = !empty($_POST['aula']) ? $_POST['aula'] : null;

            $aulas->asignarGrupo($aulaId, $grupos->getId());

            $grupos->edit();
            $_SESSION["exito"] = "Grupo editado";
            header("Location: /admin/grupos/");
            exit();
        }
        $aulaIdArray = $grupos->getAulaIdByGrupoId($numero);
        $data = [
            "id" => $numero,
            "nombre_grupo" => $grupos->getNombre($numero)[0]["nombre_grupo"],
            "aulas" => $aulas->getAll(),
            "grupos" => $grupos->getAll(),
            "aulaId" => !empty($aulaIdArray) ? $aulaIdArray[0]["aula_id"] : null
        ];
        $this->renderHtml("../views/profesor/grupos/editGrupoView.php", $data);
    }




    public function deleteGrupo($url)
    {
        $numero = explode("/", $url);
        $numero = end($numero);

        $grupos = Grupos::getInstancia();
        $grupos->setId($numero);
        $grupos->delete();
        $_SESSION["exito"] = "Grupo eliminado";
        header("Location: /admin/grupos");
        exit();
    }
}
