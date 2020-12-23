$(document).ready(function () {
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

    var recordTable = $("#record-table");
    var tableUrl = recordTable.attr("action");
    var searchForm = $("#search-form");
    var searchFromBtn = $("#search-btn");

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
                mRender: function (data, type, full) {
                    var id = data.id;
                    return (
                        '<button type="button" class="btn btn-outline-primary btn-sm edit-modal">編輯</button>\
                              <a href="/audit_services/delete/' +
                        id +
                        '" class="btn btn-outline-danger btn-sm">刪除</a>'
                    );
                },
            },
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
            { data: "pm_def_name" }, //負責審核PM
            { data: "pm_agent_name" }, //代理審核PM
            { data: "level_1_name" }, //一階主管
            { data: "level_2_name" }, //二階主管
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
                .columns(4)
                .every(function () {
                    var column = this;
                    var select = $("#check-rate-filter").on("change", function () {
                        var val = $.fn.dataTable.util.escapeRegex($(this).val());
                        column.search(val).draw();
                    });
                });
            // 負責審核PM
            _datatable
                .api()
                .columns(5)
                .every(function () {
                    var column = this;
                    var select = $("#pm-def-filter").on("change", function () {
                        var val = $.fn.dataTable.util.escapeRegex($(this).val());
                        column.search(val).draw();
                    });
                });
            // 代理審核PM
            _datatable
                .api()
                .columns(6)
                .every(function () {
                    var column = this;
                    var select = $("#pm-agent-filter").on("change", function () {
                        var val = $.fn.dataTable.util.escapeRegex($(this).val());
                        column.search(val).draw();
                    });
                });
            // 一階主管
            _datatable
                .api()
                .columns(7)
                .every(function () {
                    var column = this;
                    var select = $("#level1-filter").on("change", function () {
                        var val = $.fn.dataTable.util.escapeRegex($(this).val());
                        column.search(val).draw();
                    });
                });
            // 二階主管
            _datatable
                .api()
                .columns(8)
                .every(function () {
                    var column = this;
                    var select = $("#level2-filter").on("change", function () {
                        var val = $.fn.dataTable.util.escapeRegex($(this).val());
                        column.search(val).draw();
                    });
                });
        },
    };
    var _recordTable = recordTable.DataTable(dataTableSettings);

    // 輸入選單路徑
    searchFromBtn.on("click", function () {
        _recordTable.ajax.reload();
    });

    //新增顯示按鈕
    var addSubmit = $("#addSubmit");
    var addPath = $("#addPath");
    var addUrl = $("#addUrl");
    var addPmDef = $("#addPmDef");
    var addPmAgent = $("#addPmAgent");
    var addLevel1 = $("#addLevel1");
    var addLevel2 = $("#addLevel2");
    var addCheckRate = $("#addCheckRate");
    addSubmit.prop("disabled", true);

    //新增modal
    $("body").on("click", ".add-modal", function () {
        $("#add-modal").modal("show");
        var modal = $("#add-modal");
        modal.find("#add-form").each(function () {
            this.reset();
        });
        getAddVal();
    });

    function getAddVal() {
        if (
            addPath.val() != "" &&
            addUrl.val() != "" &&
            addPmDef.val() != "" &&
            addLevel2.val() != "" &&
            addCheckRate.val() != ""
        ) {
            addSubmit.prop("disabled", false);
        } else {
            addSubmit.prop("disabled", true);
        }
    }
    addPath.on("change", function () {
        getAddVal();
    });
    addUrl.on("change", function () {
        console.log(addUrl.val());
        getAddVal();
    });
    addPmDef.on("change", function () {
        getAddVal();
        $.ajax({
            type: "GET",
            url: "/audit_services/getAgent",
            data: { id: addPmDef.val() },
            dataType: "json",
            success: function (data) {
                addPmAgent.val(data.AuditUser["agent_id"]);
            },
        });
    });
    // addLevel1.on('change', function() {
    //     getAddVal();
    // });
    addLevel2.on("change", function () {
        getAddVal();
    });
    addCheckRate.on("change", function () {
        getAddVal();
    });

    //編輯顯示按鈕
    var editSubmit = $("#editSubmit");
    var editPath = $("#editPath");
    var editUrl = $("#editUrl");
    var editPmDef = $("#editPmDef");
    var editPmAgent = $("#editPmAgent");
    var editLevel1 = $("#editLevel1");
    var editLevel2 = $("#editLevel2");
    var editCheckRate = $("#editCheckRate");
    editSubmit.prop("disabled", true);

    //編輯modal
    $("body").on("click", ".edit-modal", function () {
        $("#edit-modal").modal("show");
        var modal = $("#edit-modal");
        modal.find("#edit-form").each(function () {
            this.reset();
        });
        var modalData = _recordTable.row($(this).parents("tr")).data();
        // var {id, path, url, check_rate, pm_def_id, pm_agent_id, level_1_id, level_2_id, deadline_at} = data;

        modal.find("#edit-form").attr("action", "/audit_setting/service/" + modalData.id);
        modal.find("#editPath").val(modalData.path);
        modal.find("#editUrl").val(modalData.url);
        modal.find("#editCheckRate").val(modalData.check_rate);
        modal.find("#editPmDef").val(modalData.pm_def_id);
        modal.find("#editPmAgent").val(modalData.pm_agent_id);
        modal.find("#editLevel1").val(modalData.level_1_id);
        modal.find("#editLevel2").val(modalData.level_2_id);
        modal.find("#editDeadlineAt").val(modalData.deadline_at);

        getEditVal();
    });

    function getEditVal() {
        if (
            editPath.val() != "" &&
            editUrl.val() != "" &&
            editPmDef.val() != "" &&
            editLevel2.val() != "" &&
            editCheckRate.val() != ""
        ) {
            editSubmit.prop("disabled", false);
        } else {
            editSubmit.prop("disabled", true);
        }
    }
    editPath.on("change", function () {
        getEditVal();
    });
    editUrl.on("change", function () {
        getEditVal();
    });
    editPmDef.on("change", function () {
        getEditVal();
        $.ajax({
            type: "GET",
            url: "/audit_services/getAgent",
            data: { id: editPmDef.val() },
            dataType: "json",
            success: function (data) {
                editPmAgent.val(data.AuditUser["agent_id"]);
            },
        });
    });
    // editLevel1.on('change', function() {
    //     getEditVal();
    // });
    editLevel2.on("change", function () {
        getEditVal();
    });
    editCheckRate.on("change", function () {
        getEditVal();
    });

    //點檢頻率
    $("#check-rate-filter").hide();
    $("#check-rate-btn").on("click", function () {
        $("#check-rate-filter").toggle();
    });
    $("#check-rate-filter").on("change", function () {
        $("#check-rate-filter").hide();
    });
    //負責審核PM
    $("#pm-def-filter").hide();
    $("#pm-def-btn").on("click", function () {
        $("#pm-def-filter").toggle();
    });
    $("#pm-def-filter").on("change", function () {
        $("#pm-def-filter").hide();
    });
    //代理審核PM
    $("#pm-agent-filter").hide();
    $("#pm-agent-btn").on("click", function () {
        $("#pm-agent-filter").toggle();
    });
    $("#pm-agent-filter").on("change", function () {
        $("#pm-agent-filter").hide();
    });
    //一階主管
    $("#level1-filter").hide();
    $("#level1-btn").on("click", function () {
        $("#level1-filter").toggle();
    });
    $("#level1-filter").on("change", function () {
        $("#level1-filter").hide();
    });
    //二階主管
    $("#level2-filter").hide();
    $("#level2-btn").on("click", function () {
        $("#level2-filter").toggle();
    });
    $("#level2-filter").on("change", function () {
        $("#level2-filter").hide();
    });
});
