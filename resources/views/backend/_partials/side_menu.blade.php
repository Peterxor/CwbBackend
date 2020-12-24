<!-- begin:: Aside -->
<div class="kt-aside  kt-aside--fixed  kt-grid__item kt-grid kt-grid--desktop kt-grid--hor-desktop"
     id="kt_aside">
    <div class="kt-aside__brand kt-grid__item " id="kt_aside_brand" style="background-color:#1e1e2d">
        <div class="kt-aside__brand-logo">
            <a href="{{route('index')}}" style="color:#fff">
                {{-- <img alt="Logo" src="/images/logo_large.png" style="width:80%;"> --}}
                氣象局播報系統
            </a>
        </div>
    </div>
    <!-- end:: Aside -->
    <!-- begin:: Aside Menu -->
    <div class="kt-aside-menu-wrapper kt-grid__item kt-grid__item--fluid" id="kt_aside_menu_wrapper">
        <div id="kt_aside_menu" class="kt-aside-menu" data-ktmenu-vertical="1" data-ktmenu-scroll="1"
             data-ktmenu-dropdown-timeout="500">
            <ul class="kt-menu__nav ">
                {{ Widget::SideMenu() }}
            </ul>
        </div>
    </div>
</div>
<!-- end:: Aside -->
