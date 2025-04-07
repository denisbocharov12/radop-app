<div style="display: none; max-width: 800px" id="salesPeriodModal">
    <div class="modal-wrap">
        <div class="row">
            <div class="col-12">
                <div class="theme-head d-flex align-items-center justify-content-center">
                    <h3>{{__('theme.sales_period_table_heading')}}</h3>
                </div>
            </div>
        </div>
        @foreach(\App\Models\DiscountPeriod::orderBy('order')->get() as $discountPeriod)
            <div class="row mb-3">
                <div class="col-4">
                    <p>Сумма от: {{$discountPeriod->sum_from}} {{__('theme.MDL')}}</p>
                </div>
                <div class="col-4">
                    <p>Сумма до: {{$discountPeriod->sum_to}} {{__('theme.MDL')}}</p>
                </div>
                <div class="col-4">
                    <p>Скидка: {{$discountPeriod->discount_koef}} %</p>
                </div>
            </div>
        @endforeach
    </div>
</div>
