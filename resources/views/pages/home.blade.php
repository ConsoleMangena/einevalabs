@extends('layouts.app')

@section('title', 'EINEVA Labs | Cybersecurity, Software Engineering & Digital Design - Zimbabwe')
@section('description', 'Cybersecurity research, software engineering, and digital design. EINEVA Labs is an African technology research lab building, securing and explaining complex systems.')
@section('canonical', 'https://eineva.co.zw/')
@section('og_url', 'https://eineva.co.zw/')
@section('og_title', 'EINEVA Labs | Cybersecurity, Software Engineering & Digital Design - Zimbabwe')
@section('og_description', 'An African technology research lab. Cybersecurity, software engineering, and digital design — under one roof, because the hard problems need all three.')

@section('structured_data')
<script type="application/ld+json">
@verbatim
{
  "@context": "https://schema.org",
  "@type": "Organization",
  "name": "EINEVA Labs",
  "url": "https://eineva.co.zw/",
  "logo": "https://eineva.co.zw/assets/logo/einevalabs.png",
  "description": "EINEVA Labs is a technology research lab. We investigate complex systems, build what should exist, and make it all visible, across cybersecurity, software engineering, and digital design.",
  "email": "info@eineva.co.zw",
  "telephone": "+263789575175",
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
    <div class="hero-section" style="background-image: linear-gradient(rgba(10, 10, 12, 0.8), rgba(10, 10, 12, 0.9)), url('{{ asset('assets/images/cyber_bg.jpg') }}'); background-size: cover; background-position: center; border-radius: 16px; padding: 2rem;">
      <div class="row align-items-center g-5">
        <div class="col-lg-7">
          {{--
              The H1 names the three services in the order they appear on
              /services, so a visitor knows what the lab sells in one second and
              the heading carries searchable terms. The positioning line sits
              underneath as the reason they belong to one lab. Both halves of
              the data-text pair must match the visible text or the CSS glitch
              effect animates a different word.
          --}}
          <h1 class="glitch-text" data-text="Cybersecurity, software engineering, and digital design.">Cybersecurity, software engineering, and digital design.</h1>

          <p class="hero-sub">
            <strong>Technology Research Lab</strong>. We investigate complex systems, build what should exist, and make it all visible. Three disciplines under one roof, because the hard problems need all three.
          </p>

          <p class="hero-sub" style="font-size: 0.95rem; margin-top: 1rem;">
            Every engagement is carried out ethically, with written authorisation and an agreed scope.
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

    <!-- Capabilities -->
    <div class="capabilities-section" style="margin-bottom: var(--section-gap);">
      <h2 class="section-title">One Lab. No Handovers.</h2>
      <p style="color: var(--color-text-dim); max-width: 760px; margin: 0 auto 2.5rem; text-align: center; font-size: 1.05rem;">
        Investigate it, build it, then show it. Most of this work needs more than one discipline,
        which is the entire reason they sit together instead of in three companies.
      </p>
      <div class="row g-4">
        <div class="col-lg-4">
          <div class="mv-card h-100 dept-block" data-dept="cyber" style="background-image: linear-gradient(rgba(10, 10, 12, 0.85), rgba(10, 10, 12, 0.95)), url('{{ asset('assets/images/cyber_bg.jpg') }}'); background-size: cover; background-position: center; border: 1px solid var(--border);">
            <div class="mv-icon" aria-hidden="true"><svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M9 12.75 11.25 15 15 9.75m-3-7.036A11.959 11.959 0 0 1 3.598 6 11.99 11.99 0 0 0 3 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285Z"/></svg></div>
            <p class="mv-label">Cybersecurity</p>
            <p>Authorised penetration testing and red teaming on one side; continuous monitoring, detection engineering, hardening and incident response on the other. Security is two-sided, and we work both sides.</p>
          </div>
        </div>
        <div class="col-lg-4">
          <div class="mv-card h-100 dept-block" data-dept="software" style="background-image: linear-gradient(rgba(10, 10, 12, 0.85), rgba(10, 10, 12, 0.95)), url('{{ asset('assets/images/software_bg.jpg') }}'); background-size: cover; background-position: center; border: 1px solid var(--border);">
            <div class="mv-icon" aria-hidden="true"><svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M6.75 7.5l3 2.25-3 2.25m4.5 0h3m-9 8.25h13.5A2.25 2.25 0 0 0 21 18V6a2.25 2.25 0 0 0-2.25-2.25H5.25A2.25 2.25 0 0 0 3 6v12a2.25 2.25 0 0 0 2.25 2.25Z"/></svg></div>
            <p class="mv-label">Software Engineering</p>
            <p>Custom applications, APIs and products, from the first prototype through to handover and maintenance. BizIntel and SiteSurveyor are this team, shipping.</p>
          </div>
        </div>
        <div class="col-lg-4">
          <div class="mv-card h-100 dept-block" data-dept="three_d" style="background-image: linear-gradient(rgba(10, 10, 12, 0.85), rgba(10, 10, 12, 0.95)), url('{{ asset('assets/images/three_d_bg.jpg') }}'); background-size: cover; background-position: center; border: 1px solid var(--border);">
            <div class="mv-icon" aria-hidden="true"><svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M21 7.5l-9-5.25L3 7.5m18 0l-9 5.25m9-5.25v9l-9 5.25M3 7.5l9 5.25M3 7.5v9l9 5.25m0-9v9"/></svg></div>
            <p class="mv-label">Creative Technology</p>
            <p>Animation, motion design and frontend development. Attack paths, architectures and datasets rendered as sequences or built as interactive scenes, plus the interface that carries them.</p>
          </div>
        </div>
      </div>
      <div style="text-align: center; margin-top: 2rem;">
        <a href="{{ route('services') }}" class="btn btn-secondary">View all services</a>
      </div>
    </div>

    <!-- Technologies Slider -->
    <div class="tech-slider-container">
      <h2 class="tech-slider-title">Technologies &amp; Platforms We Work With</h2>
      <div class="tech-slider">
        <div class="tech-slider-track">
          @php
            $techIcons = [
              ['src' => 'https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/rust/rust-original.svg', 'alt' => 'Rust', 'class' => 'tech-logo--mono'],
              ['src' => 'https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/go/go-original-wordmark.svg', 'alt' => 'Go'],
              ['src' => 'https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/python/python-original.svg', 'alt' => 'Python'],
              ['src' => 'https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/php/php-original.svg', 'alt' => 'PHP'],
              ['src' => 'https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/laravel/laravel-original.svg', 'alt' => 'Laravel'],
              ['src' => 'https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/typescript/typescript-original.svg', 'alt' => 'TypeScript'],
              ['src' => 'https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/threejs/threejs-original.svg', 'alt' => 'Three.js', 'class' => 'tech-logo--mono'],
              ['src' => 'https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/blender/blender-original.svg', 'alt' => 'Blender'],
              ['src' => 'https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/tauri/tauri-original.svg', 'alt' => 'Tauri'],
              ['src' => 'https://cdn.jsdelivr.net/gh/simple-icons/simple-icons@latest/icons/solana.svg', 'alt' => 'Solana', 'class' => 'tech-logo--mono'],
              ['src' => 'https://cdn.jsdelivr.net/gh/simple-icons/simple-icons@latest/icons/solidity.svg', 'alt' => 'Solidity', 'class' => 'tech-logo--mono'],
              ['src' => 'https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/wasm/wasm-original.svg', 'alt' => 'WebAssembly'],
              ['src' => 'https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/docker/docker-original.svg', 'alt' => 'Docker'],
              ['src' => 'https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/kubernetes/kubernetes-plain.svg', 'alt' => 'Kubernetes'],
              ['src' => 'https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/amazonwebservices/amazonwebservices-plain-wordmark.svg', 'alt' => 'AWS'],
              ['src' => 'https://cdn.jsdelivr.net/gh/simple-icons/simple-icons@latest/icons/kalilinux.svg', 'alt' => 'Kali Linux', 'class' => 'tech-logo--mono'],
            ];
          @endphp
          @foreach($techIcons as $icon)
            <img src="{{ $icon['src'] }}" alt="{{ $icon['alt'] }}" title="{{ $icon['alt'] }}" class="{{ $icon['class'] ?? '' }}" width="128" height="128" loading="lazy" draggable="false">
          @endforeach
          <!-- Duplicate for seamless loop -->
          @foreach($techIcons as $icon)
            <img src="{{ $icon['src'] }}" alt="{{ $icon['alt'] }}" title="{{ $icon['alt'] }}" class="{{ $icon['class'] ?? '' }}" width="128" height="128" aria-hidden="true" loading="lazy" draggable="false">
          @endforeach
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
              <span class="dept-tag" data-dept="software">Software</span>
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
              <span class="dept-tag" data-dept="software">Software</span>
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
          <h3 class="page-title" style="text-align: left; font-size: clamp(1.8rem, 3vw, 2.2rem); margin-bottom: 1.5rem;">Investigate, Build, Show</h3>
          <p style="color: var(--color-text-dim); margin-bottom: 1.5rem; font-size: 1.05rem;">
            We adjust our assessments and recommendations based on the specific infrastructure and regulatory requirements of each client.
          </p>
          <p style="color: var(--color-text-dim); margin-bottom: 1.5rem; font-size: 1.05rem;">
            We identify existing weaknesses and work directly with engineering teams to implement permanent fixes, then build the tooling that keeps them fixed.
          </p>
          <p style="color: var(--color-text-dim); margin-bottom: 2rem; font-size: 1.05rem;">
            Every offensive technique we use is authorised, scoped, and applied in service of a defensive outcome. Every system we build is designed to be explained, so the same insight that proves the weakness also tells you how to close it.
          </p>
          <a href="{{ route('about') }}" class="btn btn-primary">Learn about our mission</a>
        </div>
        <div class="col-lg-6">
          <div class="row g-3">
            <div class="col-sm-6">
              <div class="stat-card dept-block" data-dept="cyber" style="padding: 1.8rem 1.5rem; height: 100%;">
                <div class="stat-number" style="font-size: 2.2rem;">1</div>
                <div class="stat-label">Assess &amp; Identify</div>
              </div>
            </div>
            <div class="col-sm-6">
              <div class="stat-card dept-block" data-dept="software" style="padding: 1.8rem 1.5rem; height: 100%;">
                <div class="stat-number" style="font-size: 2.2rem;">2</div>
                <div class="stat-label">Build &amp; Protect</div>
              </div>
            </div>
            <div class="col-sm-6">
              <div class="stat-card dept-block" data-dept="three_d" style="padding: 1.8rem 1.5rem; height: 100%;">
                <div class="stat-number" style="font-size: 2.2rem;">3</div>
                <div class="stat-label">Monitor &amp; Detect</div>
              </div>
            </div>
            <div class="col-sm-6">
              <div class="stat-card dept-block" data-dept="cyber" style="padding: 1.8rem 1.5rem; height: 100%;">
                <div class="stat-number" style="font-size: 2.2rem;">4</div>
                <div class="stat-label">Respond &amp; Explain</div>
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
            <p class="notify-sub">Subscribe to receive research releases, project updates and service announcements.</p>
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
