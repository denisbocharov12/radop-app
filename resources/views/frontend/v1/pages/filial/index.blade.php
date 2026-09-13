@extends('frontend.v1.layouts.layout')

@section('sf-page', 1)

@section('content')
    <x-sf-account-shell :title="__('theme.my_filials')">
        <x-slot:actions>
            <a class="sf-btn-primary" href="{{ route('theme.user.filial.create') }}">
                <x-sf-icon name="plus" :size="16" />{{ __('theme.filial_store') }}
            </a>
        </x-slot:actions>

        @if(! $user->filials->count())
            <div class="sf-card px-6 py-14 text-center">
                <x-sf-icon name="building" :size="40" class="mx-auto mb-3 text-ink-300" />
                <p class="text-md font-medium text-ink-700">{{ __('theme.no_filials') }}</p>
                <a href="{{ route('theme.user.filial.create') }}" class="sf-btn-primary mt-5 inline-flex">
                    <x-sf-icon name="plus" :size="16" />{{ __('theme.filial_store') }}
                </a>
            </div>
        @else
            <ul class="grid gap-3 md:grid-cols-2">
                @foreach($filials as $filial)
                    <li class="sf-card flex flex-col p-4">
                        <div class="flex items-start gap-3">
                            <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-brand-50 text-brand-600">
                                <x-sf-icon name="building" :size="19" />
                            </span>
                            <div class="min-w-0 flex-1">
                                <p class="font-semibold text-ink-900">{{ $filial->address }}</p>
                                <p class="mt-0.5 text-sm text-ink-500">{{ $filial?->city?->name }}</p>
                            </div>
                            <a href="{{ route('theme.user.filial.edit', $filial) }}" class="sf-btn-ghost sf-btn-sm shrink-0">{{ __('theme.edit_btn_text') }}</a>
                        </div>

                        <dl class="mt-4 grid grid-cols-3 gap-2 border-t border-ink-100 pt-3 text-sm">
                            <div>
                                <dt class="text-2xs text-ink-500">{{ __('theme.filial_input_phone') }}</dt>
                                <dd class="mt-0.5 font-medium text-ink-800">{{ $filial->phone ?: '—' }}</dd>
                            </div>
                            <div>
                                <dt class="text-2xs text-ink-500">{{ __('theme.filial_count_orders') }}</dt>
                                <dd class="mt-0.5 font-medium text-ink-800">{{ $filial->orders->count() }}</dd>
                            </div>
                            <div>
                                <dt class="text-2xs text-ink-500">{{ __('theme.filial_price_total') }}</dt>
                                <dd class="mt-0.5 font-medium text-ink-800">{{ number_format((float) $filial->orders->sum('total'), 2, ',', ' ') }} {{ __('theme.MDL') }}</dd>
                            </div>
                        </dl>
                    </li>
                @endforeach
            </ul>

            {{ $filials->links('vendor.pagination.sf') }}
        @endif
    </x-sf-account-shell>
@endsection
