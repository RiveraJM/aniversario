<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title ?? 'Aniversario Universitario 2026'; ?></title>
    
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>css/styles.css">
    <?php if (!empty($contactoCss)): ?>
        <link rel="stylesheet" href="<?php echo $publicUrl; ?>css/contacto.css">
    <?php endif; ?>
</head>
<body>
<?php
$navigationBaseUrl = $publicUrl ?? BASE_URL;
$info_universidad = $info_universidad ?? [
    'nombre' => 'Universidad Peruana Unión',
    'direccion' => 'Jr Los Martires 340 Tarapoto - San Martín',
    'telefono' => '+51 967 262 821',
    'horario_atencion' => 'Lunes a Viernes: 8:00 am - 5:00 pm'
];
?>
    <!-- Header -->
    <header class="header">
        <div class="header-container">
            <div class="header-logo">
                <img src="<?php echo $navigationBaseUrl; ?>img/logo1.png" alt="Logo Universidad Peruana Unión" class="logo-img">
                <span>Aniversario <span class="highlight">2026</span></span>
            </div>
            <nav class="header-nav">
                <ul>
                    <li><a href="<?php echo $navigationBaseUrl; ?>" class="active">Inicio</a></li>
                    <li><a href="<?php echo $navigationBaseUrl; ?>">Actividades</a></li>
                    <li><a href="<?php echo $navigationBaseUrl; ?>?url=contacto">Contacto</a></li>
                </ul>
            </nav>
            
        </div>
    </header>

    <!-- Main Content -->
    <main class="main-content">
        <?php echo $content ?? ''; ?>
    </main>

     <!-- ============================================
    FOOTER - INDEPENDIENTE
    ============================================ -->
    <footer class="footer">
        <div class="footer-container">
            <div class="footer-content">
                
                <div class="footer-info">
                    <p><i class="fas fa-map-marker-alt"></i> <?php echo htmlspecialchars($info_universidad['direccion']); ?></p>
                    <p><i class="fas fa-phone"></i> <?php echo htmlspecialchars($info_universidad['telefono']); ?></p>
                    <p><i class="fas fa-clock"></i> <?php echo htmlspecialchars($info_universidad['horario_atencion']); ?></p>
                </div>
            </div>
        </div>
    </footer>
    <script src="<?php echo BASE_URL; ?>js/main.js"></script>
</body>
</html>