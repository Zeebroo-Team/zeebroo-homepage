@extends('layouts.frontend')

@section('title', 'Zeebroo: ඔබේ මුළු ව්‍යාපාරයම එකම තැනකින් පාලනය කරන POS පද්ධතිය')
@section('description', 'විකුණුම්, තොග, ගිණුම්, සේවකයින් සහ ප්‍රචාරණ සියල්ල Zeebroo එකම තැනක. වෙබ් සහ ඩෙස්ක්ටොප් POS, තොග, බිල්, HR සහ ප්‍රචාරණ. අමතර ගාස්තු නැතිව සියලුම මොඩියුල ඇතුළත්.')

@push('head')
<link rel="preload" as="image" href="{{ asset('assets/mascot.webp') }}">
@endpush

@push('scripts')
{{-- Sinhala text for the interactive demo, roles, module switcher and finance map in script.js --}}
<script>
window.ZB_TEXT = {
  cats: {All: 'සියල්ල', Bakery: 'බේකරි', Drinks: 'බීම', Dairy: 'කිරි ආහාර', Fresh: 'එළවළු/පලතුරු'},
  products: ['පාන් ගෙඩිය', 'චොකලට් කේක් කෑල්ල', 'ලංකා තේ 100g', 'අයිස් කෝපි', 'වතුර බෝතලය 1L', 'චෙඩාර් චීස්', 'බිත්තර 10ක පැකට්', 'වැනිලා අයිස්ක්‍රීම්', 'රතු ඇපල් 1kg', 'කැරට් 500g'],
  add: '{name} එකතු කරන්න, {price}',
  lowStock: 'තොගය අඩුයි: ',
  left: '{n}ක් ඉතිරියි',
  noResults: 'ගැළපෙන භාණ්ඩ හමු වුණේ නැහැ. වෙනත් නමකින් සොයා බලන්න.',
  empty: 'බිල තවම හිස්. විකුණුමක් පටන් ගන්න භාණ්ඩයක් ඔබන්න.',
  removeOne: '{name} එකක් අඩු කරන්න',
  addOne: '{name} එකක් වැඩි කරන්න',
  discRule: '(රු. 2,000ට වැඩි බිල්වලට 5%)',
  methods: {Cash: 'මුදල්', Card: 'කාඩ්', QR: 'QR'},
  branch: 'කොළඹ 03, ශාඛාව 1',
  receiptNo: 'රිසිට් #{no}',
  subtotal: 'උප එකතුව',
  discount: 'වට්ටම',
  total: 'මුළු මුදල',
  paidBy: '{method} මගින් ගෙවා ඇත',
  thanks: 'ස්තූතියි, නැවත එන්න!',
  sold: 'කිං! <b>{amount}</b>ක විකුණුමක් සාර්ථකයි.',
  roles: [
    {n: 'නිමාලි', r: 'කැෂියර්', p: [['විකුණුම් කිරීම', 1], ['මුදල් ආපසු දීම', 0], ['වාර්තා බැලීම', 0]]},
    {n: 'කසුන්', r: 'කළමනාකරු', p: [['විකුණුම් කිරීම', 1], ['තොග වෙනස් කිරීම', 1], ['වාර්තා බැලීම', 1]]},
    {n: 'අයේෂා', r: 'ගණකාධිකාරී', p: [['බිල් ගෙවීම', 1], ['වාර්තා බැලීම', 1], ['තොග වෙනස් කිරීම', 0]]},
  ],
  modOn: 'සක්‍රියයි',
  modOff: 'අක්‍රියයි',
  enable: '{name} සක්‍රිය කරන්න',
  learnMore: '{name} ගැන තවත් දැනගන්න',
  illustration: '{name} සඳහා Zeebroo සීබ්‍රා චිත්‍රය',
  bills: [['විදුලි බිල', 'ගෙවීම පමාදයි', 1], ['ගෑස් බිල', '5,000.00, ගෙවීම පමාදයි', 1], ['දුරකථන බිල', 'ගෙවීම පමාදයි', 1], ['කසළ බිල', '2,999.97, ගෙවීම පමාදයි', 1], ['වතුර බිල', 'ගෙවීම පමාදයි', 1], ['ව්‍යාපාර ණය', 'මසකට 20,023.96', 0], ['වාහන ලීසිං', 'මසකට 48,815.95', 0]],
  income: [['POS විකුණුම්', 'කවුන්ටර විකුණුම්'], ['කොටේෂන්', 'වෙබ් පැනලය'], ['ඉන්වොයිසි', 'වෙබ් පැනලය'], ['ණය එකතු කිරීම', 'ලැබිය යුතු ණය']],
  expenses: 'වියදම්',
  expensesTotal: 'මසකට 106,839.88',
  business: 'ඔබේ ව්‍යාපාරය',
  incomeLabel: 'ආදායම',
  streams: 'මාර්ග 4ක්',
};
</script>
<script src="{{ asset('assets/js/script.js') }}"></script>
@endpush

@section('content')
    @include('frontend.home.hero')
    @include('frontend.home.benefits')
    @include('frontend.home.modules')
    @include('frontend.home.finance')
    @include('frontend.home.industries')
    @include('frontend.home.partners')
    @include('frontend.home.testimonials')
    @include('frontend.home.packages')
    @include('frontend.home.steps')
    @include('frontend.home.manifesto')
    @include('frontend.home.faq')
    @include('frontend.home.cta')
    @include('frontend.home.temp')
@endsection
