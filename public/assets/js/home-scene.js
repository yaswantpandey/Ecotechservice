/* ==========================================================================
   Home hero — "network globe" rendered with Three.js.
   A Fibonacci dot-sphere, a faint wire core, data arcs with travelling
   pulses, and a starfield. Tilts with the pointer, drifts with scroll,
   pauses when off-screen or the tab is hidden.
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
  const mobile  = window.matchMedia('(max-width: 767px)').matches;

  const GREEN  = new THREE.Color('#22c55e');
  const BRIGHT = new THREE.Color('#4ade80');
  const TEAL   = new THREE.Color('#2dd4bf');

  const renderer = new THREE.WebGLRenderer({ canvas, antialias: !mobile, alpha: true, powerPreference: 'high-performance' });
  renderer.setPixelRatio(Math.min(window.devicePixelRatio || 1, 1.5));
  renderer.setClearColor(0x000000, 0);

  const scene  = new THREE.Scene();
  const camera = new THREE.PerspectiveCamera(42, 1, 0.1, 100);
  camera.position.set(0, 0, 7.2);

  const globe = new THREE.Group();
  scene.add(globe);

  const R = 2.2;

  // ── Dot sphere (shader: twinkle + soft round points) ──────────────────
  const N = mobile ? 1400 : 3200;
  const pos = new Float32Array(N * 3);
  const seed = new Float32Array(N);
  const golden = Math.PI * (3 - Math.sqrt(5));
  for (let i = 0; i < N; i++) {
    const y = 1 - (i / (N - 1)) * 2;
    const r = Math.sqrt(1 - y * y);
    const t = golden * i;
    pos[i * 3]     = Math.cos(t) * r * R;
    pos[i * 3 + 1] = y * R;
    pos[i * 3 + 2] = Math.sin(t) * r * R;
    seed[i] = Math.random();
  }
  const dotGeo = new THREE.BufferGeometry();
  dotGeo.setAttribute('position', new THREE.BufferAttribute(pos, 3));
  dotGeo.setAttribute('aSeed', new THREE.BufferAttribute(seed, 1));

  const dotMat = new THREE.ShaderMaterial({
    transparent: true,
    depthWrite: false,
    blending: THREE.AdditiveBlending,
    uniforms: {
      uTime:  { value: 0 },
      uSize:  { value: (mobile ? 9 : 11) * renderer.getPixelRatio() },
      uColA:  { value: GREEN },
      uColB:  { value: TEAL },
    },
    vertexShader: /* glsl */`
      attribute float aSeed;
      uniform float uTime;
      uniform float uSize;
      varying float vAlpha;
      varying float vMix;
      void main() {
        vec4 mv = modelViewMatrix * vec4(position, 1.0);
        // Fade the back hemisphere so the sphere reads as solid.
        vec3 n = normalize(normalMatrix * position);
        float facing = smoothstep(-0.35, 0.6, n.z);
        float tw = 0.55 + 0.45 * sin(uTime * 1.6 + aSeed * 40.0);
        vAlpha = facing * tw;
        vMix = aSeed;
        gl_PointSize = uSize * (0.45 + 0.55 * tw) / -mv.z;
        gl_Position = projectionMatrix * mv;
      }`,
    fragmentShader: /* glsl */`
      uniform vec3 uColA;
      uniform vec3 uColB;
      varying float vAlpha;
      varying float vMix;
      void main() {
        float d = length(gl_PointCoord - 0.5);
        float a = smoothstep(0.5, 0.0, d);
        gl_FragColor = vec4(mix(uColA, uColB, vMix * 0.6), a * vAlpha);
      }`,
  });
  globe.add(new THREE.Points(dotGeo, dotMat));

  // ── Wire core + atmosphere rim ─────────────────────────────────────────
  const core = new THREE.LineSegments(
    new THREE.WireframeGeometry(new THREE.IcosahedronGeometry(R * 0.62, 1)),
    new THREE.LineBasicMaterial({ color: GREEN, transparent: true, opacity: 0.12 })
  );
  globe.add(core);

  const rim = new THREE.Mesh(
    new THREE.SphereGeometry(R * 1.04, 48, 48),
    new THREE.ShaderMaterial({
      transparent: true,
      depthWrite: false,
      side: THREE.BackSide,
      blending: THREE.AdditiveBlending,
      uniforms: { uCol: { value: GREEN } },
      vertexShader: /* glsl */`
        varying vec3 vN;
        void main() {
          vN = normalize(normalMatrix * normal);
          gl_Position = projectionMatrix * modelViewMatrix * vec4(position, 1.0);
        }`,
      fragmentShader: /* glsl */`
        uniform vec3 uCol;
        varying vec3 vN;
        void main() {
          float i = pow(0.72 - dot(vN, vec3(0.0, 0.0, 1.0)), 3.0);
          gl_FragColor = vec4(uCol, clamp(i, 0.0, 1.0) * 0.55);
        }`,
    })
  );
  scene.add(rim);

  // ── Data arcs with travelling pulses ───────────────────────────────────
  const arcs = [];
  const ARC_COUNT = mobile ? 10 : 18;
  const SEG = 64;

  function randOnSphere() {
    const u = Math.random() * 2 - 1;
    const t = Math.random() * Math.PI * 2;
    const s = Math.sqrt(1 - u * u);
    return new THREE.Vector3(s * Math.cos(t), u, s * Math.sin(t)).multiplyScalar(R);
  }

  const arcMat = new THREE.ShaderMaterial({
    transparent: true,
    depthWrite: false,
    blending: THREE.AdditiveBlending,
    uniforms: { uCol: { value: BRIGHT } },
    vertexShader: /* glsl */`
      attribute float aT;
      uniform float uHead;
      varying float vT;
      void main() {
        vT = aT;
        gl_Position = projectionMatrix * modelViewMatrix * vec4(position, 1.0);
      }`,
    fragmentShader: /* glsl */`
      uniform vec3 uCol;
      uniform float uHead;
      varying float vT;
      void main() {
        float tail = 0.35;
        float d = uHead - vT;
        float a = (d >= 0.0 && d <= tail) ? (1.0 - d / tail) : 0.0;
        gl_FragColor = vec4(uCol, a * 0.95 + 0.06);
      }`,
  });

  for (let i = 0; i < ARC_COUNT; i++) {
    const a = randOnSphere();
    const b = randOnSphere();
    if (a.distanceTo(b) < R * 0.6) { i--; continue; }
    const mid = a.clone().add(b).multiplyScalar(0.5);
    mid.normalize().multiplyScalar(R + a.distanceTo(b) * 0.38);
    const curve = new THREE.QuadraticBezierCurve3(a, mid, b);
    const pts = curve.getPoints(SEG);
    const g = new THREE.BufferGeometry().setFromPoints(pts);
    const tArr = new Float32Array(pts.length);
    for (let k = 0; k < pts.length; k++) tArr[k] = k / (pts.length - 1);
    g.setAttribute('aT', new THREE.BufferAttribute(tArr, 1));

    const m = arcMat.clone();
    m.uniforms.uHead = { value: 0 };
    m.uniforms.uCol  = { value: i % 3 === 0 ? TEAL : BRIGHT };
    const line = new THREE.Line(g, m);
    globe.add(line);

    // End-point "nodes"
    [a, b].forEach((p) => {
      const node = new THREE.Mesh(
        new THREE.SphereGeometry(0.028, 8, 8),
        new THREE.MeshBasicMaterial({ color: BRIGHT, transparent: true, opacity: 0.9 })
      );
      node.position.copy(p);
      globe.add(node);
    });

    arcs.push({ mat: m, speed: 0.18 + Math.random() * 0.22, offset: Math.random() * 1.35 });
  }

  // ── Starfield ──────────────────────────────────────────────────────────
  const S = mobile ? 400 : 900;
  const sp = new Float32Array(S * 3);
  for (let i = 0; i < S; i++) {
    sp[i * 3]     = (Math.random() - 0.5) * 30;
    sp[i * 3 + 1] = (Math.random() - 0.5) * 18;
    sp[i * 3 + 2] = -4 - Math.random() * 16;
  }
  const starGeo = new THREE.BufferGeometry();
  starGeo.setAttribute('position', new THREE.BufferAttribute(sp, 3));
  const stars = new THREE.Points(starGeo, new THREE.PointsMaterial({
    color: 0x9ca3af, size: 0.03, sizeAttenuation: true, transparent: true, opacity: 0.55, depthWrite: false,
  }));
  scene.add(stars);

  globe.rotation.x = 0.35;

  // ── Layout: globe sits right on desktop, centred/back on mobile ────────
  function resize() {
    const w = host.clientWidth;
    const h = host.clientHeight;
    renderer.setSize(w, h, false);
    camera.aspect = w / h;
    camera.updateProjectionMatrix();
    const wide = w >= 1024;
    globe.position.x = wide ? 2.1 : 0;
    globe.position.y = wide ? 0 : -0.6;
    rim.position.copy(globe.position);
    const s = wide ? 1 : 0.82;
    globe.scale.setScalar(s);
    rim.scale.setScalar(s);
  }
  resize();
  window.addEventListener('resize', resize);

  // ── Input ──────────────────────────────────────────────────────────────
  const target = { x: 0, y: 0 };
  const cur    = { x: 0, y: 0 };
  window.addEventListener('pointermove', (e) => {
    target.x = (e.clientX / window.innerWidth  - 0.5) * 2;
    target.y = (e.clientY / window.innerHeight - 0.5) * 2;
  }, { passive: true });

  let scrollP = 0;
  window.addEventListener('scroll', () => {
    scrollP = Math.min(1, window.scrollY / Math.max(1, host.clientHeight));
  }, { passive: true });

  // ── Loop (paused when hidden / off-screen) ─────────────────────────────
  const clock = new THREE.Clock();
  let visible = true;
  let raf = 0;

  function frame() {
    const t = clock.getElapsedTime();
    dotMat.uniforms.uTime.value = t;

    cur.x += (target.x - cur.x) * 0.05;
    cur.y += (target.y - cur.y) * 0.05;

    globe.rotation.y = t * 0.08 + cur.x * 0.35;
    globe.rotation.x = 0.35 + cur.y * 0.18 + scrollP * 0.5;
    core.rotation.y  = -t * 0.15;
    core.rotation.z  =  t * 0.05;

    camera.position.z = 7.2 + scrollP * 2.2;
    stars.rotation.y  = t * 0.004 + cur.x * 0.04;
    stars.position.y  = scrollP * 1.5;

    for (const a of arcs) {
      a.mat.uniforms.uHead.value = ((t * a.speed + a.offset) % 1.35);
    }

    renderer.render(scene, camera);
    raf = visible ? requestAnimationFrame(frame) : 0;
  }

  function start() { if (!raf && !reduced) raf = requestAnimationFrame(frame); }
  function stop()  { if (raf) cancelAnimationFrame(raf); raf = 0; }

  if (reduced) {
    // Still frame — the scene is decoration, not content.
    arcs.forEach((a, i) => { a.mat.uniforms.uHead.value = 0.3 + (i % 5) * 0.2; });
    renderer.render(scene, camera);
  } else {
    start();
    new IntersectionObserver(([e]) => {
      visible = e.isIntersecting && !document.hidden;
      visible ? start() : stop();
    }).observe(host);
    document.addEventListener('visibilitychange', () => {
      visible = !document.hidden;
      visible ? start() : stop();
    });
  }

  host.classList.add('is-3d');
}
