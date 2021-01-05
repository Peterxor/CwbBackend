@extends('backend.layouts.app')
@section('content')
    <!-- begin:: Content Head -->
    <div class="kt-subheader  kt-grid__item" id="kt_subheader">
        <div class="kt-container  kt-container--fluid ">
            <div class="kt-subheader__main">
                <h3 class="kt-subheader__title">人員個別簡介</h3>
                <span class="kt-subheader__separator kt-subheader__separator--v"></span>
                <a href="{{route('personnel.index', [])}}">人員列表</a><span> / 人員個別簡介</span>
            </div>
        </div>
    </div>
    <!-- end:: Content Head -->
    <!-- begin:: Content -->

    <form class="kt-form kt-form--label-right" id="edit-info-form" action="{{route('personnel.update', ['personnel' => $person->id])}}" method="post"
          enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="_method" value="put"/>
        <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">

            <div class="kt-form__actions">
                <div class="form-group row">
                    <div class="col-6">
                        <a href="{{route('personnel.index', [])}}" class="btn btn-secondary">回上一頁</a>
                    </div>
                    <div class="col-6 kt-align-right">

                    </div>
                </div>
            </div>

            <div class="kt-portlet">
                <div class="kt-portlet__head">
                    <div class="kt-portlet__head-label">
                        <h3 class="kt-portlet__head-title">
                            人員簡介
                        </h3>
                    </div>
                </div>
                <div class="kt-portlet__body">
                    <div class="kt-section kt-section--first">

                        <div class="form-group row">
                            <label for="example-search-input" class="col-2 col-form-label">
                                <span class="kt-font-danger">*</span>人員姓名
                            </label>
                            <div class="col-3 kt-input-icon">
                                <input class="form-control"
                                       type="text"
                                       value="{{$person->name ?? ''}}" name="name" required placeholder="請輸入人員姓名">
                                <span class="kt-input-icon__icon kt-input-icon__icon--right"></span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="example-search-input" class="col-2 col-form-label">
                                <span class="kt-font-danger">*</span>角色稱呼
                            </label>
                            <div class="col-3 kt-input-icon">
                                <input class="form-control" type="text" value="{{$person->nick_name ?? ''}}"
                                       name="nick_name" required placeholder="請輸入角色稱呼">
                                <span class="kt-input-icon__icon kt-input-icon__icon--right"></span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="example-search-input" class="col-2 col-form-label">
                                現職
                            </label>
                            <div class="col-3 kt-input-icon">
                                <input class="form-control" type="text" value="{{$person->career ?? ''}}" name="career"
                                       placeholder="請輸入現職">
                                <span class="kt-input-icon__icon kt-input-icon__icon--right"></span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="example-search-input" class="col-2 col-form-label">
                                學歷
                            </label>
                            <div class="col-3 kt-input-icon">
                                <input class="form-control" type="text" value="{{$person->education}}" name="education"
                                       placeholder="請輸入學歷">
                                <span class="kt-input-icon__icon kt-input-icon__icon--right"></span>
                            </div>
                        </div>

                        <div class="form-group row" style="margin-bottom:0rem;">
                            <label for="example-search-input" class="col-2 col-form-label">
                                經歷
                            </label>
                        </div>

                        @for($i = 0; $i < 3; $i++)
                            <div class="form-group row">
                                <label for="example-search-input" class="col-2 col-form-label">
                                    {{$i + 1}}.
                                </label>
                                <div class="col-3 kt-input-icon">
                                    <input class="form-control" type="text" value="{{$experience[$i] ?? ''}}" name="exp[]" placeholder="請輸入經歷">
                                    <span class="kt-input-icon__icon kt-input-icon__icon--right"></span>
                                </div>
                            </div>
                        @endfor
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-6">
                </div>
                <div class="col-6 kt-align-right">
                    <button type="submit" class="btn btn-primary" id="submit-btn">確認修改</button>
                </div>
            </div>
        </div>
        <!-- end:: Content -->
    </form>

@endsection

@section('pages_scripts')
@endsection
