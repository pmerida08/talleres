<?php

namespace App\Controllers;

use App\Models\Aulas;
use App\Models\Incidencias;
use App\Models\Profesores;

class IncidenciasController extends BaseController
{
    public function incidenciasView()
    {
        $incidencias = Incidencias::getInstancia();
        $profesores = Profesores::getInstancia();
        $aulas = Aulas::getInstancia();
        $data = [
            "incidencias" => $incidencias->getAll(),
            "profesores" => $profesores->getAll(),
            "aulas" => $aulas->getAll()
        ];
        $this->renderHtml("../views/profesor/incidencias/incidenciasView.php", $data);
    }

    public function incidenciaViewAula($url)
    {
        $incidencias = Incidencias::getInstancia();
        $profesores = Profesores::getInstancia();
        $aulas = Aulas::getInstancia();

        $parts = explode("/", $url);
        $numAula = $parts[2];
        $idAula = $aulas->getIdPorNumAula($numAula)[0]["id"];
        
        $data = [
            "idAula" => $idAula,
            "numAula" => $numAula,
            "incidencias" => $incidencias->getPorAulaId($idAula),
            "profesores" => $profesores->getAll(),
            "aulas" => $aulas->getAll()
        ];
        $this->renderHtml("../views/profesor/incidencias/incidenciasViewAula.php", $data);
    }

    public function incidenciaAdd()
    {
        $incidencias = Incidencias::getInstancia();
        if (isset($_POST) && !empty($_POST)) {
            if (empty($_POST['descripcion']) || empty($_POST['fecha']) || empty($_POST['aula_id'])) {
                $_SESSION["fallo"] = "Completa todos los campos";
                header("Location: /admin/incidencias/add");
                exit();
            }
            if (!empty($_POST['fecha_fin'])) {
                if (strtotime($_POST['fecha_fin']) <= strtotime($_POST['fecha'])) {
                    $_SESSION["fallo"] = "La fecha final no puede ser anterior a la de inicio";
                    header("Location: /admin/incidencias/add");
                    exit();
                }
            }

            $incidencias->setDescripcion($_POST["descripcion"]);
            $incidencias->setFecha($_POST['fecha']);
            !empty($_POST['fecha_fin']) ? $incidencias->setFechaSolucion($_POST['fecha_fin']) : null;
            $incidencias->setIdAulas($_POST['aula_id']);
            $incidencias->setIdProfesores($_SESSION["idPerfil"]);
            $incidencias->set();
            header("Location: /admin/incidencias/");
        }

        $profesores = Profesores::getInstancia();
        $aulas = Aulas::getInstancia();
        $data = [
            "profesores" => $profesores->getAll(),
            "aulas" => $aulas->getAll()
        ];
        $this->renderHtml("../views/profesor/incidencias/addIncidenciaView.php", $data);
    }
    
    public function incidenciaAddPorAula($url){
        $aulas = Aulas::getInstancia();
        $incidencias = Incidencias::getInstancia();
        $profesores = Profesores::getInstancia();

        $parts = explode("/", $url);
        $numAula = $parts[2];
        $idAula = $aulas->getIdPorNumAula($numAula)[0]["id"];

        if (isset($_POST) && !empty($_POST)) {
            if (empty($_POST['descripcion']) || empty($_POST['fecha'])) {
                $_SESSION["fallo"] = "Completa todos los campos";
                header("Location: /aula/$numAula/incidencias/add");
                exit();
            }
            if (!empty($_POST['fecha_fin'])) {
                if (strtotime($_POST['fecha_fin']) <= strtotime($_POST['fecha'])) {
                    $_SESSION["fallo"] = "La fecha final no puede ser anterior a la de inicio";
                    header("Location: /aula/$numAula/incidencias/add");
                    exit();
                }
            }

            $incidencias->setDescripcion($_POST["descripcion"]);
            $incidencias->setFecha($_POST['fecha']);
            !empty($_POST['fecha_fin']) ? $incidencias->setFechaSolucion($_POST['fecha_fin']) : null;
            $incidencias->setIdAulas($idAula);
            $incidencias->setIdProfesores($_SESSION["idPerfil"]);
            $incidencias->set();
            header("Location: /aula/$numAula/incidencias");
        }

        $data = [
            "profesores" => $profesores->getAll(),
            "numAula" => $numAula
        ];
        $this->renderHtml("../views/profesor/incidencias/addIncidenciaViewPorAula.php", $data);
    }

    public function incidenciaDel($url)
    {
        $numero = explode("/", $url);
        $numero = end($numero);

        $incidencias = Incidencias::getInstancia();
        $incidencias->delete($numero);
        header("Location: /admin/incidencias/");
    }

    public function incidenciaDelPorAula($url){
        $parts = explode("/", $url);
        $incidenciaId = $parts[5];
        $numAula = $parts[2];

        $incidencias = Incidencias::getInstancia();
        $incidencias->delete($incidenciaId);
        header("Location: /aula/$numAula/incidencias");
    }

    public function incidenciaEdit($url)
    {
        $numero = explode("/", $url);
        $numero = end($numero);
        $incidencias = Incidencias::getInstancia();
        if (isset($_POST) && !empty($_POST)) {
            if (empty($_POST['descripcion']) || empty($_POST['fecha']) || empty($_POST['aula_id'])) {
                $_SESSION["fallo"] = "Completa todos los campos";
                header("Location: /admin/incidencias/edit/$numero");
                exit();
            }
            if (!empty($_POST['fecha_fin'])) {
                if (strtotime($_POST['fecha_fin']) <= strtotime($_POST['fecha'])) {
                    $_SESSION["fallo"] = "La fecha final no puede ser anterior a la de inicio";
                    header("Location: /admin/incidencias/edit/$numero");
                    exit();
                }
            }
            $incidencias->setId($numero);
            $incidencias->setDescripcion($_POST["descripcion"]);
            $incidencias->setFecha($_POST['fecha']);
            !empty($_POST['fecha_fin']) ? $incidencias->setFechaSolucion($_POST['fecha_fin']) : null;
            $incidencias->setIdAulas($_POST['aula_id']);
            $incidencias->setIdProfesores($_SESSION["idPerfil"]);
            $incidencias->edit();
            header("Location: /admin/incidencias/");
        }

        $profesores = Profesores::getInstancia();
        $aulas = Aulas::getInstancia();
        $data = [
            "id" => $numero,
            "descripcion" => $incidencias->getDescripcion($numero)[0]["descripcion"],
            "fecha" => $incidencias->getFecha($numero)[0]["fecha"],
            "fechaSolucion" => $incidencias->getFechaSolucion($numero)[0]["fecha_solucion"],
            "profesores" => $profesores->getAll(),
            "idProfesorActual" => $incidencias->getProfesoresId($numero)[0]["profesores_id"],
            "aulas" => $aulas->getAll(),
            "idAulaActual" => $incidencias->getAulasId($numero)[0]["aulas_id"],
        ];
        $this->renderHtml("../views/profesor/incidencias/editIncidenciaView.php", $data);
    }

    public function incidenciaEditPorAula($url){
        $profesores = Profesores::getInstancia();
        $aulas = Aulas::getInstancia();
        $incidencias = Incidencias::getInstancia();

        $parts = explode("/", $url);
        $incidenciaId = $parts[5];
        $numAula = $parts[2];
        $idAula = $aulas->getIdPorNumAula($numAula)[0]["id"];

        if (isset($_POST) && !empty($_POST)) {
            if (empty($_POST['descripcion']) || empty($_POST['fecha'])) {
                $_SESSION["fallo"] = "Completa todos los campos";
                header("Location: /aula/$numAula/incidencias/edit/$incidenciaId");
                exit();
            }
            if (!empty($_POST['fecha_fin'])) {
                if (strtotime($_POST['fecha_fin']) <= strtotime($_POST['fecha'])) {
                    $_SESSION["fallo"] = "La fecha final no puede ser anterior a la de inicio";
                    header("Location: /aula/$numAula/incidencias/edit/$incidenciaId");
                    exit();
                }
            }
            $incidencias->setId($incidenciaId);
            $incidencias->setDescripcion($_POST["descripcion"]);
            $incidencias->setFecha($_POST['fecha']);
            !empty($_POST['fecha_fin']) ? $incidencias->setFechaSolucion($_POST['fecha_fin']) : null;
            $incidencias->setIdAulas($idAula);
            $incidencias->setIdProfesores($_SESSION["idPerfil"]);
            $incidencias->edit();
            header("Location: /aula/$numAula/incidencias");
        }

        $data = [
            "id" => $incidenciaId,
            "descripcion" => $incidencias->getDescripcion($incidenciaId)[0]["descripcion"],
            "fecha" => $incidencias->getFecha($incidenciaId)[0]["fecha"],
            "fechaSolucion" => $incidencias->getFechaSolucion($incidenciaId)[0]["fecha_solucion"],
            "profesores" => $profesores->getAll(),
            "idProfesorActual" => $incidencias->getProfesoresId($incidenciaId)[0]["profesores_id"],
            "idAulaActual" => $numAula,
        ];
        $this->renderHtml("../views/profesor/incidencias/editIncidenciaViewPorAula.php", $data);
    }
}
