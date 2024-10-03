<?php

namespace App\Controllers;

use App\Models\Aulas;
use App\Models\Equipos;
use App\Models\Ubicacion;

class EquiposController extends BaseController
{
    public function adminViewEquipos()
    {
        $equipos = Equipos::getInstancia();
        $ubicacion = Ubicacion::getInstancia();
        $aulas = Aulas::getInstancia();
        if (isset($_POST["buscar"])) {
            $data = [
                "valueInput" => $_POST["busqueda"],
                "equipos" => $equipos->buscar($_POST["busqueda"]),
                "estados" => $equipos->getAllEstados(),
                "ubicaciones" => $ubicacion->getAll(),
                "aulas" => $aulas->getAll()
            ];
        } else {
            $data = [
                "valueInput" => $_POST["busqueda"],
                "equipos" => $equipos->getAll(),
                "estados" => $equipos->getAllEstados(),
                "ubicaciones" => $ubicacion->getAll(),
                "aulas" => $aulas->getAll()
            ];
        }
        $this->renderHtml("../views/profesor/equipos/equiposViewAdmin.php", $data);
    }

    public function editEquipo($url)
    {
        $numero = explode("/", $url);
        $numero = end($numero);

        $equipos = Equipos::getInstancia();
        if (isset($_POST) && !empty($_POST)) {
            if (empty($_POST['codigo']) || empty($_POST['descripcion']) || empty($_POST['estado'])) {
                $_SESSION["fallo"] = "Completa todos los campos";
                header("Location: /admin/equipos/edit/$numero");
                exit();
            }
            if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
                $mimeType = mime_content_type($_FILES['imagen']['tmp_name']);
                $allowedMimeTypes = ['image/jpeg', 'image/png'];
                
                $extension = strtolower(pathinfo($_FILES['imagen']['name'], PATHINFO_EXTENSION));
                $allowedExtensions = ['jpg', 'jpeg', 'png'];
            
                if (in_array($mimeType, $allowedMimeTypes) && in_array($extension, $allowedExtensions)) {
                    $rutaImagenes = '/var/www/html/talleres/public/imagenes/';
                    
                    if (!is_dir($rutaImagenes)) {
                        if (!mkdir($rutaImagenes, 0777, true)) {
                            $_SESSION["fallo"] = "No se pudo crear el directorio de destino.";
                            header("Location: /admin/equipos/edit/$numero");
                            exit();
                        }
                    }
                    
                    $fechaHora = date('Y-m-d-H-i-s');
                    $nuevoNombreArchivo = $fechaHora . '.' . $extension;
                    $archivoDestino = $rutaImagenes . $nuevoNombreArchivo;
                    
                    if (!move_uploaded_file($_FILES['imagen']['tmp_name'], $archivoDestino)) {
                        $error = error_get_last();
                        $_SESSION["fallo"] = "No se pudo mover el archivo subido. Error: " . $error['message'];
                        header("Location: /admin/equipos/edit/$numero");
                        exit();
                    }
                } else {
                    $_SESSION["fallo"] = "Solo se permiten archivos JPG y PNG.";
                    header("Location: /admin/equipos/edit/$numero");
                    exit();
                }
            }
            
            $equipos->setId($numero);
            $equipos->setcodigo($_POST["codigo"]);
            $equipos->setdescripcion($_POST['descripcion']);
            $equipos->setreferencia_ja($_POST['referenciaJa'] != null ? $_POST['referenciaJa'] : "");
            $equipos->setImagen(
                ($nuevoNombreArchivo != null) 
                ? $nuevoNombreArchivo 
                : (
                    ($equipos->getImagen($numero)[0]["imagen"] != null) 
                    ? $equipos->getImagen($numero)[0]["imagen"] 
                    : ""
                )
            );
            $equipos->setEstado($_POST['estado']);
            $equipos->edit();
            header("Location: /admin/equipos/");
        }

        $data = [
            "id" => $numero,
            "codigo" => $equipos->getcodigo($numero)[0]["codigo"],
            "descripcion" => $equipos->getdescripcion($numero)[0]["descripcion"],
            "referencia_ja" => $equipos->getreferencia_ja($numero)[0]["referencia_ja"],
            "imagen" => $equipos->getImagen($numero)[0]["imagen"],
            "estado" => $equipos->getEstado($numero)[0]["t_estados_id"],
            "estados" => $equipos->getAllEstados()
        ];
        $this->renderHtml("../views/profesor/equipos/editEquipoView.php", $data);
    }

    public function addEquipo()
    {

        $equipos = Equipos::getInstancia();
        if (isset($_POST) && !empty($_POST)) {
            if (empty($_POST['codigo']) || empty($_POST['descripcion']) || empty($_POST['estado'])) {
                $_SESSION["fallo"] = "Completa todos los campos";
                header("Location: /admin/equipos/add");
                exit();
            }
            
            if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
                $mimeType = mime_content_type($_FILES['imagen']['tmp_name']);
                $allowedMimeTypes = ['image/jpeg', 'image/png'];
                
                $extension = strtolower(pathinfo($_FILES['imagen']['name'], PATHINFO_EXTENSION));
                $allowedExtensions = ['jpg', 'jpeg', 'png'];
            
                if (in_array($mimeType, $allowedMimeTypes) && in_array($extension, $allowedExtensions)) {
                    $rutaImagenes = '/var/www/html/talleres/public/imagenes/';
                    
                    if (!is_dir($rutaImagenes)) {
                        if (!mkdir($rutaImagenes, 0777, true)) {
                            $_SESSION["fallo"] = "No se pudo crear el directorio de destino.";
                            header("Location: /admin/equipos/add");
                            exit();
                        }
                    }
                    
                    $fechaHora = date('Y-m-d-H-i-s');
                    $nuevoNombreArchivo = $fechaHora . '.' . $extension;
                    $archivoDestino = $rutaImagenes . $nuevoNombreArchivo;
                    var_dump($archivoDestino);
                    
                    if (!move_uploaded_file($_FILES['imagen']['tmp_name'], $archivoDestino)) {
                        $error = error_get_last();
                        $_SESSION["fallo"] = "No se pudo mover el archivo subido. Error: " . $error['message'];
                        header("Location: /admin/equipos/add");
                        exit();
                    }
                } else {
                    $_SESSION["fallo"] = "Solo se permiten archivos JPG y PNG.";
                    header("Location: /admin/equipos/add");
                    exit();
                }
            }
            
            $equipos->setcodigo($_POST["codigo"]);
            $equipos->setdescripcion($_POST['descripcion']);
            $equipos->setreferencia_ja($_POST['referenciaJa'] != null ? $_POST['referenciaJa'] : "");
            $equipos->setImagen($nuevoNombreArchivo ? $nuevoNombreArchivo : "");
            $equipos->setEstado($_POST['estado']);
            $equipos->set();
            header("Location: /admin/equipos/");
        }
        $data = [
            "estados" => $equipos->getAllEstados()
        ];
        $this->renderHtml("../views/profesor/equipos/addEquipoView.php", $data);
    }

    public function deleteEquipo($url)
    {
        $numero = explode("/", $url);
        $numero = end($numero);
        $equipos = equipos::getInstancia();
        $equipos->delete($numero);
        header("Location: /admin/equipos/");
    }
}
