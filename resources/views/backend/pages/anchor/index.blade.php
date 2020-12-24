@extends('backend.layouts.app')
@section('content')
    <!-- begin:: Content Head -->
<div class="kt-subheader  kt-grid__item" id="kt_subheader">
    <div class="kt-container  kt-container--fluid ">
        <div class="kt-subheader__main">
            <h3 class="kt-subheader__title">主播偏好設定</h3>
            <span class="kt-subheader__separator kt-subheader__separator--v"></span>
        </div>

    </div>
</div>
<!-- end:: Content Head -->
<!-- begin:: Content -->
<div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
    <form class="kt-form kt-form--label-right" id="search-form" action="{{route('anchor.query')}}">
    </form>
    <div class="row">
        <div class="kt-portlet">
            <div class="kt-portlet__body">
                <table id="anchor-table" class="table table-striped- table-bordered table-hover table-checkable dataTable no-footer dtr-inline" data-edit-url="{{ env('URL_PREFIX','').route('anchor.update', ['_id'],false) }}">
                    <thead>
                        <tr>
                            <th>預報主播</th>
                            <th>防災視訊室</th>
                            <th>公關室</th>
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
    {!! Html::script(env('URL_PREFIX','').'js/anchor/index.js') !!}
@endsection
