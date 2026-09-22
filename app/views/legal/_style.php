<?php
/* Shared presentation layer for the legal documents. Same editorial system as
   the home page: warm paper, graphite ink, hairlines, no rounded corners. */
?>
<style>
.doc {
  --paper: #EDEAE2; --paper-2: #E5E1D7; --ink: #191A17; --ink-2: #43453E;
  --ink-3: #6E7066; --rule: #C7C2B4; --rule-2: #DAD6CA; --signal: #2C5F42;
  background: var(--paper); color: var(--ink);
  font-family: 'IBM Plex Sans', system-ui, sans-serif; font-size: 16px; line-height: 1.65;
  -webkit-font-smoothing: antialiased;
}
.doc *, .doc *::before, .doc *::after { border-radius: 0; box-shadow: none; }
.doc ::selection { background: var(--signal); color: var(--paper); }
.doc-shell { max-width: 1180px; margin: 0 auto; padding: 0 1.25rem; }
@media (min-width: 1024px) { .doc-shell { padding: 0 2.5rem; } }
.doc-display { font-family: 'Instrument Serif', Georgia, serif; font-weight: 400; line-height: 1.05; letter-spacing: -0.015em; }
.doc-spec {
  font-family: 'IBM Plex Mono', ui-monospace, monospace; font-size: .6875rem;
  letter-spacing: .1em; text-transform: uppercase; color: var(--ink-3);
}
.doc-band { border-top: 1px solid var(--rule); }

/* Sticky section index — real navigation state, highlights the section in view */
.doc-index { position: sticky; top: 118px; }
.doc-index ol { list-style: none; margin: 0; padding: 0; counter-reset: idx; }
.doc-index li { counter-increment: idx; border-top: 1px solid var(--rule-2); }
.doc-index li:first-child { border-top: 0; }
.doc-index a {
  display: flex; gap: .6rem; padding: .5rem 0; font-size: .8125rem;
  color: var(--ink-3); text-decoration: none; transition: color .15s linear;
}
.doc-index a::before {
  content: counter(idx, decimal-leading-zero);
  font-family: 'IBM Plex Mono', monospace; font-size: .6875rem; color: var(--rule); padding-top: .18rem;
}
.doc-index a:hover { color: var(--ink); }
.doc-index a.is-current { color: var(--signal); }
.doc-index a.is-current::before { color: var(--signal); }

/* Body copy */
.doc-body { max-width: 72ch; }
.doc-body section { padding: 2.25rem 0; border-top: 1px solid var(--rule-2); scroll-margin-top: 130px; }
.doc-body section:first-of-type { border-top: 0; }
.doc-body h2 { font-family: 'Instrument Serif', Georgia, serif; font-size: 1.75rem; line-height: 1.15; margin-bottom: .9rem; }
.doc-body h3 { font-size: .9375rem; font-weight: 600; margin: 1.5rem 0 .5rem; }
.doc-body p { color: var(--ink-2); margin-bottom: .9rem; }
.doc-body p:last-child { margin-bottom: 0; }
.doc-body a { color: var(--ink); border-bottom: 1px solid var(--rule); text-decoration: none; }
.doc-body a:hover { color: var(--signal); border-color: var(--signal); }
.doc-body ul { list-style: none; margin: 0 0 .9rem; padding: 0; }
.doc-body ul li { position: relative; padding: .35rem 0 .35rem 1.15rem; color: var(--ink-2); font-size: .9375rem; border-top: 1px dotted var(--rule); }
.doc-body ul li:first-child { border-top: 0; }
.doc-body ul li::before { content: '—'; position: absolute; left: 0; color: var(--ink-3); }
.doc-table { width: 100%; border-collapse: collapse; font-size: .875rem; margin-bottom: .9rem; }
.doc-table th, .doc-table td { text-align: left; vertical-align: top; padding: .65rem .8rem .65rem 0; border-top: 1px solid var(--rule-2); color: var(--ink-2); }
.doc-table thead th {
  font-family: 'IBM Plex Mono', monospace; font-weight: 400; font-size: .6875rem;
  letter-spacing: .08em; text-transform: uppercase; color: var(--ink-3); border-top: 0;
}
.doc-table tbody th { font-weight: 600; color: var(--ink); width: 34%; }
.doc-callout { border: 1px solid var(--rule); background: var(--paper-2); padding: 1.1rem 1.25rem; margin: 1.2rem 0; }
.doc-callout p { margin-bottom: 0; font-size: .9375rem; }
.doc-cta {
  display: inline-flex; align-items: baseline; gap: .6rem; background: var(--signal);
  color: #F3F1EA; padding: .8rem 1.3rem; font-weight: 500; font-size: .9375rem;
  border: 1px solid var(--signal); text-decoration: none; transition: background .18s linear;
}
.doc-cta:hover { background: var(--ink); border-color: var(--ink); }
</style>
