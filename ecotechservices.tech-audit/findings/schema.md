# Schema & Structured Data Findings — ecotechservices.tech
**Audit Date:** 2026-11-14 (Re-audit)  
**Category Score:** **92 / 100** (Weight: 10%)

---

## 1. Executive Summary

Structured data is one of the strongest technical assets of the Ecotech Service platform. Every page serves a unified, syntactically clean JSON-LD graph anchored to Schema.org standards.

Zero JSON syntax errors or schema parse warnings were encountered across the site crawl.

---

## 2. Detected Schema Graph Nodes

| Schema `@type` | Application Scope | Key Properties Declared | Status |
| :--- | :--- | :--- | :---: |
| **`Organization`** | Site-wide | `@id`, name, url, logo, image, description, email, telephone, sameAs | 🟢 Complete |
| **`ProfessionalService`** | Site-wide | address (`PostalAddress`), geo (`GeoCoordinates`), priceRange, openingHours | 🟢 Complete |
| **`WebSite`** | Site-wide | url, name, potentialAction (`SearchAction` query-input) | 🟢 Complete |
| **`BreadcrumbList`** | All pages | `itemListElement` with ordered position, name, and item URLs | 🟢 Complete |
| **`AggregateRating`** | Organization | `ratingValue`, `reviewCount`, `bestRating`, `worstRating` | 🟢 Complete |
| **`Service`** | 460 Programmatic Pages | `serviceType`, provider (`@id`), areaServed (`AdministrativeArea`) | 🟢 Complete |
| **`BlogPosting`** | Blog posts (when published) | `headline`, `author`, `publisher`, `datePublished`, `dateModified` | 🟢 Ready |

---

## 3. High-Value Opportunities for Rich Results

### 1. `FAQPage` JSON-LD Schema (Opportunity)
- **Current State:** Programmatic landing pages display accordion FAQ sections directly in the HTML view (`app/views/seo_landing.php`), answering common client questions about delivery time, pricing, and technology stack.
- **Opportunity:** These FAQs are currently not tagged with `FAQPage` / `Question` / `Answer` structured data.
- **Search Advantage:** Adding `FAQPage` schema allows Google to render expandable accordion dropdowns directly beneath the search result snippet in SERPs, significantly increasing click-through rates (CTR).

### 2. `AggregateRating` Review Expansion
- **Current State:** `AggregateRating` exists on the main organization node.
- **Opportunity:** Add individual `Review` objects within the graph citing verifiable client testimonials to unlock author and review snippet rich features.
