<?php
$actividad = $data['actividad'] ?? null;
$registro = $data['registro'] ?? null;
$codigo = $data['codigo'] ?? 'REG-' . strtoupper(substr(md5(uniqid()), 0, 8));
$nombre_participante = $registro['nombres'] ?? $registro['representante'] ?? 'Participante';
$es_individual = isset($registro['nombres']); // Si tiene nombres, es registro individual
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>¡Registro Exitoso! - Aniversario 2026</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>css/styles.css">
    <style>
        /* ========================================
           CONFIRMACIÓN - DISEÑO PROFESIONAL
           ======================================== */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --primary: #003366;
            --primary-dark: #002244;
            --secondary: #F8A900;
            --secondary-light: #FFC940;
            --white: #FFFFFF;
            --gold-gradient: linear-gradient(135deg, #F8A900, #FFC940, #F8A900);
            --shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
            --radius: 20px;
        }

        body {
            font-family: 'Inter', -apple-system, sans-serif;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            background: var(--primary);
            background-image: 
                radial-gradient(ellipse at 10% 20%, rgba(248, 169, 0, 0.15) 0%, transparent 50%),
                radial-gradient(ellipse at 90% 80%, rgba(248, 169, 0, 0.1) 0%, transparent 50%);
        }

        /* ========================================
           HEADER
           ======================================== */
        .header {
            background: rgba(0, 51, 102, 0.95);
            backdrop-filter: blur(10px);
            padding: 0 2rem;
            position: sticky;
            top: 0;
            z-index: 1000;
            border-bottom: 2px solid rgba(248, 169, 0, 0.2);
        }

        .header-container {
            max-width: 1400px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.8rem 0;
        }

        .header-logo {
            display: flex;
            align-items: center;
            gap: 0.8rem;
            font-size: 1.5rem;
            font-weight: 800;
            color: var(--white);
        }

        .header-logo i {
            color: var(--secondary);
        }

        .header-logo .highlight {
            color: var(--secondary);
        }

        /* ========================================
           MAIN CONTENT
           ======================================== */
        .main-content {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
            min-height: 80vh;
        }

        /* ========================================
           TARJETA DE CONFIRMACIÓN
           ======================================== */
        .confirmacion-card {
            max-width: 750px;
            width: 100%;
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(20px);
            border-radius: var(--radius);
            padding: 3rem;
            box-shadow: var(--shadow);
            text-align: center;
            position: relative;
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, 0.2);
            animation: slideUp 0.8s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .confirmacion-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 6px;
            background: var(--gold-gradient);
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(40px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* ========================================
           CONFETTI / DECORACIONES
           ======================================== */
        .confetti-container {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            pointer-events: none;
            overflow: hidden;
            z-index: 0;
        }

        .confetti {
            position: absolute;
            width: 10px;
            height: 10px;
            border-radius: 2px;
            animation: confettiFall 4s ease-in-out infinite;
        }

        @keyframes confettiFall {
            0% {
                transform: translateY(-20px) rotate(0deg);
                opacity: 1;
            }
            100% {
                transform: translateY(500px) rotate(720deg);
                opacity: 0;
            }
        }

        /* ========================================
           ICONO DE ÉXITO
           ======================================== */
        .success-icon {
            width: 100px;
            height: 100px;
            background: linear-gradient(135deg, #22C55E, #16A34A);
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 3.5rem;
            color: var(--white);
            margin-bottom: 1.5rem;
            box-shadow: 0 12px 40px rgba(34, 197, 94, 0.4);
            position: relative;
            z-index: 1;
            animation: pulseCheck 2s ease-in-out infinite;
        }

        @keyframes pulseCheck {
            0%, 100% {
                transform: scale(1);
                box-shadow: 0 12px 40px rgba(34, 197, 94, 0.4);
            }
            50% {
                transform: scale(1.05);
                box-shadow: 0 16px 60px rgba(34, 197, 94, 0.6);
            }
        }

        /* ========================================
           TÍTULOS Y TEXTOS
           ======================================== */
        .confirmacion-card h1 {
            font-size: 2.8rem;
            font-weight: 900;
            color: var(--primary);
            margin-bottom: 0.3rem;
            position: relative;
            z-index: 1;
            letter-spacing: -0.5px;
        }

        .confirmacion-card h1 .highlight {
            color: var(--secondary);
        }

        .confirmacion-card .subtitulo {
            font-size: 1.2rem;
            color: var(--text-secondary);
            margin-bottom: 0.5rem;
            position: relative;
            z-index: 1;
        }

        .confirmacion-card .actividad-nombre {
            display: inline-block;
            background: var(--secondary);
            color: var(--primary);
            padding: 0.4rem 2rem;
            border-radius: 50px;
            font-weight: 700;
            font-size: 1rem;
            margin: 0.5rem 0 1rem;
            position: relative;
            z-index: 1;
            box-shadow: 0 4px 16px rgba(248, 169, 0, 0.3);
        }

        /* ========================================
           MENSAJE PERSONALIZADO
           ======================================== */
        .mensaje-bienvenida {
            background: linear-gradient(135deg, rgba(0, 51, 102, 0.05), rgba(248, 169, 0, 0.05));
            border-radius: 16px;
            padding: 1.5rem;
            margin: 1.5rem 0;
            border-left: 4px solid var(--secondary);
            position: relative;
            z-index: 1;
        }

        .mensaje-bienvenida p {
            font-size: 1.05rem;
            color: var(--text-primary);
            line-height: 1.8;
            margin-bottom: 0.5rem;
        }

        .mensaje-bienvenida .fecha-evento {
            display: inline-block;
            background: var(--primary);
            color: var(--white);
            padding: 0.3rem 1.2rem;
            border-radius: 50px;
            font-size: 0.85rem;
            margin-top: 0.5rem;
        }

        /* ========================================
           CÓDIGO DE REGISTRO
           ======================================== */
        .codigo-container {
            display: inline-block;
            background: var(--primary);
            color: var(--white);
            padding: 0.6rem 2.5rem;
            border-radius: 50px;
            font-weight: 700;
            font-size: 1.3rem;
            letter-spacing: 2px;
            margin: 1rem 0 0.5rem;
            box-shadow: 0 4px 20px rgba(0, 51, 102, 0.3);
            position: relative;
            z-index: 1;
            font-family: 'Courier New', monospace;
        }

        .codigo-container i {
            color: var(--secondary);
            margin-right: 0.5rem;
        }

        /* ========================================
           DETALLES DEL REGISTRO
           ======================================== */
        .detalle-registro {
            text-align: left;
            background: var(--background);
            border-radius: 12px;
            padding: 1.2rem 1.5rem;
            margin: 1.5rem 0;
            position: relative;
            z-index: 1;
        }

        .detalle-registro .row {
            display: flex;
            padding: 0.4rem 0;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        }

        .detalle-registro .row:last-child {
            border-bottom: none;
        }

        .detalle-registro .label {
            font-weight: 600;
            color: var(--text-secondary);
            width: 140px;
            flex-shrink: 0;
            font-size: 0.85rem;
        }

        .detalle-registro .value {
            color: var(--text-primary);
            font-weight: 500;
            font-size: 0.9rem;
        }

        /* ========================================
           PRÓXIMOS PASOS
           ======================================== */
        .proximos-pasos {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1rem;
            margin: 1.5rem 0;
            position: relative;
            z-index: 1;
        }

        .paso-item {
            background: var(--background);
            border-radius: 12px;
            padding: 1rem;
            text-align: center;
            transition: all 0.3s;
        }

        .paso-item:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08);
        }

        .paso-item .paso-icono {
            font-size: 1.8rem;
            color: var(--secondary);
            margin-bottom: 0.3rem;
        }

        .paso-item .paso-numero {
            display: inline-block;
            background: var(--primary);
            color: var(--white);
            width: 24px;
            height: 24px;
            border-radius: 50%;
            font-size: 0.7rem;
            font-weight: 700;
            line-height: 24px;
            margin-bottom: 0.3rem;
        }

        .paso-item .paso-texto {
            font-size: 0.8rem;
            color: var(--text-secondary);
            font-weight: 500;
        }

        /* ========================================
           BOTÓN VOLVER
           ======================================== */
        .btn-volver {
            display: inline-flex;
            align-items: center;
            gap: 0.8rem;
            padding: 0.9rem 2.5rem;
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: var(--white);
            border: none;
            border-radius: 50px;
            font-weight: 700;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.3s;
            text-decoration: none;
            box-shadow: 0 4px 20px rgba(0, 51, 102, 0.3);
            position: relative;
            z-index: 1;
        }

        .btn-volver:hover {
            transform: translateY(-3px) scale(1.02);
            box-shadow: 0 8px 40px rgba(0, 51, 102, 0.4);
        }

        .btn-volver i {
            transition: transform 0.3s;
        }

        .btn-volver:hover i {
            transform: translateX(-4px);
        }

        /* ========================================
           FOOTER
           ======================================== */
        .footer {
            background: rgba(0, 51, 102, 0.95);
            backdrop-filter: blur(10px);
            color: rgba(255, 255, 255, 0.6);
            padding: 1.5rem 0;
            text-align: center;
            border-top: 1px solid rgba(255, 255, 255, 0.05);
            margin-top: auto;
        }

        .footer p {
            font-size: 0.85rem;
        }

        .footer .corazon {
            color: #EF4444;
        }

        /* ========================================
           RESPONSIVE
           ======================================== */
        @media (max-width: 768px) {
            .confirmacion-card {
                padding: 1.5rem;
            }
            
            .confirmacion-card h1 {
                font-size: 2rem;
            }
            
            .proximos-pasos {
                grid-template-columns: 1fr;
                gap: 0.8rem;
            }
            
            .detalle-registro .row {
                flex-direction: column;
                gap: 0.2rem;
            }
            
            .detalle-registro .label {
                width: 100%;
            }
            
            .codigo-container {
                font-size: 1rem;
                padding: 0.5rem 1.5rem;
            }
            
            .btn-volver {
                width: 100%;
                justify-content: center;
            }
        }

        @media (max-width: 480px) {
            .confirmacion-card {
                padding: 1rem;
                border-radius: 12px;
            }
            
            .confirmacion-card h1 {
                font-size: 1.6rem;
            }
            
            .success-icon {
                width: 70px;
                height: 70px;
                font-size: 2.5rem;
            }
            
            .mensaje-bienvenida p {
                font-size: 0.95rem;
            }
        }
    </style>
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
        </div>
    </header>

    <!-- ============================================
    MAIN CONTENT
    ============================================ -->
    <main class="main-content">
        <div class="confirmacion-card">
            <!-- CONFETTI DECORATIVO -->
            <div class="confetti-container">
                <div class="confetti" style="left: 10%; animation-delay: 0s; background: #F8A900;"></div>
                <div class="confetti" style="left: 25%; animation-delay: 0.5s; background: #003366;"></div>
                <div class="confetti" style="left: 40%; animation-delay: 1s; background: #FFC940;"></div>
                <div class="confetti" style="left: 55%; animation-delay: 0.3s; background: #22C55E;"></div>
                <div class="confetti" style="left: 70%; animation-delay: 0.8s; background: #F8A900;"></div>
                <div class="confetti" style="left: 85%; animation-delay: 1.2s; background: #003366;"></div>
                <div class="confetti" style="left: 15%; animation-delay: 0.6s; background: #FF6B6B;"></div>
                <div class="confetti" style="left: 45%; animation-delay: 0.2s; background: #22C55E;"></div>
                <div class="confetti" style="left: 65%; animation-delay: 0.9s; background: #FFC940;"></div>
                <div class="confetti" style="left: 35%; animation-delay: 0.4s; background: #F8A900;"></div>
            </div>

            <!-- ICONO DE ÉXITO -->
            <div class="success-icon">
                <i class="fas fa-check"></i>
            </div>

            <!-- TÍTULO -->
            <h1>
                <span class="highlight">¡Registro</span> Exitoso!
            </h1>
            <p class="subtitulo">
                <?php echo $es_individual ? 'Has participado en:' : 'Tu institución ha participado en:'; ?>
            </p>

            <div class="actividad-nombre">
                <i class="fas fa-tag"></i> <?php echo htmlspecialchars($actividad['nombre'] ?? 'Actividad'); ?>
            </div>

            <!-- MENSAJE PERSONALIZADO -->
            <div class="mensaje-bienvenida">
                <p>
                    <strong>🎊 ¡Felicidades, <?php echo htmlspecialchars($nombre_participante); ?>!</strong>
                </p>
                <p>
                    Te damos la más cordial bienvenida a la celebración del 
                    <strong>21° Aniversario de la Universidad Peruana Unión</strong>.
                    Tu participación es muy valiosa para nosotros y estamos seguros 
                    de que vivirás una experiencia inolvidable.
                </p>
                <p>
                    <i class="fas fa-calendar-alt" style="color: var(--secondary);"></i>
                    <strong>¡Nos vemos en la celebración!</strong>
                </p>
                <div class="fecha-evento">
                    <i class="fas fa-calendar-day"></i> 13 - 18 de Octubre, 2026
                </div>
            </div>

            <!-- CÓDIGO DE REGISTRO -->
            <div class="codigo-container">
                <i class="fas fa-qrcode"></i> <?php echo $codigo; ?>
            </div>
            <p style="font-size: 0.8rem; color: var(--text-light); margin-top: 0.2rem; position: relative; z-index: 1;">
                Guarda este código para futuras referencias
            </p>

            <!-- DETALLES DEL REGISTRO -->
            <div class="detalle-registro">
                <?php if ($es_individual): ?>
                    <div class="row">
                        <span class="label">Participante</span>
                        <span class="value"><?php echo htmlspecialchars($registro['nombres'] . ' ' . $registro['apellidos']); ?></span>
                    </div>
                    <div class="row">
                        <span class="label">DNI</span>
                        <span class="value"><?php echo htmlspecialchars($registro['dni'] ?? '-'); ?></span>
                    </div>
                    <div class="row">
                        <span class="label">Institución</span>
                        <span class="value"><?php echo htmlspecialchars($registro['institucion'] ?? '-'); ?></span>
                    </div>
                    <div class="row">
                        <span class="label">Correo</span>
                        <span class="value"><?php echo htmlspecialchars($registro['email'] ?? '-'); ?></span>
                    </div>
                <?php else: ?>
                    <div class="row">
                        <span class="label">Institución</span>
                        <span class="value"><?php echo htmlspecialchars($registro['institucion'] ?? '-'); ?></span>
                    </div>
                    <div class="row">
                        <span class="label">Representante</span>
                        <span class="value"><?php echo htmlspecialchars($registro['representante'] ?? '-'); ?></span>
                    </div>
                    <div class="row">
                        <span class="label">Participantes</span>
                        <span class="value"><?php echo htmlspecialchars($registro['participantes'] ?? 1); ?></span>
                    </div>
                <?php endif; ?>
                <div class="row">
                    <span class="label">Fecha registro</span>
                    <span class="value"><?php echo date('d/m/Y H:i:s'); ?></span>
                </div>
            </div>

            <!-- PRÓXIMOS PASOS -->
            <div class="proximos-pasos">
                <div class="paso-item">
                    <div class="paso-icono">
                        <i class="fas fa-calendar-check"></i>
                    </div>
                    <div class="paso-numero">1</div>
                    <div class="paso-texto">Confirma tu asistencia</div>
                </div>
                <div class="paso-item">
                    <div class="paso-icono">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <div class="paso-numero">2</div>
                    <div class="paso-texto">Revisa tu correo</div>
                </div>
                <div class="paso-item">
                    <div class="paso-icono">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="paso-numero">3</div>
                    <div class="paso-texto">¡Disfruta el evento!</div>
                </div>
            </div>

            <!-- BOTÓN VOLVER -->
            <a href="<?php echo BASE_URL; ?>" class="btn-volver">
                <i class="fas fa-arrow-left"></i>
                Volver al inicio
            </a>

            <p style="font-size: 0.75rem; color: var(--text-light); margin-top: 1rem; position: relative; z-index: 1;">
                
                Universidad Peruana Unión - 21 Aniversario
            </p>
        </div>
    </main>

    <!-- ============================================
    FOOTER
    ============================================ -->
    <footer class="footer">
        <p>
            &copy; <?php echo date('Y'); ?> Universidad Peruana Unión -  Tarapoto 
            
        </p>
    </footer>
</body>
</html>