@extends('backend.layouts.app')
@section('content')
<!-- begin:: Content Head -->
<div class="kt-subheader  kt-grid__item" id="kt_subheader">
    <div class="kt-container  kt-container--fluid ">
        <div class="kt-subheader__main">
            <h3 class="kt-subheader__title">編輯角色</h3>
            <span class="kt-subheader__separator kt-subheader__separator--v"></span>
        </div>
    </div>
</div>
<!-- end:: Content Head -->
<!-- begin:: Content -->


<form class="kt-form kt-form--label-right" id="edit-info-form" action="{{route('roles.update', ['role'=>$role->id])}}"  method="post" enctype="multipart/form-data">
  @csrf
  <input type="hidden" name="_method" value="put" />
  <input type="hidden" name="set_avatar" id="set_avatar" value="1">
  <input type="hidden" name="is_new_avatar" id="is_new_avatar" value="0">
<div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
    <div class="kt-form__actions">
        <div class="form-group row">
              <a href="{{route('users.index', [])}}" class="btn btn-secondary">回上一頁</a>
        </div>
    </div>
    <div class="kt-portlet">
        <div class="kt-portlet__head">
            <div class="kt-portlet__head-label">
                <h3 class="kt-portlet__head-title">
                    角色資訊
                </h3>
            </div>
        </div>
        <div class="kt-portlet__body">
            <div class="kt-section kt-section--first">
                <div class="form-group row">
                    <label for="example-search-input" class="col-2 col-form-label">
                        <span class="kt-font-danger">*</span>角色名稱
                    </label>
                    <div class="col-6 kt-input-icon">
                        <input class="form-control" type="text" value="{{$role->name}}" name="name" id="name-input" required maxlength="30">
                        <span class="kt-input-icon__icon kt-input-icon__icon--right"><span id="name-count">{{mb_strlen($role->name, "utf-8")}}/30</span></span>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="example-search-input" class="col-2 col-form-label">
                        權限
                    </label>
                    <div class="col-9 col-form-label">
                        <div class="checkbox-inline">
                            @foreach($permissions as $permission)
                                <label class="checkbox">
                                    <input type="checkbox" name="permissions[]" value="{{$permission->id}}" {{in_array($permission->name, $rolePermission) ? 'checked' : ''}}>
                                    <span>{{$permission->name}}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
    	</div>
    </div>
</div>
<!-- end:: Content -->
<div class="kt-portlet__foot">
    <div class="kt-form__actions">
        <div class="col-1">
        </div>
        <div class="col-8">
            <button type="submit" class="btn btn-primary" id="submit-btn">儲存變更</button>
        </div>
    </div>
</div>
</form>

@endsection

@section('pages_scripts')
    {!! Html::script(env('URL_PREFIX','').'js/user/edit.js') !!}
@endsection
