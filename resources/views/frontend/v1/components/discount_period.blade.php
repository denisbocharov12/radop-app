@php
    $foundedDiscountPeriod = null;
        $sum = \Cart::session($sessionId)->getTotal();
        foreach (\App\Models\DiscountPeriod::orderBy('order')->get() as $discountPeriod) {
            if ($discountPeriod->sum_to >= $sum && $discountPeriod->sum_from <= $sum) {
                $foundedDiscountPeriod = $discountPeriod;
            }
        }
    $nextFoundedDiscountPeriod = \App\Models\DiscountPeriod::where('order', (int)$foundedDiscountPeriod->order + 1)->first();
@endphp
@if($foundedDiscountPeriod !== null)
    <li class="item">
        <span class="left">{{__('theme.discount')}} </span><span class="right theme-bold">{{number_format(($foundedDiscountPeriod->discount_koef * \Cart::session($sessionId)->getTotal()) / 100 , 2, ',', '')}} {{__('theme.MDL')}}</span>
    </li>
@endif
@if($nextFoundedDiscountPeriod !== null)
    <li class="item">
        <span class="left">{{__('theme.sum_to_period_discount', ['koef' => $nextFoundedDiscountPeriod->discount_koef])}}</span><span class="right">{{number_format($foundedDiscountPeriod->sum_to - \Cart::session($sessionId)->getTotal(), 2, ',', '')}} {{__('theme.MDL')}}</span>
    </li>
@endif
