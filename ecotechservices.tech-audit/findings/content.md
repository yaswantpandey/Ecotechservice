# Content Quality Findings — ecotechservices.tech (2026-11-01 re-audit)

## Score: 78/100 (weight 23%)

## What works (E-E-A-T is the site's strength)
- Named Technical Director (Yaswant Kumar) in llms.txt, about page, and schema — consistency across surfaces
- Portfolio projects link out to live client properties (pandeyreality.com, apnacleanig.in, krantifurniture.in, yaswant.co.in) — verifiable experience
- Core page depth: /templates 953 words, /about 562, /contact 477, /services 374, /projects 314
- Programmatic pages average 329-338 words — above thin-content threshold, with structured H1/H2/breadcrumbs
- llms.txt (2.8KB) accurately mirrors on-page services, tech stack, portfolio

## Findings
1. **HIGH — /blog indexed but empty.** Renders "No posts yet" (178 words, 6 H2s). No `/blog/post` URLs exist in the sitemap. An indexed empty section wastes crawl budget and signals neglect. *Fix: publish a 3-5 post starter batch or drop /blog from the sitemap and noindex until populated.*

2. **MEDIUM — scaled-content risk on the 460 service×city pages.** 23 service types × a 20-36 city grid share one near-identical copy template ("We provide [Service] for businesses in [City] — fast, scalable and secure solutions built around how your business actually works."). Word counts cluster tightly at ~330, uniqueness is only the entity swap. Google's scaled content abuse guidance targets exactly this pattern. *Fix: per-city intro paragraph (local project reference or market fact), 3-4 unique FAQs, one local proof point — starting with the 36 pages that share primary services with the largest cities.*

3. **LOW — /internships live but not in sitemap.** It exists, is linked in the header/footer and from llms.txt, yet is absent from the sitemap.

## Verdict
Core-site content quality is genuinely strong for a small consultancy. The risk is concentrated in the programmatic grid (identical copy) and the empty blog, both fixable with bounded template work rather than new writing from scratch.
