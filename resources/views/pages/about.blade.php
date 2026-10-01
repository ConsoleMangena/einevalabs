@extends('layouts.app')

@section('title', 'About - EINEVA Labs | Technology Research Lab')
@section('description', 'EINEVA Labs is a technology research lab in Gweru, Zimbabwe. We investigate complex systems, build what should exist, and make it all visible — across cybersecurity, software engineering, and animation, motion design and frontend development.')
@section('canonical', 'https://eineva.co.zw/about')
@section('og_url', 'https://eineva.co.zw/about')
@section('og_title', 'About - EINEVA Labs | Technology Research Lab')
@section('og_description', 'A technology research lab in Gweru, Zimbabwe. We investigate complex systems, build what should exist, and make it all visible.')

@section('content')
    <!-- Hero with two-column layout -->
    <div class="about-hero">
      <div class="row align-items-center g-5">
        <div class="col-lg-7">
          <div class="hero-badge">About Us</div>
          <h1 class="page-title" style="text-align: left;">About EINEVA Labs</h1>
          <p style="font-size: 1.1rem; color: var(--color-text-dim);">
            We are a technology research lab in Gweru, Zimbabwe. We investigate complex systems, build
            what should exist, and make it all visible. That work covers cybersecurity, software
            engineering, and animation, motion design and frontend development. Startups, businesses, public institutions and
            independent developers draw on every part of it.
          </p>
          <p style="font-size: 1.1rem; color: var(--color-text-dim);">
            These capabilities sit together because the hard problems straddle them. A breach nobody
            understands does not get fixed. A system that is never visualised does not get adopted. An
            explanation not built on a real finding is just decoration. Most engagements need more than
            one of these, which is the entire reason for the structure.
          </p>
          <p style="font-size: 1.1rem; color: var(--color-text-dim);">
            None of it changes how we work. Every engagement is authorised in writing, scoped in advance,
            and bounded by agreed rules. Those are conditions, not optional extras. And every
            offensive technique we use to prove a weakness is the same technique we then use to close it.
          </p>
        </div>
        <div class="col-lg-5 text-center text-lg-end">
          <div class="hero-logo">
            <img src="{{ asset('assets/logo/einevalabs.png') }}" alt="EINEVA Labs" width="150" height="150" loading="eager" style="max-width: 100%; height: auto; filter: drop-shadow(0 0 15px rgba(239, 68, 68, 0.15)); display: inline-block;">
          </div>
        </div>
      </div>
    </div>

    <!-- Stats -->
    <div class="stats-row">
      <div class="row g-3">
        <div class="col-6 col-md-3">
          <div class="stat-card dept-block" data-dept="cyber">
            <div class="stat-number">3</div>
            <div class="stat-label">Practices</div>
          </div>
        </div>
        <div class="col-6 col-md-3">
          <div class="stat-card dept-block" data-dept="software">
            <div class="stat-number">2</div>
            <div class="stat-label">Products Shipped</div>
          </div>
        </div>
        <div class="col-6 col-md-3">
          <div class="stat-card dept-block" data-dept="three_d">
            <div class="stat-number">100%</div>
            <div class="stat-label">Authorised Work</div>
          </div>
        </div>
        <div class="col-6 col-md-3">
          <div class="stat-card">
            <div class="stat-number">ZW</div>
            <div class="stat-label">Based In</div>
          </div>
        </div>
      </div>
    </div>

    <!-- Mission & Vision -->
    <div class="mv-section">
      <div class="row g-4">
        <div class="col-md-6">
          <div class="mv-card">
            <div class="mv-icon" aria-hidden="true"><svg width="28" height="28" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"><path d="M3 3v1.5M3 21v-6m0 0 2.77-.693a9 9 0 0 1 6.208.682l.108.054a9 9 0 0 0 6.086.71l3.114-.732a48.524 48.524 0 0 1-.005-10.499l-3.11.732a9 9 0 0 1-6.085-.711l-.108-.054a9 9 0 0 0-6.208-.682L3 4.5M3 15V4.5"/></svg></div>
            <p class="mv-label">Our Mission</p>
            <p>
              To put high-quality security research, engineering and technical expertise where it matters
              most. Secure, well-built and clearly explained systems should be available to Africa's
              products, infrastructure and institutions, not only to the ones who can afford a
              large vendor.
            </p>
          </div>
        </div>
        <div class="col-md-6">
          <div class="mv-card">
            <div class="mv-icon" aria-hidden="true"><svg width="28" height="28" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"><path d="M9.813 15.904 9 18.75l-.813-2.846a4.5 4.5 0 0 0-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 0 0 3.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 0 0 3.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 0 0-3.09 3.09ZM18.259 8.715 18 9.75l-.259-1.035a3.375 3.375 0 0 0-2.455-2.456L14.25 6l1.036-.259a3.375 3.375 0 0 0 2.455-2.456L18 2.25l.259 1.035a3.375 3.375 0 0 0 2.456 2.456L21.75 6l-1.035.259a3.375 3.375 0 0 0-2.456 2.456ZM16.894 20.567 16.5 21.75l-.394-1.183a2.25 2.25 0 0 0-1.423-1.423L13.5 18.75l1.183-.394a2.25 2.25 0 0 0 1.423-1.423l.394-1.183.394 1.183a2.25 2.25 0 0 0 1.423 1.423l1.183.394-1.183.394a2.25 2.25 0 0 0-1.423 1.423Z"/></svg></div>
            <p class="mv-label">Our Vision</p>
            <p>
              A digitally capable Africa where organisations of any size can build secure software,
              verify it properly and explain it clearly, with world-class research, tools and
              talent available locally, and applied globally.
            </p>
          </div>
        </div>
      </div>
    </div>

    <!-- How We Work -->
    <div class="timeline-section">
      <h2 class="section-title">How We Work</h2>
      <div class="row g-4">
        <div class="col-md-4">
          <div class="mv-card h-100">
            <div class="mv-icon" aria-hidden="true"><svg width="28" height="28" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"><path d="M11.42 15.17L17.25 21A2.652 2.652 0 0 0 21 17.25l-5.877-5.877M11.42 15.17l2.496-3.03c.317-.384.74-.626 1.208-.766M11.42 15.17l-4.665-4.665M18.75 10.5h.008v.008h-.008V10.5zm-15-7.5l4.665 4.665m0 0a1.5 1.5 0 0 1 0 2.121l-3 3a1.5 1.5 0 0 1-2.121 0l-3-3a1.5 1.5 0 0 1 0-2.121l3-3a1.5 1.5 0 0 1 2.121 0h.008z"/></svg></div>
            <p class="mv-label">Investigate, Build, Show</p>
            <p>We find the weakness with authorised offensive testing, build the fix rather than only recommending it, then render the result so the people who own the system can see exactly what changed.</p>
          </div>
        </div>
        <div class="col-md-4">
          <div class="mv-card h-100">
            <div class="mv-icon" aria-hidden="true"><svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M9 12.75 11.25 15 15 9.75m-3-7.036A11.959 11.959 0 0 1 3.598 6 11.99 11.99 0 0 0 3 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285Z"/></svg></div>
            <p class="mv-label">Authorised &amp; Scoped</p>
            <p>No engagement starts without written permission, a verified scope, and agreed rules of engagement. We work inside those boundaries at all times.</p>
          </div>
        </div>
        <div class="col-md-4">
          <div class="mv-card h-100">
            <div class="mv-icon" aria-hidden="true"><svg width="28" height="28" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"><path d="M12 18.75a6 6 0 0 0 6-6v-1.5m-6 7.5a6 6 0 0 1-6-6v-1.5m6 7.5v3.75m-3.75 0h7.5M12 15.75a3 3 0 0 1-3-3V4.5a3 3 0 1 1 6 0v8.25a3 3 0 0 1-3 3Z"/></svg></div>
            <p class="mv-label">Responsible Disclosure</p>
            <p>We report findings to the client first and support them through remediation. We do not sell access, hold data hostage, or build tools meant to cause harm.</p>
          </div>
        </div>
      </div>
      <p style="color: var(--color-text-dim); font-size: 0.95rem; margin: 1.75rem 0 0; text-align: center;">
        The full detail sits in our <a href="{{ route('ethics') }}">ethics &amp; responsible security policy</a>.
      </p>
    </div>

    <!-- Timeline -->
    <div class="timeline-section">
      <h2 class="section-title">Our Journey</h2>
      <div class="timeline">
        <div class="timeline-item">
          <h4>Research &amp; Foundation</h4>
          <p>Defining the vision, researching Africa's unique cybersecurity landscape, and laying the groundwork for the lab.</p>
        </div>
        <div class="timeline-item">
          <h4>Building Capability</h4>
          <p>Authorised offensive security and red teaming alongside defensive monitoring and incident response; software and product engineering; and animation, motion design and frontend development.</p>
        </div>
        <div class="timeline-item">
          <h4>Shipping Products</h4>
          <p>Turning that capability into our own tools rather than only client work. BizIntel and SiteSurveyor are live, and they are how we test our own methods.</p>
        </div>
        <div class="timeline-item">
          <h4>Full Operations</h4>
          <p>Open for engagements across Southern Africa, with pilots run alongside delivery so the methods keep improving under real conditions.</p>
        </div>
      </div>
    </div>
@endsection
