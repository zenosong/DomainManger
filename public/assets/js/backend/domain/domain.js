define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'domain/domain/index' + location.search,
                    add_url: 'domain/domain/add',
                    edit_url: 'domain/domain/edit',
                    del_url: 'domain/domain/del',
                    multi_url: 'domain/domain/multi',
                    import_url: 'domain/domain/import',
                    table: 'domain',
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
                        {field: 'id', title: __('Id')},
                        {field: 'user_id', title: __('User_id')},
                        {field: 'group_id', title: __('Group_id')},
                        {field: 'domain', title: __('Domain'), operate: 'LIKE'},
                        {field: 'dns_id', title: __('Dns_id')},
                        {field: 'dns', title: __('Dns'), operate: 'LIKE'},
                        {field: 'channel', title: __('Channel'), operate: 'LIKE'},
                        {field: 'status', title: __('Status')},
                        {field: 'is_auto_renew', title: __('Is_auto_renew')},
                        {field: 'record_nums', title: __('Record_nums')},
                        {field: 'latest_time', title: __('Latest_time'), operate:'RANGE', addclass:'datetimerange', autocomplete:false, formatter: Table.api.formatter.datetime},
                        {field: 'create_time', title: __('Create_time'), operate:'RANGE', addclass:'datetimerange', autocomplete:false, formatter: Table.api.formatter.datetime},
                        {field: 'update_time', title: __('Update_time'), operate:'RANGE', addclass:'datetimerange', autocomplete:false, formatter: Table.api.formatter.datetime},
                        {field: 'domaingroup.id', title: __('Domaingroup.id')},
                        {field: 'domaingroup.user_id', title: __('Domaingroup.user_id')},
                        {field: 'domaingroup.name', title: __('Domaingroup.name'), operate: 'LIKE'},
                        {field: 'domaingroup.status', title: __('Domaingroup.status')},
                        {field: 'domaingroup.delete_time', title: __('Domaingroup.delete_time'), operate:'RANGE', addclass:'datetimerange', autocomplete:false, formatter: Table.api.formatter.datetime},
                        {field: 'domaingroup.create_time', title: __('Domaingroup.create_time'), operate:'RANGE', addclass:'datetimerange', autocomplete:false, formatter: Table.api.formatter.datetime},
                        {field: 'domaingroup.update_time', title: __('Domaingroup.update_time'), operate:'RANGE', addclass:'datetimerange', autocomplete:false, formatter: Table.api.formatter.datetime},
                        {field: 'user.id', title: __('User.id')},
                        {field: 'user.group_id', title: __('User.group_id')},
                        {field: 'user.username', title: __('User.username'), operate: 'LIKE'},
                        {field: 'user.nickname', title: __('User.nickname'), operate: 'LIKE'},
                        {field: 'user.password', title: __('User.password'), operate: 'LIKE'},
                        {field: 'user.salt', title: __('User.salt'), operate: 'LIKE'},
                        {field: 'user.email', title: __('User.email'), operate: 'LIKE'},
                        {field: 'user.mobile', title: __('User.mobile'), operate: 'LIKE'},
                        {field: 'user.avatar', title: __('User.avatar'), operate: 'LIKE', events: Table.api.events.image, formatter: Table.api.formatter.image},
                        {field: 'user.level', title: __('User.level')},
                        {field: 'user.gender', title: __('User.gender')},
                        {field: 'user.birthday', title: __('User.birthday'), operate:'RANGE', addclass:'datetimerange', autocomplete:false},
                        {field: 'user.bio', title: __('User.bio'), operate: 'LIKE'},
                        {field: 'user.money', title: __('User.money'), operate:'BETWEEN'},
                        {field: 'user.score', title: __('User.score')},
                        {field: 'user.successions', title: __('User.successions')},
                        {field: 'user.maxsuccessions', title: __('User.maxsuccessions')},
                        {field: 'user.prevtime', title: __('User.prevtime'), operate:'RANGE', addclass:'datetimerange', autocomplete:false, formatter: Table.api.formatter.datetime},
                        {field: 'user.logintime', title: __('User.logintime'), operate:'RANGE', addclass:'datetimerange', autocomplete:false, formatter: Table.api.formatter.datetime},
                        {field: 'user.loginip', title: __('User.loginip'), operate: 'LIKE'},
                        {field: 'user.loginfailure', title: __('User.loginfailure')},
                        {field: 'user.joinip', title: __('User.joinip'), operate: 'LIKE'},
                        {field: 'user.jointime', title: __('User.jointime'), operate:'RANGE', addclass:'datetimerange', autocomplete:false, formatter: Table.api.formatter.datetime},
                        {field: 'user.createtime', title: __('User.createtime'), operate:'RANGE', addclass:'datetimerange', autocomplete:false, formatter: Table.api.formatter.datetime},
                        {field: 'user.updatetime', title: __('User.updatetime'), operate:'RANGE', addclass:'datetimerange', autocomplete:false, formatter: Table.api.formatter.datetime},
                        {field: 'user.token', title: __('User.token'), operate: 'LIKE'},
                        {field: 'user.status', title: __('User.status'), operate: 'LIKE', formatter: Table.api.formatter.status},
                        {field: 'user.verification', title: __('User.verification'), operate: 'LIKE'},
                        {field: 'operate', title: __('Operate'), table: table, events: Table.api.events.operate, formatter: Table.api.formatter.operate}
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
        api: {
            bindevent: function () {
                Form.api.bindevent($("form[role=form]"));
            }
        }
    };
    return Controller;
});