<?php

namespace App\Widgets;

use Arrilot\Widgets\AbstractWidget;
use App\Models\User;

class UserSelect extends AbstractWidget
{
    protected $config = [
        'selected'=>[]
    ];

    public function __construct(array $config = [])
    {
        $this->addConfigDefaults($config);

        parent::__construct($config);
    }

    /**
     * 取得使用者資料
     */
    public function run()
    {
        $selectedUser = [];
        if (!empty($this->config['selected'])) {
            $selectedUser = array_column($this->config['selected']->toArray(), 'name');
        }

        $datas = User::select(['id','name'])
        ->get()
        ->map(function ($item) use ($selectedUser) {
            $item->selected = in_array($item->name, $selectedUser);
            return $item;
        });

        return view('backend.widgets.user_select', [
            'datas' => $datas,
        ]);
    }
}
