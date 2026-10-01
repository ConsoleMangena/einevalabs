# Three-Department Rebrand — Design

Date: 2026-10-01

## Problem

EINEVA Labs is positioned site-wide as "Africa's dedicated cybersecurity research
laboratory". That string appears in the default `<title>`, the default meta
description, the Open Graph fallbacks, the homepage `Organization` JSON-LD, the
footer tagline yield, and six individual pages.

The lab actually does three things — cybersecurity research, software
engineering, and 3D/animation — and only the first is named anywhere. Two
shipped products (BizIntel, SiteSurveyor) are already proof of the software
engineering work; it is simply never labelled as a service.

Leaving this unaddressed means adjacent work is invisible to people who could
buy it, and the site under-claims what already exists.

## Positioning

The three departments are held together by one thread: **complex systems get
investigated, built, and made visible**. That makes 3D a capability rather
than decoration — it is how an attack surface or an architecture gets explained
to a non-specialist.

Head term moves from "cybersecurity laboratory" to "technology research lab", so
the category widens without abandoning the security equity that ranks today.

| Slot | Copy |
| --- | --- |
| Hero H1 | Complex systems. Solved, built, and shown. |
| Positioning line | EINEVA Labs is a technology research lab. We investigate complex systems, build what should exist, and make it all visible. |
| Sub | Cybersecurity, software engineering, and 3D visualisation — under one roof, because the hard problems need all three. |
| Footer tagline | Technology research, engineering and visualisation for Africa |
| Meta description | Cybersecurity research, software engineering and 3D visualisation. An African technology lab building, securing and explaining complex systems. |

## Structure — one shell, three departments

The site keeps a single navigation and a single contact inbox. Departments are
*sections* on the services page, not separate routes. No new top-level pages.

```
/            hero + three department cards + unified positioning line
/services    three department sections, each with services and an accent
/projects    existing cards, department-tagged
/about       reframed around "the hard problems need all three"
/contact     one form, department dropdown
```

Rationale for not splitting into `/cybersecurity`, `/software`, `/3d`: three
routes dilute authority on a site that currently ranks on a single keyword, and
each would be a thin page. Sections on one page give each department real
weight while keeping one canonical `/services` URL.

## Departments

### Cybersecurity

Existing services, moved verbatim. No copy changes — the content is already
accurate, and rewriting it would only lose ranking on existing service terms.

### Software Engineering

| Service | Substance |
| --- | --- |
| Custom Software Development | Web, desktop and mobile applications built against a stated spec, with handover documentation and a maintenance plan |
| API & Backend Systems | REST and event-driven services, data models, integrations and third-party API integration |
| Product & Prototype Development | Turning an idea into a working product — the path our own BizIntel and SiteSurveyor took |
| Maintenance & Support | Dependency upgrades, bug fixing, monitoring and iteration on systems we or others built |

### 3D & Motion

| Service | Substance |
| --- | --- |
| 3D Modelling & Asset Creation | Hard-surface and organic assets, optimised and delivered ready for web or real-time use |
| Technical Animation & Explainers | Motion graphics and 3D sequences that explain a system, a process or a finding |
| Interactive 3D & WebGL | Real-time browser scenes — explorable configurations, architecture walkthroughs, data visualisations |
| Brand & Product Visualisation | Product renders and visual assets for marketing and investor-facing material |

**No gallery ships.** Portfolio work is unconfirmed, so the 3D section is
services-only. Fabricating client names or a reel to fill it would contradict
the "shown" promise in the hero line. The section is written so a gallery can be
appended later without restructuring.

## Accents

Department colour is an accent only — no separate palettes, no theme forks. The
existing red stays the brand colour everywhere chrome appears.

| Department | Accent | Source |
| --- | --- | --- |
| Cybersecurity | `--color-red` | existing brand red |
| Software Engineering | `--color-teal` | existing variable |
| 3D & Motion | `--color-violet` | new variable, added to both themes |

`--color-violet` is new because neither existing teal nor amber reads as 3D.
It is defined in the dark block and overridden in the light block alongside the
other palette overrides.

## Contact form

A nullable `department` column on `contact_submissions`, a validated select on
the public form, and the value surfaced in Filament and in the Web3Forms
notification subject so an enquiry can be routed without opening the site.

Validation is `nullable|string|in:` against the three slugs. Rejecting unknown
values matters because the column feeds a Filament table filter — an
unvalidated free string would let anyone write unbounded text into a column
that gets rendered in the admin table.

## Files

| File | Change |
| --- | --- |
| `resources/views/layouts/app.blade.php` | Default title/description/OG/twitter, footer tagline, footer newsletter line |
| `resources/views/pages/home.blade.php` | New hero, department cards replacing the offensive/defensive four, new JSON-LD description, meta |
| `resources/views/pages/services.blade.php` | Three department sections, department tags |
| `resources/views/pages/about.blade.php` | Hero, mission, vision, stats, journey reframed |
| `resources/views/pages/projects.blade.php` | Department tags on existing cards |
| `resources/views/pages/contact.blade.php` | Department select, copy |
| `public/assets/styles.css` | `--color-violet` (both themes), `.dept-tag` variants |
| `database/migrations/2026_10_01_000000_add_department_to_contact_submissions_table.php` | Nullable column |
| `app/Models/ContactSubmission.php` | `department` fillable |
| `app/Http/Requests/ContactRequest.php` | `department` rule |
| `app/Http/Controllers/ContactController.php` | Persist department |
| `app/Jobs/SendWeb3FormsNotification.php` | Department in subject |
| `app/Filament/Resources/ContactSubmissionResource.php` | Column, filter, infolist entry |

## Tests

`tests/Feature/PublicPagesRenderTest.php` currently asserts the old hero and
the old "Africa's dedicated cybersecurity research laboratory" string. Those
assertions are replaced, not deleted — the test becomes a regression guard for
the new positioning.

Added:

- `/services` renders all three department headings and all three services
- `/` carries the new hero line
- contact submission persists a valid department
- contact submission rejects an unknown department
- contact submission without a department still succeeds (the column is
  nullable and the form must not become harder to use)

## Out of scope

- No new routes or pages
- No gallery, reel, or Spline embed
- No new theme, font, or layout system
- No bundler changes — the project ships pre-built assets by design, so CSS is
  edited directly in `public/assets/styles.css`
- Project cards are tagged by department but are not filtered; that needs a data
  model the `projects` table does not have
