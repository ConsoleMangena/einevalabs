@extends('layouts.app')

@section('title', 'BizIntel - EINEVA Labs | AI-Powered Enterprise Intelligence')
@section('description', 'BizIntel - AI-powered Enterprise Intelligence System for real-time market monitoring, operational analysis, and geospatial insights from EINEVA Labs.')
@section('canonical', 'https://eineva.co.zw/bizintel')
@section('og_url', 'https://eineva.co.zw/bizintel')
@section('og_title', 'BizIntel - EINEVA Labs')
@section('og_description', 'AI-powered Enterprise Intelligence System for real-time market monitoring, operational analysis, and geospatial insights.')
@section('og_image', asset('assets/images/logos/bizintel2.png'))
@section('og_image_type', 'image/png')

@section('footer_tagline', 'Technology research, engineering and visualisation for Africa')

@section('content')
    <!-- Product Hero — Bootstrap two-column layout -->
    <div class="product-hero">
      <div class="row align-items-center g-5">
        <div class="col-lg-7">          <h1 class="page-title">BizIntel Framework</h1>
                              <p class="hero-desc">
            <strong>AI-Powered Enterprise Intelligence System</strong>. BizIntel is an open-source enterprise intelligence platform built on the SiteSurveyor architecture. Using Rust, WebAssembly, and Tauri, it integrates business and geospatial analysis with OpenClaw AI and the Solana blockchain to monitor markets and track operational data.
          </p>
          <div class="hero-actions" style="margin-top: 2rem;">
            <a href="https://bizintel.eineva.co.zw" class="btn btn-primary" style="padding: 0.5rem 1rem; font-size: 0.85rem; margin-right: 0.5rem;" target="_blank" rel="noopener">View Site</a>
            <a href="{{ route('contact') }}" class="btn btn-secondary" style="padding: 0.5rem 1rem; font-size: 0.85rem;">Get in touch</a>
          </div>
        </div>
        <div class="col-lg-5">
          <div class="product-hero-img">
            <img src="{{ asset('assets/images/logos/bizintel2.png') }}" alt="BizIntel Logo" width="180" height="180" loading="eager" >
          </div>
        </div>
      </div>
    </div>

    <div style="margin: 4rem 0; text-align: center; color: var(--color-text-muted);"><p>No content yet.</p></div>

    <div class="status-banner">
      <div class="status-label">Open Source Platform</div>
      <p>
        Interested in using the open-source BizIntel framework for your organization? <a href="{{ route('contact') }}">Get in touch</a> with our team.
      </p>
    </div>
@endsection
