@extends('layouts.app')

@section('title', 'Team - EINEVA Labs | Technology Research, Africa')
@section('description', 'EINEVA Labs is founded by Tatenda Mangena (CEO) and Consolation Mangena (CTO) - an African technology research lab working across cybersecurity, software engineering, and animation, motion design and frontend development. Three roles open.')
@section('canonical', 'https://eineva.co.zw/team')
@section('og_url', 'https://eineva.co.zw/team')
@section('og_title', 'Team - EINEVA Labs | Technology Research, Africa')
@section('og_description', 'EINEVA Labs is founded by Tatenda Mangena (CEO) and Consolation Mangena (CTO). Three open roles across offensive security, software engineering, and animation and frontend development.')

@section('footer_tagline', 'Technology research, engineering and visualisation for Africa')

@section('content')
    <div class="logo">
      <img src="{{ asset('assets/logo/einevalabs.png') }}" alt="EINEVA Labs" width="150" height="150" loading="eager" style="max-width: 100%; height: auto; filter: drop-shadow(0 0 15px rgba(239, 68, 68, 0.15)); display: inline-block;">
    </div>
    <h1 class="page-title">Our Team</h1>
    <p class="page-sub">Two founders, three open roles. We hire specialists who want their work shipped rather than described.</p>

    <div class="team-grid">
      <div class="team-card">
        <div class="placeholder-img" aria-hidden="true">+</div>
        <h3 class="name">Tatenda Mangena</h3>
        <p class="role">Founder &amp; Chief Executive Officer</p>
        <div style="display: flex; gap: 0.5rem; margin-bottom: 0.7rem; align-items: center;">
          <span class="status filled" style="margin-bottom: 0;">Filled</span>
        </div>
        <p>Founded EINEVA Labs to build African technical capacity across security, engineering and visualisation. Leads the lab's direction, its research agenda, and its relationships with the organisations that depend on it.</p>
      </div>

      <div class="team-card">
        <img src="{{ asset('assets/images/profile/founder2.jpg') }}" alt="Consolation Mangena, Co-Founder and Chief Technology Officer" class="team-img" width="100" height="100" loading="lazy">
        <h3 class="name">Consolation Mangena</h3>
        <p class="role">Co-Founder &amp; Chief Technology Officer</p>
        <div style="display: flex; gap: 0.5rem; margin-bottom: 0.7rem; align-items: center;">
          <span class="status filled" style="margin-bottom: 0;">Filled</span>
        </div>
        <p>Co-founded the lab and owns the technology across every part of it. Sets the engineering and research practice, runs the offensive and defensive security work, and leads the software and creative technology teams building the lab's own products.</p>
      </div>

      <div class="team-card">
        <div class="placeholder-img" aria-hidden="true">+</div>
        <h3 class="name">Penetration Tester</h3>
        <p class="role">Offensive Security</p>
        <div style="display: flex; gap: 0.5rem; margin-bottom: 0.7rem; align-items: center;">
          <span class="dept-tag" data-dept="cyber" style="margin-bottom: 0;">Cybersecurity</span>
          <span class="status vacant" style="margin-bottom: 0;">Vacant</span>
        </div>
        <p>Lead and execute penetration tests across web, mobile, API, cloud and network. Replicate adversary TTPs, produce findings a client can act on, and help engineering teams close them.</p>
        <a href="mailto:careers@eineva.co.zw?subject=Penetration%20Tester%20Application" class="apply-btn">Apply now &rarr;</a>
      </div>

      <div class="team-card">
        <div class="placeholder-img" aria-hidden="true">+</div>
        <h3 class="name">Backend / API Engineer</h3>
        <p class="role">Software Engineering</p>
        <div style="display: flex; gap: 0.5rem; margin-bottom: 0.7rem; align-items: center;">
          <span class="dept-tag" data-dept="software" style="margin-bottom: 0;">Software Engineering</span>
          <span class="status vacant" style="margin-bottom: 0;">Vacant</span>
        </div>
        <p>Build the services our products run on: REST and event-driven APIs, data models, and third-party integrations. Strong PHP, Python, Rust or Go, and opinions about testing. You'll work on our own products, BizIntel and SiteSurveyor, not just client work.</p>
        <a href="mailto:careers@eineva.co.zw?subject=Backend%20API%20Engineer%20Application" class="apply-btn">Apply now &rarr;</a>
      </div>

      <div class="team-card">
        <div class="placeholder-img" aria-hidden="true">+</div>
        <h3 class="name">Animator &amp; Frontend Developer</h3>
        <p class="role">Animation, Motion &amp; Frontend Development</p>
        <div style="display: flex; gap: 0.5rem; margin-bottom: 0.7rem; align-items: center;">
          <span class="dept-tag" data-dept="three_d" style="margin-bottom: 0;">Creative Technology</span>
          <span class="status vacant" style="margin-bottom: 0;">Vacant</span>
        </div>
        <p>Animate and design motion for technical explainers: attack paths, system architectures and datasets that have to be legible, not just pretty. Then build the frontend that runs it. 3D modelling and WebGL where the brief needs them.</p>
        <a href="mailto:careers@eineva.co.zw?subject=Animator%20Frontend%20Developer%20Application" class="apply-btn">Apply now &rarr;</a>
      </div>
    </div>

    <p class="team-note">
      We research threats, engineer the tools that defend against them, and render both so people can see what changed.
    </p>
@endsection
