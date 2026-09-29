@extends('layouts.app')

@section('title', 'Ethics & Responsible Security Policy - EINEVA Labs')
@section('description', 'How EINEVA Labs conducts authorised offensive and defensive security work: written permission, agreed rules of engagement, data minimisation, responsible disclosure, and what we will never do.')
@section('canonical', 'https://eineva.co.zw/ethics')
@section('og_url', 'https://eineva.co.zw/ethics')
@section('og_title', 'Ethics & Responsible Security Policy - EINEVA Labs')
@section('og_description', 'Our offensive work is authorised, scoped, and defensive in purpose. Read our rules of engagement, data handling, and responsible disclosure commitments.')
@section('robots')
  <meta name="robots" content="index, follow">
@endsection

@section('footer_tagline', 'Cybersecurity Research & Innovation for Africa')

@section('content')
    <div class="logo">
      <img src="{{ asset('assets/logo/einevalabs.png') }}" alt="EINEVA Labs" width="150" height="150" loading="eager" style="max-width: 100%; height: auto; filter: drop-shadow(0 0 15px rgba(239, 68, 68, 0.15)); display: inline-block;">
    </div>
    <h1 class="page-title">Ethics &amp; Responsible Security Policy</h1>
    <p class="page-sub">How we handle offensive and defensive security work</p>
    <p class="legal-meta">Last updated: 29 September 2026</p>

    <details class="category" open>
      <summary class="category-header">
        <div class="category-accent" aria-hidden="true"></div>
        <h2>1. Our Position</h2>
      </summary>
      <div class="category-services" style="padding: 1.5rem 2rem; color: var(--color-text-dim);">
        <p>
        EINEVA Labs works on both sides of security. Our <strong>offensive</strong> work is penetration
        testing, red teaming, and vulnerability research. Our <strong>defensive</strong> work is
        monitoring, hardening, incident response, and secure engineering. The offensive side exists only
        to serve the defensive side.
      </p>
      <p>
        We are a research lab, not an actor in the threat economy. We do not break into systems for
        access, do not sell access or data, do not deploy ransomware, and do not build tools intended to
        harm people or infrastructure. Everything we do is meant to leave a client stronger than we
        found it.
      </p>
      </div>
    </details>

    <details class="category">
      <summary class="category-header">
        <div class="category-accent" aria-hidden="true"></div>
        <h2>2. Authorisation Comes First</h2>
      </summary>
      <div class="category-services" style="padding: 1.5rem 2rem; color: var(--color-text-dim);">
        <p>No offensive work begins until the following are in place and in writing:</p>
      <ul>
        <li><strong>Written permission</strong> from the asset owner or an authorised representative</li>
        <li><strong>Verified ownership</strong> of every in-scope system, so we are never testing a third party by mistake</li>
        <li><strong>A defined scope</strong> listing the exact systems, environments, and techniques covered</li>
        <li><strong>Named client contacts</strong> reachable during the engagement if something unexpected happens</li>
      </ul>
      <p>
        Verbal permission, implied permission, or an assumption that a system is "probably fine to test" is
        never sufficient. If authorisation is unclear, we pause until it is resolved in writing.
      </p>
      </div>
    </details>

    <details class="category">
      <summary class="category-header">
        <div class="category-accent" aria-hidden="true"></div>
        <h2>3. Rules of Engagement</h2>
      </summary>
      <div class="category-services" style="padding: 1.5rem 2rem; color: var(--color-text-dim);">
        <p>
        Every engagement has documented rules of engagement agreed before any testing occurs. These
        normally set out the testing window and time zone, the techniques that are permitted and those
        that are prohibited, the test accounts and IP addresses we will use, the escalation path, and the
        stop conditions that end testing immediately.
      </p>
      <p>
        We stay strictly inside that agreed boundary. Discovering a system that is not in scope does not
        entitle us to test it; it becomes a finding we report to the client instead.
      </p>
      </div>
    </details>

    <details class="category">
      <summary class="category-header">
        <div class="category-accent" aria-hidden="true"></div>
        <h2>4. Minimising Impact on Operations</h2>
      </summary>
      <div class="category-services" style="padding: 1.5rem 2rem; color: var(--color-text-dim);">
        <p>
        We are assessing your security, not disrupting your business. Our default approach is to avoid
        actions that could degrade service, corrupt data, or affect real users, even where such an action
        would technically be within scope. Destructive techniques, denial-of-service testing, and social
        engineering of your staff are excluded unless the client requests them in writing as a specific,
        separately agreed objective.
      </p>
      </div>
    </details>

    <details class="category">
      <summary class="category-header">
        <div class="category-accent" aria-hidden="true"></div>
        <h2>5. Data Handling</h2>
      </summary>
      <div class="category-services" style="padding: 1.5rem 2rem; color: var(--color-text-dim);">
        <p>
        Assessment evidence is sensitive and treated accordingly. We collect the minimum data needed to
        demonstrate a finding, avoid copying production or personal data unless it is strictly necessary
        and specifically agreed, encrypt evidence in transit and at rest, restrict access to the named
        engagement team, and return or securely destroy all client data and credentials on request or at
        the end of the engagement.
      </p>
      </div>
    </details>

    <details class="category">
      <summary class="category-header">
        <div class="category-accent" aria-hidden="true"></div>
        <h2>6. Responsible Disclosure</h2>
      </summary>
      <div class="category-services" style="padding: 1.5rem 2rem; color: var(--color-text-dim);">
        <p>
        Findings are reported to the client first, with enough detail to reproduce and fix each issue, and
        with a severity rating and a practical remediation path. We agree a disclosure timeline with the
        client so they can remediate before anything becomes public.
      </p>
      <p>
        We do not publish client details, working methods, or exploit code that would harm the client
        without their written consent. Where a vulnerability affects a system we do not own, we follow a
        coordinated disclosure process and give the owner a reasonable opportunity to fix it.
      </p>
      </div>
    </details>

    <details class="category">
      <summary class="category-header">
        <div class="category-accent" aria-hidden="true"></div>
        <h2>7. What We Will Not Do</h2>
      </summary>
      <div class="category-services" style="padding: 1.5rem 2rem; color: var(--color-text-dim);">
        <p>These are firm limits on our work, in any engagement and in any research we publish:</p>
      <ul>
        <li>Test, scan, or probe any system without documented authorisation</li>
        <li>Access, retain, or share customer or personal data beyond what the engagement requires</li>
        <li>Sell, trade, publish, or otherwise profit from access, credentials, exploits, or stolen data</li>
        <li>Build or deploy malware, ransomware, or wipers</li>
        <li>Conduct denial-of-service attacks, or any activity designed to degrade or deny a service, without explicit written approval naming the target, window, and rate limits</li>
        <li>Conduct surveillance on private individuals, or target members of the public</li>
        <li>Assist any party in planning, preparing, or executing an attack</li>
        <li>Hold or operate infrastructure intended to support criminal activity</li>
      </ul>
      </div>
    </details>

    <details class="category">
      <summary class="category-header">
        <div class="category-accent" aria-hidden="true"></div>
        <h2>8. Legal and Professional Standards</h2>
      </summary>
      <div class="category-services" style="padding: 1.5rem 2rem; color: var(--color-text-dim);">
        <p>
        We operate in accordance with applicable law, including Zimbabwe's cybercrime legislation and the
        laws of each jurisdiction in which an engagement is performed, and we work to align with recognised
        professional standards and ethical codes in the security testing field. When a request would require
        us to act outside the law, outside the agreed scope, or outside these commitments, we decline it.
      </p>
      </div>
    </details>

    <details class="category">
      <summary class="category-header">
        <div class="category-accent" aria-hidden="true"></div>
        <h2>9. Reporting a Vulnerability in Our Systems</h2>
      </summary>
      <div class="category-services" style="padding: 1.5rem 2rem; color: var(--color-text-dim);">
        <p>
        If you find a weakness in one of our own systems, please tell us rather than exploiting it.
        Email <a href="mailto:info@eineva.co.zw">info@eineva.co.zw</a> with a description of the issue and
        how you reproduced it. We will acknowledge your report, work to validate and fix it, and coordinate
        any public disclosure with you. We do not take legal action against researchers who act in good
        faith within this process, and we ask that you avoid accessing data, degrading service, or
        disrupting other users.
      </p>
      </div>
    </details>

    <details class="category">
      <summary class="category-header">
        <div class="category-accent" aria-hidden="true"></div>
        <h2>10. Questions</h2>
      </summary>
      <div class="category-services" style="padding: 1.5rem 2rem; color: var(--color-text-dim);">
        <p>
        If you need clarification about this policy, or you want to confirm the authorisation and scope of
        work we are doing for you, contact us at
        <a href="mailto:info@eineva.co.zw">info@eineva.co.zw</a> or
        <a href="{{ route('contact') }}">our contact page</a>. We will put the relevant authorisation and
        scope documentation in writing on request.
      </p>
      </div>
    </details>
@endsection
