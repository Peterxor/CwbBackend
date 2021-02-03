@extends('backend.layouts.app')
@section('content')
    <!-- begin:: Content Head -->
<div class="kt-subheader  kt-grid__item" id="kt_subheader">
    <div class="kt-container  kt-container--fluid ">
        <div class="kt-subheader__main">
            <h3 class="kt-subheader__title">事件紀錄</h3>
            <span class="kt-subheader__separator kt-subheader__separator--v"></span>
        </div>

    </div>
</div>
<!-- end:: Content Head -->
<!-- begin:: Content -->
<div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">

    <div class="row">
        <div class="kt-portlet">
        <form class="kt-form kt-form--label-right" id="search-form" action="{{route('active.query',[],false)}}">
            <div class="kt-portlet__body">
                <div class="form-group row">
                    <div class="col-lg-4">
                        <label>操作行為:</label>
                        <select name="active_type" class="form-control">
                            <option value="">所有行為</option>
                            <option value="登入">登入</option>
                            <option value="登出">登出</option>
                            <option value="新增">新增</option>
                            <option value="修改">修改</option>
                            <option value="刪除">刪除</option>
                        </select>
                    </div>
                    <div class="col-lg-6">
                        <label>日期</label>
                        <div class="input-daterange input-group" id="">
                            <input type="text" class="form-control" name="start_date" id="start-date" value="">
                            <div class="input-group-append">
                                <span class="input-group-text"><i class="la la-ellipsis-h"></i></span>
                            </div>
                            <input type="text" class="form-control" name="end_date" id="end-date" value="">
                        </div>
                    </div>
                </div>
            </div>
            <div class="kt-portlet__foot">
              <div class="kt-form__actions">
                <div class="row">
                  <div class="col-lg-12 kt-align-right">
                    <button type="button" class="btn btn-secondary" id="search-btn">搜尋</button>
                  </div>
                </div>
              </div>
            </div>
        </form>
        </div>
    </div>

    <div class="row">
        <div class="kt-portlet">
            <div class="kt-portlet__body">
                <table id="active-table" class="table table-striped- table-bordered table-hover table-checkable dataTable no-footer dtr-inline">
                    <thead>
                        <tr>
                            <th>日期時間</th>
                            <th>操作使用者</th>
                            <th>操作行為</th>
                            <th>項目</th>
                            <th>Ip Address</th>
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
    {!! Html::script('vendor/audit/bootstrap-timepicker.min.js') !!}
    {!! Html::script('js/active/index.js') !!}
@endsection
