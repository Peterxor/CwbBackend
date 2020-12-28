<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddPreferenceJsonInDevice extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('device', function (Blueprint $table) {
            $table->json('preference_json')->nullable()->comment('預設偏好json');
        });

        DB::table('device')->update(['preference_json' => '{"颱風預報":{"颱風動態":{"颱風動態":{"zoom":200,"translate":"left_top","point":[0,0]},"颱風IR":{"zoom":200,"translate":"left_top","point":[0,0]},"颱風MB":{"zoom":200,"translate":"left_top","point":[0,0]},"颱風VIS":{"zoom":200,"translate":"left_top","point":[0,0]},"標題":{"translate":"left_top","point":[0,0]},"工具列_中":{"translate":"left_top","point":[0,0]}},"颱風潛勢":{"颱風潛勢":{"zoom":200,"translate":"left_top","point":[0,0]},"標題":{"translate":"left_top","point":[0,0]},"工具列_中":{"translate":"left_top","point":[0,0]}},"風力觀測":{"台灣_全":{"zoom":200,"translate":"left_top","point":[0,0]},"台灣_北":{"zoom":200,"translate":"left_top","point":[0,0]},"台灣_中":{"zoom":200,"translate":"left_top","point":[0,0]},"台灣_南":{"zoom":200,"translate":"left_top","point":[0,0]},"台灣_東":{"zoom":200,"translate":"left_top","point":[0,0]},"標題":{"translate":"left_top","point":[0,0]},"圖例":{"translate":"left_top","point":[0,0]},"工具列_左":{"translate":"left_top","point":[0,0]},"工具列_右":{"translate":"left_top","point":[0,0]},"工具列_中":{"translate":"left_top","point":[0,0]}},"風力預測":{"台灣_全":{"zoom":200,"translate":"left_top","point":[0,0]},"台灣_北":{"zoom":200,"translate":"left_top","point":[0,0]},"台灣_中":{"zoom":200,"translate":"left_top","point":[0,0]},"台灣_南":{"zoom":200,"translate":"left_top","point":[0,0]},"台灣_東":{"zoom":200,"translate":"left_top","point":[0,0]},"標題":{"translate":"left_top","point":[0,0]},"圖例":{"translate":"left_top","point":[0,0]},"工具列_左":{"translate":"left_top","point":[0,0]},"工具列_右":{"translate":"left_top","point":[0,0]},"工具列_中":{"translate":"left_top","point":[0,0]}},"雨量觀測":{"台灣_全":{"zoom":200,"translate":"left_top","point":[0,0]},"台灣_北":{"zoom":200,"translate":"left_top","point":[0,0]},"台灣_中":{"zoom":200,"translate":"left_top","point":[0,0]},"台灣_南":{"zoom":200,"translate":"left_top","point":[0,0]},"台灣_宜":{"zoom":200,"translate":"left_top","point":[0,0]},"台灣_花":{"zoom":200,"translate":"left_top","point":[0,0]},"台灣_東":{"zoom":200,"translate":"left_top","point":[0,0]},"標題":{"translate":"left_top","point":[0,0]},"圖例":{"translate":"left_top","point":[0,0]},"工具列_左":{"translate":"left_top","point":[0,0]},"工具列_右":{"translate":"left_top","point":[0,0]},"工具列_中":{"translate":"left_top","point":[0,0]}},"雨量預測":{"台灣_全":{"zoom":200,"translate":"left_top","point":[0,0]},"台灣_北":{"zoom":200,"translate":"left_top","point":[0,0]},"台灣_中":{"zoom":200,"translate":"left_top","point":[0,0]},"台灣_南":{"zoom":200,"translate":"left_top","point":[0,0]},"台灣_宜":{"zoom":200,"translate":"left_top","point":[0,0]},"台灣_花":{"zoom":200,"translate":"left_top","point":[0,0]},"台灣_東":{"zoom":200,"translate":"left_top","point":[0,0]},"標題":{"translate":"left_top","point":[0,0]},"圖例":{"translate":"left_top","point":[0,0]},"工具列_左":{"translate":"left_top","point":[0,0]},"工具列_右":{"translate":"left_top","point":[0,0]},"工具列_中":{"translate":"left_top","point":[0,0]}},"主播圖卡":{"圖卡區塊":{"translate":"left_top","point":[0,0]}}},"一般天氣":{"東亞VIS":{"東亞VIS":{"zoom":200,"translate":"left_top","point":[0,0]},"標題":{"translate":"left_top","point":[0,0]},"工具列_左":{"translate":"left_top","point":[0,0]},"工具列_右":{"translate":"left_top","point":[0,0]}},"天氣預測":{"天氣預測":{"zoom":200,"translate":"left_top","point":[0,0]},"標題":{"translate":"left_top","point":[0,0]},"工具列_左":{"translate":"left_top","point":[0,0]},"工具列_右":{"translate":"left_top","point":[0,0]},"圖片列表_左":{"translate":"left_top","point":[0,0]},"圖片列表_右":{"translate":"left_top","point":[0,0]}},"定量降水預報6小時":{"雙圖群組":{"translate":"left_top","point":[0,0]},"標題":{"translate":"left_top","point":[0,0]},"工具列_左":{"translate":"left_top","point":[0,0]},"工具列_右":{"translate":"left_top","point":[0,0]}}}}']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('device', function (Blueprint $table) {
            $table->dropColumn('preference_json');
        });
    }
}
