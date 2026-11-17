# Technical SEO Findings — ecotechservices.tech
**Audit Date:** 2026-11-14 (Re-audit)  
**Category Score:** **52 / 100** (Weight: 22%)

---

## 1. Verified Infrastructure Status

| Technical Item | Status | Detailed Finding |
| :--- | :---: | :--- |
| **TLS Certificate Chain** | 🔴 **CRITICAL DEFECT** | Leaf certificate `CN=ecotechservices.tech` is valid, but the server handshake omits the Let's Encrypt `YR2` intermediate certificate. Automated API clients, python `requests`, curl, and AI fetchers fail with `SSLCertVerificationError: unable to get local issuer certificate`. |
| **Anti-Bot WAF & Challenge** | 🔴 **CRITICAL DEFECT** | Host is InfinityFree (`Server: openresty`, IP: `185.27.134.149`). Non-whitelisted bots receive **HTTP 403 Forbidden** or an 847-byte AES JS challenge (`aes.js` / `__test` cookie). |
| **HTTP Security Headers** | 🟢 **EXCELLENT** | `Strict-Transport-Security: max-age=31536000; includeSubDomains; preload`, `X-Frame-Options: SAMEORIGIN`, `X-Content-Type-Options: nosniff`, `Referrer-Policy: strict-origin-when-cross-origin`, `Permissions-Policy: camera=(), microphone=(), geolocation=()`, `Cross-Origin-Opener-Policy: same-origin`. |
| **Wire Compression** | 🟢 **ACTIVE** | Gzip and Brotli compression active (`Transfer-Encoding: chunked`, `Vary: Accept-Encoding`). Compresses 37KB HTML to ~7KB wire size. |
| **IndexNow Protocol** | 🟢 **VERIFIED** | Verification key file `82568927e2e0467eac3f26e8e621ea0a.txt` returns HTTP 200 with the exact key matching `.env`. |
| **Canonical Redirects** | 🟡 **DEFECT** | `http://` and `www.` versions return HTTP 200 OK without issuing 301 permanent redirects to `https://ecotechservices.tech`. |
| **`/llms.txt` Discovery** | 🔴 **DEFECT** | `https://ecotechservices.tech/llms.txt` returns **HTTP 404 Not Found** on production. |

---

## 2. Empirical Crawler Access Matrix (Live Probes, 2026-11-14)

```
Test Command: python urllib / curl probe across standard crawler user agents
Target: https://ecotechservices.tech/
```

| User Agent | Status Code | Wire Bytes | Challenge Wall Detected | Verdict |
| :--- | :---: | :---: | :---: | :--- |
| **Googlebot/2.1** | `HTTP 200` | 37,022 | No (Whitelisted) | 🟢 Full access |
| **bingbot/2.0** | `HTTP 200` | 37,022 | No (Whitelisted) | 🟢 Full access |
| **GPTBot/1.2 (OpenAI)** | `HTTP 403` | 0 | Hard WAF Forbidden | 🔴 Blocked by WAF |
| **ClaudeBot/1.0 (Anthropic)** | `HTTP 403` | 0 | Hard WAF Forbidden | 🔴 Blocked by WAF |
| **PerplexityBot/1.0** | `HTTP 403` | 0 | Hard WAF Forbidden | 🔴 Blocked by WAF |
| **Applebot-Extended** | `HTTP 200` | 847 | AES JS Challenge (`aes.js`) | 🔴 Trapped in challenge |
| **DuckDuckBot/1.1** | `HTTP 200` | 847 | AES JS Challenge (`aes.js`) | 🔴 Trapped in challenge |
| **YandexBot/3.0** | `HTTP 403` | 0 | Hard WAF Forbidden | 🔴 Blocked by WAF |

---

## 3. Protocol & Subdomain Canonicalization Matrix

| Request URL | Observed HTTP Status | Expected Status | Redirect Location |
| :--- | :---: | :---: | :--- |
| `http://ecotechservices.tech` | `HTTP 200 OK` | `HTTP 301 Moved Permanently` | `https://ecotechservices.tech/` |
| `https://www.ecotechservices.tech` | `HTTP 200 OK` | `HTTP 301 Moved Permanently` | `https://ecotechservices.tech/` |
| `http://www.ecotechservices.tech` | `HTTP 200 OK` | `HTTP 301 Moved Permanently` | `https://ecotechservices.tech/` |
| `https://ecotechservices.tech` | `HTTP 200 OK` | `HTTP 200 OK` | Canonical destination |

**Impact:** Although canonical tags point to `https://ecotechservices.tech`, search engines that crawl HTTP or www discover complete duplicate 200 OK pages, which dilutes crawl budget and fractures external backlink equity.

---

## 4. Remediation Steps

1. **Server Migration / Reverse Proxy:**
   Migrate to a standard VPS (e.g. Hostinger, Hetzner, DigitalOcean) or place a transparent Cloudflare reverse proxy in front to bypass InfinityFree's OpenResty anti-bot challenge and 403 blocks.
2. **Bundle Intermediate Certificate (`fullchain.pem`):**
   Ensure the server configuration includes both the domain certificate and the Let's Encrypt `YR2` intermediate certificate.
3. **Deploy `.htaccess` Canonical Rewrite Rules:**
   ```apache
   # Canonical HTTPS & Non-WWW Redirect
   RewriteCond %{HTTPS} off [OR]
   RewriteCond %{HTTP_HOST} ^www\. [NC]
   RewriteRule ^(.*)$ https://ecotechservices.tech/$1 [L,R=301]
   ```
4. **Fix `/llms.txt` Route:**
   Exclude `.txt` files from rewrite rules in `public/.htaccess` so `public/llms.txt` is served directly as static plain text.
