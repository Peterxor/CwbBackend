@extends('backend.layouts.app')
@section('content')
<!-- begin:: Content Head -->
<div class="kt-subheader  kt-grid__item" id="kt_subheader">
    <div class="kt-container  kt-container--fluid ">
        <div class="kt-subheader__main">
            <h3 class="kt-subheader__title">編輯使用者</h3>
            <span class="kt-subheader__separator kt-subheader__separator--v"></span>
            <a href="{{route('users.index', [])}}">使用者管理</a><span> / 編輯使用者</span>
        </div>
    </div>
</div>
<!-- end:: Content Head -->
<!-- begin:: Content -->

<form class="kt-form kt-form--label-right" id="edit-info-form" action="{{route('users.update', ['user'=>$user->id])}}"  method="post" enctype="multipart/form-data">
  @csrf
  <input type="hidden" name="_method" value="put" />
<div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">

    <div class="kt-form__actions">
        <div class="form-group row">
            <div class="col-6">
                <a href="{{route('users.index', [])}}" class="btn btn-secondary">回上一頁</a>
            </div>
            <div class="col-6 kt-align-right">

            </div>
        </div>
    </div>

    <div class="kt-portlet">
        <div class="kt-portlet__head">
            <div class="kt-portlet__head-label">
                <h3 class="kt-portlet__head-title">
                    使用者資訊
                </h3>
            </div>
        </div>
        <div class="kt-portlet__body">
            <div class="kt-section kt-section--first">

                <div class="form-group row">
                    <label for="example-search-input" class="col-2 col-form-label">
                        <span class="kt-font-danger">*</span>帳號(信箱)
                    </label>
                    <div class="col-3 kt-input-icon">
                        <input class="form-control"
                               type="email"
                               value="{{$user->email}}" name="email" required maxlength="50">
                        <span class="kt-input-icon__icon kt-input-icon__icon--right"></span>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="example-search-input" class="col-2 col-form-label">
                        <span class="kt-font-danger">*</span>密碼
                    </label>
                    <div class="col-3 kt-input-icon">
                        <input class="form-control" type="password" value="" name="password" minlength="8" maxlength="12">
                        <span class="kt-input-icon__icon kt-input-icon__icon--right"></span>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="example-search-input" class="col-2 col-form-label">
                        <span class="kt-font-danger">*</span>使用者名稱
                    </label>
                    <div class="col-3 kt-input-icon">
                        <input class="form-control" type="text" value="{{$user->name}}" name="name" required maxlength="30">
                        <span class="kt-input-icon__icon kt-input-icon__icon--right"></span>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="example-search-input" class="col-2 col-form-label">
                        <span class="kt-font-danger">*</span>角色權限
                    </label>
                    <div class="col-2">
                        <select class="form-control" name="role">
                            @foreach($roles as $role)
                                    <option value="{{$role->id}}" {{$userRoles==$role->name ? 'selected' : ''}}>{{$role->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
    	</div>
    </div>
    <div class="row">
        <div class="col-6">
        </div>
        <div class="col-6 kt-align-right">
            <button type="submit" class="btn btn-primary" id="submit-btn">儲存變更</button>
        </div>
    </div>
</div>
<!-- end:: Content -->
</form>

@endsection

@section('pages_scripts')
@endsection
