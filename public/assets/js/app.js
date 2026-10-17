/**
 * Ecotech Service — site JavaScript.
 * Navbar state, mobile drawer, flash dismiss, counters, accordions, and a
 * reduced-motion-aware reveal. No cursor effects, loaders or hover motion.
 */
(function () {
  'use strict';

  var reduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

  // ── Navbar rule appears once the page scrolls ─────────────────────
  var navbar = document.getElementById('navbar');
  if (navbar) {
    var onScroll = function () { navbar.classList.toggle('scrolled', window.scrollY > 8); };
    window.addEventListener('scroll', onScroll, { passive: true });
    onScroll();
  }

  // ── Mobile drawer ─────────────────────────────────────────────────
  var drawer  = document.getElementById('mobileDrawer');
  var overlay = document.getElementById('mobileDrawerOverlay');
  var openBtn = document.getElementById('mobileDrawerOpen');
  var closeBtn = document.getElementById('mobileDrawerClose');
  var lastFocus = null;

  function openDrawer() {
    if (!drawer) return;
    lastFocus = document.activeElement;
    drawer.classList.add('active', 'open');
    drawer.setAttribute('aria-hidden', 'false');
    if (overlay) overlay.classList.add('active');
    if (openBtn) openBtn.setAttribute('aria-expanded', 'true');
    document.body.style.overflow = 'hidden';
    var first = drawer.querySelector('a, button');
    if (first) first.focus();
  }
  function closeDrawer() {
    if (!drawer) return;
    drawer.classList.remove('active', 'open');
    drawer.setAttribute('aria-hidden', 'true');
    if (overlay) overlay.classList.remove('active');
    if (openBtn) openBtn.setAttribute('aria-expanded', 'false');
    document.body.style.overflow = '';
    if (lastFocus && lastFocus.focus) lastFocus.focus();
  }
  if (openBtn)  openBtn.addEventListener('click', openDrawer);
  if (closeBtn) closeBtn.addEventListener('click', closeDrawer);
  if (overlay)  overlay.addEventListener('click', closeDrawer);
  document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape' && drawer && drawer.classList.contains('open')) closeDrawer();
  });

  // ── Flash message: removed after 6s ───────────────────────────────
  document.querySelectorAll('#flashMsg').forEach(function (el) {
    setTimeout(function () { el.remove(); }, 6000);
  });

  // ── Counters: [data-counter] (optional data-target), keeps suffix ─
  function runCounter(el) {
    var raw = el.dataset.target || el.textContent;
    var target = parseFloat(raw);
    if (isNaN(target)) return;
    var suffix = el.textContent.replace(/[\d.,\s]/g, '');
    if (reduced) { el.textContent = target + suffix; return; }
    var start = null;
    var dur = 1100;
    function tick(t) {
      if (start === null) start = t;
      var p = Math.min(1, (t - start) / dur);
      var v = target * (1 - Math.pow(1 - p, 3));
      el.textContent = (Number.isInteger(target) ? Math.round(v) : v.toFixed(1)) + suffix;
      if (p < 1) requestAnimationFrame(tick);
    }
    requestAnimationFrame(tick);
  }

  // ── Accordions ────────────────────────────────────────────────────
  // Generic: [data-acc] button with aria-controls → panel (hidden attr).
  document.querySelectorAll('[data-acc]').forEach(function (btn) {
    btn.addEventListener('click', function () {
      var panel = document.getElementById(btn.getAttribute('aria-controls'));
      if (!panel) return;
      var open = btn.getAttribute('aria-expanded') === 'true';
      btn.setAttribute('aria-expanded', open ? 'false' : 'true');
      panel.hidden = open;
      var sign = btn.querySelector('.s-acc-sign');
      if (sign) sign.textContent = open ? '+' : '\u2212';
    });
  });
  // Legacy: .faq-item / .faq-button (one open at a time).
  document.querySelectorAll('.faq-button').forEach(function (button) {
    button.addEventListener('click', function () {
      var item = button.closest('.faq-item');
      if (!item) return;
      var wasActive = item.classList.contains('active');
      document.querySelectorAll('.faq-item').forEach(function (i) { i.classList.remove('active'); });
      if (!wasActive) item.classList.add('active');
    });
  });

  // ── Reveal on scroll: [data-reveal] (CSS hides only under .s-js) ──
  var reveals  = document.querySelectorAll('[data-reveal]');
  var counters = document.querySelectorAll('[data-counter]');

  if (reduced || !('IntersectionObserver' in window)) {
    reveals.forEach(function (el) { el.classList.add('is-in'); });
    counters.forEach(runCounter);
    return;
  }

  var io = new IntersectionObserver(function (entries) {
    entries.forEach(function (entry) {
      if (!entry.isIntersecting) return;
      var el = entry.target;
      if (el.hasAttribute('data-counter')) runCounter(el);
      else el.classList.add('is-in');
      io.unobserve(el);
    });
  }, { rootMargin: '0px 0px -8% 0px', threshold: 0.12 });

  reveals.forEach(function (el) { io.observe(el); });
  counters.forEach(function (el) { io.observe(el); });
})();
