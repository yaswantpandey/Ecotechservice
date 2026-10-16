/* ==========================================================================
   Home motion — GSAP + ScrollTrigger + Lenis.
   Content is fully visible without this file; motion is added on top only
   once the libraries load and the user has not asked for reduced motion.
   ========================================================================== */
import { gsap } from 'https://cdn.jsdelivr.net/npm/gsap@3.12.5/index.js';
import { ScrollTrigger } from 'https://cdn.jsdelivr.net/npm/gsap@3.12.5/ScrollTrigger.js';
import Lenis from 'https://cdn.jsdelivr.net/npm/lenis@1.1.13/dist/lenis.mjs';

const root = document.querySelector('.hx');
const reduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
const finePointer = window.matchMedia('(hover: hover) and (pointer: fine)').matches;

if (root) {
  initTestimonials();          // useful even with reduced motion (manual controls)
  if (!reduced) initMotion();
}

function initMotion() {
  gsap.registerPlugin(ScrollTrigger);
  root.classList.add('is-motion');

  // ── Smooth scroll, driven by GSAP's ticker so ScrollTrigger stays in sync ─
  const lenis = new Lenis({ duration: 1.15, smoothWheel: true });
  lenis.on('scroll', ScrollTrigger.update);
  gsap.ticker.add((t) => lenis.raf(t * 1000));
  gsap.ticker.lagSmoothing(0);

  // ── Hero intro ────────────────────────────────────────────────────────────
  const intro = gsap.timeline({ defaults: { ease: 'power4.out' } });
  intro
    .from('[data-hero-eyebrow]', { y: 16, opacity: 0, duration: 0.7 })
    .from('[data-split] .w > span', { yPercent: 115, duration: 1.1, stagger: 0.06 }, '-=0.35')
    .from('[data-hero-lede]', { y: 18, opacity: 0, duration: 0.8 }, '-=0.7')
    .from('[data-hero-cta] > *', { y: 18, opacity: 0, duration: 0.7, stagger: 0.08 }, '-=0.6')
    .from('[data-hero-meta] > *', { opacity: 0, y: 10, duration: 0.6, stagger: 0.06 }, '-=0.4')
    .from('[data-hero-canvas]', { opacity: 0, scale: 0.92, duration: 1.8, ease: 'power2.out' }, 0);

  // Hero copy lifts away as you scroll out of it
  gsap.to('[data-hero-copy]', {
    yPercent: -18, opacity: 0.15, ease: 'none',
    scrollTrigger: { trigger: '[data-hero]', start: 'top top', end: 'bottom top', scrub: true },
  });

  // ── Generic reveals (batched so a grid staggers as one) ──────────────────
  ScrollTrigger.batch('[data-reveal]', {
    start: 'top 88%',
    once: true,
    onEnter: (els) => gsap.fromTo(els,
      { y: 40, opacity: 0 },
      { y: 0, opacity: 1, duration: 0.9, ease: 'power3.out', stagger: 0.08, overwrite: 'auto' }),
  });

  // Section headings: line-mask slide up
  gsap.utils.toArray('[data-heading]').forEach((h) => {
    gsap.from(h.querySelectorAll('.w > span'), {
      yPercent: 110, duration: 1, ease: 'power4.out', stagger: 0.05,
      scrollTrigger: { trigger: h, start: 'top 85%', once: true },
    });
  });

  // ── Counters ──────────────────────────────────────────────────────────────
  gsap.utils.toArray('[data-count]').forEach((el) => {
    const end = parseFloat(el.dataset.count) || 0;
    const obj = { v: 0 };
    gsap.to(obj, {
      v: end, duration: 1.8, ease: 'power2.out',
      scrollTrigger: { trigger: el, start: 'top 90%', once: true },
      onUpdate: () => { el.textContent = Math.round(obj.v); },
    });
  });

  // ── Desktop-only pinned / horizontal sequences ───────────────────────────
  const mm = gsap.matchMedia();

  mm.add('(min-width: 1024px)', () => {
    // Lifecycle: pin, draw the rail, light each stage as the head passes it
    const life  = document.querySelector('[data-life]');
    const rail  = document.querySelector('[data-life-rail]');
    const steps = gsap.utils.toArray('[data-life-step]');
    if (life && rail && steps.length) {
      const tl = gsap.timeline({
        scrollTrigger: {
          trigger: life, start: 'top top', end: '+=' + steps.length * 320, pin: true, scrub: 0.6,
          onUpdate: (st) => {
            const reached = st.progress * steps.length;
            steps.forEach((s, i) => s.classList.toggle('is-on', reached > i + 0.25));
          },
        },
      });
      tl.fromTo(rail, { scaleX: 0 }, { scaleX: 1, ease: 'none', duration: steps.length });
      steps.forEach((s, i) => {
        tl.fromTo(s, { opacity: 0.25, y: 30 }, { opacity: 1, y: 0, duration: 0.6, ease: 'power2.out' }, i);
      });
    }

    // Live work: vertical scroll drives a horizontal track; images parallax inside
    const work  = document.querySelector('[data-work]');
    const track = document.querySelector('[data-work-track]');
    if (work && track && track.children.length > 2) {
      const dist = () => Math.max(0, track.scrollWidth - work.clientWidth + 80);
      const tween = gsap.to(track, {
        x: () => -dist(), ease: 'none',
        scrollTrigger: { trigger: work, start: 'top top', end: () => '+=' + dist(), pin: true, scrub: 0.8, invalidateOnRefresh: true },
      });
      gsap.utils.toArray('[data-work-img]').forEach((img) => {
        gsap.fromTo(img, { xPercent: -8 }, {
          xPercent: 8, ease: 'none',
          scrollTrigger: { trigger: img.closest('[data-work-card]'), containerAnimation: tween, start: 'left right', end: 'right left', scrub: true },
        });
      });
      const bar = document.querySelector('[data-work-progress]');
      if (bar) gsap.fromTo(bar, { scaleX: 0 }, { scaleX: 1, ease: 'none', scrollTrigger: { trigger: work, start: 'top top', end: () => '+=' + dist(), scrub: true } });
    }
  });

  // ── Final CTA: headline fills with colour as it crosses the viewport ─────
  const fill = document.querySelector('[data-fill]');
  if (fill) {
    gsap.fromTo(fill, { backgroundSize: '0% 100%' }, {
      backgroundSize: '100% 100%', ease: 'none',
      scrollTrigger: { trigger: fill, start: 'top 85%', end: 'top 35%', scrub: true },
    });
  }

  // ── Pointer effects (fine pointers only) ─────────────────────────────────
  if (finePointer) {
    // Magnetic buttons
    gsap.utils.toArray('[data-magnetic]').forEach((el) => {
      const xTo = gsap.quickTo(el, 'x', { duration: 0.5, ease: 'power3' });
      const yTo = gsap.quickTo(el, 'y', { duration: 0.5, ease: 'power3' });
      el.addEventListener('pointermove', (e) => {
        const r = el.getBoundingClientRect();
        xTo((e.clientX - r.left - r.width / 2) * 0.3);
        yTo((e.clientY - r.top - r.height / 2) * 0.35);
      });
      el.addEventListener('pointerleave', () => { xTo(0); yTo(0); });
    });

    // 3D tilt + cursor-following glow on cards
    gsap.utils.toArray('[data-tilt]').forEach((card) => {
      const rx = gsap.quickTo(card, 'rotationX', { duration: 0.6, ease: 'power3' });
      const ry = gsap.quickTo(card, 'rotationY', { duration: 0.6, ease: 'power3' });
      gsap.set(card, { transformPerspective: 900 });
      card.addEventListener('pointermove', (e) => {
        const r = card.getBoundingClientRect();
        const px = (e.clientX - r.left) / r.width;
        const py = (e.clientY - r.top) / r.height;
        card.style.setProperty('--mx', (px * 100).toFixed(1) + '%');
        card.style.setProperty('--my', (py * 100).toFixed(1) + '%');
        ry((px - 0.5) * 10);
        rx((0.5 - py) * 10);
      });
      card.addEventListener('pointerleave', () => { rx(0); ry(0); });
    });

    // Soft cursor spotlight that follows the pointer across the page
    const spot = document.querySelector('[data-spot]');
    if (spot) {
      const sx = gsap.quickTo(spot, 'x', { duration: 0.8, ease: 'power3' });
      const sy = gsap.quickTo(spot, 'y', { duration: 0.8, ease: 'power3' });
      window.addEventListener('pointermove', (e) => { sx(e.clientX); sy(e.clientY); }, { passive: true });
    }
  }

  // Images loading late change layout — keep pin distances correct.
  window.addEventListener('load', () => ScrollTrigger.refresh());
}

function initTestimonials() {
  const box = document.querySelector('[data-quotes]');
  if (!box) return;
  const slides = Array.from(box.querySelectorAll('[data-quote]'));
  const dots   = Array.from(box.querySelectorAll('[data-quote-dot]'));
  if (slides.length < 2) return;

  let i = 0;
  let timer = 0;

  function show(n) {
    i = (n + slides.length) % slides.length;
    slides.forEach((s, k) => {
      const on = k === i;
      s.classList.toggle('is-on', on);
      s.setAttribute('aria-hidden', on ? 'false' : 'true');
    });
    dots.forEach((d, k) => d.setAttribute('aria-current', k === i ? 'true' : 'false'));
  }
  function play() { if (!reduced) { clearInterval(timer); timer = setInterval(() => show(i + 1), 6500); } }

  dots.forEach((d, k) => d.addEventListener('click', () => { show(k); play(); }));
  box.addEventListener('pointerenter', () => clearInterval(timer));
  box.addEventListener('pointerleave', play);
  show(0);
  play();
}
