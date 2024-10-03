<?php

namespace App\Models;

class Reservas extends DBAbstractModel
{
    static $instancia;
    private $id;
    private $fecha_inicio;
    private $fecha_final;
    private $equipos_id;
    private $observaciones;
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
        $this->query = "SELECT * FROM reservas WHERE id=:id";
        $this->params['id'] = $id;
        $this->get_results_from_query();
        $this->message = "reserva mostrada";
        return $this->rows;
    }
    public function getAll(){
        $this->query = "SELECT * FROM reservas";
        $this->get_results_from_query();
        $this->message = "reservas mostradas";
        return $this->rows;
    }
    public function set()
    {
        $this->query = "INSERT INTO reservas (fecha_inicio, fecha_final, equipos_id, profesores_id, observaciones) VALUES (:fecha_inicio,:fecha_final,:equipos_id,:profesores_id,:observaciones)";
        $this->params['fecha_inicio'] = $this->fecha_inicio;
        $this->params['fecha_final'] = $this->fecha_final;
        $this->params['equipos_id'] = $this->equipos_id;
        $this->params['profesores_id'] = $this->profesores_id;
        $this->params['observaciones'] = $this->observaciones;

        $this->get_results_from_query();
        $this->message = "reserva añadida";
    }
    public function edit()
    {
        $this->query = "UPDATE reservas SET fecha_inicio=:fecha_inicio, fecha_final=:fecha_final, equipos_id=:equipos_id, profesores_id=:profesores_id, observaciones=:observaciones WHERE id=:id";
        $this->params['fecha_inicio'] = $this->fecha_inicio;
        $this->params['fecha_final'] = $this->fecha_final;
        $this->params['equipos_id'] = $this->equipos_id;
        $this->params['profesores_id'] = $this->profesores_id;
        $this->params['observaciones'] = $this->observaciones;
        $this->params['id'] = $this->id;
        $this->get_results_from_query();
        $this->message = "reserva editada";
    }
    public function delete($id = "")
    {
        if ($id == "") {
            $id = $this->id;
        }
        $this->query = "DELETE FROM reservas WHERE id=:id";
        $this->params['id'] = $id;
        $this->get_results_from_query();
        $this->message = "reserva borrada";
    }

    public function getReservasPorProfesorId($profesores_id){
        $this->query = "SELECT * FROM reservas WHERE profesores_id LIKE :profesores_id";
        $this->params['profesores_id'] = "%$profesores_id%";
        $this->get_results_from_query();
        $this->message = "equipos mostrados";
        return $this->rows;
    }

    // Getters Propiedades
    public function getId()
    {
        return $this->id;
    }
    public function getFechaInicio($id)
    {
        $this->query = "SELECT fecha_inicio FROM reservas WHERE id = :id";
        $this->params['id'] = $id;
        $this->get_results_from_query();
        return $this->rows;
    }

    public function getObservaciones($id)
    {
        $this->query = "SELECT observaciones FROM reservas WHERE id = :id";
        $this->params['id'] = $id;
        $this->get_results_from_query();
        return $this->rows;
    }

    public function getFechaFinal($id)
    {
        $this->query = "SELECT fecha_final FROM reservas WHERE id = :id";
        $this->params['id'] = $id;
        $this->get_results_from_query();
        return $this->rows;
    }

    public function getFechaFinalIdEquipo($equipos_id)
    {
        $this->query = "SELECT fecha_final FROM reservas WHERE equipos_id = :equipos_id AND id != :id";
        $this->params['equipos_id'] = $equipos_id;
        $this->get_results_from_query();
        return $this->rows;
    }

    public function getReservasPorEquipoId($equipos_id, $id)
    {
        $this->query = "SELECT * FROM reservas WHERE equipos_id = :equipos_id AND id != :id";
        $this->params['equipos_id'] = $equipos_id;
        $this->params['id'] = $id;
        $this->get_results_from_query();
        return $this->rows;
    }
    
    public function getEquiposId($id)
    {
        $this->query = "SELECT equipos_id FROM reservas WHERE id = :id";
        $this->params['id'] = $id;
        $this->get_results_from_query();
        return $this->rows;    
    }

    public function getEquiposIdAll()
    {
        $this->query = "SELECT equipos_id FROM reservas";
        $this->get_results_from_query();
        return $this->rows;    
    }

    public function getProfesoresId($id)
    {
        $this->query = "SELECT profesores_id FROM reservas WHERE id = :id";
        $this->params['id'] = $id;
        $this->get_results_from_query();
        return $this->rows;    
    }

    // Setters Propiedades
    public function setId($id)
    {
        $this->id = $id;
    }
    public function setFechaInicio($fecha_inicio)
    {
        $this->fecha_inicio = $fecha_inicio;
    }

    public function setObservaciones($observaciones)
    {
        $this->observaciones = $observaciones;
    }

    public function setFechaFinal($fecha_final)
    {
        $this->fecha_final = $fecha_final;
    }
    public function setEquiposId($equipos_id)
    {
        $this->equipos_id = $equipos_id;
    }

    public function setProfesoresId($profesores_id)
    {
        $this->profesores_id = $profesores_id;
    }
}
