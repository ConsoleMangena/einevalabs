@extends('layouts.app')

@section('title', 'Cybersecurity Capabilities - EINEVA Labs | Africa')
@section('description', 'EINEVA Labs cybersecurity: penetration testing, vulnerability assessment, red teaming, secure SDLC, AI threat intel, incident response, SOC advisory.')
@section('canonical', 'https://eineva.co.zw/services')
@section('og_url', 'https://eineva.co.zw/services')
@section('og_title', 'Cybersecurity Capabilities - EINEVA Labs | Africa')
@section('og_description', 'EINEVA Labs cybersecurity capabilities: penetration testing, secure development, threat intelligence, managed security services, and more - building capacity for Africa.')

@section('footer_tagline', 'Cybersecurity Research & Innovation for Africa')

@section('content')
    <div class="logo">
      <img src="{{ asset('assets/logo/einevalabs.png') }}" alt="EINEVA Labs" width="150" height="150" loading="eager" style="max-width: 100%; height: auto; filter: drop-shadow(0 0 15px rgba(239, 68, 68, 0.15)); display: inline-block;">
    </div>
    <h1 class="page-title">Capabilities</h1>
    <p class="page-sub">Building a comprehensive cybersecurity practice for Africa</p>

    <details class="category" open>
      <summary class="category-header">
        <div class="category-accent" aria-hidden="true"></div>
          <h2>Security Assessment</h2>
        </summary>
        <div class="category-services">
          <div class="service">
            <h3><span class="service-icon">&#x1F50D;</span>Penetration Testing</h3>
          <p>Simulating real-world attacks across web, mobile, network, and cloud environments to identify vulnerabilities before adversaries do.</p>
        </div>
        <div class="service">
            <h3><span class="service-icon">&#x1F4CA;</span>Vulnerability Assessment</h3>
          <p>Systematic scanning and analysis of systems, networks, and applications to identify, prioritise, and remediate security weaknesses.</p>
        </div>
        <div class="service">
            <h3><span class="service-icon">&#x1F6E1;</span>Red Teaming</h3>
          <p>Full-scope adversarial simulations that test people, processes, and technology - going beyond automated tools to emulate real threat actors.</p>
        </div>
      </div>
    </details>

    <details class="category">
      <summary class="category-header">
        <div class="category-accent" aria-hidden="true"></div>
          <h2>Secure Development &amp; Cloud</h2>
        </summary>
        <div class="category-services">
          <div class="service">
            <h3><span class="service-icon">&#x1F4BB;</span>Secure Software Development</h3>
          <p>Embedding security into every stage of the SDLC - from threat modelling and secure architecture reviews to code auditing and security testing.</p>
        </div>
        <div class="service">
            <h3><span class="service-icon">&#x26A1;</span>DevSecOps &amp; Secure CI/CD</h3>
          <p>Integrating automated security gates, SAST/DAST tooling, and policy-as-code into development pipelines for continuous, shift-left security.</p>
        </div>
        <div class="service">
            <h3><span class="service-icon">&#x2601;</span>Cloud Security</h3>
          <p>Assessing and hardening cloud environments across AWS, Azure, and GCP - including posture management, identity security, and workload protection.</p>
        </div>
      </div>
    </details>

    <details class="category">
      <summary class="category-header">
        <div class="category-accent" aria-hidden="true"></div>
        <h2>Threat Intelligence &amp; Response</h2>
      </summary>
      <div class="category-services">
        <div class="service">
            <h3><span class="service-icon">&#x1F9E0;</span>AI Threat Intelligence</h3>
          <p>Leveraging machine learning and data-driven analysis to detect, predict, and respond to emerging threats with context-aware intelligence pipelines.</p>
        </div>
        <div class="service">
            <h3><span class="service-icon">&#x1F4DD;</span>Incident Response &amp; Forensics</h3>
          <p>Rapid containment, eradication, and recovery from security breaches - supported by digital forensics to understand root cause and preserve evidence.</p>
        </div>
      </div>
    </details>

    <details class="category">
      <summary class="category-header">
        <div class="category-accent" aria-hidden="true"></div>
        <h2>Managed Security &amp; Advisory</h2>
      </summary>
      <div class="category-services">
        <div class="service">
            <h3><span class="service-icon">&#x1F6E0;</span>Managed Security Services (MSS)</h3>
          <p>24/7 monitoring, threat hunting, and security operations - providing enterprise-grade defence without the overhead of building an in-house SOC.</p>
        </div>
        <div class="service">
            <h3><span class="service-icon">&#x1F3AF;</span>SOC Advisory</h3>
          <p>Helping organisations design, build, and mature their Security Operations Centres - from tool selection and workflow design to team skilling.</p>
        </div>
        <div class="service">
            <h3><span class="service-icon">&#x1F4CB;</span>Compliance &amp; Risk Advisory</h3>
          <p>Guidance on regulatory frameworks including POPIA, ISO 27001, and industry standards - helping organisations navigate compliance and manage cyber risk.</p>
        </div>
        <div class="service">
            <h3><span class="service-icon">&#x1F4AC;</span>Cybersecurity Consultancy</h3>
          <p>Strategic advisory covering security program design, technology selection, vendor evaluation, policy development, and board-level risk reporting for organisations of all sizes.</p>
        </div>
      </div>
    </details>

    <details class="category">
      <summary class="category-header">
        <div class="category-accent" aria-hidden="true"></div>
        <h2>Web3 &amp; Blockchain Security</h2>
      </summary>
      <div class="category-services">
        <div class="service">
            <h3><span class="service-icon">&#x1F3DB;</span>Smart Contract Auditing</h3>
          <p>Manual and automated review of smart contracts on Ethereum, Solana, and other chains - identifying logic flaws, gas optimisations, and vulnerability vectors before deployment.</p>
        </div>
        <div class="service">
            <h3><span class="service-icon">&#x26D3;</span>Blockchain Security Assessment</h3>
          <p>Evaluating consensus mechanisms, bridge protocols, tokenomics, and dApp architecture to ensure the integrity and resilience of Web3 infrastructure.</p>
        </div>
      </div>
    </details>

    <details class="category">
      <summary class="category-header">
        <div class="category-accent" aria-hidden="true"></div>
        <h2>Security Culture</h2>
      </summary>
      <div class="category-services">
        <div class="service">
            <h3><span class="service-icon">&#x1F3AD;</span>Security Awareness Training</h3>
          <p>Building a human firewall through engaging, context-relevant training programs that equip teams to recognise and respond to social engineering and phishing threats.</p>
        </div>
      </div>
    </details>
@endsection
