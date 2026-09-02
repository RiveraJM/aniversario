<?php
class InscripcionController extends Controller {
    
    /**
     * Muestra el formulario de inscripción
     * @param int $actividad_id ID de la actividad
     */
    public function crear($actividad_id = null) {
        // Si no hay ID de actividad, redirigir al inicio
        if ($actividad_id === null) {
            header('Location: ' . BASE_URL);
            exit;
        }
        
        // Obtener los datos de la actividad
        $actividad = $this->getActividadById($actividad_id);
        
        // Si la actividad no existe, redirigir al inicio
        if (!$actividad) {
            header('Location: ' . BASE_URL);
            exit;
        }
        
        // Verificar si hay cupos disponibles
        $disponibles = $actividad['capacidad'] - $actividad['inscritos'];
        if ($disponibles <= 0) {
            header('Location: ' . BASE_URL . 'actividad/detalle/' . $actividad_id . '?error=cupos');
            exit;
        }
        
        // Datos para la vista
        $data = [
            'title' => 'Inscripción - ' . $actividad['nombre'],
            'actividad' => $actividad,
            'disponibles' => $disponibles
        ];
        
        // Cargar la vista
        $this->view('inscripciones/crear', $data);
    }
    
    /**
     * Procesa el formulario de inscripción
     */
    public function guardar() {
        // Verificar que sea método POST
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL);
            exit;
        }
        
        // Obtener datos del formulario
        $actividad_id = $_POST['actividad_id'] ?? null;
        $nombres = $_POST['nombres'] ?? '';
        $apellidos = $_POST['apellidos'] ?? '';
        $email = $_POST['email'] ?? '';
        $telefono = $_POST['telefono'] ?? '';
        $institucion = $_POST['institucion'] ?? '';
        $cargo = $_POST['cargo'] ?? '';
        $dni = $_POST['dni'] ?? '';
        $terminos = isset($_POST['terminos']) ? true : false;
        
        // Validar datos
        $errores = [];
        
        if (empty($nombres)) $errores['nombres'] = 'El nombre es obligatorio';
        if (empty($apellidos)) $errores['apellidos'] = 'Los apellidos son obligatorios';
        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errores['email'] = 'Email válido es obligatorio';
        if (empty($telefono)) $errores['telefono'] = 'El teléfono es obligatorio';
        if (empty($institucion)) $errores['institucion'] = 'La institución es obligatoria';
        if (empty($dni) || strlen($dni) < 8) $errores['dni'] = 'DNI válido es obligatorio (mínimo 8 dígitos)';
        if (!$terminos) $errores['terminos'] = 'Debes aceptar los términos y condiciones';
        
        // Si hay errores, mostrar nuevamente el formulario
        if (!empty($errores)) {
            $actividad = $this->getActividadById($actividad_id);
            $data = [
                'title' => 'Inscripción - ' . $actividad['nombre'],
                'actividad' => $actividad,
                'errores' => $errores,
                'datos' => $_POST
            ];
            $this->view('inscripciones/crear', $data);
            return;
        }
        
        // ============================================
        // AQUÍ SE GUARDARÍA EN LA BASE DE DATOS
        // Por ahora solo mostramos la confirmación
        // ============================================
        
        // Datos para la confirmación
        $data = [
            'title' => 'Inscripción Exitosa - Aniversario 2026',
            'actividad' => $this->getActividadById($actividad_id),
            'inscripcion' => [
                'nombres' => $nombres,
                'apellidos' => $apellidos,
                'email' => $email,
                'telefono' => $telefono,
                'institucion' => $institucion,
                'cargo' => $cargo,
                'dni' => $dni,
                'fecha' => date('d/m/Y H:i:s'),
                'codigo' => 'INS-' . strtoupper(substr(md5(uniqid()), 0, 8))
            ]
        ];
        
        // Cargar la vista de confirmación
        $this->view('inscripciones/confirmacion', $data);
    }
    
    /**
     * Obtiene los datos de una actividad por su ID
     */
    private function getActividadById($id) {
        $actividades = $this->getAllActividades();
        
        foreach ($actividades as $actividad) {
            if ($actividad['id'] == $id) {
                return $actividad;
            }
        }
        return null;
    }
    
    /**
     * Obtiene todas las actividades
     */
    private function getAllActividades() {
        return [
            [
                'id' => 1,
                'numero' => 1,
                'nombre' => 'CADE Educativo',
                'categoria' => 'Académico',
                'descripcion' => 'Congreso de Alto Nivel que reúne a líderes educativos para discutir tendencias pedagógicas, metodologías innovadoras y el impacto de la tecnología en la educación superior.',
                'fecha' => '13 de Octubre de 2026',
                'hora' => '09:00 AM',
                'lugar' => 'Auditorio Central - Campus Universitario',
                'capacidad' => 300,
                'inscritos' => 189,
                'icono' => 'fa-chalkboard-user',
                'requisitos' => 'Inscripción previa, estudiantes de últimos ciclos y profesionales'
            ],
            [
                'id' => 2,
                'numero' => 2,
                'nombre' => 'Sesión Solemne',
                'categoria' => 'Institucional',
                'descripcion' => 'Ceremonia protocolar de gran relevancia institucional donde se conmemora el aniversario, con autoridades académicas, políticas y el reconocimiento a docentes y estudiantes destacados.',
                'fecha' => '14 de Octubre de 2026',
                'hora' => '10:00 AM',
                'lugar' => 'Templo Universitario - Campus Central',
                'capacidad' => 500,
                'inscritos' => 312,
                'icono' => 'fa-certificate',
                'requisitos' => 'Traje formal, invitación especial para autoridades'
            ],
            [
                'id' => 3,
                'numero' => 3,
                'nombre' => 'Desfile Plaza Tarapoto',
                'categoria' => 'Cultural',
                'descripcion' => 'Gran desfile cívico-cultural por las principales calles de Tarapoto, con delegaciones estudiantiles, carros alegóricos, bandas musicales y comparsas que representan la riqueza cultural de la región.',
                'fecha' => '15 de Octubre de 2026',
                'hora' => '08:00 AM',
                'lugar' => 'Plaza Mayor - Tarapoto',
                'capacidad' => 1000,
                'inscritos' => 756,
                'icono' => 'fa-flag',
                'requisitos' => 'Vestimenta alusiva al aniversario, puntualidad'
            ],
            [
                'id' => 4,
                'numero' => 4,
                'nombre' => 'Deporte Interinstituciones',
                'categoria' => 'Deportivo',
                'descripcion' => 'Competencia deportiva que reúne a las principales instituciones educativas de la región en fútbol, básquet, vóley y atletismo, fomentando el espíritu deportivo y la sana competencia.',
                'fecha' => '16 de Octubre de 2026',
                'hora' => '08:00 AM',
                'lugar' => 'Estadio Universitario - Complejo Deportivo',
                'capacidad' => 800,
                'inscritos' => 523,
                'icono' => 'fa-futbol',
                'requisitos' => 'Inscripción por equipo, presentar DNI, uniforme deportivo'
            ],
            [
                'id' => 5,
                'numero' => 5,
                'nombre' => 'Concurso Alzaré mi Voz',
                'categoria' => 'Artístico',
                'descripcion' => 'Concurso de talentos artísticos que busca descubrir estudiantes con habilidades sobresalientes en canto, danza, música instrumental y oratoria, como plataforma para expresar su creatividad.',
                'fecha' => '17 de Octubre de 2026',
                'hora' => '06:00 PM',
                'lugar' => 'Teatro Universitario - Campus Central',
                'capacidad' => 400,
                'inscritos' => 267,
                'icono' => 'fa-microphone',
                'requisitos' => 'Inscripción previa, presentar propuesta artística'
            ],
            [
                'id' => 6,
                'numero' => 6,
                'nombre' => 'Deporte InterIglesias',
                'categoria' => 'Deportivo',
                'descripcion' => 'Encuentro deportivo que congrega a las diferentes congregaciones religiosas de la región en una jornada de confraternidad, competencia y valores, fortaleciendo lazos de hermandad y promoviendo la unidad.',
                'fecha' => '18 de Octubre de 2026',
                'hora' => '09:00 AM',
                'lugar' => 'Complejo Deportivo Universitario',
                'capacidad' => 600,
                'inscritos' => 398,
                'icono' => 'fa-hand-holding-heart',
                'requisitos' => 'Inscripción por congregación, presentar constancia'
            ]
        ];
    }
}
?>