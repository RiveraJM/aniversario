<?php
class Auth {
    private static $usuarios = [
        [
            'usuario' => 'aniversario',
            'password' => 'tpp2020',
            'tipo' => 'Colegios Adventistas',
            'actividades' => [1, 2, 3, 4, 5, 6] // Todas
        ],
        [
            'usuario' => 'aniversario',
            'password' => 'tpp2021',
            'tipo' => 'Colegios No Adventistas',
            'actividades' => [1, 2, 3] // CADE, Sesión Solemne, Desfile
        ],
        [
            'usuario' => 'aniversario',
            'password' => 'tpp2022',
            'tipo' => 'Universidades No Adventistas',
            'actividades' => [1, 2, 3] // CADE, Sesión Solemne, Desfile
        ],
        [
            'usuario' => 'aniversario',
            'password' => 'tpp2023',
            'tipo' => 'Instituciones Adventistas',
            'actividades' => [1, 2, 3, 4, 5, 6] // Todas
        ],
        [
            'usuario' => 'aniversario',
            'password' => 'tpp2024',
            'tipo' => 'Instituciones No Adventistas',
            'actividades' => [2, 3] // Sesión Solemne, Desfile
        ],
        [
            'usuario' => 'aniversario',
            'password' => 'tpp2025',
            'tipo' => 'Iglesias',
            'actividades' => [5, 6] // Concurso Alzaré mi Voz, Deporte InterIglesias
        ]
    ];

    /**
     * Verifica las credenciales del usuario
     */
    public static function login($usuario, $password) {
        foreach (self::$usuarios as $datosUsuario) {
            if ($datosUsuario['usuario'] === $usuario && $datosUsuario['password'] === $password) {
                $_SESSION['usuario'] = $usuario;
                $_SESSION['tipo'] = $datosUsuario['tipo'];
                $_SESSION['actividades'] = $datosUsuario['actividades'];
                return true;
            }
        }

        return false;
    }

    /**
     * Verifica si el usuario está autenticado
     */
    public static function isLoggedIn() {
        return isset($_SESSION['usuario']);
    }

    /**
     * Verifica si el usuario tiene acceso a una actividad específica
     */
    public static function tieneAcceso($actividad_id) {
        if (!self::isLoggedIn()) return false;
        return in_array($actividad_id, $_SESSION['actividades']);
    }

    /**
     * Filtra las actividades según el usuario
     */
    public static function filtrarActividades($actividades) {
        if (!self::isLoggedIn()) return [];
        
        $actividadesFiltradas = [];
        foreach ($actividades as $actividad) {
            if (self::tieneAcceso($actividad['id'])) {
                $actividadesFiltradas[] = $actividad;
            }
        }
        return $actividadesFiltradas;
    }

    /**
     * Cierra la sesión del usuario
     */
    public static function logout() {
        session_destroy();
    }

    /**
     * Obtiene el tipo de usuario
     */
    public static function getTipoUsuario() {
        return $_SESSION['tipo'] ?? null;
    }
}
?>