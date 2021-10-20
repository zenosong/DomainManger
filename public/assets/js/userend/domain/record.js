define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init();

            let table = $("#table");
            table.bootstrapTable({
                url: 'domain/record',
                extend: {
                    index_url: 'domain/record/index',
                    add_url: 'domain/record/add',
                    edit_url: 'domain/record/edit',
                    del_url: 'domain/record/del',
                    table: 'record',
                },
                toolbar: '#toolbar',
                sortName: 'id',
                search: false,
                columns: [
                    [
                        {field: 'host', title: __('Host')},
                        {field: 'type', title: __('Type')},
                        {field: 'value', title: __('Value')},
                        {field: 'weight', title: __('Weight')},
                        {field: 'mx_level', title: __('MX Level')},
                        {field: 'ttl', title: __('TTL')},
                        {field: 'status', title: __('Status')},
                        {field: 'create_time', title: __('Create time')},
                        {field: 'update_time', title: __('Update time')},
                        {
                            field: 'operate', title: __('Operate'), table: table, events: Table.api.events.operate, buttons: [

                            ], formatter: Table.api.formatter.operate
                        }
                    ]
                ],
                onClickRow: function (row) {
                    console.log(row);
                }
            });

            // 为表格1绑定事件
            Table.api.bindevent(table);
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
