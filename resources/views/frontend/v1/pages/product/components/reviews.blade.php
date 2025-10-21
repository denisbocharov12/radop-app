<section class="section-reviews mb-5">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="reviews-wrap">
                    <div class="reviews-header">
                        <h2 class="reviews-title">{{ __('theme.reviews') }}</h2>
                        <div class="reviews-summary">
                            @php
                                $averageScore = $product->approvedReviews()->avg('score') ?? 0;
                                $reviewsCount = $product->approvedReviews()->count();
                            @endphp
                            @if($reviewsCount > 0)
                                <div class="average-rating">
                                    <span class="rating-value">{{ number_format($averageScore, 1) }}</span>
                                    <div class="stars">
                                        @for($i = 1; $i <= 5; $i++)
                                            @if($i <= floor($averageScore))
                                                <i class="icon-star-fill"></i>
                                            @elseif($i - 0.5 <= $averageScore)
                                                <i class="icon-star-half"></i>
                                            @else
                                                <i class="icon-star"></i>
                                            @endif
                                        @endfor
                                    </div>
                                    <span class="reviews-count">({{ $reviewsCount }} {{ __('theme.reviews_count') }})</span>
                                </div>
                            @else
                                <p class="no-reviews-text">{{ __('theme.no_reviews_yet') }}</p>
                            @endif
                        </div>
                    </div>

                    @auth('user')
                        <div class="review-form-wrap mt-4">
                            <h3 class="form-title">{{ __('theme.leave_review') }}</h3>
                            <form id="review-form" class="review-form">
                                @csrf
                                <input type="hidden" name="user_id" value="{{ auth('user')->id() }}">
                                <input type="hidden" name="product_onec_id" value="{{ $product->onec_id }}">

                                <div class="form-group mb-3">
                                    <label for="score" class="form-label">{{ __('theme.your_rating') }}</label>
                                    <div class="rating-input">
                                        <div class="star-rating" id="star-rating">
                                            <i class="icon-star" data-rating="1"></i>
                                            <i class="icon-star" data-rating="2"></i>
                                            <i class="icon-star" data-rating="3"></i>
                                            <i class="icon-star" data-rating="4"></i>
                                            <i class="icon-star" data-rating="5"></i>
                                        </div>
                                        <input type="hidden" name="score" id="review-score" value="5" required>
                                    </div>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="review-text" class="form-label">{{ __('theme.your_review') }}</label>
                                    <textarea name="text" id="review-text" class="form-control" rows="4"
                                              placeholder="{{ __('theme.write_your_review') }}"
                                              required minlength="10" maxlength="2000"></textarea>
                                    <small class="form-text text-muted pt-2 d-block">{{ __('theme.min_characters') }}: 10</small>
                                </div>

                                <button type="submit" class="btn btn-primary">{{ __('theme.submit_review') }}</button>
                            </form>
                        </div>
                    @else
                        <div class="review-auth-notice mt-4 p-3">
                            <p>{{ __('theme.login_to_review') }} <a href="{{ route('user.login') }}">{{ __('theme.login-registration') }}</a></p>
                        </div>
                    @endauth

                    <div class="reviews-list mt-5" id="reviews-list">
                        @foreach($product->approvedReviews as $review)
                            <div class="review-item mb-4">
                                <div class="review-header">
                                    <div class="reviewer-info">
                                        <strong class="reviewer-name">
                                            @if($review->user)
                                                @if($review->user->type?->key_name === 'iur')
                                                    {{ $review->user->profile->organization_name ?? __('theme.deleted_user') }}
                                                @else
                                                    {{ $review->user->profile->first_name ?? '' }} {{ $review->user->profile->last_name ?? '' }}
                                                @endif
                                            @else
                                                {{ __('theme.deleted_user') }}
                                            @endif
                                        </strong>
                                        @if($review->is_verified)
                                            <span class="verified-badge">
                                                <i class="icon-check-circle"></i> {{ __('theme.verified_purchase') }}
                                            </span>
                                        @endif
                                    </div>
                                    <div class="review-meta">
                                        <div class="review-rating">
                                            @for($i = 1; $i <= 5; $i++)
                                                @if($i <= $review->score)
                                                    <i class="icon-star-fill"></i>
                                                @else
                                                    <i class="icon-star"></i>
                                                @endif
                                            @endfor
                                        </div>
                                        <span class="review-date">{{ $review->created_at->format('d.m.Y') }}</span>
                                    </div>
                                </div>
                                <div class="review-content mt-2">
                                    <p>{{ $review->text }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const starRating = document.getElementById('star-rating');
    const scoreInput = document.getElementById('review-score');

    if (starRating) {
        const stars = starRating.querySelectorAll('i');

        stars.forEach(star => {
            star.addEventListener('click', function() {
                const rating = this.getAttribute('data-rating');
                scoreInput.value = rating;

                stars.forEach((s, index) => {
                    if (index < rating) {
                        s.classList.remove('icon-star');
                        s.classList.add('icon-star-fill', 'active');
                    } else {
                        s.classList.remove('icon-star-fill', 'active');
                        s.classList.add('icon-star');
                    }
                });
            });

            star.addEventListener('mouseenter', function() {
                const rating = this.getAttribute('data-rating');
                stars.forEach((s, index) => {
                    if (index < rating) {
                        s.style.color = '#ffa500';
                    } else {
                        s.style.color = '#ddd';
                    }
                });
            });
        });

        starRating.addEventListener('mouseleave', function() {
            const currentRating = scoreInput.value;
            stars.forEach((s, index) => {
                if (index < currentRating) {
                    s.style.color = '#ffa500';
                } else {
                    s.style.color = '#ddd';
                }
            });
        });
    }

    const reviewForm = document.getElementById('review-form');
    if (reviewForm) {
        reviewForm.addEventListener('submit', function(e) {
            e.preventDefault();

            const formData = new FormData(this);
            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.textContent;

            submitBtn.disabled = true;
            submitBtn.textContent = '{{ __('theme.sending') }}...';

            fetch('{{ route('theme.review.store') }}', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    toastr.success(data.message);
                    reviewForm.reset();
                    scoreInput.value = '5';

                    const stars = starRating.querySelectorAll('i');
                    stars.forEach((s, index) => {
                        if (index < 5) {
                            s.classList.remove('icon-star');
                            s.classList.add('icon-star-fill', 'active');
                        } else {
                            s.classList.remove('icon-star-fill', 'active');
                            s.classList.add('icon-star');
                        }
                    });

                    setTimeout(() => {
                        location.reload();
                    }, 2000);
                } else {
                    toastr.error(data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                toastr.error('{{ __('theme.error_occurred') }}');
            })
            .finally(() => {
                submitBtn.disabled = false;
                submitBtn.textContent = originalText;
            });
        });
    }
});
</script>

