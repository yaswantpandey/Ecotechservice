# On-Page SEO Findings — ecotechservices.tech (2026-11-01 re-audit)

## Score: 62/100 (weight 20%)

## >200-item crawl stats (473/473 pages parsed)
| Metric | Result |
|---|---|
| Titles present | 473/473 |
| Duplicate titles | 0 |
| Titles > 60 chars | **379/473 (80%)** |
| Descriptions present | 473/473 |
| Duplicate descriptions | 0 |
| Descriptions > 160 chars | **216/473 (46%)** |
| Canonical self-referencing & matching | 473/473 |
| H1 exactly one | 473/473 |
| hreflang | 0 (acceptable: single-country targeting) |
| Images / missing alt | 34 / 0 |

## Title overage breakdown
- 358/420 "other service × city" pages (avg 67.7 chars) — e.g. "Best Mobile App Development Company in Bangalore | Ecotech Services" (67)
- 20/20 mobile-app pages (avg 65 chars)
- 3/7 core pages
- Web-development pages are already trimmed (1/20 over)

## Description overage breakdown
- 211/420 other-service pages (avg 161.6 chars)
- 4/20 mobile pages, 1 core page
- Project pages are fine (avg 67 chars)

## Findings
1. **HIGH — title template overshoot.** The pattern `Best [Service] Company in [City] | Ecotech Services` breaches 60 chars for most city names, so Google truncates the brand tail and may rewrite. *Fix: one-line template change in the shared per-service controller → `[Service] in [City] | Ecotech Services` (Bangalore example: 67 → 48 chars).*
2. **HIGH — description template overshoot.** Closing sales clause almost always severed. *Fix: cut the second sentence, keep `[Service] for [City] businesses` + one differentiator, ≤155 chars.*
3. **LOW — project descriptions very short (avg 67).** Not truncation — the opposite: little keyword surface for portfolio pages that could rank for product-type queries.
