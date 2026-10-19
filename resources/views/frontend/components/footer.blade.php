<footer>
  <div class="wrap">
    <div class="foot">
      <div><a href="{{ route('home') }}#top" class="logo"><img src="{{ asset('assets/mark.png') }}" alt="" width="25" height="32">Zeebroo</a><p>The all-in-one platform to run, track and grow your business.</p></div>
      <div><h4>Explore</h4><ul><li><a href="{{ route('home') }}#benefits">Benefits</a></li><li><a href="{{ route('features.index') }}">Features</a></li><li><a href="{{ route('industries.index') }}">Industries</a></li><li><a href="{{ route('packages.index') }}">Pricing</a></li><li><a href="{{ route('partners.index') }}">Partners</a></li><li><a href="https://www.zeebroo.com/about">About</a></li><li><a href="{{ route('blog.index') }}">Blog</a></li></ul></div>
      <div><h4>Includes</h4><ul>@foreach ($navFeatures->where('group', 'core')->take(5) as $f)<li><a href="{{ route('features.show', $f->slug) }}">{{ $f->title }}</a></li>@endforeach</ul></div>
      <div><h4>Contact</h4><ul><li><a href="{{ route('contact') }}">Contact us</a></li><li><a href="mailto:hello@zeebroo.com">hello@zeebroo.com</a></li><li><a href="https://platform.zeebroo.com/">Sign in</a></li></ul></div>
    </div>
    <div class="foot-b"><span>&copy; <span id="yr"></span> Zeebroo. All rights reserved.</span><span>Built for business owners</span></div>
  </div>
</footer>