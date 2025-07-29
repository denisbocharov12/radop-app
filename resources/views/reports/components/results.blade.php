<div class="row g-3">
    <div class="col-md-3">
        <div class="card card-bordered">
            <div class="card-inner">
                <div class="text-center">
                    <h6 class="text-muted">Количество заказов</h6>
                    <h3 class="text-primary">{{ $reportData['count'] ?? 0 }}</h3>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card card-bordered">
            <div class="card-inner">
                <div class="text-center">
                    <h6 class="text-muted">Общая сумма</h6>
                    <h3 class="text-success">{{ number_format(($reportData['total_sum'] ?? 0) / 100, 2, ',', ' ') }} </h3>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card card-bordered">
            <div class="card-inner">
                <div class="text-center">
                    <h6 class="text-muted">Период</h6>
                    <h6 class="text-info">{{ $reportData['period']['start_date'] ?? '-' }} - {{ $reportData['period']['end_date'] ?? '-' }}</h6>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card card-bordered">
            <div class="card-inner">
                <div class="text-center">
                    <h6 class="text-muted">Менеджер</h6>
                    <h6 class="text-warning">{{ $managerName ?? 'Все менеджеры' }}</h6>
                </div>
            </div>
        </div>
    </div>
</div>
