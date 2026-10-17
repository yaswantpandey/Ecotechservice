/* ==========================================================================
   Home hero — line-drawn globe, ink on paper (Three.js).
   Meridians and parallels in graphite, a handful of route arcs in the deep
   signal green, drawn once on load and then rotating slowly. No glow,
   particles, blending tricks or gradients. Pauses off-screen / hidden tab;
   renders one still frame under reduced motion.
   ========================================================================== */
import * as THREE from 'https://cdn.jsdelivr.net/npm/three@0.160.0/build/three.module.js';

const canvas = document.querySelector('[data-hero-canvas]');
const host   = canvas ? canvas.parentElement : null;

function webglOk() {
  try {
    const c = document.createElement('canvas');
    return !!(window.WebGLRenderingContext && (c.getContext('webgl2') || c.getContext('webgl')));
  } catch (e) { return false; }
}

if (canvas && host && webglOk()) init();

function init() {
  const reduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  const INK    = new THREE.Color('#191A17');
  const SIGNAL = new THREE.Color('#2C5F42');

  const renderer = new THREE.WebGLRenderer({ canvas, antialias: true, alpha: true });
  renderer.setPixelRatio(Math.min(window.devicePixelRatio || 1, 2));
  renderer.setClearColor(0x000000, 0);

  const scene  = new THREE.Scene();
  const camera = new THREE.PerspectiveCamera(32, 1, 0.1, 100);
  camera.position.set(0, 0, 9);

  const globe = new THREE.Group();
  globe.rotation.z = THREE.MathUtils.degToRad(-12);   // axial tilt
  scene.add(globe);

  const R = 2.4;

  // Back-facing lines are drawn fainter so the sphere reads without shading.
  function lineMat(color, opacity) {
    return new THREE.ShaderMaterial({
      transparent: true,
      depthWrite: false,
      uniforms: { uCol: { value: color }, uA: { value: opacity }, uDraw: { value: reduced ? 1 : 0 } },
      vertexShader: /* glsl */`
        attribute float aT;
        varying float vFace;
        varying float vT;
        void main() {
          vec3 n = normalize(normalMatrix * position);
          vFace = n.z;
          vT = aT;
          gl_Position = projectionMatrix * modelViewMatrix * vec4(position, 1.0);
        }`,
      fragmentShader: /* glsl */`
        uniform vec3 uCol;
        uniform float uA;
        uniform float uDraw;
        varying float vFace;
        varying float vT;
        void main() {
          if (vT > uDraw) discard;
          float a = vFace > 0.0 ? uA : uA * 0.28;
          gl_FragColor = vec4(uCol, a);
        }`,
    });
  }

  function addLine(points, mat) {
    const g = new THREE.BufferGeometry().setFromPoints(points);
    const t = new Float32Array(points.length);
    for (let i = 0; i < points.length; i++) t[i] = i / (points.length - 1);
    g.setAttribute('aT', new THREE.BufferAttribute(t, 1));
    const line = new THREE.Line(g, mat);
    globe.add(line);
    return line;
  }

  const gridMat = lineMat(INK, 0.42);
  const SEG = 128;

  // Parallels
  for (let lat = -75; lat <= 75; lat += 15) {
    const phi = THREE.MathUtils.degToRad(lat);
    const r = Math.cos(phi) * R;
    const y = Math.sin(phi) * R;
    const pts = [];
    for (let i = 0; i <= SEG; i++) {
      const a = (i / SEG) * Math.PI * 2;
      pts.push(new THREE.Vector3(Math.cos(a) * r, y, Math.sin(a) * r));
    }
    addLine(pts, gridMat);
  }
  // Meridians
  for (let lon = 0; lon < 180; lon += 15) {
    const th = THREE.MathUtils.degToRad(lon);
    const pts = [];
    for (let i = 0; i <= SEG; i++) {
      const a = (i / SEG) * Math.PI * 2;
      pts.push(new THREE.Vector3(Math.cos(a) * Math.cos(th) * R, Math.sin(a) * R, Math.cos(a) * Math.sin(th) * R));
    }
    addLine(pts, gridMat);
  }
  // Outline ring facing the camera (drawn in camera space, never rotates)
  {
    const pts = [];
    for (let i = 0; i <= SEG; i++) {
      const a = (i / SEG) * Math.PI * 2;
      pts.push(new THREE.Vector3(Math.cos(a) * R * 1.001, Math.sin(a) * R * 1.001, 0));
    }
    const g = new THREE.BufferGeometry().setFromPoints(pts);
    scene.add(new THREE.Line(g, new THREE.LineBasicMaterial({ color: INK, transparent: true, opacity: 0.7 })));
  }

  // Route arcs: Lucknow outward to a few fixed points (deterministic, not random noise)
  function fromLatLon(lat, lon, r = R) {
    const phi = THREE.MathUtils.degToRad(lat);
    const th  = THREE.MathUtils.degToRad(lon);
    return new THREE.Vector3(Math.cos(phi) * Math.cos(th) * r, Math.sin(phi) * r, -Math.cos(phi) * Math.sin(th) * r);
  }
  const home = fromLatLon(26.85, 80.95);
  const routes = [[51.5, -0.1], [40.7, -74.0], [25.2, 55.3], [1.35, 103.8], [-33.9, 151.2], [52.5, 13.4]];
  const arcMats = [];
  routes.forEach(([la, lo]) => {
    const b = fromLatLon(la, lo);
    const mid = home.clone().add(b).multiplyScalar(0.5);
    const lift = R + home.distanceTo(b) * 0.32;
    mid.normalize().multiplyScalar(lift);
    const curve = new THREE.QuadraticBezierCurve3(home, mid, b);
    const m = lineMat(SIGNAL, 0.95);
    arcMats.push(m);
    addLine(curve.getPoints(96), m);

    const tick = new THREE.Mesh(new THREE.CircleGeometry(0.035, 12), new THREE.MeshBasicMaterial({ color: SIGNAL }));
    tick.position.copy(b);
    tick.lookAt(b.clone().multiplyScalar(2));
    globe.add(tick);
  });
  const homeMark = new THREE.Mesh(new THREE.CircleGeometry(0.06, 16), new THREE.MeshBasicMaterial({ color: SIGNAL }));
  homeMark.position.copy(home);
  homeMark.lookAt(home.clone().multiplyScalar(2));
  globe.add(homeMark);

  // Start with Lucknow facing the viewer.
  globe.rotation.y = -THREE.MathUtils.degToRad(80.95) + Math.PI / 2 - 0.5;

  function resize() {
    const w = host.clientWidth;
    const h = host.clientHeight;
    if (!w || !h) return;
    renderer.setSize(w, h, false);
    camera.aspect = w / h;
    camera.updateProjectionMatrix();
    const fit = Math.min(1, (w / h) / 0.9);
    camera.position.z = 9 / Math.max(0.55, fit);
  }
  resize();
  window.addEventListener('resize', resize);

  if (reduced) { renderer.render(scene, camera); host.classList.add('is-3d'); return; }

  // Pointer: a small tilt toward the cursor, eased.
  const target = { x: 0, y: 0 };
  const cur = { x: 0, y: 0 };
  window.addEventListener('pointermove', (e) => {
    target.x = (e.clientX / window.innerWidth - 0.5);
    target.y = (e.clientY / window.innerHeight - 0.5);
  }, { passive: true });

  const clock = new THREE.Clock();
  const baseY = globe.rotation.y;
  let raf = 0;
  let visible = true;

  function frame() {
    const t = clock.getElapsedTime();
    // Draw-on over ~2.2s: grid first, routes after.
    gridMat.uniforms.uDraw.value = Math.min(1, t / 1.6);
    arcMats.forEach((m, i) => { m.uniforms.uDraw.value = THREE.MathUtils.clamp((t - 1.2 - i * 0.12) / 0.9, 0, 1); });

    cur.x += (target.x - cur.x) * 0.04;
    cur.y += (target.y - cur.y) * 0.04;
    globe.rotation.y = baseY + t * 0.05 + cur.x * 0.25;
    globe.rotation.x = cur.y * 0.15;

    renderer.render(scene, camera);
    raf = visible ? requestAnimationFrame(frame) : 0;
  }
  function start() { if (!raf) raf = requestAnimationFrame(frame); }
  function stop()  { if (raf) cancelAnimationFrame(raf); raf = 0; }

  start();
  new IntersectionObserver(([e]) => { visible = e.isIntersecting && !document.hidden; visible ? start() : stop(); }).observe(host);
  document.addEventListener('visibilitychange', () => { visible = !document.hidden; visible ? start() : stop(); });

  host.classList.add('is-3d');
}
