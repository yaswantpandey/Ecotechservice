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

// ── Mobile drawer & menu toggle ───────────────────────────────
const drawerOpenBtn = document.getElementById('mobileDrawerOpen');
const drawerCloseBtn = document.getElementById('mobileDrawerClose');
const drawerOverlay = document.getElementById('mobileDrawerOverlay');
const mobileDrawer = document.getElementById('mobileDrawer');

function openMobileDrawer() {
  if (mobileDrawer) {
    mobileDrawer.style.visibility = 'visible';
    mobileDrawer.classList.add('active');
    document.body.style.overflow = 'hidden';
  }
}

function closeMobileDrawer() {
  if (mobileDrawer) {
    mobileDrawer.classList.remove('active');
    document.body.style.overflow = '';
    setTimeout(() => {
      if (!mobileDrawer.classList.contains('active')) {
        mobileDrawer.style.visibility = 'hidden';
      }
    }, 280);
  }
}

if (drawerOpenBtn) drawerOpenBtn.addEventListener('click', openMobileDrawer);
if (drawerCloseBtn) drawerCloseBtn.addEventListener('click', closeMobileDrawer);
if (drawerOverlay) drawerOverlay.addEventListener('click', closeMobileDrawer);

// Legacy menuToggle fallback
const menuToggle = document.getElementById('menuToggle');
const mobileMenu = document.getElementById('mobileMenu');
if (menuToggle && mobileMenu) {
  menuToggle.addEventListener('click', () => {
    mobileMenu.classList.toggle('hidden');
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

// ── Live Typing Effect for Hero ─────────────────────────────
const typingEl = document.getElementById('typingText');
if (typingEl) {
  const words = ['Custom Web Apps', 'High-Performance Software', 'Eco-Tech Solutions', 'Digital Growth Engines'];
  let wordIndex = 0;
  let charIndex = 0;
  let isDeleting = false;

  function type() {
    const currentWord = words[wordIndex];
    if (isDeleting) {
      typingEl.textContent = currentWord.substring(0, charIndex - 1);
      charIndex--;
    } else {
      typingEl.textContent = currentWord.substring(0, charIndex + 1);
      charIndex++;
    }

    let typeSpeed = isDeleting ? 40 : 80;

    if (!isDeleting && charIndex === currentWord.length) {
      typeSpeed = 2200; // Pause at end
      isDeleting = true;
    } else if (isDeleting && charIndex === 0) {
      isDeleting = false;
      wordIndex = (wordIndex + 1) % words.length;
      typeSpeed = 400;
    }

    setTimeout(type, typeSpeed);
  }
  setTimeout(type, 800);
}

// ── FAQ Accordion Toggle ─────────────────────────────────────
document.querySelectorAll('.faq-button').forEach(button => {
  button.addEventListener('click', () => {
    const faqItem = button.closest('.faq-item');
    const isActive = faqItem.classList.contains('active');

    // Close all FAQs
    document.querySelectorAll('.faq-item').forEach(item => item.classList.remove('active'));

    // Toggle current
    if (!isActive) {
      faqItem.classList.add('active');
    }
  });
});

// ── Interactive Glassmorphism Loading Screen Logic ────────────
(function initGlassLoader() {
  const loadingScreen = document.getElementById('loadingScreen');
  const progressFill = document.getElementById('loaderFill');
  const percentText = document.getElementById('loaderPercent');
  const messageText = document.getElementById('loaderMessage');

  if (!loadingScreen) return;

  const messages = [
    'Building smarter digital experiences',
    'Securing your digital world',
    'Engineering technology for tomorrow',
    'Innovation. Security. Technology.'
  ];

  let progress = 0;
  let messageIdx = 0;

  // Rotate tagline messages
  const messageInterval = setInterval(() => {
    if (!messageText) return;
    messageText.style.opacity = '0';
    messageText.style.transform = 'translateY(-6px)';
    
    setTimeout(() => {
      messageIdx = (messageIdx + 1) % messages.length;
      messageText.textContent = messages[messageIdx];
      messageText.style.opacity = '1';
      messageText.style.transform = 'translateY(0)';
    }, 300);
  }, 1800);

  // Animate Progress 0% to 100%
  const duration = 1200; // Fast & smooth entrance
  const startTime = performance.now();

  function updateProgress(currentTime) {
    const elapsed = currentTime - startTime;
    progress = Math.min(100, Math.floor((elapsed / duration) * 100));

    if (progressFill) progressFill.style.width = progress + '%';
    if (percentText) percentText.textContent = 'Loading ' + progress + '%';

    if (progress < 100) {
      requestAnimationFrame(updateProgress);
    } else {
      // Completed loading sequence
      clearInterval(messageInterval);
      setTimeout(dismissLoadingScreen, 250);
    }
  }

  requestAnimationFrame(updateProgress);

  function dismissLoadingScreen() {
    loadingScreen.classList.add('loaded');
    setTimeout(() => {
      loadingScreen.remove();
      // Trigger entrance animations for main content
      document.body.classList.add('page-ready');
    }, 700);
  }
})();

// ── Custom Desktop Pointer Cursor ─────────────────────────────
(function initCustomCursor() {
  const cursor = document.getElementById('customCursor');
  const cursorDot = document.getElementById('customCursorDot');

  if (!cursor || !cursorDot || window.matchMedia('(hover: none)').matches) return;

  let mouseX = window.innerWidth / 2;
  let mouseY = window.innerHeight / 2;
  let cursorX = mouseX;
  let cursorY = mouseY;

  window.addEventListener('mousemove', (e) => {
    mouseX = e.clientX;
    mouseY = e.clientY;
    cursorDot.style.left = mouseX + 'px';
    cursorDot.style.top = mouseY + 'px';
  }, { passive: true });

  function renderCursor() {
    cursorX += (mouseX - cursorX) * 0.25;
    cursorY += (mouseY - cursorY) * 0.25;
    cursor.style.left = cursorX + 'px';
    cursor.style.top = cursorY + 'px';
    requestAnimationFrame(renderCursor);
  }
  requestAnimationFrame(renderCursor);

  // Expand cursor on interactive elements
  const hoverSelectors = 'a, button, input, select, textarea, .glass-card, .tech-card, .faq-button';
  document.addEventListener('mouseover', (e) => {
    if (e.target.closest(hoverSelectors)) {
      document.body.classList.add('cursor-hover');
    }
  });

  document.addEventListener('mouseout', (e) => {
    if (e.target.closest(hoverSelectors)) {
      document.body.classList.remove('cursor-hover');
    }
  });
})();

// ── Card Mouse Spotlight Radial Effect ────────────────────────
document.querySelectorAll('.glass-card, .card-spotlight, .tech-card').forEach(card => {
  card.addEventListener('mousemove', (e) => {
    const rect = card.getBoundingClientRect();
    const x = e.clientX - rect.left;
    const y = e.clientY - rect.top;
    card.style.setProperty('--mouse-x', x + 'px');
    card.style.setProperty('--mouse-y', y + 'px');
  });
});


