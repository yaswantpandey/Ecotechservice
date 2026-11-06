# Schema & Structured Data — ecotechservices.tech (2026-11-01 re-audit)

## Score: 95/100 (weight 10%)

## Observed across 473 pages (valid JSON-LD, 0 parse errors)
| @type | Pages |
|---|---|
| Organization | 473 |
| ProfessionalService | 473 |
| WebSite | 473 |
| ItemList | 473 |
| BreadcrumbList | 473 |
| Service | 460 |

## What works
- Consistent entity graph with ProfessionalService anchored to real NAP data (Lucknow address, coordinates, founder)
- BreadcrumbList auto-generated from URL segments aligns with the visible breadcrumb on programmatics
- Service nodes only on service pages — correctly omitted on project pages (no over-markup)
- WebSite + potentialAction SearchAction maintained on all pages

## Findings
1. **LOW — AggregateRating/Review absent** (carried over from previous audit). No verified reviews exist yet, so no review-stars rich result on any of the 460 service pages — the highest-value surface for stars. *Fix: gather 5-6 verified reviews, add `aggregateRating` + `review` arrays to the ProfessionalService node.*
2. **LOW — FAQPage absent.** When the per-city FAQs ship (see content.md), pair them with FAQPage JSON-LD for a second rich-result surface.
