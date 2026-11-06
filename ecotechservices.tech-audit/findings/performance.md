# Performance (Core Web Vitals) — ecotechservices.tech (2026-11-01 re-audit)

## Score: 78/100 (weight 10%) — lab/crawl estimate only

## Constraint
No CrUX/GSC field data or Lighthouse lab available in this audit environment; scores are derived from the full-crawl timings and page-weight observations. Treat as directional.

## Observations (full crawl of 473 URLs)
- Response time total: avg **1.55s**, p95 **2.32s**, worst **16.35s** (single outlier; includes TLS from this client)
- Gzip confirmed: 42,503-byte homepage transfers at ~7KB
- Server-rendered HTML, no client framework hydration, exactly one CDN script dependency (cdnjs.cloudflare.com) per page
- Static assets carry long-cache headers (retained from previous audit)
- Live sitemap lastmod set: ~2026-10-24/25 for grid pages, 2026-11-01 for core pages — deploys are current

## Findings
1. **MEDIUM — first-hit penalty from the hosting challenge.** First-time (non-toasted) visitors hit the JS interstitial plus its `?i=1` redirect before content: an extra hop + an LCP delay that field CWV would capture disproportionately. Login-free humans on flaky connections also see intermittent connection drops (observed 5/5 during one probe window). *Fix: hosting migration; then measure CrUX for the 7 core pages in GSC, then template pages.*
2. **INFO — no field data.** After migration, record CWV from CrUX for /, /services, /about, /contact and one high-priority service×city template.
