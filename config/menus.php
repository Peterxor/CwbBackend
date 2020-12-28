<?php

use Illuminate\Support\Facades\Auth;

return array(
    ['name' => 'dashboard', 'permission'=>'', 'display_name' => 'Dashboard', 'link' => 'index', 'display' => true , 'level'=>'1', 'icon'=>'<i class="la la-dashboard"></i>'],
    ['name' => 'device', 'permission'=>'', 'display_name' => '裝置排版管理', 'link' => 'device.index', 'display' => true, 'level'=>'1' ,'icon'=>'<i class="la la-tv"></i>'],
    ['name' => 'anchor', 'permission'=>'', 'display_name' => '主播偏好設定', 'link' => 'anchor.index', 'display' => true, 'level'=>'1' ,'icon'=>'<i class="la la-bullhorn"></i>'],
    ['name' => 'media', 'permission'=>'', 'display_name' => '圖資管理', 'display' => true, 'level'=>'1', 'icon'=>'','children' => [
        ['name' => 'weather', 'permission'=>'', 'display_name' => '一般天氣預報圖資', 'link' => 'weather.index', 'display' => false, 'level'=>'1'],
        ['name' => 'typhoon', 'permission'=>'', 'display_name' => '颱風預報圖資', 'link' => 'typhoon.index', 'display' => false, 'level'=>'1'],
    ]],
    ['name' => 'users', 'permission'=>'', 'display_name' => '使用者管理', 'link' => 'users.index', 'display' => true, 'level'=>'1' ,'icon'=>'<i class="la la-user"></i>'],
    ['name' => 'active', 'permission'=>'', 'display_name' => '事件紀錄', 'link' => 'active.index', 'display' => true, 'level'=>'1' ,'icon'=>'<i class="la la-file-text"></i>'],
);
