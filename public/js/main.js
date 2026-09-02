// ========================================
// FUNCIONES GLOBALES
// ========================================

/**
 * Función para mostrar notificaciones
 */
function showNotification(message, activityId = null) {
    const notification = document.createElement('div');
    notification.style.cssText = `
        position: fixed;
        bottom: 30px;
        right: 30px;
        background: linear-gradient(135deg, #003366, #001a33);
        color: white;
        padding: 1.2rem 2rem;
        border-radius: 16px;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.3);
        border-left: 4px solid #F8A900;
        z-index: 9999;
        font-family: 'Inter', sans-serif;
        font-weight: 500;
        transform: translateX(100%);
        transition: transform 0.5s cubic-bezier(0.4, 0, 0.2, 1);
        max-width: 400px;
        display: flex;
        align-items: center;
        gap: 1rem;
    `;
    
    let content = `
        <i class="fas fa-calendar-check" style="color: #F8A900; font-size: 1.5rem; flex-shrink: 0;"></i>
        <div style="flex: 1;">
            <div style="font-weight: 600; margin-bottom: 0.2rem;">${message}</div>
    `;
    
    if (activityId) {
        content += `<div style="font-size: 0.8rem; opacity: 0.7;">ID: #${activityId}</div>`;
    }
    
    content += `
        </div>
        <button style="background: none; border: none; color: rgba(255,255,255,0.7); cursor: pointer; font-size: 1.2rem; padding: 0; margin: 0;" onclick="this.closest('div').remove();">
            <i class="fas fa-times"></i>
        </button>
    `;
    
    notification.innerHTML = content;
    document.body.appendChild(notification);
    
    setTimeout(() => {
        notification.style.transform = 'translateX(0)';
    }, 100);
    
    setTimeout(() => {
        notification.style.transform = 'translateX(110%)';
        setTimeout(() => {
            notification.remove();
        }, 500);
    }, 4000);
}

// ========================================
// CONTADOR DE ACTIVIDADES (Animación)
// ========================================
function animateCounter() {
    const counters = document.querySelectorAll('.hero-stat .number');
    
    counters.forEach(counter => {
        const target = parseInt(counter.textContent);
        let current = 0;
        const increment = Math.ceil(target / 50);
        const duration = 1500;
        const stepTime = duration / (target / increment);
        
        const timer = setInterval(() => {
            current += increment;
            if (current >= target) {
                counter.textContent = target;
                clearInterval(timer);
            } else {
                counter.textContent = current;
            }
        }, stepTime);
    });
}

// ========================================
// EFECTO DE PARALLAX EN HERO
// ========================================
function handleParallax() {
    const hero = document.querySelector('.hero-section');
    if (!hero) return;
    
    window.addEventListener('scroll', () => {
        const scrolled = window.pageYOffset;
        hero.style.backgroundPositionY = -(scrolled * 0.5) + 'px';
    });
}

// ========================================
// EFECTO DE RESALTE EN EL HEADER AL SCROLL
// ========================================
function handleHeaderScroll() {
    const header = document.querySelector('.header');
    let lastScroll = 0;
    
    window.addEventListener('scroll', function() {
        const currentScroll = window.pageYOffset;
        
        if (currentScroll > 50) {
            header.style.boxShadow = '0 4px 40px rgba(0, 0, 0, 0.3)';
            header.style.background = 'rgba(0, 51, 102, 0.98)';
        } else {
            header.style.boxShadow = '0 2px 30px rgba(0, 0, 0, 0.2)';
            header.style.background = 'rgba(0, 51, 102, 0.95)';
        }
        
        lastScroll = currentScroll;
    });
}

// ========================================
// ANIMACIÓN DE ENTRADA PARA LAS TARJETAS
// ========================================
function handleCardAnimations() {
    const cards = document.querySelectorAll('.actividad-card');
    
    if ('IntersectionObserver' in window) {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    observer.unobserve(entry.target);
                }
            });
        }, {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        });
        
        cards.forEach((card, index) => {
            card.style.animationDelay = (index * 0.1) + 's';
            observer.observe(card);
        });
    } else {
        cards.forEach((card, index) => {
            card.style.animationDelay = (index * 0.1) + 's';
            card.style.opacity = '1';
            card.style.transform = 'translateY(0)';
        });
    }
}

// ========================================
// EFECTOS DE INTERACCIÓN - CORREGIDO
// ========================================
function setupInteractions() {
    // Efecto en el ícono de usuario
    const userIcon = document.querySelector('.header-user');
    if (userIcon) {
        userIcon.addEventListener('click', function() {
            showNotification('🔐 Panel de acceso / Inicio de sesión');
        });
    }
    
    // ============================================
    // ENLACES DE NAVEGACIÓN - CORREGIDO
    // ============================================
    const navLinks = document.querySelectorAll('.header-nav a');
    navLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            const href = this.getAttribute('href');
            const texto = this.textContent.trim();
            
            // Si es un enlace vacío o #, prevenir y mostrar notificación
            if (href === '#' || href === '' || href === 'javascript:void(0)') {
                e.preventDefault();
                showNotification('📍 Navegando a: ' + texto);
                return;
            }
            
            // Si es el enlace de contacto, mostrar notificación antes de redirigir
            if (href && href.includes('contacto')) {
                e.preventDefault();
                showNotification('📍 Navegando a: ' + texto);
                setTimeout(() => {
                    window.location.href = href;
                }, 800);
                return;
            }
            
            // Para enlaces reales (como el de "Actividades")
            // Mostrar notificación y permitir navegación
            if (href && href !== '#' && !href.includes('contacto')) {
                // No prevenir el comportamiento por defecto para enlaces reales
                // Pero mostrar notificación
                showNotification('📍 Navegando a: ' + texto);
                
                // Actualizar clase active
                navLinks.forEach(l => l.classList.remove('active'));
                this.classList.add('active');
                // La navegación ocurre normalmente
            }
        });
    });
    
    // Enlaces de redes sociales
    const socialLinks = document.querySelectorAll('.footer-social a');
    socialLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const icon = this.querySelector('i');
            const red = icon ? icon.className : 'Red social';
            showNotification('🌐 ' + red + ' (Próximamente)');
        });
    });
}

// ========================================
// EFECTO DE PARTÍCULAS
// ========================================
function createParticles() {
    const hero = document.querySelector('.hero-section');
    if (!hero) return;
    
    const oldParticles = hero.querySelectorAll('.particle');
    oldParticles.forEach(p => p.remove());
    
    for (let i = 0; i < 20; i++) {
        const particle = document.createElement('div');
        particle.className = 'particle';
        particle.style.cssText = `
            position: absolute;
            width: ${Math.random() * 6 + 2}px;
            height: ${Math.random() * 6 + 2}px;
            background: rgba(248, 169, 0, ${Math.random() * 0.3 + 0.1});
            border-radius: 50%;
            top: ${Math.random() * 100}%;
            left: ${Math.random() * 100}%;
            animation: float ${Math.random() * 5 + 3}s ease-in-out infinite;
            animation-delay: ${Math.random() * 2}s;
            pointer-events: none;
            z-index: 1;
        `;
        hero.appendChild(particle);
    }
}

// ========================================
// INICIALIZACIÓN
// ========================================
document.addEventListener('DOMContentLoaded', function() {
    console.log('🎉 Dashboard del Aniversario - Premium Edition');
    console.log('📊 Total de actividades: ' + document.querySelectorAll('.actividad-card').length);
    
    setTimeout(animateCounter, 500);
    handleParallax();
    handleHeaderScroll();
    handleCardAnimations();
    setupInteractions();
    createParticles();
    
    console.log('✅ Todos los sistemas cargados correctamente');
});