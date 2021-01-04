@extends('backend.layouts.app')
@section('content')

    <!-- begin:: Content Head -->
    <div class="kt-subheader  kt-grid__item" id="kt_subheader">
        <div class="kt-container  kt-container--fluid ">
            <div class="kt-subheader__main">
                <h3 class="kt-subheader__title">Dashboard</h3>
                <span class="kt-subheader__separator kt-subheader__separator--v"></span>
            </div>
        </div>
    </div>
    <!-- end:: Content Head -->
    <!-- begin:: Content -->
    <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
        @foreach($devices as $device)
            <div class="kt-portlet">
                <div class="kt-portlet__head">
                    <div class="kt-portlet__head-label">
                        <h3 class="kt-portlet__head-title">
                            {{$device->name}}（21:9）
                        </h3>
                    </div>
                </div>
                <div class="kt-portlet__body">
                    <div class="kt-section kt-section--first">

                        <div class="form-group row">
                            <div class="col-6">
                                <label for="example-search-input" class="col-12 col-form-label">
                                <span class="kt-badge kt-badge--lg kt-badge--rounded" style="font-size: 22px"><i
                                        class="la la-user"></i></span>預報主播
                                </label>
                                <div class="col-12 row">
                                    <div class="col-6">
                                        <select class="form-control" id="device-host-{{$device->id}}" name="user" disabled>
                                            <option value="0" selected>不指定主播</option>
                                            {{ Widget::UserSelect(['selected'=>$device->user_id ?? null])}}
                                        </select>
                                    </div>
                                    <div class="col-3 kt-align-left">
                                        <button class="btn btn-primary" data-device-id="{{$device->id}}"
                                                name="save_user_btn" style="display:none;">儲存
                                        </button>
                                        <button class="btn btn-outline-secondary" name="change_user_btn">變更</button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <label for="example-search-input" class="col-12 col-form-label">
                                <span class="kt-badge kt-badge--lg kt-badge--rounded" style="font-size: 22px"><i
                                        class="la la-paint-brush"></i></span>佈景主題
                                </label>
                                <div class="col-12 row">
                                    <div class="col-6">
                                        <select class="form-control" name="layout" disabled>
                                            <option value="1" selected>自然</option>
                                            <option value="2">科技藍</option>
                                            <option value="3">工業橘</option>
                                            <option value="4">現代紅</option>
                                        </select>
                                    </div>
                                    <div class="col-3 kt-align-left">
                                        <button class="btn btn-primary" name="save_layout_btn" style="display:none;">儲存
                                        </button>
                                        <button class="btn btn-outline-secondary" name="change_layout_btn">變更</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-6">
                                <label for="example-search-input" class="col-4 col-form-label">
                                <span class="kt-badge kt-badge--lg kt-badge--rounded" style="font-size: 22px"><i
                                        class="la la-commenting"></i></span>預報看板
                                </label>
                                <button class="btn btn-primary" name="edit_btn" data-toggle="modal" data-target="#edit-modal">編輯看板內容</button>
                                <input type="hidden" name="people_1" value="伍婉華">
                                <input type="hidden" name="people_2" value="丘安">
                                <input type="hidden" name="news_status" value="1">
                                <input type="hidden" name="next_news_status" value="0">
                                <input type="hidden" name="news_time" value="11:40">
                                <input type="hidden" name="next_news_time" value="">
                            </div>
                            <div class="col-6">

                            </div>
                        </div>
                        {{-- 預設版型 --}}
                        <div class="form-group row js-default-block" style="padding-left:30px;display:none;">
                            <div class="col-6 row" style="background-color:#efefef">
                                <div class="col-4">
                                    <label for="example-search-input" class="col-form-label">
                                        <span class="kt-badge kt-badge--dark kt-badge--inline kt-badge--pill kt-badge--rounded">人員1</span>
                                    </label>
                                    <label for="example-search-input" class="col-form-label col-6">
                                        <span>伍婉華</span>
                                    </label>
                                </div>
                                <div class="col-8">
                                    <label for="example-search-input" class="col-form-label">
                                        <span class="kt-badge kt-badge--dark kt-badge--inline kt-badge--pill kt-badge--rounded">本場次記者會</span>
                                    </label>
                                    <label for="example-search-input" class="col-form-label col-6">
                                        <span>11：40 AM</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-6">

                            </div>
                            <div class="col-6 row" style="background-color:#efefef">
                                <div class="col-4">
                                    <label for="example-search-input" class="col-form-label">
                                        <span class="kt-badge kt-badge--dark kt-badge--inline kt-badge--pill kt-badge--rounded">人員2</span>
                                    </label>
                                    <label for="example-search-input" class="col-form-label col-6">
                                        <span>丘安</span>
                                    </label>
                                </div>
                                <div class="col-8">
                                    <label for="example-search-input" class="col-form-label">
                                        <span class="kt-badge kt-badge--dark kt-badge--inline kt-badge--pill kt-badge--rounded">下場次記者會</span>
                                    </label>
                                    <label for="example-search-input" class="col-form-label col-6">
                                        <span>無</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-6">

                            </div>
                        </div>
                        {{-- 上傳圖片 --}}
                        <div class="form-group row js-upload-block" style="padding-left:30px;display:none;">
                            <div class="col-4">
                                <label for="example-search-input" class="col-form-label">
                                    <span class="kt-badge kt-badge--dark kt-badge--inline kt-badge--pill kt-badge--rounded">上傳圖片</span>
                                </label>
                                <label for="example-search-input" class="col-form-label">
                                    <span>202012311140-press</span>
                                </label>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-6">
                                <label for="example-search-input" class="col-4 col-form-label">
                                <span class="kt-badge kt-badge--lg kt-badge--rounded" style="font-size: 22px"><i
                                        class="la la-desktop"></i></span>颱風主播圖卡
                                </label>
                                <a href="{{route('dashboard.edit', ['dashboard'=> $device->id, 'pic_type' => 'typhoon'])}}"
                                   class="btn btn-primary">編輯主播圖卡</a>
                            </div>
                            <div class="col-6">
                                <label for="example-search-input" class="col-4 col-form-label">
                                <span class="kt-badge kt-badge--lg kt-badge--rounded" style="font-size: 22px"><i
                                        class="la la-desktop"></i></span>天氣預報排程
                                </label>
                                <a href="{{route('dashboard.edit', ['dashboard' => $device->id, 'pic_type' => 'forecast'])}}"
                                   class="btn btn-primary">編輯預報排程</a>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                            <div class="col-6 row">
                                @if(isset($device->decode_typhoon))
                                    @foreach($device->decode_typhoon as $index => $f)
                                        @if(!($index%3))
                                            <div class="col-empty"></div>
                                        @endif
                                        <div class="col-4 layout-container"
                                             style="background-image:url({{$f->img_url ?? '/images/login/logo.png'}});">

                                            <div class="row layout-text">
                                                <label>{{$index + 1 }}. {{$f->img_name ?? ''}}</label>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                            <div class="col-6 row">
                                @if(isset($device->decode_forecast))
                                    @foreach($device->decode_forecast as $index => $f)
                                        @if(!($index%3))
                                            <div class="col-empty"></div>
                                        @endif
                                        <div class="col-4 layout-container"
                                             style="background-image:url({{$f->img_url ?? '/images/login/logo.png'}});">

                                            <div class="row layout-text">
                                                <label>{{$index + 1 }}. {{$f->img_name ?? ''}}</label>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </div>
    @endforeach
    <style>
        .col-empty {
            flex: 0 0 50%;
            max-width: 5%;
        }

        .layout-container {
            max-width: 30%;
            height: 100px;
            background-repeat: no-repeat;
            background-position: center;
            background-size: cover;
            margin-bottom: 50px;
            margin-left: 5px;
            border-style: solid;
            border-color: black;
            border-width: 1px;
        }

        .layout-text {
            margin-top: 110px;
        }

    </style>
    <!-- end:: Content -->
@include('backend.pages.dashboard._index_modal')
@endsection

@section('pages_scripts')
    {!! Html::script('vendor/audit/bootstrap-timepicker.min.js') !!}
    {!! Html::script(env('URL_PREFIX','').'js/dashboard/index.js') !!}
@endsection
