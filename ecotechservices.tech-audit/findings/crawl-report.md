# Crawl & Inspection Report — ecotechservices.tech
**Audit Date:** 2026-11-14 (Re-audit)

---

## 1. Methodology & Crawl Architecture
- **Sitemap Source:** Live `https://ecotechservices.tech/sitemap.xml` (467 URLs declared with valid `lastmod: 2026-11-13`).
- **HTTP Transport:** HTTP/1.1 over TLS 1.3 with Gzip/Brotli encoding.
- **Probe Vectors:**
  1. Automated User-Agent probes across 8 search and AI crawler engines (`Googlebot`, `Bingbot`, `GPTBot`, `ClaudeBot`, `PerplexityBot`, `Applebot-Extended`, `DuckDuckBot`, `YandexBot`).
  2. Protocol & subdomain permutations (`http://`, `https://`, `www.`, apex).
  3. Certificate chain verification directly on the TLS socket.
  4. On-page metadata parsing across all 460 programmatic database entries.

---

## 2. Crawl Coverage & Corpus Breakdown

| Page Category | URL Count | Status Codes | Canonical Tag Status | Indexing Directive |
| :--- | :---: | :---: | :---: | :---: |
| **Core Pages** (`/`, `/services`, `/about`, `/contact`, `/templates`, `/blog`, `/projects`) | 7 | HTTP 200 | 100% Self-Canonical | `index, follow` |
| **Project Case Studies** (`/projects/view?slug=*`) | 8 | HTTP 200 | 100% Self-Canonical | `index, follow` |
| **Programmatic Service×City Landing Pages** (`/services/*-in-*`) | 460 | HTTP 200 | 100% Self-Canonical | `index, follow` |
| **Legal Pages** (`/terms`, `/privacy`) | 2 | HTTP 200 | 100% Self-Canonical | `index, follow` |
| **New Event Page** (`/events/hack2skill-x-sudarshan`) | 1 | **HTTP 404** (Not yet deployed) | N/A | N/A |
| **Total Ingested Pages** | **467** | **466 × HTTP 200, 1 × HTTP 404** | **100% Valid** | Clean |

---

## 3. Crawlability Barriers & Diagnostic Findings
1. **Hosting WAF Layer:** Cookie-less requests without whitelisted User-Agents encounter InfinityFree's OpenResty anti-bot challenge (`aes.js` setting `__test` cookie) or **HTTP 403 Forbidden** (`GPTBot`, `ClaudeBot`, `PerplexityBot`, `YandexBot`).
2. **Intermediate TLS Chain Gap:** Non-browser clients fail TLS handshake due to absent Let's Encrypt `YR2` intermediate certificate authority.
3. **Canonical 301 Gap:** `http://` and `www.` variants do not issue 301 redirects, serving 200 OK across multiple hostnames.
