{{-- Single-series column chart with hover tooltips. Needs: $bars (list of [label, value]), $unit (e.g. "enquiries"), $caption --}}
@php($max = max(1, collect($bars)->max('value')))
@php($last = count($bars) - 1)
<figure class="adm-chart">
  <div class="adm-chart-plot" role="img" aria-label="{{ $caption }}: {{ collect($bars)->map(fn ($b) => $b['label'].' '.$b['value'])->implode(', ') }}">
    <span class="adm-chart-max">{{ $max }}</span>
    @foreach ($bars as $i => $bar)
      <span class="adm-chart-col" data-tip="{{ $bar['label'] }} · {{ $bar['value'] }} {{ $unit }}">
        <i style="height: {{ $bar['value'] ? max(3, round($bar['value'] / $max * 100)) : 0 }}%"></i>
      </span>
    @endforeach
  </div>
  <figcaption class="adm-chart-x">
    <span>{{ $bars[0]['label'] }}</span>
    @if ($last > 1)<span>{{ $bars[intdiv($last, 2)]['label'] }}</span>@endif
    <span>{{ $bars[$last]['label'] }}</span>
  </figcaption>
</figure>
