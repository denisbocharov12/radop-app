{{-- Review form for signed-in customers (used by reviews.blade.php). --}}
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
                <button type="button" class="p-0.5 text-accent-400 transition-transform hover:scale-110" data-rating="{{ $i }}" aria-label="{{ $i }}">
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

@once
    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                var rating = document.getElementById('star-rating');
                var score = document.getElementById('review-score');
                var form = document.getElementById('review-form');
                if (!rating || !form) return;

                var stars = rating.querySelectorAll('button');
                var paint = function (value) {
                    stars.forEach(function (star, index) {
                        star.classList.toggle('text-accent-400', index < value);
                        star.classList.toggle('text-ink-200', index >= value);
                    });
                };

                stars.forEach(function (star) {
                    star.addEventListener('click', function () { score.value = star.dataset.rating; paint(Number(score.value)); });
                    star.addEventListener('mouseenter', function () { paint(Number(star.dataset.rating)); });
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
                        headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content, Accept: 'application/json' },
                    })
                        .then(function (response) { return response.json(); })
                        .then(function (data) {
                            if (!data.success) { window.toastr && window.toastr.error(data.message); return; }
                            window.toastr && window.toastr.success(data.message);
                            form.reset();
                            score.value = '5';
                            paint(5);
                            setTimeout(function () { location.reload(); }, 1500);
                        })
                        .catch(function () { window.toastr && window.toastr.error(@json(__('theme.error_occurred'))); })
                        .finally(function () { button.disabled = false; button.textContent = label; });
                });
            });
        </script>
    @endpush
@endonce
