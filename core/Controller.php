<?php
class Controller {
    public function view($view, $data = []) {
        // Extraer datos para la vista
        extract($data);
        
        // Verificar si existe la vista
        $viewFile = __DIR__ . '/../App/views/' . $view . '.php';
        if(file_exists($viewFile)) {
            require_once $viewFile;
        } else {
            die('La vista no existe: ' . $viewFile);
        }
    }
}
?>