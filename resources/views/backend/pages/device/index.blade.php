@extends('backend.layouts.app')
@section('content')
    <!-- begin:: Content Head -->
<div class="kt-subheader  kt-grid__item" id="kt_subheader">
    <div class="kt-container  kt-container--fluid ">
        <div class="kt-subheader__main">
            <h3 class="kt-subheader__title">裝置排版設定</h3>
            <span class="kt-subheader__separator kt-subheader__separator--v"></span>
        </div>

    </div>
</div>
<!-- end:: Content Head -->
<!-- begin:: Content -->
<div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
    <form class="kt-form kt-form--label-right" id="search-form" action="{{route('device.query')}}">
    </form>

    <div class="row">
        <div class="kt-portlet">
            <div class="kt-portlet__body">
                <table id="device-table" class="table table-striped- table-bordered table-hover table-checkable dataTable no-footer dtr-inline" data-edit-url="{{ env('URL_PREFIX','').route('device.show', ['id' => '_id'],false) }}">
                    <thead>
                        <tr>
                            <th>裝置名稱</th>
                            <th>管理</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- end:: Content -->

@endsection

@section('pages_scripts')
    {!! Html::script(env('URL_PREFIX','').'js/device/index.js') !!}
@endsection
