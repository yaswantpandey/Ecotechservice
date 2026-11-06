# Crawl Report — ecotechservices.tech (2026-11-01)

## Method
- Source: live `/sitemap.xml` (98.2KB, 473 URLs, each with lastmod)
- Transport: curl, desktop Chrome UA + full crawl with sitemap values iterated at concurrency 5, per-request gzip
- First access without cookies → rendered+computed the JS challenge (`aes.js` slowAES `__test`) exactly as a browser does to obtain the session cookie, then crawled with the cookie set. This simulates an executing browser and is required to see the site at all.
- Per-page parsing: title/meta/canonical/h1/h2/robots-meta/hreflang/JSON-LD/img-alt/word-count
- UA-specific probes: Googlebot, bingbot, GPTBot, DuckDuckBot, YandexBot, Applebot, Chrome-no-cookie

## Coverage
- 473/473 URLs fetched → **473 × HTTP 200, 0 failures**
- Corpus: 7 core, 6 project, 460 programmatic service×city (23 service types × 20-36 city grid)
- robots.txt: fetched live; single sitemap declared; AI UAs explicitly allowed (rules verified accurate but application-layer challenge still blocks those UAs — see technical.md)
- Raw data: `live_pages/analysis.jsonl`, `live_pages/cat_stats.json`, `live_pages/crawl_log.txt` (agent working data, not part of the report corpus)

## Limitations
- No CrUX/GSC/Lighthouse field or lab data (no credentials configured) — performance scores are crawl-derived estimates
- Googlebot/Bingbot checks are UA-level; real render-tree checks require GSC URL Inspection, recommended post-migration
- The `?i=1` cookie flow proves human reachability, not crawler reachability
