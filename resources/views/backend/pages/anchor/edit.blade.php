@extends('backend.layouts.app')
@section('content')
    <!-- begin:: Content Head -->
    <div class="kt-subheader  kt-grid__item" id="kt_subheader">
        <div class="kt-container  kt-container--fluid ">
            <div class="kt-subheader__main">
                <h3 class="kt-subheader__title">主播排版偏好設定</h3>
                <span class="kt-subheader__separator kt-subheader__separator--v"></span>
                <a href="{{route('anchor.index', [])}}">主播列表 </a><span> / 個別排版偏好設定</span>
            </div>
        </div>
    </div>
    <!-- end:: Content Head -->
    <!-- begin:: Content -->
    <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
        <div class="row">
            <div class="col-12">
                <div class="kt-form__actions">
                    <div class="form-group row">
                        <div class="col-6">
                            <a href="{{route('anchor.index', [])}}" class="btn btn-secondary">回上一頁</a>
                        </div>
                        <div class="col-6 kt-align-right">

                        </div>
                    </div>
                </div>
                <div class="kt-portlet">
                    <div class="kt-portlet__body">
                        <div class="form-group row">
                            <label for="example-search-input" class="col-2 col-form-label">
                                主播：
                            </label>
                            <div class="col-7">
                                <label for="example-search-input" class="col-3 col-form-label">
                                    {{$hostPreference->user->name}}
                                </label>
                            </div>

                        </div>
                        <div class="form-group row">
                            <label for="example-search-input" class="col-2 col-form-label">
                                裝置：
                            </label>
                            <div class="col-7">
                                <label for="example-search-input" class="col-3 col-form-label">
                                    {{$hostPreference->device->name}}
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="kt-portlet">
                    <div class="kt-portlet__head">
                        <div class="kt-portlet__head-label">
                            <h3 class="kt-portlet__head-title">
                                颱風預報圖資
                            </h3>
                        </div>
                    </div>
                    <div class="kt-portlet__body">
                        {{ Widget::TyphoonLayout(['update_url' => route('anchor.update', ['hostPreference' => $hostPreference->id]), 'auchor'=>true, 'default' => $hostPreference->device->preference_json['typhoon'] ?? [], 'preference' => $hostPreference->preference_json['typhoon'] ?? []])}}
                    </div>
                </div>

                <div class="kt-portlet">
                    <div class="kt-portlet__head">
                        <div class="kt-portlet__head-label">
                            <h3 class="kt-portlet__head-title">
                                一般天氣預報圖資
                            </h3>
                        </div>
                    </div>
                    <div class="kt-portlet__body">
                        <div class="kt-section kt-section--first">
                            {{ Widget::weatherLayout(['update_url' => route('anchor.update', ['hostPreference' => $hostPreference->id]), 'auchor'=>true, 'default' => $hostPreference->device->preference_json['weather'] ?? [], 'preference' => $hostPreference->preference_json['weather'] ?? []])}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end:: Content -->

    <style>
        .blcok_type_1 {
            background-color: #efefef
        }

        .blcok_type_2 {
            background-color: #6cb2eb
        }
    </style>

@endsection

@section('pages_scripts')
    <script>
        $('.reset-default').click(function(){
            $(this).parents('tr').get(0).querySelectorAll('input').forEach(function (element) {
                $(element).val($(element).data('default'));
            });
        });
    </script>
@endsection
