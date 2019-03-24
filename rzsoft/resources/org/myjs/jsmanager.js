$(function () {
      $('#jsmanager').datagrid({
        url:'get_jsdata',
        fit : true,
        fitColumns : true,
        striped : true,
        rownumbers : true,
        border : true,
        pagination : true,
        pageSize : 15,
        pageList : [15, 30, 45, 60, 75],
        pageNumber : 1,
        sortName : 'js_name',
        sortOrder : 'asc',
        toolbar : '#jsbrow_tool',
        columns : [[
            {
                field : 'js_name',
                title : '角色名称',
                width :45,
            },
            {
                field : 'js_auth',
                title : '权限',
                width : 250,
            },
        ]],
    });

    $('#group_add').dialog({
        width : 420,
        title : '新增角色',
        modal : true,
        closed : true,
        iconCls : 'icon-user-add',
        buttons : [{
            text : '提交',
            iconCls : 'icon-add-new',
            handler : function () {
                if ($('#group_add').form('validate')) {
                    $.ajax({
                        url : 'addgroup',
                        type : 'post',
                        data : {
                            js_name:$('input[name="add_group_name"]').val(),
                            // js_auth:$('input[name="add_group_auth"]').val(),
                            js_auth:$('#add_group_auth').combotree('getText'),
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
                                    msg : '新增角色成功',
                                });
                                $('#group_add').dialog('close').form('reset');
                                $('#jsmanager').datagrid('reload');
                            } else {
                                if (data==-3){
                                    $.messager.alert('新增失败！', '新增角色已经存在，请重试！', 'warning');
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
                $('#group_add').dialog('close').form('reset');
            },
        }],
    });

    $('#group_edit').dialog({
        width : 420,
        title : '修改角色权限',
        modal : true,
        closed : true,
        iconCls : 'icon-user-add',
        buttons : [{
            text : '提交',
            iconCls : 'icon-edit-new',
            handler : function () {
                if ($('#group_edit').form('validate')) {
                    $.ajax({
                        url : 'updategroup',
                        type : 'post',
                        data : {
                            id:$('input[name="edit_group_id"]').val(),
                            js_name:$('input[name="edit_group_name"]').val(),
                            js_auth:$('#edit_group_auth').combotree('getText'),
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
                                $('#group_edit').dialog('close').form('reset');
                                $('#jsmanager').datagrid('reload');
                            } else {
                                if (data==-3){
                                    $.messager.alert('新增失败！', '修改的角色已经存在，请重试！', 'warning');
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
                $('#group_edit').dialog('close').form('reset');
            },
        }],
    });

    $('input[name="add_group_name"]').validatebox({
        required : true,
        validType : 'length[2,20]',
        missingMessage : '请输入角色名称',
        invalidMessage : '角色名称2-20个汉字长度',
    });

    $('input[name="edit_group_name"]').validatebox({
        //required : true,
        validType : 'length[2,30]',
        missingMessage : '请输入角色名称',
        invalidMessage : '角色名称2-20个汉字长度',
    });

    jsbrow_tool = {
        reload : function () {
            $('#jsmanager').datagrid('reload');
        },
        // redo : function () {
        //     $('#jsmanager').datagrid('unselectAll');
        // },
        add : function () {
            $('#group_add').dialog('open');
            $('input[name="add_group_name"]').focus();
        },
        print:function () {
            var rows = $('#jsmanager').datagrid('getSelections');
    $.ajax({
        type: 'POST',
         dataType:'json',
        url: 'get_jsdata',
        success: function (data) {
            if (data) {
var LODOP=getCLodop();
LODOP.PRINT_INIT("打印功能演示");
LODOP.ADD_PRINT_SHAPE(4,134,65,121,33,0,1,"#C0C0C0");
LODOP.ADD_PRINT_TEXT(48,203,301,46,"角色權限清單及二維碼測試");
LODOP.SET_PRINT_STYLEA(0,"FontName","微軟正黑體");
LODOP.SET_PRINT_STYLEA(0,"FontSize",17);
LODOP.SET_PRINT_STYLEA(0,"Bold",1);
LODOP.ADD_PRINT_SHAPE(4,134,188,333,33,0,1,"#C0C0C0");

LODOP.ADD_PRINT_TEXT(138,78,100,25,"角色");
LODOP.SET_PRINT_STYLEA(0,"Alignment",2);
LODOP.ADD_PRINT_TEXT(137,281,100,25,"擁有權限");
LODOP.SET_PRINT_STYLEA(0,"Alignment",2);
LODOP.ADD_PRINT_TEXT(139,534,105,25,"二維碼");
LODOP.SET_PRINT_STYLEA(0,"Alignment",2);

                var aa=0;

                $.each(data,function (i,v) {
LODOP.ADD_PRINT_RECT(170+aa*109,65,585,107,0,1);
LODOP.ADD_PRINT_RECT(279+aa*109,65,585,107,0,1);
LODOP.ADD_PRINT_TEXT(204+aa*109,78,100,45,data[aa].js_name);
LODOP.SET_PRINT_STYLEA(0,"FontSize",13);
LODOP.ADD_PRINT_TEXT(203+aa*109,188,338,45,data[aa].js_auth);
LODOP.SET_PRINT_STYLEA(0,"FontSize",15);
LODOP.ADD_PRINT_RECT(182+aa*109,541,105,93,0,1);
LODOP.SET_PRINT_STYLEA(0,"HtmWaitMilSecs",1000);
LODOP.ADD_PRINT_BARCODE(184+aa*109,555,100,113,"QRCode",data[aa].js_name);
LODOP.SET_PRINT_STYLEA(0,"HtmWaitMilSecs",1000);


                 aa=aa+1;
              });
               LODOP.PREVIEW();

            }
        },
    });
},

        remove : function () {
            var rows = $('#jsmanager').datagrid('getSelections');
               if (rows.length > 0) {
                $.messager.confirm('确定操作', '您正在要删除所选的记录吗？', function (flag) {
                    if (flag) {
                        var ids = [];
                        for (var i = 0; i < rows.length; i ++) {
                            ids.push(rows[i].id);
                        }
                        $.ajax({
                            type : 'POST',
                            url : 'del_jsdata',
                            data : {
                                ids:ids,
                                //ids : ids.join(','),
                                // id:rows[0].id,
                            },
                            beforeSend : function () {
                                $('#jsmanager').datagrid('loading');
                            },
                            success : function (data) {
                                if (data) {
                                    $('#jsmanager').datagrid('loaded');
                                    $('#jsmanager').datagrid('load');
                                    $('#jsmanager').datagrid('unselectAll');
                                    $.messager.show({
                                        title : '提示',
                                        msg : data + '个角色被删除成功！',
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
            var rows = $('#jsmanager').datagrid('getSelections');
            if (rows.length > 1) {
                $.messager.alert('警告操作！', '编辑记录只能选定一条数据！', 'warning');
            } else if (rows.length == 1) {
                $.ajax({
                    url : 'get_group_byid',
                    type : 'post',
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
                        var obj=$.parseJSON(data);
                        var editjsauth=obj[0].js_auth.split(',');
                        if (data) {
                            $('#group_edit').form('load', {
                                edit_group_id:obj[0].id,
                                edit_group_name : obj[0].js_name,
                                // js_auth :$('#edit_group_auth').combotree('getText'),
                            }).dialog('open');

                            $('#edit_group_auth').combotree({
                                url : 'get_auth',
                                // required : true,
                                lines : true,
                                multiple : true,
                                checkbox : true,
                                onlyLeafCheck : true,
                                // fit:true,
                                onLoadSuccess : function (node, data) {
                                    var _this = this;
                                    if (data) {
                                        $(data).each(function (index, value) {
                                            if ($.inArray(value.text,editjsauth)!=-1){
                                                var fnode=$(_this).tree('find',value.id)
                                                if (fnode){
                                                    $(_this).tree('check',fnode.target);
                                                }
                                            }
                                            if (this.state == 'closed') {
                                                $(_this).tree('expandAll');
                                            }
                                        });
                                    }
                                },
                            });
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

    $('#add_group_auth').combotree({
        url : 'get_auth',
        // required : true,
        lines : true,
        multiple : true,
        checkbox : true,
        onlyLeafCheck : true,
        // fit:true,
        onLoadSuccess : function (node, data) {
            var _this = this;
            if (data) {
                $(data).each(function (index, value) {
                    if (this.state == 'closed') {
                        $(_this).tree('expandAll');
                    }
                });
            }
        },
    });
});
