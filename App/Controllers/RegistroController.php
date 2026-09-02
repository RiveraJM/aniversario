<?php
class RegistroController extends Controller {
    
    /**
     * Muestra el formulario de registro
     */
    public function crear($actividad_id = null) {
        // Si no hay ID, redirigir al inicio
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
            'title' => 'Registro - ' . $actividad['nombre'],
            'actividad' => $actividad,
            'disponibles' => $disponibles,
            'errores' => [],
            'datos' => []
        ];

        // CADE tiene su propio formulario con validaciones y envío a Google Sheets.
        // Mantener el flujo general para el resto de actividades sin afectar lo que ya funciona.
        $esCade = ($actividad['id'] == 1) || (stripos($actividad['nombre'], 'CADE') !== false);

        if ($esCade) {
            $this->view('inscripciones/cade', $data);
            return;
        }
        
        // ============================================
        // CARGAR LA VISTA - CORREGIDO
        // Busca en views/inscripciones/crear.php
        // ============================================
        $this->view('inscripciones/crear', $data);
    }
    
    /**
     * Procesa el formulario de registro
     */
    public function guardar() {
        // Verificar que sea método POST
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL);
            exit;
        }

        $actividad_id = $_POST['actividad_id'] ?? null;
        $actividad = $this->getActividadById($actividad_id);

        if ($actividad && stripos($actividad['nombre'] ?? '', 'CADE') !== false) {
            $this->guardarCade();
            return;
        }

        $nombreActividad = strtolower($actividad['nombre'] ?? '');

        // Datos básicos
        $institucion = trim($_POST['institucion'] ?? '');
        $telefono = trim($_POST['telefono'] ?? $_POST['celular'] ?? $_POST['representante_telefono'] ?? '');
        $email = trim($_POST['email'] ?? $_POST['correo'] ?? $_POST['representante_email'] ?? '');
        $terminos = isset($_POST['terminos']) ? true : false;

        // Datos de representación para sesión solemne
        $representante = trim($_POST['representante'] ?? $_POST['representante_nombres'] ?? '');
        $representante_apellidos = trim($_POST['representante_apellidos'] ?? '');
        $cargo = trim($_POST['cargo'] ?? $_POST['representante_cargo'] ?? '');
        $dni = trim($_POST['dni'] ?? $_POST['representante_dni'] ?? '');
        $cantidadParticipantes = trim($_POST['cantidad_participantes'] ?? $_POST['numero_participantes'] ?? '');
        $cargoParticipantes = trim($_POST['cargo_participantes'] ?? '');

        // Datos para desfile, voz y deporte
        $nombreDelegacion = trim($_POST['nombre_delegacion'] ?? $_POST['nombre_equipo'] ?? $_POST['equipo'] ?? '');
        $nombreContacto = trim($_POST['nombre'] ?? $_POST['nombre_contacto'] ?? $_POST['representante'] ?? '');
        $ciudad = trim($_POST['ciudad'] ?? '');
        $disciplinas = $_POST['disciplinas'] ?? [];
        $disciplinasTexto = is_array($disciplinas) ? implode(', ', array_map('trim', $disciplinas)) : trim((string)$disciplinas);

        require_once dirname(__DIR__, 2) . '/core/GoogleSheets.php';
        $googleSheets = new GoogleSheets();

        // Validar datos por tipo de actividad
        $errores = [];

        if (stripos($nombreActividad, 'sesión solemne') !== false) {
            if (empty($institucion)) $errores['institucion'] = 'La institución es obligatoria';
            if (empty($representante)) $errores['representante'] = 'El nombre del representante es obligatorio';
            if (empty($cargo)) $errores['cargo'] = 'El cargo de la institución es obligatorio';
            if (empty($cantidadParticipantes) || !is_numeric($cantidadParticipantes) || (int)$cantidadParticipantes < 1) $errores['cantidad_participantes'] = 'La cantidad de participantes es obligatoria';
            if (empty($cargoParticipantes)) $errores['cargo_participantes'] = 'Debe indicar el cargo de los participantes';
            if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errores['email'] = 'Correo válido es obligatorio';
            if (empty($telefono)) $errores['telefono'] = 'El teléfono es obligatorio';


        } elseif (stripos($nombreActividad, 'desfile') !== false) {
            if (empty($nombreDelegacion)) $errores['nombre_delegacion'] = 'El nombre de la delegación es obligatorio';
            if (empty($nombreContacto)) $errores['nombre'] = 'El nombre de contacto es obligatorio';
            if (empty($telefono)) $errores['telefono'] = 'El celular es obligatorio';
            if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errores['email'] = 'Correo válido es obligatorio';
            if (empty($cantidadParticipantes) || !is_numeric($cantidadParticipantes) || (int)$cantidadParticipantes < 1) $errores['numero_participantes'] = 'El número de participantes es obligatorio';


        } elseif (stripos($nombreActividad, 'deporte') !== false || stripos($nombreActividad, 'interiglesias') !== false) {
            if (empty($institucion)) $errores['institucion'] = 'La institución es obligatoria';
            if (empty($nombreDelegacion)) $errores['equipo'] = 'El nombre del equipo es obligatorio';
            if (empty($disciplinasTexto)) $errores['disciplinas'] = 'Debe seleccionar al menos una disciplina';
            if (empty($telefono)) $errores['telefono'] = 'El celular es obligatorio';
            if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errores['email'] = 'Correo válido es obligatorio';
        
        
        
            } elseif (stripos($nombreActividad, 'alzare') !== false || stripos($nombreActividad, 'alzaré') !== false || stripos($nombreActividad, 'voz') !== false) {
            if (empty($institucion)) $errores['institucion'] = 'La institución es obligatoria';
            if (empty($ciudad)) $errores['ciudad'] = 'La ciudad es obligatoria';
            if (empty($nombreDelegacion)) $errores['nombre_equipo'] = 'El nombre del conjunto o equipo es obligatorio';
            if (empty($nombreContacto)) $errores['nombre'] = 'El nombre de contacto es obligatorio';
            if (empty($telefono)) $errores['telefono'] = 'El celular es obligatorio';
            if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errores['email'] = 'Correo válido es obligatorio';
        
        
            } else {
            $nombres = trim($_POST['nombres'] ?? '');
            $apellidos = trim($_POST['apellidos'] ?? '');
            if (empty($nombres)) $errores['nombres'] = 'El nombre es obligatorio';
            if (empty($apellidos)) $errores['apellidos'] = 'Los apellidos son obligatorios';
            if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errores['email'] = 'Email válido es obligatorio';
            if (empty($telefono)) $errores['telefono'] = 'El teléfono es obligatorio';
            if (empty($institucion)) $errores['institucion'] = 'La institución es obligatoria';
            if (empty($dni) || strlen($dni) < 8) $errores['dni'] = 'DNI válido es obligatorio (mínimo 8 dígitos)';
        }

        if (!$terminos) $errores['terminos'] = 'Debes aceptar los términos y condiciones';

        // Si hay errores, mostrar nuevamente el formulario
        if (!empty($errores)) {
            $actividad = $this->getActividadById($actividad_id);
            $data = [
                'title' => 'Registro - ' . $actividad['nombre'],
                'actividad' => $actividad,
                'errores' => $errores,
                'datos' => $_POST
            ];
            $this->view('inscripciones/crear', $data);
            return;
        }

        session_start();
        if (!isset($_SESSION['registros'])) {
            $_SESSION['registros'] = [];
        }

        $registro = [
            'id' => count($_SESSION['registros']) + 1,
            'actividad_id' => $actividad_id,
            'actividad_nombre' => $this->getActividadById($actividad_id)['nombre'],
            'nombres' => $representante ?: $nombreContacto ?: ($_POST['nombres'] ?? ''),
            'apellidos' => $representante_apellidos ?: '',
            'email' => $email,
            'telefono' => $telefono,
            'institucion' => $institucion,
            'cargo' => $cargo ?: $cargoParticipantes ?: ($_POST['cargo'] ?? ''),
            'dni' => $dni,
            'cantidad_participantes' => $cantidadParticipantes ?: ($_POST['cantidad_participantes'] ?? 1),
            'disciplinas' => $disciplinasTexto,
            'ciudad' => $ciudad,
            'nombre_equipo' => $nombreDelegacion,
            'fecha_registro' => date('d/m/Y H:i:s'),
            'codigo' => 'REG-' . strtoupper(substr(md5(uniqid()), 0, 8))
        ];

        $_SESSION['registros'][] = $registro;

        $congregacion = trim($_POST['congregacion'] ?? '');

        $datosHoja = [
            'id' => null,
            'fecha' => date('d/m/Y H:i:s'),
            'institucion' => $institucion,
            'tipo_institucion' => $_POST['tipo_institucion'] ?? '',
            'direccion' => $_POST['direccion'] ?? '',
            'telefono_institucion' => $_POST['telefono_institucion'] ?? $telefono,
            'email_institucion' => $_POST['email_institucion'] ?? $email,
            'representante' => $representante ?: $nombreContacto,
            'cargo' => $cargo ?: $cargoParticipantes,
            'representante_dni' => $dni,
            'representante_telefono' => $telefono,
            'representante_email' => $email,
            'participantes' => $cantidadParticipantes ?: 1,
            'codigo' => $registro['codigo'],
            'nombres' => $_POST['nombres'] ?? $nombreContacto,
            'apellidos' => $_POST['apellidos'] ?? '',
            'email' => $email,
            'telefono' => $telefono,
            'ciudad' => $ciudad,
            'nombre_delegacion' => $nombreDelegacion,
            'nombre_equipo' => $nombreDelegacion,
            'nombre_contacto' => $nombreContacto,
            'disciplinas' => $disciplinasTexto,
            'deporte' => $_POST['deporte'] ?? $disciplinasTexto,
            'categoria' => $_POST['categoria'] ?? $disciplinasTexto,
            'congregacion' => $congregacion,
            'categoria_artistica' => $_POST['categoria_artistica'] ?? '',
            'nombre_artistico' => $_POST['nombre_artistico'] ?? $nombreDelegacion,
            'dni' => $dni
        ];

        $guardadoEnHoja = false;

        if (stripos($actividad['nombre'] ?? '', 'CADE') !== false) {
            $guardadoEnHoja = $googleSheets->guardarRegistroCade($datosHoja);
        } elseif (stripos($actividad['nombre'] ?? '', 'Sesión Solemne') !== false) {
            $guardadoEnHoja = $googleSheets->guardarRegistroSesionSolemne($datosHoja);
        } elseif (stripos($actividad['nombre'] ?? '', 'Desfile') !== false) {
            $guardadoEnHoja = $googleSheets->guardarRegistroDesfile($datosHoja);
        } elseif (stripos($actividad['nombre'] ?? '', 'Deporte Interinstituciones') !== false) {
            $guardadoEnHoja = $googleSheets->guardarRegistroDeporteInterinstituciones($datosHoja);
        } elseif (stripos($actividad['nombre'] ?? '', 'Alzaré') !== false || stripos($actividad['nombre'] ?? '', 'Alzare') !== false || stripos($actividad['nombre'] ?? '', 'Voz') !== false) {
            $guardadoEnHoja = $googleSheets->guardarRegistroAlzareMiVoz($datosHoja);
        } elseif (stripos($actividad['nombre'] ?? '', 'InterIglesias') !== false) {
            $guardadoEnHoja = $googleSheets->guardarRegistroInterIglesias($datosHoja);
        }

        if (!$guardadoEnHoja) {
            error_log('Registro no guardado en Google Sheets para la actividad: ' . ($actividad['nombre'] ?? 'desconocida'));
        }

        $data = [
            'title' => 'Registro Exitoso - Aniversario 2026',
            'actividad' => $this->getActividadById($actividad_id),
            'registro' => $registro,
            'guardado_en_hoja' => $guardadoEnHoja
        ];

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
 * Procesa el formulario de registro CADE Educativo (Individual)
 */
public function guardarCade() {
    // Verificar que sea método POST
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        header('Location: ' . BASE_URL);
        exit;
    }
    
    // Obtener datos del formulario
    $actividad_id = $_POST['actividad_id'] ?? null;
    
    // Datos personales
    $nombres = trim($_POST['nombres'] ?? '');
    $apellidos = trim($_POST['apellidos'] ?? '');
    $dni = trim($_POST['dni'] ?? '');
    $cargo = trim($_POST['cargo'] ?? '');
    
    // Datos de contacto
    $email = trim($_POST['email'] ?? '');
    $telefono = trim($_POST['telefono'] ?? '');
    $institucion = trim($_POST['institucion'] ?? '');
    
    $terminos = isset($_POST['terminos']) ? true : false;
    
    // Validar datos
    $errores = [];
    
    // Validar personales
    if (empty($nombres)) $errores['nombres'] = 'El nombre es obligatorio';
    if (empty($apellidos)) $errores['apellidos'] = 'Los apellidos son obligatorios';
    if (empty($dni) || strlen($dni) < 8) $errores['dni'] = 'DNI válido es obligatorio (mínimo 8 dígitos)';
    if (empty($cargo)) $errores['cargo'] = 'El cargo es obligatorio';
    
    // Validar contacto
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errores['email'] = 'Correo electrónico válido es obligatorio';
    }
    if (empty($telefono)) $errores['telefono'] = 'El teléfono es obligatorio';
    if (empty($institucion)) $errores['institucion'] = 'La institución es obligatoria';
    
    if (!$terminos) $errores['terminos'] = 'Debes aceptar los términos y condiciones';
    
    // Si hay errores, mostrar nuevamente el formulario
    if (!empty($errores)) {
        $actividad = $this->getActividadById($actividad_id);
        $data = [
            'title' => 'Registro CADE - ' . $actividad['nombre'],
            'actividad' => $actividad,
            'errores' => $errores,
            'datos' => $_POST
        ];
        $this->view('inscripciones/cade', $data);
        return;
    }
    
    // ============================================
    // GUARDAR EN GOOGLE SHEETS
    // ============================================
    require_once dirname(__DIR__, 2) . '/core/GoogleSheets.php';
    
    $googleSheets = new GoogleSheets();
    
    // Generar código de registro
    $codigo = 'CADE-' . strtoupper(substr(md5(uniqid()), 0, 8));
    
    // Preparar datos para Google Sheets
    $registro = [
        'id' => null,
        'fecha' => date('d/m/Y H:i:s'),
        'nombres' => $nombres,
        'apellidos' => $apellidos,
        'dni' => $dni,
        'cargo' => $cargo,
        'email' => $email,
        'telefono' => $telefono,
        'institucion' => $institucion,
        'codigo' => $codigo
    ];
    
    // Guardar en Google Sheets en la hoja "CADE Educativo"
    $guardado = $googleSheets->guardarRegistroCade($registro);

    // Si Google Sheets no está configurado, se guarda localmente en sesión para no bloquear el registro.
    if (!$guardado) {
        error_log('Google Sheets no disponible para CADE. Se guardó el registro en sesión como respaldo.');
        session_start();
        if (!isset($_SESSION['registros'])) {
            $_SESSION['registros'] = [];
        }
        $_SESSION['registros'][] = [
            'id' => count($_SESSION['registros']) + 1,
            'actividad_id' => $actividad_id,
            'actividad_nombre' => $this->getActividadById($actividad_id)['nombre'],
            'nombres' => $nombres,
            'apellidos' => $apellidos,
            'email' => $email,
            'telefono' => $telefono,
            'institucion' => $institucion,
            'cargo' => $cargo,
            'dni' => $dni,
            'fecha_registro' => date('d/m/Y H:i:s'),
            'codigo' => $codigo,
            'guardado_local' => true
        ];
    }

    // Después de guardar exitosamente
$data = [
    'title' => '¡Registro Exitoso! - Aniversario 2026',
    'actividad' => $this->getActividadById($actividad_id),
    'registro' => $registro,
    'codigo' => $codigo
];

// Cargar la vista de confirmación
$this->view('inscripciones/confirmacion', $data);
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
                'icono' => 'fa-gavel',
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