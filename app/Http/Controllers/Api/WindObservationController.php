<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Web\Controller;
use Illuminate\Http\JsonResponse;

class WindObservationController extends Controller
{
    private $locationToCounty = [
        "彭佳嶼" => "基隆市",
        "基隆嶼" => "基隆市",
        "基隆" => "基隆市",
        "七堵" => "基隆市",
        "鞍部" => "臺北市",
        "大屯山" => "臺北市",
        "陽明山" => "臺北市",
        "文化大學" => "臺北市",
        "平等" => "臺北市",
        "天母" => "臺北市",
        "台農院關渡站" => "臺北市",
        "石牌" => "臺北市",
        "社子" => "臺北市",
        "士林" => "臺北市",
        "內湖" => "臺北市",
        "松山" => "臺北市",
        "信義" => ["臺北市", "南投縣"],
        "臺北" => "臺北市",
        "國三南深路交流道" => "臺北市",
        "大安森林" => "臺北市",
        "臺灣大學" => "臺北市",
        "文山" => "臺北市",
        "白沙灣" => "新北市",
        "三芝" => "新北市",
        "三和" => "新北市",
        "金山" => "新北市",
        "大坪" => "新北市",
        "淡水" => "新北市",
        "八里" => "新北市",
        "硬漢嶺" => "新北市",
        "五指山" => "新北市",
        "鼻頭角" => "新北市",
        "瑞芳" => "新北市",
        "蘆洲" => "新北市",
        "五股" => "新北市",
        "林口" => "新北市",
        "五分山" => "新北市",
        "汐止" => "新北市",
        "三重" => "新北市",
        "新莊" => "新北市",
        "雙溪" => "新北市",
        "福隆" => "新北市",
        "永和" => "新北市",
        "三貂角" => "新北市",
        "火燒寮" => "新北市",
        "深坑" => "新北市",
        "板橋" => "新北市",
        "石碇" => "新北市",
        "中和" => "新北市",
        "山佳" => "新北市",
        "土城" => "新北市",
        "泰平" => "新北市",
        "新店" => "新北市",
        "文山茶改" => "新北市",
        "鶯歌" => "新北市",
        "桃改臺北" => "新北市",
        "三峽" => "新北市",
        "坪林" => "新北市",
        "屈尺" => "新北市",
        "四堵" => "新北市",
        "桶後" => "新北市",
        "福山" => "新北市",
        "福山植物園" => "新北市",
        "蘆竹" => "桃園市",
        "國一五楊N44K" => "桃園市",
        "大園" => "桃園市",
        "龜山" => "桃園市",
        "觀音" => "桃園市",
        "新屋" => "桃園市",
        "桃園" => "桃園市",
        "農工中心" => "桃園市",
        "八德蔬果" => "桃園市",
        "中壢" => "桃園市",
        "中央大學" => "桃園市",
        "桃園農改" => "桃園市",
        "八德合作社" => "桃園市",
        "八德" => "桃園市",
        "楊梅" => "桃園市",
        "茶改場" => "桃園市",
        "平鎮" => "桃園市",
        "大溪永福" => "桃園市",
        "大溪" => "桃園市",
        "龍潭" => "桃園市",
        "復興" => ["桃園市", "高雄市"],
        "新竹市東區" => "新竹市",
        "香山" => "新竹市",
        "湖口" => "新竹縣",
        "新豐" => "新竹縣",
        "打鐵坑" => "新竹縣",
        "新埔工作站" => "新竹縣",
        "新竹" => "新竹縣",
        "關西" => "新竹縣",
        "竹東" => "新竹縣",
        "寶山" => "新竹縣",
        "橫山" => "新竹縣",
        "峨眉" => "新竹縣",
        "梅花" => "新竹縣",
        "五峰站" => "新竹縣",
        "雪霸" => "新竹縣",
        "竹南" => "苗栗縣",
        "頭份" => "苗栗縣",
        "國一S114K" => "苗栗縣",
        "造橋" => "苗栗縣",
        "大河" => "苗栗縣",
        "高鐵苗栗" => "苗栗縣",
        "後龍" => "苗栗縣",
        "南庄" => "苗栗縣",
        "國一S123K" => "苗栗縣",
        "苗栗" => "苗栗縣",
        "西湖" => "苗栗縣",
        "獅潭" => "苗栗縣",
        "新竹畜試" => "苗栗縣",
        "國一S132K" => "苗栗縣",
        "國三S140K" => "苗栗縣",
        "苗栗農改" => "苗栗縣",
        "銅鑼" => "苗栗縣",
        "通霄" => "苗栗縣",
        "國一N142K" => "苗栗縣",
        "馬都安" => "苗栗縣",
        "苑裡" => "苗栗縣",
        "雪見" => "苗栗縣",
        "大湖分場" => "苗栗縣",
        "大湖" => "苗栗縣",
        "三義" => "苗栗縣",
        "國三S156K" => "苗栗縣",
        "卓蘭" => "苗栗縣",
        "桃山" => "臺中市",
        "雪山東峰" => "臺中市",
        "雪山圈谷" => "臺中市",
        "審馬陣" => "臺中市",
        "南湖圈谷" => "臺中市",
        "武陵" => "臺中市",
        "外埔" => "臺中市",
        "大甲" => "臺中市",
        "大安" => "臺中市",
        "清水" => "臺中市",
        "后里" => "臺中市",
        "國三S168K" => "臺中市",
        "國四E5K" => "臺中市",
        "石岡" => "臺中市",
        "國三S173K" => "臺中市",
        "烏石坑" => "臺中市",
        "神岡" => "臺中市",
        "梧棲" => "臺中市",
        "豐原" => "臺中市",
        "中坑" => "臺中市",
        "梨山" => "臺中市",
        "東勢" => ["臺中市", "雲林縣"],
        "國一S169K" => "臺中市",
        "國三S178K" => "臺中市",
        "種苗繁殖" => "臺中市",
        "潭子" => "臺中市",
        "國一N174K" => "臺中市",
        "新社" => "臺中市",
        "龍井" => "臺中市",
        "西屯" => "臺中市",
        "大坑" => ["臺中市", "花蓮縣"],
        "大肚" => "臺中市",
        "臺中" => "臺中市",
        "南屯" => "臺中市",
        "國一S188K" => "臺中市",
        "烏日" => "臺中市",
        "中竹林" => "臺中市",
        "大里" => "臺中市",
        "國三N208K" => "臺中市",
        "農業試驗所" => "臺中市",
        "伸港" => "彰化縣",
        "線西" => "彰化縣",
        "國三N191K" => "彰化縣",
        "國三N196K" => "彰化縣",
        "國三S202K" => "彰化縣",
        "彰師大" => "彰化縣",
        "鹿港" => "彰化縣",
        "國一N198K" => "彰化縣",
        "福興" => "彰化縣",
        "秀水" => "彰化縣",
        "花壇" => "彰化縣",
        "芬園" => "彰化縣",
        "臺中農改" => "彰化縣",
        "埔鹽" => "彰化縣",
        "國一S207K" => "彰化縣",
        "溪湖" => "彰化縣",
        "埔心" => "彰化縣",
        "員林" => "彰化縣",
        "芳苑" => "彰化縣",
        "二林" => "彰化縣",
        "田尾" => "彰化縣",
        "社頭" => "彰化縣",
        "北斗" => "彰化縣",
        "高鐵彰化" => "彰化縣",
        "田中" => "彰化縣",
        "埤頭" => "彰化縣",
        "大城" => "彰化縣",
        "溪州" => "彰化縣",
        "竹塘" => "彰化縣",
        "二水" => "彰化縣",
        "畢祿溪站" => "南投縣",
        "合歡山頂" => "南投縣",
        "小奇萊" => "南投縣",
        "昆陽" => "南投縣",
        "梅峰" => "南投縣",
        "國姓" => "南投縣",
        "廬山" => "南投縣",
        "仁愛" => "南投縣",
        "國三S217K" => "南投縣",
        "萬大發電廠" => "南投縣",
        "草屯" => "南投縣",
        "埔里" => "南投縣",
        "國三N223K" => "南投縣",
        "萬大林道" => "南投縣",
        "蓮華池" => "南投縣",
        "南投" => "南投縣",
        "埔里分場" => "南投縣",
        "南投服務區" => "南投縣",
        "魚池" => "南投縣",
        "中寮" => "南投縣",
        "日月潭" => "南投縣",
        "魚池茶改" => "南投縣",
        "名間" => "南投縣",
        "集集" => "南投縣",
        "消防署訓練中心" => "南投縣",
        "水里" => "南投縣",
        "凍頂茶改" => "南投縣",
        "竹山" => "南投縣",
        "臺大竹山" => "南投縣",
        "鳳凰" => "南投縣",
        "臺大內茅埔" => "南投縣",
        "臺大溪頭" => "南投縣",
        "臺大和社" => "南投縣",
        "神木村" => "南投縣",
        "玉山" => "南投縣",
        "玉山風口" => "南投縣",
        "大庄合作社" => "雲林縣",
        "西螺" => "雲林縣",
        "麥寮" => "雲林縣",
        "二崙" => "雲林縣",
        "莿桐" => "雲林縣",
        "崙背" => "雲林縣",
        "麥寮合作社" => "雲林縣",
        "林內" => "雲林縣",
        "國一N234K" => "雲林縣",
        "高鐵雲林" => "雲林縣",
        "雲林臺大" => "雲林縣",
        "斗六" => "雲林縣",
        "虎尾" => "雲林縣",
        "臺西水試" => "雲林縣",
        "水試所臺西" => "雲林縣",
        "臺西" => "雲林縣",
        "褒忠" => "雲林縣",
        "棋山" => "雲林縣",
        "土庫" => "雲林縣",
        "斗南" => "雲林縣",
        "四湖植物園" => "雲林縣",
        "古坑" => "雲林縣",
        "元長" => "雲林縣",
        "大埤" => "雲林縣",
        "雲林分場" => "雲林縣",
        "古坑(花卉中心)" => "雲林縣",
        "四湖" => "雲林縣",
        "草嶺" => "雲林縣",
        "口湖工作站" => "雲林縣",
        "北港" => "雲林縣",
        "水林" => "雲林縣",
        "宜梧" => "雲林縣",
        "蔦松" => "雲林縣",
        "嘉義" => "嘉義市",
        "嘉義農試" => "嘉義市",
        "嘉義市東區" => "嘉義市",
        "國一N250K" => "嘉義縣",
        "溪口" => "嘉義縣",
        "大林" => "嘉義縣",
        "溪口農場" => "嘉義縣",
        "梅山" => "嘉義縣",
        "新港" => "嘉義縣",
        "民雄" => "嘉義縣",
        "竹崎" => "嘉義縣",
        "阿里山" => "嘉義縣",
        "奮起湖" => "嘉義縣",
        "六腳" => "嘉義縣",
        "番路" => "嘉義縣",
        "東石" => "嘉義縣",
        "太保" => "嘉義縣",
        "達邦" => "嘉義縣",
        "朴子" => "嘉義縣",
        "中埔" => "嘉義縣",
        "水上" => "嘉義縣",
        "嘉義分場" => "嘉義縣",
        "鹿草" => "嘉義縣",
        "里佳" => "嘉義縣",
        "布袋" => "嘉義縣",
        "東後寮" => "嘉義縣",
        "義竹分場" => "嘉義縣",
        "新美" => "嘉義縣",
        "馬頭山" => "嘉義縣",
        "茶山" => "嘉義縣",
        "表湖" => "嘉義縣",
        "鹿寮" => "臺南市",
        "白河" => "臺南市",
        "蘭花園區" => "臺南市",
        "關子嶺" => "臺南市",
        "新營" => "臺南市",
        "東河" => ["臺南市", "臺東縣"],
        "鹽水" => "臺南市",
        "北門" => "臺南市",
        "柳營" => "臺南市",
        "學甲" => "臺南市",
        "下營" => "臺南市",
        "王爺宮" => "臺南市",
        "曾文" => "臺南市",
        "將軍" => "臺南市",
        "官田" => "臺南市",
        "麻豆" => "臺南市",
        "佳里" => "臺南市",
        "七股" => "臺南市",
        "玉井" => "臺南市",
        "西港" => "臺南市",
        "水試所七股" => "臺南市",
        "大內" => "臺南市",
        "善化" => "臺南市",
        "安定" => "臺南市",
        "七股研究中心" => "臺南市",
        "北寮" => "臺南市",
        "安南" => "臺南市",
        "山上" => "臺南市",
        "新市" => "臺南市",
        "臺南農改" => "臺南市",
        "畜試所" => "臺南市",
        "左鎮" => "臺南市",
        "永康" => "臺南市",
        "虎頭埤" => "臺南市",
        "臺南市北區" => "臺南市",
        "臺南" => "臺南市",
        "安平" => "臺南市",
        "媽廟" => "臺南市",
        "仁德" => "臺南市",
        "關廟" => "臺南市",
        "臺南市南區" => "臺南市",
        "崎頂" => "臺南市",
        "小林" => "高雄市",
        "甲仙" => "高雄市",
        "六龜" => "高雄市",
        "六龜林試" => "高雄市",
        "內門" => "高雄市",
        "月眉" => "高雄市",
        "扇平林試" => "高雄市",
        "茄萣" => "高雄市",
        "萬山" => "高雄市",
        "美濃" => "高雄市",
        "古亭坑" => "高雄市",
        "旗山" => "高雄市",
        "茂林" => "高雄市",
        "阿蓮" => "高雄市",
        "旗南農改" => "高雄市",
        "路竹" => "高雄市",
        "永安" => "高雄市",
        "阿公店" => "高雄市",
        "岡山" => "高雄市",
        "彌陀" => "高雄市",
        "橋頭" => "高雄市",
        "溪埔" => "高雄市",
        "大社" => "高雄市",
        "楠梓" => "高雄市",
        "仁武" => "高雄市",
        "左營" => "高雄市",
        "鳳山" => "高雄市",
        "鳳山農試" => "高雄市",
        "三民" => "高雄市",
        "新興" => "高雄市",
        "鼓山" => "高雄市",
        "苓雅" => "高雄市",
        "大寮" => "高雄市",
        "旗津" => "高雄市",
        "高雄" => "高雄市",
        "鳳森" => "高雄市",
        "林園" => "高雄市",
        "東沙島" => "高雄市",
        "南沙島" => "高雄市",
        "尾寮山" => "屏東縣",
        "高樹" => "屏東縣",
        "里港" => "屏東縣",
        "阿禮" => "屏東縣",
        "九如" => "屏東縣",
        "鹽埔" => "屏東縣",
        "三地門" => "屏東縣",
        "高雄農改" => "屏東縣",
        "長治" => "屏東縣",
        "瑪家" => "屏東縣",
        "屏東" => "屏東縣",
        "麟洛" => "屏東縣",
        "赤山" => "屏東縣",
        "舊泰武" => "屏東縣",
        "萬丹" => "屏東縣",
        "竹田" => "屏東縣",
        "新園" => "屏東縣",
        "潮州" => "屏東縣",
        "來義" => "屏東縣",
        "崁頂" => "屏東縣",
        "南州" => "屏東縣",
        "東港工作站" => "屏東縣",
        "新埤" => "屏東縣",
        "東港" => "屏東縣",
        "白鷺" => "屏東縣",
        "林邊" => "屏東縣",
        "佳冬" => "屏東縣",
        "大漢山" => "屏東縣",
        "春日" => "屏東縣",
        "枋寮" => "屏東縣",
        "琉球嶼" => "屏東縣",
        "內獅" => "屏東縣",
        "枋山" => "屏東縣",
        "旭海" => "屏東縣",
        "丹路" => "屏東縣",
        "獅子" => "屏東縣",
        "楓港" => "屏東縣",
        "牡丹池山" => "屏東縣",
        "九棚" => "屏東縣",
        "牡丹" => "屏東縣",
        "高士" => "屏東縣",
        "南仁湖" => "屏東縣",
        "恆春工作站" => "恆春半島",
        "四林格山" => "屏東縣",
        "檳榔" => "屏東縣",
        "車城" => "屏東縣",
        "保力" => "屏東縣",
        "大坪頂" => "屏東縣",
        "滿州" => "屏東縣",
        "恆春" => "恆春半島",
        "佳樂水" => "屏東縣",
        "墾丁" => "屏東縣",
        "恆春畜試" => "恆春半島",
        "龍磐" => "屏東縣",
        "貓鼻頭" => "屏東縣",
        "墾雷" => "屏東縣",
        "桃源谷" => "宜蘭縣",
        "鶯子嶺" => "宜蘭縣",
        "坪林石牌" => "宜蘭縣",
        "頭城" => "宜蘭縣",
        "龜山島" => "宜蘭縣",
        "礁溪" => "宜蘭縣",
        "大福" => "宜蘭縣",
        "大礁溪" => "宜蘭縣",
        "宜蘭" => "宜蘭縣",
        "雙連埤" => "宜蘭縣",
        "員山" => "宜蘭縣",
        "內城" => "宜蘭縣",
        "五結" => "宜蘭縣",
        "蘭陽分場" => "宜蘭縣",
        "羅東" => "宜蘭縣",
        "玉蘭" => "宜蘭縣",
        "宜蘭畜試" => "宜蘭縣",
        "三星" => "宜蘭縣",
        "冬山" => "宜蘭縣",
        "蘇澳" => "宜蘭縣",
        "鴛鴦湖" => "宜蘭縣",
        "土場" => "宜蘭縣",
        "西德山" => "宜蘭縣",
        "西帽山" => "宜蘭縣",
        "白嶺" => "宜蘭縣",
        "東澳" => "宜蘭縣",
        "翠峰湖" => "宜蘭縣",
        "太平山" => "宜蘭縣",
        "南澳" => "宜蘭縣",
        "南山" => "宜蘭縣",
        "樟樹山" => "宜蘭縣",
        "多加屯" => "宜蘭縣",
        "和平林道" => "花蓮縣",
        "和平" => "花蓮縣",
        "和中" => "花蓮縣",
        "清水斷崖" => "花蓮縣",
        "大禹嶺" => "花蓮縣",
        "天祥" => "花蓮縣",
        "富世" => "花蓮縣",
        "合歡山" => "花蓮縣",
        "新城" => "花蓮縣",
        "水源" => "花蓮縣",
        "花蓮農改" => "花蓮縣",
        "花蓮" => "花蓮縣",
        "鯉魚潭" => "花蓮縣",
        "吉安光華" => "花蓮縣",
        "東華" => "花蓮縣",
        "西林" => "花蓮縣",
        "月眉山" => "花蓮縣",
        "水璉" => "花蓮縣",
        "鳳林" => "花蓮縣",
        "蕃薯寮" => "花蓮縣",
        "鳳林山" => "花蓮縣",
        "萬榮" => "花蓮縣",
        "加路蘭山" => "花蓮縣",
        "光復" => "花蓮縣",
        "富源" => "花蓮縣",
        "豐濱" => "花蓮縣",
        "瑞穗" => "花蓮縣",
        "瑞穗林道" => "花蓮縣",
        "德武" => "花蓮縣",
        "舞鶴" => "花蓮縣",
        "靜浦" => "花蓮縣",
        "赤柯山" => "花蓮縣",
        "佳心" => "花蓮縣",
        "卓溪" => "花蓮縣",
        "玉里" => "花蓮縣",
        "安通山" => "花蓮縣",
        "清水林道" => "花蓮縣",
        "東里" => "花蓮縣",
        "明里" => "花蓮縣",
        "富里" => "花蓮縣",
        "長濱" => "臺東縣",
        "向陽" => "臺東縣",
        "石寧山" => "臺東縣",
        "下馬" => "臺東縣",
        "池上" => "臺東縣",
        "水試所成功" => "臺東縣",
        "成功" => "臺東縣",
        "紅石" => "臺東縣",
        "關山" => "臺東縣",
        "都歷" => "臺東縣",
        "瑞和" => "臺東縣",
        "七塊厝" => "臺東縣",
        "鹿野" => "臺東縣",
        "臺東茶改" => "臺東縣",
        "延平" => "臺東縣",
        "斑鳩分場" => "臺東縣",
        "賓朗果園" => "臺東縣",
        "檳榔四格山" => "臺東縣",
        "臺東" => "臺東縣",
        "知本(水試所)" => "臺東縣",
        "知本" => "臺東縣",
        "綠島" => "蘭嶼綠島",
        "太麻里" => "臺東縣",
        "太麻里1" => "臺東縣",
        "太麻里2" => "臺東縣",
        "金峰嘉蘭" => "臺東縣",
        "香蘭" => "臺東縣",
        "金崙山" => "臺東縣",
        "金崙" => "臺東縣",
        "歷坵" => "臺東縣",
        "大溪山" => "臺東縣",
        "土坂" => "臺東縣",
        "勝林山" => "臺東縣",
        "加津林" => "臺東縣",
        "大武" => "臺東縣",
        "山豬窟" => "臺東縣",
        "南田" => "臺東縣",
        "達仁林場" => "臺東縣",
        "蘭嶼燈塔" => "蘭嶼綠島",
        "蘭嶼高中" => "蘭嶼綠島",
        "蘭嶼" => "蘭嶼綠島",
        "蘭嶼綠島" => "蘭嶼綠島",
        "吉貝" => "澎湖縣",
        "澎湖" => "澎湖縣",
        "花嶼" => "澎湖縣",
        "東吉島" => "澎湖縣",
        "烏坵" => "金門縣",
        "金沙" => "金門縣",
        "金寧" => "金門縣",
        "九宮碼頭" => "金門縣",
        "金門(東)" => "金門縣",
        "金門" => "金門縣",
        "馬祖" => "連江縣",
        "東莒" => "連江縣"
    ];

    private $countyToTaiwan = [
        '臺北市' => 'n',
        '新北市' => 'n',
        '基隆市' => 'n',
        '桃園市' => 'n',
        '新竹市' => 'n',
        '新竹縣' => 'n',
        '宜蘭縣' => 'n',
        '苗栗縣' => 'm',
        '臺中市' => 'm',
        '彰化縣' => 'm',
        '南投縣' => 'm',
        '雲林縣' => 'm',
        '嘉義市' => 's',
        '嘉義縣' => 's',
        '臺南市' => 's',
        '高雄市' => 's',
        '屏東縣' => 's',
        '恆春半島' => 's',
        '澎湖縣' => 's',
        '花蓮縣' => 'e',
        '臺東縣' => 'e',
        '蘭嶼綠島' => 'e',
        '金門縣' => 'e',
        '連江縣' => 'e'
    ];

    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $stationObs = simplexml_load_file(storage_path('data/wind/obs/WindObs.xml'));

        $data = [
            'startTime' => (string)$stationObs->dataset->datasetInfo->validTime->startTime,
            'endTime' => (string)$stationObs->dataset->datasetInfo->validTime->endTime,
        ];

        $location = ['n' => [], 'm' => [], 's' => [], 'e' => []];
        foreach ($stationObs->dataset->location ?? [] as $loc) {
            if (!array_key_exists((string)$loc->locationName, $this->locationToCounty))
                continue;

            $county = $this->locationToCounty[(string)$loc->locationName];
            if (is_array($county)) {
                foreach ($county as $c) {
                    if (!array_key_exists($c, $location[$this->countyToTaiwan[$c]])) {
                        $county = $c;
                        break;
                    }
                }
            }

            if (is_array($county) || array_key_exists($county, $location[$this->countyToTaiwan[$county]]))
                continue;

            $location[$this->countyToTaiwan[$county]][$county] = [
                "wind" => (string)$loc->weatherElement[1]->time->parameter[2]->parameterValue,
                "gust" => (string)$loc->weatherElement[2]->time->parameter[2]->parameterValue,
            ];
        }

        $data['location'] = $location;

        return response()->json($data);
    }
}
