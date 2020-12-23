
<!-- begin:: Header -->
<div id="kt_header" class="kt-header kt-grid__item  kt-header--fixed ">
    <!-- begin:: Header Menu -->
    <div class="kt-header-menu-wrapper" id="kt_header_menu_wrapper">

    </div>
    <!-- end:: Header Menu -->

    <!-- begin:: Header Topbar -->
    <div class="kt-header__topbar">

        <div class="kt-header__topbar-item kt-header__topbar-item--user">
            <div class="kt-header__topbar-wrapper" data-toggle="dropdown" data-offset="0px,0px">
                <div class="kt-header__topbar-user">
                    <span class="kt-header__topbar-welcome kt-hidden-mobile">Hi,</span>
                    <span
                        class="kt-header__topbar-username kt-hidden-mobile">{{Auth::user() ? Auth::user()->name : ''}}</span>
                    <img class="" alt="Pic" src="/images/user/default.png"/>
                </div>
            </div>

            <div
                class="dropdown-menu dropdown-menu-fit dropdown-menu-right dropdown-menu-anim dropdown-menu-top-unround dropdown-menu-xl">
                <!--begin: Head -->
                <div class="kt-user-card kt-user-card--skin-dark kt-notification-item-padding-x"
                     style="background-color: #45BBFF">
                    <div class="kt-user-card__avatar">
                        <img class="" alt="Pic" src="/images/user/default.png"/>
                    </div>
                    <div class="kt-user-card__name">
                        {{Auth::user() ? Auth::user()->name : ''}}
                    </div>
                    @if(isset($roles[0]) && $roles[0])
                        <div class="kt-user-card__badge">
    						<span class="btn btn-success btn-sm btn-bold btn-font-md">{{$roles[0]}}</span>
    					</div>
                    @endif
                </div>
                <!--end: Head -->

                <!--begin: Navigation -->
                <div class="kt-notification">
                    <div class="kt-notification__custom kt-space-between float-right">
                        <a href="{{route('logout')}}"
                           class="btn m-btn--pill btn-secondary m-btn m-btn--custom m-btn--label-brand m-btn--bolder"
                           onclick="event.preventDefault();
                              document.getElementById('logout-form').submit();">
                            {{ __('登出') }}</a>
                        <form id="logout-form" action="{{ route('logout') }}"
                              method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                </div>
                <!--end: Navigation -->
            </div>
        </div>
        <!--end: User Bar -->
    </div>
    <!-- end:: Header Topbar -->
</div>
<!-- end:: Header -->
