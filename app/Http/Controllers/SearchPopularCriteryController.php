<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\SearchPopularCritery\SearchPopularCriteryRequest;
use App\Models\SearchPopularCritery;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

/**
 * ТЗ 68: популярные поисковые запросы.
 *
 * Запросы копятся сами, этот раздел — про правку списка: закрепить нужный
 * наверху, убрать неудачный, добавить свой. Слои и вид повторяют раздел
 * «Секции главной».
 */
final class SearchPopularCriteryController extends Controller
{
    private const PER_PAGE = 50;

    public function index(Request $request): View
    {
        $locale = (string) $request->get('locale', '');

        $criteries = SearchPopularCritery::query()
            ->when($locale !== '', static fn ($query) => $query->where('locale', $locale))
            ->when(
                $request->filled('search'),
                static fn ($query) => $query->where('query', 'like', '%' . trim((string) $request->get('search')) . '%')
            )
            ->orderByDesc('is_pinned')
            ->orderByDesc('hits')
            ->paginate(self::PER_PAGE)
            ->withQueryString();

        return view('search-popular-critery.index', [
            'criteries' => $criteries,
            'locales' => $this->locales(),
            'locale' => $locale,
        ]);
    }

    public function create(): View
    {
        return view('search-popular-critery.form', [
            'critery' => new SearchPopularCritery([
                'locale' => app()->getLocale(),
                'is_pinned' => true,
                'position' => 0,
            ]),
            'locales' => $this->locales(),
        ]);
    }

    public function store(SearchPopularCriteryRequest $request): RedirectResponse
    {
        SearchPopularCritery::create($request->validated());

        return redirect()
            ->route('search-popular-critery.index')
            ->with('success', 'Запрос добавлен');
    }

    public function edit(SearchPopularCritery $searchPopularCritery): View
    {
        return view('search-popular-critery.form', [
            'critery' => $searchPopularCritery,
            'locales' => $this->locales(),
        ]);
    }

    public function update(
        SearchPopularCriteryRequest $request,
        SearchPopularCritery $searchPopularCritery
    ): RedirectResponse {
        $searchPopularCritery->update($request->validated());

        return redirect()
            ->route('search-popular-critery.index')
            ->with('success', 'Запрос сохранён');
    }

    public function destroy(SearchPopularCritery $searchPopularCritery): RedirectResponse
    {
        $searchPopularCritery->delete();

        return redirect()
            ->route('search-popular-critery.index')
            ->with('success', 'Запрос удалён');
    }

    /**
     * @return array<string, string>
     */
    private function locales(): array
    {
        return collect(LaravelLocalization::getSupportedLocales())
            ->map(static fn (array $properties, string $code) => $properties['native'] ?? $code)
            ->all();
    }
}
