@extends('v1.layouts.layout')

@section('content')
    <div class="nk-content ">
        <div class="container-fluid">
            <div class="nk-content-inner">
                <div class="nk-content-body">
                    @include('v1.errors.errors')
                    <div class="nk-block nk-block-lg">
                        <div class="nk-block-head">
                            <div class="nk-block-between">
                                <div class="nk-block-head-content">
                                    <h4 class="title nk-block-title">
                                        Редактирование SEO записи — {{ strtoupper($seoMeta->locale) }}
                                        @if($seoMeta->ai_generated)
                                            <span class="badge bg-info ms-2 fs-6" title="Сгенерировано AI">AI</span>
                                        @endif
                                    </h4>
                                    <div class="text-soft small">{{ $pageTypes[$seoMeta->page_type] ?? $seoMeta->page_type }}{{ $seoMeta->page_id ? ' · ID: '.$seoMeta->page_id : '' }}</div>
                                </div>
                                <div class="nk-block-head-content">
                                    <button type="button" id="ai-regenerate-btn"
                                            class="btn btn-warning"
                                            data-seo-id="{{ $seoMeta->id }}">
                                        <em class="icon ni ni-spark me-1"></em> Регенерировать с AI
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-inner">
                                <form action="{{route('seo_meta.update', $seoMeta)}}" enctype="multipart/form-data" method="POST" class="form-validate is-alter">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="locale" value="{{$seoMeta->locale}}" required>
                                    <div class="row g-gs">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label" for="page_type">Тип страницы</label>
                                                <div class="form-control-wrap">
                                                    <select class="form-select" id="page_type" name="page_type" required>
                                                        <option value="">Выберите тип страницы</option>
                                                        @foreach($pageTypes as $value => $label)
                                                            <option value="{{ $value }}" {{ old('page_type', $seoMeta->page_type) == $value ? 'selected' : '' }}>
                                                                {{ $label }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label" for="page_id">ID страницы</label>
                                                <div class="form-control-wrap">
                                                    <input type="text" class="form-control @error('page_id') error @enderror" id="page_id" name="page_id" value="{{$seoMeta->page_id}}" placeholder="ID страницы">
                                                    @error('page_id')
                                                    <span id="fv-page-id-error" class="invalid">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label" for="title">Заголовок</label>
                                                <div class="form-control-wrap">
                                                    <input type="text" required class="form-control @error('title') error @enderror" id="title" name="title" value="{{$seoMeta->title}}" placeholder="Заголовок">
                                                    @error('title')
                                                    <span id="fv-title-error" class="invalid">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label" for="keywords">Ключевые слова</label>
                                                <div class="form-control-wrap">
                                                    <input type="text" class="form-control @error('keywords') error @enderror" id="keywords" name="keywords" value="{{$seoMeta->keywords}}" placeholder="Ключевые слова через запятую">
                                                    @error('keywords')
                                                    <span id="fv-keywords-error" class="invalid">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label class="form-label" for="description">Описание</label>
                                                <div class="form-control-wrap">
                                                    <textarea class="form-control @error('description') error @enderror" id="description" name="description" rows="4" placeholder="Описание">{{$seoMeta->description}}</textarea>
                                                    @error('description')
                                                    <span id="fv-description-error" class="invalid">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label" for="canonical">Каноническая ссылка</label>
                                                <div class="form-control-wrap">
                                                    <input type="text" class="form-control @error('canonical') error @enderror" id="canonical" name="canonical" value="{{$seoMeta->canonical}}" placeholder="Каноническая ссылка">
                                                    @error('canonical')
                                                    <span id="fv-canonical-error" class="invalid">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label" for="robots">Robots</label>
                                                <div class="form-control-wrap">
                                                    <input type="text" class="form-control @error('robots') error @enderror" id="robots" name="robots" value="{{$seoMeta->robots}}" placeholder="Robots">
                                                    @error('robots')
                                                    <span id="fv-robots-error" class="invalid">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label class="form-label">SEO изображение</label>
                                                <div class="form-control-wrap">
                                                    <div class="form-file">
                                                        <input type="file" name="attachments[]" multiple="" class="form-file-input" id="seoAttachments">
                                                        <label class="form-file-label" for="seoAttachments">Выбрать</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="nk-block-head nk-block-head-sm">
                                            <div class="nk-block-between g-3">
                                                <div class="nk-block-head-content">
                                                    <h3 class="nk-block-title page-title">SEO изображения</h3>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row g-gs">
                                            @foreach($seoMeta->getMedia('files') as $image)
                                                <div class="col-sm-6 col-lg-4 col-xxl-3" id="model-media-{{$image->id}}">
                                                    <div class="gallery card card-bordered">
                                                        <a class="gallery-image popup-image" href="{{$image->getUrl()}}">
                                                            <img class="w-100 rounded-top" src="{{$image->getUrl()}}" alt="">
                                                        </a>
                                                        <div class="gallery-body card-inner align-center justify-between flex-wrap g-2">
                                                            <div class="user-card">
                                                                <div class="user-info">
                                                                    <span class="lead-text">#{{$image->id}} - {{$image->name}}</span>
                                                                </div>
                                                            </div>
                                                            <div>
                                                                <a id="model-media-delete-{{$image->id}}" href="#" data-id="{{$image->id}}" data-model-id="{{$seoMeta->id}}" class="model-media-delete btn btn-p-0 btn-nofocus" title="Удалить"><em class="icon ni ni-trash"></em></a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                        <div class="col-12">
                                            <ul class="align-center flex-wrap flex-sm-nowrap gx-4 gy-2">
                                                <li>
                                                    <button type="submit" class="btn btn-primary">Обновить SEO запись</button>
                                                </li>
                                                <li>
                                                    <button type="button" class="btn btn-danger seo-delete-btn" data-id="{{ $seoMeta->id }}" data-page-type="{{ $pageTypes[$seoMeta->page_type] ?? $seoMeta->page_type }}">
                                                        <em class="icon ni ni-trash"></em>
                                                        <span>Удалить запись</span>
                                                    </button>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        // AI Regenerate
        $('#ai-regenerate-btn').on('click', function() {
            const btn = $(this);
            const seoId = btn.data('seo-id');

            if (!confirm('Регенерировать SEO данные с помощью AI?\nТекущие значения заголовка, описания и ключевых слов будут заменены.')) return;

            btn.prop('disabled', true).html('<em class="icon ni ni-loader ni-spin me-1"></em> Генерация...');

            $.ajax({
                url: '/admin/seo/' + seoId + '/regenerate',
                type: 'POST',
                data: { _token: '{{ csrf_token() }}' },
                success: function(response) {
                    if (response.status && response.data) {
                        const d = response.data;
                        if (d.title)       $('#title').val(d.title);
                        if (d.description) $('#description').val(d.description);
                        if (d.keywords)    $('#keywords').val(d.keywords);

                        if (typeof NioApp !== 'undefined' && NioApp.Toast) {
                            NioApp.Toast.success('SEO регенерирован. Сохраните форму для применения изменений.');
                        } else {
                            alert('SEO регенерирован. Нажмите "Обновить SEO запись" для сохранения.');
                        }
                    } else {
                        alert('Ошибка: ' + (response.message || 'Не удалось сгенерировать SEO'));
                    }
                },
                error: function(xhr) {
                    const res = xhr.responseJSON || {};
                    if (xhr.status === 429 || res.quota) {
                        const msg = res.message || 'Превышен лимит Gemini API. Попробуйте позже.';
                        if (typeof NioApp !== 'undefined' && NioApp.Toast) {
                            NioApp.Toast.warning('⚠️ ' + msg);
                        } else {
                            alert('⚠️ ' + msg);
                        }
                    } else {
                        const msg = res.message || 'Ошибка запроса. Проверьте GEMINI_API_KEY в .env';
                        alert('Ошибка: ' + msg);
                    }
                },
                complete: function() {
                    btn.prop('disabled', false).html('<em class="icon ni ni-spark me-1"></em> Регенерировать с AI');
                }
            });
        });

        $(document).on('click','.model-media-delete',function (e) {
            e.preventDefault();
            var image_id = $(this).data('id');
            var token = "{{csrf_token()}}";
            var path = "{{route('seo_meta.media.delete', $seoMeta)}}";
            $.ajax({
                url: path,
                type: "GET",
                dataType:"JSON",
                data:{
                    id: image_id,
                    _token: token
                },
                success:function (response) {
                    if(response.status) {
                        $('#model-media-'+image_id).fadeOut();
                    } else {
                    }
                }
            });
        });

        $(document).on('click', '.seo-delete-btn', function(e) {
            e.preventDefault();
            const id = $(this).data('id');
            const pageType = $(this).data('page-type');

            if (confirm(`Вы уверены, что хотите удалить SEO запись для "${pageType}"?`)) {
                const deleteBtn = $(this);

                deleteBtn.prop('disabled', true).html('<em class="icon ni ni-loader"></em><span>Удаление...</span>');

                $.ajax({
                    url: `/admin/seo/${id}/ajax-delete`,
                    type: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.status) {
                            if (typeof NioApp !== 'undefined' && NioApp.Toast) {
                                NioApp.Toast.success('Запись успешно удалена');
                            } else {
                                alert('Запись успешно удалена');
                            }

                            setTimeout(function() {
                                window.location.href = '{{ route("seo_meta.index") }}';
                            }, 1000);
                        } else {
                            if (typeof NioApp !== 'undefined' && NioApp.Toast) {
                                NioApp.Toast.error(response.message || 'Ошибка при удалении');
                            } else {
                                alert(response.message || 'Ошибка при удалении');
                            }
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Delete Error:', xhr, status, error);
                        if (typeof NioApp !== 'undefined' && NioApp.Toast) {
                            NioApp.Toast.error('Ошибка при удалении записи');
                        } else {
                            alert('Ошибка при удалении записи');
                        }
                    },
                    complete: function() {
                        deleteBtn.prop('disabled', false).html('<em class="icon ni ni-trash"></em><span>Удалить запись</span>');
                    }
                });
            }
        });
    </script>
@endsection
