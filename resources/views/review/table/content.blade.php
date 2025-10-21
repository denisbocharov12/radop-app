<div class="card-inner p-0">
    <div class="nk-tb-list nk-tb-ulist">
        <div class="nk-tb-item nk-tb-head">
            <div class="nk-tb-col"><span class="sub-text">ID</span></div>
            <div class="nk-tb-col"><span class="sub-text">Пользователь</span></div>
            <div class="nk-tb-col tb-col-lg"><span class="sub-text">Товар</span></div>
            <div class="nk-tb-col"><span class="sub-text">Оценка</span></div>
            <div class="nk-tb-col"><span class="sub-text">Текст</span></div>
            <div class="nk-tb-col"><span class="sub-text">Статус</span></div>
            <div class="nk-tb-col"><span class="sub-text">Подтвержден</span></div>
            <div class="nk-tb-col"><span class="sub-text">Дата</span></div>
            <div class="nk-tb-col nk-tb-col-tools text-end">
            </div>
        </div><!-- .nk-tb-item -->
        @foreach($reviews as $review)
            <div class="nk-tb-item" id="review-id-{{$review->id}}">
                <div class="nk-tb-col">
                    <span>#{{$review->id}}</span>
                </div>
                <div class="nk-tb-col">
                    <span>
                        @if($review->user)
                            @if($review->user->type?->key_name === 'iur')
                                {{ $review->user->profile->organization_name ?? 'Удален' }}
                            @else
                                {{ $review->user->profile->first_name ?? '' }} {{ $review->user->profile->last_name ?? '' }}
                            @endif
                        @else
                            Удален
                        @endif
                    </span>
                </div>
                <div class="nk-tb-col tb-col-lg">
                    <span>{{$review->product->title ?? 'Удален'}}</span>
                </div>
                <div class="nk-tb-col">
                    <span class="badge badge-dim bg-warning">
                        <em class="icon ni ni-star-fill"></em> {{$review->score}}
                    </span>
                </div>
                <div class="nk-tb-col">
                    <span>{{ Str::limit($review->text, 50) }}</span>
                </div>
                <div class="nk-tb-col">
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input review-status-toggle" 
                               id="review-status-{{$review->id}}" 
                               data-id="{{$review->id}}"
                               {{$review->status ? 'checked' : ''}}>
                        <label class="custom-control-label" for="review-status-{{$review->id}}">
                            @if($review->status)
                                <span class="badge badge-dim bg-success">Одобрен</span>
                            @else
                                <span class="badge badge-dim bg-warning">На модерации</span>
                            @endif
                        </label>
                    </div>
                </div>
                <div class="nk-tb-col">
                    @if($review->is_verified)
                        <span class="badge badge-dim bg-success"><em class="icon ni ni-check-circle"></em> Да</span>
                    @else
                        <span class="badge badge-dim bg-secondary">Нет</span>
                    @endif
                </div>
                <div class="nk-tb-col">
                    <span>{{$review->created_at->format('d.m.Y H:i')}}</span>
                </div>
                <div class="nk-tb-col nk-tb-col-tools">
                    <ul class="nk-tb-actions gx-2">
                        <li>
                            <div class="drodown">
                                <a href="#" class="btn btn-sm btn-icon btn-trigger dropdown-toggle" data-bs-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <ul class="link-list-opt no-bdr">
                                        <li><a href="{{route('review.edit', $review)}}" data-id="{{$review->id}}" ><em class="icon ni ni-edit"></em><span>Редактировать</span></a></li>
                                        <li><a href="#" class="review-delete" id="review-delete-{{$review->id}}" data-id="{{$review->id}}"><em class="icon ni ni-delete"></em><span>Удалить</span></a></li>
                                    </ul>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div><!-- .nk-tb-item -->
        @endforeach
    </div><!-- .nk-tb-list -->
</div><!-- .card-inner -->

