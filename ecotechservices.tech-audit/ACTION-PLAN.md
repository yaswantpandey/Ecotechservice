# Prioritized SEO Action Plan: Ecotech Services

This action plan categorizes every audit recommendation by urgency and business impact. Follow this implementation sequence to maximize organic rankings and AI search visibility.

---

## Phase 1: Immediate & Critical Fixes (Week 1)

### 1. Verify Production SSL / TLS Configuration
- **Severity:** Critical
- **Impact:** Eliminates security warnings and prevents search engine indexing drops.
- **Action:**
  1. Log into your hosting control panel (Hostinger / cPanel) or Cloudflare dashboard.
  2. If using Cloudflare, set the SSL/TLS encryption mode to **Full (Strict)**.
  3. Ensure the SSL certificate is auto-renewed and the certificate chain includes the intermediate CA certificates.

### 2. Deploy IndexNow Key File to Live Root
- **Severity:** High
- **Impact:** Enables instant automated indexing across Bing, Yandex, Naver, and Seznam.
- **Action:**
  - Push the newly created `public/82568927e2e0467eac3f26e8e621ea0a.txt` to the `main` branch so GitHub Actions deploys it via FTP to `https://ecotechservices.tech/82568927e2e0467eac3f26e8e621ea0a.txt`.
  - Once deployed, test retrieval in your browser to confirm HTTP 200 with text content `82568927e2e0467eac3f26e8e621ea0a`.

### 3. Guard SitemapController Disk Caching
- **Severity:** High
- **Impact:** Prevents committing or caching `http://localhost/...` inside `public/sitemap.xml` and `public/robots.txt`.
- **Action:**
  - In `app/controllers/SitemapController.php`, wrap `@file_put_contents` with `if (APP_ENV === 'production')`.

### 4. Trim Homepage Meta Description
- **Severity:** Low
- **Impact:** Prevents SERP truncation and improves click-through rate (CTR).
- **Target:** 150-160 characters.
- **Recommended Text:**
  > *"Ecotech Service builds high-performance web platforms, secure mobile apps, and enterprise cloud solutions. Certified engineering based in Lucknow, India."*

---

## Phase 2: AI Search Readiness & Generative Optimization (Weeks 2-3)

### 1. Publish `/public/llms.txt` for AI Answer Engines
- **Severity:** Medium
- **Impact:** Positions Ecotech Services for inclusion and citations in ChatGPT Search, Perplexity, Claude, and Google AI Overviews.
- **Action:** Create `public/llms.txt` following the standard llms.txt format with an executive summary, services list, and technology stack.

### 2. Update `robots.txt` with AI Bot Directives
- **Severity:** Low
- **Impact:** Eliminates ambiguity for AI crawlers while maintaining protection for private paths.
- **Add to `public/robots.txt`:**
  ```txt
  User-agent: GPTBot
  Allow: /

  User-agent: PerplexityBot
  Allow: /

  User-agent: ClaudeBot
  Allow: /

  User-agent: Applebot-Extended
  Allow: /
  ```

### 3. Enforce HSTS (Strict-Transport-Security)
- **Severity:** Medium
- **Impact:** Tells browsers to only connect over HTTPS.
- **Add to `public/.htaccess`:**
  ```apache
  Header always set Strict-Transport-Security "max-age=31536000; includeSubDomains; preload"
  ```

---

## Phase 3: Programmatic SEO & Traffic Acceleration (Month 2)

### 1. Run Database Migration for Programmatic SEO Pages
- **Severity:** High
- **Impact:** Unlocks 300+ geo-targeted long-tail search landing pages (targeting US, UK, Canada, UAE, Singapore, Australia, India, and European tech hubs).
- **Action:** Execute `global_seo_pages.sql` on the production database.

### 2. Batch Submit New Pages via IndexNow
- **Severity:** Medium
- **Impact:** Gets newly migrated programmatic pages crawled within hours instead of weeks.
- **Action:**
  Call `submitIndexNow()` in PHP or run `indexnow_submit.py` with the list of generated URLs.

---

## Checklist Summary

- [x] Integrate Bing & IndexNow API key (`82568927e2e0467eac3f26e8e621ea0a`)
- [x] Create `public/82568927e2e0467eac3f26e8e621ea0a.txt`
- [x] Implement `submitIndexNow()` helper in PHP
- [ ] Verify production SSL certificate on `ecotechservices.tech`
- [ ] Create `public/llms.txt` for GEO / AI search
- [ ] Update `robots.txt` to welcome AI search bots
- [ ] Apply `APP_ENV === 'production'` guard in `SitemapController`
- [ ] Import `global_seo_pages.sql` to live database
