<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title', 'EINEVA Labs | Cybersecurity, Software Engineering & Animation - Zimbabwe')</title>
  <meta name="description" content="@yield('description', 'Cybersecurity research, software engineering, animation and frontend development. EINEVA Labs is an African technology research lab building, securing and explaining complex systems.')">
  <meta name="author" content="EINEVA Labs">
  <meta name="theme-color" content="#0a0a0f">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  @if(View::hasSection('canonical'))
  <link rel="canonical" href="@yield('canonical')">
  @endif
  <meta property="og:type" content="website">
  <meta property="og:url" content="@yield('og_url', url()->current())">
  <meta property="og:title" content="@yield('og_title', 'EINEVA Labs | Cybersecurity, Software Engineering & Animation - Zimbabwe')">
  <meta property="og:description" content="@yield('og_description', 'An African technology research lab. Cybersecurity, software engineering, animation and frontend development — under one roof, because the hard problems need all three.')">
  {{--
      The share card is a PNG, not the SVG it replaced: Facebook, LinkedIn,
      Slack and X do not render SVG og:images, so every shared link was
      rendering with no preview. The dimensions and type are declared because
      crawlers use them to lay the card out before fetching it.
  --}}
  <meta property="og:image" content="@yield('og_image', asset('assets/images/og-share.png'))">
  <meta property="og:image:type" content="@yield('og_image_type', 'image/png')">
  <meta property="og:image:width" content="1200">
  <meta property="og:image:height" content="630">
  <meta property="og:image:alt" content="EINEVA Labs - Cybersecurity, software engineering, animation and frontend development">
  <meta property="og:locale" content="en_ZW">
  <meta name="twitter:card" content="summary_large_image">
  <meta name="twitter:title" content="@yield('og_title', 'EINEVA Labs | Cybersecurity, Software Engineering & Animation - Zimbabwe')">
  <meta name="twitter:description" content="@yield('og_description', 'An African technology research lab. Cybersecurity, software engineering, animation and frontend development — under one roof, because the hard problems need all three.')">
  <meta name="twitter:image" content="@yield('og_image', asset('assets/images/og-share.png'))">
  @yield('robots')
  <link rel="manifest" href="{{ asset('manifest.json') }}">
  <link rel="stylesheet" href="{{ asset('assets/vendor/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/styles.css') }}">
  <link rel="icon" href="{{ asset('assets/logo/einevalabs.png') }}" type="image/png" />
  <link rel="shortcut icon" href="{{ asset('assets/logo/einevalabs.png') }}" type="image/png" />
  <link rel="apple-touch-icon" href="{{ asset('assets/logo/einevalabs.png') }}" />
  @yield('head')

  @if(View::hasSection('structured_data'))
  @yield('structured_data')
  @endif

<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-LWDW7M7KBX"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-LWDW7M7KBX');
</script>

</head>

<body>
  <nav class="topbar" aria-label="Primary">
    <div class="topbar__inner">
      <a href="{{ route('home') }}" class="topbar__brand" aria-label="EINEVA Labs home"><img src="{{ asset('assets/logo/einevalabs.png') }}" alt="" width="32" height="32"><span>EINEVA <span class="brand-accent">LABS</span></span></a>

      <button class="topbar__toggle" type="button" aria-label="Toggle navigation menu" aria-controls="navLinks" aria-expanded="false"><span></span></button>
      <div class="collapse topbar__menu" id="navLinks">
        <ul class="topbar__list">
          <li><a href="{{ route('home') }}" @if(Route::currentRouteName() === 'home') class="active" aria-current="page" @endif>Home</a></li>
          <li><a href="{{ route('about') }}" @if(Route::currentRouteName() === 'about') class="active" aria-current="page" @endif>About</a></li>
          <li><a href="{{ route('services') }}" @if(Route::currentRouteName() === 'services') class="active" aria-current="page" @endif>Services</a></li>
          <li><a href="{{ route('projects') }}" @if(Route::currentRouteName() === 'projects') class="active" aria-current="page" @endif>Projects</a></li>
          <li><a href="{{ route('team') }}" @if(Route::currentRouteName() === 'team') class="active" aria-current="page" @endif>Team</a></li>
          <li><a href="{{ route('posts.index') }}" @if(Str::startsWith(Route::currentRouteName(), 'posts.')) class="active" aria-current="page" @endif>Blog</a></li>
          <li><a href="{{ route('contact') }}" @if(Route::currentRouteName() === 'contact') class="active" aria-current="page" @endif>Contact</a></li>
        </ul>

        <div class="topbar__actions">
          <a href="{{ route('products.index') }}" class="btn btn-primary topbar__cta" title="EINEVA Marketplace" aria-label="EINEVA Marketplace, EINEVA Labs store">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg>
            <span class="sr-only">EINEVA Marketplace</span>
          </a>

          {{--
              The badge counted array_column($cart, 'quantity'), which
              array_filter() then removed any entry whose quantity was 0 -
              so the number shown was the count of lines, not of items, and
              it was wrong the moment a line hit zero.
          --}}
          @php($cartCount = collect(Session::get('cart', []))->sum(fn ($line) => is_array($line) ? (int) ($line['quantity'] ?? 0) : 0))
          @if($cartCount > 0)
            <a href="{{ route('products.cart') }}" class="topbar__cta topbar__cta--cart">
              <span class="sr-only">Cart, {{ $cartCount }} {{ Str::plural('item', $cartCount) }}</span>
              <span aria-hidden="true" style="position: relative; display: inline-flex;">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg>
                <span class="topbar__cta-badge" style="position: absolute; top: -8px; right: -10px; background: var(--color-red); padding: 0.15rem 0.3rem; border-radius: 9999px; font-size: 0.65rem; font-weight: 700; color: #fff; min-width: 1rem; text-align: center; line-height: 1;">{{ $cartCount }}</span>
              </span>
            </a>
          @endif
        </div>
      </div>
    </div>
  </nav>
  <div class="container">

    @if(session('success'))
    <div class="alert-success" role="alert" style="background:rgba(0,200,100,.12);border:1px solid rgba(0,200,100,.3);color:#0c6;padding:1rem 1.5rem;border-radius:.75rem;margin:2rem 0;text-align:center;font-weight:500;">
      {{ session('success') }}
    </div>
    @endif

    @if(session('error'))
    <div class="alert-error" role="alert" style="background:rgba(255,60,60,.12);border:1px solid rgba(255,60,60,.3);color:#f44;padding:1rem 1.5rem;border-radius:.75rem;margin:2rem 0;text-align:center;font-weight:500;">
      {{ session('error') }}
    </div>
    @endif

    @yield('content')

    <footer class="site-footer" style="padding: 5rem 0 2rem; margin-top: 5rem; border-top: 1px solid var(--color-border);">
      <div class="row g-4">
        <div class="col-lg-4 col-md-6">
          <a href="{{ route('home') }}" class="topbar__brand" style="display: inline-flex; align-items: center; gap: 0.65rem; font-family: var(--font-heading); font-size: 1.25rem; font-weight: 700; color: var(--color-heading); margin-bottom: 1.5rem; text-decoration: none;">
            <img src="{{ asset('assets/logo/einevalabs.png') }}" alt="" width="36" height="36" style="border-radius: var(--radius-sm); border: 1px solid var(--color-border-hover); filter: drop-shadow(0 4px 12px rgba(239, 68, 68, 0.22));">
            <span>EINEVA <span style="color: var(--color-red);">LABS</span></span>
          </a>
          <p style="color: var(--color-text-dim); font-size: 0.95rem; margin-bottom: 1.5rem; line-height: 1.6;">@yield('footer_tagline', 'Technology research, engineering and visualisation for Africa')</p>
          <div class="social" aria-label="Social media links" style="display: flex; gap: 1rem;">
            <a href="https://www.linkedin.com/in/consolemangena404/" target="_blank" rel="noopener" aria-label="LinkedIn" style="color: var(--color-icon); transition: color 0.2s;"><svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 0 1-2.063-2.065 2.064 2.064 0 1 1 2.063 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg></a>
            <a href="https://www.facebook.com/einevalabs/" target="_blank" rel="noopener" aria-label="Facebook" style="color: var(--color-icon); transition: color 0.2s;"><svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg></a>
            <a href="https://github.com/einevalabs" target="_blank" rel="noopener" aria-label="GitHub" style="color: var(--color-icon); transition: color 0.2s;"><svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12 .297c-6.63 0-12 5.373-12 12 0 5.303 3.438 9.8 8.205 11.385.6.113.82-.258.82-.577 0-.285-.01-1.04-.015-2.04-3.338.724-4.042-1.61-4.042-1.61C4.422 18.07 3.633 17.7 3.633 17.7c-1.087-.744.084-.729.084-.729 1.205.084 1.838 1.236 1.838 1.236 1.07 1.835 2.809 1.305 3.495.998.108-.776.417-1.305.76-1.605-2.665-.3-5.466-1.332-5.466-5.93 0-1.31.465-2.38 1.235-3.22-.135-.303-.54-1.523.105-3.176 0 0 1.005-.322 3.3 1.23.96-.267 1.98-.399 3-.405 1.02.006 2.04.138 3 .405 2.28-1.552 3.285-1.23 3.285-1.23.645 1.653.24 2.873.12 3.176.765.84 1.23 1.91 1.23 3.22 0 4.61-2.805 5.625-5.475 5.92.42.36.81 1.096.81 2.22 0 1.606-.015 2.896-.015 3.286 0 .315.21.69.825.57C20.565 22.092 24 17.592 24 12.297c0-6.627-5.373-12-12-12"/></svg></a>
          </div>
        </div>
        
        <div class="col-lg-2 col-md-3 col-6">
          <h4 style="font-family: var(--font-heading); font-size: 1.1rem; color: var(--color-heading); margin-bottom: 1.25rem;">Quick Links</h4>
          <ul style="list-style: none; padding: 0; display: flex; flex-direction: column; gap: 0.75rem; font-size: 0.95rem;">
            <li><a href="{{ route('home') }}" style="color: var(--color-text-dim); text-decoration: none;">Home</a></li>
            <li><a href="{{ route('services') }}" style="color: var(--color-text-dim); text-decoration: none;">Services</a></li>
            <li><a href="{{ route('posts.index') }}" style="color: var(--color-text-dim); text-decoration: none;">Blog</a></li>
            <li><a href="{{ route('ethics') }}" style="color: var(--color-text-dim); text-decoration: none;">Ethics</a></li>
            <li><a href="{{ route('contact') }}" style="color: var(--color-text-dim); text-decoration: none;">Contact Us</a></li>
          </ul>
        </div>
        
        <div class="col-lg-2 col-md-3 col-6">
          <h4 style="font-family: var(--font-heading); font-size: 1.1rem; color: var(--color-heading); margin-bottom: 1.25rem;">Contact</h4>
          <ul style="list-style: none; padding: 0; display: flex; flex-direction: column; gap: 0.75rem; font-size: 0.95rem;">
            <li><a href="mailto:info@eineva.co.zw" style="color: var(--color-text-dim); text-decoration: none;">info@eineva.co.zw</a></li>
            <li><a href="tel:+263789575175" style="color: var(--color-text-dim); text-decoration: none;">+263 78 957 5175</a></li>
            <li style="color: var(--color-text-dim);">Gweru, Zimbabwe</li>
          </ul>
        </div>
        
        <div class="col-lg-4 col-md-12">
          <h4 style="font-family: var(--font-heading); font-size: 1.1rem; color: var(--color-heading); margin-bottom: 1.25rem;">Newsletter</h4>
          <p style="color: var(--color-text-dim); font-size: 0.95rem; margin-bottom: 1.25rem;">Subscribe for research releases, project updates and lab news.</p>
          <form action="{{ route('newsletter.subscribe') }}" method="post" aria-label="Subscribe to newsletter" style="display: flex; gap: 0.5rem; max-width: 400px;">
            @csrf
            <input type="email" name="email" placeholder="Email address..." required style="flex: 1; border: 1px solid var(--color-border); padding: 0.6rem 1rem; border-radius: var(--radius-sm); background: var(--color-bg-card); color: inherit; font-family: inherit; font-size: 0.95rem; outline: none; min-width: 0;">
            <input type="checkbox" name="botcheck" class="hidden">
            <button type="submit" class="btn btn-primary" style="padding: 0.6rem 1.25rem; white-space: nowrap;">Subscribe</button>
          </form>
        </div>
      </div>
      
      <div style="margin-top: 4rem; padding-top: 1.5rem; border-top: 1px solid var(--color-border); display: flex; flex-wrap: wrap; justify-content: space-between; align-items: center; gap: 1rem; color: var(--color-text-muted); font-size: 0.85rem;">
        <p style="margin: 0;">&copy; {{ date('Y') }} EINEVA Labs. All rights reserved.</p>
        <div style="display: flex; gap: 1.5rem;">
          <a href="{{ route('privacy') }}" style="color: var(--color-text-muted); text-decoration: none;">Privacy Policy</a>
          <a href="{{ route('ethics') }}" style="color: var(--color-text-muted); text-decoration: none;">Ethics</a>
          <a href="{{ route('contact') }}" style="color: var(--color-text-muted); text-decoration: none;">Support</a>
        </div>
      </div>
    </footer>
  </div>

  <a href="https://wa.me/263789575175?text=Hello%20EINEVA%20Labs" target="_blank" rel="noopener" class="whatsapp-fab" aria-label="Chat with us on WhatsApp">
    <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/></svg>
  </a>
  <script src="{{ asset('assets/loader.js') }}" defer></script>
  @yield('scripts')
</body>

</html>
