@extends('backend.layouts.app')
@section('content')
<!-- begin:: Content Head -->
    <div class="kt-subheader  kt-grid__item" id="kt_subheader">
        <div class="kt-container  kt-container--fluid ">
            <div class="kt-subheader__main">
                <h3 class="kt-subheader__title">天氣預報排程</h3>
                <span class="kt-subheader__separator kt-subheader__separator--v"></span>
                <a href="{{route('dashboard.index', [])}}">Dashboard </a><span> / 天氣預報排程</span>
            </div>
        </div>
    </div>
<!-- end:: Content Head -->
<!-- begin:: Content -->
    <form class="kt-form kt-form--label-right" id="edit-form" method="post">
      @csrf
    <input type="hidden" name="_method" value="put"/>

    <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">



        <div class="row">
            <div class="col-12">
                <div class="kt-form__actions">
                    <div class="form-group row">
                        <div class="col-6">
                            <a href="{{route('dashboard.index', [])}}" class="btn btn-secondary">回上一頁</a>
                            <button type="submit" class="btn btn-primary" id="edit-btn">儲存變更</button>
                        </div>
                        <div class="col-6">

                        </div>
                    </div>
                </div>

                <div class="kt-portlet">
                    <div class="kt-portlet__head">
                        <div class="kt-portlet__head-label">
                            <h3 class="kt-portlet__head-title">
                                裝置：防災視訊室
                            </h3>
                        </div>
                    </div>

                    <div class="kt-portlet__body">
                        <table class="table table-striped- table-bordered table-hover table-checkable dataTable no-footer dtr-inline" >
                            <thead>
                                <tr>
                                    <th style="width:50px;">排序</th>
                                    <th style="width:150px;">類別</th>
                                    <th>名稱</th>
                                </tr>
                            </thead>
                            <tr>
                                <td><span class="kt-badge kt-badge--inline"><i class="la la-sort" style="font-size:24px"></i></span></td>
                                <td>
                                    <select class="form-control js-change-btn">
                                        <option value="weather" selected>圖資來源</option>
                                        <option value="upload">圖片上傳</option>
                                    </select>
                                </td>
                                <td>
                                    <select class="form-control js-ref js-weather" style="display:block;">
                                        {{-- 一般天氣預報圖資 --}}
                                    </select>
                                    <input type="file" class="js-ref js-avatar" id="file-upload" accept="image/gif, image/jpeg, image/png" style="display:none;"/>
                                </td>
                            </tr>
                        </table>
                	</div>
                </div>
            </div>
        </div>

    </div>
    </form>
<!-- end:: Content -->

@endsection

@section('pages_scripts')
    {!! Html::script(env('URL_PREFIX','').'js/dashboard/edit.js') !!}
@endsection
