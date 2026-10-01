@extends('layouts.app')

@section('title', 'Capabilities - Cybersecurity, Software Engineering, Animation & Motion - EINEVA Labs')
@section('description', 'EINEVA Labs capabilities: authorised penetration testing and red teaming, custom software and API development, and 3D, animation, motion design and frontend development.')
@section('canonical', 'https://eineva.co.zw/services')
@section('og_url', 'https://eineva.co.zw/services')
@section('og_title', 'Capabilities - Cybersecurity, Software Engineering, Animation & Motion - EINEVA Labs')
@section('og_description', 'Authorised offensive and defensive security, custom software and product engineering, and animation, motion design and frontend development - all from one lab, with no handovers between specialists.')

@section('content')
    <div class="logo">
      <img src="{{ asset('assets/logo/einevalabs.png') }}" alt="EINEVA Labs" width="150" height="150" loading="eager" style="max-width: 100%; height: auto; filter: drop-shadow(0 0 15px rgba(239, 68, 68, 0.15)); display: inline-block;">
    </div>
    <h1 class="page-title">Capabilities</h1>
    <p class="page-sub">Cybersecurity, software engineering, and animation, motion design &amp; frontend development, delivered with authorisation and care</p>

    <div class="mv-section" style="margin-bottom: var(--section-gap);">
      <div class="row g-4">
        <div class="col-md-6">
          <div class="mv-card h-100">
            <div class="mv-icon" aria-hidden="true"><svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M9 12.75 11.25 15 15 9.75m-3-7.036A11.959 11.959 0 0 1 3.598 6 11.99 11.99 0 0 0 3 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285Z"/></svg></div>
            <p class="mv-label">Offensive Security</p>
            <p>
              We attack your systems the way a real adversary would, within strict ethical boundaries, to
              prove where the weaknesses are before an attacker finds them. Every assessment is carried out
              with written authorisation, an agreed scope, and documented rules of engagement.
            </p>
          </div>
        </div>
        <div class="col-md-6">
          <div class="mv-card h-100">
            <div class="mv-icon" aria-hidden="true"><svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M9 12.75 11.25 15 15 9.75m-3-7.036A11.959 11.959 0 0 1 3.598 6 11.99 11.99 0 0 0 3 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285Z"/></svg></div>
            <p class="mv-label">Defensive Security</p>
            <p>
              We then help you close those gaps for good. Monitoring, detection engineering, hardening,
              incident response, and secure development turn a one-off test into a standing defence that
              keeps improving as your environment changes.
            </p>
          </div>
        </div>
      </div>
      <p style="color: var(--color-text-dim); font-size: 0.95rem; margin: 1.5rem 0 0; text-align: center;">
        All offensive work is authorised, scoped, and defensive in purpose. See our
        <a href="{{ route('ethics') }}">ethics &amp; responsible security policy</a> for the commitments behind every engagement.
      </p>
    </div>

    <!--
      One page, three capability blocks. Each block carries data-dept so
      styles.css can set the accent for everything inside it; the capabilities
      are never given their own routes, because a thin page per capability
      would dilute
      authority on a single canonical /services URL.
    -->
    <h2 class="section-title">What We Do</h2>
    <p style="color: var(--color-text-dim); max-width: 760px; margin: 0 auto 2.5rem; text-align: center; font-size: 1.05rem;">
      Pick the capability that matches your problem. Most of our engagements touch more than one.
    </p>

    <div class="dept-block" data-dept="cyber" id="dept-cyber">
      <div style="background-image: linear-gradient(rgba(10, 10, 12, 0.8), rgba(10, 10, 12, 0.95)), url('{{ asset('assets/images/cyber_bg.jpg') }}'); background-size: cover; background-position: center; border-radius: 12px; padding: 2.5rem 2rem; margin-bottom: 2.5rem; border: 1px solid var(--border);">
        <div class="dept-heading" style="margin-bottom: 1rem;">
          <h2 style="margin: 0; text-shadow: 0 2px 10px rgba(0,0,0,0.5);">Cybersecurity</h2>
        </div>
        <p style="color: rgba(255, 255, 255, 0.9); margin-bottom: 0; font-size: 1.05rem; text-shadow: 0 1px 4px rgba(0,0,0,0.8);">
          Offensive and defensive security, delivered with authorisation and care. Security is two-sided,
          and we work both sides. Every technique used to prove a weakness is also the technique that
          closes it.
        </p>
      </div>

    <details class="category" open>
      <summary class="category-header">
        <div class="category-accent" aria-hidden="true"></div>
          <h3>Security Assessment</h3>
          <span class="category-tag" data-side="offensive">Offensive</span>
        </summary>
        <div class="category-services">
          <div class="service">
            <h3><svg class="service-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>Penetration Testing</h3>
          <p>Simulating real-world attacks across web, mobile, network, and cloud environments to identify vulnerabilities before adversaries do. Every test is carried out with written authorisation, an agreed scope, and documented rules of engagement.</p>
        </div>
        <div class="service">
            <h3><svg class="service-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>Vulnerability Assessment</h3>
          <p>Systematic scanning and analysis of systems, networks, and applications to identify, prioritise, and remediate security weaknesses.</p>
        </div>
        <div class="service">
            <h3><svg class="service-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>Red Teaming</h3>
          <p>Full-scope adversarial simulations that test people, processes, and technology - going beyond automated tools to emulate real threat actors. Scoped and authorised up front, and run with the client's own response team on standby.</p>
        </div>
      </div>
    </details>

    <details class="category">
      <summary class="category-header">
        <div class="category-accent" aria-hidden="true"></div>
          <h3>Secure Development &amp; Cloud</h3>
          <span class="category-tag" data-side="defensive">Defensive</span>
        </summary>
        <div class="category-services">
          <div class="service">
            <h3><svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M6.75 7.5l3 2.25-3 2.25m4.5 0h3m-9 8.25h13.5A2.25 2.25 0 0 0 21 18V6a2.25 2.25 0 0 0-2.25-2.25H5.25A2.25 2.25 0 0 0 3 6v12a2.25 2.25 0 0 0 2.25 2.25Z"/></svg>Secure Software Development</h3>
          <p>Embedding security into every stage of the SDLC - from threat modelling and secure architecture reviews to code auditing and security testing.</p>
        </div>
        <div class="service">
            <h3><svg class="service-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg>DevSecOps &amp; Secure CI/CD</h3>
          <p>Integrating automated security gates, SAST/DAST tooling, and policy-as-code into development pipelines for continuous, shift-left security.</p>
        </div>
        <div class="service">
            <h3><svg class="service-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 10h-1.26A8 8 0 1 0 9 20h9a5 5 0 0 0 0-10z"/></svg>Cloud Security</h3>
          <p>Assessing and hardening cloud environments across AWS, Azure, and GCP - including posture management, identity security, and workload protection.</p>
        </div>
      </div>
    </details>

    <details class="category">
      <summary class="category-header">
        <div class="category-accent" aria-hidden="true"></div>
        <h3>Threat Intelligence &amp; Response</h3>
        <span class="category-tag" data-side="defensive">Defensive</span>
      </summary>
      <div class="category-services">
        <div class="service">
            <h3><svg class="service-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="4" y="4" width="16" height="16" rx="2" ry="2"/><rect x="9" y="9" width="6" height="6"/><line x1="9" y1="1" x2="9" y2="4"/><line x1="15" y1="1" x2="15" y2="4"/><line x1="9" y1="20" x2="9" y2="23"/><line x1="15" y1="20" x2="15" y2="23"/><line x1="20" y1="9" x2="23" y2="9"/><line x1="20" y1="14" x2="23" y2="14"/><line x1="1" y1="9" x2="4" y2="9"/><line x1="1" y1="14" x2="4" y2="14"/></svg>AI Threat Intelligence</h3>
          <p>Leveraging machine learning and data-driven analysis to detect, predict, and respond to emerging threats with context-aware intelligence pipelines.</p>
        </div>
        <div class="service">
            <h3><svg class="service-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>Incident Response &amp; Forensics</h3>
          <p>Rapid containment, eradication, and recovery from security breaches - supported by digital forensics to understand root cause and preserve evidence.</p>
        </div>
      </div>
    </details>

    <details class="category">
      <summary class="category-header">
        <div class="category-accent" aria-hidden="true"></div>
        <h3>Managed Security &amp; Advisory</h3>
        <span class="category-tag" data-side="defensive">Defensive</span>
      </summary>
      <div class="category-services">
        <div class="service">
            <h3><svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M9 12.75 11.25 15 15 9.75m-3-7.036A11.959 11.959 0 0 1 3.598 6 11.99 11.99 0 0 0 3 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285Z"/></svg>Managed Security Services (MSS)</h3>
          <p>24/7 monitoring, threat hunting, and security operations - providing enterprise-grade defence without the overhead of building an in-house SOC.</p>
        </div>
        <div class="service">
            <h3><svg class="service-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><circle cx="12" cy="12" r="6"/><circle cx="12" cy="12" r="2"/></svg>SOC Advisory</h3>
          <p>Helping organisations design, build, and mature their Security Operations Centres - from tool selection and workflow design to team skilling.</p>
        </div>
        <div class="service">
            <h3><svg class="service-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>Compliance &amp; Risk Advisory</h3>
          <p>Guidance on regulatory frameworks including POPIA, ISO 27001, and industry standards - helping organisations navigate compliance and manage cyber risk.</p>
        </div>
        <div class="service">
            <h3><svg class="service-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>Cybersecurity Consultancy</h3>
          <p>Strategic advisory covering security program design, technology selection, vendor evaluation, policy development, and board-level risk reporting for organisations of all sizes.</p>
        </div>
      </div>
    </details>

    <details class="category">
      <summary class="category-header">
        <div class="category-accent" aria-hidden="true"></div>
        <h3>Web3 &amp; Blockchain Security</h3>
        <span class="category-tag" data-side="offensive">Offensive</span>
      </summary>
      <div class="category-services">
        <div class="service">
            <h3><svg class="service-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/><polyline points="3.27 6.96 12 12.01 20.73 6.96"/><line x1="12" y1="22.08" x2="12" y2="12"/></svg>Smart Contract Auditing</h3>
          <p>Manual and automated review of smart contracts on Ethereum, Solana, and other chains - identifying logic flaws, gas optimisations, and vulnerability vectors before deployment.</p>
        </div>
        <div class="service">
            <h3><svg class="service-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"/><path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"/></svg>Blockchain Security Assessment</h3>
          <p>Evaluating consensus mechanisms, bridge protocols, tokenomics, and dApp architecture to ensure the integrity and resilience of Web3 infrastructure.</p>
        </div>
      </div>
    </details>

    <details class="category">
      <summary class="category-header">
        <div class="category-accent" aria-hidden="true"></div>
        <h3>Security Culture</h3>
        <span class="category-tag" data-side="defensive">Defensive</span>
      </summary>
      <div class="category-services">
        <div class="service">
            <h3><svg class="service-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>Security Awareness Training</h3>
          <p>Building a human firewall through engaging, context-relevant training programs that equip teams to recognise and respond to social engineering and phishing threats.</p>
        </div>
      </div>
    </details>
    </div><!-- /.dept-block cyber -->

    <div class="dept-block" data-dept="software" id="dept-software">
      <div style="background-image: linear-gradient(rgba(10, 10, 12, 0.8), rgba(10, 10, 12, 0.95)), url('{{ asset('assets/images/software_bg.jpg') }}'); background-size: cover; background-position: center; border-radius: 12px; padding: 2.5rem 2rem; margin-bottom: 2.5rem; border: 1px solid var(--border);">
        <div class="dept-heading" style="margin-bottom: 1rem;">
          <h2 style="margin: 0; text-shadow: 0 2px 10px rgba(0,0,0,0.5);">Software Engineering</h2>
        </div>
        <p style="color: rgba(255, 255, 255, 0.9); margin-bottom: 0; font-size: 1.05rem; text-shadow: 0 1px 4px rgba(0,0,0,0.8);">
          Applications, APIs and products, from the first prototype through handover and
          maintenance. This team built BizIntel and SiteSurveyor, so the way we work is visible in
          shipped software rather than promised in a brochure.
        </p>
      </div>

    <details class="category" open>
      <summary class="category-header">
        <div class="category-accent" aria-hidden="true"></div>
        <h3>Custom Software Development</h3>
      </summary>
      <div class="category-services">
        <div class="service">
          <h3><svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M6.75 7.5l3 2.25-3 2.25m4.5 0h3m-9 8.25h13.5A2.25 2.25 0 0 0 21 18V6a2.25 2.25 0 0 0-2.25-2.25H5.25A2.25 2.25 0 0 0 3 6v12a2.25 2.25 0 0 0 2.25 2.25Z"/></svg>Application Development</h3>
          <p>Web, desktop and mobile applications built against a stated specification, with handover documentation and a maintenance plan attached rather than offered later.</p>
        </div>
        <div class="service">
            <h3><svg class="service-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="2" width="20" height="8" rx="2" ry="2"/><rect x="2" y="14" width="20" height="8" rx="2" ry="2"/><line x1="6" y1="6" x2="6.01" y2="6"/><line x1="6" y1="18" x2="6.01" y2="18"/></svg>API &amp; Backend Systems</h3>
          <p>REST and event-driven services, data modelling, and third-party API integration. It is the layer most products actually depend on.</p>
        </div>
        <div class="service">
            <h3><svg class="service-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/></svg>Product &amp; Prototype Development</h3>
          <p>Turning an idea into something that runs. BizIntel and SiteSurveyor both started here, as specifications rather than feature lists.</p>
        </div>
        <div class="service">
            <h3><svg class="service-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"/></svg>Maintenance &amp; Support</h3>
          <p>Dependency upgrades, bug fixing, monitoring and iteration on systems we built or systems we inherited. Being maintainable by whoever comes next is part of the deliverable.</p>
        </div>
      </div>
    </details>

    <details class="category">
      <summary class="category-header">
        <div class="category-accent" aria-hidden="true"></div>
        <h3>Engineering Practice</h3>
      </summary>
      <div class="category-services">
        <div class="service">
            <h3><svg class="service-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"/></svg>Architecture &amp; Code Review</h3>
          <p>Design review and code review before the expensive stage, when a structural decision is still cheap to change.</p>
        </div>
        <div class="service">
            <h3><svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M9 12.75 11.25 15 15 9.75m-3-7.036A11.959 11.959 0 0 1 3.598 6 11.99 11.99 0 0 0 3 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285Z"/></svg>Secure by Construction</h3>
          <p>Every system we build is designed against the findings our security testing produces, so the defects we already know how to find are never introduced in the first place.</p>
        </div>
        <div class="service">
            <h3><svg class="service-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>Performance &amp; Scale</h3>
          <p>Profiling and optimisation against real workloads, rather than assumptions about where the bottleneck is.</p>
        </div>
      </div>
    </details>
    </div><!-- /.dept-block software -->

    <div class="dept-block" data-dept="three_d" id="dept-3d">
      <div style="background-image: linear-gradient(rgba(10, 10, 12, 0.8), rgba(10, 10, 12, 0.95)), url('{{ asset('assets/images/three_d_bg.jpg') }}'); background-size: cover; background-position: center; border-radius: 12px; padding: 2.5rem 2rem; margin-bottom: 2.5rem; border: 1px solid var(--border);">
        <div class="dept-heading" style="margin-bottom: 1rem;">
          <h2 style="margin: 0; text-shadow: 0 2px 10px rgba(0,0,0,0.5);">Creative Technology</h2>
        </div>
        <p style="color: rgba(255, 255, 255, 0.9); margin-bottom: 0; font-size: 1.05rem; text-shadow: 0 1px 4px rgba(0,0,0,0.8);">
          Making the invisible legible. An attack path, a system architecture or a survey dataset is
          easier to act on when it can be seen. We animate and design the motion, model what needs to
          be modelled, and build the frontend that runs it. One team, no handover between the
          design and the code.
        </p>
      </div>

    <details class="category" open>
      <summary class="category-header">
        <div class="category-accent" aria-hidden="true"></div>
        <h3>Creative Technology Services</h3>
      </summary>
      <div class="category-services">
        <div class="service">
          <h3><svg class="service-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/><polyline points="3.27 6.96 12 12.01 20.73 6.96"/><line x1="12" y1="22.08" x2="12" y2="12"/></svg>3D Modelling &amp; Asset Creation</h3>
          <p>Hard-surface and organic assets, modelled, textured and optimised for web or real-time use, delivered at the resolution and topology the target actually needs.</p>
        </div>
        <div class="service">
            <h3><svg class="service-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="23 7 16 12 23 17 23 7"/><rect x="1" y="5" width="15" height="14" rx="2" ry="2"/></svg>Animation &amp; Motion Design</h3>
          <p>Motion graphics, 2D and 3D sequences that explain a system, a process or a finding to someone who does not already hold the context. Storyboarded, animated and delivered at the length and format the channel needs.</p>
        </div>
        <div class="service">
            <h3><svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M6.75 7.5l3 2.25-3 2.25m4.5 0h3m-9 8.25h13.5A2.25 2.25 0 0 0 21 18V6a2.25 2.25 0 0 0-2.25-2.25H5.25A2.25 2.25 0 0 0 3 6v12a2.25 2.25 0 0 0 2.25 2.25Z"/></svg>Frontend Development</h3>
          <p>The interface the animation lands in. Component-based builds, design systems, scroll and transition choreography, and accessibility, all in the same codebase as the motion work, so what ships is what was designed.</p>
        </div>
        <div class="service">
            <h3><svg class="service-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 2 7 12 12 22 7 12 2"/><polyline points="2 17 12 22 22 17"/><polyline points="2 12 12 17 22 12"/></svg>Interactive 3D &amp; WebGL</h3>
          <p>Real-time browser scenes: explorable configurations, architecture walkthroughs and data visualisations that respond to input rather than playing a fixed video.</p>
        </div>
        <div class="service">
            <h3><svg class="service-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="5" y="2" width="14" height="20" rx="2" ry="2"/><line x1="12" y1="18" x2="12.01" y2="18"/></svg>Mobile &amp; Responsive Interfaces</h3>
          <p>The same discipline on a small screen. Touch-driven scenes, responsive layouts and performance budgets that hold on a mid-range Android, not just the machine it was designed on.</p>
        </div>
        <div class="service">
            <h3><svg class="service-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>Brand &amp; Product Visualisation</h3>
          <p>Product renders and visual assets for marketing, investor-facing material and technical documentation.</p>
        </div>
      </div>
    </details>
    </div><!-- /.dept-block three_d -->

    <p style="color: var(--color-text-dim); font-size: 0.95rem; margin: 3rem 0 0; text-align: center;">
      Not sure which capability fits? <a href="{{ route('contact') }}">Tell us the problem</a> and we
      will tell you which parts of the lab it needs.
    </p>
@endsection
