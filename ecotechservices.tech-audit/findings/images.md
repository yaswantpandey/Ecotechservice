# Images — ecotechservices.tech (2026-11-01 re-audit)

## Score: 95/100 (weight 5%)

## Stats
- 34 images across crawled pages, **0 missing alt text**
- Portfolio product screenshots carry the main image weight (appropriate purpose)
- One external dependency observed: `image.thum.io` thumbnail-rendering service

## Findings
1. **LOW — third-party thumbnail dependency.** image.thum.io renders visual content at view time; an outage there removes portfolio visuals, irrelevant for SEO ranking but a page-experience/consistency dependency. *Fix: render thumbnails to cached local WebP/AVIF.*
2. **INFO — geo pages are text-only (0 images).** No image-SEO opportunity wasted, but if local proof (photos/testimonials) is added to primary city pages per the content plan, ship them with local alt text (`[service] project deliverable for [city] client`).
