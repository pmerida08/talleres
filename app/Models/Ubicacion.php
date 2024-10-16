<?php

namespace App\Models;

class Ubicacion extends DBAbstractModel
{
    private $id;
    private $puesto;
    private $aulas_id;
    private $equipos_id;
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

    public function getAll()
    {
        $this->query = "SELECT * FROM ubicacion";
        $this->get_results_from_query();
        $this->message = "Ubicacion mostrada";
        return $this->rows;
    }

    public function get($id = "")
    {
    }

    public function getUbicacionPorId($aulas_id = "")
    {
        $this->query = "SELECT * FROM ubicacion WHERE aulas_id=:aulas_id";
        $this->params['aulas_id'] = $aulas_id;
        $this->get_results_from_query();
        $this->message = "Ubicaciones mostradas";
        return $this->rows;
    }
    
    public function existeUbicacionPorPuesto($puesto = "", $aulas_id = "")
    {
        $this->query = "SELECT COUNT(*) as count FROM ubicacion WHERE puesto=:puesto AND aulas_id=:aulas_id";
        $this->params['puesto'] = $puesto;
        $this->params['aulas_id'] = $aulas_id;
        $this->get_results_from_query();
        $count = $this->rows[0]['count'];
        return $count > 0;
    }

    public function existeUbicacionPorEquipo($equipos_id = "")
    {
        $this->query = "SELECT COUNT(*) as count FROM ubicacion WHERE equipos_id=:equipos_id";
        $this->params['equipos_id'] = $equipos_id;
        $this->get_results_from_query();
        $count = $this->rows[0]['count'];
        return $count > 0;
    }
    public function set()
    {
        $this->query = "INSERT INTO ubicacion (puesto, aulas_id, equipos_id) VALUES (:puesto,:aulas_id,:equipos_id)";
        $this->params['puesto'] = $this->puesto;
        $this->params['aulas_id'] = $this->aulas_id;
        $this->params['equipos_id'] = $this->equipos_id;
        $this->get_results_from_query();
        $this->message = "Ubicación añadida";
    }
    public function edit()
    {
        $this->query = "UPDATE ubicacion SET puesto=:puesto, aulas_id=:aulas_id, equipos_id=:equipos_id WHERE puesto=:puesto AND aulas_id=:aulas_id";
        $this->params['puesto'] = $this->puesto;
        $this->params['aulas_id'] = $this->aulas_id;
        $this->params['equipos_id'] = $this->equipos_id;
        $this->get_results_from_query();
        $this->message = "Ubicación editada";
    }
    public function delete($equipos_id = "")
    {
        $this->query = "DELETE FROM ubicacion WHERE equipos_id = :equipos_id";
        $this->params['equipos_id'] = $equipos_id;
        $this->get_results_from_query();
        $this->message = "Ubicación borrada";
    }

    public function deletePorPuestoYIdAula($puesto, $aulas_id)
    {
        $this->query = "DELETE FROM ubicacion WHERE puesto = :puesto AND aulas_id = :aulas_id";
        $this->params['puesto'] = $puesto;
        $this->params['aulas_id'] = $aulas_id;
        $this->get_results_from_query();
        $this->message = "Ubicación borrada";
    }

    // // Getters Propiedades

    public function getIdEquipos(){
        $this->query = "SELECT equipos_id FROM ubicacion";
        $this->get_results_from_query();
        return $this->rows;
    }
    public function deletePorEquipo($equipos_id)
{
    $this->query = "DELETE FROM ubicacion WHERE equipos_id = :equipos_id";
    $this->params['equipos_id'] = $equipos_id;
    $this->get_results_from_query();
    $this->message = "Ubicación eliminada";
}

public function getPorEquiposId($equipos_id)
{
    $this->query = "SELECT * FROM ubicacion WHERE equipos_id = :equipos_id";
    $this->params['equipos_id'] = $equipos_id;
    $this->get_results_from_query();
    return $this->rows;
}

    
    // public function getId()
    // {
    //     return $this->id;
    // }
    // public function getpuesto($id)
    // {
    //     $this->query = "SELECT num_aula FROM aulas WHERE id = :id";
    //     $this->params['id'] = $id;
    //     $this->get_results_from_query();
    //     return $this->rows;
    // }
    // public function getaulas_id($id)
    // {
    //     $this->query = "SELECT aulas_id FROM aulas WHERE id = :id";
    //     $this->params['id'] = $id;
    //     $this->get_results_from_query();
    //     return $this->rows;    
    // }

    // public function getAllaulas_id()
    // {
    //     $this->query = "SELECT * FROM t_aulas_id_aulas";
    //     $this->get_results_from_query();
    //     return $this->rows;    
    // }
    // public function getequipos_id($id)
    // {
    //     $this->query = "SELECT num_mesas FROM aulas WHERE id = :id";
    //     $this->params['id'] = $id;
    //     $this->get_results_from_query();
    //     return $this->rows;    
    // }

    // Setters Propiedades
    public function setId($id)
    {
        $this->id = $id;
    }
    public function setPuesto($puesto)
    {
        $this->puesto = $puesto;
    }
    public function setAulas_id($aulas_id)
    {
        $this->aulas_id = $aulas_id;
    }
    public function setEquipos_id($equipos_id)
    {
        $this->equipos_id = $equipos_id;
    }
}
