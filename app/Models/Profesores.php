<?php

namespace App\Models;

class Profesores extends DBAbstractModel
{
    private $id;
    private $nombre;
    private $email;
    private $contrasena;
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
        $this->query = "SELECT * FROM profesores WHERE id=:id";
        $this->params['id'] = $id;
        $this->get_results_from_query();
        $this->message = "Profesor mostrado";
        return $this->rows;
    }
    public function getAll()
    {
        $this->query = "SELECT * FROM profesores";
        $this->get_results_from_query();
        $this->message = "profesores mostrados";
        return $this->rows;
    }

    public function buscar($palabra)
    {
        $palabra = htmlspecialchars($palabra, ENT_QUOTES, 'UTF-8');
        $this->query = "SELECT * FROM profesores WHERE nombre LIKE :nombre";
        $this->params['nombre'] = "%$palabra%";
        $this->get_results_from_query();
        $this->message = "profesores mostrados";
        return $this->rows;
    }

    public function set()
    {
        $this->query = "INSERT INTO profesores (nombre, email, contrasena) VALUES (:nombre,:email,:contrasena)";
        $this->params['nombre'] = $this->nombre;
        $this->params['email'] = $this->email;
        $this->params['contrasena'] = $this->contrasena;
        $this->get_results_from_query();
        $this->message = "profesor añadido";
    }
    public function insert($fila)
    {
        $nombre = $fila[0];
        $email = $fila[1];
        $contrasena = $fila[2];

        $this->query = "INSERT INTO profesores (nombre, email, contrasena) VALUES (:nombre, :email, :contrasena)";
        $this->params['nombre'] = $nombre;
        $this->params['email'] = $email;
        $this->params['contrasena'] = $contrasena;
        $this->get_results_from_query();
    }
    public function edit()
    {
        $this->query = "UPDATE profesores SET nombre=:nombre, email=:email, contrasena=:contrasena WHERE id=:id";
        $this->params['nombre'] = $this->nombre;
        $this->params['email'] = $this->email;
        $this->params['contrasena'] = $this->contrasena;
        $this->params['id'] = $this->id;
        $this->get_results_from_query();
        $this->message = "profesor editado";
    }
    public function delete($id = "")
    {
        if ($id == "") {
            $id = $this->id;
        }
        $this->query = "DELETE FROM profesores WHERE id=:id";
        $this->params['id'] = $id;
        $this->get_results_from_query();
        $this->message = "profesor borrado";
    }

    public function existeProfesor($nombre, $contrasena)
    {
        $this->query = "SELECT contrasena FROM profesores WHERE nombre = :nombre";
        $this->params['nombre'] = $nombre;
        $this->get_results_from_query();
    
        if (count($this->rows) > 0) {
            $hashed_password = $this->rows[0]['contrasena'];
            if (password_verify($contrasena, $hashed_password)) {
                return true;
            }
        }
        return false;
    }
    

    public function existeProfesorPorEmail($email)
    {
        $this->query = "SELECT COUNT(*) AS total FROM profesores WHERE email = :email";
        $this->params['email'] = $email;
        $this->get_results_from_query();
        if ($this->rows[0]['total'] > 0) {
            return true;
        } else {
            return false;
        }
    }

    // Getters Propiedades
    public function getId()
    {
        return $this->id;
    }

    public function getIdPorNombreContrasena($nombre, $password)
    {
        $this->query = "SELECT id, contrasena FROM profesores WHERE nombre = :nombre";
        $this->params['nombre'] = $nombre;
        $this->get_results_from_query();
    
        if (count($this->rows) > 0) {
            $hashed_password = $this->rows[0]['contrasena'];
                if (password_verify($password, $hashed_password)) {
                return $this->rows[0]['id'];
            }
        }
        return false;   
    }
    
    public function getIdPorNombre($nombre)
    {
        $this->query = "SELECT id FROM profesores WHERE nombre LIKE :nombre";
        $this->params['nombre'] = $nombre;
        $this->get_results_from_query();
        return $this->rows;
    }

    public function getnombre($id)
    {
        $this->query = "SELECT nombre FROM profesores WHERE id = :id";
        $this->params['id'] = $id;
        $this->get_results_from_query();
        return $this->rows;
    }
    public function getemail($id)
    {
        $this->query = "SELECT email FROM profesores WHERE id = :id";
        $this->params['id'] = $id;
        $this->get_results_from_query();
        return $this->rows;
    }

    public function getContrasena($id)
    {
        $this->query = "SELECT contrasena FROM profesores WHERE id = :id";
        $this->params['id'] = $id;
        $this->get_results_from_query();
        return $this->rows;
    }

    // Setters Propiedades
    public function setId($id)
    {
        $this->id = $id;
    }
    public function setnombre($nombre)
    {
        $this->nombre = $nombre;
    }
    public function setemail($email)
    {
        $this->email = $email;
    }
    public function setcontrasena($contrasena)
    {
        $this->contrasena = $contrasena;
    }
}
