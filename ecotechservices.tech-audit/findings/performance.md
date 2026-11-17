# Performance & Core Web Vitals Findings — ecotechservices.tech
**Audit Date:** 2026-11-14 (Re-audit)  
**Category Score:** **76 / 100** (Weight: 10%)

---

## 1. Laboratory & Crawl Timing Analysis

| Timing Metric | Measured Value | Standard Target | Assessment |
| :--- | :---: | :---: | :---: |
| **Average Server Response (TTFB)** | **1.62s** | < 0.8s | 🟡 Elevated (Shared Host) |
| **95th Percentile Response** | **2.45s** | < 1.5s | 🟡 High Variance |
| **HTML Wire Transfer Size** | **~7 KB** | < 50 KB | 🟢 Highly Optimized |
| **Uncompressed HTML Size** | **37 KB** | < 100 KB | 🟢 Lean DOM |
| **Cumulative Layout Shift (CLS)** | **0.00** | < 0.1 | 🟢 Zero Layout Shift |

---

## 2. Front-End Architectural Strengths
- **No Heavy Client Frameworks:** Built with clean native PHP server-rendering and lightweight vanilla JavaScript. No multi-megabyte hydration overhead (e.g. Next.js, Angular, React).
- **CSS Efficiency:** A single lightweight `site.css` (~18KB raw, ~4.2KB wire) covers all layout and component styles.
- **Font Optimization:** Preconnected to Google Fonts origins (`fonts.googleapis.com`, `fonts.gstatic.com`) with `font-display: swap` to prevent Flash of Invisible Text (FOIT).
- **Zero Third-Party Ad or Tracking Bloat:** Omits intrusive tracking tags, heatmaps, or third-party ad networks that destroy Interaction to Next Paint (INP).

---

## 3. Bottlenecks & Infrastructure Limitations

1. **First-Hit JS Challenge Latency Penalty (LCP):**
   First-time visitors must execute `aes.js` and reload with `?i=1` to acquire the `__test` cookie. This double-round-trip injects an artificial 1.5s–3.0s delay directly into Largest Contentful Paint (LCP) for new visitors.
2. **Shared Hosting Resource Limits:**
   Because InfinityFree is a free shared hosting platform, OpenResty CPU and concurrency limits cause sporadic TLS socket termination under concurrent requests.
3. **Absence of Real Field Data (CrUX):**
   Google CrUX field data requires sufficient organic traffic volume. Once traffic grows post-migration, Google Search Console will report real-user 28-day field LCP, INP, and CLS.
