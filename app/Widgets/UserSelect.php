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
        $selected = '';
        if (!empty($this->config['selected'])) {
            $selected = $this->config['selected'];
        }

        $datas = User::select(['id','name'])->get();

        return view('backend.widgets.user_select', [
            'datas' => $datas,
            'selected'=>$selected
        ]);
    }
}
