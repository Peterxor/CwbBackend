var csrfToken = $('meta[name="csrf-token"]').attr('content');
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': csrfToken
    }
});

//email格式驗證
function validateEmail(email) {
    var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(String(email).toLowerCase());
}

function validatePhone(value) {
    var re = /^0\d{1,2}-?(\d{6,8})(#\d{1,5}){0,1}$/;
    return re.test(value);
}
function validateMobile(value) {
    var re = /^09\d{2}-?(\d{3})-?(\d{3})$/;
    return re.test(value);
}



if($('.js-p-num-only').length>0){

    // 偵測只允許數字與.的輸入
    $('.js-p-num-only').on('keypress', function(event){
        return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13) ? null : (event.charCode >= 48 && event.charCode <= 57)|| event.charCode==46
    });
    // 偵測只能輸入到小數點下二位
    var timeout = null;
    $('.js-p-num-only').on('keyup', function(){
        var _this = $(this);
        clearTimeout(timeout);
        timeout = setTimeout(function () {
            if(isNaN(_this.val())){
                _this.val('');
            }else{
                _this.val(+parseFloat( ( new Number(_this.val()) ).toFixed(2) ));
            }
        }, 250);
    });
}


var datatable_lang_tw = {
	"processing":   "處理中...",
	"loadingRecords": "載入中...",
	"lengthMenu":   "顯示 _MENU_ 項結果",
	"zeroRecords":  "沒有符合的結果",
	"info":         "顯示第 _START_ 至 _END_ 項結果，共 _TOTAL_ 項",
	"infoEmpty":    "顯示第 0 至 0 項結果，共 0 項",
	"infoFiltered": "(從 _MAX_ 項結果中過濾)",
	"infoPostFix":  "",
	"search":       "搜尋:",
	"paginate": {
		"first":    "第一頁",
		"previous": "上一頁",
		"next":     "下一頁",
		"last":     "最後一頁"
	},
	"aria": {
		"sortAscending":  ": 升冪排列",
		"sortDescending": ": 降冪排列"
	},
    "sEmptyTable": "無資料"
}
