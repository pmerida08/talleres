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

    public function get($id = "")
    {
        $this->query = "SELECT * FROM aulas WHERE id=:id";
        $this->params['id'] = $id;
        $this->get_results_from_query();
        $this->message = "Aula mostrada";
        return $this->rows;
    }
    public function getAll(){
        $this->query = "SELECT * FROM aulas";
        $this->get_results_from_query();
        $this->message = "Aulas mostradas";
        return $this->rows;
    }
    public function set()
    {
        $this->query = "INSERT INTO aulas (num_aula, num_mesas) VALUES (:numAula,:numMesas)";
        $this->params['numAula'] = $this->numAula;

        $this->params['numMesas'] = $this->numMesas;
        $this->get_results_from_query();
        $this->message = "Aula añadida";
    }
    public function edit()
    {
        $this->query = "UPDATE aulas SET num_aula=:numAula, num_mesas=:numMesas WHERE id=:id";
        $this->params['numAula'] = $this->numAula;
        $this->params['numMesas'] = $this->numMesas;
        $this->params['id'] = $this->id;
        $this->get_results_from_query();
        $this->message = "Aula editada";
    }
    public function delete($id = "")
    {
        if ($id == "") {
            $id = $this->id;
        }
        $this->query = "DELETE FROM aulas WHERE id=:id";
        $this->params['id'] = $id;
        $this->get_results_from_query();
        $this->message = "Aula borrada";
    }

    // Getters Propiedades
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

    public function getIdPorNumAula($numAula)
    {
        $this->query = "SELECT id FROM aulas WHERE num_aula = :numAula";
        $this->params['numAula'] = $numAula;
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

    // Setters Propiedades
    public function setId($id)
    {
        $this->id = $id;
    }
    public function setnumAula($numAula)
    {
        $this->numAula = $numAula;
    }
    
    public function setNumMesas($NumMesas)
    {
        $this->numMesas = $NumMesas;
    }

    
}
