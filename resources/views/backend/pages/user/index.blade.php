@extends('backend.layouts.app')
@section('content')
<!-- begin:: Content Head -->
<div class="kt-subheader  kt-grid__item" id="kt_subheader">
    <div class="kt-container  kt-container--fluid ">
        <div class="kt-subheader__main">
            <h3 class="kt-subheader__title">使用者管理</h3>
            <span class="kt-subheader__separator kt-subheader__separator--v"></span>
        </div>
    </div>
</div>
<!-- end:: Content Head -->
<!-- begin:: Content -->
<div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
    <div class="row">
        <div class="kt-portlet">
        <form class="kt-form kt-form--label-right" id="search-form" action="{{route('users.query',[],false)}}">
            <input type="hidden" name="role">
            <div class="kt-portlet__body">
                <div class="form-group row">
                    <div class="col-lg-4">
                        <label>關鍵字</label>
                        <input type="text" name="name" class="form-control" placeholder="請輸入使用者名稱">
                    </div>
                </div>
            </div>
            <div class="kt-portlet__foot">
              <div class="kt-form__actions">
                <div class="row">
                  <div class="col-lg-12 kt-align-right">
                    <button type="button" class="btn btn-secondary" id="search-btn">搜尋</button>
                    <a href="{{route('users.create')}}" class="btn btn-primary" id="add-btn"><i class="la la-plus-square"></i>新增使用者</a>
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
                <ul class="nav nav-tabs  nav-tabs-line mb-0" role="tablist">
                    <li class="nav-item">
        				<div class="nav-link active js-role" data-toggle="tab" role="tab" aria-selected="true">全部</div>
        			</li>
                    @foreach ($roles as $role)
                        <li class="nav-item">
            				<div class="nav-link js-role" data-toggle="tab" role="tab" aria-selected="true" data-role="{{$role['name']}}">{{$role['chinese_name']}}</div>
            			</li>
                    @endforeach
        		</ul>
        		<div class="tab-content tab-content-noborder">
        			<div class="tab-pane active" role="tabpanel">
                        <table id="user-table" class="table table-striped- table-bordered table-hover table-checkable dataTable no-footer dtr-inline" data-edit-url="{{ route('users.edit', ['_id']) }}" data-destroy-url="{{ route('users.destroy', ['_id']) }}">
                            <thead>
                                <tr>
                                    <th>帳號</th>
                                    <th>使用者名稱</th>
                                    <th>角色權限</th>
                                    <th>編輯</th>
                                    <th>刪除</th>
                                </tr>
                            </thead>
                        </table>
        			</div>
        		</div>
            </div>
        </div>
    </div>
</div>

<!-- end:: Content -->

@endsection

@section('pages_scripts')
    {!! Html::script('js/user/index.js') !!}
@endsection
