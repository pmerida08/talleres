<?php
namespace App\Controllers;

use App\Models\Profesores;
use App\Models\Alumnos;
use App\Models\Reservas;
use App\Models\Equipos;

class ProfesoresController extends BaseController
{
    public function profesoresView()
    {
        $profesores = Profesores::getInstancia();
        if (isset($_POST["buscar"])) {
            $data = [
                "valueInput" => $_POST["busqueda"],
                "profesores" => $profesores->buscar($_POST["busqueda"])
            ];
        } else {
            $data = [
                "profesores" => $profesores->getAll()
            ];
        }
        $this->renderHTML("../views/profesor/profesores/profesoresView.php", $data);
    }

    public function profesoresExportar()
    {
        $profesores = Profesores::getInstancia();
        $datos_profesores = $profesores->getAll();

        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="profesores.csv"');

        $output = fopen('php://output', 'w');

        fputcsv($output, array('id', 'nombre', 'email', 'contrasena'));

        foreach ($datos_profesores as $profesor) {
            fputcsv($output, $profesor);
        }
        fclose($output);
    }

    public function profesoresImportar()
    {
        if (!isset($_FILES["archivoCvs"]) || empty($_FILES["archivoCvs"]["tmp_name"])) {
            header("Location: /admin/profesores/");
            exit();
        }
    
        $profesores = Profesores::getInstancia();
        $archivo_tmp = $_FILES["archivoCvs"]["tmp_name"];
        $csv = fopen($archivo_tmp, 'r');
    
        if ($csv !== false) {
            while (($fila = fgetcsv($csv)) !== false) {
                $profesores->insert($fila);
            }
            fclose($csv);
    
            header('Location: /admin/profesores/');
            exit();
        } else {
            echo "Error al abrir el archivo CSV";
        }
    }

    public function profesorAdd()
    {
        $profesores = Profesores::getInstancia();
        $alumnos = Alumnos::getInstancia();
        if (isset($_POST) && !empty($_POST)) {
            if (empty($_POST['nombre']) || empty($_POST['email']) || empty($_POST['contrasena'])) {
                $_SESSION["fallo"] = "Completa todos los campos";
                header("Location: /admin/profesores/add");
                exit();
            }
            if ($alumnos->existeAlumno($_POST['nombre'], $_POST['contrasena']) || $profesores->existeProfesor($_POST['nombre'], $_POST['contrasena'])) {
                $_SESSION["fallo"] = "Usuario Existente";
                header("Location: /admin/profesores/add");
                exit();
            }
            if (!ctype_alpha($_POST['nombre']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
                $_SESSION["fallo"] = "Nombre o email incorrectos";
                header("Location: /admin/profesores/add");
                exit();
            }
            $profesores->setNombre($_POST["nombre"]);
            $profesores->setEmail($_POST['email']);
            $profesores->setContrasena(password_hash($_POST["contrasena"], PASSWORD_DEFAULT));
            $profesores->set();
            header("Location: /admin/profesores/");
        }
        $data = [];
        $this->renderHtml("../views/profesor/profesores/addProfesorView.php", $data);
    }

    public function profesorEdit($url)
    {
        $numero = explode("/", $url);
        $numero = end($numero);

        $profesores = Profesores::getInstancia();
        $alumnos = Alumnos::getInstancia();
        $reservas = Reservas::getInstancia();
        $equipos = Equipos::getInstancia();

        if (isset($_POST) && !empty($_POST)) {
            if (empty($_POST['nombre']) || empty($_POST['email']) || empty($_POST['contrasena'])) {
                $_SESSION["fallo"] = "Completa todos los campos";
                header("Location: /admin/profesores/edit/$numero");
                exit();
            }
            if ($alumnos->existeAlumno($_POST['nombre'], $_POST['contrasena'])) {
                $_SESSION["fallo"] = "Usuario Existente";
                header("Location: /admin/profesores/edit/$numero");
                exit();
            }
            if (!ctype_alpha($_POST['nombre']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
                $_SESSION["fallo"] = "Nombre o email incorrectos";
                header("Location: /admin/profesores/edit/$numero");
                exit();
            }
            $profesores->setId($numero);
            $profesores->setNombre($_POST["nombre"]);
            $profesores->setEmail($_POST['email']);
            $profesores->setContrasena(password_hash($_POST["contrasena"], PASSWORD_DEFAULT));
            $profesores->edit();
            header("Location: /admin/profesores/");
        }
        $data = [
            "id" => $numero,
            "nombre" => $profesores->getNombre($numero)[0]["nombre"],
            "email" => $profesores->getEmail($numero)[0]["email"],
            "reservas" =>$reservas->getReservasPorProfesorId($numero),
            "equipos" => $equipos->getAll()
        ];
        $this->renderHtml("../views/profesor/profesores/editprofesorView.php", $data);
    }

    public function profesoresDel($url)
    {
        $numero = explode("/", $url);
        $numero = end($numero);
        $profesores = Profesores::getInstancia();
        $profesores->delete($numero);
        header("Location: /admin/profesores/");
    }
}
