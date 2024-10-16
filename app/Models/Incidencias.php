<?php

namespace App\Models;

class Incidencias extends DBAbstractModel
{
    static $instancia;
    private $id;
    private $descripcion;
    private $fecha;
    private $fecha_solucion;
    private $aulas_id;
    private $profesores_id;

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
        $this->query = "SELECT * FROM incidencias WHERE id=:id";
        $this->params['id'] = $id;
        $this->get_results_from_query();
        $this->message = "inicidencia mostrada";
        return $this->rows;
    }
    public function getAll(){
        $this->query = "SELECT * FROM incidencias";
        $this->get_results_from_query();
        $this->message = "incidencias mostradas";
        return $this->rows;
    }

    public function getPorAulaId($aulas_id = "")
    {
        $this->query = "SELECT * FROM incidencias WHERE aulas_id=:aulas_id";
        $this->params['aulas_id'] = $aulas_id;
        $this->get_results_from_query();
        $this->message = "inicidencia mostrada";
        return $this->rows;
    }

    public function set()
    {
        $this->query = "INSERT INTO incidencias (descripcion, fecha, fecha_solucion, aulas_id, profesores_id) VALUES (:descripcion,:fecha,:fecha_solucion,:aulas_id,:profesores_id)";
        $this->params['descripcion'] = $this->descripcion;
        $this->params['fecha'] = $this->fecha;
        $this->params['fecha_solucion'] = $this->fecha_solucion;
        $this->params['aulas_id'] = $this->aulas_id;
        $this->params['profesores_id'] = $this->profesores_id;

        $this->get_results_from_query();
        $this->message = "inicidencia añadido";
    }
    public function edit()
    {
        $this->query = "UPDATE incidencias SET descripcion=:descripcion, fecha=:fecha, fecha_solucion=:fecha_solucion, aulas_id=:aulas_id, profesores_id=:profesores_id WHERE id=:id";
        $this->params['descripcion'] = $this->descripcion;
        $this->params['fecha'] = $this->fecha;
        $this->params['fecha_solucion'] = $this->fecha_solucion;
        $this->params['aulas_id'] = $this->aulas_id;
        $this->params['profesores_id'] = $this->profesores_id;
        $this->params['id'] = $this->id;
        $this->get_results_from_query();
        $this->message = "inicidencia editada";
    }
    public function delete($id = "")
    {
        if ($id == "") {
            $id = $this->id;
        }
        $this->query = "DELETE FROM incidencias WHERE id=:id";
        $this->params['id'] = $id;
        $this->get_results_from_query();
        $this->message = "inicidencia borrada";
    }

    // Getters Propiedades
    public function getId()
    {
        return $this->id;
    }
    public function getDescripcion($id)
    {
        $this->query = "SELECT descripcion FROM incidencias WHERE id = :id";
        $this->params['id'] = $id;
        $this->get_results_from_query();
        return $this->rows;
    }
    public function getFecha($id)
    {
        $this->query = "SELECT fecha FROM incidencias WHERE id = :id";
        $this->params['id'] = $id;
        $this->get_results_from_query();
        return $this->rows;
    }
    public function getProfesoresId($id)
    {
        $this->query = "SELECT profesores_id FROM incidencias WHERE id = :id";
        $this->params['id'] = $id;
        $this->get_results_from_query();
        return $this->rows;    
    }
    public function getFechaSolucion($id)
    {
        $this->query = "SELECT fecha_solucion FROM incidencias WHERE id = :id";
        $this->params['id'] = $id;
        $this->get_results_from_query();
        return $this->rows;    
    }

    public function getAulasId($id)
    {
        $this->query = "SELECT aulas_id FROM incidencias WHERE id = :id";
        $this->params['id'] = $id;
        $this->get_results_from_query();
        return $this->rows;    
    }

    // Setters Propiedades
    public function setId($id)
    {
        $this->id = $id;
    }
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;
    }
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;
    }
    public function setFechaSolucion($fecha_solucion)
    {
        $this->fecha_solucion = $fecha_solucion;
    }

    public function setIdAulas($aulas_id)
    {
        $this->aulas_id = $aulas_id;
    }
    
    public function setIdProfesores($profesores_id)
    {
        $this->profesores_id = $profesores_id;
    }
}
