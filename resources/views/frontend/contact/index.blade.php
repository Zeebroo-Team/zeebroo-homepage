@extends('layouts.frontend')

@section('title', 'Contact Zeebroo: talk to our team')
@section('description', 'Questions about Zeebroo POS, pricing or a demo? Send us a message and our team will get back to you.')

@section('content')
<!-- CONTACT -->
<section class="contact">
  <div class="wrap">
    <div class="head">
      <span class="label">Contact us</span>
      <h1>Let's talk about your business.</h1>
      <p>Tell us how you work today and we'll show you how Zeebroo fits. We usually reply within one business day.</p>
    </div>

    <div class="contact-grid">
      <aside class="contact-side">
        <span class="mega-ic"><i class="fa-solid fa-headset"></i></span>
        <h2>Talk to a real person</h2>
        <p>Book a demo, ask about pricing, or get help setting up your shop.</p>
        <ul class="contact-ways">
          <li><span><i class="fa-regular fa-envelope"></i></span><div><small>Email us</small><a href="mailto:hello@zeebroo.com">hello@zeebroo.com</a></div></li>
          <li><span><i class="fa-solid fa-book-open"></i></span><div><small>Guides and tutorials</small><a href="https://www.zeebroo.com/tutorial">Read the docs</a></div></li>
          <li><span><i class="fa-solid fa-right-to-bracket"></i></span><div><small>Already a customer?</small><a href="https://platform.zeebroo.com/login">Sign in to Zeebroo</a></div></li>
        </ul>
        <img class="contact-art" src="{{ asset('assets/ufo.webp') }}" alt="" width="179" height="187" loading="lazy">
      </aside>

      <div class="contact-card">
        @if (session('contact_sent'))
          <div class="contact-ok" role="status">
            <span><i class="fa-solid fa-check"></i></span>
            <h3>Thanks, your message is on its way.</h3>
            <p>Our team will get back to you by email shortly.</p>
            <a class="btn btn-line" href="{{ route('home') }}">Back to home</a>
          </div>
        @else
          <form class="contact-form" method="POST" action="{{ route('contact.store') }}" novalidate>
            @csrf
            <div class="hp" aria-hidden="true"><label>Website <input type="text" name="website" tabindex="-1" autocomplete="off"></label></div>

            <div class="f-row">
              <label class="f">
                <span>Full name *</span>
                <input type="text" name="name" value="{{ old('name') }}" autocomplete="name" required>
                @error('name')<em>{{ $message }}</em>@enderror
              </label>
              <label class="f">
                <span>Email *</span>
                <input type="email" name="email" value="{{ old('email') }}" autocomplete="email" required>
                @error('email')<em>{{ $message }}</em>@enderror
              </label>
            </div>
            <div class="f-row">
              <label class="f">
                <span>Phone</span>
                <input type="tel" name="phone" value="{{ old('phone') }}" autocomplete="tel">
                @error('phone')<em>{{ $message }}</em>@enderror
              </label>
              <label class="f">
                <span>Business name</span>
                <input type="text" name="business" value="{{ old('business') }}" autocomplete="organization">
                @error('business')<em>{{ $message }}</em>@enderror
              </label>
            </div>

            <fieldset class="f">
              <legend>How can we help? *</legend>
              <div class="topics">
                @foreach ($topics as $key => $label)
                  <label class="topic"><input type="radio" name="topic" value="{{ $key }}" @checked(old('topic', 'demo') === $key)><span>{{ $label }}</span></label>
                @endforeach
              </div>
              @error('topic')<em>{{ $message }}</em>@enderror
            </fieldset>

            <label class="f">
              <span>Message *</span>
              <textarea name="message" rows="5" required placeholder="Tell us about your business and what you need.">{{ old('message') }}</textarea>
              @error('message')<em>{{ $message }}</em>@enderror
            </label>

            <button class="btn btn-ink" type="submit">Send message <i class="fa-solid fa-arrow-right"></i></button>
          </form>
        @endif
      </div>
    </div>
  </div>
</section>
@endsection
