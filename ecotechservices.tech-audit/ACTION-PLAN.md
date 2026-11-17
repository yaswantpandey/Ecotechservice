# Prioritized SEO Action Plan — ecotechservices.tech
**Generated:** 2026-11-14 · Derived from `FULL-AUDIT-REPORT.md` (Health Score: **65 / 100**)  
**Priority Hierarchy:** **Critical (P0)** = Fix immediately (blocks indexing/crawling) · **High (P1)** = Fix ≤1 week · **Medium (P2)** = Fix ≤1 month · **Low (P3)** = Backlog optimization

---

## Phase 1 — Critical Infrastructure, Bot Accessibility & Handshake Fixes (Immediate / Days 1–3)

| # | Priority | Category | Action Item | Effort | Implementation Details |
|---|---|---|---|---|---|
| **1** | **Critical (P0)** | Technical SEO / GEO | **Hosting Migration & Challenge Wall Removal** | ~3–4 hours | InfinityFree shared hosting blocks AI bots with **HTTP 403** (`GPTBot`, `ClaudeBot`, `PerplexityBot`) and traps standard clients in an 847-byte AES JS challenge. Migrate to standard shared hosting or VPS (Hostinger, Hetzner, etc.) where WAF policies allow verified crawlers. |
| **2** | **Critical (P0)** | Technical SEO | **Supply Intermediate CA in TLS Handshake** | 30 mins | Server only serves leaf cert `CN=ecotechservices.tech` and omits the Let's Encrypt `YR2` intermediate certificate. Deploy `fullchain.pem` to eliminate `SSLCertVerificationError` for all non-browser fetchers, API clients, and curl. |
| **3** | **Critical (P0)** | AI Search / Technical | **Fix `/llms.txt` Delivery (Currently 404 on Live)** | 15 mins | Exclude `.txt` files from router rewrite rules in `public/.htaccess` or define an explicit route in `public/index.php` serving `public/llms.txt` with `Content-Type: text/plain`. |
| **4** | **High (P1)** | Technical SEO | **Enforce Canonical 301 Redirects (HTTPS & Non-WWW)** | 15 mins | Add rewrite rules to `public/.htaccess` redirecting `http://` and `www.` traffic to `https://ecotechservices.tech` with permanent HTTP 301. Currently all 4 permutations serve 200 OK. |

---

## Phase 2 — Snippet Optimization & Programmatic Quality (Week 1 / Days 4–7)

| # | Priority | Category | Action Item | Effort | Implementation Details |
|---|---|---|---|---|---|
| **5** | **High (P1)** | On-Page SEO | **Shorten Programmatic Page Titles** | 1 hour | Replace `Best [Service] Company in [City] \| Ecotech Services` with `[Service] in [City] \| Ecotech` in `database/ecotech.sql`. Caps maximum length at 60 characters across all 460 pages, completely eliminating SERP snippet truncation. |
| **6** | **High (P1)** | On-Page SEO | **Trim Programmatic Meta Descriptions** | 1 hour | Condense descriptions to ≤155 characters: `Need [Service] in [City]? Ecotech Services builds fast, secure software with fixed pricing and ongoing support. Get a free quote.` (Resolves 215 overlong descriptions). |
| **7** | **High (P1)** | Content Quality | **Remediate Empty `/blog` Section** | 1–2 days | Either publish 3 foundational technical articles (e.g. Web Security, Cloud Architecture, Modern Web Performance) or add `<meta name="robots" content="noindex, follow">` to `/blog` to prevent hollow crawl budget consumption. |
| **8** | **High (P1)** | Technical / Links | **Deploy Missing Event Page on Production** | 15 mins | Deploy newly committed `events/hack2skill-x-sudarshan` files to production to resolve the HTTP 404 currently triggered by the site footer and sitemap link. |

---

## Phase 3 — Rich Results, Schema & Local Signals (Weeks 2–3)

| # | Priority | Category | Action Item | Effort | Implementation Details |
|---|---|---|---|---|---|
| **9** | **Medium (P2)** | Schema Markup | **Add FAQPage & Service JSON-LD on City Pages** | 2 hours | Inject structured `FAQPage` and `Service` JSON-LD schemas into `app/views/seo_landing.php` matching existing rendered accordion questions to unlock rich Google SERP snippet expansions. |
| **10** | **Medium (P2)** | Schema Markup | **Add BreadcrumbList JSON-LD Across Site** | 1 hour | Integrate `BreadcrumbList` schema in `app/views/layouts/main.php` to establish navigation hierarchy in search result listings. |
| **11** | **Medium (P2)** | Content Quality | **De-templatize High-Priority Metro Pages** | 1 day | Add unique localized project examples, regional client feedback, and specific local tech ecosystem references to top 10 city pages (Lucknow, Bangalore, Delhi, Mumbai, Hyderabad, New York, London, etc.). |

---

## Phase 4 — Verification, IndexNow & Field Telemetry (Month 2 / Ongoing)

| # | Priority | Category | Action Item | Effort | Implementation Details |
|---|---|---|---|---|---|
| **12** | **Medium (P2)** | Crawling / Indexing | **Trigger Full IndexNow Batch Submission** | 30 mins | Submit all 467 canonical URLs to Bing and Yandex using the verified `82568927e2e0467eac3f26e8e621ea0a.txt` API key once hosting is stabilized. |
| **13** | **Low (P3)** | Telemetry | **Connect GSC & CrUX Field Data APIs** | 1 hour | Configure `google-api.json` credentials in `claude-seo` plugin to track real 28-day user Core Web Vitals (LCP, INP, CLS) and organic search impression trends. |
| **14** | **Low (P3)** | Security | **Configure Content-Security-Policy (CSP) Header** | 1 hour | Define strict script/style source whitelist in `public/.htaccess` covering inline styles and external Google Fonts. |

---

## Projected SEO Health Score Impact

| Milestones | Projected Score | Key Score Drivers Unlocked |
| :--- | :---: | :--- |
| **Current Baseline** | **65 / 100** | Grade C — AI bots blocked (403), missing intermediate TLS cert, overlong titles, empty blog |
| **After Phase 1 (Infrastructure & TLS)** | **82 / 100** | Grade B — AI bots allowed (200), TLS chain complete, /llms.txt live, 301 redirects active |
| **After Phase 2 (Titles, Descs, Blog)** | **89 / 100** | Grade B+ — 100% clean title/desc snippets, no thin indexable blog |
| **After Phase 3 (Schema & De-templatization)** | **94 / 100** | Grade A — Rich snippets eligible (FAQPage + Service), enhanced local E-E-A-T |
| **After Phase 4 (Field CWV & IndexNow)** | **96+ / 100** | Grade A+ — Real field CrUX validation, instantaneous search engine synchronization |
