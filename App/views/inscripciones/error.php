<?php
$actividad = $data['actividad'] ?? null;
$error = $data['error'] ?? 'Ocurrió un error al procesar la inscripción.';
$title = $data['title'] ?? 'Error en la inscripción';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($title); ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>css/styles.css">
    <style>
        body {
            background: #f3f2f3;
            font-family: 'Inter', sans-serif;
            margin: 0;
        }
        .main-content {
            max-width: 760px;
            margin: 60px auto;
            padding: 20px;
        }
        .error-card {
            background: #fff;
            border-radius: 18px;
            box-shadow: 0 10px 35px rgba(0, 0, 0, 0.08);
            border: 1px solid rgba(0,0,0,0.04);
            padding: 2.5rem;
            text-align: center;
        }
        .error-icon {
            width: 100px;
            height: 100px;
            margin: 0 auto 1.5rem;
            background: linear-gradient(135deg, #ef4444, #b91c1c);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 3rem;
            box-shadow: 0 10px 25px rgba(239, 68, 68, 0.3);
        }
        h1 {
            color: #003366;
            font-size: 2rem;
            margin-bottom: 0.75rem;
        }
        .mensaje {
            color: #3A4A5F;
            font-size: 1.08rem;
            line-height: 1.6;
            margin-bottom: 1.5rem;
        }
        .actividad {
            display: inline-block;
            margin-bottom: 1.2rem;
            padding: 0.55rem 1rem;
            background: #f8fafc;
            border: 1px solid #dfe7f1;
            border-radius: 999px;
            color: #003366;
            font-weight: 700;
        }
        .btn-volver {
            display: inline-flex;
            align-items: center;
            gap: 0.6rem;
            padding: 0.85rem 1.5rem;
            background: linear-gradient(135deg, #003366, #002244);
            color: white;
            text-decoration: none;
            border-radius: 999px;
            font-weight: 700;
            transition: transform 0.2s ease;
        }
        .btn-volver:hover {
            transform: translateY(-2px);
        }
    </style>
</head>
<body>
    <header class="header">
        <div class="header-container">
            <div class="header-logo">
                <i class="fas fa-university"></i>
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

    <main class="main-content">
        <div class="error-card">
            <div class="error-icon">
                <i class="fas fa-exclamation-triangle"></i>
            </div>
            <h1>Ocurrió un problema</h1>

            <?php if ($actividad): ?>
                <div class="actividad">
                    <i class="fas fa-tag"></i>
                    <?php echo htmlspecialchars($actividad['nombre'] ?? 'Actividad'); ?>
                </div>
            <?php endif; ?>

            <p class="mensaje">
                <?php echo htmlspecialchars($error); ?>
            </p>

            <a href="<?php echo BASE_URL; ?>" class="btn-volver">
                <i class="fas fa-arrow-left"></i>
                Volver al inicio
            </a>
        </div>
    </main>
</body>
</html>
