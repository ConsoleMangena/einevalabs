@extends('layouts.app')

@section('title', 'Contact - EINEVA Labs | Cybersecurity Research Africa')
@section('description', 'Contact EINEVA Labs - Africa\'s dedicated cybersecurity research lab in Zimbabwe. Reach out for penetration testing, threat intelligence, and managed security.')
@section('canonical', 'https://eineva.co.zw/contact')
@section('og_url', 'https://eineva.co.zw/contact')
@section('og_title', 'Contact - EINEVA Labs | Cybersecurity Research Africa')
@section('og_description', 'Contact EINEVA Labs - Africa\'s dedicated cybersecurity research and innovation laboratory based in Gweru, Zimbabwe. Reach out to connect.')

@section('footer_tagline', 'Cybersecurity Research & Innovation for Africa')

@section('content')
    <!-- Hero -->
    <div class="contact-hero">
      <div class="hero-badge">Get In Touch</div>
      <h1 class="page-title">Contact Us</h1>
      <p class="page-sub">Ready to strengthen your cybersecurity posture? Reach out and let's talk.</p>
    </div>

    <!-- Info Cards row -->
    <div class="info-cards">
      <div class="row g-3">
        <div class="col-md-4">
          <div class="info-card">
            <div class="info-card-icon" aria-hidden="true"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="20" height="16" x="2" y="4" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg></div>
            <p class="label">Email</p>
            <p class="value"><a href="mailto:info@eineva.co.zw">info@eineva.co.zw</a></p>
          </div>
        </div>
        <div class="col-md-4">
          <div class="info-card">
            <div class="info-card-icon" aria-hidden="true"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/></svg></div>
            <p class="label">Phone</p>
            <p class="value"><a href="tel:+263781524929">+263 78 152 4929</a></p>
          </div>
        </div>
        <div class="col-md-4">
          <div class="info-card">
            <div class="info-card-icon" aria-hidden="true"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg></div>
            <p class="label">Location</p>
            <p class="value">Gweru, Zimbabwe</p>
          </div>
        </div>
      </div>
    </div>

    <!-- Two-column: Form + Sidebar -->
    <div class="contact-main">
      <div class="row g-4">
        <div class="col-lg-7">
          <form class="contact-form" action="{{ route('contact.submit') }}" method="post" aria-label="Send a message to EINEVA Labs">
            @csrf
            <p class="form-title">Send a message</p>
            <div class="row g-3">
              <div class="col-sm-6">
                <div class="field">
                  <label for="contact-name">Name</label>
                  <input type="text" id="contact-name" name="name" placeholder="Your name" autocomplete="name" required>
                </div>
              </div>
              <div class="col-sm-6">
                <div class="field">
                  <label for="contact-email">Email</label>
                  <input type="email" id="contact-email" name="email" placeholder="your@email.com" autocomplete="email" required>
                </div>
              </div>
            </div>
            <div class="field">
              <label for="contact-subject">Subject</label>
              <input type="text" id="contact-subject" name="subject" placeholder="What's it about?">
            </div>
            <div class="field">
              <label for="contact-message">Message</label>
              <textarea id="contact-message" name="message" placeholder="Tell us more..." required minlength="10" maxlength="5000"></textarea>
            </div>
            <input type="checkbox" name="botcheck" class="hidden">
            <button type="submit">Send message</button>
          </form>
        </div>
        <div class="col-lg-5">
          <div class="notice-card">
            <p class="notice-label">Ready to engage</p>
            <p>EINEVA Labs is fully operational and ready to engage. Feel free to reach out to us to discuss your cybersecurity needs.</p>
          </div>

          <div class="hours-card">
            <p class="hours-label">Response Hours</p>
            <div class="hours-row">
              <span class="hours-day">Monday — Friday</span>
              <span class="hours-time">08:00 — 17:00</span>
            </div>
            <div class="hours-row">
              <span class="hours-day">Saturday</span>
              <span class="hours-time">09:00 — 13:00</span>
            </div>
            <div class="hours-row">
              <span class="hours-day">Emergency</span>
              <span class="hours-time">24/7</span>
            </div>
          </div>
          
          <div class="notice-card" style="margin-top: 1.5rem;">
            <p class="notice-label">Subscribe to Newsletter</p>
            <p style="margin-bottom: 1rem; font-size: 0.95rem;">Get the latest cybersecurity research and updates delivered directly to your inbox.</p>
            <form action="{{ route('newsletter.subscribe') }}" method="post" class="subscribe-form" aria-label="Subscribe to newsletter">
              @csrf
              <div class="field" style="margin-bottom: 0.75rem;">
                <input type="email" name="email" placeholder="your@email.com" required style="width: 100%; border: 1px solid rgba(100,116,139,0.3); padding: 0.75rem 1rem; border-radius: 8px; background: transparent; color: inherit; font-family: inherit;">
              </div>
              <input type="checkbox" name="botcheck" class="hidden">
              <button type="submit" style="width: 100%; padding: 0.75rem; border-radius: 8px; font-weight: 600; cursor: pointer;">Subscribe</button>
            </form>
          </div>
        </div>
      </div>
    </div>
@endsection

@section('scripts')
  <script>
    (function() {
      var form = document.querySelector('.contact-form');
      if (!form) return;
      var btn = form.querySelector('button[type="submit"]');
      form.addEventListener('submit', function() {
        btn.textContent = 'Sending...';
        btn.disabled = true;
        btn.style.opacity = '0.7';
      });
    })();
  </script>
@endsection
