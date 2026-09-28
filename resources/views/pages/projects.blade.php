@extends('layouts.app')

@section('title', 'Projects - EINEVA Labs | Cybersecurity & Software Innovation')
@section('description', 'Explore projects by EINEVA Labs: SiteSurveyor for Engineers - Web 3.0 project management for survey projects with marketplace and enterprise accounts.')
@section('canonical', 'https://eineva.co.zw/projects')
@section('og_url', 'https://eineva.co.zw/projects')
@section('og_title', 'Projects - EINEVA Labs | Cybersecurity & Software Innovation')
@section('og_description', 'Explore projects by EINEVA Labs - including SiteSurveyor for Engineers, with Personal and Enterprise accounts, and an instrument and personnel marketplace.')

@section('footer_tagline', 'Cybersecurity Research & Innovation for Africa')

@section('content')
    <div class="logo">
      <img src="{{ asset('assets/logo/einevalabs.png') }}" alt="EINEVA Labs" width="150" height="150" loading="eager" style="max-width: 100%; height: auto; filter: drop-shadow(0 0 15px rgba(239, 68, 68, 0.15)); display: inline-block;">
    </div>
    <h1 class="page-title">Our Projects</h1>
    <p class="page-sub">EINEVA Labs develops software products to address specific security and operational challenges. We build systems using artificial intelligence and blockchain technology.</p>

    <!-- Bootstrap grid: side-by-side on desktop, stacked on mobile -->
    <div class="projects-grid" style="margin-bottom: var(--section-gap);">
      <div class="row g-4">
        <div class="col-lg-6">
          <div class="project-card h-100">
            <div class="project-header">
              <img src="{{ asset('assets/images/logos/sitesurveyor.jpeg') }}" alt="SiteSurveyor for Engineers logo" class="project-logo" width="80" height="80" loading="lazy">
              <div>
                <h2 class="project-title">SiteSurveyor Framework</h2>
                <p class="project-tagline">AI Automation &amp; Solana Blockchain for Surveying Systems</p>
              </div>
            </div>
            <p class="project-desc">A framework for surveying systems. Built with Rust, WebAssembly, and Tauri, it integrates OpenClaw AI for automation and the Solana blockchain for secure records.</p>
            <a href="{{ route('projects.sitesurveyor') }}" class="project-link">View SiteSurveyor details &rarr;</a>
          </div>
        </div>
        <div class="col-lg-6">
          <div class="project-card h-100">
            <div class="project-header">
              <img src="{{ asset('assets/images/logos/bizintel2.png') }}" alt="BizIntel logo" class="project-logo" width="80" height="80" loading="lazy">
              <div>
                <h2 class="project-title">BizIntel Framework</h2>
                <p class="project-tagline">AI-Powered Enterprise Intelligence System</p>
              </div>
            </div>
            <p class="project-desc">An open-source enterprise intelligence platform. It uses the Solana blockchain for data integrity and OpenClaw AI for market monitoring and operational analysis.</p>
            <a href="{{ route('projects.bizintel') }}" class="project-link">View BizIntel details &rarr;</a>
          </div>
        </div>
      </div>
    </div>
    
    <div class="mv-section" style="margin-bottom: var(--section-gap);">
      <h2 class="section-title">Open Source Commitment</h2>
      <div class="row g-4 justify-content-center">
        <div class="col-md-8">
          <div class="mv-card" style="text-align: center; padding: 3rem 2rem;">
            <div class="mv-icon" style="margin: 0 auto 1.5rem;" aria-hidden="true"><svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="16 18 22 12 16 6"/><polyline points="8 6 2 12 8 18"/></svg></div>
            <p class="mv-label">Open Source</p>
            <p style="margin-bottom: 2rem;">
              Our core frameworks are open source. We encourage developers and security researchers to audit our code, contribute to the repositories, and adapt the tools for their own environments.
            </p>
            <a href="https://github.com/einevalabs" target="_blank" rel="noopener" class="btn btn-secondary">
              <svg viewBox="0 0 24 24" aria-hidden="true" width="20" height="20" style="margin-right: 8px; fill: currentColor;"><path d="M12 .297c-6.63 0-12 5.373-12 12 0 5.303 3.438 9.8 8.205 11.385.6.113.82-.258.82-.577 0-.285-.01-1.04-.015-2.04-3.338.724-4.042-1.61-4.042-1.61C4.422 18.07 3.633 17.7 3.633 17.7c-1.087-.744.084-.729.084-.729 1.205.084 1.838 1.236 1.838 1.236 1.07 1.835 2.809 1.305 3.495.998.108-.776.417-1.305.76-1.605-2.665-.3-5.466-1.332-5.466-5.93 0-1.31.465-2.38 1.235-3.22-.135-.303-.54-1.523.105-3.176 0 0 1.005-.322 3.3 1.23.96-.267 1.98-.399 3-.405 1.02.006 2.04.138 3 .405 2.28-1.552 3.285-1.23 3.285-1.23.645 1.653.24 2.873.12 3.176.765.84 1.23 1.91 1.23 3.22 0 4.61-2.805 5.625-5.475 5.92.42.36.81 1.096.81 2.22 0 1.606-.015 2.896-.015 3.286 0 .315.21.69.825.57C20.565 22.092 24 17.592 24 12.297c0-6.627-5.373-12-12-12"/></svg>
              Follow us on GitHub
            </a>
          </div>
        </div>
      </div>
    </div>
@endsection
