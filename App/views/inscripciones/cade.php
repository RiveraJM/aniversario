<?php
$actividad = $data['actividad'] ?? null;
$disponibles = $data['disponibles'] ?? 0;
$errores = $data['errores'] ?? [];
$datos = $data['datos'] ?? [];

// Si no hay actividad, mostrar error
if (!$actividad) {
    die('❌ No se encontró la actividad');
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro CADE Educativo - Aniversario 2026</title>
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- CSS del formulario CADE -->
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>css/cade.css">
    
    <!-- Estilos globales (header y footer) -->
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>css/styles.css">
</head>
<body class="registro-page">
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
    <main class="cade-container">
        <div class="cade-card">
            <!-- Header del formulario -->
            <div class="cade-header">
                <div class="icono-actividad">
                    <i class="fas <?php echo $actividad['icono']; ?>"></i>
                </div>
                <h1>Registro CADE Educativo</h1>
                <p class="subtitulo">Completa tus datos para participar en:</p>
                <div class="actividad-nombre">
                    <i class="fas fa-tag"></i> <?php echo htmlspecialchars($actividad['nombre']); ?>
                </div>
                <div class="cupos-disponibles">
                    <i class="fas fa-users"></i> Cupos disponibles: <strong><?php echo $disponibles; ?></strong>
                </div>
            </div>

            <!-- Mostrar errores generales -->
            <?php if (!empty($errores)): ?>
                <div class="alert-danger">
                    <i class="fas fa-exclamation-circle"></i>
                    <div>
                        <strong>Por favor, corrige los siguientes errores:</strong>
                        <ul>
                            <?php foreach ($errores as $campo => $mensaje): ?>
                                <li><?php echo $mensaje; ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            <?php endif; ?>

            <!-- ============================================
            FORMULARIO
            ============================================ -->
            <form action="<?php echo BASE_URL; ?>registro/guardarCade" method="POST" id="formCade">
                <input type="hidden" name="actividad_id" value="<?php echo $actividad['id']; ?>">

                <!-- ============================================
                SECCIÓN 1: DATOS PERSONALES
                ============================================ -->
                <div class="seccion-formulario">
                    <div class="seccion-titulo">
                        <i class="fas fa-user"></i> Datos Personales
                    </div>
                    <p class="seccion-descripcion">Información del participante.</p>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="nombres">
                                Nombres <span class="required">*</span>
                            </label>
                            <input type="text" 
                                   id="nombres" 
                                   name="nombres" 
                                   class="form-control <?php echo isset($errores['nombres']) ? 'error' : ''; ?>" 
                                   value="<?php echo htmlspecialchars($datos['nombres'] ?? ''); ?>" 
                                   placeholder="" 
                                   required>
                            <?php if (isset($errores['nombres'])): ?>
                                <div class="error-message"><i class="fas fa-times-circle"></i> <?php echo $errores['nombres']; ?></div>
                            <?php endif; ?>
                        </div>

                        <div class="form-group">
                            <label for="apellidos">
                                Apellidos <span class="required">*</span>
                            </label>
                            <input type="text" 
                                   id="apellidos" 
                                   name="apellidos" 
                                   class="form-control <?php echo isset($errores['apellidos']) ? 'error' : ''; ?>" 
                                   value="<?php echo htmlspecialchars($datos['apellidos'] ?? ''); ?>" 
                                   placeholder="" 
                                   required>
                            <?php if (isset($errores['apellidos'])): ?>
                                <div class="error-message"><i class="fas fa-times-circle"></i> <?php echo $errores['apellidos']; ?></div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="dni">
                                DNI / Documento de Identidad <span class="required">*</span>
                            </label>
                            <input type="text" 
                                   id="dni" 
                                   name="dni" 
                                   class="form-control <?php echo isset($errores['dni']) ? 'error' : ''; ?>" 
                                   value="<?php echo htmlspecialchars($datos['dni'] ?? ''); ?>" 
                                   placeholder="" 
                                   maxlength="8" 
                                   required>
                            <?php if (isset($errores['dni'])): ?>
                                <div class="error-message"><i class="fas fa-times-circle"></i> <?php echo $errores['dni']; ?></div>
                            <?php endif; ?>
                        </div>

                        <div class="form-group">
                            <label for="cargo">
                                Cargo / Rol <span class="required">*</span>
                            </label>
                            <select id="cargo" name="cargo" class="form-control <?php echo isset($errores['cargo']) ? 'error' : ''; ?>" required>
                                <option value="">Seleccionar...</option>
                                <option value="estudiante" <?php echo (($datos['cargo'] ?? '') == 'estudiante') ? 'selected' : ''; ?>>Estudiante</option>
                                <option value="docente" <?php echo (($datos['cargo'] ?? '') == 'docente') ? 'selected' : ''; ?>>Docente / Profesor</option>
                                <option value="investigador" <?php echo (($datos['cargo'] ?? '') == 'investigador') ? 'selected' : ''; ?>>Investigador</option>
                                <option value="directivo" <?php echo (($datos['cargo'] ?? '') == 'directivo') ? 'selected' : ''; ?>>Directivo / Autoridad</option>
                                <option value="profesional" <?php echo (($datos['cargo'] ?? '') == 'profesional') ? 'selected' : ''; ?>>Profesional / Egresado</option>
                                <option value="otro" <?php echo (($datos['cargo'] ?? '') == 'otro') ? 'selected' : ''; ?>>Otro</option>
                            </select>
                            <?php if (isset($errores['cargo'])): ?>
                                <div class="error-message"><i class="fas fa-times-circle"></i> <?php echo $errores['cargo']; ?></div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- ============================================
                SECCIÓN 2: DATOS DE CONTACTO
                ============================================ -->
                <div class="seccion-formulario" style="border-left-color: var(--secondary);">
                    <div class="seccion-titulo" style="color: var(--secondary);">
                        <i class="fas fa-envelope"></i> Datos de Contacto
                    </div>
                    <p class="seccion-descripcion">Información para contacto y notificaciones.</p>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="email">
                                Correo Electrónico <span class="required">*</span>
                            </label>
                            <input type="email" 
                                   id="email" 
                                   name="email" 
                                   class="form-control <?php echo isset($errores['email']) ? 'error' : ''; ?>" 
                                   value="<?php echo htmlspecialchars($datos['email'] ?? ''); ?>" 
                                   placeholder="" 
                                   required>
                            <?php if (isset($errores['email'])): ?>
                                <div class="error-message"><i class="fas fa-times-circle"></i> <?php echo $errores['email']; ?></div>
                            <?php endif; ?>
                        </div>

                        <div class="form-group">
                            <label for="telefono">
                                Teléfono / Celular <span class="required">*</span>
                            </label>
                            <input type="tel" 
                                   id="telefono" 
                                   name="telefono" 
                                   class="form-control <?php echo isset($errores['telefono']) ? 'error' : ''; ?>" 
                                   value="<?php echo htmlspecialchars($datos['telefono'] ?? ''); ?>" 
                                   placeholder="" 
                                   required>
                            <?php if (isset($errores['telefono'])): ?>
                                <div class="error-message"><i class="fas fa-times-circle"></i> <?php echo $errores['telefono']; ?></div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="institucion">
                            Institución / Organización <span class="required">*</span>
                        </label>
                        <input type="text" 
                               id="institucion" 
                               name="institucion" 
                               class="form-control <?php echo isset($errores['institucion']) ? 'error' : ''; ?>" 
                               value="<?php echo htmlspecialchars($datos['institucion'] ?? ''); ?>" 
                               placeholder="" 
                               required>
                        <?php if (isset($errores['institucion'])): ?>
                            <div class="error-message"><i class="fas fa-times-circle"></i> <?php echo $errores['institucion']; ?></div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- ============================================
                TÉRMINOS Y CONDICIONES
                ============================================ -->
                <div class="form-group-checkbox <?php echo isset($errores['terminos']) ? 'error' : ''; ?>">
                    <input type="checkbox" id="terminos" name="terminos" value="1" <?php echo isset($datos['terminos']) ? 'checked' : ''; ?>>
                    <label for="terminos">
                        Confirmo que los datos proporcionados son correctos y autorizo el uso de esta información para fines del registro en el CADE Educativo.
                        <span class="required">*</span>
                    </label>
                </div>
                <?php if (isset($errores['terminos'])): ?>
                    <div class="error-message" style="margin-top: -0.5rem; margin-bottom: 1rem;">
                        <i class="fas fa-times-circle"></i> <?php echo $errores['terminos']; ?>
                    </div>
                <?php endif; ?>

                <!-- ============================================
                BOTÓN DE ENVÍO
                ============================================ -->
                <button type="submit" class="btn-submit" id="btnSubmit">
                    <i class="fas fa-pen"></i>
                    Registrar participación
                </button>

                <p class="texto-informativo">
                    <i class="fas fa-lock"></i>
                    Tus datos están seguros y serán utilizados exclusivamente para este registro.
                </p>
            </form>
        </div>
    </main>

    <!-- ============================================
    FOOTER
    ============================================ -->
    <footer class="footer">
        <div class="footer-container">
            <div class="footer-content">
                <div class="footer-logo">
                    <img src="<?php echo BASE_URL; ?>img/logo1.png" alt="Logo Universidad" class="logo-img">
                    <span>Universidad Peruana Unión</span>
                </div>
                <div class="footer-info">
                    <p><i class="fas fa-calendar-alt"></i> Aniversario 2026</p>
                    <p><i class="fas fa-map-marker-alt"></i> Campus UPeU-Tarapoto</p>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; <?php echo date('Y'); ?> Universidad - Todos los derechos reservados</p>
            </div>
        </div>
    </footer>

    <!-- ============================================
    JAVASCRIPT
    ============================================ -->
    <script src="<?php echo BASE_URL; ?>js/cade.js"></script>
</body>
</html>