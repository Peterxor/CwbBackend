@php
$user = Auth::user();
$permissions = [];
if ($user){
    foreach($user->getAllPermissions() as $permission){
        $permissions[] = $permission->name;
    }
}
@endphp

@foreach ($items as $item)
    @if ($item['permission'] && !in_array($item['permission'], $permissions))
        @continue
    @endif
    @if(!empty($item['children']))
        <li class="kt-menu__item kt-menu__item--submenu {{($item['name']==Request::segment($item['level']))?'kt-menu__item--open':''}}"
            aria-haspopup="true" data-ktmenu-submenu-toggle="hover">
            <a href="javascript:;" class="kt-menu__link kt-menu__toggle">
                <span class="kt-menu__link-icon"><i class="la la-wrench"></i></span>
                <span class="kt-menu__link-text">{{$item['display_name'] ?? ''}}</span>
                <i class="kt-menu__ver-arrow la la-angle-right"></i>
            </a>
            <div class="kt-menu__submenu ">
                <span class="kt-menu__arrow"></span>
                <ul class="kt-menu__subnav">
                    <li class="kt-menu__item kt-menu__item--parent" aria-haspopup="true">
                        <span class="kt-menu__link"><span class="kt-menu__link-text">{{$item['display_name'] ?? ''}}</span></span>
                    </li>
                    @include('backend.widgets.side_menu', ['items' => $item['children']])
                </ul>
            </div>
        </li>
    @else
        <li class="kt-menu__item {{($item['name']==Request::segment($item['level']))?'kt-menu__item--active': ''}}" aria-haspopup="true">
            @php
            if(isset($item['link']) ){
                if(isset($item['param_key']) ){
                    $param = array();
                    $param[$item["param_key"]] = $item['param_value'];
                    $link = route($item['link'],$param);
                }else{
                    $link = route($item['link']);
                }
            }else{
                $link = '#';
            }
            @endphp
            <a href="{{$link}}" class="kt-menu__link ">
                <!-- <span class="kt-menu__link-icon"><i class="la la-file-text"></i></span> -->
                <span class="kt-menu__link-icon">{!! $item['icon'] ?? '' !!}</i></span>
                <span class="kt-menu__link-text">{{$item['display_name'] ?? ''}}</span>
            </a>
        </li>
    @endif
@endforeach
