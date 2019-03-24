$(function () {

    $('#mauth5_add').dialog({
        width: 420,
        title: '新增电脑',
        modal: true,
        closed : true,
        iconCls : 'icon-user-add',
        buttons : [{
            text : '提交',
            iconCls : 'icon-add-new',
            handler : function () {
                if ($('#mauth5_add').form('validate')) {
                     var nnode=$('#vemployee').tree.getSelected();
                    $.ajax({
                        url : 'yfqx_add',
                        data : {
                            type : 'post',
                            name:$('input[name="yfqx_add_name"]').val(),
                            login_name:$('input[name="yfqx_add_login_name"]').val(),
                            comment:$('input[name="yfqx_add_comment"]').val(),
                            user_pass:$('input[name="yfqx_add_user_pass"]').val(),
                            auth:$('input[name="yfqx_add_auth"]').val(),
                            dept_id:$nnode.text,
                        },
                        beforeSend : function () {
                            $.messager.progress({
                                text : '正在新增中...',
                            });
                        },
                        success : function (data, response, status) {
                            $.messager.progress('close');
                            if (data > 0) {
                                $.messager.show({
                                    title : '提示',
                                    msg : '新增用户成功',
                                });
                                $('#ipmanager_add').dialog('close').form('reset');
                                $('#ipmanager').datagrid('reload');
                            } else {
                                $.messager.alert('新增失败！', '未知错误导致失败，请重试！', 'warning');
                            }
                        }
                    });
                }
            },
        },{
            text : '取消',
            iconCls : 'icon-redo',
            handler : function () {
                $('#mauth5_add').dialog('close').form('reset');
            },
        }],
    });

    $('#manager_edit').dialog({
        width : 420,
        title : '修改计算机',
        modal : true,
        closed : true,
        iconCls : 'icon-user-add',
        buttons : [{
            text : '提交',
            iconCls : 'icon-edit-new',
            handler : function () {
                if ($('#manager_edit').form('validate')) {
                    $.ajax({
                        url : 'ipupdate',
                        type : 'post',
                        data : {
                            id:$('input[name="id2"]').val(),
                            username:$('input[name="username2"]').val(),
                            cname1:$('input[name="cname12"]').val(),
                            cname2:$('input[name="cname22"]').val(),
                            iplan:$('input[name="iplan2"]').val(),
                            lmac:$('input[name="lmac2"]').val(),
                            ipwlan:$('input[name="ipwlan2"]').val(),
                            wmac:$('input[name="wmac2"]').val(),
                            comment:$('input[name="comment2"]').val(),
                            lastdate:getdate(),
                        },
                        beforeSend : function () {
                            $.messager.progress({
                                text : '正在修改中...',
                            });
                        },
                        success : function (data, response, status) {
                            $.messager.progress('close');
                            if (data > 0) {
                                $.messager.show({
                                    title : '提示',
                                    msg : '修改成功',
                                });
                                $('#manager_edit').dialog('close').form('reset');
                                $('#ipmanager').datagrid('reload');
                            } else {
                                $.messager.alert('修改失败！', '未知错误或没有任何修改，请重试！', 'warning');
                            }
                        }
                    });
                }
            },
        },{
            text : '取消',
            iconCls : 'icon-redo',
            handler : function () {
                $('#manager_edit').dialog('close').form('reset');
            },
        }],
    });

    brow_tool2 = {
        add2 : function () {
            $('#mauth5_add').dialog('open');
            // $('input[name="username"]').focus();
        },
        auth2: function () {
            var rows1 = $('#userbrow').datagrid('getSelections');
            if (rows1.length !=1) {
                $.messager.alert('警告操作！', '只能选定一条数据！', 'warning');
            } else {
                $.ajax({
                    url: 'getauth2/' + rows1[0].login_name,
                    type: 'post',
                    cache:false,
                    data: {
                        login_name: rows1[0].login_name,
                    },
                    beforeSend: function () {
                        $.messager.progress({
                            text: '正在获取中...',
                        });
                    },
                    success: function (data2, response, status) {
                        $.messager.progress('close');
                        if (data2) {
                            $('#mauth5').form('load',{
                                	name4:'name2',
                                    login_name4:'login_name'

                            }).dialog('open');
                        }
                    }
                });
            }
        },
        remove : function () {
            var rows = $('#ipmanager').datagrid('getSelections');
            if (rows.length > 0) {
                $.messager.confirm('确定操作', '您正在要删除所选的记录吗？', function (flag) {
                    if (flag) {
                        var ids = [];
                        for (var i = 0; i < rows.length; i ++) {
                            ids.push(rows[i].id);
                        }
                        // console.log(ids.join(','));
                        $.ajax({
                            type : 'POST',
                            url : 'deletemanager',
                            data : {
                                ids:ids,
                                //ids : ids.join(','),
                                // id:rows[0].id,
                            },
                            beforeSend : function () {
                                $('#ipmanager').datagrid('loading');
                            },
                            success : function (data) {
                                if (data) {
                                    $('#ipmanager').datagrid('loaded');
                                    $('#ipmanager').datagrid('load');
                                    $('#ipmanager').datagrid('unselectAll');
                                    $.messager.show({
                                        title : '提示',
                                        msg : data + '个电脑被删除成功！',
                                    });
                                }
                            },
                        });
                    }
                });
            } else {
                $.messager.alert('提示', '请选择要删除的记录！', 'info');
            }
        },
        edit : function () {
            var rows = $('#ipmanager').datagrid('getSelections');
            if (rows.length > 1) {
                $.messager.alert('警告操作！', '编辑记录只能选定一条数据！', 'warning');
            } else if (rows.length == 1) {
                $.ajax({
                    url : 'iptable/'+rows[0].id+'/edit',
                    type : 'get',
                    data : {
                        id : rows[0].id,
                    },
                    beforeSend : function () {
                        $.messager.progress({
                            text : '正在获取中...',
                        });
                    },
                    success : function (data, response, status) {
                        $.messager.progress('close');

                        if (data) {
                            // $auth = data[0].auth;
                            $('#manager_edit').form('load', {
                                id2:data[0].id,
                                username2 : data[0].username,
                                cname12 :data[0].cname1,
                                cname22 :data[0].cname2,
                                cname12 :data[0].cname1,
                                iplan2 :data[0].iplan,
                                ipwlan2 :data[0].ipwlan,
                                lmac2 :data[0].lmac,
                                wmac2 :data[0].wmac,
                                comment2 : data[0].comment,
                            }).dialog('open');
                        } else {
                            $.messager.alert('获取失败！', '未知错误导致失败，请重试！', 'warning');
                        }
                    }
                });
            } else if (rows.length == 0) {
                $.messager.alert('警告操作！', '编辑记录至少选定一条数据！', 'warning');
            }
        },
    };
});

