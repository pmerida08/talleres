<?php

namespace App\Controllers;

use App\Models\Alumnos;
use App\Models\Profesores;
use Google\Service\Oauth2 as Google_Service_Oauth2;

class AdminController extends BaseController
{
    public function adminLogIn()
    {
        $profesores = Profesores::getInstancia();
        $alumnos = Alumnos::getInstancia();
        if (isset($_POST) && !empty($_POST)) {
            if (empty($_POST['user']) || empty($_POST['password'])) {
                header('Location: /');
                exit();
            }

            $nombre = $_POST['user'];
            $password = $_POST['password'];

            if ($profesores->existeProfesor($nombre, $password)) {
                $_SESSION["perfil"] = "profesor";
                $_SESSION["idPerfil"] = $profesores->getIdPorNombreContrasena($nombre, $password);
                header("Location: /");
            } elseif ($alumnos->existeAlumno($nombre, $password)) {
                $_SESSION["perfil"] = $alumnos->getActivo($nombre, $password) ? "alumno" : "invitado";
                header("Location: /");
            } else {
                $_SESSION["perfil"] = "invitado";
                $_SESSION["fallo"] = "Usuario o contraseña erroneos";
                header("Location: /login/");
            }
            exit();
        } else if (isset($_GET["code"])) {
            $token = CLIENT->fetchAccessTokenWithAuthCode($_GET["code"]);
            CLIENT->setAccessToken($token["access_token"]);

            $google_oauth = new Google_Service_Oauth2(CLIENT);
            $google_account_info = $google_oauth->userinfo->get();
            $email = $google_account_info->email;
            
            
            if ($profesores->existeProfesorPorEmail($email)) {
                $_SESSION["perfil"] = "profesor";
                $_SESSION["fallo"] = false;
                header("Location: /");
            } elseif ($alumnos->existeAlumnoPorEmail($email)) {
                $_SESSION["perfil"] = $alumnos->getActivoPorEmail($email) ? "alumno" : "invitado";
                $_SESSION["fallo"] = false;
                header("Location: /");
            } else {
                $_SESSION["perfil"] = "invitado";
                $_SESSION["fallo"] = true;
                header("Location: /login/");
                // var_dump($_POST['contrasena']);
            }
        }
        $this->renderHtml("../views/profesor/logIn.php");
    }

    public function adminLogOut()
    {
        $this->renderHtml("../views/profesor/logOut.php");
    }
}
