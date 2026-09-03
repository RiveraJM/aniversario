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
    <title>Registro Institucional - <?php echo htmlspecialchars($actividad['nombre']); ?></title>
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- CSS del formulario -->
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>css/registro.css">
    
    <!-- Estilos del header y footer -->
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>css/styles.css">
</head>
<body class="registro-page">
    <!-- ============================================
    HEADER
    ============================================ -->
    <header class="header">
        <div class="header-container">
            <a href="<?php echo BASE_URL; ?>" class="header-home-link" aria-label="Ir al inicio">
                <img src="<?php echo BASE_URL; ?>img/logo1.png" alt="Logo Universidad Peruana Unión" class="header-university-logo">
            </a>
            <div class="header-logo">
                <span class="header-title">21 <span class="highlight">ANIVERSARIO</span></span>
            </div>
            <nav class="header-nav">
                <ul>
                    <li><a href="<?php echo BASE_URL; ?>">Inicio</a></li>
                    <li><a href="<?php echo BASE_URL; ?>" class="active">Actividades</a></li>
                    
                </ul>
            </nav>
        </div>
    </header>

    <!-- ============================================
    MAIN CONTENT
    ============================================ -->
    <main class="registro-container">
        <div class="registro-card">
            <!-- Header del formulario -->
            <div class="registro-header">
                <div class="icono-institucion">
                    <i class="fas <?php echo $actividad['icono']; ?>"></i>
                </div>
                <h1>Registro Institucional</h1>
                <p class="subtitulo">Registra la participación de tu institución en:</p>
                <div class="actividad-nombre">
                    <i class="fas fa-tag"></i> <?php echo htmlspecialchars($actividad['nombre']); ?>
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
            <form action="<?php echo BASE_URL; ?>registro/guardar" method="POST" id="formRegistro">
                <input type="hidden" name="actividad_id" value="<?php echo $actividad['id']; ?>">
                <?php
                $nombreActividad = strtolower($actividad['nombre'] ?? '');

                if (stripos($nombreActividad, 'sesión solemne') !== false) {
                    ?>
                    <div class="seccion-formulario">
                        <div class="seccion-titulo"><i class="fas fa-user-tie"></i> Datos del representante</div>
                        <p class="seccion-descripcion">Registro por representante y cantidad de asistentes.</p>

                        <div class="form-group">
                            <label for="institucion">Nombre de la institución <span class="required">*</span></label>
                            <input type="text" id="institucion" name="institucion" class="form-control <?php echo isset($errores['institucion']) ? 'error' : ''; ?>" value="<?php echo htmlspecialchars($datos['institucion'] ?? ''); ?>" required>
                            <?php if (isset($errores['institucion'])): ?><div class="error-message"><i class="fas fa-times-circle"></i> <?php echo $errores['institucion']; ?></div><?php endif; ?>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="representante">Nombre del representante <span class="required">*</span></label>
                                <input type="text" id="representante" name="representante" class="form-control <?php echo isset($errores['representante']) ? 'error' : ''; ?>" value="<?php echo htmlspecialchars($datos['representante'] ?? ''); ?>" required>
                                <?php if (isset($errores['representante'])): ?><div class="error-message"><i class="fas fa-times-circle"></i> <?php echo $errores['representante']; ?></div><?php endif; ?>
                            </div>
                            <div class="form-group">
                                <label for="cargo">Cargo <span class="required">*</span></label>
                                <input type="text" id="cargo" name="cargo" class="form-control <?php echo isset($errores['cargo']) ? 'error' : ''; ?>" value="<?php echo htmlspecialchars($datos['cargo'] ?? ''); ?>" required>
                                <?php if (isset($errores['cargo'])): ?><div class="error-message"><i class="fas fa-times-circle"></i> <?php echo $errores['cargo']; ?></div><?php endif; ?>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="telefono">Celular <span class="required">*</span></label>
                                <input type="tel" id="telefono" name="telefono" class="form-control <?php echo isset($errores['telefono']) ? 'error' : ''; ?>" value="<?php echo htmlspecialchars($datos['telefono'] ?? ''); ?>" required>
                                <?php if (isset($errores['telefono'])): ?><div class="error-message"><i class="fas fa-times-circle"></i> <?php echo $errores['telefono']; ?></div><?php endif; ?>
                            </div>
                            <div class="form-group">
                                <label for="email">Correo <span class="required">*</span></label>
                                <input type="email" id="email" name="email" class="form-control <?php echo isset($errores['email']) ? 'error' : ''; ?>" value="<?php echo htmlspecialchars($datos['email'] ?? ''); ?>" required>
                                <?php if (isset($errores['email'])): ?><div class="error-message"><i class="fas fa-times-circle"></i> <?php echo $errores['email']; ?></div><?php endif; ?>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="cantidad_participantes">Cantidad de participantes <span class="required">*</span></label>
                                <input type="number" id="cantidad_participantes" name="cantidad_participantes" class="form-control <?php echo isset($errores['cantidad_participantes']) ? 'error' : ''; ?>" value="<?php echo htmlspecialchars($datos['cantidad_participantes'] ?? 1); ?>" min="1" required>
                                <?php if (isset($errores['cantidad_participantes'])): ?><div class="error-message"><i class="fas fa-times-circle"></i> <?php echo $errores['cantidad_participantes']; ?></div><?php endif; ?>
                            </div>
                            
                        </div>
                    </div>
                    <?php
                } elseif (stripos($nombreActividad, 'desfile') !== false) {
                    ?>
                    <div class="seccion-formulario">
                        <div class="seccion-titulo"><i class="fas fa-flag"></i> Datos de la delegación</div>
                        <p class="seccion-descripcion">Registro por delegación.</p>

                        <div class="form-group">
                            <label for="nombre_delegacion">Nombre de la delegación <span class="required">*</span></label>
                            <input type="text" id="nombre_delegacion" name="nombre_delegacion" class="form-control <?php echo isset($errores['nombre_delegacion']) ? 'error' : ''; ?>" value="<?php echo htmlspecialchars($datos['nombre_delegacion'] ?? ''); ?>" required>
                            <?php if (isset($errores['nombre_delegacion'])): ?><div class="error-message"><i class="fas fa-times-circle"></i> <?php echo $errores['nombre_delegacion']; ?></div><?php endif; ?>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="nombre_contacto">Nombre <span class="required">*</span></label>
                                <input type="text" id="nombre_contacto" name="nombre_contacto" class="form-control <?php echo isset($errores['nombre']) ? 'error' : ''; ?>" value="<?php echo htmlspecialchars($datos['nombre_contacto'] ?? ''); ?>" required>
                                <?php if (isset($errores['nombre'])): ?><div class="error-message"><i class="fas fa-times-circle"></i> <?php echo $errores['nombre']; ?></div><?php endif; ?>
                            </div>
                            <div class="form-group">
                                <label for="telefono">Celular <span class="required">*</span></label>
                                <input type="tel" id="telefono" name="telefono" class="form-control <?php echo isset($errores['telefono']) ? 'error' : ''; ?>" value="<?php echo htmlspecialchars($datos['telefono'] ?? ''); ?>" required>
                                <?php if (isset($errores['telefono'])): ?><div class="error-message"><i class="fas fa-times-circle"></i> <?php echo $errores['telefono']; ?></div><?php endif; ?>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="email">Correo <span class="required">*</span></label>
                                <input type="email" id="email" name="email" class="form-control <?php echo isset($errores['email']) ? 'error' : ''; ?>" value="<?php echo htmlspecialchars($datos['email'] ?? ''); ?>" required>
                                <?php if (isset($errores['email'])): ?><div class="error-message"><i class="fas fa-times-circle"></i> <?php echo $errores['email']; ?></div><?php endif; ?>
                            </div>
                            <div class="form-group">
                                <label for="numero_participantes">Número de participantes <span class="required">*</span></label>
                                <input type="number" id="numero_participantes" name="numero_participantes" class="form-control <?php echo isset($errores['numero_participantes']) ? 'error' : ''; ?>" value="<?php echo htmlspecialchars($datos['numero_participantes'] ?? 1); ?>" min="1" required>
                                <?php if (isset($errores['numero_participantes'])): ?><div class="error-message"><i class="fas fa-times-circle"></i> <?php echo $errores['numero_participantes']; ?></div><?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <?php
                } elseif (stripos($nombreActividad, 'deporte') !== false || stripos($nombreActividad, 'interiglesias') !== false) {
                    ?>
                    <div class="seccion-formulario">
                        <div class="seccion-titulo"><i class="fas fa-futbol"></i> Datos del equipo</div>
                        <p class="seccion-descripcion">Registro por institución y disciplina. Puede elegir varias disciplinas.</p>

                        <div class="form-group">
                            <label for="institucion">Institución <span class="required">*</span></label>
                            <input type="text" id="institucion" name="institucion" class="form-control <?php echo isset($errores['institucion']) ? 'error' : ''; ?>" value="<?php echo htmlspecialchars($datos['institucion'] ?? ''); ?>" required>
                            <?php if (isset($errores['institucion'])): ?><div class="error-message"><i class="fas fa-times-circle"></i> <?php echo $errores['institucion']; ?></div><?php endif; ?>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="equipo">Nombre del equipo <span class="required">*</span></label>
                                <input type="text" id="equipo" name="equipo" class="form-control <?php echo isset($errores['equipo']) ? 'error' : ''; ?>" value="<?php echo htmlspecialchars($datos['equipo'] ?? ''); ?>" required>
                                <?php if (isset($errores['equipo'])): ?><div class="error-message"><i class="fas fa-times-circle"></i> <?php echo $errores['equipo']; ?></div><?php endif; ?>
                            </div>
                            <div class="form-group">
                                <label for="telefono">Celular <span class="required">*</span></label>
                                <input type="tel" id="telefono" name="telefono" class="form-control <?php echo isset($errores['telefono']) ? 'error' : ''; ?>" value="<?php echo htmlspecialchars($datos['telefono'] ?? ''); ?>" required>
                                <?php if (isset($errores['telefono'])): ?><div class="error-message"><i class="fas fa-times-circle"></i> <?php echo $errores['telefono']; ?></div><?php endif; ?>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="email">Correo <span class="required">*</span></label>
                            <input type="email" id="email" name="email" class="form-control <?php echo isset($errores['email']) ? 'error' : ''; ?>" value="<?php echo htmlspecialchars($datos['email'] ?? ''); ?>" required>
                            <?php if (isset($errores['email'])): ?><div class="error-message"><i class="fas fa-times-circle"></i> <?php echo $errores['email']; ?></div><?php endif; ?>
                        </div>

                        <div class="form-group">
                            <label>Disciplina(s) <span class="required">*</span></label>
                            <div class="checkbox-list" style="display:grid; gap:0.6rem; margin-top:0.5rem;">
                                <?php
                                $disciplinasDisponibles = ['Fútbol varones', 'Vóley varones', 'Básquet varones', 'Fútbol mujeres', 'Vóley mujeres', 'Básquet mujeres'];
                                $disciplinasSeleccionadas = is_array($datos['disciplinas'] ?? null) ? $datos['disciplinas'] : explode(', ', trim((string)($datos['disciplinas'] ?? '')));
                                foreach ($disciplinasDisponibles as $disciplina) {
                                    $checked = in_array($disciplina, $disciplinasSeleccionadas, true) ? 'checked' : '';
                                    echo '<label style="display:flex; align-items:center; gap:0.7rem; cursor:pointer; padding:0.5rem 0.75rem; border:1px solid #dfe7ee; border-radius:10px; background:#f8fafc;">';
                                    echo '<input type="checkbox" name="disciplinas[]" value="' . htmlspecialchars($disciplina) . '" ' . $checked . ' />';
                                    echo '<span>' . htmlspecialchars($disciplina) . '</span>';
                                    echo '</label>';
                                }
                                ?>
                            </div>
                            <div class="help-text">Marca las disciplinas que aplique a tu equipo.</div>
                            <?php if (isset($errores['disciplinas'])): ?><div class="error-message"><i class="fas fa-times-circle"></i> <?php echo $errores['disciplinas']; ?></div><?php endif; ?>
                        </div>
                    </div>
                    <?php
                } elseif (stripos($nombreActividad, 'alzare') !== false || stripos($nombreActividad, 'alzaré') !== false || stripos($nombreActividad, 'voz') !== false) {
                    ?>
                    <div class="seccion-formulario">
                        <div class="seccion-titulo"><i class="fas fa-microphone"></i> Datos del conjunto</div>
                        <p class="seccion-descripcion">Registro por institución y conjunto artístico.</p>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="institucion">Institución a la que representan <span class="required">*</span></label>
                                <input type="text" id="institucion" name="institucion" class="form-control <?php echo isset($errores['institucion']) ? 'error' : ''; ?>" value="<?php echo htmlspecialchars($datos['institucion'] ?? ''); ?>" required>
                                <?php if (isset($errores['institucion'])): ?><div class="error-message"><i class="fas fa-times-circle"></i> <?php echo $errores['institucion']; ?></div><?php endif; ?>
                            </div>
                            <div class="form-group">
                                <label for="ciudad">Ciudad <span class="required">*</span></label>
                                <input type="text" id="ciudad" name="ciudad" class="form-control <?php echo isset($errores['ciudad']) ? 'error' : ''; ?>" value="<?php echo htmlspecialchars($datos['ciudad'] ?? ''); ?>" required>
                                <?php if (isset($errores['ciudad'])): ?><div class="error-message"><i class="fas fa-times-circle"></i> <?php echo $errores['ciudad']; ?></div><?php endif; ?>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="nombre_equipo">Nombre del equipo o conjunto <span class="required">*</span></label>
                            <input type="text" id="nombre_equipo" name="nombre_equipo" class="form-control <?php echo isset($errores['nombre_equipo']) ? 'error' : ''; ?>" value="<?php echo htmlspecialchars($datos['nombre_equipo'] ?? ''); ?>" required>
                            <?php if (isset($errores['nombre_equipo'])): ?><div class="error-message"><i class="fas fa-times-circle"></i> <?php echo $errores['nombre_equipo']; ?></div><?php endif; ?>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="nombre_contacto">Nombre <span class="required">*</span></label>
                                <input type="text" id="nombre_contacto" name="nombre_contacto" class="form-control <?php echo isset($errores['nombre']) ? 'error' : ''; ?>" value="<?php echo htmlspecialchars($datos['nombre_contacto'] ?? ''); ?>" required>
                                <?php if (isset($errores['nombre'])): ?><div class="error-message"><i class="fas fa-times-circle"></i> <?php echo $errores['nombre']; ?></div><?php endif; ?>
                            </div>
                            <div class="form-group">
                                <label for="telefono">Celular <span class="required">*</span></label>
                                <input type="tel" id="telefono" name="telefono" class="form-control <?php echo isset($errores['telefono']) ? 'error' : ''; ?>" value="<?php echo htmlspecialchars($datos['telefono'] ?? ''); ?>" required>
                                <?php if (isset($errores['telefono'])): ?><div class="error-message"><i class="fas fa-times-circle"></i> <?php echo $errores['telefono']; ?></div><?php endif; ?>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="email">Correo <span class="required">*</span></label>
                            <input type="email" id="email" name="email" class="form-control <?php echo isset($errores['email']) ? 'error' : ''; ?>" value="<?php echo htmlspecialchars($datos['email'] ?? ''); ?>" required>
                            <?php if (isset($errores['email'])): ?><div class="error-message"><i class="fas fa-times-circle"></i> <?php echo $errores['email']; ?></div><?php endif; ?>
                        </div>
                    </div>
                    <?php
                } else {
                    ?>
                    <div class="seccion-formulario">
                        <div class="seccion-titulo"><i class="fas fa-building"></i> Datos de la institución</div>
                        <p class="seccion-descripcion">Información básica del participante o institución.</p>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="institucion">Nombre de la institución <span class="required">*</span></label>
                                <input type="text" id="institucion" name="institucion" class="form-control <?php echo isset($errores['institucion']) ? 'error' : ''; ?>" value="<?php echo htmlspecialchars($datos['institucion'] ?? ''); ?>" required>
                                <?php if (isset($errores['institucion'])): ?><div class="error-message"><i class="fas fa-times-circle"></i> <?php echo $errores['institucion']; ?></div><?php endif; ?>
                            </div>
                            <div class="form-group">
                                <label for="tipo_institucion">Tipo de institución <span class="required">*</span></label>
                                <select id="tipo_institucion" name="tipo_institucion" class="form-control <?php echo isset($errores['tipo_institucion']) ? 'error' : ''; ?>" required>
                                    <option value="">Seleccionar...</option>
                                    <option value="universidad" <?php echo (($datos['tipo_institucion'] ?? '') == 'universidad') ? 'selected' : ''; ?>>Universidad</option>
                                    <option value="instituto" <?php echo (($datos['tipo_institucion'] ?? '') == 'instituto') ? 'selected' : ''; ?>>Instituto</option>
                                    <option value="colegio" <?php echo (($datos['tipo_institucion'] ?? '') == 'colegio') ? 'selected' : ''; ?>>Colegio</option>
                                    <option value="iglesia" <?php echo (($datos['tipo_institucion'] ?? '') == 'iglesia') ? 'selected' : ''; ?>>Iglesia / Congregación</option>
                                    <option value="otro" <?php echo (($datos['tipo_institucion'] ?? '') == 'otro') ? 'selected' : ''; ?>>Otro</option>
                                </select>
                                <?php if (isset($errores['tipo_institucion'])): ?><div class="error-message"><i class="fas fa-times-circle"></i> <?php echo $errores['tipo_institucion']; ?></div><?php endif; ?>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="nombres">Nombres <span class="required">*</span></label>
                                <input type="text" id="nombres" name="nombres" class="form-control <?php echo isset($errores['nombres']) ? 'error' : ''; ?>" value="<?php echo htmlspecialchars($datos['nombres'] ?? ''); ?>" required>
                                <?php if (isset($errores['nombres'])): ?><div class="error-message"><i class="fas fa-times-circle"></i> <?php echo $errores['nombres']; ?></div><?php endif; ?>
                            </div>
                            <div class="form-group">
                                <label for="apellidos">Apellidos <span class="required">*</span></label>
                                <input type="text" id="apellidos" name="apellidos" class="form-control <?php echo isset($errores['apellidos']) ? 'error' : ''; ?>" value="<?php echo htmlspecialchars($datos['apellidos'] ?? ''); ?>" required>
                                <?php if (isset($errores['apellidos'])): ?><div class="error-message"><i class="fas fa-times-circle"></i> <?php echo $errores['apellidos']; ?></div><?php endif; ?>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="dni">DNI <span class="required">*</span></label>
                                <input type="text" id="dni" name="dni" class="form-control <?php echo isset($errores['dni']) ? 'error' : ''; ?>" value="<?php echo htmlspecialchars($datos['dni'] ?? ''); ?>" maxlength="8" required>
                                <?php if (isset($errores['dni'])): ?><div class="error-message"><i class="fas fa-times-circle"></i> <?php echo $errores['dni']; ?></div><?php endif; ?>
                            </div>
                            <div class="form-group">
                                <label for="telefono">Teléfono <span class="required">*</span></label>
                                <input type="tel" id="telefono" name="telefono" class="form-control <?php echo isset($errores['telefono']) ? 'error' : ''; ?>" value="<?php echo htmlspecialchars($datos['telefono'] ?? ''); ?>" required>
                                <?php if (isset($errores['telefono'])): ?><div class="error-message"><i class="fas fa-times-circle"></i> <?php echo $errores['telefono']; ?></div><?php endif; ?>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="email">Correo <span class="required">*</span></label>
                            <input type="email" id="email" name="email" class="form-control <?php echo isset($errores['email']) ? 'error' : ''; ?>" value="<?php echo htmlspecialchars($datos['email'] ?? ''); ?>" required>
                            <?php if (isset($errores['email'])): ?><div class="error-message"><i class="fas fa-times-circle"></i> <?php echo $errores['email']; ?></div><?php endif; ?>
                        </div>
                    </div>
                    <?php
                }
                ?>

                <div class="form-group-checkbox <?php echo isset($errores['terminos']) ? 'error' : ''; ?>">
                    <input type="checkbox" id="terminos" name="terminos" value="1" <?php echo isset($datos['terminos']) ? 'checked' : ''; ?>>
                    <label for="terminos">
                        Confirmo que los datos proporcionados son correctos y autorizo el uso de esta información para fines del registro.
                        <span class="required">*</span>
                    </label>
                </div>
                <?php if (isset($errores['terminos'])): ?>
                    <div class="error-message" style="margin-top: -0.5rem; margin-bottom: 1rem;">
                        <i class="fas fa-times-circle"></i> <?php echo $errores['terminos']; ?>
                    </div>
                <?php endif; ?>

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
            const form = document.getElementById('formRegistro');
            const btnSubmit = document.getElementById('btnSubmit');

            // Validación en tiempo real de DNI (solo números)
            const dniInput = document.getElementById('representante_dni');
            if (dniInput) {
                dniInput.addEventListener('input', function() {
                    this.value = this.value.replace(/\D/g, '').slice(0, 8);
                });
            }

            // Validación en tiempo real de teléfonos (solo números)
            const telefonoInputs = document.querySelectorAll('input[type="tel"]');
            telefonoInputs.forEach(input => {
                input.addEventListener('input', function() {
                    this.value = this.value.replace(/\D/g, '');
                });
            });

            // Prevenir envío doble
            form.addEventListener('submit', function(e) {
                btnSubmit.disabled = true;
                btnSubmit.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Registrando...';
            });
        });
    </script>
</body>
</html>