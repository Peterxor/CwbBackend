@extends('backend.layouts.app')
@section('content')
<!-- begin:: Content Head -->
    <div class="kt-subheader  kt-grid__item" id="kt_subheader">
        <div class="kt-container  kt-container--fluid ">
            <div class="kt-subheader__main">
                <h3 class="kt-subheader__title">個別排版偏好設定</h3>
                <span class="kt-subheader__separator kt-subheader__separator--v"></span>
                <a href="{{route('anchor.index', [])}}">主播列表 </a><span> / 個別排版偏好設定</span>
            </div>
        </div>
    </div>
<!-- end:: Content Head -->
<!-- begin:: Content -->
    <form class="kt-form kt-form--label-right" id="edit-form" method="post" enctype="multipart/form-data">
      @csrf
    <input type="hidden" name="_method" value="put"/>

    <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
        <div class="row">
            <div class="col-12">
                <div class="kt-form__actions">
                    <div class="form-group row">
                        <div class="col-6">
                            <a href="{{route('typhoon.index', [])}}" class="btn btn-secondary">回上一頁</a>
                        </div>
                        <div class="col-6 kt-align-right">

                        </div>
                    </div>
                </div>
                <div class="kt-portlet">
                    <div class="kt-portlet__body">
                        <div class="form-group row">
                            <label for="example-search-input" class="col-2 col-form-label">
                                主播：
                            </label>
                            <div class="col-7">
                                <label for="example-search-input" class="col-3 col-form-label">
                                    伍婉華
                                </label>
                            </div>

                        </div>
                        <div class="form-group row">
                            <label for="example-search-input" class="col-2 col-form-label">
                                裝置：
                            </label>
                            <div class="col-7">
                                <label for="example-search-input" class="col-3 col-form-label">
                                    防災視訊室
                                </label>
                            </div>
                        </div>
                	</div>
                </div>

                <div class="kt-portlet">
                    <div class="kt-portlet__head">
                        <div class="kt-portlet__head-label">
                            <h3 class="kt-portlet__head-title">
                                颱風預報圖資
                            </h3>
                        </div>
                    </div>
                    <div class="kt-portlet__body">
                        {{ Widget::TyphoonLayout(['auchor'=>true])}}
                	</div>
                </div>

                <div class="kt-portlet">
                    <div class="kt-portlet__head">
                        <div class="kt-portlet__head-label">
                            <h3 class="kt-portlet__head-title">
                                一般天氣預報圖資
                            </h3>
                        </div>
                    </div>
                    <div class="kt-portlet__body">
                        <div class="kt-section kt-section--first">
                            {{ Widget::weatherLayout(['auchor'=>true])}}
                        </div>
                	</div>
                </div>
            </div>
        </div>
    </div>
    </form>
<!-- end:: Content -->

<style>
    .blcok_type_1{
        background-color: #efefef
    }

    .blcok_type_2{
        background-color: #6cb2eb
    }
</style>

@endsection

@section('pages_scripts')
    {{-- {!! Html::script(env('URL_PREFIX','').'js/weather/edit.js') !!} --}}
@endsection
