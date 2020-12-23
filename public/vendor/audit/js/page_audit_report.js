$(document).ready(function () {
    function gup(name, url) {
        if (!url) url = location.href;
        name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
        var regexS = "[\\?&]" + name + "=([^&#]*)";
        var regex = new RegExp(regexS);
        var results = regex.exec(url);
        return results == null ? null : results[1];
    }

    var id = gup("id", window.location);

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

    // 時間設定
    $("#startDate")
        .datepicker({
            autoclose: true,
            language: "zh-TW",
            format: "yyyy-mm-dd",
        })
        .on("changeDate", function () {
            if ($("#startDate").val() > $("#endDate").val()) {
                $("#endDate").val("");
            }
            $("#endDate").datepicker("setStartDate", $("#startDate").val());
            $("#endDate").focus();
        });
    $("#endDate").datepicker({
        autoclose: true,
        language: "zh-TW",
        format: "yyyy-mm-dd",
    });

    var recordTable = $("#record-table");
    var tableUrl = recordTable.attr("action");
    var searchForm = $("#search-form");
    var dateSearchFromBtn = $("#date-search-btn");
    var pathSearchFromBtn = $("#path-search-btn");

    var _recordTable;
    var dataTableSettings = {
        stateSave: false,
        processing: true,
        serverSide: true,
        searching: false,
        destroy: true,
        autoWidth: true,
        ordering: false,
        lengthChange: false,
        language: datatable_lang_tw,
        ajax: {
            url: tableUrl,
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
            { data: "pm_check_name" }, //審核PM
            {
                data: null,
                defaultContent: "",
                mRender: function (data, type, full) {
                    var status = data.status;
                    var status_string = data.status_string;
                    if (status == 1) {
                        return (
                            '<div class="btn btn-sm btn-success">' + status_string + "</div>"
                        );
                    } else if (status == 2) {
                        return (
                            '<div class="btn btn-sm btn-danger">' + status_string + "</div>"
                        );
                    } else {
                        return (
                            '<div class="btn btn-sm btn-primary">' + status_string + "</div>"
                        );
                    }
                },
            }, //審核狀態
            { data: "created_at" }, //點檢時間
            { data: "checked_at" }, //審核時間
            { data: "pm_check_department" }, //單位(科股)
        ],

        rowCallback: function (row, data, index) {
            //   console.log(data);
            // $(row).attr('data-id',data.id);
        },
        initComplete: function () {
            _datatable = this;
            // 點檢頻率
            _datatable
                .api()
                .columns(3)
                .every(function () {
                    var column = this;
                    var select = $("#check-rate-filter").on("change", function () {
                        var val = $.fn.dataTable.util.escapeRegex($(this).val());
                        column.search(val).draw();
                    });
                });
            // 審核PM
            _datatable
                .api()
                .columns(4)
                .every(function () {
                    var column = this;
                    var select = $("#pm-filter").on("change", function () {
                        var val = $.fn.dataTable.util.escapeRegex($(this).val());
                        column.search(val).draw();
                    });
                });
            // 審核狀態
            _datatable
                .api()
                .columns(5)
                .every(function () {
                    var column = this;
                    var select = $("#status-filter").on("change", function () {
                        var val = $.fn.dataTable.util.escapeRegex($(this).val());
                        column.search(val).draw();
                    });
                });
            // 部門
            _datatable
                .api()
                .columns(8)
                .every(function () {
                    var column = this;
                    var select = $("#department-filter").on("change", function () {
                        var val = $.fn.dataTable.util.escapeRegex($(this).val());
                        column.search(val).draw();
                    });
                });
        },
    };
    var _recordTable = recordTable.DataTable(dataTableSettings);

    dateSearchFromBtn.on("click", function () {
        _recordTable.ajax.reload();
    });
    pathSearchFromBtn.on("click", function () {
        _recordTable.ajax.reload();
    });

    //點檢頻率
    $("#check-rate-filter").hide();
    $("#check-rate-btn").on("click", function () {
        $("#check-rate-filter").toggle();
    });
    $("#check-rate-filter").on("change", function () {
        $("#check-rate-filter").hide();
    });
    //檢核PM
    $("#pm-filter").hide();
    $("#pm-btn").on("click", function () {
        $("#pm-filter").toggle();
    });
    $("#pm-filter").on("change", function () {
        $("#pm-filter").hide();
    });
    //檢核狀態
    $("#status-filter").hide();
    $("#status-btn").on("click", function () {
        $("#status-filter").toggle();
    });
    $("#status-filter").on("change", function () {
        $("#status-filter").hide();
    });
    //部門
    $("#department-filter").hide();
    $("#department-btn").on("click", function () {
        $("#department-filter").toggle();
    });
    $("#department-filter").on("change", function () {
        $("#department-filter").hide();
    });

    // 匯出excel
    $("#excel_export").on("click", function (e) {
        e.preventDefault()

        q_string = '?';

        $.each(searchForm.serializeArray(), function (key, value) {
            q_string += value.name + '=' + value.value + '&';
        });
        
        q_string += 'employee_id=' + (id == null ? '' : id);

        let url = $(this).attr('action')


        window.open(url + q_string);
    });
    
});
