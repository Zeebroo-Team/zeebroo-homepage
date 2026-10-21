<footer>
  <div class="wrap">
    <div class="foot">
      <div><a href="{{ route('home') }}#top" class="logo"><img src="{{ asset('assets/mark.png') }}" alt="" width="25" height="32">Zeebroo</a><p>ඔබේ ව්‍යාපාරය පවත්වාගෙන යාමට, නිරීක්ෂණය කිරීමට සහ වර්ධනය කිරීමට සියල්ල එකම වේදිකාවක.</p></div>
      <div><h4>නිෂ්පාදනය</h4><ul><li><a href="{{ route('home') }}#benefits">ප්‍රතිලාභ</a></li><li><a href="{{ route('features.index') }}">විශේෂාංග</a></li><li><a href="{{ route('industries.index') }}">ව්‍යාපාර ක්ෂේත්‍ර</a></li><li><a href="{{ route('packages.index') }}">මිල ගණන්</a></li></ul></div>
      <div><h4>සමාගම</h4><ul><li><a href="{{ route('about') }}">අප ගැන</a></li><li><a href="{{ route('partners.index') }}">හවුල්කරුවන්</a></li><li><a href="{{ route('testimonials.index') }}">ප්‍රතිචාර</a></li><li><a href="{{ route('blog.index') }}">බ්ලොග්</a></li></ul></div>
      <div><h4>ඇතුළත් වන්නේ</h4><ul>@foreach ($navFeatures->where('group', 'core')->take(5) as $f)<li><a href="{{ route('features.show', $f->slug) }}">{{ $f->title }}</a></li>@endforeach</ul></div>
      <div><h4>සම්බන්ධතා</h4><ul><li><a href="{{ route('contact') }}">අප අමතන්න</a></li><li><a href="mailto:hello@zeebroo.com">hello@zeebroo.com</a></li><li><a href="https://platform.zeebroo.com/">පිවිසෙන්න</a></li></ul></div>
    </div>
    <div class="foot-b"><span>&copy; <span id="yr"></span> Zeebroo. සියලු හිමිකම් ඇවිරිණි.</span><span>ව්‍යාපාර හිමියන් සඳහා නිර්මාණය කළා</span></div>
  </div>
</footer>
<button type="button" class="to-top" id="toTop" aria-label="ඉහළට යන්න"><i class="fa-solid fa-arrow-up"></i></button>