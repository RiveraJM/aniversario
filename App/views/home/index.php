<?php
// El contenido se almacena en buffer para el layout
ob_start();
?>

<div class="dashboard">
    <div class="dashboard-header">
        <div class="header-content">
            <h1>
                <i class="fas fa-calendar-check"></i>
                Actividades del Aniversario
            </h1>
            <p class="subtitle">
                Celebra con nosotros los <span class="highlight"><?php echo count($actividades); ?></span> eventos especiales
            </p>
            <div class="header-decoration"></div>
        </div>
    </div>

    <?php $basesPorActividad = require dirname(__DIR__, 2) . '/config/bases.php'; ?>
    <div class="actividades-grid">
        <?php foreach($actividades as $actividad): ?>
        <!-- Cada tarjeta recibe una clase basada en su ID para asignarle su imagen de fondo. -->
        <div class="actividad-card actividad-card-id-<?php echo (int) $actividad['id']; ?>" data-aos="fade-up">
            <!-- Badge de número -->
            <div class="card-badge">
                <span class="numero">#<?php echo str_pad($actividad['numero'], 2, '0', STR_PAD_LEFT); ?></span>
            </div>

            <!-- Icono de actividad -->
            <div class="card-icon">
                <i class="fas <?php echo $actividad['icono']; ?>"></i>
            </div>

            <!-- Contenido -->
            <div class="card-content">
                <div class="card-header">
                    <h3><?php echo $actividad['nombre']; ?></h3>
                    <span class="categoria"><?php echo $actividad['categoria']; ?></span>
                </div>

                <p class="descripcion"><?php echo $actividad['descripcion']; ?></p>

                <div class="card-details">
                    <div class="detail-item">
                        <i class="fas fa-calendar-day"></i>
                        <span><?php echo $actividad['fecha']; ?></span>
                    </div>
                    <div class="detail-item">
                        <i class="fas fa-clock"></i>
                        <span><?php echo $actividad['hora']; ?></span>
                    </div>
                </div>
            </div>

            <!-- Botón -->
            <div class="card-actions">
                <?php
                $pdfActividad = $basesPorActividad[$actividad['id']] ?? null;
                ?>
                <a href="<?php echo BASE_URL . 'registro/crear/' . $actividad['id']; ?>" class="btn-ver-actividad">
                    Registrarse
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
</div>

<?php
// Guardar el contenido en buffer
$content = ob_get_clean();

// Incluir el layout
require_once dirname(__DIR__) . '/Layouts/main.php';
?>