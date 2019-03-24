$(function () {

    $('#yfqx_add_name').validatebox({
        required:true,
        missingMessage:'请输入用户显示名称',
        invalidMessage:'用户名称不得为空',
    });

    $('#yfqx_add_login_name').validatebox({
        required:true,
        missingMessage:'请输入用户登录名称',
        invalidMessage:'用户登录名称不得为空',
    });

    $('#yfqx_add_user_pass').validatebox({
        required:true,
        validtype:'length[8,15]',
        missingMessage:'用户密码8-15位',
        invalidMessage:'密码不得为空',
    });

    $('#yfqx_edit_name').validatebox({
        required:true,
        missingMessage:'请输入用户显示名称',
        invalidMessage:'用户名称不得为空',
    });

    $('#yfqx_edit_login_name').validatebox({
        required:true,
        missingMessage:'请输入用户登录名称',
        invalidMessage:'用户登录名称不得为空',
    });

    $('#yfqx_edit_user_pass').validatebox({
        // required:true,
        validtype:'length[8,15]',
        missingMessage:'用户密码8-15位或为空不修改',
        invalidMessage:'用户密码8-15位或为空不修改',
    });

    $('#vemployee').tree({
        url:'get_dept2',
        type:'post',
        fit:true,
        onLoadSuccess: function (node, data) {
            if($.isEmptyObject(node)){

            }else{
               if(node.text=='增你强'){
                   $('#vemployee').tree('select', node.target);
               }
            }
            if (data) {
                    $(data).each(function (index, value) {
                    if (this.state == 'closed') {
                        $('#vemployee').tree('expandAll');
                    }
                });
            }
        },
        onSelect:function (node) {
            // console.log(node.id);
            $('#userbrow').datagrid('load',{dept_id: node.id});
        },
});


    $('#userbrow').datagrid({
        url:'get_userbrow',
        fit : true,
        fitColumns : true,
        striped : true,
        rownumbers : true,
        border : true,
        pagination : true,
        pageSize : 15,
        pageList : [15, 30, 45, 60, 75],
        pageNumber : 1,
        // sortName : 'iplan',
        // sortOrder : 'asc',
        toolbar : '#userbrow_tool2',
        columns : [[
            {
                field : 'name',
                title : '姓名',
                width :25,
            },
            {
                field : 'js_auth',
                title : '角色',
                width :25,
            },
            {
                field : 'login_name',
                title : '登录名称',
                width : 30,
            },
            {
                field : 'auth',
                title : '权限',
                width : 100,
            },
            {
                field : 'comment',
                title : '备注',
                width : 25,
            },
            {
                field : 'entry_time',
                title : '修改时间',
                width : 30,
            },
        ]],
    });



    $('#mauth5_add').dialog({
        width: 420,
        title: '新增用户',
        modal: true,
        closed : true,
        iconCls : 'icon-user-add',
        buttons : [{
            text : '提交',
            iconCls : 'icon-add-new',
            handler : function () {
                if ($('#mauth5_add').form('validate')) {
                    var node=$('#vemployee').tree('getSelected');
                    // console.log(node.id);
                    $.ajax({
                        url : 'yfqx_add',
                        data : {
                            type : 'post',
                            name:$('input[name="yfqx_add_name"]').val(),
                            login_name:$('input[name="yfqx_add_login_name"]').val(),
                            comment:$('input[name="yfqx_add_comment"]').val(),
                            user_pass:$('input[name="yfqx_add_user_pass"]').val(),
                            auth:$('#yfqx_add_auth').combotree('getText'),
                            js_auth:$('#yfqx_add_js').combogrid('getText'),

                            dept_id:node.id,
                            entry_time:getdate(),
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
                                $('#mauth5_add').dialog('close').form('reset');
                                $('#userbrow').datagrid('reload');
                            } else {
                                if(data==-3) {
                                    $.messager.alert('新增失败！', '登录帐号已经存在，请重试！', 'warning');
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
                $('#mauth5_add').dialog('close').form('reset');
            },
        }],
    });

    $('#mauth5_edit').dialog({
        width : 420,
        title : '修改用户权限',
        modal : true,
        closed : true,
        iconCls : 'icon-user-add',
        buttons : [{
            text : '提交',
            iconCls : 'icon-edit-new',
            handler : function () {
                if ($('#mauth5_edit').form('validate')) {
                    $.ajax({
                        url: 'yfqx_edit_update',
                        type: 'post',
                        data: {
                            id: $('input[name="yfqx_edit_id"]').val(),
                            name: $('input[name="yfqx_edit_name"]').val(),
                            login_name: $('input[name="yfqx_edit_login_name"]').val(),
                            dept_id: $('input[name="yfqx_edit_dept_id"]').val(),
                            comment: $('input[name="yfqx_edit_comment"]').val(),
                            auth: $('#yfqx_edit_auth_combotree').combotree('getText'),
                            user_pass: $('input[name="yfqx_edit_user_pass"]').val(),
                            js_auth: $('#yfqx_edit_js').combogrid('getText'),
                            entry_time: getdate(),
                        },
                        beforeSend: function () {
                            $.messager.progress({
                                text: '正在修改中...',
                            });
                        },
                        success: function (data, response, status) {
                            $.messager.progress('close');
                            if (data > 0) {
                                $.messager.show({
                                    title: '提示',
                                    msg: '修改成功',
                                });
                                $('#mauth5_edit').dialog('close').form('reset');
                                $('#userbrow').datagrid('reload');
                            } else {
                                if (data == -3) {
                                    $.messager.alert('修改失败！', '登录帐号已经存在，请重试！', 'warning');
                                } else if (data == -2) {
                                    $.messager.alert('修改失败！', '密码长度需大于8位！', 'warning');
                                }
                                if (data != -3 && data != -2) {
                                    $.messager.alert('修改失败！', '未知错误导致失败，请重试！', 'warning');
                                }
                            }
                        }
                    });
                }
            },
        }, {
            text: '取消',
            iconCls: 'icon-redo',
            handler: function () {
                $('#mauth5_edit').dialog('close').form('reset');
            },

        }],
    });




    brow_tool2 = {
        add2 : function () {
            $('#mauth5_add').form('load',{yfqx_add_js:'',yfqx_add_name:'',yfqx_add_login_name:'',yfqx_add_comment:'',yfqx_add_user_pass:'',yfqx_add_auth:'',field:'id',title:'编号'}).dialog('open');
        },
        reload2 : function () {
            $('#userbrow').datagrid('reload');
        },
        remove2 : function () {
            var rows = $('#userbrow').datagrid('getSelections');
            if (rows.length > 0) {
                $.messager.confirm('确定操作', '您要删除所选的记录吗？', function (flag) {
                    if (flag) {
                        var ids = [];
                        for (var i = 0; i < rows.length; i ++) {
                            ids.push(rows[i].id);
                        }
                        $.ajax({
                            type : 'POST',
                            url : 'del_yfqx_user',
                            data : {
                                ids:ids,
                            },
                            beforeSend : function () {
                                $('#userbrow').datagrid('loading');
                            },
                            success : function (data) {
                                if (data) {
                                    // $('#userbrow').datagrid('loaded');
                                    $('#userbrow').datagrid('load');
                                    $('#userbrow').datagrid('unselectAll');
                                    $.messager.show({
                                        title : '提示',
                                        msg : data + '个用户被删除成功！',
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
        edit2 : function () {
            //$('#yfqx_edit_js').innerHTML=" ";
            var rows = $('#userbrow').datagrid('getSelections');
            if (rows.length > 1) {
                $.messager.alert('警告操作！', '编辑记录只能选定一条数据！', 'warning');
            } else if (rows.length == 1) {
                $.ajax({
                    // url : 'employee/'+rows[0].id+'/edit',
                    url:'get_employee_byid',
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

                            var obj=$.parseJSON(data);
                            var fyfqx_edit_auth=obj[0].auth.split(',');
                            var fyfqx_edit_jsauth=obj[0].js_auth.split(',');
                            // console.log(obj[0].name);
                           $('#mauth5_edit').form('load', {
                                yfqx_edit_id:obj[0].id,
                                yfqx_edit_name:obj[0].name,
                                yfqx_edit_login_name:obj[0].login_name,
                                yfqx_edit_comment:obj[0].comment,
                                yfqx_edit_user_pass:'',
                                yfqx_edit_js:obj[0].js_auth,
                                yfqx_edit_dept_id:obj[0].dept_id,
                                yfqx_edit_entry_date:getdate(),
                            }).dialog('open');

                            $('#yfqx_edit_auth_combotree').combotree({
                                url : 'get_auth',
                                // required : true,
                                lines : true,
                                multiple : true,
                                checkbox : true,
                                onlyLeafCheck : true,
                                // fit:true,
                                onLoadSuccess : function (node, data) {
                                    // var ft=$('#yfqx_edit_auth_combotree').combotree('tree');
                                    var _this = this;
                                    if (data) {
                                        $(data).each(function (index, value) {
                                            if ($.inArray(value.text,fyfqx_edit_auth)!=-1){

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

                            $('#yfqx_edit_js').combogrid({
                                // loadmsg:'数据加载中。。。',
                                url:'getuser_js',
                                idField:'js_name',
                                texField:'js_name',
                                multiple:true,
                                panelwidth:200,
                                fitColumns:true,
                                // method: 'get',
                                columns:[[
                                    {
                                        field:'id',
                                        title:'编号',
                                        width:40,
                                        checkbox:true,
                                    },
                                    {
                                        field:'js_name',
                                        title:'角色名称',
                                        width:160,
                                    }
                                ]],
                              onLoadSuccess : function (data) {
                                   var _this=this;
                                       //console.log(_this);
                                   
                                    if (data){

                                        var arr = [];
                                         for (var i in data) {
                                              arr.push(data[i]); //属性

                                         }



                                         $.each(arr[1],function (index, value){
                                                if ($.inArray(value.js_name,fyfqx_edit_jsauth)!=-1){
                                                      //  console.log(index);
                                                     $(_this).datagrid("selectRow", index);
                                                            
                 
                                                 }
                                         });                                          
                                        
                                    }


                               }
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


    $('#yfqx_add_auth').combotree({
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

    $('#yfqx_add_js').combogrid({
        // loadmsg:'数据加载中。。。',
        url:'getuser_js',
        idField:'js_name',
        texField:'js_name',
        multiple:true,
        panelwidth:200,
        fitColumns:true,
        // method: 'get',
        columns:[[
            {
                field:'id',
                title:'编号',
                width:40,
                checkbox:true,
            },
            {
                field:'js_name',
                title:'角色名称',
                width:160,
            }
        ]]
    });


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
