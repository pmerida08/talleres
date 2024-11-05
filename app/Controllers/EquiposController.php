<?php

namespace App\Controllers;

use App\Models\Aulas;
use App\Models\Equipos;
use App\Models\Ubicacion;
use App\Models\Alumnos;

class EquiposController extends BaseController
{
    public function adminViewEquipos()
    {
        echo $_SESSION["fallo"];
        $equiposModel = Equipos::getInstancia();
        $ubicacionModel = Ubicacion::getInstancia();
        $aulasModel = Aulas::getInstancia();
        $alumnosModel = Alumnos::getInstancia();

        if (isset($_POST["buscar"])) {
            $equiposList = $equiposModel->buscar($_POST["busqueda"]);
            $valueInput = $_POST["busqueda"];
        } else {
            $equiposList = $equiposModel->getAll();
            $valueInput = '';
        }

        $alumnosConEquipo = $alumnosModel->getAlumnosConEquipo();

        $alumnosPorEquipo = [];
        foreach ($alumnosConEquipo as $alumno) {
            $equipoId = $alumno['equipo_id'];
            if (!isset($alumnosPorEquipo[$equipoId])) {
                $alumnosPorEquipo[$equipoId] = [];
            }
            $alumnosPorEquipo[$equipoId][] = $alumno;
        }

        $equiposConAlumnos = [];
        foreach ($equiposList as $equipo) {
            $equipoId = $equipo['id'];
            $equipo['alumnos'] = $alumnosPorEquipo[$equipoId] ?? [];
            $equiposConAlumnos[] = $equipo;
        }

        $data = [
            "valueInput" => $valueInput,
            "equipos" => $equiposConAlumnos,
            "estados" => $equiposModel->getAllEstados(),
            "ubicaciones" => $ubicacionModel->getAll(),
            "aulas" => $aulasModel->getAll()
        ];

        $this->renderHtml("../views/profesor/equipos/equiposViewAdmin.php", $data);
    }



    public function editEquipo($url)
    {
        $numero = explode("/", $url);
        $numero = end($numero);

        $equipos = Equipos::getInstancia();
        $aulas = Aulas::getInstancia();
        $ubicacionModel = Ubicacion::getInstancia();
        $alumnosModel = Alumnos::getInstancia();

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST)) {
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
                ($nuevoNombreArchivo ?? null)
                    ? $nuevoNombreArchivo
                    : (
                        ($equipos->getImagen($numero)[0]["imagen"] ?? null)
                        ? $equipos->getImagen($numero)[0]["imagen"]
                        : ""
                    )
            );
            $equipos->setEstado($_POST['estado']);
            $equipos->edit();

            if (!empty($_POST['aula_id']) && !empty($_POST['puesto'])) {
                $ubicacionModel->deletePorEquipo($numero);
                $ubicacionModel->setEquipos_id($numero);
                $ubicacionModel->setAulas_id($_POST['aula_id']);
                $ubicacionModel->setPuesto($_POST['puesto']);
                $ubicacionModel->set();
            }

            header("Location: /admin/equipos/");
            exit();
        }

        $equipo = $equipos->get($numero);
        if (!$equipo) {
            $_SESSION["fallo"] = "El equipo no existe.";
            header("Location: /admin/equipos/");
            exit();
        }

        $alumnosAsignados = $alumnosModel->getAlumnosPorEquipo($numero);
        $ubicacion = $ubicacionModel->getPorEquiposId($numero);

        $data = [
            "id" => $numero,
            "codigo" => $equipos->getcodigo($numero)[0]["codigo"],
            "descripcion" => $equipos->getdescripcion($numero)[0]["descripcion"],
            "referencia_ja" => $equipos->getreferencia_ja($numero)[0]["referencia_ja"],
            "imagen" => $equipos->getImagen($numero)[0]["imagen"],
            "estado" => $equipos->getEstado($numero)[0]["t_estados_id"],
            "estados" => $equipos->getAllEstados(),
            "alumnosAsignados" => $alumnosAsignados,
            "aulas" => $aulas->getAll(),
            "ubicacion" => $ubicacion[0] ?? null
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

    public function addMasivaEquipos()
    {
        $equipos = Equipos::getInstancia();

        if (isset($_POST) && !empty($_POST)) {
            $cod = $_POST['codigo'];
            $descripcion = $_POST['descripcion'];
            $numeroEquipos = (int) $_POST['numeroEquipos'];
            $estado = $_POST['estado'];

            if (empty($cod) || $numeroEquipos <= 0 || empty($estado) || empty($descripcion)) {
                $_SESSION["fallo"] = "Completa todos los campos";
                header("Location: /admin/equipos/addMasivo");
                exit();
            }

            for ($i = 1; $i <= $numeroEquipos; $i++) {
                $codigo = $cod . "_" . str_pad($i, 2, '0', STR_PAD_LEFT);
                $equipos->setCodigo($codigo);
                $equipos->setDescripcion($descripcion);
                $equipos->setEstado($estado);
                $equipos->setImagen("");
                $equipos->set();
            }

            header("Location: /admin/equipos/");
            exit();
        }

        $data = [
            "estados" => $equipos->getAllEstados()
        ];
        $this->renderHtml("../views/profesor/equipos/addEquiposMasivoView.php", $data);
    }
    public function deleteEquipo($url)
    {
        $numero = explode("/", $url);
        $numero = end($numero);
        $equipos = equipos::getInstancia();
        $equipos->delete($numero);
        header("Location: /admin/equipos/");
    }
    public function mostrarFormularioAsignacion($request)
    {
        $equipos = Equipos::getInstancia();
        $alumnosModel = Alumnos::getInstancia();

        if (preg_match('/^\/asignarPc\/pc\/(\d+)$/', $request, $matches)) {
            $numero_pc = $matches[1];
        } else {
            header('Location: /admin/equipos/');
            exit;
        }

        $equipo = $equipos->get($numero_pc);

        if (!$equipo) {
            $error = "El equipo no existe.";
            $data = ['error' => $error];
            $this->renderHtml("../views/profesor/equipos/asignarEquipoView.php", $data);
            return;
        }

        $alumnos = [];
        if (isset($_POST["buscar"])) {
            $searchQuery = $_POST["busqueda"];
            $alumnos = $alumnosModel->buscar($searchQuery);
        } else {
            $searchQuery = '';
        }

        $data = [
            "valueInput" => $searchQuery,
            "numero_pc" => $numero_pc,
            "equipo" => $equipo[0],
            "alumnos" => $alumnos,
        ];

        $this->renderHtml("../views/profesor/equipos/asignarEquipoView.php", $data);
    }


    public function asignarPc($url)
    {
        $equiposModel = Equipos::getInstancia();

        $urlParts = explode('/', $url);
        $numero_pc = $urlParts[3];

        $equipoExistente = $equiposModel->get($numero_pc);

        if (!$equipoExistente) {
            $error = "El equipo no existe.";
            $this->renderHtml("../views/profesor/equipos/asignarEquipoView.php", ['error' => $error]);
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $alumno_id = $_POST['alumno_id'];
            if (!$alumno_id) {
                $error = "Debe seleccionar un alumno.";
            } else {
                $alumnosModel = Alumnos::getInstancia();
                $alumnosModel->asignarEquipo($alumno_id, $numero_pc);
                $equiposModel->setEstadoById($numero_pc, 6);

                header('Location: /admin/equipos/');
                exit;
            }
        } else {
            header('Location: /admin/equipos/');
            exit;
        }
    }

    public function borrarAlumno($url)
    {
        $partesUrl = explode("/", $url);
        $numero = $partesUrl[4];

        if (isset($_POST['alumno_id']) && !empty($_POST['alumno_id'])) {
            $alumnoId = $_POST['alumno_id'];

            $alumnosModel = Alumnos::getInstancia();

            $asignacion = $alumnosModel->getAsignacionPorEquipoYAlumno($numero, $alumnoId);

            if ($asignacion) {
                $alumnosModel->eliminarAsignacion($alumnoId);

                header("Location: /admin/equipos/edit/$numero");
                exit();
            } else {
                $_SESSION["fallo"] = "El alumno no está asignado a este equipo.";
                header("Location: /admin/equipos/edit/$numero");
                exit();
            }
        } else {
            $_SESSION["fallo"] = "No se proporcionó un ID de alumno válido.";
            header("Location: /admin/equipos/edit/$numero");
            exit();
        }
    }
}
