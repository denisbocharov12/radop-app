<div class="card-inner p-0">
    <div class="nk-tb-list nk-tb-ulist">
        <div class="nk-tb-item nk-tb-head">
            <div class="nk-tb-col"><span class="sub-text">ID</span></div>
            <div class="nk-tb-col"><span class="sub-text">От</span></div>
            <div class="nk-tb-col"><span class="sub-text">До</span></div>
            <div class="nk-tb-col"><span class="sub-text">Коэфициент</span></div>
            <div class="nk-tb-col nk-tb-col-tools text-end">
            </div>
        </div><!-- .nk-tb-item -->
        @foreach($discountPeriods as $discountPeriod)
            <div class="nk-tb-item" id="model-id-{{$discountPeriod->id}}">
                <div class="nk-tb-col">
                    <span>#{{$discountPeriod->id}}</span>
                </div>
                <div class="nk-tb-col">
                    <span>{{$discountPeriod->sum_from}}</span>
                </div>
                <div class="nk-tb-col">
                    <span>{{$discountPeriod->sum_to}}</span>
                </div>
                <div class="nk-tb-col">
                    <span class="tb-status text-success">{{(float)$discountPeriod->discount_koef}}</span>
                </div>
                <div class="nk-tb-col nk-tb-col-tools">
                    <ul class="nk-tb-actions gx-2">
                        <li>
                            <div class="drodown">
                                <a href="#" class="btn btn-sm btn-icon btn-trigger dropdown-toggle" data-bs-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <ul class="link-list-opt no-bdr">
                                        <li><a href="{{route('discount-period.edit', $discountPeriod)}}" data-id="{{$discountPeriod->id}}" ><em class="icon ni ni-edit"></em><span>Редактировать</span></a></li>
                                        <li><a href="#" class="model-delete" id="model-delete-{{$discountPeriod->id}}" data-id="{{$discountPeriod->id}}"><em class="icon ni ni-delete"></em><span>Удалить</span></a></li>
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
