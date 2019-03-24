$(function () {
$('#vorg').treegrid({
    url:'get_org',
    idField:'id',
    fit:true,
    treeField:'org_name',
    toolbar:'#orgbrow_tool1',
    columns:[[
        {title:'部门名称',field:'org_name',width:380},
        {title:'负责人1',field:'org_leading1',width:160,align:'right'},
        {title:'负责人2',field:'org_leading2',width:160},
    ]],
    onLoadSuccess: function (node, data) {
        if (data) {
            $(data).each(function (index, value) {
                if (this.state == 'closed') {
                    $('#vorg').treegrid('expandAll');
                }
            });
        }
    },
  });

    $('#add_bm_name').validatebox({
        required:true,
        missingMessage:'请输入部门名称',
        invalidMessage:'部门名称不得为空',
    });

    $('#add_z1_name').validatebox({
        required:true,
        missingMessage:'请输入部门负责人姓名',
        invalidMessage:'部门负责人名称不得为空',
    });

    $('#edit_bm_name').validatebox({
        required:true,
        missingMessage:'请输入部门名称',
        invalidMessage:'部门名称不得为空',
    });

    $('#edit_z1_name').validatebox({
        required:true,
        missingMessage:'请输入部门负责人姓名',
        invalidMessage:'部门负责人名称不得为空',
    });
    // $('#yfqx_edit_user_pass').validatebox({
    //     // required:true,
    //     validtype:'length[8,15]',
    //     missingMessage:'用户密码8-15位或为空不修改',
    //     invalidMessage:'用户密码8-15位或为空不修改',
    // });

    $('#orgbrow_add').dialog({
        width: 420,
        title: '新增部门和负责人',
        modal: true,
        closed : true,
        iconCls : 'icon-user-add',
        buttons : [{
            text : '提交',
            iconCls : 'icon-add-new',
            handler : function () {
                if ($('#orgbrow_add').form('validate')) {
                    $.ajax({
                        url : 'bm_add',
                        type:'post',
                        data : {
                            type : 'post',
                            name:$('input[name="add_bm_name"]').val(),
                            z1:$('input[name="add_z1_name"]').val(),
                            z2:$('input[name="add_z2_name"]').val(),
                            nid:$('input[name="add_bm_nid"]').val(),
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
                                    msg : '新增部门成功',
                                });
                                $('#orgbrow_add').dialog('close').form('reset');
                                $('#vorg').treegrid('reload');
                            } else {
                                if(data==-3) {
                                    $.messager.alert('新增失败！', '部门名称已经存在，请重试！', 'warning');
                                }else{
                                    $.messager.alert('新增失败！', '未知错误导致失败，请重试！', 'warning');
                                }
                            }
                        }
                    });
                }
            },
        },{
            text : '取消',
            iconCls : 'icon-redo',
            handler : function () {
                $('#orgbrow_add').dialog('close').form('reset');
            },
        }],
    });


    $('#orgbrow_edit').dialog({
        width: 420,
        title: '修改部门和负责人',
        modal: true,
        closed : true,
        iconCls : 'icon-user-add',
        buttons : [{
            text : '提交',
            iconCls : 'icon-add-new',
            handler : function () {
                if ($('#orgbrow_edit').form('validate')) {
                    $.ajax({
                        url : 'bm_edit',
                        type:'post',
                        data : {
                            type : 'post',
                            name:$('input[name="edit_bm_name"]').val(),
                            z1:$('input[name="edit_z1_name"]').val(),
                            z2:$('input[name="edit_z2_name"]').val(),
                            id:$('input[name="edit_bm_id"]').val(),
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
                                    msg : '修改部门成功',
                                });
                                $('#orgbrow_edit').dialog('close').form('reset');
                                $('#vorg').treegrid('reload');
                            } else {
                                if(data==-3) {
                                    $.messager.alert('修改失败！', '部门名称已经存在，请重试！', 'warning');
                                }else{
                                    $.messager.alert('修改失败！', '未知错误导致失败，请重试！', 'warning');
                                }
                            }
                        }
                    });
                }
            },
        },{
            text : '取消',
            iconCls : 'icon-redo',
            handler : function () {
                $('#orgbrow_edit').dialog('close').form('reset');
            },
        }],
    });


    orgbrow_tool1 = {
        add_bm : function () {
            var rows = $('#vorg').datagrid('getSelections');
            if (rows.length != 1) {
                $.messager.alert('请选择部门！', '选定后增加同级层部门！', 'warning');
            } else if (rows.length == 1) {
                $('#orgbrow_add').form('load', {add_bm_name: '', add_z1_name: '', add_z2_name: '',add_bm_nid:rows[0].id}).dialog('open');
            }
        },
        // add_cbm : function () {
        //     var rows = $('#vorg').datagrid('getSelections');
        //     if (rows.length != 1) {
        //         $.messager.alert('请选择部门！', '选定后增加所选部门子部门！', 'warning');
        //     } else if (rows.length == 1) {
        //         $('#orgbrow_add').form('load', {add_bm_name: '', add_z1_name: '', add_z2_name: ''}).dialog('open');
        //     }
        // },
        reload: function () {
            $('#vorg').treegrid('reload');
        },
        remove : function () {
            var rows = $('#vorg').datagrid('getSelections');
            if (rows.length = 1) {
                $.messager.confirm('确定操作', '您要删除所选的记录吗？', function (flag) {
                    if (flag) {
                        // var ids = [];
                        // for (var i = 0; i < rows.length; i ++) {
                        //     ids.push(rows[i].id);
                        // }
                        $.ajax({
                            type : 'POST',
                            url : 'del_select_dept',
                            data : {
                                // ids:ids,
                                ids:rows[0].id,
                            },
                            beforeSend : function () {
                                $('#vorg').treegrid('loading');
                            },
                            success : function (data) {
                                $.messager.progress('close');
                                if (data>0) {
                                    $('#vorg').treegrid('load');
                                    $('#vorg').treegrid('unselectAll');
                                    $.messager.show({
                                        title : '提示',
                                        msg : data + '个部门被删除成功！',
                                    });
                                }else{
                                    if (data==-1){
                                        $.messager.alert('错误！', '删除不成功，还有子部门！', 'warning');
                                    }
                                    if (data==-2){
                                        $.messager.alert('错误！', '删除不成功，部门还有人员！', 'warning');
                                    }
                                    if (data==-3){
                                        $.messager.alert('错误！', '删除不成功，不能删除根部门，只能修改！', 'warning');
                                    }
                                    if (data!=-1&&data!=-2&&data!=-3){
                                        $.messager.alert('错误！', '删除不成功，请稍后再试！', 'warning');
                                    }

                                    $('#vorg').treegrid('reload');
                                }
                            },
                        });
                    }
                });
            } else {
                $.messager.alert('提示', '请选择要删除的部门！', 'info');
            }
        },
        edit : function () {
            var rows = $('#vorg').datagrid('getSelections');
            if (rows.length != 1) {
                $.messager.alert('警告操作！', '编辑记录只能选定一条数据！', 'warning');
            } else if (rows.length == 1) {
                $.ajax({
                    url:'get_dept_byid',
                    type:'post',
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
                            // console.log(data[0].org_name);
                           $('#orgbrow_edit').form('load', {
                               edit_bm_id:data[0].id,
                               edit_bm_name:data[0].org_name,
                               edit_z1_name:data[0].org_leading1,
                               edit_z2_name:data[0].org_leading2,
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

    function getdate(){
        $curr_time=new Date();
        $y1=$curr_time.getFullYear();
        $m1=$curr_time.getMonth()+1;
        if($m1>=0 && $m1<=9){
            $m1='0'+$m1;
        }
        $d1=$curr_time.getDate();
        $spe='-';
        return $y1+$spe+$m1+$spe+$d1;
    }

});
