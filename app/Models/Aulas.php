<?php

namespace App\Models;

class Aulas extends DBAbstractModel
{
    private $id;
    private $numAula;
    private $numMesas;
    private static $instancia;

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

    // Métodos setter
    public function setId($id)
    {
        $this->id = $id;
    }

    public function setnumAula($numAula)
    {
        $this->numAula = $numAula;
    }

    public function setNumMesas($numMesas)
    {
        $this->numMesas = $numMesas;
    }

    // Métodos getter

    public function getId()
    {
        $this->query = "SELECT id FROM aulas ";
        $this->params['id'] = $this->id;
        $this->get_results_from_query();
        return $this->rows;
    }
    public function getnumAula($id)
    {
        $this->query = "SELECT num_aula FROM aulas WHERE id = :id";
        $this->params['id'] = $id;
        $this->get_results_from_query();
        return $this->rows;
    }


    public function getNumMesas($id)
    {
        $this->query = "SELECT num_mesas FROM aulas WHERE id = :id";
        $this->params['id'] = $id;
        $this->get_results_from_query();
        return $this->rows;
    }

    public function get($id = "")
    {
        if ($id != "") {
            $this->query = "SELECT * FROM aulas WHERE id = :id";
            $this->params['id'] = $id;
        } else {
            $this->query = "SELECT * FROM aulas";
        }
        $this->get_results_from_query();
        return $this->rows;
    }

    public function getGrupos($aulaId)
    {
        $this->query = "SELECT g.* FROM grupos g
                        INNER JOIN aulas_grupos ag ON g.id = ag.grupo_id
                        WHERE ag.aula_id = :aula_id";
        $this->params['aula_id'] = $aulaId;
        $this->get_results_from_query();
        return $this->rows ?? [];
    }
    public function getIncidencias($aulaId)
    {
        $this->query = "SELECT i.*, p.nombre AS profesor_nombre FROM incidencias i
                    INNER JOIN profesores p ON i.profesores_id = p.id
                    WHERE i.aulas_id = :aula_id";
        $this->params['aula_id'] = $aulaId;
        $this->get_results_from_query();
        return $this->rows ?? [];
    }


    // Método para agregar un aula
    public function set()
    {
        $this->query = "INSERT INTO aulas (num_aula, num_mesas) 
                        VALUES (:numAula, :numMesas)";
        $this->params['numAula'] = $this->numAula;
        $this->params['numMesas'] = $this->numMesas;
        $this->get_results_from_query();
        return $this->lastInsert();
    }

    // Método para editar un aula
    public function edit()
    {
        $this->query = "UPDATE aulas SET num_aula = :numAula, num_mesas = :numMesas WHERE id = :id";
        $this->params['id'] = $this->id;
        $this->params['numAula'] = $this->numAula;
        $this->params['numMesas'] = $this->numMesas;
        $this->get_results_from_query();
        $this->message = "Aula editada";
    }

    public function delete()
    {
        $this->query = "DELETE FROM aulas WHERE id = :id";
        $this->params['id'] = $this->id;
        $this->get_results_from_query();
        $this->message = "Aula eliminada";
    }

    public function asignarGrupo($aulaId, $grupoId)
    {
        $this->query = "REPLACE INTO aulas_grupos (aula_id, grupo_id) VALUES (:aula_id, :grupo_id)";
        $this->params['aula_id'] = $aulaId;
        $this->params['grupo_id'] = $grupoId;
        $this->get_results_from_query();
    }

    public function eliminarGrupos($aulaId)
    {
        $this->query = "DELETE FROM aulas_grupos WHERE aula_id = :aula_id";
        $this->params['aula_id'] = $aulaId;
        $this->get_results_from_query();
    }

    public function getAllAulasGrupos()
    {
        $this->query = "SELECT * FROM aulas_grupos";
        $this->get_results_from_query();
        return $this->rows;
    }
    public function getAulasGrupos($aulaId)
    {
        $this->query = "SELECT grupo_id FROM aulas_grupos WHERE aula_id = :aula_id";
        $this->params['aula_id'] = $aulaId;
        $this->get_results_from_query();
        return $this->rows;
    }

    public function getAll()
    {
        return $this->get();
    }

    public function getIdPorNumAula($numAula)
    {
        $this->query = "SELECT id FROM aulas WHERE num_aula = :num_aula";
        $this->params['num_aula'] = $numAula;
        $this->get_results_from_query();
        return $this->rows;
    }
}
