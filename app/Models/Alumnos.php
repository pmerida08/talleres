<?php

namespace App\Models;

class Alumnos extends DBAbstractModel
{
    private $id;
    private $nombre;
    private $email;
    private $contrasena;
    private $activo;
    private $equipo_id;
    private $grupo_id;
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
        $this->query = "SELECT * FROM alumnos WHERE id=:id";
        $this->params['id'] = $id;
        $this->get_results_from_query();
        $this->message = "Alumno mostrado";
        return $this->rows;
    }
    public function getAll()
    {
        $this->query = "SELECT * FROM alumnos";
        $this->get_results_from_query();
        $this->message = "alumnos mostrados";
        return $this->rows;
    }

    public function buscar($palabra)
    {
        $palabra = htmlspecialchars($palabra, ENT_QUOTES, 'UTF-8');
        $this->query = "SELECT * FROM alumnos WHERE nombre LIKE :nombre";
        $this->params['nombre'] = "%$palabra%";
        $this->get_results_from_query();
        $this->message = "alumnos mostrados";
        return $this->rows;
    }

    public function set()
    {
        $this->query = "INSERT INTO alumnos (nombre, email, contrasena, activo, equipo_id, grupo_id) VALUES (:nombre,:email,:contrasena,:activo, :equipo_id, :grupo_id)";
        $this->params['nombre'] = $this->nombre;
        $this->params['email'] = $this->email;
        $this->params['contrasena'] = $this->contrasena;
        $this->params['activo'] = $this->activo;
        $this->params['equipo_id'] = $this->equipo_id;
        $this->params['grupo_id'] = $this->grupo_id;
        $this->get_results_from_query();
        $this->message = "alumno añadido";
    }

    public function insert($fila)
    {
        $nombre = $fila[0];
        $email = $fila[1];
        $contrasena = $fila[2];
        $activo = $fila[3];

        $this->query = "INSERT INTO alumnos (nombre, email, contrasena, activo) VALUES (:nombre, :email, :contrasena, :activo)";
        $this->params['nombre'] = $nombre;
        $this->params['email'] = $email;
        $this->params['contrasena'] = $contrasena;
        $this->params['activo'] = $activo;
        $this->get_results_from_query();
    }

    public function edit()
    {
        $this->query = "UPDATE alumnos SET nombre=:nombre, email=:email, activo=:activo, equipo_id=:equipo_id, grupo_id=:grupo_id WHERE id=:id";
        $this->params['nombre'] = $this->nombre;
        $this->params['email'] = $this->email;
        $this->params['activo'] = $this->activo;
        $this->params['equipo_id'] = $this->equipo_id;
        $this->params['grupo_id'] = $this->grupo_id;
        $this->params['id'] = $this->id;
        $this->get_results_from_query();
        $this->message = "alumno editado";
    }
    public function delete($id = "")
    {
        if ($id == "") {
            $id = $this->id;
        }
        $this->query = "DELETE FROM alumnos WHERE id=:id";
        $this->params['id'] = $id;
        $this->get_results_from_query();
        $this->message = "alumno borrado";
    }

    public function existeAlumno($nombre, $contrasena)
    {
        $this->query = "SELECT contrasena FROM alumnos WHERE nombre = :nombre";
        $this->params['nombre'] = $nombre;
        $this->get_results_from_query();

        if (count($this->rows) > 0) {
            $hashed_password = $this->rows[0]['contrasena'];

            if (password_verify($contrasena, $hashed_password)) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function existeAlumnoPorEmail($email)
    {
        $this->query = "SELECT COUNT(*) AS total FROM alumnos WHERE email = :email";
        $this->params['email'] = $email;
        $this->get_results_from_query();
        if ($this->rows[0]['total'] > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function asignarEquipo($alumno_id, $equipo_id)
    {
        $this->query = "UPDATE alumnos SET equipo_id = :equipo_id WHERE id = :alumno_id";
        $this->params['equipo_id'] = $equipo_id;
        $this->params['alumno_id'] = $alumno_id;
        $this->get_results_from_query();
    }

    public function getAlumnosConEquipo()
    {
        $this->query = "SELECT * FROM alumnos WHERE equipo_id IS NOT NULL";
        $this->params = [];
        $this->get_results_from_query();
        return $this->rows;
    }

    public function getAsignacionPorEquipoYAlumno($numeroPc, $alumnoId)
    {
        $this->query = "SELECT * FROM alumnos WHERE equipo_id = :equipo_id AND id = :alumno_id";
        $this->params['equipo_id'] = $numeroPc;
        $this->params['alumno_id'] = $alumnoId;
        $this->get_results_from_query();
        return $this->rows[0] ?? false;
    }


    public function eliminarAsignacion($alumnoId)
    {
        $this->query = "UPDATE alumnos SET equipo_id = NULL WHERE id = :alumno_id";
        $this->params['alumno_id'] = $alumnoId;
        $this->get_results_from_query();
    }



    public function limpiarEquipoAlumno($numero_pc)
    {
        $this->query = "UPDATE alumnos SET equipo_id = NULL WHERE equipo_id = :numero_pc";
        $this->params['numero_pc'] = $numero_pc;
        $this->get_results_from_query();
    }

    public function getAlumnosPorEquipo($numero_pc)
    {
        $this->query = "SELECT * FROM alumnos WHERE equipo_id = :numero_pc";
        $this->params['numero_pc'] = $numero_pc;
        $this->get_results_from_query();
        return $this->rows;
    }
    // Getters Propiedades
    public function getId()
    {
        return $this->id;
    }
    public function getNombre($id)
    {
        $this->query = "SELECT nombre FROM alumnos WHERE id = :id";
        $this->params['id'] = $id;
        $this->get_results_from_query();
        return $this->rows;
    }
    public function getEmail($id)
    {
        $this->query = "SELECT email FROM alumnos WHERE id = :id";
        $this->params['id'] = $id;
        $this->get_results_from_query();
        return $this->rows;
    }
    public function getContrasena($id)
    {
        $this->query = "SELECT contrasena FROM alumnos WHERE id = :id";
        $this->params['id'] = $id;
        $this->get_results_from_query();
        return $this->rows;
    }

    public function getActivoPorId($id)
    {
        $this->query = "SELECT * FROM alumnos WHERE id = :id";
        $this->params['id'] = $id;
        $this->get_results_from_query();
        return $this->rows;
    }

    public function getActivo($nombre, $contrasena)
    {
        $this->query = "SELECT contrasena, activo FROM alumnos WHERE nombre = :nombre";
        $this->params['nombre'] = $nombre;
        $this->get_results_from_query();

        if (count($this->rows) > 0) {
            $hashed_password = $this->rows[0]['contrasena'];
            $activo = $this->rows[0]['activo'];

            if (password_verify($contrasena, $hashed_password)) {
                if ($activo >= 1) {
                    return true;
                }
            }
        }
        return false;
    }


    public function getActivoPorEmail($email)
    {
        $this->query = "SELECT * FROM alumnos WHERE email = :email AND activo >= 1";
        $this->params['email'] = $email;
        $this->get_results_from_query();
        return !empty($this->rows);
    }

    public function getGrupo($id)
    {
        $this->query = "SELECT grupo_id FROM alumnos WHERE id = :id";
        $this->params['id'] = $id;
        $this->get_results_from_query();
        return $this->rows;
    }


    // Setters Propiedades
    public function setId($id)
    {
        $this->id = $id;
    }
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }
    public function setEmail($email)
    {
        $this->email = $email;
    }
    public function setContrasena($contrasena)
    {
        $this->contrasena = $contrasena;
    }
    public function setActivo($activo)
    {
        $this->activo = $activo;
    }

    public function setGrupo($grupo_id)
    {
        $this->grupo_id = $grupo_id;
    }
}
