define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init();
            this.table.first();
            this.table.second();
        },
        table: {
            first: function () {
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
                            {field: 'name', title: __('Nickname'), searchable: false},
                            {
                                field: 'operate', title: __('Operate'), table: table1, events: Table.api.events.operate, buttons: [

                                ], formatter: Table.api.formatter.operate
                            }
                        ]
                    ],
                    onClickRow: function (row) {
                        $("#myTabContent2 .form-commonsearch input[name='username']").val(row.username);
                        $("#myTabContent2 .btn-refresh").trigger("click");
                    }
                });

                // 为表格1绑定事件
                Table.api.bindevent(table1);
            },
            second: function () {
                // 表格2
                var table2 = $("#table2");
                table2.bootstrapTable({
                    url: 'domain/domain',
                    extend: {
                        index_url: 'domain/domain/index',
                        add_url: 'domain/domain/add',
                        edit_url: 'domain/domain/edit',
                        del_url: 'domain/domain/del',
                        table: 'domain',
                    },
                    toolbar: '#toolbar2',
                    sortName: 'id',
                    search: true,
                    commonSearch: false,
                    showExport: false,
                    showColumns: false,
                    showToggle: false,
                    columns: [
                        [
                            {field: 'domain', title: __('Domain'), searchable: false},
                            {field: 'dns', title: __('Dns'), searchable: false},
                            {field: 'channel', title: __('Channel'), searchable: false},
                            {field: 'Status', title: __('Status'), searchable: false},
                            {field: 'create_time', title: __('Createtime'), formatter: Table.api.formatter.datetime, operate: 'RANGE', addclass: 'datetimerange', sortable: true, searchable: false},
                            {field: 'update_time', title: __('Updatetime'), formatter: Table.api.formatter.datetime, operate: 'RANGE', addclass: 'datetimerange', sortable: true, searchable: false},
                            {field: 'is_auto_renew', title: __('自动续费')},
                            {
                                field: 'operate', title: __('Operate'), table: table2, events: Table.api.events.operate, buttons: [
                                    {
                                        name: 'single',
                                        title: '独立解析',
                                        icon: 'fa fa-connectdevelop',
                                        classname: 'btn btn-primary btn-xs btn-addtabs',
                                        url: 'domain/record/index',
                                    }
                                ], formatter: Table.api.formatter.operate
                            }
                        ]
                    ]
                });

                // 为表格2绑定事件
                Table.api.bindevent(table2);
            }
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
