<?php

namespace App\Widgets;

use Arrilot\Widgets\AbstractWidget;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Redis;
use Log;

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

        return view('backend.widgets.side_menu', [
            'items' => $menus,
        ]);
    }
}
