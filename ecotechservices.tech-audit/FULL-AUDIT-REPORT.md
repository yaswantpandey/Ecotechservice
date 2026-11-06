# Full SEO Audit — ecotechservices.tech
**Audit date:** 2026-11-01 (re-audit; previous 2026-10-26 scored 91)
**Method:** Full crawl of all 473 sitemap URLs + UA-specific crawler-access probes + per-page on-page parsing
**Business type:** B2B Technology Services & Software Consultancy with a 460-page programmatic service×city grid

---

## Executive Summary

### SEO Health Score: **68 / 100 (C+)**

| Category | Weight | Score | Weighted |
|---|---|---|---|
| Technical SEO | 22% | 55 | 12.2 |
| Content Quality & E-E-A-T | 23% | 78 | 17.9 |
| On-Page SEO | 20% | 62 | 12.4 |
| Schema & Structured Data | 10% | 95 | 9.5 |
| Performance (CWV) | 10% | 78 | 7.8 |
| AI Search Readiness | 10% | 35 | 3.5 |
| Images | 5% | 95 | 4.8 |
| **Total** | 100% | | **68** |

**Why the score fell from 91 to 68:** the previous audit flagged an SSL/probe anomaly as a "verify on production" item; this re-audit completed the production probes and confirmed it as an active **JS anti-bot challenge wall on InfinityFree free hosting** that blocks every crawler except Googlebot and Bingbot. The 2026-10-26 quick wins were, however, largely executed — HSTS is live, llms.txt is published, robots.txt welcomes AI crawlers, the IndexNow key deploys, and the homepage meta description is trimmed. The new 473-page programmatic grid adds a fresh wave of measurable, mechanical title/description overlength issues.

### Top 5 critical issues
1. **JS challenge wall (Critical):** cookie-less sessions get an 847-byte JS interstitial or dropped connection. Only Googlebot/Bingbot are whitelisted; GPTBot/DuckDuckBot/Applebot get the stub, YandexBot gets **HTTP 403**. Root cause: hosting layer, not site code or certs.
2. **AI engines can't cite the site (Critical):** robots.txt explicitly allows GPTBot/PerplexityBot/ClaudeBot/Applebot-Extended and /llms.txt exists — but the challenge blocks those bots on 100% of paths including static files.
3. **379/473 titles > 60 chars (High):** template `Best [Service] Company in [City] | Ecotech Services` truncates in SERPs on most city names.
4. **216/473 descriptions > 160 chars (High):** closing sales phrase severed on 211 of 420 non-web-dev city pages.
5. **/blog indexed but empty (High):** renders "No posts yet"; zero posts in sitemap.

### Top 5 quick wins
1. One-line title template change → `[Service] in [City] | Ecotech Services` (fixes 379 titles at once)
2. Trim description template to ≤155 chars (fixes 216)
3. Publish a 3-5 post starter batch — or noindex /blog until populated
4. Add 301 redirects for `http://` and `www.` variants (5 minutes of .htaccess)
5. After hosting migration: resubmit sitemap + all URLs via IndexNow, re-probe AI-bot UAs

---

## 1. Technical SEO (55/100)

### Crawl availability (the dominant issue)
The live host is InfinityFree free shared hosting (`Server: openresty`, IP 185.27.134.149). Observed with real UAs:

| UA | Result |
|---|---|
| Googlebot | ✅ full content, 3/3 |
| bingbot | ✅ full content |
| GPTBot | ❌ JS challenge, 3/3 |
| DuckDuckBot | ❌ JS challenge |
| Applebot | ❌ JS challenge |
| YandexBot | ❌ HTTP 403 |
| Chrome, no cookies | ❌ 5/5 dropped TLS connections (curl 56, missing close_notify) — then interstitial with `?i=1` |

The prior audit's "SSL handshake abrupt termination" is now root-caused to this hosting layer. The certificate chain itself is valid (Let's Encrypt, openssl-verified), the site's own server responses are fast (avg 1.55s, p95 2.32s once through), and the application code produces crawler-clean output once fetched.

### Fixed since last audit
- ✅ HSTS `max-age=31536000; includeSubDomains; preload` — live
- ✅ llms.txt — live (2.8KB, high quality)
- ✅ robots.txt AI-crawler allow blocks — live (rules accurate; ineffective until the challenge wall is gone)
- ✅ IndexNow key file — live, content matches
- ✅ Homepage meta description — trimmed and inside the limit

### Still open
- JS challenge wall (Critical — hosting migration)
- No 301s for `http://` and `www.` host variants (Medium)
- No Content-Security-Policy header (Low)
- Single outlier 16.3s crawl response (Info — likely hosting congestion)

---

## 2. Content Quality & E-E-A-T (78/100)

**Strengths:** named Technical Director across all surfaces (llms.txt, about, schema), portfolio links to four live client sites, core pages 314–953 words, geo pages ~330 words with structure.

**Open issues:**
1. **/blog empty but indexed** (High) — "No posts yet", 178 words, no post URLs in sitemap. Fix: starter posts or noindex until populated.
2. **Scaled-content risk on the 460-page grid** (Medium) — one interchangeable copy template across 23 service types × 36 cities ("We provide X for businesses in Y — fast, scalable and secure solutions…"). This matches what Google's scaled-content-abuse policy targets. Fix: per-city intros, 3-4 unique FAQs, one local proof point, prioritizing primary-service × largest-city pages.
3. **/internships live but not sitemapped** (Low) — it's header/footer-linked and in llms.txt.

---

## 3. On-Page SEO (62/100)

**Site-wide fundamentals are clean:** 0 duplicate titles, 0 duplicate descriptions, 1 H1/page on 473/473, self-canonical on 473/473, 34/34 images with alt, no noindex, no canonical mismatches, accurate 404 handling.

The entire downside is the programmatic template:
- Titles >60: 358/420 other-service pages, 20/20 mobile pages (only web-dev pages were trimmed: 1/20)
- Descriptions >160: 211/420 other-service pages, 4/20 mobile, 1 core
- Project descriptions very short (~67 chars) — the inverse problem, little keyword surface

Both fixes are single-line changes in the shared service-page controller — no per-page editing needed.

---

## 4. Schema & Structured Data (95/100)

Valid JSON-LD on every page: Organization + ProfessionalService + WebSite + ItemList + BreadcrumbList on 473/473, Service on the 460 service pages, zero parse errors. Outstanding items are both Low:
- AggregateRating/Review still absent (needs verified client reviews) — highest-value missing rich result for 460 service pages
- FAQPage markup to be added when per-city FAQs ship

---

## 5. Performance (78/100 — crawl-estimate only)

No CrUX/GSC/Lighthouse data available in this environment (no Google API credentials configured); figures are directional from the full crawl. Avg 1.55s / p95 2.32s response totals, gzip active, lean server-rendered HTML, one CDN dependency. The measurable penalty is the first-hit challenge interstitial + `?i=1` redirect for new visitors. After hosting migration, pull CrUX CWV from GSC for the 7 core pages.

---

## 6. AI Search Readiness (35/100 — down from 76)

All infrastructural wins are live — llms.txt (excellent: identity, 6 anchored services, 4 portfolio links, stack, internships), robots.txt explicitly allowing the 4 major AI crawlers, IndexNow key. But AI crawlers receive the challenge on every tested path, so **citing engines cannot read any of it**. This is why the score dropped despite the previous audit's fixes shipping: the fixes are correct but dead-lettered by the host layer. One migration restores the entire category.

---

## 7. Images (95/100)

34 images, 0 missing alt. Only items: a third-party thumbnail dependency (image.thum.io) and the absence of images on geo templates (fine today; ship with local alt text when local proof content is added).

---

## Deployment context notes
- CI/CD via GitHub Actions FTP-Deploy to `ecotechservices.tech/htdocs/` (InfinityFree); PHPMailer vendor built in CI; SMTP targets `smtp.hostinger.com` — the infrastructure preference for a paid-host migration already exists
- Sitemap lastmods: grid pages 2026-10-25 (grid deployment date), core pages 2026-11-01 — deploys are current
- Local audit tooling: `audit_scripts/` (crawl, analyze, stats, sample) and `live_pages/` (raw corpus) are working data generated by this audit

---

## Scoring rationale
- Technical SEO 55: everything on-page/headers/sitemap is right; the score collapses on crawl availability for non-Google/Bing crawlers, which is a hosting-layer property
- Content 78: strong core E-E-A-T minus empty blog and genuine scaled-content risk on 95%+ of the corpus
- On-Page 62: clean fundamentals, 80% title truncation on the programmatic grid
- Schema 95, Images 95: essentially done
- Performance 78: unmeasured field data; lab signals good modulo challenge
- AI Readiness 35: infrastructure all correct, zero effective reach

**Total: 68 / 100 (C+).** The path back to 90+ is short because almost every issue is a template change or a hosting move: hosting migration (+~15-20 across two categories), title/description template fix (+~6), blog decision (+~2), redirects/CSP (+~2) → ~92-94 potential.
