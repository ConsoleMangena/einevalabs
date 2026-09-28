@extends('layouts.app')

@section('title', 'Page Not Found – EINEVA Labs')
@section('description', 'The page you are looking for could not be found. Return to EINEVA Labs homepage or explore our cybersecurity capabilities.')
@section('robots')
  <meta name="robots" content="noindex, nofollow">
@endsection

@section('content')
    <div class="logo">
      <img src="{{ asset('assets/logo/einevalabs.png') }}" alt="EINEVA Labs" width="150" height="150" loading="eager" style="max-width: 100%; height: auto; filter: drop-shadow(0 0 15px rgba(239, 68, 68, 0.15)); display: inline-block;">
    </div>

    <div class="error-code" role="status" aria-label="Error 404">404</div>
    <h1 class="error-title">Page not found</h1>
    <p class="error-msg">
      The page you are looking for might have been moved, renamed, or is temporarily unavailable.
      Check the URL or head back to the homepage.
    </p>

    <div class="error-actions">
      <a href="{{ route('home') }}" class="primary">Back to Home</a>
      <a href="{{ route('contact') }}">Contact Us</a>
      <a href="{{ route('services') }}">Our Capabilities</a>
    </div>
@endsection
