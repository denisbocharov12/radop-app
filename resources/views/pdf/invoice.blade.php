<!DOCTYPE html>
<html lang="ru">
<head>
    <style>
        *, *::before, *::after {
            box-sizing: border-box;
        }
        html, body, div, span, applet, object, iframe,
        h1, h2, h3, h4, h5, h6, p, blockquote, pre,
        a, abbr, acronym, address, big, cite, code,
        del, dfn, em, img, ins, kbd, q, s, samp,
        small, strike, strong, sub, sup, tt, var,
        b, u, i, center,
        dl, dt, dd, ol, ul, li,
        fieldset, form, label, legend,
        table, caption, tbody, tfoot, thead, tr, th, td,
        article, aside, canvas, details, embed,
        figure, figcaption, footer, header, hgroup,
        menu, nav, output, ruby, section, summary,
        time, mark, audio, video {
            margin: 0;
            padding: 0;
            border: 0;
            font-size: 100%;
            font: inherit;
            vertical-align: baseline;
        }
        /* HTML5 display-role reset for older browsers */
        article, aside, details, figcaption, figure,
        footer, header, hgroup, menu, nav, section {
            display: block;
        }
        body {
            line-height: 1;
            text-align: left;
        }
        ol, ul {
            list-style: none;
        }
        blockquote, q {
            quotes: none;
        }
        blockquote:before, blockquote:after,
        q:before, q:after {
            content: '';
            content: none;
        }
        table {
            border-collapse: collapse;
            border-spacing: 0;
        }
        img{
            width: 100%;
            object-fit: cover;
        }
        .invoice-print{
            max-width: 700px;
            margin: 2rem auto;
            margin-top: 50px;
        }
        .invoice-head {
            flex-direction: row;
            padding-bottom: 1.5rem;
            display: flex;
            justify-content: space-between;
        }
        .invoice-contact{
            width: 300px;
        }
        .overline-title{
            font-size: 11px;
            line-height: 1.2;
            letter-spacing: 0.2em;
            color: #8094ae;
            text-transform: uppercase;
            font-weight: 700;
        }
        .invoice-contact-info h4{
            font-weight: 700;
            color: #364a63;
            font-size: 1.2rem;
        }
        .invoice-contact ul li:first-child {
            padding-top: 0;
        }
        .invoice-contact ul li {
            padding: 10px 0;
        }
        .invoice-contact ul .icon {
            line-height: 1.3;
            font-size: 1.1em;
            display: inline-block;
            vertical-align: top;
            margin-top: -2px;
            color: #854fff;
            margin-right: .5rem;
        }
        .invoice-contact ul .icon + span {
            display: inline-block;
            vertical-align: top;
            color: #8094ae;
        }
        .invoice-desc .title {
            text-transform: uppercase;
            color: #854fff;
            font-size: 1.5rem;
        }
        .invoice-desc ul li {
            padding: .25rem 0;
        }
        .invoice-desc ul span:first-child {
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #8094ae;
        }
        .invoice-desc ul span {
            font-weight: 500;
            color: #526484;
        }
        .invoice-desc ul span:last-child {
            padding-left: 0.75rem;
        }

        .invoice-desc ul span {
            font-size: 13px;
            font-weight: 500;
            color: #526484;
        }
        .invoice-desc{
            width: 210px;
            padding-top: 0;
            float: right;
        }
    </style>
    <style>
        h3,h4{margin-top:0;margin-bottom:.5rem;}
        ul{margin-top:0;margin-bottom:1rem;}
        img{vertical-align:middle;border-style:none;}
        table{border-collapse:collapse;}
        th{text-align:inherit;}
        h3{font-size:1.5rem;}
        h4{font-size:1.25rem;}
        .table{width:100%;margin-bottom:1rem;color:#526484;}
        .table th,.table td{padding:.5rem;vertical-align:top;border-top:1px solid #dbdfea;}
        .table thead th{vertical-align:bottom;border-bottom:2px solid #dbdfea;}
        .table-striped tbody tr:nth-of-type(odd){background-color:#f5f6fa;}
        .table-responsive{display:block;width:100%;overflow-x:auto;-webkit-overflow-scrolling:touch;}
        .text-center{text-align:center!important;}

        ul{list-style:none;margin:0;padding:0;}
        img{max-width:100%;}
        h3,h4{letter-spacing:-0.02em;}
        @media (min-width: 992px){
            h3{font-size:2rem;letter-spacing:-0.03em;}
            h4{font-size:1.5rem;}
        }
        .w-150px{width:150px!important;}
        .w-60{width:60%!important;}
        .table thead tr:last-child th{border-bottom:1px solid #dbdfea;}
        .table td:first-child,.table th:first-child{padding-left:1.25rem;}
        .table td:last-child,.table th:last-child{padding-right:1.25rem;}
        .table th{line-height:1.1;}
        .overline-title{font-size:11px;line-height:1.2;letter-spacing:0.2em;color:#8094ae;text-transform:uppercase;font-weight:700;}
        .fs-14px{font-size:14px;}
        .fs-18px{font-size:18px;}
        .invoice{position:relative;}
        .invoice-wrap{padding:1.25rem;border:1px solid #dbdfea;border-radius:4px;background:#fff;}
        .invoice-brand{padding-bottom:1.5rem;}
        .invoice-bills{font-size:12px;}
        .invoice-bills .table{min-width:580px;}
        .invoice-bills .table th{color:#854fff;font-size:12px;text-transform:uppercase;border-top:0;}
        .invoice-bills .table th:last-child,.invoice-bills .table td:last-child{text-align:right;}
        .invoice-bills .table tfoot{border-top:1px solid #dbdfea;}
        .invoice-bills .table tfoot td{border-top:0;white-space:nowrap;padding-top:.25rem;padding-bottom:.25rem;}
        .invoice-bills .table tfoot tr:last-child td:not(:first-child),.invoice-bills .table tfoot tr:first-child td:not(:first-child){font-weight:500;padding-top:1.25rem;padding-bottom:.25rem;}
        .invoice-bills .table tfoot tr:last-child td:not(:first-child){border-top:1px solid #dbdfea;padding-top:.25rem;padding-bottom:.25rem;}
        .invoice-head{padding-bottom:1.5rem;display:flex;justify-content:space-between;flex-direction:column;}
        .invoice-desc{width:210px;padding-top:1.5rem;}
        .invoice-desc .title{text-transform:uppercase;color:#854fff;}
        .invoice-desc ul li{padding:.25rem 0;}
        .invoice-desc ul span{font-size:13px;font-weight:500;color:#526484;}
        .invoice-desc ul span:first-child{text-transform:uppercase;letter-spacing:1px;color:#8094ae;}
        .invoice-desc ul span:last-child{padding-left:0.75rem;}
        .invoice-contact ul .icon{line-height:1.3;font-size:1.1em;display:inline-block;vertical-align:top;margin-top:-2px;color:#854fff;margin-right:.5rem;}
        .invoice-contact ul .icon+span{display:inline-block;vertical-align:top;color:#8094ae;}
        .invoice-print .invoice-wrap{padding:0;border:none!important;}
        @media (min-width: 768px){
            .invoice-wrap{padding:3rem;}
            .invoice-head{flex-direction:row;}
            .invoice-desc{padding-top:0;}
            .invoice-bills{font-size:.875rem;}
        }

    </style>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
</head>
<body class="bg-white">
<div class="nk-block">
    <div class="invoice invoice-print">
        <div class="invoice-wrap">
            <div class="invoice-brand text-center" style="display: flex;align-items: center;justify-content: center;text-align: center">
                <img style="width: 100px; display: flex; align-items: center;justify-content: center" src="https://floradelivery.md/wp-content/uploads/2022/03/logo-white-1.jpg" alt="">
            </div>
            <div class="invoice-head">
                <div class="invoice-contact">
                    <span class="overline-title">Инвойс к</span>
                    <div class="invoice-contact-info">
                        <h4 class="title">{{$order?->fio}}</h4>
                        <ul class="list-plain">
                            <li><em class="icon ni ni-map-pin-fill fs-18px"></em><span>{{$order->address}}</span></li>
                            <li><em class="icon ni ni-call-fill fs-14px"></em><span>{{$order->phone}}</span></li>
                        </ul>
                    </div>
                </div>
                <div class="invoice-desc">
                    <h3 class="title">Invoice</h3>
                    <ul class="list-plain">
                        <li class="invoice-id"><span>Invoice ID</span>:<span>{{$order->order_number}}</span></li>
                        <li class="invoice-date"><span>Date</span>:<span>{{$order->created_at}}</span></li>
                    </ul>
                </div>
            </div><!-- .invoice-head -->
            <div class="invoice-bills" style="margin-top: 100px">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th class="w-150px">Item ID</th>
                            <th class="w-60">Description</th>
                            <th>Price</th>
                            <th>Qty</th>
                            <th>Amount</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($order->products as $item)
                            <tr>
                                <td>{{$item->product_id}}</td>
                                <td>{{$order->note}}</td>
                                <td>{{$item->price}} {{__('theme.MDL')}}</td>
                                <td>{{$item->quantity}}</td>
                                <td>{{$item->price * $item->quantity}} {{__('theme.MDL')}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                        <tfoot style="margin-top: 20px;">
                        <tr>
                            <td colspan="2"></td>
                            <td colspan="2">Всего</td>
                            <td>{{$order->subtotal}} {{__('theme.MDL')}}</td>
                        </tr>
                        <tr>
                            <td colspan="2"></td>
                            <td colspan="2">Доставка</td>
                            @if($order->delivery_charge == null)
                                <td>Бесплатно</td>
                            @else
                                <td>{{$order->delivery_charge}} {{__('theme.MDL')}}</td>
                            @endif

                        </tr>
                        @if($order->discount > 0)
                            <tr>
                                <td colspan="2"></td>
                                <td colspan="2">Скидка</td>
                                <td>{{$order->discount}} {{__('theme.MDL')}}</td>
                            </tr>
                        @endif
                        <tr>
                            <td colspan="2"></td>
                            <td colspan="2">К оплате</td>
                            <td>{{number_format((float)str_replace(',','', $order->total) + (float)str_replace(',','',$order->delivery_charge),2)}} {{__('theme.MDL')}}</td>
                        </tr>
                        </tfoot>
                    </table>
                </div>
            </div><!-- .invoice-bills -->
        </div><!-- .invoice-wrap -->
    </div><!-- .invoice -->
</div><!-- .nk-block -->
</body>
</html>
