<?php
class ContactoController extends Controller {
    public function index() {
        $publicUrl = $this->getPublicUrl();
        $title = 'Contacto - Aniversario Universitario 2026';
        $contactoCss = true;

        ob_start();
        require_once dirname(__DIR__) . '/views/contacto/index.php';
        $content = ob_get_clean();

        require_once dirname(__DIR__) . '/views/Layouts/main.php';
    }

    private function getPublicUrl() {
        return BASE_URL;
    }
}
?>