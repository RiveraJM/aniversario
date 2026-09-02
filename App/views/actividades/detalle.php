<?php
// El contenido se almacena en buffer para el layout
ob_start();
$actividad = $data['actividad'];
$disponibles = $actividad['capacidad'] - $actividad['inscritos'];
$porcentaje = round(($actividad['inscritos'] / $actividad['capacidad']) * 100);
$pdfUrl = $actividad['pdf'] ?? (BASE_URL . 'pdf/bases%20canto.pdf');

// Determinar estado de disponibilidad
if ($disponibles > 50) {
    $estado = 'disponible';
    $estado_texto = '¡Cupos disponibles!';
    $estado_color = '#02081f';
} elseif ($disponibles > 10) {
    $estado = 'pocos';
    $estado_texto = '¡Últimos cupos!';
    $estado_color = '#F59E0B';
} elseif ($disponibles > 0) {
    $estado = 'agotando';
    $estado_texto = '¡Se están agotando!';
    $estado_color = '#EF4444';
} else {
    $estado = 'agotado';
    $estado_texto = 'Cupos agotados';
    $estado_color = '#6B7280';
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($actividad['nombre']); ?> - Aniversario 2026</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>css/styles.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>css/detalle.css">
</head>
<body>
    <!-- ============================================
    HEADER
    ============================================ -->
    <header class="header">
        <div class="header-container">
            <div class="header-logo">
                 <img src="<?php echo BASE_URL; ?>img/logo1.png" alt="Logo Universidad" class="logo-img">
                <span>Aniversario <span style="color: var(--secondary); font-weight: 800;">2026</span></span>
            </div>
            <nav class="header-nav">
                <ul>
                    <li><a href="<?php echo BASE_URL; ?>">Inicio</a></li>
                    <li><a href="<?php echo BASE_URL; ?>" class="active">Actividades</a></li>
                    <li><a href="<?php echo BASE_URL; ?>?url=contacto">Contacto</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <!-- ============================================
    MAIN CONTENT
    ============================================ -->
    <main class="main-content">
        <!-- Breadcrumb -->
        <div class="breadcrumb">
            <a href="<?php echo BASE_URL; ?>"><i class="fas fa-home"></i> Inicio</a>
            <i class="fas fa-chevron-right"></i>
            <a href="<?php echo BASE_URL; ?>">Actividades</a>
            <i class="fas fa-chevron-right"></i>
            <span class="current"><?php echo htmlspecialchars($actividad['nombre']); ?></span>
        </div>

        <div class="detalle-grid">
            <!-- ========================================
            COLUMNA PRINCIPAL
            ============================================ -->
            <div class="detalle-main">
                <!-- Cabecera -->
                <div class="actividad-header">
                    <div class="actividad-icono">
                        <i class="fas <?php echo $actividad['icono']; ?>"></i>
                    </div>
                    <div class="actividad-titulo">
                        <h1><?php echo htmlspecialchars($actividad['nombre']); ?></h1>
                        <span class="categoria-badge">
                            <i class="fas fa-tag"></i> <?php echo htmlspecialchars($actividad['categoria']); ?>
                        </span>
                    </div>
                </div>

                <!-- Meta información -->
                <div class="actividad-meta">
                    <div class="meta-item">
                        <i class="fas fa-calendar-alt"></i>
                        <div>
                            <div class="meta-label">Fecha</div>
                            <div class="meta-value"><?php echo htmlspecialchars($actividad['fecha']); ?></div>
                        </div>
                    </div>
                    <div class="meta-item">
                        <i class="fas fa-clock"></i>
                        <div>
                            <div class="meta-label">Hora</div>
                            <div class="meta-value"><?php echo htmlspecialchars($actividad['hora']); ?></div>
                        </div>
                    </div>
                    <div class="meta-item">
                        <i class="fas fa-map-marker-alt"></i>
                        <div>
                            <div class="meta-label">Lugar</div>
                            <div class="meta-value"><?php echo htmlspecialchars($actividad['lugar']); ?></div>
                        </div>
                    </div>
                </div>

                <!-- Descripción -->
                <div class="actividad-descripcion">
                    <h3><i class="fas fa-info-circle"></i> Descripción</h3>
                    <p><?php echo htmlspecialchars($actividad['descripcion']); ?></p>
                </div>

                <?php if (!in_array((int)$actividad['id'], [1, 2], true)): ?>
                    <div class="actividad-bases" style="margin-top: 1.5rem; background: linear-gradient(135deg, rgba(248, 169, 0, 0.08), rgba(0, 51, 102, 0.05)); border: 1px solid rgba(248, 169, 0, 0.25); border-radius: 14px; padding: 1.5rem;">
                        <h3 style="display:flex; align-items:center; gap:0.6rem; font-size: 1rem; font-weight: 700; color: var(--text-primary); margin-bottom: 0.8rem;">
                            <i class="fas fa-file-pdf" style="color: #d93025;"></i> Bases del evento
                        </h3>
                        <p style="color: var(--text-secondary); margin-bottom: 0.8rem;">Consulta las bases y requisitos oficiales antes de inscribirte.</p>
                        <a id="btnDescargarBases" href="<?php echo $pdfUrl; ?>" download style="display: inline-flex; align-items: center; gap: 0.7rem; background: linear-gradient(135deg, var(--primary), var(--primary-dark)); color: var(--white); padding: 0.8rem 1.2rem; border-radius: 12px; text-decoration: none; font-weight: 700; box-shadow: 0 8px 22px rgba(0, 51, 102, 0.18);">
                            <i class="fas fa-download"></i>
                            Descargar bases en PDF
                        </a>
                    </div>
                <?php endif; ?>

                <!-- Requisitos -->
                <div class="actividad-requisitos" style="margin-top: 1.5rem;">
                    <h3><i class="fas fa-clipboard-list"></i> Requisitos para participar</h3>
                    <p><?php echo htmlspecialchars($actividad['requisitos']); ?></p>
                </div>
            </div>

            <!-- ========================================
            SIDEBAR - INSCRIPCIÓN
            ============================================ -->
            <div class="detalle-sidebar">
                <div class="sidebar-card">
                   
                    

                    

                    <!-- Botón de inscripción -->
                    <?php if ($disponibles > 0): ?>
                     <a href="<?php echo BASE_URL; ?>registro/crear/<?php echo $actividad['id']; ?>" class="btn-inscribirse" id="btnInscribirse">
                        <i class="fas fa-pen"></i>
                        Registrar participación
                    </a>
                        <p class="texto-ayuda">
                            <i class="fas fa-info-circle"></i>
                            Cupos limitados, ¡no te quedes sin tu lugar!
                        </p>
                    <?php else: ?>
                        <button class="btn-inscribirse" disabled>
                            <i class="fas fa-times-circle"></i>
                            Cupos agotados
                        </button>
                        <p class="texto-ayuda error">
                            <i class="fas fa-exclamation-circle"></i>
                            Lo sentimos, ya no hay cupos disponibles
                        </p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </main>

    <!-- ============================================
    FOOTER
    ============================================ -->
    <footer class="footer">
        <div class="footer-container">
            <div class="footer-content">
                
                <div class="footer-info">
                    <p>
                        <i class="fas fa-calendar-alt"></i>
                        13- 18 de Octubre, 2026
                    </p>
                    <p>
                        <i class="fas fa-map-marker-alt"></i>
                        Campus UPeU-Tarapoto
                    </p>
                    <p>
                        <i class="fas fa-envelope"></i>
                        aniversario@upeu.edu.pe
                    </p>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; <?php echo date('Y'); ?> Universidad Peruana Unión -  Tarapoto </p>
            </div>
        </div>
    </footer>

    <!-- ============================================
    JAVASCRIPT
    ============================================ -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Animación de la barra de progreso al cargar
            const progressFill = document.querySelector('.progress-fill');
            if (progressFill) {
                const width = progressFill.style.width;
                progressFill.style.width = '0%';
                setTimeout(() => {
                    progressFill.style.width = width;
                }, 300);
            }

            // Efecto en botón de inscripción
            const btnInscribirse = document.getElementById('btnInscribirse');
            if (btnInscribirse) {
                btnInscribirse.addEventListener('click', function(e) {
                    // No prevenir el comportamiento - permitir navegación normal
                    // El href ya tiene la URL correcta
                });
            }

            // Descargar PDF sin abrirlo en la misma página
            const btnDescargarBases = document.getElementById('btnDescargarBases');
            if (btnDescargarBases) {
                btnDescargarBases.addEventListener('click', function(e) {
                    e.preventDefault();
                    const link = document.createElement('a');
                    link.href = this.href;
                    link.setAttribute('download', 'bases-' + location.pathname.split('/').filter(Boolean).slice(-1)[0] + '.pdf');
                    link.target = '_blank';
                    document.body.appendChild(link);
                    link.click();
                    link.remove();
                });
            }
        });
    </script>
</body>
</html>