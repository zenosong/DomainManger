define(['jquery', 'bootstrap', 'userend', 'table', 'form'], function ($, undefined, Userend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'order/index',
                    table: 'user_order',
                }
            });

            var table = $("#table");

            // 初始化表格
            table.bootstrapTable({
                url: $.fn.bootstrapTable.defaults.extend.index_url,
                pk: 'id',
                sortName: 'id',
                columns: [
                    [
                        {checkbox: true},
                        {field: 'create_time', title: __('创建时间'), formatter: Table.api.formatter.datetime},
                        {field: 'order_no', title: __('订单编号')},
                        {field: 'product', title: __('购买内容')},
                        {field: 'real_amount', title: __('实付金额')},
                        {field: 'after', title: __('After')},
                        {field: 'status', title: __('状态')},
                        {
                            field: 'operate',
                            title: __('Operate'),
                            table: table,
                            buttons: [
                                {
                                    name: 'pay',
                                    title: __('订单支付'),
                                    classname: 'btn btn-xs btn-primary btn-dialog',
                                    icon: 'fa fa-list',
                                    url: 'order/pay'
                                }
                            ],
                            formatter: Table.api.formatter.operate
                        }
                    ]
                ]
            });

            // 为表格绑定事件
            Table.api.bindevent(table);
        },
        add: function () {
            Controller.api.bindevent();
        },
        edit: function () {
            Controller.api.bindevent();
        },
        pay: function () {
            Controller.api.bindevent();
            $(document).on('click', '#pay-type-group button', function () {
                $(this).parent().find('button').removeClass('active');
                $(this).addClass('active');
                $('#pay_type').val($(this).attr('id'));
                if ($(this).attr('id') === 'card') {
                    $('.card-form').show();
                } else {
                    $('.card-form').hide();
                }
            });
        },
        api: {
            bindevent: function () {
                Form.api.bindevent($("form[role=form]"));
            }
        }
    };
    return Controller;
});