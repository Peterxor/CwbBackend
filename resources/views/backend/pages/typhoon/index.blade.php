@extends('backend.layouts.app')
@section('content')
    <!-- begin:: Content Head -->
<div class="kt-subheader  kt-grid__item" id="kt_subheader">
    <div class="kt-container  kt-container--fluid ">
        <div class="kt-subheader__main">
            <h3 class="kt-subheader__title">颱風預報圖資管理</h3>
            <span class="kt-subheader__separator kt-subheader__separator--v"></span>
        </div>

    </div>
</div>
<!-- end:: Content Head -->
<!-- begin:: Content -->
<div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
    <div class="row">
        <div class="kt-portlet">
            <div class="kt-portlet__body">
                <table id="typhoon-table" class="table table-striped- table-bordered table-hover table-checkable dataTable no-footer dtr-inline" data-query-url="{{route('typhoon.query')}}" data-edit-url="{{ env('URL_PREFIX','').route('typhoon.edit', ['_id'],false) }}">
                    <thead>
                        <tr>
                            <th>排序</th>
                            <th>圖資名稱</th>
                            <th>設定</th>
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
    {!! Html::script(env('URL_PREFIX','').'js/typhoon/index.js') !!}
@endsection
