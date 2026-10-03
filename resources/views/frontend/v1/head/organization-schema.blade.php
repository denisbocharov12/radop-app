{{-- Organization / OnlineStore structured data, rendered once per page
     in <head>. Locale-aware description. --}}
@php
    $orgLocale = app()->getLocale();
    $orgDescription = match ($orgLocale) {
        'ru' => 'Radop.md — канцелярские товары для офиса, школы и творчества. 30 лет на рынке Молдовы. Оптовые и розничные цены, доставка по Кишинёву и стране.',
        default => 'Radop.md — rechizite de birou, școlare și creație. 30 de ani pe piața din Moldova. Prețuri en gros și cu amănuntul, livrare în Chișinău și în toată țara.',
    };
@endphp
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "OnlineStore",
  "@id": "{{ url('/') }}#organization",
  "name": "RĂDOP-OPT SRL",
  "alternateName": "Radop",
  "url": "{{ url('/') }}",
  "logo": "{{ url('v1/frontend/assets/images/logo-512.png') }}",
  "image": "{{ url('v1/frontend/assets/images/logo-512.png') }}",
  "description": @json($orgDescription),
  "telephone": ["+37322782112", "+37379782112"],
  "email": "support@radop.md",
  "foundingDate": "1993",
  "address": {
    "@type": "PostalAddress",
    "streetAddress": "str. Sarmizegetusa 15",
    "addressLocality": "Chișinău",
    "postalCode": "MD-2015",
    "addressCountry": "MD"
  },
  "openingHoursSpecification": [
    {
      "@type": "OpeningHoursSpecification",
      "dayOfWeek": ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday"],
      "opens": "08:00",
      "closes": "18:00"
    },
    {
      "@type": "OpeningHoursSpecification",
      "dayOfWeek": "Saturday",
      "opens": "08:00",
      "closes": "16:00"
    }
  ],
  "areaServed": {
    "@type": "Country",
    "name": "Moldova"
  }
}
</script>

{{-- WebSite + SearchAction: поисковая строка сайта в выдаче Google.
     Адрес совпадает с реальным поиском витрины (?search=). --}}
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "WebSite",
  "@id": "{{ url('/') }}#website",
  "url": "{{ url('/') }}",
  "name": "Radop",
  "publisher": { "@id": "{{ url('/') }}#organization" },
  "inLanguage": "{{ app()->getLocale() === 'ru' ? 'ru-MD' : 'ro-MD' }}",
  "potentialAction": {
    "@type": "SearchAction",
    "target": {
      "@type": "EntryPoint",
      "urlTemplate": "{{ route('theme.search.index') }}?search={search_term_string}"
    },
    "query-input": "required name=search_term_string"
  }
}
</script>
