<?php
class Router {
    private $controller = 'HomeController';
    private $method = 'index';
    private $params = [];

    public function __construct() {
        // ============================================
        // 1. OBTENER LA URL
        // ============================================
        $url = isset($_GET['url']) ? $_GET['url'] : '';
        $url = rtrim($url, '/');
        $urlArray = !empty($url) ? explode('/', $url) : [];
        
        // ============================================
        // 2. BUSCAR EL CONTROLADOR EN App/Controllers/
        // ============================================
        if(isset($urlArray[0]) && !empty($urlArray[0])) {
            $controllerName = ucfirst($urlArray[0]) . 'Controller';
            
            // ============================================
            // BUSCAR EN App/Controllers/ (mayúscula)
            // ============================================
            $controllerFile = __DIR__ . '/../App/Controllers/' . $controllerName . '.php';
            
            // ============================================
            // SI NO EXISTE, BUSCAR EN app/controllers/ (minúscula)
            // ============================================
            if(!file_exists($controllerFile)) {
                $controllerFile = __DIR__ . '/../app/controllers/' . $controllerName . '.php';
            }
            
            // ============================================
            // SI EXISTE, ASIGNAR CONTROLADOR
            // ============================================
            if(file_exists($controllerFile)) {
                $this->controller = $controllerName;
                unset($urlArray[0]);
            }
        }
        
        // ============================================
        // 3. CARGAR EL CONTROLADOR
        // ============================================
        // Primero buscar en App/Controllers/
        $controllerFile = __DIR__ . '/../App/Controllers/' . $this->controller . '.php';
        
        // Si no existe, buscar en app/controllers/
        if(!file_exists($controllerFile)) {
            $controllerFile = __DIR__ . '/../app/controllers/' . $this->controller . '.php';
        }
        
        if(!file_exists($controllerFile)) {
            die('❌ Controlador no encontrado: ' . $controllerFile);
        }
        
        require_once $controllerFile;
        
        // ============================================
        // VERIFICAR QUE LA CLASE EXISTE
        // ============================================
        if(!class_exists($this->controller)) {
            die('❌ Clase no encontrada: ' . $this->controller . ' en archivo: ' . $controllerFile);
        }
        
        $this->controller = new $this->controller;
        
        // ============================================
        // 4. VERIFICAR EL MÉTODO
        // ============================================
        if(isset($urlArray[1]) && !empty($urlArray[1])) {
            if(method_exists($this->controller, $urlArray[1])) {
                $this->method = $urlArray[1];
                unset($urlArray[1]);
            }
        }
        
        // ============================================
        // 5. OBTENER PARÁMETROS
        // ============================================
        $this->params = !empty($urlArray) ? array_values($urlArray) : [];
        
        // ============================================
        // 6. EJECUTAR EL CONTROLADOR Y MÉTODO
        // ============================================
        call_user_func_array([$this->controller, $this->method], $this->params);
    }
}
?>