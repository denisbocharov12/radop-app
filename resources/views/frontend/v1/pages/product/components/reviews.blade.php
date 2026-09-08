@php
    $averageScore = (float) ($product->approvedReviews()->avg('score') ?? 0);
    $reviewsCount = (int) $product->approvedReviews()->count();
@endphp

<section class="sf-section" id="reviews">
    <div class="sf-container">
        <div class="sf-section-head mb-4">
            <h2 class="sf-section-title">{{ __('theme.reviews') }}</h2>

            @if($reviewsCount > 0)
                <div class="flex items-center gap-2">
                    <x-sf-rating :score="$averageScore" />
                    <span class="text-md font-bold text-ink-900">{{ number_format($averageScore, 1) }}</span>
                    <span class="text-xs text-ink-500">({{ $reviewsCount }} {{ __('theme.reviews_count') }})</span>
                </div>
            @endif
        </div>

        <div class="grid gap-6 lg:grid-cols-[minmax(0,1fr)_22rem] lg:items-start">
            <div>
                @if($reviewsCount === 0)
                    <p class="text-sm italic text-ink-500">{{ __('theme.no_reviews_yet') }}</p>
                @else
                    <ul class="space-y-3">
                        @foreach($product->approvedReviews as $review)
                            <li class="sf-card p-4">
                                <div class="flex flex-wrap items-center justify-between gap-x-4 gap-y-1">
                                    <div class="flex flex-wrap items-center gap-2">
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
                @endif
            </div>

            <div class="sf-card p-4">
                @auth('user')
                    <h3 class="mb-3 text-md font-bold text-ink-900">{{ __('theme.leave_review') }}</h3>

                    <form id="review-form" class="space-y-3">
                        @csrf
                        <input type="hidden" name="user_id" value="{{ auth('user')->id() }}">
                        <input type="hidden" name="product_onec_id" value="{{ $product->onec_id }}">
                        <input type="hidden" name="score" id="review-score" value="5" required>

                        <div>
                            <span class="sf-label">{{ __('theme.your_rating') }}</span>
                            <div class="flex gap-1" id="star-rating">
                                @for($i = 1; $i <= 5; $i++)
                                    <button
                                        type="button"
                                        class="p-0.5 text-accent-400 transition-transform hover:scale-110"
                                        data-rating="{{ $i }}"
                                        aria-label="{{ $i }}"
                                    >
                                        <x-sf-icon name="star" :size="24" stroke-width="1.5" style="fill: currentColor" />
                                    </button>
                                @endfor
                            </div>
                        </div>

                        <label class="block">
                            <span class="sf-label">{{ __('theme.your_review') }}</span>
                            <textarea
                                name="text"
                                id="review-text"
                                rows="4"
                                class="sf-field resize-y"
                                placeholder="{{ __('theme.write_your_review') }}"
                                required
                                minlength="10"
                                maxlength="2000"
                            ></textarea>
                            <span class="sf-hint">{{ __('theme.min_characters') }}: 10</span>
                        </label>

                        <button type="submit" class="sf-btn-primary sf-btn-block">{{ __('theme.submit_review') }}</button>
                    </form>
                @else
                    <p class="text-center text-sm text-ink-600">
                        {{ __('theme.login_to_review') }}
                        <a href="javascript:;" data-sf-auth-open class="font-medium text-brand-600 hover:text-brand-700">
                            {{ __('theme.login-registration') }}
                        </a>
                    </p>
                @endauth
            </div>
        </div>
    </div>
</section>

@auth('user')
    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                var rating = document.getElementById('star-rating');
                var score = document.getElementById('review-score');
                var form = document.getElementById('review-form');
                if (!rating || !form) return;

                var stars = rating.querySelectorAll('button');

                /* Stars are drawn filled and dimmed past the current value —
                   one class toggle instead of the old swap between two icon
                   font classes plus inline colours. */
                var paint = function (value) {
                    stars.forEach(function (star, index) {
                        star.classList.toggle('text-accent-400', index < value);
                        star.classList.toggle('text-ink-200', index >= value);
                    });
                };

                stars.forEach(function (star) {
                    star.addEventListener('click', function () {
                        score.value = star.dataset.rating;
                        paint(Number(score.value));
                    });
                    star.addEventListener('mouseenter', function () {
                        paint(Number(star.dataset.rating));
                    });
                });

                rating.addEventListener('mouseleave', function () { paint(Number(score.value)); });
                paint(Number(score.value));

                form.addEventListener('submit', function (event) {
                    event.preventDefault();

                    var button = form.querySelector('button[type=submit]');
                    var label = button.textContent;
                    button.disabled = true;
                    button.textContent = @json(__('theme.sending')) + '…';

                    fetch(@json(route('theme.review.store')), {
                        method: 'POST',
                        body: new FormData(form),
                        headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content },
                    })
                        .then(function (response) { return response.json(); })
                        .then(function (data) {
                            if (!data.success) {
                                window.toastr && window.toastr.error(data.message);
                                return;
                            }
                            window.toastr && window.toastr.success(data.message);
                            form.reset();
                            score.value = '5';
                            paint(5);
                            setTimeout(function () { location.reload(); }, 1500);
                        })
                        .catch(function () {
                            window.toastr && window.toastr.error(@json(__('theme.error_occurred')));
                        })
                        .finally(function () {
                            button.disabled = false;
                            button.textContent = label;
                        });
                });
            });
        </script>
    @endpush
@endauth
