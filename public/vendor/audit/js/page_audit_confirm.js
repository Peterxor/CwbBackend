$(document).ready(function () {
    var employeeId = $("#employee_id");

    employeeId.on("keypress",function(e){
        if(e.keyCode == 13) {
            $("#login-btn").click();
        }
    });

    $("#login-btn").on("click", function () {
        if (employeeId.val() == "") {
            alert("請輸入代號！");
        } else {
            location.replace("/page_audit/confirm?id=" + employeeId.val());
        }
    });

    function gup(name, url) {
        if (!url) url = location.href;
        name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
        var regexS = "[\\?&]" + name + "=([^&#]*)";
        var regex = new RegExp(regexS);
        var results = regex.exec(url);
        return results == null ? "" : results[1];
    }

    var id = gup("id", window.location);
    var msg = decodeURI(gup("msg", window.location));

    if (msg != "") {
        alert(msg);
    }

    var datatable_lang_tw = {
        processing: "處理中...",
        loadingRecords: "載入中...",
        lengthMenu: "顯示 _MENU_ 項結果",
        zeroRecords: "沒有符合的結果",
        info: "顯示第 _START_ 至 _END_ 項結果，共 _TOTAL_ 項",
        infoEmpty: "顯示第 0 至 0 項結果，共 0 項",
        infoFiltered: "(從 _MAX_ 項結果中過濾)",
        infoPostFix: "",
        search: "搜尋:",
        paginate: {
            first: "第一頁",
            previous: "上一頁",
            next: "下一頁",
            last: "最後一頁",
        },
        aria: {
            sortAscending: ": 升冪排列",
            sortDescending: ": 降冪排列",
        },
        sEmptyTable: "無資料",
    };

    $("#main-form").find('input[name="main"]').val(id);
    $("#agent-form").find('input[name="agent"]').val(id);
    //負責審核服務
    var mainRecordTable = $("#main-record-table");
    var mainTableUrl = mainRecordTable.attr("action");
    var searchForm = $("#search-form");
    var searchFromBtn = $("#search-btn");
    var _mainRecordTable;
    var dataTableSettings = {
        stateSave: false,
        processing: true,
        serverSide: true,
        searching: false,
        destroy: true,
        autoWidth: true,
        ordering: false,
        paging: false,
        bInfo: false,
        lengthChange: false,
        language: datatable_lang_tw,
        ajax: {
            url: mainTableUrl,
            type: "GET",
            data: function (aoData) {
                //把分頁的參數與自訂的搜尋結合
                $.each(searchForm.serializeArray(), function (key, value) {
                    aoData[value.name] = value.value;
                });
                aoData["employee_id"] = id;
                return aoData;
            },
            // success:function(data){
            //     console.log(data);
            // },
            // error:function(e){
            //     console.log('error',e);
            // },
            dataSrc: "data",
        },
        columns: [
            {
                data: null,
                defaultContent: "",
                mRender: function (data, type, full, meta) {
                    return meta.settings._iDisplayStart + meta.row + 1;
                },
            }, //編號
            { data: "path" }, //選單路徑
            {
                data: null,
                defaultContent: "",
                mRender: function (data, type, full) {
                    var url = data.url;
                    return '<a href="' + url + '" target="blank">' + url + "</a>";
                },
            }, //URL
            { data: "check_rate_string" }, //點檢頻率
            // { data: "pm_def_name" },            //負責審核PM
            // { data: "pm_agent_name" },          //代理審核PM
        ],
        rowCallback: function (row, data, index) {
            //   console.log(data);
            // $(row).attr('data-id',data.id);
        },
    };
    var _mainRecordTable = mainRecordTable.DataTable(dataTableSettings);

    //代理審核服務
    var agetntRecordTable = $("#agent-record-table");
    var agentTableUrl = agetntRecordTable.attr("action");
    var searchForm = $("#search-form");
    var searchFromBtn = $("#search-btn");
    var _agentRecordTable;
    var dataTableSettings = {
        stateSave: false,
        processing: true,
        serverSide: true,
        searching: false,
        destroy: true,
        autoWidth: true,
        ordering: false,
        paging: false,
        bInfo: false,
        lengthChange: false,
        language: datatable_lang_tw,
        ajax: {
            url: agentTableUrl,
            type: "GET",
            data: function (aoData) {
                //把分頁的參數與自訂的搜尋結合
                $.each(searchForm.serializeArray(), function (key, value) {
                    aoData[value.name] = value.value;
                });
                aoData["employee_id"] = id;
                return aoData;
            },
            // success:function(data){
            //     console.log(data);
            // },
            // error:function(e){
            //     console.log('error',e);
            // },
            dataSrc: "data",
        },
        columns: [
            {
                data: null,
                defaultContent: "",
                mRender: function (data, type, full, meta) {
                    return meta.settings._iDisplayStart + meta.row + 1;
                },
            }, //編號
            { data: "path" }, //選單路徑
            {
                data: null,
                defaultContent: "",
                mRender: function (data, type, full) {
                    var url = data.url;
                    return '<a href="' + url + '" target="blank">' + url + "</a>";
                },
            }, //URL
            { data: "check_rate_string" }, //點檢頻率
            // { data: "pm_def_name" },            //負責審核PM
            // { data: "pm_agent_name" },          //代理審核PM
        ],
        rowCallback: function (row, data, index) {
            //   console.log(data);
            // $(row).attr('data-id',data.id);
        },
    };
    var _agentRecordTable = agetntRecordTable.DataTable(dataTableSettings);
});
