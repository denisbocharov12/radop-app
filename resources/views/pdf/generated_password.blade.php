<!DOCTYPE html>
<html lang="ru">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
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
        .instruction{
            display: block;
            margin-bottom: 30px;
            border: 2px solid #0a2d6c;
            padding: 15px;
            border-radius: 4px;
        }
        .instruction .heading{
            font-size: 20px;
            margin-bottom: 10px;
            font-weight: 600;
        }
        .instruction .list{
            margin-top: 15px;
        }
        .instruction .list span{
            font-weight: 500;
        }
        .instruction .list li{
            margin-bottom: 5px;
        }
        .instruction .list img{
            margin-top: 5px;
        }
    </style>
    <style>
        /* Стили таблицы (IKSWEB) */
        table.iksweb{text-decoration: none;border-collapse:collapse;width:100%;text-align:center;}
        table.iksweb th{font-weight:normal;font-size:14px; color:#ffffff;background-color:#000000;}
        table.iksweb td{font-size:13px;color:#000000;}
        table.iksweb td,table.iksweb th{white-space:pre-wrap;padding:10px 5px;line-height:13px;vertical-align: middle;border: 1px solid #000000;}
        table.iksweb tr:hover{background-color:#f9fafb}
        table.iksweb tr:hover td{color:#000000;cursor:default;}
    </style>
</head>
<body class="bg-white">
<div class="nk-block">
    <div class="invoice invoice-print">
        <div class="invoice-wrap">
            <div style="display: flex; align-items: flex-start; justify-content: flex-start" class="invoice-header">
                <div class="autor" style="margin-top: 15px">
                    <p><span style="font-weight: bold">Автор:</span> {{$profile['first_name']}} {{$profile['last_name']}}</p>
                </div>
                <div class="otgruz" style="margin-top: 15px">
                    <p><span style="font-weight: bold">Контактный телефон:</span> {{$profile['phone']}}</p>
                </div>
                <div class="client" style="margin-top: 15px">
                    <p><span style="font-weight: bold">Логин:</span> {{$name}} <span style="font-weight: bold">или</span> {{$email}}</p>
                </div>
                <div class="client" style="margin-top: 15px">
                    <p><span style="font-weight: bold">Пароль:</span> {{$password}}</p>
                </div>
            </div>
        </div><!-- .invoice-wrap -->
    </div><!-- .invoice -->
</div><!-- .nk-block -->
</body>
</html>
