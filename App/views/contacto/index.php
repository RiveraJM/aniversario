<?php
// Detectar la URL pública de esta aplicación
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https://' : 'http://';
$host = $_SERVER['HTTP_HOST'] ?? 'localhost';

// Definir BASE_URL si no está definida
if (!defined('BASE_URL')) {
    $basePath = dirname($_SERVER['SCRIPT_NAME']);
    $basePath = ($basePath == '/' || $basePath == '\\') ? '' : $basePath;
    define('BASE_URL', $protocol . $host . $basePath . '/');
}

$publicUrl = $protocol . $host . rtrim(str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? '/')), '/') . '/';

// Resto de tu código...

// Si los datos vienen del controlador, usarlos, si no, usar datos por defecto
$contactos = $data['contactos'] ?? [
    [
        'id' => 1,
        'nombre' => 'Téc. Thaylí Loconi',
        'cargo' => 'Asistente de Dirección General de la UPeU, Campus Tarapoto',
        'telefono' => '+51 968 701 965',
        'email' => 'secretariag.tpp@upeu.edu.pe',
        'whatsapp' => '51968701965',
        'iniciales' => 'TL',
        'responsable' => true
    ],
    [
        'id' => 2,
        'nombre' => 'Lic. Edelways Ramos',
        'cargo' => 'Coordinadora de Imagen y Comunicaciones, UPeU Campus Tarapoto',
        'telefono' => '+51 968 701 951',
        'email' => 'imagen.tpp@upeu.edu.pe',
        'whatsapp' => '51968701951',
        'iniciales' => 'ER',
        'responsable' => false
    ]
];

$info_universidad = $data['info_universidad'] ?? [
    'nombre' => 'Universidad Peruana Unión',
    'direccion' => 'Jr Los Martires 340 Tarapoto - San Martín',
    'telefono' => '+51 967 262 821',
    'email' => 'aniversario@upeu.edu.pe',
    'horario_atencion' => 'Lunes a Viernes: 8:00 am - 5:00 pm'
];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contacto - Aniversario 2026</title>
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Estilos CSS -->
    <link rel="stylesheet" href="<?php echo $publicUrl; ?>css/styles.css">
    <link rel="stylesheet" href="<?php echo $publicUrl; ?>css/contacto.css">
</head>
<body>
    <!-- ============================================
    HEADER
    ============================================ -->
  

    <!-- ============================================
    MAIN CONTENT - PÁGINA DE CONTACTO
    ============================================ -->
    <div class="contacto-page">
            

            <!-- ========================================
            EQUIPO DE CONTACTO
            ============================================ -->
            <div class="contacto-panel">
                <div class="panel-title">
                    <h2><i class="fas fa-users" style="color: #FFFF"></i> Nuestro equipo</h2>
                    <p>Contáctate con nuestros encargados para resolver tus dudas sobre las actividades del aniversario.</p>
                </div>

                <div class="contacto-grid">
                    <?php foreach ($contactos as $contacto): ?>
                    <div class="contacto-card">
                        <!-- Badge de responsable -->
                        <?php if ($contacto['responsable']): ?>
                            <span class="badge-responsable"><i class="fas fa-star"></i> Responsable</span>
                        <?php endif; ?>

                        <!-- Avatar -->
                        <div class="contacto-avatar">
                            <span class="avatar-inicial"><?php echo $contacto['iniciales']; ?></span>
                        </div>

                        <!-- Nombre y cargo -->
                        <h3 class="contacto-nombre"><?php echo htmlspecialchars($contacto['nombre']); ?></h3>
                        <span class="contacto-cargo"><?php echo htmlspecialchars($contacto['cargo']); ?></span>

                        <div class="contacto-divider"></div>

                        <!-- Detalles de contacto -->
                        <div class="contacto-detalles">
                            <a class="contacto-item telefono-item" href="tel:<?php echo htmlspecialchars(preg_replace('/[^\d+]/', '', $contacto['telefono'])); ?>" aria-label="Llamar a <?php echo htmlspecialchars($contacto['nombre']); ?>">
                                <i class="fas fa-phone"></i>
                                <div>
                                    <span class="item-label"></span>
                                    <div class="item-value">
                                        <?php echo htmlspecialchars($contacto['telefono']); ?>
                                    </div>
                                </div>
                            </a>
                            
                        </div>

                        <!-- Botones de contacto -->
                        <div class="contacto-botones">
                            <a href="https://wa.me/<?php echo $contacto['whatsapp']; ?>" 
                               target="_blank" 
                               class="btn-contactar whatsapp">
                                <i class="fab fa-whatsapp"></i> WhatsApp
                            </a>
                            <a href="mailto:<?php echo htmlspecialchars($contacto['email']); ?>" 
                               class="btn-contactar email">
                                <i class="fas fa-envelope"></i> Correo
                            </a>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
    </div>

   

    <!-- ============================================
    JAVASCRIPT
    ============================================ -->
    <script src="<?php echo $publicUrl; ?>js/main.js"></script>
</body>
</html>

<style>
/* ========================================
   PÁGINA DE CONTACTO - ESTILOS PREMIUM
   ======================================== */

.contacto-page {
    padding: 0;
    margin: -1.5rem 0;
}

/* ========================================
   BANNER DE CONTACTO
   ======================================== */
.contacto-banner {
    background: linear-gradient(135deg, rgba(0, 51, 102, 0.92) 0%, rgba(0, 26, 51, 0.85) 100%);
    padding: 3rem 2rem;
    border-radius: 0 0 20px 30px;
    margin-bottom: 2.5rem;
    text-align: center;
    position: relative;
    overflow: hidden;
}

.contacto-banner::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -20%;
    width: 400px;
    height: 400px;
    background: radial-gradient(circle, rgba(248, 169, 0, 0.08), transparent 70%);
    border-radius: 50%;
}

.contacto-banner::after {
    content: '';
    position: absolute;
    bottom: -30%;
    left: -10%;
    width: 300px;
    height: 300px;
    background: radial-gradient(circle, rgba(248, 169, 0, 0.05), transparent 70%);
    border-radius: 50%;
}

.contacto-banner-content {
    position: relative;
    z-index: 2;
}

.contacto-banner h1 {
    font-size: 2.8rem;
    font-weight: 800;
    color: #FFFFFF;
    margin-bottom: 0.5rem;
}

.contacto-banner h1 i {
    color: var(--secondary);
    margin-right: 0.5rem;
}

.contacto-banner p {
    font-size: 1.2rem;
    color: rgba(255, 255, 255, 0.8);
    max-width: 600px;
    margin: 0 auto;
}

/* ========================================
   INFORMACIÓN DE LA UNIVERSIDAD
   ======================================== */
.info-universidad {
    max-width: 600px;
    margin: 0 auto 2.5rem;
    padding: 0 1.5rem;
}

.info-card {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(20px);
    border-radius: 16px;
    padding: 2rem;
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.12);
    border: 1px solid rgba(255, 255, 255, 0.2);
    text-align: center;
    transition: all 0.3s ease;
}

.info-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 40px rgba(0, 0, 0, 0.18);
}

.info-card i.fa-university {
    font-size: 3rem;
    color: var(--primary);
    margin-bottom: 0.5rem;
}

.info-card h3 {
    font-size: 1.3rem;
    font-weight: 700;
    color: var(--primary);
    margin-bottom: 1rem;
}

.info-card p {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.6rem;
    font-size: 0.9rem;
    color: var(--text-secondary);
    padding: 0.3rem 0;
    transition: all 0.3s ease;
}

.info-card p i {
    color: var(--secondary);
    width: 20px;
    text-align: center;
}

.info-card p:hover {
    color: var(--text-primary);
    transform: translateX(4px);
}

/* ========================================
   TÍTULO DEL PANEL
   ======================================== */
.contacto-panel {
    padding: 0.75rem 0 2rem;
    padding: 2.5rem 1.5rem;
    margin-left: -1.5rem;
    margin-right: -1.5rem;
    border-radius: 20px;
    background-image: linear-gradient(rgba(0, 26, 51, 0.72), rgba(0, 26, 51, 0.72)), url('<?php echo BASE_URL; ?>img/campus.webp');
    background-position: center;
    background-size: cover;
    background-attachment: fixed;
}

.contacto-intro {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    width: fit-content;
    margin: 0 auto 1rem;
    padding: 0.45rem 1rem;
    border-radius: 8px;
    background: rgba(0, 51, 102, 0.9);
    color: var(--white);
    font-size: 1rem;
    font-weight: 700;
}

.contacto-intro i {
    color: var(--secondary);
}

.contacto-panel > * {
    position: relative;
    z-index: 1;
}

.contacto-panel .panel-title h2,
.contacto-panel .panel-title p {
    color: var(--white);
}

.contacto-panel .panel-title {
    text-align: center;
    margin: 0 auto 2.5rem;
    padding: 1.25rem 1.5rem;
    max-width: 760px;
    border: 1px solid rgba(255, 255, 255, 0.35);
    border-radius: 16px;
    background: rgba(255, 255, 255, 0.9);
    backdrop-filter: blur(12px);
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.16);
}

.contacto-panel .panel-title h2 {
    font-size: 2.2rem;
    font-weight: 800;
    color: var(--primary);
    margin-bottom: 0.5rem;
    position: relative;
    display: inline-block;
}

.contacto-panel .panel-title h2 .fa-user,
.contacto-panel .panel-title h2 .fa-users {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 42px;
    height: 42px;
    margin-right: 0.5rem;
    border-radius: 50%;
    background: #002244;
    color: var(--primary);
    font-size: 1.1rem;
    vertical-align: middle;
    box-shadow: 0 4px 12px rgba(248, 169, 0, 0.3);
}

.contacto-panel .panel-title h2::after {
    content: '';
    position: absolute;
    bottom: -8px;
    left: 50%;
    transform: translateX(-50%);
    width: 80px;
    height: 4px;
    background: var(--gradient-gold);
    border-radius: 2px;
}

.contacto-panel .panel-title p {
    color: #002244;
    font-size: 1.1rem;
    margin-top: 1rem;
}

/* ========================================
   GRID DE CONTACTOS
   ======================================== */
.contacto-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
    gap: 2rem;
    max-width: 900px;
    margin: 0 auto;
}

/* ========================================
   TARJETA DE CONTACTO
   ======================================== */
.contacto-card {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(20px);
    border-radius: 16px;
    padding: 2rem;
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.12);
    border: 1px solid rgba(255, 255, 255, 0.2);
    text-align: center;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.contacto-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: var(--gradient-gold);
}

.contacto-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 12px 40px rgba(0, 0, 0, 0.18);
}

/* ========================================
   AVATAR
   ======================================== */
.contacto-avatar {
    width: 100px;
    height: 100px;
    border-radius: 50%;
    background: var(--gradient-primary);
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1rem;
    font-size: 2.8rem;
    color: #FFFFFF;
    box-shadow: 0 8px 24px rgba(0, 51, 102, 0.25);
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.contacto-avatar .avatar-inicial {
    font-size: 2.8rem;
    font-weight: 700;
    color: #FFFFFF;
}

.contacto-avatar::after {
    content: '';
    position: absolute;
    bottom: 0;
    right: 0;
    width: 28px;
    height: 28px;
    background: #d8910e;
    border-radius: 50%;
    border: 3px solid #FFFFFF;
    box-shadow: 0 2px 8px rgba(34, 197, 94, 0.3);
}

.contacto-card:hover .contacto-avatar {
    transform: scale(1.05);
    box-shadow: 0 12px 32px rgba(0, 51, 102, 0.35);
}

/* ========================================
   INFORMACIÓN DE CONTACTO
   ======================================== */
.contacto-card .contacto-nombre {
    font-size: 1.2rem;
    font-weight: 700;
    color: #172033;
    margin-bottom: 0.2rem;
}

.contacto-card .contacto-cargo {
    font-size: 0.85rem;
    color: #002244;
    font-weight: 600;
    display: inline-block;
    background: rgba(248, 169, 0, 0.1);
    padding: 0.2rem 1rem;
    border-radius: 50px;
    margin-bottom: 1rem;
}

.contacto-card .contacto-divider {
    height: 1px;
    background: linear-gradient(90deg, transparent, rgba(0, 51, 102, 0.1), transparent);
    margin: 0.8rem 0;
}

.contacto-card .contacto-detalles {
    display: flex;
    flex-direction: column;
    gap: 0.6rem;
    text-align: left;
    margin-bottom: 1.2rem;
}

.contacto-card .contacto-item {
    display: flex;
    align-items: center;
    gap: 0.8rem;
    font-size: 0.9rem;
    color: #3A4A5F;
    transition: all 0.3s ease;
    padding: 0.75rem 0.8rem;
    border: 1px solid rgba(0, 51, 102, 0.1);
    border-radius: 12px;
    background: rgba(255, 255, 255, 0.82);
    box-shadow: 0 3px 10px rgba(0, 0, 0, 0.06);
}

.contacto-card .contacto-item:hover {
    background: rgba(255, 255, 255, 0.98);
    border-color: rgba(248, 169, 0, 0.5);
    transform: translateY(-2px);
    box-shadow: 0 6px 14px rgba(0, 0, 0, 0.1);
}

.contacto-card .telefono-item {
    width: calc(50% - 0.4rem);
    height: 43px;
    margin: 0 auto;
    padding: 0.6rem 1.2rem;
    background: #002244;
    border-color: #002244;
    box-shadow: 0 4px 12px rgba(0, 34, 68, 0.25);
    justify-content: center;
    text-align: center;
    text-decoration: none;
    cursor: pointer;
}

.contacto-card .telefono-item:hover {
    background: #003366;
    border-color: #003366;
    box-shadow: 0 6px 16px rgba(0, 34, 68, 0.35);
}

.contacto-card .contacto-item i {
    width: 32px;
    height: 32px;
    background: rgba(0, 51, 102, 0.08);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #003366;
    font-size: 0.85rem;
    flex-shrink: 0;
    transition: all 0.3s ease;
}

.contacto-card .contacto-item:hover i {
    background: var(--gradient-primary);
    color: #FFFFFF;
}

.contacto-card .contacto-item .item-label {
    font-size: 0.7rem;
    text-transform: uppercase;
    color: #6B7A8F;
    font-weight: 500;
    letter-spacing: 0.04em;
}

.contacto-card .telefono-item .item-label,
.contacto-card .telefono-item .item-value,
.contacto-card .telefono-item a {
    color: #FFFFFF;
}

.contacto-card .telefono-item i {
   
    color: #FFFF;
}




.contacto-card .contacto-item .item-value {
    font-weight: 500;
    color: #FFFF;
}

.contacto-card .contacto-item a {
    color: #FFFF;
    text-decoration: none;
    transition: all 0.3s ease;
}

.contacto-card .contacto-item a:focus-visible {
    outline: 2px solid var(--secondary);
    outline-offset: 2px;
    border-radius: 4px;
}

.contacto-card .contacto-item a:hover {
    color: #003366;
}

/* ========================================
   BOTONES DE CONTACTO
   ======================================== */
.contacto-card .contacto-botones {
    display: flex;
    gap: 0.8rem;
    margin-top: 0.5rem;
}

.contacto-card .btn-contactar {
    flex: 1;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    padding: 0.6rem 1.2rem;
    border-radius: 50px;
    font-weight: 600;
    font-size: 0.85rem;
    text-decoration: none;
    transition: all 0.3s ease;
    border: none;
    cursor: pointer;
    font-family: 'Inter', sans-serif;
}

.contacto-card .btn-contactar.whatsapp {
    background: #002244;
    color: #FFFFFF;
    box-shadow: 0 4px 12px rgba(37, 211, 102, 0.25);
}

.contacto-card .btn-contactar.whatsapp:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 24px rgba(37, 211, 102, 0.35);
}

.contacto-card .btn-contactar.email {
    background: var(--gradient-primary);
    color: #FFFFFF;
    box-shadow: 0 4px 12px rgba(0, 51, 102, 0.25);
}

.contacto-card .btn-contactar.email:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 24px rgba(0, 51, 102, 0.35);
}

/* ========================================
   BADGE RESPONSABLE
   ======================================== */
.contacto-card .badge-responsable {
    position: absolute;
    top: 1rem;
    right: 1rem;
    background: rgba(248, 169, 0, 0.15);
    color: 0 4px 12px rgba(0, 51, 102, 0.25);
    padding: 0.2rem 0.8rem;
    border-radius: 50px;
    font-size: 0.65rem;
    font-weight: 600;
    border: 1px solid rgba(248, 169, 0, 0.2);
    text-transform: uppercase;
    letter-spacing: 0.04em;
}

/* ========================================
   RESPONSIVE
   ======================================== */
@media (max-width: 768px) {
    .contacto-panel {
        margin-left: -0.75rem;
        margin-right: -0.75rem;
    }

    .contacto-banner {
        padding: 2rem 1.5rem;
        border-radius: 0 0 20px 20px;
    }

    .contacto-banner p {
        font-size: 1rem;
    }

    .contacto-panel .panel-title h2 {
        font-size: 1.8rem;
    }

    .contacto-grid {
        grid-template-columns: 1fr;
        max-width: 100%;
        padding: 0 0.5rem;
    }

    .contacto-card {
        padding: 1.5rem;
    }

    .contacto-card .telefono-item {
        width: 100%;
        height: auto;
        margin: 0;
        justify-content: flex-start;
        text-align: left;
    }

    .contacto-avatar {
        width: 80px;
        height: 80px;
        font-size: 2.2rem;
    }

    .contacto-avatar .avatar-inicial {
        font-size: 2.2rem;
    }

    .contacto-card .contacto-botones {
        flex-direction: column;
    }

    .contacto-card .badge-responsable {
        position: static;
        display: inline-block;
        margin-bottom: 0.5rem;
    }

    .info-card {
        padding: 1.5rem;
    }
}

@media (max-width: 480px) {
    .contacto-page {
        margin: 0;
    }

    .contacto-panel {
        margin-left: -1rem;
        margin-right: -1rem;
    }

    .contacto-banner h1 {
        font-size: 1.6rem;
    }

    .contacto-banner p {
        font-size: 0.9rem;
    }

    .contacto-panel .panel-title h2 {
        font-size: 1.4rem;
    }

        padding: 1rem;
    }
        margin: 0 auto 2.5rem;
        padding: 1.25rem 1.5rem;
        border-radius: 12px;
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(12px);
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
    .contacto-avatar {
        width: 70px;
        height: 70px;
        font-size: 2rem;
    }

    .contacto-avatar .avatar-inicial {
        font-size: 2rem;
    }

    .contacto-card .contacto-nombre {
        font-size: 1rem;
    }

    .contacto-card .contacto-item {
        font-size: 0.8rem;
        padding: 0.2rem 0.4rem;
    }

    .contacto-card .contacto-item i {
        width: 28px;
        height: 28px;
        font-size: 0.75rem;
    }

    .contacto-card .btn-contactar {
        font-size: 0.8rem;
        padding: 0.5rem 1rem;
    }

    .info-card {
        padding: 1rem;
    }

    .info-card p {
        font-size: 0.8rem;
    }
}
</style>