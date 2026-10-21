<footer>
  <div class="wrap">
    <div class="foot">
      <div><a href="{{ route('home') }}#top" class="logo"><img src="{{ asset('assets/mark.png') }}" alt="" width="25" height="32">Zeebroo</a><p>ඔබේ ව්‍යාපාරය පහසුවෙන් කරගෙන යන්න, බලාගන්න සහ දියුණු කරගන්න අවශ්‍ය සියල්ල එකම තැනක.</p></div>
      <div><h4>අපේ සේවා</h4><ul><li><a href="{{ route('home') }}#benefits">ඔබට ලැබෙන වාසි</a></li><li><a href="{{ route('features.index') }}">විශේෂාංග</a></li><li><a href="{{ route('industries.index') }}">ව්‍යාපාර වර්ග</a></li><li><a href="{{ route('packages.index') }}">මිල ගණන්</a></li></ul></div>
      <div><h4>සමාගම</h4><ul><li><a href="{{ route('about') }}">අපි ගැන</a></li><li><a href="{{ route('partners.index') }}">හවුල්කරුවන්</a></li><li><a href="{{ route('testimonials.index') }}">පාරිභෝගික අදහස්</a></li><li><a href="{{ route('blog.index') }}">ලිපි</a></li></ul></div>
      <div><h4>ඇතුළත් දේ</h4><ul>@foreach ($navFeatures->where('group', 'core')->take(5) as $f)<li><a href="{{ route('features.show', $f->slug) }}">{{ $f->title }}</a></li>@endforeach</ul></div>
      <div><h4>අපව අමතන්න</h4><ul><li><a href="{{ route('contact') }}">අපට කතා කරන්න</a></li><li><a href="mailto:hello@zeebroo.com">hello@zeebroo.com</a></li><li><a href="https://platform.zeebroo.com/">පිවිසෙන්න</a></li></ul></div>
    </div>
    <div class="foot-b"><span>&copy; <span id="yr"></span> Zeebroo. සියලු හිමිකම් ඇවිරිණි.</span><span>ව්‍යාපාර හිමියන් වෙනුවෙන්ම නිර්මාණය කළා</span></div>
  </div>
</footer>
<button type="button" class="to-top" id="toTop" aria-label="ඉහළට යන්න"><i class="fa-solid fa-arrow-up"></i></button>
