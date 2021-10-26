define(['jquery', 'bootstrap', 'backend', 'table', 'form', 'template'], function ($, undefined, Backend, Table, Form, Template) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init();

            let table = $("#table");
            table.bootstrapTable({
                url: 'product/index',
                extend: {
                    index_url: 'product/index',
                    add_url: 'product/add',
                    edit_url: 'product/edit',
                    table: 'product',
                },
                toolbar: '#toolbar',
                sortName: 'id',
                sortOrder: 'asc',
                search: true,
                commonSearch: false,
                showToggle: false,
                showExport: false,
                showColumns: false,
                columns: [
                    [
                        {field: 'name', title: __('Product name')},
                        {field: 'extend.domain_num.value', title: __('Domain num')},
                        {field: 'models.0.price', title: __('Month')},
                        {field: 'models.1.price', title: __('Quarter')},
                        {field: 'models.2.price', title: __('Year')},
                        {field: 'status', title: __('Status'), operate: false, formatter: Table.api.formatter.status, searchList: {'1': __('Enabled'), '0': __('Disabled')}},
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

            $("form.edit-form").data("validator-options", {
                display: function (elem) {
                    return $(elem).closest('tr').find("td:first").text();
                }
            });
            Form.api.bindevent($("form.edit-form"));

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
