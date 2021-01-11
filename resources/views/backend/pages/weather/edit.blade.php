@extends('backend.layouts.app')
@section('content')
<!-- begin:: Content Head -->
    <div class="kt-subheader  kt-grid__item" id="kt_subheader">
        <div class="kt-container  kt-container--fluid ">
            <div class="kt-subheader__main">
                <h3 class="kt-subheader__title">設定天氣圖資</h3>
                <span class="kt-subheader__separator kt-subheader__separator--v"></span>
                <a href="{{route('weather.index', [])}}">一般天氣預報圖資管理 </a><span> / 設定天氣圖資</span>
            </div>
        </div>
    </div>
<!-- end:: Content Head -->
<!-- begin:: Content -->
    <form class="kt-form kt-form--label-right" id="edit-form" method="post" action="{{route('weather.update', ['weather' => $general->id])}}}" >
      @csrf
    <input type="hidden" name="_method" value="put"/>

    <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
        <div class="row">
            <div class="col-12">
                <div class="kt-form__actions">
                    <div class="form-group row">
                        <div class="col-6">
                            <a href="{{route('weather.index', [])}}" class="btn btn-secondary">回上一頁</a>
                        </div>
                        <div class="col-6 kt-align-right">

                        </div>
                    </div>
                </div>

                <div class="kt-portlet">
                    <div class="kt-portlet__head">
                        <div class="kt-portlet__head-label">
                            <h3 class="kt-portlet__head-title">
                                圖資資訊
                            </h3>
                        </div>
                    </div>
                    <div class="kt-portlet__body">
                        <div class="kt-section kt-section--first">
                            <div class="form-group row">
                    			<label for="example-search-input" class="col-2 col-form-label">
                                    <span class="kt-font-danger">*</span>圖資名稱
                                </label>
                    			<div class="col-3">
                                    <input class="form-control" type="text" value="{{$json['display_name']}}" name="display_name" required>
                                </div>
                                <div class="col-3 pt-3 col-form-label">
                                </div>
            		        </div>
                            <div class="form-group row">
                    			<label for="example-search-input" class="col-2 col-form-label">
                                    <span class="kt-font-danger">*</span>分類
                                </label>
                    			<div class="col-3">
                                    <select class="form-control" name="category">
                                        @foreach($categorys as $id => $name)
                    					<option value="{{$id}}" {{$id == ($general->category->id ?? null) ? 'selected' : ''}}>{{$name}}</option>
                                        @endforeach
                                        {{-- @widget('CategorySelect') --}}
                                    </select>
                                </div>
            		        </div>
                            <div class="form-group row">
                    			<label for="example-search-input" class="col-2 col-form-label">
                                    <span class="kt-font-danger">*</span>顯示模式
                                </label>
                    			<div class="col-7">
                                    <div class="kt-radio-inline">
                    					<label class="kt-radio">
                    						<input class="mr-1" type="radio" name="display_type" value="1" id="single" {{$type == 1 ? 'checked' : ''}} disabled/>單圖
                                            <span></span>
                    					</label>
                    					<label class="kt-radio">
                    						<input class="ml-2 mr-1" type="radio" name="display_type" value="2" id="parallel" {{$type == 2 ? 'checked' : ''}} disabled/>雙圖並列
                                            <span></span>
                    					</label>
                                        <label class="kt-radio">
                    						<input class="ml-2 mr-1" type="radio" name="display_type" value="3" id="dynamic" {{$type == 3 ? 'checked' : '' }} disabled/>動態組圖
                                            <span></span>
                    					</label>
                                        <label class="kt-radio">
                    						<input class="ml-2 mr-1" type="radio" name="display_type" value="4" id="list" {{$type == 4 ? 'checked' : ''}} disabled/>圖片列表
                                            <span></span>
                    					</label>
                    				</div>
                                </div>
                                <div class="col-3 pt-3 col-form-label">
                                </div>
            		        </div>
                            <div class="form-group row js-info-group js-single js-dynamic js-list" style="{{$type != 3 ? '' : 'display:none;'}}">
                    			<label for="example-search-input" class="col-2 col-form-label">
                                    <span class="kt-font-danger">*</span>資料來源
                                </label>
                    			<div class="col-7">
                                    <input class="form-control" type="text" value="{{$json['origin'] ?? ''}}" name="origin">
                                </div>
                                <div class="col-3 pt-3 col-form-label">
                                </div>
            		        </div>
                            <div class="form-group row js-info-group js-parallel" style="{{$type == 3 ? '' : 'display:none;'}}">
                    			<label for="example-search-input" class="col-2 col-form-label">
                                    <span class="kt-font-danger">*</span>資料來源(左)
                                </label>
                    			<div class="col-7">
                                    <input class="form-control" type="text" value="{{$json['origin_left'] ?? ''}}" name="origin_left">
                                </div>
                                <div class="col-3 pt-3 col-form-label">
                                </div>
            		        </div>
                            <div class="form-group row js-info-group js-parallel" style="{{$type == 3 ? '' : 'display:none;'}}">
                    			<label for="example-search-input" class="col-2 col-form-label">
                                    <span class="kt-font-danger">*</span>資料來源(右)
                                </label>
                    			<div class="col-7">
                                    <input class="form-control" type="text" value="{{$json['origin_right'] ?? ''}}" name="origin_right">
                                </div>
                                <div class="col-3 pt-3 col-form-label">
                                </div>
            		        </div>
                            <div class="form-group row js-info-group js-dynamic" style="{{$type == 4 ? '' : 'display:none;'}}">
                    			<label for="example-search-input" class="col-2 col-form-label">
                                    <span class="kt-font-danger">*</span>動態組圖張數
                                </label>
                    			<div class="col-7">
                                    <input class="form-control" type="text" value="{{$json['amount'] ?? 1}}" name="amount">
                                </div>
                                <div class="col-3 pt-3 col-form-label">
                                    <span>張</span>
                                </div>
            		        </div>
                            <div class="form-group row js-info-group js-dynamic" style="{{$type == 4 ? '' : 'display:none;'}}">
                    			<label for="example-search-input" class="col-2 col-form-label">
                                    <span class="kt-font-danger">*</span>換圖速率 (毫秒/張)
                                </label>
                    			<div class="col-7">
                                    <input class="form-control" type="text" value="{{$json['interval'] ?? 1000}}" name="interval">
                                </div>
                                <div class="col-3 pt-3 col-form-label">
                                    <span>張/秒</span>
                                </div>
            		        </div>
                        </div>
                	</div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-6">
            </div>
            <div class="col-6 kt-align-right">
                <button type="submit" class="btn btn-primary" id="edit-btn">儲存</button>
            </div>
        </div>
    </div>
    </form>
<!-- end:: Content -->

@endsection

@section('pages_scripts')
    {!! Html::script(env('URL_PREFIX','').'js/weather/edit.js') !!}
@endsection
