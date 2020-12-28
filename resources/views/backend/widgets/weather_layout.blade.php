@foreach ($items as $item)
    <div class="kt-portlet kt-portlet--collapse" data-ktportlet="true">
        <div class="kt-portlet__head">
            <div class="kt-portlet__head-label">
                <h3 class="kt-portlet__head-title">
                    {{$item['display_name']}}
                </h3>
            </div>
            <div class="kt-portlet__head-toolbar">
                <div class="kt-portlet__head-group">
                    <a href="#" data-ktportlet-tool="toggle" class="btn btn-sm btn-icon btn-clean btn-icon-md"><i
                            class="la la-angle-down"></i></a>
                </div>
            </div>
        </div>
        <div class="kt-portlet__body" style="display: none; overflow: hidden; padding-top: 0; padding-bottom: 0;">
            <form class="kt-form kt-form--label-right" id="edit-form" action="{{$update_url}}" method="post">
                @csrf
                <input type="hidden" name="_method" value="put"/>
                <input type="hidden" name="key" value="一般天氣"/>
                <div class="kt-section">
                    <div class="kt-section__content">
                        <table class="table table-bordered">
                            <tbody>

                            @if(!empty($item['children']))
                                @foreach ($item['children'] as $children)
                                    <tr>
                                        <th class="{{$children['class_name']}}">{{$children['display_name']}}</th>
                                        @if (!$auchor)
                                            <td>
                                                @if($children['type'] == 1)
                                                    縮放
                                                    <label><input class="form-control" type="text"
                                                                  value="{{$preference[$item['name']][$children['name']]['zoom'] ?? '100'}}"
                                                                  name="preference[{{$item['name']}}][{{$children['name']}}][zoom]"></label>
                                                    %
                                                @endif
                                            </td>
                                        @endif
                                        <td>
                                            基準點
                                            <label><select class="form-control" name="" disabled>
                                                    {{-- <option>左上</option>
                                                    <option>左下</option>
                                                    <option>右上</option>
                                                    <option>右下</option>
                                                    <option>正中心</option> --}}
                                                    <option>固定</option>
                                                </select></label>
                                        </td>
                                        <td>
                                            絕對座標
                                            <label><input class="form-control" type="text"
                                                          value="{{$preference[$item['name']][$children['name']]['point'][0] ?? '0'}}"
                                                          name="preference[{{$item['name']}}][{{$children['name']}}][point][0]"
                                                          placeholder="x"></label>
                                            <label><input class="form-control" type="text"
                                                          value="{{$preference[$item['name']][$children['name']]['point'][1] ?? '0'}}"
                                                          name="preference[{{$item['name']}}][{{$children['name']}}][point][1]"
                                                          placeholder="y"></label>
                                        </td>
                                        @if($auchor)
                                            <td>
                                                <button type="submit" class="btn btn-secondary">重回預設值</button>
                                            </td>
                                        @endif
                                    </tr>
                                @endforeach
                            @endif
                            </tbody>
                        </table>
                        <div class="row">
                            <div class="col-6"></div>
                            <div class="col-6 kt-align-right">
                                <button type="submit" class="btn btn-success">儲存</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endforeach
