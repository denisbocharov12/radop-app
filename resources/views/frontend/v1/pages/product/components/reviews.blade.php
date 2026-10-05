@php
    $averageScore = (float) ($product->approvedReviews()->avg('score') ?? 0);
    $reviewsCount = (int) $product->approvedReviews()->count();
    $signedIn = auth('user')->check();
@endphp

{{--
    Reviews. Two layouts:
     - no reviews yet: one centred empty state that invites the first review
       (the form for signed-in customers, a sign-in prompt for guests);
     - with reviews: the list, and beside it the form or the sign-in prompt.
--}}
{{-- Отступ сверху — обычный для секции: описание переехало в сетку выше и
     больше не отбивает отзывы своим нижним полем. --}}
<section class="sf-section pt-8 lg:pt-10" id="reviews">
    <div class="sf-container">
        <div class="sf-section-head mb-4">
            <h2 class="sf-section-title">
                {{ __('theme.reviews') }}
                @if($reviewsCount > 0)
                    <span class="ml-1 align-middle text-md font-medium text-ink-400">({{ $reviewsCount }})</span>
                @endif
            </h2>

            @if($reviewsCount > 0)
                <div class="flex items-center gap-2">
                    <x-sf-rating :score="$averageScore" />
                    <span class="text-md font-bold text-ink-900">{{ number_format($averageScore, 1) }}</span>
                </div>
            @endif
        </div>

        @if($reviewsCount === 0)
            <div class="sf-card flex flex-col items-center gap-5 px-6 py-8 text-center md:flex-row md:text-left">
                <span class="flex h-14 w-14 shrink-0 items-center justify-center rounded-full bg-accent-50 text-accent-500">
                    <x-sf-icon name="star" :size="26" stroke-width="1.5" style="fill: currentColor" />
                </span>

                <div class="min-w-0 flex-1">
                    <p class="text-md font-semibold text-ink-900">{{ __('theme.no_reviews_yet') }}</p>
                    <p class="mt-1 text-sm text-ink-500">
                        {{ $signedIn ? __('theme.leave_review') : __('theme.login_to_review') }}
                    </p>
                </div>

                @unless($signedIn)
                    <div class="flex shrink-0 flex-wrap justify-center gap-2">
                        <button type="button" class="sf-btn-primary" data-sf-auth-open>
                            <x-sf-icon name="user" :size="16" />{{ __('theme.log-in-account') }}
                        </button>
                        <a href="{{ route('user.registration.index') }}" class="sf-btn-secondary">{{ __('theme.registration') }}</a>
                    </div>
                @endunless
            </div>

            @if($signedIn)
                <div class="sf-card mt-3 max-w-2xl p-5">
                    @include('frontend.v1.pages.product.components.review-form')
                </div>
            @endif
        @else
            <div class="grid gap-6 lg:grid-cols-[minmax(0,1fr)_22rem] lg:items-start">
                <ul class="space-y-3">
                    @foreach($product->approvedReviews as $review)
                        <li class="sf-card p-4">
                            <div class="flex flex-wrap items-center justify-between gap-x-4 gap-y-1">
                                <div class="flex flex-wrap items-center gap-2">
                                    <span class="flex h-8 w-8 items-center justify-center rounded-full bg-brand-50 text-xs font-bold uppercase text-brand-600">
                                        {{ mb_substr($review->user?->profile?->organization_name ?: ($review->user?->profile?->first_name ?: '?'), 0, 1) }}
                                    </span>
                                    <strong class="text-sm font-semibold text-ink-900">
                                        @if($review->user)
                                            @if($review->user->type?->key_name === 'iur')
                                                {{ $review->user->profile->organization_name ?? __('theme.deleted_user') }}
                                            @else
                                                {{ trim(($review->user->profile->first_name ?? '') . ' ' . ($review->user->profile->last_name ?? '')) ?: __('theme.deleted_user') }}
                                            @endif
                                        @else
                                            {{ __('theme.deleted_user') }}
                                        @endif
                                    </strong>
                                    @if($review->is_verified)
                                        <span class="inline-flex items-center gap-1 rounded bg-success-50 px-1.5 py-0.5 text-2xs font-semibold text-success-600">
                                            <x-sf-icon name="check" :size="11" />{{ __('theme.verified_purchase') }}
                                        </span>
                                    @endif
                                </div>

                                <div class="flex items-center gap-2">
                                    <x-sf-rating :score="$review->score" :size="13" />
                                    <span class="text-2xs text-ink-400">{{ $review->created_at->format('d.m.Y') }}</span>
                                </div>
                            </div>

                            <p class="mt-2 text-sm leading-relaxed text-ink-700">{{ $review->text }}</p>
                        </li>
                    @endforeach
                </ul>

                <div class="sf-card p-5 lg:sticky lg:top-24">
                    @if($signedIn)
                        @include('frontend.v1.pages.product.components.review-form')
                    @else
                        <div class="text-center">
                            <span class="mx-auto mb-3 flex h-12 w-12 items-center justify-center rounded-full bg-brand-50 text-brand-600">
                                <x-sf-icon name="user" :size="22" />
                            </span>
                            <p class="text-sm text-ink-600">{{ __('theme.login_to_review') }}</p>
                            <button type="button" class="sf-btn-primary sf-btn-block mt-4" data-sf-auth-open>{{ __('theme.log-in-account') }}</button>
                            <a href="{{ route('user.registration.index') }}" class="sf-btn-ghost sf-btn-block mt-1">{{ __('theme.registration') }}</a>
                        </div>
                    @endif
                </div>
            </div>
        @endif
    </div>
</section>
