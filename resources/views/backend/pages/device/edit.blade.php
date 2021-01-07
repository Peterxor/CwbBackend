@extends('backend.layouts.app')
@section('content')
    <!-- begin:: Content Head -->
    <div class="kt-subheader  kt-grid__item" id="kt_subheader">
        <div class="kt-container  kt-container--fluid ">
            <div class="kt-subheader__main">
                <h3 class="kt-subheader__title">{{$name}}</h3>
                <span class="kt-subheader__separator kt-subheader__separator--v"></span>
                <a href="{{route('device.index', [])}}">裝置排版設定 </a><span> / {{$name}}</span>
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
                            <a href="{{route('device.index', [])}}" class="btn btn-secondary">回上一頁</a>
                        </div>
                        <div class="col-6 kt-align-right">

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
                        {{ Widget::TyphoonLayout(['update_url' => route('device.update', ['device' => $device->id]), 'auchor'=>false, 'preference' => $preference['颱風預報'] ?? []])}}
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
                            {{ Widget::weatherLayout(['update_url' => route('device.update', ['device' => $device->id]), 'auchor'=>false, 'preference' => $preference['一般天氣'] ?? []])}}
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

@endsection
