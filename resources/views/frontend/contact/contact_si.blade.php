<!-- CONTACT -->
<section class="contact">
  <div class="wrap">
    <div class="head">
      <span class="label">අප හා සම්බන්ධ වන්න</span>
      <h1 class="rise"><span class="line"><span>ඔබේ ව්‍යාපාරය ගැන</span></span><span class="line"><span><span class="mark">අපි කතා කරමු.</span></span></span></h1>
      <p class="fade-in">ඔබ දැනට ව්‍යාපාරය කරගෙන යන ආකාරය අපට කියන්න. Zeebroo ඔබේ වැඩට ගැළපෙන්නේ කොහොමද කියා අපි පෙන්වා දෙන්නම්. සාමාන්‍යයෙන් වැඩ කරන දින එකක් ඇතුළත අපි ඔබට පිළිතුරු දෙනවා.</p>
    </div>

    <div class="contact-grid">
      <aside class="contact-side reveal">
        <span class="mega-ic"><i class="fa-solid fa-headset"></i></span>
        <h2>අපගේ කණ්ඩායම සමඟ කෙලින්ම කතා කරන්න</h2>
        <p>Demo එකක් වෙන් කරගන්න, මිල ගණන් ගැන විමසන්න, නැත්නම් ඔබේ ව්‍යාපාරය Zeebroo හි සකසා ගැනීමට අපගේ සහාය ලබාගන්න.</p>
        <ul class="contact-ways">
          <li><span><i class="fa-regular fa-envelope"></i></span><div><small>ඊමේල් කරන්න</small><a href="mailto:hello@zeebroo.com">hello@zeebroo.com</a></div></li>
          <li><span><i class="fa-solid fa-book-open"></i></span><div><small>මාර්ගෝපදේශ සහ පාඩම්</small><a href="https://www.zeebroo.com/tutorial">උපදෙස් කියවන්න</a></div></li>
          <li><span><i class="fa-solid fa-right-to-bracket"></i></span><div><small>දැනටමත් Zeebroo භාවිත කරනවාද?</small><a href="https://platform.zeebroo.com/login">ඔබේ ගිණුමට ලොග් වන්න</a></div></li>
        </ul>
        <img class="contact-art" src="{{ asset('assets/ufo.webp') }}" alt="" width="179" height="187" loading="lazy">
      </aside>

      <div class="contact-card reveal">
        @if (session('contact_sent'))
          <div class="contact-ok" role="status">
            <span><i class="fa-solid fa-check"></i></span>
            <h3>ස්තූතියි! ඔබේ පණිවිඩය අපට ලැබුණා.</h3>
            <p>අපගේ කණ්ඩායම ඉක්මනින්ම ඊමේල් මගින් ඔබව සම්බන්ධ කරගනීවි.</p>
            <a class="btn btn-line" href="{{ route('home') }}">මුල් පිටුවට යන්න</a>
          </div>
        @else
          <form class="contact-form" method="POST" action="{{ route('contact.store') }}" novalidate>
            @csrf
            <div class="hp" aria-hidden="true"><label>Website <input type="text" name="website" tabindex="-1" autocomplete="off"></label></div>

            <div class="f-row">
              <label class="f">
                <span>ඔබේ නම *</span>
                <input type="text" name="name" value="{{ old('name') }}" autocomplete="name" required>
                @error('name')<em>{{ $message }}</em>@enderror
              </label>
              <label class="f">
                <span>ඊමේල් ලිපිනය *</span>
                <input type="email" name="email" value="{{ old('email') }}" autocomplete="email" required>
                @error('email')<em>{{ $message }}</em>@enderror
              </label>
            </div>
            <div class="f-row">
              <label class="f">
                <span>දුරකථන අංකය</span>
                <input type="tel" name="phone" value="{{ old('phone') }}" autocomplete="tel">
                @error('phone')<em>{{ $message }}</em>@enderror
              </label>
              <label class="f">
                <span>ව්‍යාපාරයේ නම</span>
                <input type="text" name="business" value="{{ old('business') }}" autocomplete="organization">
                @error('business')<em>{{ $message }}</em>@enderror
              </label>
            </div>

            <fieldset class="f">
              <legend>අපෙන් ඔබට අවශ්‍ය කුමක්ද? *</legend>
              <div class="topics">
                @php($topicLabels = ['demo' => 'Demo එකක් වෙන් කරගන්න', 'sales' => 'මිල ගණන් සහ මිලදී ගැනීම', 'support' => 'මගේ ගිණුමට සහාය', 'partnership' => 'ව්‍යාපාරික හවුල්කාරිත්වය', 'other' => 'වෙනත් කරුණක්'])
                @foreach ($topics as $key => $label)
                  <label class="topic"><input type="radio" name="topic" value="{{ $key }}" @checked(old('topic', 'demo') === $key)><span>{{ $topicLabels[$key] ?? $label }}</span></label>
                @endforeach
              </div>
              @error('topic')<em>{{ $message }}</em>@enderror
            </fieldset>

            <label class="f">
              <span>ඔබේ පණිවිඩය *</span>
              <textarea name="message" rows="5" required placeholder="ඔබේ ව්‍යාපාරය ගැනත්, ඔබට අවශ්‍ය දේ ගැනත් කෙටියෙන් අපට කියන්න.">{{ old('message') }}</textarea>
              @error('message')<em>{{ $message }}</em>@enderror
            </label>

            <button class="btn btn-ink" type="submit" style="transition:opacity .2s">පණිවිඩය යවන්න <i class="fa-solid fa-arrow-right"></i></button>
          </form>
          <script>
            (function () {
              var form = document.querySelector('.contact-form');
              if (!form) return;
              var btn = form.querySelector('button[type="submit"]');
              var original = btn.innerHTML;

              form.addEventListener('submit', function (e) {
                if (btn.disabled) { e.preventDefault(); return; }
                btn.disabled = true;
                btn.setAttribute('aria-busy', 'true');
                btn.style.opacity = '.6';
                btn.style.cursor = 'not-allowed';
                btn.innerHTML = 'යවමින් පවතී... <i class="fa-solid fa-spinner fa-spin"></i>';
              });

              // Re-enable if the user comes back via the browser back button (bfcache)
              window.addEventListener('pageshow', function () {
                btn.disabled = false;
                btn.removeAttribute('aria-busy');
                btn.style.opacity = '';
                btn.style.cursor = '';
                btn.innerHTML = original;
              });
            })();
          </script>
        @endif
      </div>
    </div>
  </div>
</section>