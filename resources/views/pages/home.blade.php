@extends('layouts.app')

@section('title', 'EINEVA Labs | Securing Africa\'s Digital Future')
@section('description', 'EINEVA Labs is Africa\'s dedicated cybersecurity research laboratory offering penetration testing, threat intelligence, and managed security services.')
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
  "description": "Africa's dedicated cybersecurity research and innovation laboratory.",
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
            <strong>Cybersecurity Research Lab</strong> &mdash; EINEVA Labs provides penetration testing, secure software development, threat intelligence, and managed security services to organizations across Africa.
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
      <h2 class="section-title">Core Capabilities</h2>
      <div class="row g-4">
        <div class="col-md-4">
          <div class="mv-card h-100">
            <div class="mv-icon" aria-hidden="true"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg></div>
            <p class="mv-label">Offensive Security</p>
            <p>We conduct penetration testing and red team exercises to identify vulnerabilities in web, mobile, and cloud environments.</p>
          </div>
        </div>
        <div class="col-md-4">
          <div class="mv-card h-100">
            <div class="mv-icon" aria-hidden="true"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="3" width="20" height="14" rx="2" ry="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/></svg></div>
            <p class="mv-label">Secure Engineering</p>
            <p>We review software architecture, integrate DevSecOps practices, and audit code to improve application security.</p>
          </div>
        </div>
        <div class="col-md-4">
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

    <!-- Featured Projects -->
    <div class="projects-preview-section" style="margin-bottom: var(--section-gap);">
      <h2 class="section-title">Innovation & Products</h2>
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
                  <p class="project-tagline">Blockchain & AI for Surveying</p>
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
          <h3 class="page-title" style="text-align: left; font-size: clamp(1.8rem, 3vw, 2.2rem); margin-bottom: 1.5rem;">Practical Security Assessments</h3>
          <p style="color: var(--color-text-dim); margin-bottom: 1.5rem; font-size: 1.05rem;">
            We adjust our security assessments and recommendations based on the specific infrastructure and regulatory requirements of each client.
          </p>
          <p style="color: var(--color-text-dim); margin-bottom: 2rem; font-size: 1.05rem;">
            We identify existing vulnerabilities and work directly with engineering teams to implement permanent fixes.
          </p>
          <a href="{{ route('about') }}" class="btn btn-primary">Learn about our mission</a>
        </div>
        <div class="col-lg-6">
          <div class="row g-3">
            <div class="col-sm-6">
              <div class="stat-card" style="padding: 1.8rem 1.5rem; height: 100%;">
                <div class="stat-number" style="font-size: 2.2rem;">1</div>
                <div class="stat-label">Assess & Identify</div>
              </div>
            </div>
            <div class="col-sm-6">
              <div class="stat-card" style="padding: 1.8rem 1.5rem; height: 100%;">
                <div class="stat-number" style="font-size: 2.2rem;">2</div>
                <div class="stat-label">Protect & Engineer</div>
              </div>
            </div>
            <div class="col-sm-6">
              <div class="stat-card" style="padding: 1.8rem 1.5rem; height: 100%;">
                <div class="stat-number" style="font-size: 2.2rem;">3</div>
                <div class="stat-label">Monitor & Detect</div>
              </div>
            </div>
            <div class="col-sm-6">
              <div class="stat-card" style="padding: 1.8rem 1.5rem; height: 100%;">
                <div class="stat-number" style="font-size: 2.2rem;">4</div>
                <div class="stat-label">Respond & Recover</div>
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
