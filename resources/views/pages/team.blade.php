@extends('layouts.app')

@section('title', 'Team - EINEVA Labs | Cybersecurity Research Africa')
@section('description', 'Meet the team at EINEVA Labs - Africa\'s cybersecurity research lab. Specialists in offensive security, defense, threat intelligence, and secure engineering.')
@section('canonical', 'https://eineva.co.zw/team')
@section('og_url', 'https://eineva.co.zw/team')
@section('og_title', 'Team - EINEVA Labs | Cybersecurity Research Africa')
@section('og_description', 'Meet the team at EINEVA Labs - Africa\'s dedicated cybersecurity research laboratory. We are hiring 5 developers with strong cybersecurity understanding to build our platforms and products.')

@section('footer_tagline', 'Cybersecurity Research & Innovation for Africa')

@section('content')
    <div class="logo">
      <img src="{{ asset('assets/logo/einevalabs.png') }}" alt="EINEVA Labs" width="150" height="150" loading="eager" style="max-width: 100%; height: auto; filter: drop-shadow(0 0 15px rgba(239, 68, 68, 0.15)); display: inline-block;">
    </div>
    <h1 class="page-title">Our Team</h1>
    <p class="page-sub">Building Africa's cybersecurity research team - research and secure engineering. Hiring 5 specialists across offensive security, defense, intelligence, and platform security.</p>

    <div class="team-grid">
      <div class="team-card">
        <img src="{{ asset('assets/images/profile/founder2.jpg') }}" alt="Consolation Mangena, Founder and CEO" class="team-img" width="100" height="100" loading="lazy">
        <h3 class="name">Consolation Mangena</h3>
        <p class="role">Founder &amp; CEO</p>
        <span class="status filled">Filled</span>
        <p>Visionary behind EINEVA Labs. Driving cybersecurity research and capacity building for Africa.</p>
      </div>

      <div class="team-card">
        <div class="placeholder-img" aria-hidden="true">+</div>
        <h3 class="name">Penetration Tester</h3>
        <p class="role">Offensive Security</p>
        <span class="status vacant">Vacant</span>
        <p>Lead and execute penetration tests across web, network, and infrastructure. Replicate adversary TTPs, produce actionable reports, and help clients harden their defences against real-world attacks.</p>
        <a href="mailto:careers@eineva.co.zw?subject=Penetration%20Tester%20Application" class="apply-btn">Apply now &rarr;</a>
      </div>

      <div class="team-card">
        <div class="placeholder-img" aria-hidden="true">+</div>
        <h3 class="name">Security Analyst</h3>
        <p class="role">SOC &amp; Blue Team</p>
        <span class="status vacant">Vacant</span>
        <p>Monitor, triage, and investigate security alerts across our client environments. Tune SIEM detections, hunt for threats in logs, and lead first-line incident response for active compromises.</p>
        <a href="mailto:careers@eineva.co.zw?subject=Security%20Analyst%20Application" class="apply-btn">Apply now &rarr;</a>
      </div>

      <div class="team-card">
        <div class="placeholder-img" aria-hidden="true">+</div>
        <h3 class="name">Threat Intelligence Researcher</h3>
        <p class="role">Intelligence &amp; Research</p>
        <span class="status vacant">Vacant</span>
        <p>Track APTs, malware campaigns, and emerging IOCs - with a focus on threats targeting African organisations. Produce intelligence reports, dashboards, and early-warning briefings for clients and the community.</p>
        <a href="mailto:careers@eineva.co.zw?subject=Threat%20Intelligence%20Researcher%20Application" class="apply-btn">Apply now &rarr;</a>
      </div>

      <div class="team-card">
        <div class="placeholder-img" aria-hidden="true">+</div>
        <h3 class="name">Application Security Engineer</h3>
        <p class="role">Secure Software</p>
        <span class="status vacant">Vacant</span>
        <p>Embed security in every layer of the platforms we build and the products we ship. Code review, threat modelling, secure-by-default design, and partnering with engineering to harden features end-to-end.</p>
        <a href="mailto:careers@eineva.co.zw?subject=Application%20Security%20Engineer%20Application" class="apply-btn">Apply now &rarr;</a>
      </div>

      <div class="team-card">
        <div class="placeholder-img" aria-hidden="true">+</div>
        <h3 class="name">DevSecOps Engineer</h3>
        <p class="role">Infrastructure &amp; Pipelines</p>
        <span class="status vacant">Vacant</span>
        <p>Own the CI/CD pipeline and the security gates in between - SAST/DAST, secrets management, infrastructure-as-code, and policy-as-code across every deployment we make and every environment we monitor.</p>
        <a href="mailto:careers@eineva.co.zw?subject=DevSecOps%20Engineer%20Application" class="apply-btn">Apply now &rarr;</a>
      </div>
    </div>

    <p class="team-note">
      We research threats and engineer the tools that defend against them.
    </p>
@endsection
