<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acceso - Aniversario 2026</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --primary: #003366;
            --secondary: #F8A900;
            --white: #FFFFFF;
            --radius: 16px;
            --shadow: 0 8px 32px rgba(0, 0, 0, 0.15);
        }

        body {
            font-family: 'Inter', -apple-system, sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: var(--primary);
            background-image: 
                linear-gradient(135deg, rgba(0, 51, 102, 0.85) 0%, rgba(0, 26, 51, 0.80) 40%, rgba(0, 51, 102, 0.85) 100%),
                url('<?php echo BASE_URL; ?>img/campus.webp');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            padding: 1.5rem;
        }

        .login-container {
            max-width: 420px;
            width: 100%;
            background: rgba(255, 255, 255, 0.96);
            backdrop-filter: blur(20px);
            border-radius: var(--radius);
            padding: 2.5rem;
            box-shadow: var(--shadow);
            border: 1px solid rgba(255, 255, 255, 0.2);
            position: relative;
            overflow: hidden;
        }

        .login-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(135deg, #F8A900 0%, #FFC940 50%, #F8A900 100%);
        }

        .login-logo {
            text-align: center;
            margin-bottom: 1.5rem;
        }

        .login-logo img {
            height: 70px;
            width: auto;
            object-fit: contain;
            filter: drop-shadow(0 4px 12px rgba(0, 0, 0, 0.08));
        }

        .login-logo h1 {
            font-size: 1.5rem;
            font-weight: 800;
            color: var(--primary);
            margin-top: 0.5rem;
        }

        .login-logo .highlight {
            color: var(--secondary);
        }

        .login-logo p {
            color: #6B7A8F;
            font-size: 0.9rem;
            margin-top: 0.2rem;
        }

        .form-group {
            margin-bottom: 1.2rem;
        }

        .form-group label {
            display: block;
            font-weight: 600;
            color: #172033;
            margin-bottom: 0.3rem;
            font-size: 0.85rem;
        }

        .form-group .input-group {
            position: relative;
        }

        .form-group .input-group i {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #9CA3AF;
            font-size: 1rem;
        }

        .form-control {
            width: 100%;
            padding: 0.8rem 1rem 0.8rem 2.8rem;
            border: 2px solid #E5E7EB;
            border-radius: 10px;
            font-family: 'Inter', sans-serif;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            background: var(--white);
            color: #172033;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(0, 51, 102, 0.08);
        }

        .form-control::placeholder {
            color: #9CA3AF;
        }

        .btn-login {
            width: 100%;
            padding: 0.9rem;
            background: linear-gradient(135deg, #003366 0%, #001a33 100%);
            color: var(--white);
            border: none;
            border-radius: 50px;
            font-weight: 700;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 20px rgba(0, 51, 102, 0.25);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.6rem;
            font-family: 'Inter', sans-serif;
        }

        .btn-login:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 32px rgba(0, 51, 102, 0.35);
        }

        .btn-login i {
            font-size: 1.1rem;
        }

        .error-message {
            background: #FEE2E2;
            border: 1px solid #FECACA;
            color: #991B1B;
            padding: 0.8rem 1rem;
            border-radius: 10px;
            margin-bottom: 1.2rem;
            display: flex;
            align-items: center;
            gap: 0.6rem;
            font-size: 0.9rem;
        }

        .error-message i {
            font-size: 1.1rem;
        }

        .login-footer {
            text-align: center;
            margin-top: 1.2rem;
            font-size: 0.8rem;
            color: #6B7A8F;
        }

        .login-footer i {
            color: var(--secondary);
        }

        @media (max-width: 480px) {
            .login-container {
                padding: 1.5rem;
            }

            .login-logo img {
                height: 55px;
            }

            .login-logo h1 {
                font-size: 1.2rem;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-logo">
            <img src="<?php echo $publicUrl ?? BASE_URL; ?>img/logo1.png" alt="Universidad Peruana Unión">
            <h1>Aniversario <span class="highlight">2026</span></h1>
            <p>Ingresa con tus credenciales</p>
        </div>

        <?php if (isset($error)): ?>
            <div class="error-message">
                <i class="fas fa-exclamation-circle"></i>
                <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>

        <form action="<?php echo $publicUrl ?? BASE_URL; ?>?url=auth/login" method="POST">
            <div class="form-group">
                <label for="usuario">Usuario</label>
                <div class="input-group">
                    <i class="fas fa-user"></i>
                    <input type="text" id="usuario" name="usuario" class="form-control" placeholder="Ingresa tu usuario" required>
                </div>
            </div>

            <div class="form-group">
                <label for="password">Contraseña</label>
                <div class="input-group">
                    <i class="fas fa-lock"></i>
                    <input type="password" id="password" name="password" class="form-control" placeholder="Ingresa tu contraseña" required>
                </div>
            </div>

            <button type="submit" class="btn-login">
                <i class="fas fa-arrow-right-to-bracket"></i>
                Ingresar
            </button>
        </form>

        <div class="login-footer">
            <i class="fas fa-info-circle"></i>
            Contacta al administrador si no tienes credenciales.
        </div>
    </div>
</body>
</html>