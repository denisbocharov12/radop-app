@extends('v1.layouts.layout')

@section('content')
    <div class="nk-content">
        <div class="container-fluid">
            <div class="nk-content-inner">
                <div class="nk-content-body">

                    <div class="nk-block-head nk-block-head-sm">
                        <div class="nk-block-between">
                            <div class="nk-block-head-content">
                                <h3 class="nk-block-title page-title">{{ __('product_errors.page_title') }}</h3>
                                <div class="nk-block-des text-soft">
                                    <p>{{ __('product_errors.subtitle', ['rows' => $summary['rows'], 'products' => $affectedProducts]) }}</p>
                                </div>
                            </div>
                            <div class="nk-block-head-content">
                                <ul class="nk-block-tools g-3">
                                    <li>
                                        <a href="{{ route('product.index') }}" class="btn btn-white btn-outline-light">
                                            <em class="icon ni ni-arrow-left"></em><span>{{ __('product_errors.back_to_products') }}</span>
                                        </a>
                                    </li>
                                    <li>
                                        <form action="{{ route('product.errors.rescan') }}" method="POST" onsubmit="this.querySelector('button').disabled=true;this.querySelector('button span').innerHTML='{{ __('product_errors.rescanning') }}';">
                                            @csrf
                                            <button type="submit" class="btn btn-primary">
                                                <em class="icon ni ni-reload"></em><span>{{ __('product_errors.rescan') }}</span>
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    @if(session('success'))
                        <div class="alert alert-success alert-icon"><em class="icon ni ni-check-circle"></em> {{ session('success') }}</div>
                    @endif

                    {{-- Summary cards --}}
                    <div class="row g-gs mb-3">
                        <div class="col-sm-4">
                            <div class="card card-bordered">
                                <div class="card-inner">
                                    <div class="card-title-group align-start mb-0">
                                        <div class="card-title"><h6 class="subtitle">{{ __('product_errors.card_critical') }}</h6></div>
                                    </div>
                                    <div class="card-amount"><span class="amount text-danger">{{ $summary['products_critical'] }}</span></div>
                                    <div class="text-soft" style="font-size: 12px;">{{ __('product_errors.card_critical_hint') }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="card card-bordered">
                                <div class="card-inner">
                                    <div class="card-title-group align-start mb-0">
                                        <div class="card-title"><h6 class="subtitle">{{ __('product_errors.card_minor') }}</h6></div>
                                    </div>
                                    <div class="card-amount"><span class="amount text-warning">{{ $summary['products_minor'] }}</span></div>
                                    <div class="text-soft" style="font-size: 12px;">{{ __('product_errors.card_minor_hint') }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="card card-bordered">
                                <div class="card-inner">
                                    <div class="card-title-group align-start mb-0">
                                        <div class="card-title"><h6 class="subtitle">{{ __('product_errors.card_affected') }}</h6></div>
                                    </div>
                                    <div class="card-amount"><span class="amount">{{ $affectedProducts }}</span></div>
                                    <div class="text-soft" style="font-size: 12px;">{{ __('product_errors.card_affected_hint') }}</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Filters --}}
                    <div class="card card-bordered mb-3">
                        <div class="card-inner">
                            <form action="{{ route('product.errors.index') }}" method="GET" class="row g-2 align-items-end">
                                <div class="col-md-3">
                                    <label class="form-label">{{ __('product_errors.filter_severity') }}</label>
                                    <select name="severity" class="form-select">
                                        <option value="">{{ __('product_errors.filter_all') }}</option>
                                        <option value="critical" {{ request('severity') === 'critical' ? 'selected' : '' }}>{{ __('product_errors.severities.critical') }}</option>
                                        <option value="minor" {{ request('severity') === 'minor' ? 'selected' : '' }}>{{ __('product_errors.severities.minor') }}</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">{{ __('product_errors.filter_type') }}</label>
                                    <select name="type" class="form-select">
                                        <option value="">{{ __('product_errors.filter_all') }}</option>
                                        @foreach($types as $typeKey => $typeLabel)
                                            <option value="{{ $typeKey }}" {{ request('type') === $typeKey ? 'selected' : '' }}>{{ $typeLabel }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">{{ __('product_errors.filter_search') }}</label>
                                    <input type="text" name="search" class="form-control" value="{{ e((string) request('search', '')) }}" placeholder="{{ __('product_errors.filter_search_ph') }}">
                                </div>
                                <div class="col-md-2">
                                    <button type="submit" class="btn btn-primary btn-block"><em class="icon ni ni-search"></em><span>{{ __('product_errors.filter_apply') }}</span></button>
                                </div>
                            </form>
                        </div>
                    </div>

                    {{-- Table --}}
                    <div class="nk-block">
                        <div class="card card-bordered card-stretch">
                            <div class="card-inner-group">
                                <div class="card-inner p-0">
                                    <table class="table table-tranx">
                                        <thead>
                                            <tr class="tb-tnx-head">
                                                <th><span>{{ __('product_errors.col_id') }}</span></th>
                                                <th><span>{{ __('product_errors.col_product') }}</span></th>
                                                <th><span>{{ __('product_errors.col_code') }}</span></th>
                                                <th><span>{{ __('product_errors.col_severity') }}</span></th>
                                                <th><span>{{ __('product_errors.col_type') }}</span></th>
                                                <th><span>{{ __('product_errors.col_message') }}</span></th>
                                                <th><span>{{ __('product_errors.col_action') }}</span></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($errors as $error)
                                                <tr class="tb-tnx-item">
                                                    <td><span class="tb-tnx-id">#{{ $error->product_id ?? '—' }}</span></td>
                                                    <td><span>{{ $error->product_title ?: '—' }}</span></td>
                                                    <td><span class="text-soft">{{ $error->product_onec_id }}</span></td>
                                                    <td>
                                                        @if($error->isCritical())
                                                            <span class="badge badge-dim badge-danger">{{ $error->severityLabel() }}</span>
                                                        @else
                                                            <span class="badge badge-dim badge-warning">{{ $error->severityLabel() }}</span>
                                                        @endif
                                                    </td>
                                                    <td><span>{{ $error->typeLabel() }}</span></td>
                                                    <td><span class="text-soft">{{ $error->localizedMessage() }}</span></td>
                                                    <td>
                                                        @if($error->product_id)
                                                            <a href="{{ route('product.edit', $error->product_id) }}" class="btn btn-sm btn-outline-primary">
                                                                <em class="icon ni ni-edit"></em><span>{{ __('product_errors.open') }}</span>
                                                            </a>
                                                        @else
                                                            <span class="text-soft">—</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="7" class="text-center p-4 text-soft">{{ __('product_errors.empty') }}</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                                @if($errors->hasPages())
                                    <div class="card-inner">
                                        {{ $errors->links() }}
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
