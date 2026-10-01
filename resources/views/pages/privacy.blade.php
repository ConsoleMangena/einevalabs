@extends('layouts.app')

@section('title', 'Privacy Policy - EINEVA Labs')
@section('description', 'Privacy policy for EINEVA Labs - how we collect, use, and protect information when you visit our website or contact us.')
@section('canonical', 'https://eineva.co.zw/privacy')
@section('og_url', 'https://eineva.co.zw/privacy')
@section('og_title', 'Privacy Policy - EINEVA Labs')
@section('og_description', 'How EINEVA Labs collects, uses, and protects your information.')
@section('robots')
  <meta name="robots" content="index, follow">
@endsection

@section('footer_tagline', 'Technology research, engineering and visualisation for Africa')

@section('content')
    <div class="logo">
      <img src="{{ asset('assets/logo/einevalabs.png') }}" alt="EINEVA Labs" width="150" height="150" loading="eager" style="max-width: 100%; height: auto; filter: drop-shadow(0 0 15px rgba(239, 68, 68, 0.15)); display: inline-block;">
    </div>
    <h1 class="page-title">Privacy Policy</h1>
    <p class="legal-meta">Last updated: 5 June 2026</p>

    <div class="legal-section">
      <h2>1. Introduction</h2>
      <p>
        EINEVA Labs ("we", "us", or "our") respects your privacy. This Privacy Policy
        explains what information we collect when you visit <a href="https://eineva.co.zw">eineva.co.zw</a>,
        how we use it, and the choices you have. By using the site, you agree to the practices
        described here.
      </p>
    </div>

    <div class="legal-section">
      <h2>2. Information We Collect</h2>
      <p>We collect only the minimum information needed to operate the site and respond to you:</p>
      <ul>
        <li><strong>Email address</strong> - if you submit the waitlist or contact form</li>
        <li><strong>Name and message</strong> - if you send us a message via the contact form</li>
        <li><strong>Standard server logs</strong> - IP address, browser type, referring page, and timestamps, retained by our hosting provider</li>
      </ul>
    </div>

    <div class="legal-section">
      <h2>3. How We Use Your Information</h2>
      <p>Information you provide is used to:</p>
      <ul>
        <li>Notify you about EINEVA Labs updates and services</li>
        <li>Respond to enquiries you send us through the contact form</li>
        <li>Maintain basic site security and diagnose technical issues</li>
      </ul>
      <p>We do not sell, rent, or trade your personal information to third parties.</p>
    </div>

    <div class="legal-section">
      <h2>4. Third-Party Services</h2>
      <p>Our site uses the following third-party services that may process data on our behalf:</p>
      <ul>
        <li><strong>Web3Forms</strong> - processes contact and waitlist form submissions. See <a href="https://web3forms.com/privacy" target="_blank" rel="noopener">Web3Forms' privacy policy</a>.</li>
        <li><strong>Hosting provider</strong> - serves the website and stores standard request logs</li>
        <li><strong>Social platforms</strong> - LinkedIn, Facebook, and GitHub load only when you click their links</li>
      </ul>
    </div>

    <div class="legal-section">
      <h2>5. Cookies</h2>
      <p>
        Our site does not set tracking or marketing cookies. We do not use analytics or
        advertising networks. Standard functional cookies may be set by our hosting provider
        for load balancing and security.
      </p>
    </div>

    <div class="legal-section">
      <h2>6. Data Retention</h2>
      <p>
        We retain form submissions only as long as needed to fulfil the purpose you submitted
        them for, or until you ask us to delete them. Server logs are retained according to
        our hosting provider's standard retention policy.
      </p>
    </div>

    <div class="legal-section">
      <h2>7. Your Rights</h2>
      <p>You can at any time:</p>
      <ul>
        <li>Request a copy of the personal data we hold about you</li>
        <li>Ask us to correct or delete your data</li>
        <li>Unsubscribe from our notifications</li>
      </ul>
      <p>To exercise any of these rights, email <a href="mailto:info@eineva.co.zw">info@eineva.co.zw</a>.</p>
    </div>

    <div class="legal-section">
      <h2>8. Contact</h2>
      <p>
        If you have questions about this policy, contact us at
        <a href="mailto:info@eineva.co.zw">info@eineva.co.zw</a> or
        <a href="tel:+263789575175">+263 78 957 5175</a>. EINEVA Labs is based in Gweru, Zimbabwe.
      </p>
    </div>
@endsection
