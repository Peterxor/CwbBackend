<?php

namespace App\Widgets;

use Arrilot\Widgets\AbstractWidget;

class BrushLayout extends AbstractWidget
{
    /**
     * The configuration array.
     *
     * @var array
     */
    protected $config = [
        'update_url' => '',
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
        return view('backend.widgets.brush_layout', [
            'update_url' => $this->config['update_url'],
        ]);
    }
}
