# AI Search Readiness & Generative Engine Optimization (GEO) — ecotechservices.tech
**Audit Date:** 2026-11-14 (Re-audit)  
**Category Score:** **28 / 100** (Weight: 10%)

---

## 1. Executive Summary

While `robots.txt` explicitly welcomes AI crawlers and a well-structured `llms.txt` exists in the local source tree, **zero AI search engines can currently access, crawl, or cite the live website**.

Empirical testing reveals that InfinityFree's OpenResty web application firewall forcibly rejects OpenAI `GPTBot`, Anthropic `ClaudeBot`, and `PerplexityBot` with **HTTP 403 Forbidden**, while serving an 847-byte JavaScript stub to `Applebot-Extended`. Furthermore, requests to `https://ecotechservices.tech/llms.txt` return **HTTP 404 Not Found** due to an unrouted front controller rewrite rule.

---

## 2. Empirical Bot Probe Verification (Live Origin)

| AI Bot / Engine | Declared Policy in `robots.txt` | Live Origin Probe (2026-11-14) | Resulting Crawler Experience | Citability Impact |
| :--- | :---: | :---: | :---: | :---: |
| **GPTBot 1.2 (OpenAI / ChatGPT Search)** | `Allow: /` | **HTTP 403 Forbidden** | TCP connection rejected / denied | 🔴 Cannot index or cite |
| **ClaudeBot 1.0 (Anthropic / Claude)** | `Allow: /` | **HTTP 403 Forbidden** | TCP connection rejected / denied | 🔴 Cannot index or cite |
| **PerplexityBot 1.0 (Perplexity AI)** | `Allow: /` | **HTTP 403 Forbidden** | TCP connection rejected / denied | 🔴 Cannot index or cite |
| **Applebot-Extended (Apple Intelligence)** | `Allow: /` | **HTTP 200 (847 bytes)** | Trapped in `aes.js` challenge stub | 🔴 Cannot evaluate JS |
| **DuckDuckBot 1.1** | `Allow: /` | **HTTP 200 (847 bytes)** | Trapped in `aes.js` challenge stub | 🔴 Cannot evaluate JS |

---

## 3. `/llms.txt` Deployment Defect

### The Issue:
Testing `https://ecotechservices.tech/llms.txt` returns:
```http
HTTP/1.1 404 Not Found
Server: openresty
Content-Type: text/html; charset=UTF-8
```
A complete 404 HTML template is returned instead of the machine-readable Markdown file.

### Root Cause:
In `public/.htaccess`:
```apache
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteCond %{REQUEST_URI} !\.(css|js|jpe?g|png|gif|svg|woff2?|ttf|eot|ico|webp)$ [NC]
RewriteRule ^(.*)$ index.php [QSA,L]
```
The file extension `.txt` is not excluded in the rewrite regex. On shared hosting environments where `!-f` fails to resolve due to virtual host aliasing, the request is routed to `index.php`. Since `public/index.php` contains no route matching `llms.txt`, the application triggers a 404 error response.

### Fix:
1. Update `public/.htaccess`:
   ```apache
   RewriteCond %{REQUEST_URI} !\.(css|js|jpe?g|png|gif|svg|woff2?|ttf|eot|ico|webp|txt)$ [NC]
   ```
2. Or register an explicit route in `public/index.php`:
   ```php
   'llms.txt' => function() {
       header('Content-Type: text/plain; charset=UTF-8');
       readfile(ROOT_PATH . '/public/llms.txt');
       exit;
   },
   ```

---

## 4. Agentic Browsing & Machine Citability Deficiencies

1. **Missing Discovery Endpoints:**
   - `/.well-known/ai-catalog.json`: Not implemented.
   - `/.well-known/agent-card.json`: Not implemented.
2. **Missing Markdown Negotiation:**
   - Server does not negotiate `Accept: text/markdown` or supply an `index.md` sibling.
3. **TLS Verification Failure for Agents:**
   - Automated agent runtimes (Python, LangChain, AutoGen, CrewAI) fail TLS verification when fetching `https://ecotechservices.tech` due to the missing Let's Encrypt `YR2` intermediate certificate.

---

## 5. Strategic Remediation Roadmap
1. **Immediate:** Migrate to clean hosting (e.g. Hostinger, Hetzner) or place Cloudflare in front with WAF rules configured to allow verified AI bots.
2. **Immediate:** Implement the `.htaccess` / `index.php` route fix to serve `public/llms.txt`.
3. **Post-Migration:** Resubmit `llms.txt` and `sitemap.xml` via IndexNow and monitor bot crawler access in server logs.
