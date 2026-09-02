<?php
// Activar errores en desarrollo
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

// ============================================
// DEFINIR BASE_URL DINÁMICAMENTE PARA LOCAL Y PRODUCCIÓN
// ============================================
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https://' : 'http://';
$host = $_SERVER['HTTP_HOST'] ?? 'localhost';
$scriptName = $_SERVER['SCRIPT_NAME'] ?? '/index.php';
$basePath = trim(dirname($scriptName), '/\\');

if (!empty($basePath) && preg_match('/(^|\/)public$/i', $basePath)) {
    $basePath = preg_replace('/\/public$/i', '', $basePath);
}

if ($basePath !== '' && $basePath !== '.') {
    $basePath = '/' . $basePath;
} else {
    $basePath = '';
}

define('BASE_URL', $protocol . $host . $basePath . '/');

// ============================================
// USAR ROUTER SI HAY PARÁMETRO URL
// ============================================
if(isset($_GET['url']) && !empty($_GET['url'])) {
    // Cargar dependencias
    require_once __DIR__ . '/../core/Controller.php';
    require_once __DIR__ . '/../core/Router.php';
    
    // Ejecutar el router
    $router = new Router();
    exit; // Salir después de procesar la ruta
}

require_once __DIR__ . '/../core/Auth.php';
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

if (!Auth::isLoggedIn()) {
    header('Location: ' . BASE_URL . '?url=auth/login');
    exit;
}

// ============================================
// DATOS DE EJEMPLO - ACTIVIDADES MEJORADAS
// ============================================
$actividades = [
    [
        'id' => 1,
        'numero' => 1,
        'nombre' => 'CADE Educativo',
        'categoria' => 'Académico',
        'descripcion' => 'Congreso de Alto Nivel que reúne a líderes educativos, directivos y docentes para discutir las tendencias pedagógicas del futuro, metodologías innovadoras y el impacto de la tecnología en la educación superior.',
        'fecha' => '13 de Octubre de 2026',
        'hora' => '09:00 AM',
        'icono' => 'fa-chalkboard-user',
        'lugar' => 'Auditorio Central - Campus Universitario',
        'descripcion_larga' => 'El CADE Educativo es un espacio de reflexión y análisis sobre el futuro de la educación. Contaremos con ponentes nacionales e internacionales que compartirán sus experiencias en gestión educativa, innovación pedagógica y transformación digital. Dirigido a directivos, docentes y estudiantes de últimos ciclos.'
    ],
    [
        'id' => 2,
        'numero' => 2,
        'nombre' => 'Sesión Solemne',
        'categoria' => 'Institucional',
        'descripcion' => 'Ceremonia protocolar de gran relevancia institucional donde se conmemora el aniversario de la universidad, con la participación de autoridades académicas, políticas y religiosas, y el reconocimiento a docentes y estudiantes destacados.',
        'fecha' => '14 de Octubre de 2026',
        'hora' => '10:00 AM',
        'icono' => 'fa-medal',
        'lugar' => 'Templo Universitario - Campus Central',
        'descripcion_larga' => 'La Sesión Solemne es el acto central del aniversario. En esta ceremonia se realiza el informe de gestión del rector, se otorgan distinciones honoríficas y se reconoce la trayectoria de docentes eméritos. Un evento que fortalece la identidad y el sentido de pertenencia institucional.'
    ],
    [
        'id' => 3,
        'numero' => 3,
        'nombre' => 'Desfile Plaza Tarapoto',
        'categoria' => 'Cultural',
        'descripcion' => 'Gran desfile cívico-cultural que recorrerá las principales calles de Tarapoto, con la participación de delegaciones estudiantiles, carros alegóricos, bandas musicales y comparsas que representan la riqueza cultural de la región San Martín.',
        'fecha' => '15 de Octubre de 2026',
        'hora' => '08:00 AM',
        'icono' => 'fa-flag',
        'lugar' => 'Plaza Mayor - Tarapoto',
        'descripcion_larga' => 'El Desfile por la Plaza Tarapoto es una muestra de integración entre la universidad y la comunidad. Participan todas las facultades con delegaciones que representan la diversidad cultural de nuestra región. Un evento que promueve el orgullo por nuestras raíces y el compromiso social.'
    ],
    [
        'id' => 4,
        'numero' => 4,
        'nombre' => 'Deporte Interinstituciones',
        'categoria' => 'Deportivo',
        'descripcion' => 'Competencia deportiva que reúne a las principales instituciones educativas de la región en disciplinas como fútbol, básquet, vóley y atletismo, fomentando el espíritu deportivo, la sana competencia y la integración entre estudiantes.',
        'fecha' => '16 de Octubre de 2026',
        'hora' => '08:00 AM',
        'icono' => 'fa-futbol',
        'lugar' => 'Estadio Universitario - Complejo Deportivo',
        'descripcion_larga' => 'El Deporte Interinstituciones es un encuentro que trasciende lo deportivo, promoviendo valores como el trabajo en equipo, la disciplina y el respeto. Participan instituciones educativas de toda la región, con categorías femenina y masculina. Una oportunidad para fortalecer lazos y celebrar la hermandad.'
    ],
    [
        'id' => 5,
        'numero' => 5,
        'nombre' => 'Concurso Alzaré mi Voz',
        'categoria' => 'Artístico',
        'descripcion' => 'Concurso de talentos artísticos que busca descubrir y promover a los estudiantes con habilidades sobresalientes en canto, danza, música instrumental y oratoria, como plataforma para expresar su creatividad y potencial.',
        'fecha' => '17 de Octubre de 2026',
        'hora' => '06:00 PM',
        'icono' => 'fa-microphone',
        'lugar' => 'Teatro Universitario - Campus Central',
        'descripcion_larga' => '"Alzaré mi Voz" es más que un concurso, es un movimiento que impulsa el talento juvenil. Los participantes compiten en categorías de canto, danza, música y oratoria, con el respaldo de un jurado calificado. El ganador obtiene una beca de estudios y la oportunidad de representar a la universidad en eventos nacionales.'
    ],
    [
        'id' => 6,
        'numero' => 6,
        'nombre' => 'Deporte InterIglesias',
        'categoria' => 'Deportivo',
        'descripcion' => 'Encuentro deportivo que congrega a las diferentes congregaciones religiosas de la región en una jornada de confraternidad, competencia y valores, fortaleciendo los lazos de hermandad y promoviendo un mensaje de unidad y paz.',
        'fecha' => '18 de Octubre de 2026',
        'hora' => '09:00 AM',
        'icono' => 'fa-futbol',
        'lugar' => 'Complejo Deportivo Universitario',
        'descripcion_larga' => 'El Deporte InterIglesias es un espacio de encuentro entre las diferentes confesiones religiosas, donde el deporte se convierte en un puente para la hermandad. Se realizan competencias de fútbol, básquet y vóley, acompañadas de actividades de integración y reflexión sobre los valores compartidos.'
    ]
];

$actividades = Auth::filtrarActividades($actividades);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <!-- <title>Aniversario Universitario 2026 - Celebra con nosotros</title>-->
    
    <!-- Meta tags para SEO y redes sociales -->
    <meta name="description" content="Celebra el 21 aniversario de nuestra universidad con actividades culturales, artísticas y académicas. ¡Inscríbete ahora!">
    <meta property="og:title" content="Aniversario Universitario 2026">
    <meta property="og:description" content="Únete a la celebración más importante del año universitario.">
    <meta name="theme-color" content="#003366">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Estilos CSS -->
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>css/styles.css">
</head>
<body>
    <!-- ============================================
    HEADER
    ============================================ -->
    <header class="header">
    <div class="header-container">
        <div class="header-logo">
            <img src="<?php echo BASE_URL; ?>img/logo1.png" alt="Logo Universidad" class="logo-img">
            <span>Aniversario <span class="highlight">2026</span></span>
        </div>
        <nav class="header-nav">
            <ul>
                <li><a href="<?php echo BASE_URL; ?>" class="active">Actividades</a></li>
                <li><a href="<?php echo BASE_URL; ?>?url=contacto">Contacto</a></li>
                <li><a href="<?php echo BASE_URL; ?>?url=auth/logout">Cerrar Sesión</a></li>
            </ul>
        </nav>
    </div>
</header>

    <!-- ============================================
    HERO SECTION - CON IMAGEN DE FONDO
    ============================================ -->
    <section class="hero-section">
        <!-- Partículas decorativas -->
        <div class="particle-decoration">
            <span></span>
            <span></span>
            <span></span>
            <span></span>
            <span></span>
            <span></span>
        </div>
        
        <!--<div class="hero-content">
            <div class="hero-text">
                <span class="badge">
                    <i class="fas fa-calendar-alt"></i> Edición 2026
                </span>
                <h1>
                    Celebra el 21<br>
                    <span class="highlight">Aniversario</span> <br>
                Universidad Peruana Unión
                </h1>
                <p class="subtitle">
                    <br>
                    ¡Te esperamos para celebrar juntos!
                </p>
                <div class="hero-stats">
                    <div class="hero-stat">
                        <span class="number"><?php echo count($actividades); ?></span>
                        <span class="label">Actividades</span>
                    </div>
                    <div class="hero-stat">
                        <span class="number">50+</span>
                        <span class="label">Instituciones</span>
                    </div>
                    <div class="hero-stat">
                        <span class="number">500+</span>
                        <span class="label">Participantes</span>
                    </div>
                </div>-->
            </div>
        </div>
    </section>

    <!-- ============================================
    MAIN CONTENT - DASHBOARD
    ============================================ -->
    <main class="main-content">
        <div class="dashboard">
            <!-- Título de la sección -->
            <div class="section-title">
                <h2>
                    <i class="fas fa-calendar-check" style="color: #F8A900;"></i>
                    Nuestras Actividades
                </h2>
                <p>Descubre todos los eventos que hemos preparado para ti</p>
            </div>

           <!-- Grid de Actividades -->
<?php $basesPorActividad = require __DIR__ . '/../config/bases.php'; ?>
<div class="actividades-grid">
    <?php foreach($actividades as $actividad): ?>
    <div class="actividad-card">
        <!-- Badge de número -->
        <div class="card-badge">
            <span class="numero">
                <i class="fas fa-hashtag"></i>
                <?php echo str_pad($actividad['numero'], 2, '0', STR_PAD_LEFT); ?>
            </span>
        </div>

        <!-- Icono de actividad -->
        <div class="card-icon">
            <i class="fas <?php echo $actividad['icono']; ?>"></i>
        </div>

        <!-- Contenido -->
        <div class="card-content">
            <div class="card-header">
                <h3><?php echo htmlspecialchars($actividad['nombre']); ?></h3>
                <span class="categoria"><?php echo htmlspecialchars($actividad['categoria']); ?></span>
            </div>

            <p class="descripcion"><?php echo htmlspecialchars($actividad['descripcion']); ?></p>

            <div class="card-details">
                <div class="detail-item">
                    <i class="fas fa-calendar-day"></i>
                    <span><?php echo htmlspecialchars($actividad['fecha']); ?></span>
                </div>
                <div class="detail-item">
                    <i class="fas fa-clock"></i>
                    <span><?php echo htmlspecialchars($actividad['hora']); ?></span>
                </div>
            </div>
        </div>

       <!-- Botones de registro y bases -->
<div class="card-actions">
    <?php
    $pdfActividad = $basesPorActividad[$actividad['id']] ?? null;
    ?>
    <a href="<?php echo BASE_URL . 'registro/crear/' . $actividad['id']; ?>" class="btn-ver-actividad">
        REGISTRARSE
        <i class="fas fa-arrow-right"></i>
    </a>
    <?php if ($pdfActividad): ?>
    <a href="<?php echo BASE_URL . 'pdf/' . rawurlencode($pdfActividad); ?>" class="btn-bases" download="<?php echo htmlspecialchars($pdfActividad, ENT_QUOTES, 'UTF-8'); ?>">
        <i class="fas fa-file-pdf"></i>
        Bases
    </a>
    <?php endif; ?>
</div>
    </div>
    <?php endforeach; ?>
</div>
    </main>
    <!-- ============================================
    FOOTER
    ============================================ -->
    <footer class="footer">
        <div class="footer-container">
            <div class="footer-content">
                <div class="footer-logo">
                   
                    
                    <span style="font-size: 0.8rem; opacity: 0.6; font-weight: 400;">
                       
                    </span>
                </div>
                <div class="footer-info">
                    <p>
                        <i class="fas fa-calendar-alt"></i>
                        13- 18 de Octubre, 2026
                    </p>
                    <p>
                        <i class="fas fa-map-marker-alt"></i>
                        Campus UPeU- Tarapoto
                    </p>
                    <p>
                        <i class="fas fa-envelope"></i>
                        aniversario@upeu.edu.pe
                    </p>
                </div>
                <div class="footer-social">
                    <a href="#" aria-label="Facebook">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="#" aria-label="Instagram">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a href="#" aria-label="YouTube">
                        <i class="fab fa-youtube"></i>
                    </a>
                    <a href="#" aria-label="Twitter">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a href="#" aria-label="TikTok">
                        <i class="fab fa-tiktok"></i>
                    </a>
                </div>
            </div>
            <div class="footer-bottom">
                <p>
                    &copy; <?php echo date('Y'); ?> Universidad Peruana Unión -  Tarapoto 
                    <span style="margin: 0 0.5rem;">|</span>
                   
                </p>
            </div>
        </div>
    </footer>

    <!-- ============================================
    JAVASCRIPT
    ============================================ -->
    <script src="<?php echo BASE_URL; ?>js/main.js"></script>
</body>
</html>