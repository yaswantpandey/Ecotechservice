# Prioritized Action Plan — ecotechservices.tech
**Generated:** 2026-11-01 · from FULL-AUDIT-REPORT.md (Health Score 68/100)

Legend: **Critical** = blocks indexing/citations now · **High** = fix ≤1 week · **Medium** = ≤1 month · **Low** = backlog

---

## Phase 1 — Crawl Availability & Truncation Fixes (Week 1)

| # | Priority | Action | Effort | Owner note |
|---|---|---|---|---|
| 1 | **Critical** | Migrate hosting off InfinityFree (free hosting enforce a JS cookie challenge). The deploy pipeline + SMTP already target Hostinger — a base paid plan completes the stack. Verify: GSC URL Inspection on `/`; re-probe GPTBot/DuckDuckBot/Applebot/YandexBot on `/` and `/llms.txt` | ~half day incl. verification | codebase unchanged; DNS + FTP redeploy |
| 2 | **Critical** | Post-migration: confirm AI crawlers receive 200 + real content for `/`, `/llms.txt`, `/sitemap.xml`; then resubmit sitemap and run `submitIndexNow()` for all 473 URLs | 1 hour | the existing PHP helper already does this |
| 3 | High | Title template: `Best [Service] Company in [City] \| Ecotech Services` → `[Service] in [City] \| Ecotech Services`. Fixes 379 of 473 titles >60 chars | ~1 hour | one shared per-service controller; spot check 3 city pages after deploy |
| 4 | High | Description template: cut second sentence, ≤155 chars. Fixes 216 overlength descriptions | ~1 hour | same controller |
| 5 | High | Decide /blog: publish 3-5 starter posts (topics can be lifted from existing geo-page research) **or** drop `/blog` from sitemap + noindex until populated | 1-3 days | one editorial decision |

## Phase 2 — Programmatic Grid Quality & Indexing Hygiene (Weeks 2-3)

| # | Priority | Action | Effort | Owner note |
|---|---|---|---|---|
| 6 | Medium | De-templatize the 460 service×city pages, starting with primary-service × largest-city (36-60 pages): unique intro (local project/market fact), 3-4 unique FAQs + FAQPage JSON-LD, one local proof point. Then roll the pattern outward | ~1 hr/page first batch | strongest lever against scaled-content risk |
| 7 | Medium | Add 301 redirects: `http://` → `https://` and `www.` → apex. Currently both serve 200 with only canonical tags masking the duplicates | 30 min | root `.htaccess` |
| 8 | Low | Add `Content-Security-Policy` header aligned to the existing cdnjs.cloudflare.com dependency | 30 min | expect 1-2 iterations with browser console |
| 9 | Low | Output project pages longer descriptions (currently avg 67 chars) for portfolio keyword surface | 1-2 hrs | 6 pages, hand-written |

## Phase 3 — Authority & Rich Results (Month 2)

| # | Priority | Action | Effort |
|---|---|---|---|
| 10 | Medium | Collect 5-6 verified client reviews; add `aggregateRating` + `review` to the ProfessionalService node → review-stars eligibility on 460 service pages | 1 hr + chasing reviews |
| 11 | Medium | Add `/internships` to the sitemap (live, header/footer-linked, present in llms.txt, but unlisted) | 15 min |
| 12 | Low | Replace image.thum.io thumbnail calls with locally cached WebP/AVIF | 2-3 hrs |
| 13 | Low | Pull CrUX CWV from GSC for the 7 core pages after migration; log first baselines for LCP/INP/CLS | 1 hr (needs GSC access) |

## Phase 4 — Monitoring (Ongoing)

- Monthly: rerun this audit's crawl + UA probes (scripts: `audit_scripts/crawl.php` + UA-probe loop) — watch for regressions in crawler access
- Monthly: AI citation spot checks — ChatGPT/Perplexity "best [service] in [city]" for the priority-city pages
- GSC coverage watch on the service×city grid — permanently unindexable combos should be pruned from the sitemap, not left to soft-fail
- Sitemap lastmod hygiene on every deploy (already correct today)

---

## Projected impact
| State | Score driver |
|---|---|
| Current | **68** |
| After Phase 1 only | ~84-86 (crawl availability + template fixes + blog) |
| After Phase 2 | ~90-92 (de-templatized grid + redirects) |
| After Phase 3 | ~93-95 (rich results + field-verified CWV) |

**Single highest-leverage action: #1 (hosting migration).** It unblocks Phase items 2, 13, and the entire AI Search Readiness category at once, with zero codebase work.
