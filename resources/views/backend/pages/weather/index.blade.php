@extends('backend.layouts.app')
@section('content')
<!-- begin:: Content Head -->
<div class="kt-subheader  kt-grid__item" id="kt_subheader">
    <div class="kt-container  kt-container--fluid ">
        <div class="kt-subheader__main">
            <h3 class="kt-subheader__title">一般天氣預報圖資管理</h3>
            <span class="kt-subheader__separator kt-subheader__separator--v"></span>
        </div>

    </div>
</div>
<!-- end:: Content Head -->
<!-- begin:: Content -->
<div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
    <form class="kt-form kt-form--label-right" id="search-form" action="{{route('weather.query')}}">
    </form>

    <div class="kt-form__actions">
        <div class="form-group row">
            <div class="col-6">
                <a href="#" class="btn btn-outline-primary js-edit-btn" data-toggle="modal" data-target="#index-modal" >管理分類</a>
            </div>
            <div class="col-6 kt-align-right">
            </div>
        </div>
    </div>

    <div class="row">
        <div class="kt-portlet">
            <div class="kt-portlet__body">
                <table id="weather-table" class="table table-striped- table-bordered table-hover table-checkable dataTable no-footer dtr-inline" data-edit-url="{{ route('weather.edit', ['_id'],false) }}">
                    <thead>
                        <tr>
                            <th>排序</th>
                            <th>分類</th>
                            <th>圖資名稱</th>
                            <th>設定</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>

@include('backend.pages.weather._index_modal')

<!-- end:: Content -->

@endsection

@section('pages_scripts')
    {!! Html::script('js/vendor/jquery-ui.js') !!}
    {!! Html::script('js/weather/index.js') !!}
@endsection
