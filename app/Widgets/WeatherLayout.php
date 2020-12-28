<?php

namespace App\Widgets;

use Arrilot\Widgets\AbstractWidget;
use Illuminate\Support\Facades\Config;

class WeatherLayout extends AbstractWidget
{
    /**
     * The configuration array.
     *
     * @var array
     */
    protected $config = [
        'update_url' => '',
        'auchor' => '',
        'preference' => []
     ];

    public function __construct(array $config = [])
    {
        $this->addConfigDefaults($config);

        parent::__construct($config);
    }

    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function run()
    {
        $layout = config('weatherlayout');

        return view('backend.widgets.weather_layout', [
            'update_url' => $this->config['update_url'],
            'items' => $layout,
            'preference' => $this->config['preference'],
            'auchor' => $this->config['auchor']
        ]);
    }
}
