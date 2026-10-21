{{-- every module against every package; expects $packages and $features --}}
<div class="pkg-compare reveal">
  <table>
    <thead>
      <tr>
        <th scope="col">මොඩියුලය</th>
        @foreach ($packages as $slug => $p)
          <th scope="col"><a href="{{ route('packages.show', $slug) }}">{{ $p['name'] }}</a><small>{{ $p['price'] }}@unless ($p['is_free'])/මස @endunless</small></th>
        @endforeach
      </tr>
    </thead>
    <tbody>
      @foreach ($features as $key => $feature)
        <tr>
          <th scope="row">
            @if ($feature['slug'])
              <a href="{{ route('features.show', $feature['slug']) }}"><i class="fa-solid {{ $feature['icon'] }}"></i>{{ $feature['label'] }}</a>
            @else
              <span><i class="fa-solid {{ $feature['icon'] }}"></i>{{ $feature['label'] }}</span>
            @endif
          </th>
          @foreach ($packages as $p)
            <td data-label="{{ $p['name'] }}" class="{{ isset($p['features'][$key]) ? 'is-yes' : 'is-no' }}">
              @if (isset($p['features'][$key]))
                <span class="pkg-yes" title="ඇතුළත්"><i class="fa-solid fa-check"></i><span class="sr">ඇතුළත්</span></span>
              @else
                <span class="pkg-no" title="ඇතුළත් නැත">–<span class="sr">ඇතුළත් නැත</span></span>
              @endif
            </td>
          @endforeach
        </tr>
      @endforeach
    </tbody>
  </table>
</div>
