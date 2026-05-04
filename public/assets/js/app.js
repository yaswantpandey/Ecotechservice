/**
 * Ecotech Service — Main Frontend JavaScript
 */

// ── Navbar scroll effect ─────────────────────────────────────
const navbar = document.getElementById('navbar');
if (navbar) {
  window.addEventListener('scroll', () => {
    navbar.classList.toggle('scrolled', window.scrollY > 20);
  }, { passive: true });
}

// ── Mobile menu toggle ───────────────────────────────────────
const menuToggle = document.getElementById('menuToggle');
const mobileMenu = document.getElementById('mobileMenu');
if (menuToggle && mobileMenu) {
  menuToggle.addEventListener('click', () => {
    mobileMenu.classList.toggle('hidden');
    const icon = menuToggle.querySelector('i');
    icon.classList.toggle('fa-bars');
    icon.classList.toggle('fa-times');
  });
}

// ── Flash message auto-dismiss ───────────────────────────────
const flash = document.getElementById('flashMsg');
if (flash) {
  setTimeout(() => {
    flash.style.opacity = '0';
    flash.style.transform = 'translateX(40px)';
    flash.style.transition = 'opacity 0.4s, transform 0.4s';
    setTimeout(() => flash.remove(), 400);
  }, 5000);
}

// ── Intersection Observer — scroll animations ────────────────
const observerOptions = { threshold: 0.1, rootMargin: '0px 0px -40px 0px' };
const observer = new IntersectionObserver((entries) => {
  entries.forEach(entry => {
    if (entry.isIntersecting) {
      entry.target.classList.add('animate-fadeInUp');
      entry.target.style.opacity = '1';
      observer.unobserve(entry.target);
    }
  });
}, observerOptions);

document.querySelectorAll('.service-card, .project-card, .stat-card, .testimonial-card').forEach(el => {
  el.style.opacity = '0';
  observer.observe(el);
});

// ── Smooth counter animation ─────────────────────────────────
function animateCounter(el) {
  const target = parseFloat(el.dataset.target || el.textContent);
  const suffix = el.textContent.replace(/[\d.]/g, '');
  const duration = 1500;
  const step = target / (duration / 16);
  let current = 0;
  const timer = setInterval(() => {
    current = Math.min(current + step, target);
    el.textContent = (Number.isInteger(target) ? Math.floor(current) : current.toFixed(1)) + suffix;
    if (current >= target) clearInterval(timer);
  }, 16);
}

const counterObserver = new IntersectionObserver((entries) => {
  entries.forEach(entry => {
    if (entry.isIntersecting) {
      animateCounter(entry.target);
      counterObserver.unobserve(entry.target);
    }
  });
}, { threshold: 0.5 });

document.querySelectorAll('[data-counter]').forEach(el => counterObserver.observe(el));
