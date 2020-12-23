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
                              <a href="/audit_setting/user/delete/' +
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
            {data: "department"}, //單位(科股)
            {data: "position_string"}, //職位
            {data: "employee_id"}, //員工編號
            {data: "name"}, //姓名
            {data: "email"}, //信箱
            {data: "phone"}, //手機
            {data: "agent_name"}, //代理員工姓名
        ],

        rowCallback: function (row, data, index) {
            //   console.log(data);
            // $(row).attr('data-id',data.id);
        },
        initComplete: function () {
            _datatable = this;
            // 部門
            _datatable
                .api()
                .columns(1)
                .every(function () {
                    var column = this;
                    var select = $("#department-filter").on("change", function () {
                        var val = $.fn.dataTable.util.escapeRegex($(this).val());
                        column.search(val).draw();
                    });
                });
            // 職位
            _datatable
                .api()
                .columns(2)
                .every(function () {
                    var column = this;
                    var select = $("#position-filter").on("change", function () {
                        var val = $.fn.dataTable.util.escapeRegex($(this).val());
                        column.search(val).draw();
                    });
                });
        },
    };
    var _recordTable = recordTable.DataTable(dataTableSettings);

    // 輸入姓名、員工編號
    searchFromBtn.on("click", function () {
        _recordTable.ajax.reload();
    });

    //新增顯示按鈕
    var addSubmit = $("#addSubmit");
    var addDepartment = $("#addDepartment");
    var addPosition = $("#addPosition");
    var addEmployeeId = $("#addEmployeeId");
    var addName = $("#addName");
    var addEmail = $("#addEmail");
    var addPhone = $("#addPhone");
    var addAgentId = $("#addAgentId");
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
            addDepartment.val() != "" &&
            addEmployeeId.val() != "" &&
            addName.val() != "" &&
            addEmail.val() != "" &&
            addPhone.val() != ""
        ) {
            addSubmit.prop("disabled", false);
        } else {
            addSubmit.prop("disabled", true);
        }
    }

    //新增顯示代理人
    $("#addPosition").on("change", function () {
        console.log(addPosition.val());
        if (addPosition.val() != 3) {
            $(".addSelectPm").prop("disabled", true);
            $(".addSelectPm").val("");
        } else {
            $(".addSelectPm").prop("disabled", false);
        }
    });

    //檢查新增modal欄位
    addDepartment.on("change", function () {
        getAddVal();
    });
    addPosition.on("change", function () {
        getAddVal();
    });
    addEmployeeId.on("change", function () {
        getAddVal();
    });
    addName.on("change", function () {
        getAddVal();
    });
    addEmail.on("change", function () {
        getAddVal();
    });
    addPhone.on("change", function () {
        getAddVal();
    });

    //編輯顯示按鈕
    var editSubmit = $("#editSubmit");
    var editDepartment = $("#editDepartment");
    var editPosition = $("#editPosition");
    var editEmployeeId = $("#editEmployeeId");
    var editName = $("#editName");
    var editEmail = $("#editEmail");
    var editPhone = $("#editPhone");
    var editAgentId = $("#editAgentId");

    //編輯modal
    $("body").on("click", ".edit-modal", function () {
        $("#edit-modal").modal("show");
        var modal = $("#edit-modal");
        modal.find("#edit-form").each(function () {
            this.reset();
        });
        var modalData = _recordTable.row($(this).parents("tr")).data();
        // var {id, department, employee_id, name, position, email, phone, agent_id} = data;

        modal.find("#edit-form").attr("action", "/audit_setting/user/" + modalData.id);
        modal.find("#editDepartment").val(modalData.department);
        modal.find("#editEmployeeId").val(modalData.employee_id);
        modal.find("#editName").val(modalData.name);
        modal.find("#editPosition").val(modalData.position);
        modal.find("#editEmail").val(modalData.email);
        modal.find("#editPhone").val(modalData.phone);
        modal.find("#editAgentId").val(modalData.agent_id);

        //編輯顯示代理人
        if (editPosition.val() != 3) {
            $(".editSelectPm").prop("disabled", true);
        } else {
            $(".editSelectPm").prop("disabled", false);
        }
        $("#editPosition").on("change", function () {
            if (editPosition.val() != 3) {
                $(".editSelectPm").prop("disabled", true);
                $(".editSelectPm").val("");
            } else {
                $(".editSelectPm").prop("disabled", false);
            }
        });
        getEditVal();
    });

    function getEditVal() {
        if (
            editDepartment.val() != "" &&
            editEmployeeId.val() != "" &&
            editName.val() != "" &&
            editEmail.val() != "" &&
            editPhone.val() != ""
        ) {
            editSubmit.prop("disabled", false);
        } else {
            editSubmit.prop("disabled", true);
        }
    }

    editDepartment.on("change", function () {
        getEditVal();
    });
    editPosition.on("change", function () {
        getEditVal();
    });
    editEmployeeId.on("change", function () {
        getEditVal();
    });
    editName.on("change", function () {
        getEditVal();
    });
    editEmail.on("change", function () {
        getEditVal();
    });
    editPhone.on("change", function () {
        getEditVal();
    });

    //單位
    $("#department-filter").hide();
    $("#department-btn").on("click", function () {
        $("#department-filter").toggle();
    });
    $("#department-filter").on("change", function () {
        $("#department-filter").hide();
    });
    //職務
    $("#position-filter").hide();
    $("#position-btn").on("click", function () {
        $("#position-filter").toggle();
    });
    $("#position-filter").on("change", function () {
        $("#position-filter").hide();
    });
});
