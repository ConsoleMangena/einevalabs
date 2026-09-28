(function () {
  'use strict';

  function ensureLoader() {
    var loader = document.getElementById('bizLoader');
    if (loader) return loader;

    loader = document.createElement('div');
    loader.id = 'bizLoader';
    loader.className = 'biz-loader';
    loader.setAttribute('role', 'status');
    loader.setAttribute('aria-live', 'polite');
    loader.setAttribute('aria-hidden', 'true');
    loader.innerHTML =
      '<div class="biz-loader-card">' +
        '<div class="biz-spinner" aria-hidden="true">' +
          '<div class="biz-spinner-ring biz-spinner-ring--outer"></div>' +
          '<div class="biz-spinner-ring biz-spinner-ring--inner"></div>' +
          '<div class="biz-spinner-dot"></div>' +
        '</div>' +
      '</div>';

    document.body.appendChild(loader);
    return loader;
  }

  function show() {
    var loader = ensureLoader();
    loader.classList.remove('success');
    loader.setAttribute('aria-hidden', 'false');
    loader.classList.add('show');
  }

  function hide() {
    var loader = document.getElementById('bizLoader');
    if (!loader) return;
    loader.classList.remove('show', 'success');
    loader.setAttribute('aria-hidden', 'true');
    document.body.classList.add('is-loaded');
  }

  function isInternalHtmlLink(a) {
    if (!a) return false;
    if (a.target && a.target !== '_self') return false;
    if (a.hasAttribute('download')) return false;
    if (a.hasAttribute('data-no-loader')) return false;
    var href = a.getAttribute('href');
    if (!href) return false;
    if (/^(https?:|mailto:|tel:|javascript:|#)/i.test(href)) return false;
    return /\.html?(\?|#|$)/i.test(href);
  }

  function bindLinkClicks() {
    document.addEventListener('click', function (e) {
      var el = e.target;
      while (el && el !== document) {
        if (el.tagName === 'A') {
          if (isInternalHtmlLink(el)) show();
          return;
        }
        el = el.parentElement;
      }
    });
  }

  function bindFormSubmit() {
    document.addEventListener('submit', function () { show(); });
  }

  function onReady() {
    bindLinkClicks();
    bindFormSubmit();
  }

  if (document.readyState === 'complete') {
    onReady();
    document.body.classList.add('is-loaded');
  } else if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', onReady);
  } else {
    onReady();
  }

  if (document.readyState !== 'complete') {
    show();
    window.addEventListener('load', hide);
  }

  window.addEventListener('pageshow', function (e) {
    if (e.persisted) {
      hide();
      document.body.classList.add('is-loaded');
    }
  });

  window.bizLoader = { show: show, hide: hide };
})();

/* ===== Topbar: scroll state + mobile menu ===== */
(function () {
  'use strict';

  function initTopbar() {
    var bar = document.querySelector('.topbar');
    if (!bar) return;
    var toggle = bar.querySelector('.topbar__toggle');
    var menu = bar.querySelector('.topbar__menu');

    function onScroll() {
      if (window.scrollY > 8) { bar.classList.add('is-scrolled'); }
      else { bar.classList.remove('is-scrolled'); }
    }
    onScroll();
    window.addEventListener('scroll', onScroll, { passive: true });

    if (!toggle || !menu) return;

    /* Bootstrap's .collapse pairs with .show for visibility.
       No Bootstrap JS is loaded; this drives the class directly. */
    function setOpen(open) {
      if (open) { menu.classList.add('show'); }
      else { menu.classList.remove('show'); }
      toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
    }

    toggle.addEventListener('click', function () {
      setOpen(!menu.classList.contains('show'));
    });

    menu.addEventListener('click', function (e) {
      var el = e.target;
      while (el && el !== menu) {
        if (el.tagName === 'A') { setOpen(false); return; }
        el = el.parentElement;
      }
    });

    document.addEventListener('click', function (e) {
      if (!bar.contains(e.target)) setOpen(false);
    });

    document.addEventListener('keydown', function (e) {
      if (e.key === 'Escape') setOpen(false);
    });
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initTopbar);
  } else {
    initTopbar();
  }
})();

/* ===== Theme =====
   Same mechanism as the reference build: a single `.lm` class on <html>
   carries the light palette, so switching is one classList write and every
   themed rule follows. The icon swap is done in CSS off that same class, so
   there is no way for the button and the applied theme to drift apart.

   The stored choice is applied by a blocking snippet in <head> before first
   paint; this module only re-applies it and owns the click handler. */
(function () {
  'use strict';

  var KEY = 'eineva-theme';
  var root = document.documentElement;
  var META = { dark: '#0a0a0f', light: '#f7f7fa' };

  function stored() {
    try { return localStorage.getItem(KEY); } catch (e) { return null; }
  }

  function remember(theme) {
    try { localStorage.setItem(KEY, theme); } catch (e) { /* private mode */ }
  }

  function isLight() {
    return root.classList.contains('lm');
  }

  function sync(btn) {
    var theme = isLight() ? 'light' : 'dark';
    var meta = document.querySelector('meta[name="theme-color"]');
    if (meta) meta.setAttribute('content', META[theme]);
    if (!btn) return;
    /* aria-pressed reports the state of the control the label describes, and
       the label names the action, so both are needed to stay unambiguous. */
    btn.setAttribute('aria-pressed', theme === 'light' ? 'true' : 'false');
    btn.setAttribute('aria-label', theme === 'light' ? 'Switch to dark theme' : 'Switch to light theme');
    btn.setAttribute('title', theme === 'light' ? 'Switch to dark theme' : 'Switch to light theme');
  }

  function apply(theme, btn) {
    root.classList.toggle('lm', theme === 'light');
    sync(btn);
  }

  function setTheme(theme) {
    var btn = document.getElementById('thbtn');
    apply(theme, btn);
    remember(theme);
    return theme;
  }

  function initTheme() {
    var btn = document.getElementById('thbtn');
    apply(isLight() ? 'light' : 'dark', btn);
    if (!btn) return;
    btn.addEventListener('click', function () {
      setTheme(isLight() ? 'dark' : 'light');
    });

    /* Follow the OS only while the visitor has not expressed a preference of
       their own, so an explicit choice is never silently overridden. */
    if (!stored() && window.matchMedia) {
      var mq = window.matchMedia('(prefers-color-scheme: light)');
      var onChange = function (e) {
        if (!stored()) apply(e.matches ? 'light' : 'dark', btn);
      };
      if (mq.addEventListener) mq.addEventListener('change', onChange);
      else if (mq.addListener) mq.addListener(onChange);
    }
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initTheme);
  } else {
    initTheme();
  }

  window.einevaTheme = {
    toggle: function () { return setTheme(isLight() ? 'dark' : 'light'); },
    set: setTheme,
    current: function () { return isLight() ? 'light' : 'dark'; }
  };
})();

/* ===== Scroll reveal =====
   The `.rv` class is only ever added from here, so with JavaScript disabled
   every element stays visible. Siblings cascade via a --rv-d delay, and
   elements already in the viewport on load are revealed by the observer on
   its first callback. */
(function () {
  'use strict';

  var REVEAL = [
    '.hero-section > .row',
    '.about-hero > .row',
    '.contact-hero > .row',
    '.product-hero > .row',
    '.page-title', '.logo',
    '.divider', '.section-title',
    '.stat-card', '.mv-card', '.timeline-item',
    '.project-card', '.team-card',
    '.info-card', '.notice-card', '.hours-card', '.contact-form',
    '.status-banner', '.category', '.notify-band', '.legal-section',
    '.social', '.contact', '.error-code', '.error-actions'
  ].join(',');

  var STEP = 70;
  var CAP = 6;

  function reducedMotion() {
    return !!(window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches);
  }

  function initReveal() {
    if (reducedMotion()) return;

    var found = Array.prototype.slice.call(document.querySelectorAll(REVEAL));

    /* Nested targets would animate twice and double the movement, so keep
       only the outermost node of each chain. */
    var nodes = found.filter(function (el) {
      return !found.some(function (other) {
        return other !== el && other.contains(el);
      });
    });

    if (!nodes.length) return;

    var counts = new Map();
    nodes.forEach(function (el) {
      var parent = el.parentNode;
      var n = counts.get(parent) || 0;
      counts.set(parent, n + 1);
      el.style.setProperty('--rv-d', Math.min(n, CAP) * STEP + 'ms');
      el.classList.add('rv');
    });

    if (!('IntersectionObserver' in window)) {
      nodes.forEach(function (el) { el.classList.add('in'); });
      return;
    }

    var io = new IntersectionObserver(function (entries) {
      entries.forEach(function (entry) {
        if (!entry.isIntersecting) return;
        entry.target.classList.add('in');
        io.unobserve(entry.target);
      });
    }, { threshold: 0.1, rootMargin: '0px 0px -40px 0px' });

    nodes.forEach(function (el) { io.observe(el); });
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initReveal);
  } else {
    initReveal();
  }
})();
