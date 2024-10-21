<?php

namespace App\Models;

class Grupos extends DBAbstractModel
{
    static $instancia;
    private $id;
    private $nombre_grupo;

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
        $this->query = "SELECT * FROM grupos order by nombre_grupo";
        $this->get_results_from_query();
        $this->message = "grupos mostrados";
        return $this->rows;
    }

    public function set()
    {
        $this->query = "INSERT INTO grupos (nombre_grupo) VALUES (:nombre_grupo)";
        $this->params['nombre_grupo'] = $this->nombre_grupo;
        $this->get_results_from_query();
        $this->message = "grupo guardado";
    }

    public function edit()
    {
        $this->query = "UPDATE grupos SET nombre_grupo=:nombre_grupo WHERE id=:id";
        $this->params['id'] = $this->id;
        $this->params['nombre_grupo'] = $this->nombre_grupo;
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
        $this->query = "SELECT nombre_grupo FROM grupos WHERE id=:id";
        $this->params['id'] = $id;
        $this->get_results_from_query();
        return $this->rows;
    }

    public function getGrupoIdByName($nombreGrupo)
    {
        $this->query = "SELECT id FROM grupos WHERE nombre_grupo = :nombre_grupo";
        $this->params['nombre_grupo'] = $nombreGrupo;
        $this->get_results_from_query();

        // Verificamos si hay resultados
        if (isset($this->rows) && !empty($this->rows)) {
            return $this->rows[0]['id'];
        } else {
            // Manejo de error si no se encuentra el grupo
            echo "No se encontró grupo para: " . htmlspecialchars($nombreGrupo) . "<br>";
            return null;
        }
    }


    public function setId($id)
    {
        $this->id = $id;
    }

    public function setNombre($nombre_grupo)
    {
        $this->nombre_grupo = $nombre_grupo;
    }

    // Tabla intermedia aulas_grupos

    public function getGrupoIdPorAulaId($aula_id)
    {
        $this->query = "SELECT grupo_id FROM aulas_grupos WHERE aula_id = :aula_id";
        $this->params['aula_id'] = $aula_id;
        $this->get_results_from_query();
        return $this->rows;
    }
}
