<?php

namespace App\Widgets;

use Arrilot\Widgets\AbstractWidget;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Redis;
use Log;
use Illuminate\Support\Facades\Auth;

class SideMenu extends AbstractWidget
{
    /**
     * The configuration array.
     *
     * @var array
     */
    protected $config = [];

    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function run()
    {
        try {
            $menus = Redis::get('menus');
            if (!$menus) {
                $menus = config('menus');
                Redis::set('menus', json_encode($menus));
                Log::debug('cache menus to redis');
            } else {
                $menus = json_decode($menus, true);
            }
        } catch (\Exception $e) {
            $menus = config('menus');
            // Log::debug('No redis, use config menu');
        }
        // check permission
        $user = Auth::user();
        $tempMenus = $this->checkChildrenPermission($menus, $user);
        $menus = $tempMenus;

        return view('backend.widgets.side_menu', [
            'items' => $menus,
        ]);
    }

    public function checkChildrenPermission($menu, $user)
    {
        $tempChildren = [];
        foreach($menu as $sub_menu) {
            if (isset($sub_menu['children'])) {
                $sub_menu['children'] = $this->checkChildrenPermission($sub_menu['children'], $user);
                if (count($sub_menu['children']) > 0) {
                    $tempChildren[] = $sub_menu;
                }
            } else if ($user->can($sub_menu['permission'])) {
                $tempChildren[] = $sub_menu;
            }
        }
        return $tempChildren;

    }
}
