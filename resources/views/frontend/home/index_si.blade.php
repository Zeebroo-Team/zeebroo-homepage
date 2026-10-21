@extends('layouts.frontend')

@section('title', 'Zeebroo: ඔබේ මුළු ව්‍යාපාරයම පවත්වාගෙන යන POS පද්ධතිය')
@section('description', 'Zeebroo විකුණුම්, තොගය, මුදල්, කාර්ය මණ්ඩලය සහ අලෙවිකරණය එකම තැනකට ගෙන එයි. වෙබ් සහ ඩෙස්ක්ටොප් POS, තොග, බිල්පත්, මානව සම්පත් සහ ප්‍රචාරණ. සියලුම මොඩියුල ඇතුළත්.')

@push('head')
<link rel="preload" as="image" href="{{ asset('assets/mascot.webp') }}">
@endpush

@push('scripts')
{{-- Sinhala text for the interactive demo, roles, module switcher and finance map in script.js --}}
<script>
window.ZB_TEXT = {
  cats: {All: 'සියල්ල', Bakery: 'බේකරි', Drinks: 'බීම', Dairy: 'කිරි නිෂ්පාදන', Fresh: 'නැවුම්'},
  products: ['නැවුම් පාන් ගෙඩිය', 'චොකලට් කේක් පෙත්ත', 'ලංකා තේ 100g', 'අයිස් කෝපි', 'ඛනිජ ජලය 1L', 'චෙඩාර් චීස්', 'බිත්තර, 10 පැකට්ටුව', 'වැනිලා අයිස්ක්‍රීම්', 'රතු ඇපල් 1kg', 'කැරට් 500g'],
  add: '{name} එක් කරන්න, {price}',
  lowStock: 'තොගය අඩුයි: ',
  left: '{n} ක් ඉතිරියි',
  noResults: 'ගැළපෙන භාණ්ඩ නැත. වෙනත් සෙවුමක් උත්සාහ කරන්න.',
  empty: 'කරත්තය හිස්ය. විකුණුමක් ආරම්භ කිරීමට භාණ්ඩයක් තට්ටු කරන්න.',
  removeOne: '{name} එකක් ඉවත් කරන්න',
  addOne: '{name} එකක් එක් කරන්න',
  discRule: '(රු. 2,000ට වැඩි නම් 5%)',
  methods: {Cash: 'මුදල්', Card: 'කාඩ්පත', QR: 'QR'},
  branch: 'කොළඹ 03, ශාඛාව 1',
  receiptNo: 'රිසිට්පත #{no}',
  subtotal: 'උප එකතුව',
  discount: 'වට්ටම',
  total: 'මුළු එකතුව',
  paidBy: '{method} මගින් ගෙව්වා',
  thanks: 'ස්තූතියි, නැවත එන්න!',
  sold: 'කිං! <b>{amount}</b> ක් විකිණුණා.',
  roles: [
    {n: 'නිමාලි', r: 'මුදල් අයකැමි', p: [['විකුණුම් සටහන් කිරීම', 1], ['මුදල් ආපසු ගෙවීම', 0], ['වාර්තා බැලීම', 0]]},
    {n: 'කසුන්', r: 'කළමනාකරු', p: [['විකුණුම් සටහන් කිරීම', 1], ['තොගය සංස්කරණය', 1], ['වාර්තා බැලීම', 1]]},
    {n: 'අයේෂා', r: 'ගණකාධිකාරී', p: [['බිල්පත් ගෙවීම', 1], ['වාර්තා බැලීම', 1], ['තොගය සංස්කරණය', 0]]},
  ],
  modOn: 'ස්ථාපිතයි',
  modOff: 'අක්‍රියයි',
  enable: '{name} සක්‍රිය කරන්න',
  learnMore: '{name} ගැන තවත් දැනගන්න',
  illustration: '{name} සඳහා Zeebroo සීබ්‍රා රූපය',
  bills: [['විදුලි බිල්පත', 'කල් ඉකුත්', 1], ['ගෑස් බිල්පත', '5,000.00, කල් ඉකුත්', 1], ['දුරකථන බිල්පත', 'කල් ඉකුත්', 1], ['අපද්‍රව්‍ය බිල්පත', '2,999.97, කල් ඉකුත්', 1], ['ජල බිල්පත', 'කල් ඉකුත්', 1], ['ව්‍යාපාර ණය', 'මසකට 20,023.96', 0], ['වාහන කුලිය', 'මසකට 48,815.95', 0]],
  income: [['POS විකුණුම්', 'විකුණුම් ගනුදෙනු'], ['මිල ගණන් යෝජනා', 'වෙබ් පැනලය'], ['ඉන්වොයිසි', 'වෙබ් පැනලය'], ['ණය අයකර ගැනීම', 'හිඟ ණය']],
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
