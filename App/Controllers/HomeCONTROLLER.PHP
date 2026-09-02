<?php
// ============================================
// RUTA CORREGIDA PARA Auth.php
// ============================================
require_once __DIR__ . '/../../core/Auth.php';

class HomeController extends Controller {
    public function index() {
        // Iniciar sesión
        session_start();
        
        // Si no está logueado, redirigir al login
        if (!Auth::isLoggedIn()) {
            header('Location: ' . BASE_URL . '?url=auth/login');
            exit;
        }

        // Obtener todas las actividades y filtrarlas
        $todasActividades = $this->getActividadesEjemplo();
        $actividadesFiltradas = Auth::filtrarActividades($todasActividades);
        
        $data = [
            'title' => 'Inicio - Aniversario Universitario 2026',
            'actividades' => $actividadesFiltradas,
            'tipo_usuario' => Auth::getTipoUsuario()
        ];
        
        $this->view('home/index', $data);
    }
    
    private function getActividadesEjemplo() {
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