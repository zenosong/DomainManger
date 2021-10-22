define(['jquery', 'bootstrap', 'userend', 'table', 'form'], function ($, undefined, Userend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init();

            // 表格1
            var table1 = $("#table1");
            table1.bootstrapTable({
                url: 'domain/group',
                extend: {
                    index_url: 'domain/group/index',
                    add_url: 'domain/group/add',
                    edit_url: 'domain/group/edit',
                    del_url: 'domain/group/del',
                    table: 'group',
                },
                toolbar: '#toolbar1',
                sortName: 'id',
                search: false,
                showHeader: false,
                showFooter: false,
                showColumns: false,
                showToggle: false,
                showRefresh: false,
                commonSearch: false,
                showExport: false,
                clickToSelect: true,
                singleSelect: true,
                columns: [
                    [
                        {field: 'username', title: __('Nickname'), searchable: false},
                        {
                            field: 'operate', title: __('Operate'), table: table1, events: Table.api.events.operate, buttons: [
                                {
                                    name: 'log',
                                    title: '日志列表',
                                    text: '日志列表',
                                    icon: 'fa fa-list',
                                    classname: 'btn btn-primary btn-xs btn-click',
                                    click: function (e, data) {
                                        $("#myTabContent2 .form-commonsearch input[name='username']").val(data.username);
                                        $("#myTabContent2 .btn-refresh").trigger("click");
                                    }
                                }
                            ], formatter: Table.api.formatter.operate
                        }
                    ]
                ],
                onClickRow: function (row) {
                    console.log(row);
                    $("#myTabContent2 .form-commonsearch input[name='username']").val(row.username);
                    $("#myTabContent2 .btn-refresh").trigger("click");
                }
            });

            // 为表格1绑定事件
            Table.api.bindevent(table1);
        },
        add: function () {
            Controller.api.bindevent();
        },
        edit: function () {
            Controller.api.bindevent();
        },
        del: function () {
            Controller.api.bindevent();
        },
        api: {
            bindevent: function () {
                Form.api.bindevent($("form[role=form]"));
            }
        }
    };
    return Controller;
});
