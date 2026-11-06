# AI Search Readiness & Agentic SEO (GEO) — ecotechservices.tech (2026-11-01 re-audit)

## Score: 35/100 (weight 10%) — down from 76 in the previous audit

## Why the score collapsed
The previous audit (2026-10-26) scored this category on llms.txt missing (now fixed) and robots.txt rules (now added). Both fixes are live and high quality. What changed is that this re-audit **probed with real AI-crawler user agents** and found the hosting block makes every welcome sign unusable in practice:

| Bot | robots.txt says | Live probe result |
|---|---|---|
| GPTBot | Allow | JS challenge on 100% of tested paths incl. /llms.txt, /sitemap.xml, static text |
| PerplexityBot (implied same app-layer) | Allow | challenge behavior via same challenge layer |
| DuckDuckBot | (generic allow) | JS challenge |
| Applebot / Applebot-Extended | explicit Allow | JS challenge |
| YandexBot | (generic allow) | **HTTP 403** |

## What works
- /llms.txt published and excellent: company identity + 6 functions + 4 verified portfolio links + stack + internships, 2.8KB (~900 tokens)
- robots.txt explicitly allows the four major AI crawlers
- IndexNow key file live; content is server-rendered (no JS needed to read)
- llms.txt and robots.txt exist verbatim on the live origin

## Findings
1. **CRITICAL — allow rules are dead letters.** Citing AI engines (ChatGPT Search, Perplexity, Claude, Apple Intelligence) request pages as first-time cookie-less clients; they do not execute the challenge JS, so they never receive content — and never cite the site. This is an application-layer block (InfinityFree), not a configuration error on the robots/llms side. *Fix: hosting migration. Then re-probe `/` and `/llms.txt` with GPTBot/PerplexityBot/ClaudeBot UAs and confirm 200 + real content on both.*
2. **INFO — after migration, llms.txt should be resubmitted alongside the sitemap via IndexNow** so AI indexers pick it up fresh; the 473-URL grid is already worth an IndexNow resubmit once the block lifts.
