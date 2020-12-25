<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Web\Controller;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;

class RainfallObservationController extends Controller
{
    private $siteToArea = [
        "澎湖縣望安鄉(氣象站)" => ["澎湖縣", "望安鄉"],
        "新北市金山區" => ["新北市", "金山區"],
        "澎湖縣望安鄉(第6河川局)" => ["澎湖縣", "望安鄉"],
        "新北市石門區" => ["新北市", "石門區"],
        "臺南市七股區" => ["臺南市", "七股區"],
        "高雄市茄萣區" => ["高雄市", "茄萣區"],
        "臺南市安南區" => ["臺南市", "安南區"],
        "屏東縣春日鄉" => ["屏東縣", "春日鄉"],
        "臺南市七股區(合作站)" => ["臺南市", "七股區"],
        "臺南市永康區(氣象站)" => ["臺南市", "永康區"],
        "臺南市安平區" => ["臺南市", "安平區"],
        "臺南市安定區" => ["臺南市", "安定區"],
        "屏東縣泰武鄉" => ["屏東縣", "泰武鄉"],
        "臺南市佳里區" => ["臺南市", "佳里區"],
        "臺南市中西區(氣象站)" => ["臺南市", "中西區"],
        "臺東縣達仁鄉" => ["臺東縣", "達仁鄉"],
        "臺南市北區" => ["臺南市", "北區"],
        "新北市萬里區(水保局)" => ["新北市", "萬里區"],
        "臺南市南區" => ["臺南市", "南區"],
        "高雄市楠梓區" => ["高雄市", "楠梓區"],
        "高雄市旗津區" => ["高雄市", "旗津區"],
        "高雄市梓官區" => ["高雄市", "梓官區"],
        "屏東縣琉球鄉" => ["屏東縣", "琉球鄉"],
        "高雄市永安區" => ["高雄市", "永安區"],
        "高雄市彌陀區" => ["高雄市", "彌陀區"],
        "臺南市仁德區" => ["臺南市", "仁德區"],
        "高雄市路竹區" => ["高雄市", "路竹區"],
        "高雄市湖內區" => ["高雄市", "湖內區"],
        "高雄市左營區" => ["高雄市", "左營區"],
        "澎湖縣望安鄉" => ["澎湖縣", "望安鄉"],
        "高雄市前鎮區(氣象站)" => ["高雄市", "前鎮區"],
        "臺東縣太麻里鄉" => ["臺東縣", "太麻里鄉"],
        "臺南市將軍區" => ["臺南市", "將軍區"],
        "臺東縣達仁鄉(第8河川局)" => ["臺東縣", "達仁鄉"],
        "新北市瑞芳區" => ["新北市", "瑞芳區"],
        "臺南市西港區" => ["臺南市", "西港區"],
        "高雄市岡山區" => ["高雄市", "岡山區"],
        "高雄市三民區" => ["高雄市", "三民區"],
        "高雄市新興區" => ["高雄市", "新興區"],
        "臺東縣金峰鄉(第8河川局)" => ["臺東縣", "金峰鄉"],
        "臺南市歸仁區" => ["臺南市", "歸仁區"],
        "高雄市橋頭區" => ["高雄市", "橋頭區"],
        "屏東縣牡丹鄉" => ["屏東縣", "牡丹鄉"],
        "屏東縣獅子鄉" => ["屏東縣", "獅子鄉"],
        "高雄市鼓山區" => ["高雄市", "鼓山區"],
        "屏東縣萬丹鄉" => ["屏東縣", "萬丹鄉"],
        "屏東縣獅子鄉(水保局)" => ["屏東縣", "獅子鄉"],
        "新北市石門區(十河局)" => ["新北市", "石門區"],
        "臺東縣卑南鄉" => ["臺東縣", "卑南鄉"],
        "臺東縣金峰鄉" => ["臺東縣", "金峰鄉"],
        "屏東縣滿州鄉" => ["屏東縣", "滿州鄉"],
        "臺東縣大武鄉(水保局)" => ["臺東縣", "大武鄉"],
        "花蓮縣秀林鄉" => ["花蓮縣", "秀林鄉"],
        "宜蘭縣頭城鎮" => ["宜蘭縣", "頭城鎮"],
        "臺東縣大武鄉(氣象站)" => ["臺東縣", "大武鄉"],
        "高雄市燕巢區" => ["高雄市", "燕巢區"],
        "臺南市北門區" => ["臺南市", "北門區"],
        "高雄市阿蓮區" => ["高雄市", "阿蓮區"],
        "臺東縣太麻里鄉(第8河川局)" => ["臺東縣", "太麻里鄉"],
        "高雄市阿蓮區(第6河川局)" => ["高雄市", "阿蓮區"],
        "高雄市苓雅區" => ["高雄市", "苓雅區"],
        "高雄市仁武區" => ["高雄市", "仁武區"],
        "澎湖縣馬公市(氣象站)" => ["澎湖縣", "馬公市"],
        "高雄市鳳山區" => ["高雄市", "鳳山區"],
        "高雄市小港區" => ["高雄市", "小港區"],
        "高雄市大社區" => ["高雄市", "大社區"],
        "高雄市鳳山區(合作站)" => ["高雄市", "鳳山區"],
        "花蓮縣豐濱鄉" => ["花蓮縣", "豐濱鄉"],
        "高雄市大寮區" => ["高雄市", "大寮區"],
        "屏東縣牡丹鄉(第7河川局)" => ["屏東縣", "牡丹鄉"],
        "新北市雙溪區" => ["新北市", "雙溪區"],
        "高雄市林園區" => ["高雄市", "林園區"],
        "新北市貢寮區" => ["新北市", "貢寮區"],
        "花蓮縣萬榮鄉(第9河川局)" => ["花蓮縣", "萬榮鄉"],
        "臺東縣大武鄉" => ["臺東縣", "大武鄉"],
        "新北市貢寮區(第1河川局)" => ["新北市", "貢寮區"],
        "屏東縣萬丹鄉(第7河川局)" => ["屏東縣", "萬丹鄉"],
        "新北市雙溪區(翡翠水庫)" => ["新北市", "雙溪區"],
        "臺南市學甲區(合作站)" => ["臺南市", "學甲區"],
        "基隆市中正區(氣象站)" => ["基隆市", "中正區"],
        "屏東縣新園鄉" => ["屏東縣", "新園鄉"],
        "屏東縣霧臺鄉" => ["屏東縣", "霧臺鄉"],
        "屏東縣內埔鄉" => ["屏東縣", "內埔鄉"],
        "花蓮縣萬榮鄉" => ["花蓮縣", "萬榮鄉"],
        "宜蘭縣大同鄉" => ["宜蘭縣", "大同鄉"],
        "屏東縣東港鎮" => ["屏東縣", "東港鎮"],
        "澎湖縣白沙鄉(合作站)" => ["澎湖縣", "白沙鄉"],
        "新北市萬里區" => ["新北市", "萬里區"],
        "新北市平溪區(十河局)" => ["新北市", "平溪區"],
        "屏東縣霧臺鄉(第7河川局)" => ["屏東縣", "霧臺鄉"],
        "屏東縣屏東市(第7河川局)" => ["屏東縣", "屏東市"],
        "高雄市燕巢區(第6河川局)" => ["高雄市", "燕巢區"],
        "臺南市麻豆區" => ["臺南市", "麻豆區"],
        "臺南市學甲區" => ["臺南市", "學甲區"],
        "屏東縣東港鎮(合作站)" => ["屏東縣", "東港鎮"],
        "臺東縣太麻里鄉(合作站)" => ["臺東縣", "太麻里鄉"],
        "臺東縣海端鄉" => ["臺東縣", "海端鄉"],
        "臺南市關廟區" => ["臺南市", "關廟區"],
        "屏東縣崁頂鄉(第7河川局)" => ["屏東縣", "崁頂鄉"],
        "臺東縣卑南鄉(水保局)" => ["臺東縣", "卑南鄉"],
        "臺東縣海端鄉(第8河川局)" => ["臺東縣", "海端鄉"],
        "臺東縣車城鄉" => ["臺東縣", "車城鄉"],
        "新北市平溪區" => ["新北市", "平溪區"],
        "臺南市下營區" => ["臺南市", "下營區"],
        "屏東縣潮州鎮" => ["屏東縣", "潮州鎮"],
        "屏東縣獅子鄉(第7河川局)" => ["屏東縣", "獅子鄉"],
        "臺中市和平區" => ["臺中市", "和平區"],
        "基隆市仁愛區(氣象站)" => ["基隆市", "仁愛區"],
        "屏東縣南州鄉" => ["屏東縣", "南州鄉"],
        "屏東縣崁頂鄉" => ["屏東縣", "崁頂鄉"],
        "宜蘭縣大同鄉(第1河川局)" => ["宜蘭縣", "大同鄉"],
        "臺北市士林區(大地工程處)" => ["臺北市", "士林區"],
        "花蓮縣富里鄉" => ["花蓮縣", "富里鄉"],
        "花蓮縣豐濱鄉(第9河川局)" => ["花蓮縣", "豐濱鄉"],
        "宜蘭縣南澳鄉" => ["宜蘭縣", "南澳鄉"],
        "屏東縣麟洛鄉" => ["屏東縣", "麟洛鄉"],
        "臺南市鹽水區" => ["臺南市", "鹽水區"],
        "屏東縣長治鄉" => ["屏東縣", "長治鄉"],
        "嘉義縣布袋鎮" => ["嘉義縣", "布袋鎮"],
        "臺南市新市區" => ["臺南市", "新市區"],
        "屏東縣恆春鎮" => ["屏東縣", "恆春鎮"],
        "新北市雙溪區(第1河川局)" => ["新北市", "雙溪區"],
        "新北市瑞芳區(十河局)" => ["新北市", "瑞芳區"],
        "屏東縣春日鄉(第7河川局)" => ["屏東縣", "春日鄉"],
        "基隆市七堵區" => ["基隆市", "七堵區"],
        "基隆市中正區" => ["基隆市", "中正區"],
        "新北市坪林區(翡翠水庫)" => ["新北市", "坪林區"],
        "高雄市大樹區" => ["高雄市", "大樹區"],
        "屏東縣屏東市" => ["屏東縣", "屏東市"],
        "臺南市新化區(第6河川局)" => ["臺南市", "新化區"],
        "臺東縣蘭嶼鄉" => ["臺東縣", "蘭嶼鄉"],
        "臺東縣金峰鄉(水保局)" => ["臺東縣", "金峰鄉"],
        "新北市石碇區(翡翠水庫)" => ["新北市", "石碇區"],
        "宜蘭縣蘇澳鎮(氣象站)" => ["宜蘭縣", "蘇澳鎮"],
        "臺北市北投區(大地工程處)" => ["臺北市", "北投區"],
        "屏東縣林邊鄉" => ["屏東縣", "林邊鄉"],
        "雲林縣口湖鄉" => ["雲林縣", "口湖鄉"],
        "嘉義縣義竹鄉" => ["嘉義縣", "義竹鄉"],
        "新竹縣五峰鄉" => ["新竹縣", "五峰鄉"],
        "嘉義縣東石鄉" => ["嘉義縣", "東石鄉"],
        "臺東縣臺東市(氣象站)" => ["臺東縣", "臺東市"],
        "基隆市七堵區(十河局)" => ["基隆市", "七堵區"],
        "高雄市田寮區" => ["高雄市", "田寮區"],
        "屏東縣恆春鎮(合作站)" => ["屏東縣", "恆春鎮"],
        "新北市坪林區" => ["新北市", "坪林區"],
        "臺南市龍崎區" => ["臺南市", "龍崎區"],
        "新北市坪林區(十河局)" => ["新北市", "坪林區"],
        "宜蘭縣頭城鎮(水保局)" => ["宜蘭縣", "頭城鎮"],
        "花蓮縣玉里鎮" => ["花蓮縣", "玉里鎮"],
        "臺南市新化區" => ["臺南市", "新化區"],
        "嘉義縣義竹鄉(合作站)" => ["嘉義縣", "義竹鄉"],
        "屏東縣長治鄉(合作站)" => ["屏東縣", "長治鄉"],
        "新北市石碇區(合作站)" => ["新北市", "石碇區"],
        "臺北市南港區(大地工程處)" => ["臺北市", "南港區"],
        "苗栗縣南庄鄉" => ["苗栗縣", "南庄鄉"],
        "臺東縣卑南鄉(第8河川局)" => ["臺東縣", "卑南鄉"],
        "屏東縣竹田鄉" => ["屏東縣", "竹田鄉"],
        "新北市雙溪區(水保局)" => ["新北市", "雙溪區"],
        "宜蘭縣蘇澳鎮" => ["宜蘭縣", "蘇澳鎮"],
        "臺東縣臺東市(第8河川局)" => ["臺東縣", "臺東市"],
        "新竹縣北埔鄉" => ["新竹縣", "北埔鄉"],
        "臺東縣東河鄉" => ["臺東縣", "東河鄉"],
        "屏東縣潮州鎮(第7河川局)" => ["屏東縣", "潮州鎮"],
        "花蓮縣卓溪鄉" => ["花蓮縣", "卓溪鄉"],
        "屏東縣佳冬鄉" => ["屏東縣", "佳冬鄉"],
        "屏東縣高樹鄉" => ["屏東縣", "高樹鄉"],
        "臺南市新化區(合作站)" => ["臺南市", "新化區"],
        "宜蘭縣蘇澳鎮(水保局)" => ["宜蘭縣", "蘇澳鎮"],
        "嘉義縣朴子市" => ["嘉義縣", "朴子市"],
        "屏東縣九如鄉" => ["屏東縣", "九如鄉"],
        "雲林縣水林鄉" => ["雲林縣", "水林鄉"],
        "新北市板橋區(氣象站)" => ["新北市", "板橋區"],
        "屏東縣瑪家鄉" => ["屏東縣", "瑪家鄉"],
        "臺南市善化區" => ["臺南市", "善化區"],
        "屏東縣三地門鄉" => ["屏東縣", "三地門鄉"],
        "臺中市太平區" => ["臺中市", "太平區"],
        "高雄市六龜區" => ["高雄市", "六龜區"],
        "新竹縣尖石鄉" => ["新竹縣", "尖石鄉"],
        "屏東縣瑪家鄉(第7河川局)" => ["屏東縣", "瑪家鄉"],
        "屏東縣枋寮鄉" => ["屏東縣", "枋寮鄉"],
        "嘉義縣鹿草鄉" => ["嘉義縣", "鹿草鄉"],
        "屏東縣泰武鄉(第7河川局)" => ["屏東縣", "泰武鄉"],
        "新竹縣五峰鄉(第2河川局)" => ["新竹縣", "五峰鄉"],
        "花蓮縣新城鄉(第9河川局)" => ["花蓮縣", "新城鄉"],
        "花蓮縣吉安鄉" => ["花蓮縣", "吉安鄉"],
        "新北市三峽區(十河局)" => ["新北市", "三峽區"],
        "花蓮縣光復鄉(第9河川局)" => ["花蓮縣", "光復鄉"],
        "屏東縣鹽埔鄉" => ["屏東縣", "鹽埔鄉"],
        "臺北市北投區(氣象站)" => ["臺北市", "北投區"],
        "苗栗縣通霄鎮(第2河川局)" => ["苗栗縣", "通霄鎮"],
        "屏東縣枋山鄉" => ["屏東縣", "枋山鄉"],
        "屏東縣來義鄉" => ["屏東縣", "來義鄉"],
        "新北市烏來區" => ["新北市", "烏來區"],
        "花蓮縣花蓮市(氣象站)" => ["花蓮縣", "花蓮市"],
        "屏東縣車城鄉" => ["屏東縣", "車城鄉"],
        "嘉義縣鹿草鄉(合作站)" => ["嘉義縣", "鹿草鄉"],
        "宜蘭縣大同鄉(水保局)" => ["宜蘭縣", "大同鄉"],
        "高雄市桃源區" => ["高雄市", "桃源區"],
        "花蓮縣光復鄉(水保局)" => ["花蓮縣", "光復鄉"],
        "苗栗縣獅潭鄉" => ["苗栗縣", "獅潭鄉"],
        "臺東縣卑南鄉(合作站)" => ["臺東縣", "卑南鄉"],
        "苗栗縣泰安鄉" => ["苗栗縣", "泰安鄉"],
        "花蓮縣新城鄉" => ["花蓮縣", "新城鄉"],
        "嘉義縣六腳鄉" => ["嘉義縣", "六腳鄉"],
        "新北市烏來區(十河局)" => ["新北市", "烏來區"],
        "屏東縣高樹鄉(第7河川局)" => ["屏東縣", "高樹鄉"],
        "花蓮縣壽豐鄉" => ["花蓮縣", "壽豐鄉"],
        "屏東縣里港鄉" => ["屏東縣", "里港鄉"],
        "屏東縣內埔鄉(第7河川局)" => ["屏東縣", "內埔鄉"],
        "嘉義縣太保市" => ["嘉義縣", "太保市"],
        "雲林縣四湖鄉" => ["雲林縣", "四湖鄉"],
        "宜蘭縣壯圍鄉" => ["宜蘭縣", "壯圍鄉"],
        "花蓮縣花蓮市(第9河川局)" => ["花蓮縣", "花蓮市"],
        "苗栗縣苑裡鎮(合作站)" => ["苗栗縣", "苑裡鎮"],
        "臺東縣鹿野鄉(合作站)" => ["臺東縣", "鹿野鄉"],
        "屏東縣萬巒鄉" => ["屏東縣", "萬巒鄉"],
        "苗栗縣三義鄉" => ["苗栗縣", "三義鄉"],
        "新北市新店區(十河局)" => ["新北市", "新店區"],
        "雲林縣北港鎮" => ["雲林縣", "北港鎮"],
        "雲林縣四湖鄉(合作站)" => ["雲林縣", "四湖鄉"],
        "雲林縣口湖鄉(合作站)" => ["雲林縣", "口湖鄉"],
        "新竹縣五峰鄉(合作站)" => ["新竹縣", "五峰鄉"],
        "屏東縣新埤鄉" => ["屏東縣", "新埤鄉"],
        "臺北市文山區(大地工程處)" => ["臺北市", "文山區"],
        "雲林縣麥寮鄉(合作站)" => ["雲林縣", "麥寮鄉"],
        "嘉義縣水上鄉" => ["嘉義縣", "水上鄉"],
        "臺南市後壁區" => ["臺南市", "後壁區"],
        "新北市新店區(翡翠水庫)" => ["新北市", "新店區"],
        "新北市土城區" => ["新北市", "土城區"],
        "雲林縣東勢鄉" => ["雲林縣", "東勢鄉"],
        "金門縣金城鎮(氣象站)" => ["金門縣", "金城鎮"],
        "桃園市復興區" => ["桃園市", "復興區"],
        "臺東縣臺東市" => ["臺東縣", "臺東市"],
        "臺南市新營區" => ["臺南市", "新營區"],
        "雲林縣臺西鄉" => ["雲林縣", "臺西鄉"],
        "新北市汐止區" => ["新北市", "汐止區"],
        "高雄市美濃區" => ["高雄市", "美濃區"],
        "花蓮縣壽豐鄉(水保局)" => ["花蓮縣", "壽豐鄉"],
        "屏東縣恆春鎮(氣象站)" => ["屏東縣", "恆春鎮"],
        "臺北市北投區" => ["臺北市", "北投區"],
        "新竹縣尖石鄉(石門水庫)" => ["新竹縣", "尖石鄉"],
        "高雄市旗山區(合作站)" => ["高雄市", "旗山區"],
        "雲林縣臺西鄉(合作站)" => ["雲林縣", "臺西鄉"],
        "苗栗縣銅鑼鄉(合作站)" => ["苗栗縣", "銅鑼鄉"],
        "宜蘭縣南澳鄉(第1河川局)" => ["宜蘭縣", "南澳鄉"],
        "宜蘭縣五結鄉(合作站)" => ["宜蘭縣", "五結鄉"],
        "花蓮縣光復鄉" => ["花蓮縣", "光復鄉"],
        "雲林縣褒忠鄉" => ["雲林縣", "褒忠鄉"],
        "苗栗縣獅潭鄉(第2河川局)" => ["苗栗縣", "獅潭鄉"],
        "臺東縣長濱鄉(第8河川局)" => ["臺東縣", "長濱鄉"],
        "苗栗縣三灣鄉" => ["苗栗縣", "三灣鄉"],
        "雲林縣北港鎮(第5河川局)" => ["雲林縣", "北港鎮"],
        "新竹縣尖石鄉(第2河川局)" => ["新竹縣", "尖石鄉"],
        "高雄市杉林區" => ["高雄市", "杉林區"],
        "雲林縣崙背鄉" => ["雲林縣", "崙背鄉"],
        "苗栗縣三義鄉(第2河川局)" => ["苗栗縣", "三義鄉"],
        "屏東縣來義鄉(第7河川局)" => ["屏東縣", "來義鄉"],
        "雲林縣元長鄉" => ["雲林縣", "元長鄉"],
        "臺東縣成功鎮" => ["臺東縣", "成功鎮"],
        "臺東縣延平鄉(第8河川局)" => ["臺東縣", "延平鄉"],
        "苗栗縣銅鑼鄉" => ["苗栗縣", "銅鑼鄉"],
        "屏東縣來義鄉(水保局)" => ["屏東縣", "來義鄉"],
        "苗栗縣三義鄉(合作站)" => ["苗栗縣", "三義鄉"],
        "臺中市梧棲區(氣象站)" => ["臺中市", "梧棲區"],
        "臺東縣成功鎮(氣象站)" => ["臺東縣", "成功鎮"],
        "臺北市北投區(水利處)" => ["臺北市", "北投區"],
        "臺南市山上區" => ["臺南市", "山上區"],
        "新北市三峽區(水保局)" => ["新北市", "三峽區"],
        "臺南市官田區" => ["臺南市", "官田區"],
        "嘉義縣新港鄉" => ["嘉義縣", "新港鄉"],
        "連江縣東引鄉" => ["連江縣", "東引鄉"],
        "彰化縣芳苑鄉" => ["彰化縣", "芳苑鄉"],
        "臺中市外埔區" => ["臺中市", "外埔區"],
        "彰化縣大城鄉" => ["彰化縣", "大城鄉"],
        "臺中市新社區" => ["臺中市", "新社區"],
        "臺中市霧峰區" => ["臺中市", "霧峰區"],
        "桃園市龍潭區(石門水庫)" => ["桃園市", "龍潭區"],
        "苗栗縣大湖鄉" => ["苗栗縣", "大湖鄉"],
        "臺南市大內區" => ["臺南市", "大內區"],
        "臺中市東勢區" => ["臺中市", "東勢區"],
        "新北市石碇區(十河局)" => ["新北市", "石碇區"],
        "桃園市復興區(石門水庫)" => ["桃園市", "復興區"],
        "花蓮縣秀林鄉(水保局)" => ["花蓮縣", "秀林鄉"],
        "雲林縣斗南鎮(合作站)" => ["雲林縣", "斗南鎮"],
        "苗栗縣造橋鄉" => ["苗栗縣", "造橋鄉"],
        "苗栗縣苗栗市" => ["苗栗縣", "苗栗市"],
        "苗栗縣苑裡鎮" => ["苗栗縣", "苑裡鎮"],
        "雲林縣古坑鄉(第4河川局)" => ["雲林縣", "古坑鄉"],
        "南投縣信義鄉(第4河川局)" => ["南投縣", "信義鄉"],
        "彰化縣福興鄉" => ["彰化縣", "福興鄉"],
        "臺北市陽明山(十河局)" => ["臺北市", "陽明山"],
        "苗栗縣三義鄉(水保局)" => ["苗栗縣", "三義鄉"],
        "雲林縣古坑鄉(第5河川局)" => ["雲林縣", "古坑鄉"],
        "彰化縣埔鹽鄉" => ["彰化縣", "埔鹽鄉"],
        "花蓮縣鳳林鎮(水保局)" => ["花蓮縣", "鳳林鎮"],
        "雲林縣虎尾鎮" => ["雲林縣", "虎尾鎮"],
        "苗栗縣大湖鄉(第2河川局)" => ["苗栗縣", "大湖鄉"],
        "雲林縣古坑鄉(水保局)" => ["雲林縣", "古坑鄉"],
        "彰化縣鹿港鎮(第4河川局)" => ["彰化縣", "鹿港鎮"],
        "臺中市太平區(第3河川局)" => ["臺中市", "太平區"],
        "花蓮縣豐濱鄉(水保局)" => ["花蓮縣", "豐濱鄉"],
        "臺中市大甲區" => ["臺中市", "大甲區"],
        "苗栗縣三灣鄉(第2河川局)" => ["苗栗縣", "三灣鄉"],
        "苗栗縣後龍鎮(第2河川局)" => ["苗栗縣", "後龍鎮"],
        "宜蘭縣南澳鄉(水保局)" => ["宜蘭縣", "南澳鄉"],
        "彰化縣二林鎮(第4河川局)" => ["彰化縣", "二林鎮"],
        "高雄市旗山區" => ["高雄市", "旗山區"],
        "臺中市清水區" => ["臺中市", "清水區"],
        "臺中市大安區" => ["臺中市", "大安區"],
        "新北市深坑區" => ["新北市", "深坑區"],
        "彰化縣埔心鄉" => ["彰化縣", "埔心鄉"],
        "高雄市旗山區(第7河川局)" => ["高雄市", "旗山區"],
        "臺中市太平區(水保局)" => ["臺中市", "太平區"],
        "新北市汐止區(十河局)" => ["新北市", "汐止區"],
        "苗栗縣南庄鄉(第2河川局)" => ["苗栗縣", "南庄鄉"],
        "高雄世茂林區" => ["高雄市", "茂林區"],
        "苗栗縣通霄鎮" => ["苗栗縣", "通霄鎮"],
        "新竹縣峨眉鄉" => ["新竹縣", "峨眉鄉"],
        "雲林縣二崙鄉" => ["雲林縣", "二崙鄉"],
        "雲林縣大埤鄉" => ["雲林縣", "大埤鄉"],
        "屏東縣三地門鄉(第7河川局)" => ["屏東縣", "三地門鄉"],
        "嘉義縣溪口鄉" => ["嘉義縣", "溪口鄉"],
        "臺南市東山區(第5河川局)" => ["臺南市", "東山區"],
        "臺南市白河區" => ["臺南市", "白河區"],
        "彰化縣二林鎮" => ["彰化縣", "二林鎮"],
        "雲林縣二崙鄉(合作站)" => ["雲林縣", "二崙鄉"],
        "臺南市後壁區(合作站)" => ["臺南市", "後壁區"],
        "嘉義縣大林鎮(合作站)" => ["嘉義縣", "大林鎮"],
        "雲林縣西螺鎮" => ["雲林縣", "西螺鎮"],
        "臺北市南港區" => ["臺北市", "南港區"],
        "雲林縣土庫鎮" => ["雲林縣", "土庫鎮"],
        "雲林縣莿桐鄉" => ["雲林縣", "莿桐鄉"],
        "新北市中和區" => ["新北市", "中和區"],
        "新北市石碇區" => ["新北市", "石碇區"],
        "雲林縣虎尾鎮(合作站)" => ["雲林縣", "虎尾鎮"],
        "嘉義縣梅山鄉" => ["嘉義縣", "梅山鄉"],
        "宜蘭縣礁溪鄉" => ["宜蘭縣", "礁溪鄉"],
        "屏東縣車城鄉(合作站)" => ["屏東縣", "車城鄉"],
        "彰化縣鹿港鎮" => ["彰化縣", "鹿港鎮"],
        "苗栗縣頭屋鄉(合作站)" => ["苗栗縣", "頭屋鄉"],
        "臺北市南港區(水利處)" => ["臺北市", "南港區"],
        "臺東縣關山鎮(第8河川局)" => ["臺東縣", "關山鎮"],
        "花蓮縣鳳林鎮" => ["花蓮縣", "鳳林鎮"],
        "苗栗縣頭屋鄉" => ["苗栗縣", "頭屋鄉"],
        "雲林縣古坑鄉" => ["雲林縣", "古坑鄉"],
        "雲林縣褒忠鄉(第5河川局)" => ["雲林縣", "褒忠鄉"],
        "彰化縣和美鎮(合作站)" => ["彰化縣", "和美鎮"],
        "苗栗縣公館鄉(合作站)" => ["苗栗縣", "公館鄉"],
        "臺南市白河區(第5河川局)" => ["臺南市", "白河區"],
        "雲林縣斗南鎮" => ["雲林縣", "斗南鎮"],
        "彰化縣溪湖鎮" => ["彰化縣", "溪湖鎮"],
        "臺中市大肚區" => ["臺中市", "大肚區"],
        "臺中市霧峰區(合作站)" => ["臺中市", "霧峰區"],
        "臺東縣綠島鄉" => ["臺東縣", "綠島鄉"],
        "臺中市清水區(合作站)" => ["臺中市", "清水區"],
        "花蓮縣卓溪鄉(第9河川局)" => ["花蓮縣", "卓溪鄉"],
        "花蓮縣吉安鄉(合作站)" => ["花蓮縣", "吉安鄉"],
        "彰化縣溪州鄉" => ["彰化縣", "溪州鄉"],
        "彰化縣埤頭鄉" => ["彰化縣", "埤頭鄉"],
        "彰化縣線西鄉" => ["彰化縣", "線西鄉"],
        "臺中市烏日區" => ["臺中市", "烏日區"],
        "臺中市大里區" => ["臺中市", "大里區"],
        "臺南市柳營區" => ["臺南市", "柳營區"],
        "彰化縣社頭鄉" => ["彰化縣", "社頭鄉"],
        "彰化縣田尾鄉" => ["彰化縣", "田尾鄉"],
        "苗栗縣西湖鄉" => ["苗栗縣", "西湖鄉"],
        "彰化縣秀水鄉" => ["彰化縣", "秀水鄉"],
        "彰化縣北斗鎮" => ["彰化縣", "北斗鎮"],
        "臺中市西屯區" => ["臺中市", "西屯區"],
        "臺中市南屯區" => ["臺中市", "南屯區"],
        "臺北市文山區(水利處)" => ["臺北市", "文山區"],
        "嘉義縣阿里山鄉(水保局)" => ["嘉義縣", "阿里山鄉"],
        "臺南市東山區(水保局)" => ["臺南市", "東山區"],
        "屏東縣瑪家鄉(水保局)" => ["屏東縣", "瑪家鄉"],
        "新北市新店區(水保局)" => ["新北市", "新店區"],
        "臺北市萬華區(水利處)" => ["臺北市", "萬華區"],
        "新竹縣五峰鄉(水保局)" => ["新竹縣", "五峰鄉"],
        "高雄市杉林區(水保局)" => ["高雄市", "杉林區"],
        "臺北市信義區(大地工程處)" => ["臺北市", "信義區"],
        "南投縣國姓鄉" => ["南投縣", "國姓鄉"],
        "嘉義縣竹崎鄉" => ["嘉義縣", "竹崎鄉"],
        "臺中市龍井區" => ["臺中市", "龍井區"],
        "臺中市潭子區" => ["臺中市", "潭子區"],
        "臺中市豐原區" => ["臺中市", "豐原區"],
        "嘉義縣大林鎮" => ["嘉義縣", "大林鎮"],
        "臺中市霧峰區(水保局)" => ["臺中市", "霧峰區"],
        "南投縣魚池鄉(水保局)" => ["南投縣", "魚池鄉"],
        "臺南市左鎮區" => ["臺南市", "左鎮區"],
        "苗栗縣公館鄉" => ["苗栗縣", "公館鄉"],
        "高雄市那瑪夏區" => ["高雄市", "那瑪夏區"],
        "南投縣南投市" => ["南投縣", "南投市"],
        "南投縣草屯鎮" => ["南投縣", "草屯鎮"],
        "彰化縣芬園鄉" => ["彰化縣", "芬園鄉"],
        "臺中市北屯區" => ["臺中市", "北屯區"],
        "高雄市內門區" => ["高雄市", "內門區"],
        "臺南市楠西區" => ["臺南市", "楠西區"],
        "彰化縣田中鎮" => ["彰化縣", "田中鎮"],
        "臺南市南化區" => ["臺南市", "南化區"],
        "嘉義縣大埔鄉" => ["嘉義縣", "大埔鄉"],
        "桃園市大溪區" => ["桃園市", "大溪區"],
        "花蓮縣瑞穗鄉" => ["花蓮縣", "瑞穗鄉"],
        "臺南市東山區" => ["臺南市", "東山區"],
        "宜蘭縣冬山鄉" => ["宜蘭縣", "冬山鄉"],
        "宜蘭縣羅東鎮" => ["宜蘭縣", "羅東鎮"],
        "臺東縣延平鄉" => ["臺東縣", "延平鄉"],
        "金門縣金寧鄉" => ["金門縣", "金寧鄉"],
        "臺中市大雅區" => ["臺中市", "大雅區"],
        "南投縣仁愛鄉" => ["南投縣", "仁愛鄉"],
        "彰化縣員林市" => ["彰化縣", "員林市"],
        "苗栗縣後龍鎮" => ["苗栗縣", "後龍鎮"],
        "苗栗縣竹南鎮" => ["苗栗縣", "竹南鎮"],
        "宜蘭縣三星鄉(合作站)" => ["宜蘭縣", "三星鄉"],
        "桃園市楊梅區(合作站)" => ["桃園市", "楊梅區"],
        "金門縣烈嶼鄉(合作站)" => ["金門縣", "烈嶼鄉"],
        "臺中市新社區(合作站)" => ["臺中市", "新社區"],
        "嘉義縣溪口鄉(合作站)" => ["嘉義縣", "溪口鄉"],
        "彰化縣彰化市(合作站)" => ["彰化縣", "彰化市"],
        "臺中市西屯區(合作站)" => ["臺中市", "西屯區"],
        "新北市樹林區(合作站)" => ["新北市", "樹林區"],
        "桃園市新屋區(氣象站)" => ["桃園市", "新屋區"],
        "連江縣南竿鄉(氣象站)" => ["連江縣", "南竿鄉"],
        "嘉義市西區(氣象站)" => ["嘉義市", "西區"],
        "南投縣信義鄉(氣象站)" => ["南投縣", "信義鄉"],
        "臺中市北區(氣象站)" => ["臺中市", "北區"],
        "臺東縣蘭嶼鄉(氣象站)" => ["臺東縣", "蘭嶼鄉"],
        "臺中市和平區(合作站)" => ["臺中市", "和平區"],
        "彰化縣田中鎮(氣象站)" => ["彰化縣", "田中鎮"],
        "花蓮縣秀林鄉(合作站)" => ["花蓮縣", "秀林鄉"],
        "雲林縣西螺鎮(合作站)" => ["雲林縣", "西螺鎮"],
        "臺中市神岡區(合作站)" => ["臺中市", "神岡區"],
        "新北市樹林區" => ["新北市", "樹林區"],
        "新北市新店區" => ["新北市", "新店區"],
        "桃園市楊梅區" => ["桃園市", "楊梅區"],
        "桃園市八德區" => ["桃園市", "八德區"],
        "新竹縣關西鎮" => ["新竹縣", "關西鎮"],
        "新竹縣新埔鎮" => ["新竹縣", "新埔鎮"],
        "南投縣草屯鎮(合作站)" => ["南投縣", "草屯鎮"],
        "彰化縣大村鄉(合作站)" => ["彰化縣", "大村鄉"],
        "臺中市大肚區(合作站)" => ["臺中市", "大肚區"],
        "苗栗縣通霄鎮(合作站)" => ["苗栗縣", "通霄鎮"],
        "臺中市沙鹿區(合作站)" => ["臺中市", "沙鹿區"],
        "臺東縣鹿野鄉" => ["臺東縣", "鹿野鄉"],
        "桃園市龍潭區" => ["桃園市", "龍潭區"],
        "新竹市東區" => ["新竹市", "東區"],
        "新竹市香山區" => ["新竹市", "香山區"],
        "南投縣中寮鄉" => ["南投縣", "中寮鄉"],
        "新竹縣新豐鄉" => ["新竹縣", "新豐鄉"],
        "新竹縣寶山鄉" => ["新竹縣", "寶山鄉"],
        "新北市三峽區" => ["新北市", "三峽區"],
        "嘉義縣番路鄉" => ["嘉義縣", "番路鄉"],
        "臺中市神岡區" => ["臺中市", "神岡區"],
        "南投縣名間鄉" => ["南投縣", "名間鄉"],
        "新竹縣寶山鄉(合作站)" => ["新竹縣", "寶山鄉"],
        "臺中市后里區" => ["臺中市", "后里區"],
        "苗栗縣頭份市(合作站)" => ["苗栗縣", "頭份市"],
        "花蓮縣富里鄉(第9河川局)" => ["花蓮縣", "富里鄉"],
        "臺中市后里區(合作站)" => ["臺中市", "后里區"],
        "苗栗縣竹南鎮(合作站)" => ["苗栗縣", "竹南鎮"],
        "新竹縣橫山鄉" => ["新竹縣", "橫山鄉"],
        "新竹縣竹東鎮" => ["新竹縣", "竹東鎮"],
        "新竹縣寶山鄉(第2河川局)" => ["新竹縣", "寶山鄉"],
        "南投縣仁愛鄉(合作站)" => ["南投縣", "仁愛鄉"],
        "高雄市桃源區(第7河川局)" => ["高雄市", "桃源區"],
        "新竹市香山區(第2河川局)" => ["新竹市", "香山區"],
        "新竹市北區(第2河川局)" => ["新竹市", "北區"],
        "臺南市南化區(第6河川局)" => ["臺南市", "南化區"],
        "南投縣信義鄉(合作站)" => ["南投縣", "信義鄉"],
        "桃園市平鎮區" => ["桃園市", "平鎮區"],
        "高雄市六龜區(合作站)" => ["高雄市", "六龜區"],
        "高雄市茂林區(合作站)" => ["高雄市", "茂林區"],
        "宜蘭縣冬山鄉(第1河川局)" => ["宜蘭縣", "冬山鄉"],
        "桃園市蘆竹區" => ["桃園市", "蘆竹區"],
        "桃園市中壢區" => ["桃園市", "中壢區"],
        "桃園市八德區(合作站)" => ["桃園市", "八德區"],
        "宜蘭縣礁溪鄉(第1河川局)" => ["宜蘭縣", "礁溪鄉"],
        "臺東縣東河鄉(第8河川局)" => ["臺東縣", "東河鄉"],
        "桃園市觀音區" => ["桃園市", "觀音區"],
        "嘉義縣溪口鄉(第5河川局)" => ["嘉義縣", "溪口鄉"],
        "嘉義縣大林鎮(第5河川局)" => ["嘉義縣", "大林鎮"],
        "臺南市六甲區(第6河川局)" => ["臺南市", "六甲區"],
        "南投縣信義鄉" => ["南投縣", "信義鄉"],
        "嘉義縣竹崎鄉(第5河川局)" => ["嘉義縣", "竹崎鄉"],
        "雲林縣西螺鎮(第4河川局)" => ["雲林縣", "西螺鎮"],
        "南投縣仁愛鄉(第3河川局)" => ["南投縣", "仁愛鄉"],
        "雲林縣林內鄉(第5河川局)" => ["雲林縣", "林內鄉"],
        "嘉義縣番路鄉(第5河川局)" => ["嘉義縣", "番路鄉"],
        "新竹縣湖口鄉" => ["新竹縣", "湖口鄉"],
        "高雄市甲仙區(第7河川局)" => ["高雄市", "甲仙區"],
        "新北市八里區(合作站)" => ["新北市", "八里區"],
        "雲林縣林內鄉(合作站)" => ["雲林縣", "林內鄉"],
        "新北市新莊區" => ["新北市", "新莊區"],
        "桃園市大園區" => ["桃園市", "大園區"],
        "桃園市桃園區" => ["桃園市", "桃園區"],
        "新北市林口區" => ["新北市", "林口區"],
        "臺北市文山區" => ["臺北市", "文山區"],
        "新北市三重區" => ["新北市", "三重區"],
        "花蓮縣瑞穗鄉(第9河川局)" => ["花蓮縣", "瑞穗鄉"],
        "南投縣魚池鄉(合作站)" => ["南投縣", "魚池鄉"],
        "臺中市和平區(水保局)" => ["臺中市", "和平區"],
        "新北市新店區(檢校中心)" => ["新北市", "新店區"],
        "臺北市中正區(氣象站)" => ["臺北市", "中正區"],
        "嘉義縣中埔鄉(水保局)" => ["嘉義縣", "中埔鄉"],
        "南投縣草屯鎮(水保局)" => ["南投縣", "草屯鎮"],
        "南投縣國姓鄉(水保局)" => ["南投縣", "國姓鄉"],
        "南投縣水里鄉(水保局)" => ["南投縣", "水里鄉"],
        "新北市鶯歌區" => ["新北市", "鶯歌區"],
        "苗栗縣銅鑼鄉(水保局)" => ["苗栗縣", "銅鑼鄉"],
        "苗栗縣公館鄉(水保局)" => ["苗栗縣", "公館鄉"],
        "桃園市大溪區(水保局)" => ["桃園市", "大溪區"],
        "新北市八里區" => ["新北市", "八里區"],
        "桃園市復興區(水保局)" => ["桃園市", "復興區"],
        "新竹縣關西鎮(水保局)" => ["新竹縣", "關西鎮"],
        "新北市蘆洲區" => ["新北市", "蘆洲區"],
        "新竹縣橫山鄉(水保局)" => ["新竹縣", "橫山鄉"],
        "新竹縣尖石鄉(水保局)" => ["新竹縣", "尖石鄉"],
        "南投縣竹山鎮(水保局)" => ["南投縣", "竹山鎮"],
        "苗栗縣卓蘭鎮" => ["苗栗縣", "卓蘭鎮"],
        "南投縣魚池鄉(氣象站)" => ["南投縣", "魚池鄉"],
        "嘉義縣阿里山鄉(氣象站)" => ["嘉義縣", "阿里山鄉"],
        "花蓮縣富里鄉(水保局)" => ["花蓮縣", "富里鄉"],
        "新竹縣竹北市(氣象站)" => ["新竹縣", "竹北市"],
        "高雄市六龜區(水保局)" => ["高雄市", "六龜區"],
        "新北市淡水區(氣象站)" => ["新北市", "淡水區"],
        "花蓮縣玉里鎮(水保局)" => ["花蓮縣", "玉里鎮"],
        "花蓮縣瑞穗鄉(水保局)" => ["花蓮縣", "瑞穗鄉"],
        "高雄市那瑪夏區(水保局)" => ["高雄市", "那瑪夏區"],
        "嘉義縣梅山鄉(水保局)" => ["嘉義縣", "梅山鄉"],
        "南投縣信義鄉(水保局)" => ["南投縣", "信義鄉"],
        "桃園市復興區(合作站)" => ["桃園市", "復興區"],
        "金門縣金湖鎮(合作站)" => ["金門縣", "金湖鎮"],
        "新竹縣芎林鄉" => ["新竹縣", "芎林鄉"],
        "彰化縣花壇鄉" => ["彰化縣", "花壇鄉"],
        "宜蘭縣宜蘭市(氣象站)" => ["宜蘭縣", "宜蘭市"],
        "宜蘭縣五結鄉" => ["宜蘭縣", "五結鄉"],
        "新北市烏來區(水保局)" => ["新北市", "烏來區"],
        "苗栗縣頭份市" => ["苗栗縣", "頭份市"],
        "苗栗縣卓蘭鎮(水保局)" => ["苗栗縣", "卓蘭鎮"],
        "高雄市六龜區(第7河川局)" => ["高雄市", "六龜區"],
        "南投縣鹿谷鄉(合作站)" => ["南投縣", "鹿谷鄉"],
        "苗栗縣大湖鄉(合作站)" => ["苗栗縣", "大湖鄉"],
        "南投縣信義鄉(第7河川局)" => ["南投縣", "信義鄉"],
        "嘉義縣阿里山鄉(第4河川局)" => ["嘉義縣", "阿里山鄉"],
        "高雄市那瑪夏區(第7河川局)" => ["高雄市", "那瑪夏區"],
        "高雄市茂林區(第7河川局)" => ["高雄市", "茂林區"],
        "高雄市內門區(第7河川局)" => ["高雄市", "內門區"],
        "南投縣竹山鎮(合作站)" => ["南投縣", "竹山鎮"],
        "嘉義市東區(合作站)" => ["嘉義市", "東區"],
        "彰化縣伸港鄉" => ["彰化縣", "伸港鄉"],
        "彰化縣二水鄉" => ["彰化縣", "二水鄉"],
        "桃園市中壢區(合作站)" => ["桃園市", "中壢區"],
        "高雄市桃源區(水保局)" => ["高雄市", "桃源區"],
        "臺北市士林區(合作站)" => ["臺北市", "士林區"],
        "雲林縣古坑鄉(合作站)" => ["雲林縣", "古坑鄉"],
        "桃園市龜山區" => ["桃園市", "龜山區"],
        "高雄市旗津區(合作站)" => ["高雄市", "旗津區"],
        "新北市八里區(水保局)" => ["新北市", "八里區"],
        "臺東縣成功鎮(水保局)" => ["臺東縣", "成功鎮"],
        "臺東縣鹿野鄉(水保局)" => ["臺東縣", "鹿野鄉"],
        "臺北市大安區(合作站)" => ["臺北市", "大安區"],
        "臺南市南化區(水保局)" => ["臺南市", "南化區"],
        "雲林縣林內鄉(水保局)" => ["雲林縣", "林內鄉"],
        "桃園市新屋區(合作站)" => ["桃園市", "新屋區"],
        "南投縣仁愛鄉(水保局)" => ["南投縣", "仁愛鄉"],
        "臺北市大安區(臺灣大學)" => ["臺北市", "大安區"],
        "南投縣國姓鄉(第3河川局)" => ["南投縣", "國姓鄉"],
        "南投縣草屯鎮(第3河川局)" => ["南投縣", "草屯鎮"],
        "臺東縣長濱鄉" => ["臺東縣", "長濱鄉"],
        "臺東縣關山鎮" => ["臺東縣", "關山鎮"],
        "嘉義縣阿里山鄉" => ["嘉義縣", "阿里山鄉"],
        "連江縣莒光鄉" => ["連江縣", "莒光鄉"],
        "南投縣竹山鎮" => ["南投縣", "竹山鎮"],
        "臺北市士林區" => ["臺北市", "士林區"],
        "臺北市士林區(水利處)" => ["臺北市", "士林區"],
        "臺北市信義區(水利處)" => ["臺北市", "信義區"],
        "臺北市內湖區(水利處)" => ["臺北市", "內湖區"],
        "臺北市內湖區" => ["臺北市", "內湖區"],
        "臺北市中正區(水利處)" => ["臺北市", "中正區"],
        "臺北市松山區(水利處)" => ["臺北市", "松山區"],
        "臺北市大同區(水利處)" => ["臺北市", "大同區"],
        "新北市永和區" => ["新北市", "永和區"],
        "南投縣鹿谷鄉" => ["南投縣", "鹿谷鄉"],
        "臺北市大安區(大地工程處)" => ["臺北市", "大安區"],
        "嘉義縣中埔鄉" => ["嘉義縣", "中埔鄉"],
        "高雄市茂林區" => ["高雄市", "茂林區"],
        "宜蘭縣員山鄉" => ["宜蘭縣", "員山鄉"],
        "南投縣魚池鄉" => ["南投縣", "魚池鄉"],
        "南投縣水里鄉" => ["南投縣", "水里鄉"],
        "南投縣集集鎮" => ["南投縣", "集集鎮"],
        "嘉義市東區" => ["嘉義市", "東區"],
        "嘉義縣民雄鄉" => ["嘉義縣", "民雄鄉"],
        "金門縣金沙鎮" => ["金門縣", "金沙鎮"],
        "臺北市松山區" => ["臺北市", "松山區"],
        "宜蘭縣三星鄉" => ["宜蘭縣", "三星鄉"],
        "臺東縣池上鄉" => ["臺東縣", "池上鄉"],
        "雲林縣斗六市" => ["雲林縣", "斗六市"],
        "雲林縣林內鄉" => ["雲林縣", "林內鄉"],
        "臺北市信義區" => ["臺北市", "信義區"],
        "新北市五股區" => ["新北市", "五股區"],
        "臺東縣鹿野鄉(第8河川局)" => ["臺東縣", "鹿野鄉"],
        "南投縣埔里鎮" => ["南投縣", "埔里鎮"],
        "苗栗縣泰安鄉(第2河川局)" => ["苗栗縣", "泰安鄉"],
        "新竹縣新埔鎮(第2河川局)" => ["新竹縣", "新埔鎮"],
        "新竹縣關西鎮(第2河川局)" => ["新竹縣", "關西鎮"],
        "臺南市六甲區" => ["臺南市", "六甲區"],
        "南投縣集集鎮(第4河川局)" => ["南投縣", "集集鎮"],
        "南投縣水里鄉(第4河川局)" => ["南投縣", "水里鄉"],
        "臺中市和平區(第3河川局)" => ["臺中市", "和平區"],
        "苗栗縣泰安鄉(第3河川局)" => ["苗栗縣", "泰安鄉"],
        "南投縣竹山鎮(第4河川局)" => ["南投縣", "竹山鎮"],
        "南投縣仁愛鄉(第4河川局)" => ["南投縣", "仁愛鄉"],
        "南投縣南投市(第3河川局)" => ["南投縣", "南投市"],
        "苗栗縣造橋鄉(第2河川局)" => ["苗栗縣", "造橋鄉"],
        "臺中市東勢區(第3河川局)" => ["臺中市", "東勢區"],
        "苗栗縣竹南鎮(第2河川局)" => ["苗栗縣", "竹南鎮"],
        "苗栗縣頭份鎮(第2河川局)" => ["苗栗縣", "頭份鎮"],
        "臺中市石岡區" => ["臺中市", "石岡區"],
        "臺北市中山區(大地工程處)" => ["臺北市", "中山區"],
        "臺北市內湖區(大地工程處)" => ["臺北市", "內湖區"],
        "臺北市中山區(水利處)" => ["臺北市", "中山區"],
        "桃園市龍潭區(十河局)" => ["桃園市", "龍潭區"],
        "桃園市龜山區(十河局)" => ["桃園市", "龜山區"],
        "高雄市甲仙區" => ["高雄市", "甲仙區"],
        "臺南市玉井區" => ["臺南市", "玉井區"],
        "新北市林口區(十河局)" => ["新北市", "林口區"],
        "臺北市水源路(十河局)" => ["臺北市", "水源路"],
        "南投縣南投市(水保局)" => ["南投縣", "南投市"]
    ];

    private $countyToTaiwan = [
        '臺北市' => 'n',
        '新北市' => 'n',
        '基隆市' => 'n',
        '桃園市' => 'n',
        '新竹市' => 'n',
        '新竹縣' => 'n',
        '宜蘭縣' => 'y',
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
        '花蓮縣' => 'h',
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
        $data = [
            'today' => $this->format(storage_path('data/rainfall/obs/today/rainfallObs.txt')),
            'before1nd' => $this->format(storage_path('data/rainfall/obs/before1nd/rainfallObs.txt')),
            'before2nd' => $this->format(storage_path('data/rainfall/obs/before2nd/rainfallObs.txt')),
            'before3nd' => $this->format(storage_path('data/rainfall/obs/before3nd/rainfallObs.txt')),
            'before4nd' => $this->format(storage_path('data/rainfall/obs/before4nd/rainfallObs.txt')),
        ];

        return response()->json($data);
    }

    private function format(string $path): array
    {
        $rainfallObs = fopen($path, 'r');

        $data = ['top' => [], 'location' => ['n' => [], 'm' => [], 's' => [], 'y' => [], 'h' => [], 'e' => []], 'image' => url('test/rainfall.gif')];

        if (!feof($rainfallObs))
            fgets($rainfallObs);

        if (!feof($rainfallObs)) {
            $str = $this->txtDecode(fgets($rainfallObs));
            if (!empty($str)) {
                $strArr = explode(" ", $str);
                $data['startTime'] = Carbon::create($strArr[0] . ' ' . $strArr[1])->toDateTimeLocalString() . '+08:00';
                $data['endTime'] = Carbon::create($strArr[3] . ' ' . $strArr[4])->toDateTimeLocalString() . '+08:00';
            }
        }

        $count = 0;

        while (!feof($rainfallObs)) {
            $str = $this->txtDecode(fgets($rainfallObs));
            if (empty($str))
                continue;
            $strArr = explode(" ", $str);
            $area = $this->siteToArea[$strArr[2]];
            if (array_key_exists($area[0], $data['location'][$this->countyToTaiwan[$area[0]]])) {
                continue;
            }
            $data['location'][$this->countyToTaiwan[$area[0]]][$area[0]] = [
                'value' => (float)$strArr[0]
            ];

            if ($count < 5) {
                $data['top'][] = [
                    'county' => $area[0],
                    'area' => $area[1],
                    'value' => (float)$strArr[0]
                ];
            }

            $count++;
        }

        fclose($rainfallObs);

        return $data;
    }

    private function txtDecode(string $line): string
    {
        return trim(preg_replace("/\s(?=\s)/", "\\1",
            mb_convert_encoding($line, "UTF-8", "BIG5")));
    }
}
