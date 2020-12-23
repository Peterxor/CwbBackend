<!DOCTYPE html>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<head>
    <style>
         /* http://meyerweb.com/eric/tools/css/reset/
        v2.0 | 20110126
        License: none (public domain)
        */

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

        .main-content {
            border: solid;
            border-color: #225893;
            border-width: 0.2px;
            background: #fff;
        }

        .mail-content {
            width: 80%;
            margin: 10px auto;
        }

        .mail-logo {
            padding-top: 40px;
        }

        .mail-logo>img {
            width: 120px;
        }

        .mail-title {
            margin-top: 20px;
        }

        .mail-title>span {
            font-family: PingFangTC;
            font-size: 18px;
            font-weight: 500;
            font-stretch: normal;
            font-style: normal;
            line-height: normal;
            letter-spacing: 0.71px;
            color: #232528;
        }

        .mail-text {
            margin-top: 20px;
        }

        .mail-text>p {
            margin-top: 20px;
            font-family: PingFangTC;
            font-size: 15px;
            font-weight: normal;
            font-stretch: normal;
            font-style: normal;
            line-height: normal;
            letter-spacing: 0.77px;
            color: #27292e;
        }

        .order-list {
            margin-top: 20px;
        }

        .order-snumber {
            color: #225893;
        }

        .order-list-title {
            font-family: PingFangTC;
            font-size: 16px;
            font-weight: 500;
            font-stretch: normal;
            font-style: normal;
            line-height: normal;
            letter-spacing: 0.63px;
            color: #27292e;
        }

        .pay-info>div {
            font-family: PingFangTC;
            font-size: 15px;
            font-weight: normal;
            font-stretch: normal;
            font-style: normal;
            line-height: normal;
            letter-spacing: 0.77px;
            color: #4b4e57;
        }

        .order-table {
            margin-top: 20px;
            width: 100%;
            border: solid 1px #c8c8c8;
            background-color: #ffffff;
        }

        .order-table>thead>tr,
        tbody>tr {
            height: 40px;
        }

        .order-table-title {
            background-color: #464646;
        }

        .order-table-title>th {
            font-family: PingFangTC;
            font-size: 13px;
            font-weight: normal;
            font-stretch: normal;
            font-style: normal;
            line-height: normal;
            letter-spacing: normal;
            color: #fff;
            text-align: right;
            padding-right: 15px;
        }

        .order-table-sub {
            background-color: #225893;
        }

        .order-table-sub>th {
            font-family: PingFangTC;
            font-size: 13px;
            font-weight: normal;
            font-stretch: normal;
            font-style: normal;
            line-height: normal;
            letter-spacing: normal;
            color: #fff;
            text-align: right;
            padding-right: 15px;
        }

        .order-table-white {
            background-color: #fff;
        }

        .order-table-white>td {
            font-family: PingFangTC;
            font-size: 13px;
            font-weight: normal;
            font-stretch: normal;
            font-style: normal;
            line-height: normal;
            letter-spacing: normal;
            color: #424242;
            text-align: right;
            padding-right: 15px;
        }

        .order-table-total {
            background-color: #8ec8f8
        }

        .order-table-total-text {
            font-family: PingFangTC;
            font-size: 14px;
            font-weight: normal;
            font-stretch: normal;
            font-style: normal;
            line-height: normal;
            letter-spacing: normal;
            color: #424242;
            text-align: right;
            padding-right: 15px;
            padding: 10px;
        }

        .order-table-total-num {
            font-family: PingFangTC;
            font-size: 16px;
            font-weight: 500;
            font-stretch: normal;
            font-style: normal;
            line-height: normal;
            letter-spacing: 0.46px;
            text-align: center;
            color: #225893;
            text-align: right;
            padding-right: 15px;
        }

        .order-table-spec {
            flex-direction: row;
            justify-content: flex-start;
            display: flex;
            margin-left: 15px;
            padding: 10px 0;
        }

        .contact {
            margin-top: 20px;
        }

        .contact-list {
            padding-left: 0px;
            list-style-type: none;
        }

        .contact-list>li {
            font-family: PingFangTC;
            font-size: 13px;
            font-weight: normal;
            font-stretch: normal;
            font-style: normal;
            line-height: 1.92;
            letter-spacing: 0.66px;
        }

        .text-style-1 {
            font-size: 15px;
            font-weight: 500;
            letter-spacing: 0.77px;
            color: #232528;
        }

        .text-style-2 {
            font-size: 15px;
            letter-spacing: 0.77px;
            color: #232528;
        }

        .order-link {
            padding-bottom: 40px;
        }

        .order-link>a {
            text-decoration: none;
            overflow-wrap: break-word;
            font-family: PingFangTC;
            font-size: 15px;
            font-weight: normal;
            font-stretch: normal;
            font-style: normal;
            line-height: 1.92;
            letter-spacing: 0.66px;
            color: #225893;
        }

        .warn-bottom {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 60px;
            background-color: #225893;
            border-top: solid 1px #c8c8c8;
            font-family: PingFangTC;
            font-size: 15px;
            font-weight: 500;
            font-stretch: normal;
            font-style: normal;
            line-height: 1.67;
            letter-spacing: 0.77px;
            color: #fff;
        }
    </style>
</head>

<body>
    <div class="main-content">
        <div class="mail-content">
            <div class="mail-logo"><img src="{{env('APP_URL')}}/images/headerlogo.png" /></div>
            <div class="mail-title"><span>課程付款成功通知</span></div>
            <div class="mail-text">
                <p>Dear {{$data->receive_name}}</p>
                <p>您的報名編號 <span class="order-snumber"><a href="###">{{$data->sn}}</a></span> 已順利完成付款，系統已建立您的報名資料，課程相關內容若有任何疑問請透過電子信箱或電話聯絡，謝謝。
                </p>
            </div>
            <div class="order-list">
                <p class="order-list-title">課程明細</p>
                <table class="order-table" cellspacing="0" cellpadding="0">
                    <thead>
                        <tr>
                            <th colspan="4">{{$data->product_name}}</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="order-table-title">
                            <th class="order-table-spec" colspan="2">商品規格</th>
                            <th colspan="1">數量</th>
                            <th colspan="1">小計</th>
                        </tr>
                        @foreach($data->orderProduct as $dimension_info)
                        <tr class="order-table-white">
                            <td class="order-table-spec" colspan="2">{{$dimension_info->product_name}}</td>
                            <td colspan="1">{{$dimension_info->quantity}}</td>
                            <td colspan="1">$ {{$dimension_info->subtotal}}</td>
                        </tr>
                        @endforeach
                        <tr class="order-table-total">
                            <td colspan="1"></td>
                            <td class="order-table-total-text" colspan="1">總金額</td>
                            <td class="order-table-total-num" colspan="1">{{$data->total_amount}}</td>
                        </tr>
                    </tbody>
                </table>

            </div>

            <div class="contact">
                <ul class="contact-list">
                    <li><span class="text-style-1">賣家信箱｜</span><span class="text-style-2">{{$data->website->email}}</span></li>
                    <li><span class="text-style-1">賣家電話｜</span><span class="text-style-2">{{$data->website->phone}}</span></li>
                    <li><span class="text-style-1">賣家地址｜</span><span class="text-style-2">{{$data->website->address}}</span></li>
                </ul>
            </div>
            <div class="order-link"><a href="{{$frontend_home}}" target="_blank">賀伯特首頁</a></div>
        </div>
        <div class="warn-bottom">為確保您的權益，請提高警覺預防詐騙</div>
    </div>

</body>

</html>
