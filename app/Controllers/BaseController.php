<?php
    namespace App\Controllers;

    class BaseController {
        public function renderHTML($fileName, $data = []) { // $fileName = String con la ruta del archivo a renderizar, $data = Array con los datos a renderizar
            include($fileName);
        }
    }
