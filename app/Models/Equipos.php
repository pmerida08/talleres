<?php

namespace App\Models;

class Equipos extends DBAbstractModel
{
    static $instancia;
    private $id;
    private $codigo;
    private $descripcion;
    private $referencia_ja;
    private  $imagen;
    private  $t_estados_id;

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
        $this->query = "SELECT * FROM equipos WHERE id=:id";
        $this->params['id'] = $id;
        $this->get_results_from_query();
        $this->message = "equipo mostrado";
        return $this->rows;
    }
    public function getAll(){
        $this->query = "SELECT * FROM equipos order by codigo";
        $this->get_results_from_query();
        $this->message = "equipos mostrados";
        return $this->rows;
    }

    public function buscar($palabra)
    {
        $palabra = htmlspecialchars($palabra, ENT_QUOTES, 'UTF-8');
        $this->query = "SELECT * FROM equipos WHERE codigo LIKE :codigo";
        $this->params['codigo'] = "%$palabra%";
        $this->get_results_from_query();
        $this->message = "equipos mostrados";
        return $this->rows;
    }

    public function set()
    {
        $this->query = "INSERT INTO equipos (codigo, descripcion, referencia_ja, imagen, t_estados_id) VALUES (:codigo,:descripcion,:referencia_ja,:imagen,:t_estados_id)";
        $this->params['codigo'] = $this->codigo;
        $this->params['descripcion'] = $this->descripcion;
        $this->params['referencia_ja'] = $this->referencia_ja;
        $this->params['imagen'] = $this->imagen;
        $this->params['t_estados_id'] = $this->t_estados_id;

        $this->get_results_from_query();
        $this->message = "equipo añadido";
    }
    public function edit()
    {
        $this->query = "UPDATE equipos SET codigo=:codigo, descripcion=:descripcion, referencia_ja=:referencia_ja, imagen=:imagen, t_estados_id=:t_estados_id WHERE id=:id";
        $this->params['codigo'] = $this->codigo;
        $this->params['descripcion'] = $this->descripcion;
        $this->params['referencia_ja'] = $this->referencia_ja;
        $this->params['imagen'] = $this->imagen;
        $this->params['t_estados_id'] = $this->t_estados_id;
        $this->params['id'] = $this->id;
        $this->get_results_from_query();
        $this->message = "equipo editado";
    }
    public function delete($id = "")
    {
        if ($id == "") {
            $id = $this->id;
        }
        $this->query = "DELETE FROM equipos WHERE id=:id";
        $this->params['id'] = $id;
        $this->get_results_from_query();
        $this->message = "equipo borrado";
    }

    public function setEstadoById($id, $estado){
        $this->query = "UPDATE equipos SET t_estados_id=:t_estados_id WHERE id=:id";
        $this->params['t_estados_id'] = $estado;
        $this->params['id'] = $id;
        $this->get_results_from_query();
        $this->message = "estado cambiado";
    }

    // Getters Propiedades
    public function getId()
    {
        return $this->id;
    }
    public function getcodigo($id)
    {
        $this->query = "SELECT codigo FROM equipos WHERE id = :id";
        $this->params['id'] = $id;
        $this->get_results_from_query();
        return $this->rows;
    }
    public function getdescripcion($id)
    {
        $this->query = "SELECT descripcion FROM equipos WHERE id = :id";
        $this->params['id'] = $id;
        $this->get_results_from_query();
        return $this->rows;
    }
    public function getEstado($id)
    {
        $this->query = "SELECT t_estados_id FROM equipos WHERE id = :id";
        $this->params['id'] = $id;
        $this->get_results_from_query();
        return $this->rows;    
    }

    public function getAllEstados()
    {
        $this->query = "SELECT * FROM t_estados_equipos";
        $this->get_results_from_query();
        return $this->rows;    
    }
    public function getreferencia_ja($id)
    {
        $this->query = "SELECT referencia_ja FROM equipos WHERE id = :id";
        $this->params['id'] = $id;
        $this->get_results_from_query();
        return $this->rows;    
    }

    public function getImagen($id)
    {
        $this->query = "SELECT imagen FROM equipos WHERE id = :id";
        $this->params['id'] = $id;
        $this->get_results_from_query();
        return $this->rows;    
    }



    // Setters Propiedades
    public function setId($id)
    {
        $this->id = $id;
    }
    public function setcodigo($codigo)
    {
        $this->codigo = $codigo;
    }
    public function setdescripcion($descripcion)
    {
        $this->descripcion = $descripcion;
    }
    public function setreferencia_ja($referencia_ja)
    {
        $this->referencia_ja = $referencia_ja;
    }

    public function setImagen($imagen)
    {
        $this->imagen = $imagen;
    }
    
    public function setEstado($t_estados_id)
    {
        $this->t_estados_id = $t_estados_id;
    }
}
