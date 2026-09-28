@extends('layouts.app')

@section('title', 'SiteSurveyor Framework - EINEVA Labs')
@section('description', 'SiteSurveyor Framework - A complete toolset for surveyors combining Tauri cross-platform performance, Solana blockchain integration, and OpenClaw AI automation.')
@section('canonical', 'https://eineva.co.zw/sitesurveyor')
@section('og_url', 'https://eineva.co.zw/sitesurveyor')
@section('og_title', 'SiteSurveyor Framework - EINEVA Labs')
@section('og_description', 'A complete framework for developing surveying systems with OpenClaw AI automation and Solana blockchain, built with Rust, Tauri, and WebAssembly.')

@section('footer_tagline', 'Cybersecurity Research & Innovation for Africa')

@section('content')
    <!-- Product Hero — Bootstrap two-column layout -->
    <div class="product-hero">
      <div class="row align-items-center g-5">
        <div class="col-lg-7">          <h1 class="page-title">SiteSurveyor Framework</h1>
                              <p class="hero-desc">
            <strong>AI Automation &amp; Solana Blockchain for Surveying Systems</strong> &mdash; SiteSurveyor is a framework for developing surveying software. It uses Tauri for cross-platform applications, the Solana blockchain for data integrity, and OpenClaw AI for automation. The framework provides tools for project planning, coordinate geometry computations, and secure file storage.
          </p>
          <div class="hero-actions" style="margin-top: 2rem;">
            <a href="https://sitesurveyor.eineva.co.zw" class="btn btn-primary" style="padding: 0.5rem 1rem; font-size: 0.85rem; margin-right: 0.5rem;" target="_blank" rel="noopener">View Site</a>
            <a href="{{ route('contact') }}" class="btn btn-secondary" style="padding: 0.5rem 1rem; font-size: 0.85rem;">View on GitHub</a>
          </div>
        </div>
        <div class="col-lg-5">
          <div class="product-hero-img">
            <img src="{{ asset('assets/images/logos/sitesurveyor.jpeg') }}" alt="SiteSurveyor for Engineers" width="180" height="180" loading="eager">
          </div>
        </div>
      </div>
    </div>

    <div style="margin: 4rem 0; text-align: center; color: var(--color-text-muted);"><p>No content yet.</p></div>

    <div class="status-banner">
      <div class="status-label">Open Source</div>
      <p>
        SiteSurveyor Framework is open source under the MIT license. <a href="https://github.com/ConsoleMangena/sitesurveyor-framework" target="_blank" rel="noopener">View on GitHub</a> or <a href="{{ route('contact') }}">get in touch</a> with our team.
      </p>
    </div>
@endsection
