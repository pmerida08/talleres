<?php

namespace App\Models;

class Grupos extends DBAbstractModel
{
    static $instancia;
    private $id;
    private $nombre;
    private $aulas_id1;
    private $aulas_id2;

    public static function getInstancia()
    {
        if (!self::$instancia instanceof self) {
            self::$instancia = new self;
        }
        return self::$instancia;
    }

    public function __clone()
    {
        trigger_error('La clonación de este objeto no está permitida', E_USER_ERROR);
    }

    public function get($id = "")
    {
        $this->query = "SELECT * FROM grupos WHERE id=:id";
        $this->params['id'] = $id;
        $this->get_results_from_query();
        $this->message = "grupo mostrado";
        return $this->rows;
    }

    public function getAll()
    {
        $this->query = "SELECT * FROM grupos order by nombre";
        $this->get_results_from_query();
        $this->message = "grupos mostrados";
        return $this->rows;
    }

    public function set()
    {
        $this->query = "INSERT INTO grupos (nombre, aulas_id1, aulas_id2) VALUES (:nombre,:aulas_id1, :aulas_id2)";
        $this->params['nombre'] = $this->nombre;
        $this->params['aulas_id1'] = $this->aulas_id1;
        $this->params['aulas_id2'] = $this->aulas_id2;
        $this->get_results_from_query();
        $this->message = "grupo guardado";
    }

    public function edit()
    {
        $this->query = "UPDATE grupos SET nombre=:nombre, aulas_id1=:aulas_id1, aulas_id2=:aulas_id2 WHERE id=:id";
        $this->params['id'] = $this->id;
        $this->params['nombre'] = $this->nombre;
        $this->params['aulas_id1'] = $this->aulas_id1;
        $this->params['aulas_id2'] = $this->aulas_id2;
        $this->get_results_from_query();
        $this->message = "grupo editado";
    }

    public function delete()
    {
        $this->query = "DELETE FROM grupos WHERE id=:id";
        $this->params['id'] = $this->id;
        $this->get_results_from_query();
        $this->message = "grupo eliminado";
    }

    public function getId()
    {
        return $this->id;
    }

    public function getNombre($id)
    {
        $this->query = "SELECT nombre FROM grupos WHERE id=:id";
        $this->params['id'] = $id;
        $this->get_results_from_query();
        return $this->rows;
    }

    public function getAulasId($id)
    {
        $this->query = "SELECT aulas_id1, aulas_id2 FROM grupos WHERE id=:id";
        $this->params['id'] = $id;
        $this->get_results_from_query();
        return $this->rows;
    }


    public function getNombrePorAulaId1($aulas_id1)
    {
        $this->query = "SELECT nombre FROM grupos WHERE aulas_id1 = :aulas_id1";
        $this->params['aulas_id1'] = $aulas_id1;
        $this->get_results_from_query();
        return $this->rows;
    }
    public function getNombrePorAulaId2($aulas_id2)
    {
        $this->query = "SELECT nombre FROM grupos WHERE aulas_id2 = :aulas_id2";
        $this->params['aulas_id2'] = $aulas_id2;
        $this->get_results_from_query();
        return $this->rows;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }

    public function setAulasId1($aulas_id1)
    {
        if (!isset($aulas_id1)) {
            $aulas_id1 = "";
        }
        $this->aulas_id1 = $aulas_id1;
    }

    public function setAulasId2($aulas_id2)
    {
        if (!isset($aulas_id2)) {
            $aulas_id2 = "";
        }
        $this->aulas_id2 = $aulas_id2;
    }

    public function actualizarGruposPorAulaId($aulaId, $grupo1, $grupo2)
    {
        if ($grupo1 !== null) {
            $this->query = "UPDATE grupos SET aulas_id1=:aulaId WHERE nombre=:grupo1";
            $this->params['aulaId'] = $aulaId;
            $this->params['grupo1'] = $grupo1;
            $this->get_results_from_query();
        } else {
            $this->query = "UPDATE grupos SET aulas_id1=NULL WHERE aulas_id1=:aulaId";
            $this->params['aulaId'] = $aulaId;
            $this->get_results_from_query();
        }
        if ($grupo2 !== null) {
            $this->query = "UPDATE grupos SET aulas_id2=:aulaId WHERE nombre=:grupo2";
            $this->params['aulaId'] = $aulaId;
            $this->params['grupo2'] = $grupo2;
            $this->get_results_from_query();
        } else {
            $this->query = "UPDATE grupos SET aulas_id2=NULL WHERE aulas_id2=:aulaId";
            $this->params['aulaId'] = $aulaId;
            $this->get_results_from_query();
        }
    }
}
