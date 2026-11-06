# Technical SEO Findings — ecotechservices.tech (2026-11-01 re-audit)

## Score: 55/100 (weight 22%)

## Verification of previous audit (2026-10-26)
| Prior finding | Status |
|---|---|
| SSL/TLS handshake abrupt termination | **Root cause identified, persists** — Let's Encrypt chain is valid (openssl s_client verified); the drops come from the anti-bot layer of InfinityFree free hosting, not the certificate |
| Missing HSTS | **Fixed live** — `Strict-Transport-Security: max-age=31536000; includeSubDomains; preload` present |
| SitemapController disk-cache guard | Local codebase concern; live output clean (473 URLs, valid host + lastmod) |
| IndexNow key file | **Deployed** — /82568927e2e0467eac3f26e8e621ea0a.txt returns the correct key |

## Crawler access matrix (live probes, 2026-11-01)
| User-Agent | Result on / | Result on /llms.txt | Verdict |
|---|---|---|---|
| Googlebot/2.1 | 200, 40,503 bytes ×3/3 | sitemap 200 full | OK |
| bingbot/2.0 | 200, 40,503 bytes | — | OK |
| GPTBot/1.1 | 200, 847-byte JS challenge ×3/3 | challenge ×1 | Blocked |
| DuckDuckBot | 200, 847-byte JS challenge | — | Blocked |
| Applebot | 200, 847-byte JS challenge | — | Blocked |
| YandexBot | **403** (150 bytes) | — | Hard-blocked |
| Chrome desktop (no cookies) | 5/5 initial requests: TLS connect OK, 0 bytes, connection dropped (curl 56 missing close_notify) | — | Intermittent drop |
| Chrome desktop + `?i=1` + cookie | 200 challenge stub → then full content with `__test` cookie | — | Human OK after JS |

## What works
- All 473 sitemap URLs: HTTP 200 (full crawl, 0 failures after challenge pass-through)
- Security headers complete except CSP (HSTS preload, XFO, XCTO, Referrer-Policy, Permissions-Policy)
- Gzip active; real 404s; no noindex anywhere; self-canonical on 100% of pages
- Server fast once through: avg 1.55s, p95 2.32s

## What's broken
1. **CRITICAL — JS challenge wall.** Live host is InfinityFree (Server: openresty, IP 185.27.134.149). Cookie-less sessions receive an 847-891-byte `aes.js __test` challenge or a dropped connection. Humans get through after JS+cookie; crawlers (other than Googlebot/Bingbot which are whitelisted) never do.
2. **MEDIUM — no 301s** for `http://` and `www.` host variants (both serve 200 directly; canonical tags are the only dedupe).
3. **LOW — no Content-Security-Policy header.**

## Priority recommendations
1. Migrate to paid hosting (Hostinger base plan fits the existing stack — SMTP already targets `smtp.hostinger.com`). This single change resolves findings 1, the AI-crawler block, and the first-hit latency penalty.
2. After migration: GSC URL Inspection on `/`, re-probe all six crawler UAs, add http/www 301 redirects.
