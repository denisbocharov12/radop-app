@props([
    'title' => null,
    'lead' => null,
    'breadcrumb' => true,
])

{{--
    Wrapper for the long-form pages (about, delivery, policies, order guide).
    Their bodies are plain headings, paragraphs, lists and tables, so they are
    handed to `.sf-prose` rather than each page carrying its own CSS block.

    Pages with many sections (terms, privacy, cookies) get a sticky table of
    contents on desktop, built from the `h2` headings by vitals.js — it stays
    hidden on short pages.
--}}
@if($breadcrumb && $title)
    <x-sf-breadcrumbs :with-shop="false" :items="[['url' => null, 'name' => $title]]" />
@endif

{{-- Without a title prop the page's own <h1> is the first thing under the
     header, so the top gap comes from padding instead of the breadcrumb. --}}
<article @class(['sf-container sf-page-body', 'pt-8 lg:pt-14' => ! ($breadcrumb && $title)])>
    @if($title)
        <h1 class="sf-page-title">{{ $title }}</h1>
    @endif

    @if($lead)
        <p class="-mt-2 mb-8 max-w-[65ch] text-md text-ink-600">{{ $lead }}</p>
    @endif

    {{-- Text column capped at a readable measure with the contents right beside
         it; a 1fr column left a wide empty gap between the two. --}}
    <div class="lg:grid lg:grid-cols-[minmax(0,52rem)_16rem] lg:items-start lg:justify-start lg:gap-12 xl:gap-16" data-sf-toc-scope>
        <div class="sf-prose sf-prose-page lg:max-w-none">
            {{ $slot }}
        </div>

        <aside class="sf-toc sticky top-24 hidden max-h-[calc(100vh-8rem)] overflow-y-auto" data-sf-toc aria-label="{{ __('theme.sf-toc') }}">
            <p class="mb-2 text-xs font-semibold uppercase tracking-wide text-ink-400">{{ __('theme.sf-toc') }}</p>
            <nav data-sf-toc-list></nav>
        </aside>
    </div>
</article>
