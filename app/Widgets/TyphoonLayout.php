<?php

namespace App\Widgets;

use Arrilot\Widgets\AbstractWidget;
use Illuminate\Support\Facades\Config;

class TyphoonLayout extends AbstractWidget
{
    /**
     * The configuration array.
     *
     * @var array
     */
    protected $config = [
         'auchor'=>''
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
        $layout = config('typhoonlayout');

        return view('backend.widgets.typhoon_layout', [
            'items' => $layout,
            'auchor' => $this->config['auchor']
        ]);
    }
}
