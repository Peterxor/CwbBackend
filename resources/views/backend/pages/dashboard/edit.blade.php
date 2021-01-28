@extends('backend.layouts.app')
@section('content')
    <!-- begin:: Content Head -->
    <div class="kt-subheader  kt-grid__item" id="kt_subheader">
        <div class="kt-container  kt-container--fluid ">
            <div class="kt-subheader__main">
                <h3 class="kt-subheader__title">{{$pic_type === 'typhoon' ? '颱風主播圖卡' : '天氣預報排程'}}</h3>
                <span class="kt-subheader__separator kt-subheader__separator--v"></span>
                <a href="{{route('dashboard.index', [])}}">Dashboard </a><span> / {{$pic_type === 'typhoon' ? '颱風主播圖卡' : '天氣預報排程'}}</span>
            </div>
        </div>
    </div>
    <!-- end:: Content Head -->
    <!-- begin:: Content -->
    <form class="kt-form kt-form--label-right" id="edit-form" method="post"
          action="{{route('dashboard.update', ['device' => $device->id])}}">
        @csrf
        <input type="hidden" name="_method" value="put"/>
        <input type="hidden" name="pic_type" value="{{$pic_type}}"/>

        <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">


            <div class="row">
                <div class="col-12">
                    <div class="kt-form__actions">
                        <div class="form-group row">
                            <div class="col-6">
                                <a href="{{route('dashboard.index', [])}}" class="btn btn-secondary">回上一頁</a>
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
                            <div class="form-group row">
                                <div class="col-6">
                                    <button type="submit" class="btn btn-primary" id="edit-btn">儲存變更</button>
                                </div>
                                <div class="col-6">

                                </div>
                            </div>
                            <table id="card_table"
                                   class="table table-striped- table-bordered table-hover table-checkable dataTable no-footer dtr-inline"
                                   query-device-id="{{$device->id}}" query-device-type="{{$pic_type}}">
                                <thead>
                                <tr>
                                    <th style="width:50px;">排序</th>
                                    <th style="width:150px;">類別</th>
                                    <th>名稱</th>
                                </tr>
                                </thead>
                                <tbody id="sort-table">
                                @for($i = 0; $i < $loop_times; $i++)
                                    <tr>
                                        <td><span class="kt-badge kt-badge--inline"><i class="la la-sort"
                                                                                       style="font-size:24px"></i></span>
                                        </td>
                                        <td>
                                            <select class="form-control js-change-btn">
                                                <option value="weather"
                                                        {{($data[$i]['type'] ?? null) ? ($data[$i]['type'] == 'origin' ? 'selected' : '') : 'selected'}}>
                                                    圖資來源
                                                </option>
                                                <option
                                                    value="upload" {{($data[$i]['type'] ?? null) ? ($data[$i]['type'] == 'origin' ? '' : 'selected') : ''}}>
                                                    圖片上傳
                                                </option>
                                            </select>
                                        </td>
                                        <td>
                                            <select name="origin_img_id[]" class="form-control js-ref js-weather" style="{{($data[$i]['type'] ?? null) ? ($data[$i]['type'] == 'origin' ? 'display:block;' : 'display:none;') : 'display:block;'}}">
                                                @foreach($images as $image)
                                                    <option value="{{$image->id}}" {{$data[$i] ? ($data[$i]['type'] == 'origin' ? ($image->id == $data[$i]['img_id'] ? 'selected' : '') : '') : ''}}>{{$image->content['display_name']}}</option>
                                                @endforeach
                                            </select>
                                            <div class="imgHolder" style="{{($data[$i]['type'] ?? null) ? ($data[$i]['type'] == 'origin' ? 'display:none;' : 'display:block;') : 'display:none;'}}">
                                                <div class="row">
                                                    <div class="col-1">
                                                        <label for="file-upload-avatar-{{$i}}" class="custom-file-upload">
                                                            <i class="la la-cloud-upload" style="font-size:24px"></i>
                                                        </label>
                                                        <input type="file"  class="upload-image"
                                                               id="file-upload-avatar-{{$i}}"
                                                               accept="image/gif, image/jpeg, image/png" style="display:none;"/>
                                                    </div>
                                                    <div class="col-3">
                                                        <span class="image_name">{{$data[$i]['type'] == 'upload' ? ($data[$i]['img_name'] ?? '') : ''}}</span>
                                                    </div>
                                                </div>
                                                <input class="image_type" type="hidden" name="image_type[]" value="{{$data[$i]['type'] ?? 'origin'}}">
                                                <input class="image_id" type="hidden" name="img_id[]" value="{{$data[$i]['img_id'] ?? ''}}">
                                                <input class="hidden_name" type="hidden" name="img_name[]" value="{{$data[$i]['type'] == 'upload' ? ($data[$i]['img_name'] ?? '') : ''}}">
                                                <input class="image_url" type="hidden" name="img_url[]" value="{{$data[$i]['img_url'] ?? ''}}">
                                            </div>
                                        </td>

                                    </tr>
                                @endfor
                                </tbody>
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
    {!! Html::script(env('URL_PREFIX','').'js/vendor/jquery-ui.js') !!}
    {!! Html::script(env('URL_PREFIX','').'js/dashboard/edit.js') !!}
@endsection
