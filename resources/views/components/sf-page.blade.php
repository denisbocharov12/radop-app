@props([
    'title' => null,
    'lead' => null,
    'breadcrumb' => true,
])

{{--
    Wrapper for the long-form pages (about, delivery, policies, order guide).
    Their bodies are plain headings, paragraphs, lists and tables, so they are
    handed to `.sf-prose` rather than each page carrying its own CSS block.
--}}
@if($breadcrumb && $title)
    <x-sf-breadcrumbs :with-shop="false" :items="[['url' => null, 'name' => $title]]" />
@endif

<article class="sf-container pb-16">
    @if($title)
        <h1 class="mb-3 mt-2 text-2xl font-bold text-ink-900 lg:text-3xl">{{ $title }}</h1>
    @endif

    @if($lead)
        <p class="mb-6 max-w-[65ch] text-md text-ink-600">{{ $lead }}</p>
    @endif

    <div class="sf-prose">
        {{ $slot }}
    </div>
</article>
