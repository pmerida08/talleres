<?php

namespace App\Controllers;

use App\Models\Alumnos;
use App\Models\Equipos;
use App\Models\Profesores;
use App\Models\Grupos;

class AlumnosController extends BaseController
{
    public function alumnosView()
    {
        $alumnos = Alumnos::getInstancia();
        $grupos = Grupos::getInstancia();
        if (isset($_POST["buscar"])) {
            $data = [
                "valueInput" => $_POST["busqueda"],
                "alumnos" => $alumnos->buscar($_POST["busqueda"])
            ];
        } else {
            $data = [
                "alumnos" => $alumnos->getAll(),
                "grupos" => $grupos->getAll()
            ];
        }
        $this->renderHTML("../views/profesor/alumnos/alumnosView.php", $data);
    }

    public function alumnosExportar()
    {
        $alumnos = Alumnos::getInstancia();
        $datos_alumnos = $alumnos->getAll();

        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="alumnos.csv"');

        $output = fopen('php://output', 'w');

        fputcsv($output, array('id', 'nombre', 'email', 'contrasena', 'activo', 'aula_id', 'grupo_id'));

        foreach ($datos_alumnos as $alumno) {
            unset($alumno[0]);
            fputcsv($output, $alumno);
        }
        fclose($output);
    }

    public function alumnosImportar()
    {
        if (!isset($_FILES["archivoCvs"]) || empty($_FILES["archivoCvs"]["tmp_name"])) {
            header("Location: /admin/alumnos/");
            exit();
        }

        $alumnos = Alumnos::getInstancia();
        $grupos = Grupos::getInstancia();

        $archivo_tmp = $_FILES["archivoCvs"]["tmp_name"];
        $csv = fopen($archivo_tmp, 'r');

        if ($csv !== false) {
            stream_filter_append($csv, 'convert.iconv.ISO-8859-9/UTF-8');
            // Leer la primera fila (encabezados)
            fgetcsv($csv, 0, ';');


            while (($fila = fgetcsv($csv, 0, ';')) !== false) {
                
                $alumnos->setNombre($fila[0]);
                $alumnos->setEmail("");
                $alumnos->setContrasena(PASSWORD_DEFAULT); 
                $alumnos->setActivo(1); 
                $alumnos->setGrupo($grupos->getGrupoIdByName($fila[1]) ? $grupos->getGrupoIdByName($fila[1]) : null);

                // Guardar el alumno en la base de datos
                $alumnos->insert($fila);
            }

            fclose($csv);

            // Redireccionar después de insertar los alumnos
            // header('Location: /admin/alumnos/');
            exit();
        } else {
            echo "Error al abrir el archivo CSV";
        }
    }



    public function alumnoAdd()
    {
        $alumnos = Alumnos::getInstancia();
        $profesores = Profesores::getInstancia();

        if (isset($_POST) && !empty($_POST)) {
            if (empty($_POST['nombre']) || empty($_POST['email']) || empty($_POST['contrasena'])) {
                $_SESSION["fallo"] = "Completa todos los campos";
                header("Location: /admin/alumnos/add");
                exit();
            }
            if ($alumnos->existeAlumno($_POST['nombre'], $_POST['contrasena']) || $profesores->existeProfesor($_POST['nombre'], $_POST['contrasena'])) {
                $_SESSION["fallo"] = "Usuario ya existente";
                header("Location: /admin/alumnos/add");
                exit();
            }
            if (!ctype_alpha($_POST['nombre']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
                $_SESSION["fallo"] = "Nombre o email incorrecto";
                header("Location: /admin/alumnos/add");
                exit();
            }
            $alumnos->setNombre($_POST["nombre"]);
            $alumnos->setEmail($_POST['email']);
            $alumnos->setContrasena(password_hash($_POST["contrasena"], PASSWORD_DEFAULT));
            $alumnos->setActivo(isset($_POST["activo"]) ? 0 : 1);
            $alumnos->set();
            header("Location: /admin/alumnos/");
        }
        $data = [];
        $this->renderHtml("../views/profesor/alumnos/addAlumnoView.php", $data);
    }

    public function alumnoEdit($url)
    {
        $numero = explode("/", $url);
        $numero = end($numero);

        $alumnos = Alumnos::getInstancia();
        $grupos = Grupos::getInstancia();
        // $profesores = Profesores::getInstancia();

        if (isset($_POST) && !empty($_POST)) {
            if (empty($_POST['nombre']) || empty($_POST['email'])) {
                $_SESSION["fallo"] = "Completa todos los campos";
                header("Location: /admin/alumnos/edit/$numero");
                exit();
            }
            // if ($profesores->existeProfesor($_POST['nombre'], $_POST['contrasena'])) {
            //     $_SESSION["fallo"] = "Usuario Existente";
            //     header("Location: /admin/alumnos/edit/$numero");
            //     exit();
            // }
            if (!ctype_alpha($_POST['nombre']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
                $_SESSION["fallo"] = "Nombre o email incorrecto";
                header("Location: /admin/alumnos/edit/$numero");
                exit();
            }
            $alumnos->setId($numero);
            $alumnos->setNombre($_POST["nombre"]);
            $alumnos->setEmail($_POST['email']);
            $alumnos->setGrupo($_POST["grupo"]);
            $alumnos->edit();
            header("Location: /admin/alumnos/");
        }
        $data = [
            "id" => $numero,
            "nombre" => $alumnos->getNombre($numero)[0]["nombre"],
            "email" => $alumnos->getEmail($numero)[0]["email"],
            "activo" => $alumnos->getActivoPorId($numero)[0]["activo"],
            "grupo_id" => $alumnos->getGrupo($numero)[0]["grupo_id"],
            "grupos" => $grupos->getAll()
        ];
        $this->renderHtml("../views/profesor/alumnos/editAlumnoView.php", $data);
    }

    public function alumnosDel($url)
    {
        $numero = explode("/", $url);
        $numero = end($numero);
        $alumnos = Alumnos::getInstancia();
        $alumnos->delete($numero);
        header("Location: /admin/alumnos/");
    }
}
