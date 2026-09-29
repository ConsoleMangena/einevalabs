@extends('layouts.app')

@section('title', 'About - EINEVA Labs | Cybersecurity Research for Africa')
@section('description', 'Learn about EINEVA Labs - Africa\'s dedicated cybersecurity research lab closing the cyber skills gap in Southern Africa through authorised offensive and defensive security work.')
@section('canonical', 'https://eineva.co.zw/about')
@section('og_url', 'https://eineva.co.zw/about')
@section('og_title', 'About - EINEVA Labs | Cybersecurity Research for Africa')
@section('og_description', 'Learn about EINEVA Labs - Africa\'s dedicated cybersecurity research laboratory. Our mission and journey focused on closing the cyber skills gap in Southern Africa.')

@section('content')
    <!-- Hero with two-column layout -->
    <div class="about-hero">
      <div class="row align-items-center g-5">
        <div class="col-lg-7">
          <div class="hero-badge">About Us</div>
          <h1 class="page-title" style="text-align: left;">About EINEVA Labs</h1>
          <p style="font-size: 1.1rem; color: var(--color-text-dim);">
            EINEVA Labs exists to strengthen Africa's digital resilience. We combine cybersecurity research, secure engineering, and practical threat intelligence to help startups, businesses, public institutions, and developers build safer digital products.
          </p>
          <p style="font-size: 1.1rem; color: var(--color-text-dim);">
            That means working both sides of security: we test systems the way an attacker would, within
            strict ethical boundaries, and then we help our clients defend them properly. We operate on
            authorised engagements only &mdash; written permission, agreed scope, and ethical conduct are
            the conditions of our work, not optional extras.
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
          <div class="stat-card">
            <div class="stat-number">6+</div>
            <div class="stat-label">Services</div>
          </div>
        </div>
        <div class="col-6 col-md-3">
          <div class="stat-card">
            <div class="stat-number">2</div>
            <div class="stat-label">Products</div>
          </div>
        </div>
        <div class="col-6 col-md-3">
          <div class="stat-card">
            <div class="stat-number">ZW</div>
            <div class="stat-label">Based In</div>
          </div>
        </div>
        <div class="col-6 col-md-3">
          <div class="stat-card">
            <div class="stat-number">24/7</div>
            <div class="stat-label">Operations</div>
          </div>
        </div>
      </div>
    </div>

    <!-- Mission & Vision -->
    <div class="mv-section">
      <div class="row g-4">
        <div class="col-md-6">
          <div class="mv-card">
            <div class="mv-icon" aria-hidden="true"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><circle cx="12" cy="12" r="6"/><circle cx="12" cy="12" r="2"/></svg></div>
            <p class="mv-label">Our Mission</p>
            <p>
              To make high-quality cybersecurity research, tools, and expertise accessible where they matter most. We believe digital security should be built into Africa's products, infrastructure, and institutions from the start.
            </p>
          </div>
        </div>
        <div class="col-md-6">
          <div class="mv-card">
            <div class="mv-icon" aria-hidden="true"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg></div>
            <p class="mv-label">Our Vision</p>
            <p>
              A digitally secure Africa where organisations of every size have access to world-class cybersecurity research, tools, and talent — built locally, applied globally.
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
            <div class="mv-icon" aria-hidden="true"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><path d="M9 12l2 2 4-4"/></svg></div>
            <p class="mv-label">Offensive &amp; Defensive</p>
            <p>Breaking in to break nothing. We use authorised offensive testing to find weaknesses, and defensive engineering to make sure they stay fixed.</p>
          </div>
        </div>
        <div class="col-md-4">
          <div class="mv-card h-100">
            <div class="mv-icon" aria-hidden="true"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 12l2 2 4-4"/><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg></div>
            <p class="mv-label">Authorised &amp; Scoped</p>
            <p>No engagement starts without written permission, a verified scope, and agreed rules of engagement. We work inside those boundaries at all times.</p>
          </div>
        </div>
        <div class="col-md-4">
          <div class="mv-card h-100">
            <div class="mv-icon" aria-hidden="true"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg></div>
            <p class="mv-label">Responsible Disclosure</p>
            <p>We report findings to the client first and support remediation. We do not sell access, hold data hostage, or build tools meant to cause harm.</p>
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
          <h4>Building Capabilities</h4>
          <p>Developing expertise in authorised offensive security and red teaming, defensive monitoring and incident response, secure development, and threat intelligence.</p>
        </div>
        <div class="timeline-item">
          <h4>Pilot Programmes</h4>
          <p>Engaging with partner organisations for pilot engagements, refining methodologies and tooling.</p>
        </div>
        <div class="timeline-item">
          <h4>Full Operations</h4>
          <p>Providing comprehensive security services across Southern Africa and scaling impact.</p>
        </div>
      </div>
    </div>
@endsection
