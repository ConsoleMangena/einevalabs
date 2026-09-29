@extends('layouts.app')

@section('title', 'EINEVA Labs | Securing Africa\'s Digital Future')
@section('description', 'EINEVA Labs is Africa\'s dedicated cybersecurity research laboratory providing authorised offensive and defensive security services: penetration testing, red teaming, secure engineering, and threat intelligence.')
@section('canonical', 'https://eineva.co.zw/')
@section('og_url', 'https://eineva.co.zw/')

@section('structured_data')
<script type="application/ld+json">
@verbatim
{
  "@context": "https://schema.org",
  "@type": "Organization",
  "name": "EINEVA Labs",
  "url": "https://eineva.co.zw/",
  "logo": "https://eineva.co.zw/assets/logo/einevalabs.png",
  "description": "EINEVA Labs is Africa's dedicated cybersecurity research laboratory providing authorised offensive and defensive security services: penetration testing, red teaming, secure engineering, and threat intelligence.",
  "email": "info@eineva.co.zw",
  "telephone": "+263781524929",
  "address": {
    "@type": "PostalAddress",
    "addressLocality": "Gweru",
    "addressCountry": "ZW"
  },
  "sameAs": [
    "https://www.linkedin.com/in/consolemangena404/",
    "https://www.facebook.com/einevalabs/",
    "https://github.com/einevalabs"
  ]
}
@endverbatim
</script>
@endsection

@section('content')
    <div class="hero-section">
      <div class="row align-items-center g-5">
        <div class="col-lg-7">
          <h1 class="glitch-text" data-text="Securing Africa's Digital Future">Securing Africa's Digital Future</h1>

          <p class="hero-sub">
            <strong>Cybersecurity Research Lab</strong> &mdash; EINEVA Labs provides both <strong>offensive</strong> and <strong>defensive</strong> security services to organizations across Africa: authorised penetration testing and red teaming on one side, continuous monitoring, hardening, and incident response on the other. Every engagement is carried out ethically, with written authorisation and an agreed scope.
          </p>

          <div class="hero-actions" style="margin-top: 2rem;">
            <a href="{{ route('services') }}" class="btn btn-primary" style="padding: 0.5rem 1rem; font-size: 0.85rem;">Explore capabilities &rarr;</a>
            <a href="{{ route('contact') }}" class="btn btn-secondary" style="padding: 0.5rem 1rem; font-size: 0.85rem;">Get in touch</a>
          </div>
        </div>
        <div class="col-lg-5 text-center text-lg-end">
          <div class="hero-logo">
            <img src="{{ asset('assets/logo/einevalabs.png') }}" alt="EINEVA Labs" width="150" height="150" loading="eager" style="max-width: 100%; height: auto; filter: drop-shadow(0 0 15px rgba(239, 68, 68, 0.15)); display: inline-block;">
          </div>
        </div>
      </div>
    </div>

    <!-- Core Capabilities Preview -->
    <div class="capabilities-section" style="margin-bottom: var(--section-gap);">
      <h2 class="section-title">Offensive &amp; Defensive Security</h2>
      <p style="color: var(--color-text-dim); max-width: 760px; margin: 0 auto 2.5rem; text-align: center; font-size: 1.05rem;">
        Security is two-sided. We attack your systems the way a real adversary would &mdash; within strict ethical boundaries &mdash; so you can see the gaps, then we help you close them and keep them closed.
      </p>
      <div class="row g-4">
        <div class="col-lg-3">
          <div class="mv-card h-100">
            <div class="mv-icon" aria-hidden="true"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg></div>
            <p class="mv-label">Offensive Security</p>
            <p>Authorised penetration testing and red team exercises that identify vulnerabilities in web, mobile, API, and cloud environments before an attacker does.</p>
          </div>
        </div>
        <div class="col-lg-3">
          <div class="mv-card h-100">
            <div class="mv-icon" aria-hidden="true"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><path d="M9 12l2 2 4-4"/></svg></div>
            <p class="mv-label">Defensive Security</p>
            <p>Continuous monitoring, detection engineering, hardening, and incident response that shorten the time between compromise and containment.</p>
          </div>
        </div>
        <div class="col-lg-3">
          <div class="mv-card h-100">
            <div class="mv-icon" aria-hidden="true"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="3" width="20" height="14" rx="2" ry="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/></svg></div>
            <p class="mv-label">Secure Engineering</p>
            <p>We review software architecture, integrate DevSecOps practices, and audit code to improve application security.</p>
          </div>
        </div>
        <div class="col-lg-3">
          <div class="mv-card h-100">
            <div class="mv-icon" aria-hidden="true"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg></div>
            <p class="mv-label">Threat Intelligence</p>
            <p>We monitor networks and analyze threat data to detect and respond to active security incidents.</p>
          </div>
        </div>
      </div>
      <div style="text-align: center; margin-top: 2rem;">
        <a href="{{ route('services') }}" class="btn btn-secondary">View all services</a>
      </div>
    </div>

    <!-- Ethics & Authorisation -->
    <div class="ethics-section" style="margin-bottom: var(--section-gap);">
      <div class="mv-card" style="padding: 2.5rem; background: var(--color-bg-card); border: 1px solid var(--color-border); border-radius: var(--radius-lg);">
        <h2 class="section-title" style="margin-left: 0; text-align: left;">Our Offensive Work Is Strictly Ethical</h2>
        <p style="color: var(--color-text-dim); font-size: 1.05rem; margin-bottom: 1.5rem;">
          Breaking into systems is only ever used to make them stronger. We do not test, probe, or demonstrate capability against anything we have not been explicitly authorised to assess in writing. Our purpose is defensive: find the weakness responsibly, report it responsibly, and help fix it.
        </p>
        <div class="row g-4">
          <div class="col-md-6">
            <p class="mv-label" style="margin-bottom: 0.35rem;">Written authorisation first</p>
            <p style="color: var(--color-text-dim); font-size: 0.95rem; margin: 0;">No engagement begins without signed permission from the asset owner, defining exactly which systems are in scope and who owns them.</p>
          </div>
          <div class="col-md-6">
            <p class="mv-label" style="margin-bottom: 0.35rem;">Agreed rules of engagement</p>
            <p style="color: var(--color-text-dim); font-size: 0.95rem; margin: 0;">Testing windows, permitted techniques, and escalation contacts are agreed in advance. Anything outside the agreed scope is not attempted.</p>
          </div>
          <div class="col-md-6">
            <p class="mv-label" style="margin-bottom: 0.35rem;">Minimum necessary access</p>
            <p style="color: var(--color-text-dim); font-size: 0.95rem; margin: 0;">We access only what the assessment requires, avoid collecting personal or production data, and destroy or return evidence securely on request.</p>
          </div>
          <div class="col-md-6">
            <p class="mv-label" style="margin-bottom: 0.35rem;">Responsible disclosure</p>
            <p style="color: var(--color-text-dim); font-size: 0.95rem; margin: 0;">Findings go to the client first and are published only after remediation or after the agreed disclosure window. We do not trade in access, exploits, or leaked data.</p>
          </div>
        </div>
        <p style="color: var(--color-text-dim); font-size: 0.95rem; margin: 1.5rem 0 0;">
          If you find a vulnerability in one of our own systems, please report it to
          <a href="mailto:info@eineva.co.zw">info@eineva.co.zw</a> rather than exploiting it. We will acknowledge your report and coordinate a fix.
        </p>
        <div style="margin-top: 1.75rem;">
          <a href="{{ route('ethics') }}" class="btn btn-secondary">Read our full ethics &amp; responsible security policy</a>
        </div>
      </div>
    </div>

    <!-- Featured Projects -->
    <div class="projects-preview-section" style="margin-bottom: var(--section-gap);">
      <h2 class="section-title">Innovation &amp; Products</h2>
      <div class="projects-grid">
        <div class="row g-4">
          <div class="col-lg-6">
            <div class="project-card h-100">
              <div class="project-header">
                <img src="{{ asset('assets/images/logos/bizintel2.png') }}" alt="BizIntel logo" class="project-logo" width="80" height="80" loading="lazy">
                <div>
                  <h3 class="project-title">BizIntel Framework</h3>
                  <p class="project-tagline">AI-Powered Enterprise Intelligence</p>
                </div>
              </div>
              <p class="project-desc">An advanced system using OpenClaw AI and Solana blockchain to provide real-time market monitoring, operational analysis, and spatial intelligence for modern enterprises.</p>
              <a href="{{ route('projects.bizintel') }}" class="project-link">Explore BizIntel &rarr;</a>
            </div>
          </div>
          <div class="col-lg-6">
            <div class="project-card h-100">
              <div class="project-header">
                <img src="{{ asset('assets/images/logos/sitesurveyor.jpeg') }}" alt="SiteSurveyor logo" class="project-logo" width="80" height="80" loading="lazy">
                <div>
                  <h3 class="project-title">SiteSurveyor</h3>
                  <p class="project-tagline">Blockchain &amp; AI for Surveying</p>
                </div>
              </div>
              <p class="project-desc">A complete framework combining Tauri's cross-platform performance with native Solana integration and AI capabilities to run complex, secure surveying workflows.</p>
              <a href="{{ route('projects.sitesurveyor') }}" class="project-link">Explore SiteSurveyor &rarr;</a>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Approach / Methodology -->
    <div class="approach-section" style="margin-bottom: var(--section-gap);">
      <div class="row g-5 align-items-center">
        <div class="col-lg-6">
          <h2 class="section-title" style="margin-left: 0;">Our Approach</h2>
          <h3 class="page-title" style="text-align: left; font-size: clamp(1.8rem, 3vw, 2.2rem); margin-bottom: 1.5rem;">Offensive Insight, Defensive Outcome</h3>
          <p style="color: var(--color-text-dim); margin-bottom: 1.5rem; font-size: 1.05rem;">
            We adjust our security assessments and recommendations based on the specific infrastructure and regulatory requirements of each client.
          </p>
          <p style="color: var(--color-text-dim); margin-bottom: 1.5rem; font-size: 1.05rem;">
            We identify existing vulnerabilities and work directly with engineering teams to implement permanent fixes.
          </p>
          <p style="color: var(--color-text-dim); margin-bottom: 2rem; font-size: 1.05rem;">
            Every offensive technique we use is authorised, scoped, and applied in service of a defensive outcome &mdash; so the same insight that proves the weakness also tells you how to close it.
          </p>
          <a href="{{ route('about') }}" class="btn btn-primary">Learn about our mission</a>
        </div>
        <div class="col-lg-6">
          <div class="row g-3">
            <div class="col-sm-6">
              <div class="stat-card" style="padding: 1.8rem 1.5rem; height: 100%;">
                <div class="stat-number" style="font-size: 2.2rem;">1</div>
                <div class="stat-label">Assess &amp; Identify</div>
              </div>
            </div>
            <div class="col-sm-6">
              <div class="stat-card" style="padding: 1.8rem 1.5rem; height: 100%;">
                <div class="stat-number" style="font-size: 2.2rem;">2</div>
                <div class="stat-label">Protect &amp; Engineer</div>
              </div>
            </div>
            <div class="col-sm-6">
              <div class="stat-card" style="padding: 1.8rem 1.5rem; height: 100%;">
                <div class="stat-number" style="font-size: 2.2rem;">3</div>
                <div class="stat-label">Monitor &amp; Detect</div>
              </div>
            </div>
            <div class="col-sm-6">
              <div class="stat-card" style="padding: 1.8rem 1.5rem; height: 100%;">
                <div class="stat-number" style="font-size: 2.2rem;">4</div>
                <div class="stat-label">Respond &amp; Recover</div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Newsletter -->
    <div class="notify notify-band">
      <div class="row align-items-center g-4">
        <div class="col-lg-5">
          <p class="notify-title">Stay informed</p>
          <p class="notify-sub">Subscribe to receive research releases and service updates.</p>
          <p class="notify-note">No spam. Unsubscribe anytime.</p>
        </div>
        <div class="col-lg-7">
          <form class="notify-form" action="{{ route('newsletter.subscribe') }}" method="post" aria-label="Subscribe to newsletter">
            @csrf
            <label class="sr-only" for="notify-email">Email address</label>
            <input id="notify-email" type="email" name="email" placeholder="your@email.com" autocomplete="email" required>
            <input type="checkbox" name="botcheck" class="hidden">
            <button type="submit">Subscribe</button>
          </form>
        </div>
      </div>
    </div>
@endsection
