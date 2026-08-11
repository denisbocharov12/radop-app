@extends('v2.layouts.app')

@section('content')
    <x-page-header :title="__('product_errors.page_title')"
                   :description="__('product_errors.subtitle', ['rows' => $summary['rows'], 'products' => $affectedProducts])">
        <x-slot:actions>
            <form action="{{ route('product.errors.rescan') }}" method="POST"
                  onsubmit="this.querySelector('button').disabled=true;this.querySelector('button span').innerHTML='{{ __('product_errors.rescanning') }}';">
                @csrf
                <button type="submit" class="btn-primary btn-sm">
                    <i data-lucide="refresh-cw" class="w-4 h-4"></i> <span>{{ __('product_errors.rescan') }}</span>
                </button>
            </form>
            <a href="{{ route('product.errors.export', request()->query()) }}" class="btn-success btn-sm">
                <i data-lucide="file-spreadsheet" class="w-4 h-4"></i> {{ __('product_errors.export') }}
            </a>
            <a href="{{ route('product.index') }}" class="btn-secondary btn-sm">
                <i data-lucide="arrow-left" class="w-4 h-4"></i> {{ __('product_errors.back_to_products') }}
            </a>
        </x-slot:actions>
    </x-page-header>

    @if(session('success'))
        <x-alert type="success" class="mb-4">{{ session('success') }}</x-alert>
    @endif

    {{-- Summary cards --}}
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-3 mb-5">
        <x-card>
            <h6 class="text-xs font-medium uppercase tracking-wide text-gray-500">{{ __('product_errors.card_critical') }}</h6>
            <div class="mt-1 text-3xl font-bold text-red-600">{{ $summary['products_critical'] }}</div>
            <p class="mt-1 text-xs text-gray-400">{{ __('product_errors.card_critical_hint') }}</p>
        </x-card>
        <x-card>
            <h6 class="text-xs font-medium uppercase tracking-wide text-gray-500">{{ __('product_errors.card_minor') }}</h6>
            <div class="mt-1 text-3xl font-bold text-amber-500">{{ $summary['products_minor'] }}</div>
            <p class="mt-1 text-xs text-gray-400">{{ __('product_errors.card_minor_hint') }}</p>
        </x-card>
        <x-card>
            <h6 class="text-xs font-medium uppercase tracking-wide text-gray-500">{{ __('product_errors.card_affected') }}</h6>
            <div class="mt-1 text-3xl font-bold text-gray-800">{{ $affectedProducts }}</div>
            <p class="mt-1 text-xs text-gray-400">{{ __('product_errors.card_affected_hint') }}</p>
        </x-card>
    </div>

    {{-- Filters --}}
    <x-card class="mb-5">
        <form action="{{ route('product.errors.index') }}" method="GET"
              class="grid grid-cols-1 gap-4 md:grid-cols-12 md:items-end">
            <div class="md:col-span-3">
                <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('product_errors.filter_severity') }}</label>
                <select name="severity" class="block w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-brand-500 focus:ring-1 focus:ring-brand-500 focus:outline-none">
                    <option value="">{{ __('product_errors.filter_all') }}</option>
                    <option value="critical" {{ request('severity') === 'critical' ? 'selected' : '' }}>{{ __('product_errors.severities.critical') }}</option>
                    <option value="minor" {{ request('severity') === 'minor' ? 'selected' : '' }}>{{ __('product_errors.severities.minor') }}</option>
                </select>
            </div>
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('product_errors.filter_type') }}</label>
                <select name="type" class="block w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-brand-500 focus:ring-1 focus:ring-brand-500 focus:outline-none">
                    <option value="">{{ __('product_errors.filter_all') }}</option>
                    @foreach($types as $typeKey => $typeLabel)
                        <option value="{{ $typeKey }}" {{ request('type') === $typeKey ? 'selected' : '' }}>{{ $typeLabel }}</option>
                    @endforeach
                </select>
            </div>
            <div class="md:col-span-3">
                <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('product_errors.filter_search') }}</label>
                <input type="text" name="search" value="{{ e((string) request('search', '')) }}"
                       placeholder="{{ __('product_errors.filter_search_ph') }}"
                       class="block w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-brand-500 focus:ring-1 focus:ring-brand-500 focus:outline-none">
            </div>
            <div class="md:col-span-2">
                <label class="flex items-center gap-2 cursor-pointer" title="{{ __('product_errors.filter_in_stock_hint') }}">
                    <input type="checkbox" id="filter_in_stock" name="in_stock" value="1"
                           {{ request()->boolean('in_stock') ? 'checked' : '' }}
                           class="rounded border-gray-300 text-brand-600 focus:ring-brand-500">
                    <span class="text-sm text-gray-700">{{ __('product_errors.filter_in_stock') }}</span>
                </label>
            </div>
            <div class="md:col-span-2">
                <button type="submit" class="btn-primary w-full justify-center">
                    <i data-lucide="search" class="w-4 h-4"></i> {{ __('product_errors.filter_apply') }}
                </button>
            </div>
        </form>
    </x-card>

    {{-- Table --}}
    <x-card :padding="false">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-100 text-sm">
                <thead class="bg-gray-50">
                    <tr class="text-left text-xs font-medium uppercase tracking-wide text-gray-500">
                        <th class="px-5 py-3">{{ __('product_errors.col_id') }}</th>
                        <th class="px-5 py-3">{{ __('product_errors.col_product') }}</th>
                        <th class="px-5 py-3">{{ __('product_errors.col_code') }}</th>
                        <th class="px-5 py-3">{{ __('product_errors.col_severity') }}</th>
                        <th class="px-5 py-3">{{ __('product_errors.col_type') }}</th>
                        <th class="px-5 py-3">{{ __('product_errors.col_message') }}</th>
                        <th class="px-5 py-3 text-right">{{ __('product_errors.col_action') }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($errors as $error)
                        <tr class="hover:bg-brand-50/40 transition-colors">
                            <td class="px-5 py-3 font-medium text-gray-800">#{{ $error->product_id ?? '—' }}</td>
                            <td class="px-5 py-3 text-gray-700">{{ $error->product_title ?: '—' }}</td>
                            <td class="px-5 py-3 text-gray-500">{{ $error->product_onec_id }}</td>
                            <td class="px-5 py-3">
                                @if($error->isCritical())
                                    <span class="inline-flex items-center rounded-full bg-red-50 px-2.5 py-0.5 text-xs font-medium text-red-700">{{ $error->severityLabel() }}</span>
                                @else
                                    <span class="inline-flex items-center rounded-full bg-amber-50 px-2.5 py-0.5 text-xs font-medium text-amber-700">{{ $error->severityLabel() }}</span>
                                @endif
                            </td>
                            <td class="px-5 py-3 text-gray-700">{{ $error->typeLabel() }}</td>
                            <td class="px-5 py-3 text-gray-500">{{ $error->localizedMessage() }}</td>
                            <td class="px-5 py-3 text-right">
                                @if($error->product_id)
                                    <a href="{{ route('product.edit', $error->product_id) }}" class="btn-secondary btn-sm">
                                        <i data-lucide="pencil" class="w-4 h-4"></i> {{ __('product_errors.open') }}
                                    </a>
                                @else
                                    <span class="text-gray-400">—</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-5 py-8">
                                <x-empty-state icon="check-circle" title="{{ __('product_errors.empty') }}" />
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($errors->hasPages())
            <div class="border-t border-gray-100 px-5 py-3">
                <x-pager :paginator="$errors" />
            </div>
        @endif
    </x-card>
@endsection
