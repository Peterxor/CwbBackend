@extends('backend.layouts.app')
@section('content')
<!-- begin:: Content Head -->
<div class="kt-subheader  kt-grid__item" id="kt_subheader">
    <div class="kt-container  kt-container--fluid ">
        <div class="kt-subheader__main">
            <h3 class="kt-subheader__title">角色管理</h3>
            <span class="kt-subheader__separator kt-subheader__separator--v"></span>
        </div>
    </div>
</div>
<!-- end:: Content Head -->
<!-- begin:: Content -->
<div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
    <div class="row">
        <div class="kt-portlet">
        <form class="kt-form kt-form--label-right" id="search-form" action="{{route('roles.query',[],false)}}">
          <div class="kt-portlet__body">
              <div class="form-group row">
                  <div class="col-lg-4">
                      <label>關鍵字</label>
                      <input type="text" name="name" class="form-control" placeholder="請輸入課程名稱">
                  </div>
              </div>
          </div>
          <div class="kt-portlet__foot">
            <div class="kt-form__actions">
              <div class="row">
                <div class="col-lg-12 kt-align-right">
                  <button type="button" class="btn btn-secondary" id="search-btn">搜尋</button>
                  <a href="{{route('roles.create')}}" class="btn btn-primary" id="add-btn"><i class="la la-plus-square"></i>新增角色</a>
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
                <table id="course-table" class="table table-striped- table-bordered table-hover table-checkable dataTable no-footer dtr-inline" data-edit-url="{{ route('roles.edit', ['_id']) }}" data-destroy-url="{{ route('roles.destroy', ['_id']) }}">
                    <thead>
                        <tr>
                            <th>角色名稱</th>
                            <th>建立時間</th>
                            <th>編輯時間</th>
                            <th>編輯</th>
                            <th>刪除</th>
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
    {!! Html::script('js/role/index.js') !!}
@endsection
