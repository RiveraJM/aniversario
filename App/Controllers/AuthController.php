<?php
require_once __DIR__ . '/../../core/Auth.php';

class AuthController extends Controller {
    public function login() {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuario = trim($_POST['usuario'] ?? '');
            $password = $_POST['password'] ?? '';

            if (Auth::login($usuario, $password)) {
                header('Location: ' . $this->getPublicUrl());
                exit;
            }

            $error = 'Usuario o contraseña incorrectos.';
        }

        $this->view('auth/login', [
            'error' => $error ?? null,
            'publicUrl' => $this->getPublicUrl()
        ]);
    }

    public function logout() {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        Auth::logout();
        header('Location: ' . $this->getPublicUrl() . '?url=auth/login');
        exit;
    }

    private function getPublicUrl() {
        return BASE_URL;
    }
}
?>