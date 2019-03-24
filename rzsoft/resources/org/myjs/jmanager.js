$(function () {

    obj = {
        search : function () {
               $('#ipmanager').datagrid('load', {
                username : $.trim($('input[name="username"]').val()),
                cname1 : $.trim($('input[name="cname1"]').val()),
                   iplan : $.trim($('input[name="iplan"]').val()),
                   ipwlan : $.trim($('input[name="ipwlan"]').val()),
                   lmac : $.trim($('input[name="lmac"]').val()),
                   wmac : $.trim($('input[name="wmac"]').val()),
                date_from : $('input[name="date_from"]').val(),
                date_to : $('input[name="date_to"]').val(),
                   status : $('input[name="iplz"]').val(),
                   za : $('input[name="ipza"]').val(),
                   comment : $.trim($('input[name="ipbz"]').val()),
            });
        },
    };


    // $(document).on('contextmenu', function (e) {
    //     e.preventDefault();
    //     $('#ipbox').menu('show', {
    //         left : e.pageX,
    //         top : e.pageY,
    //     });
    // });

    $('#ipbox').menu({
        /*
         onShow : function () {
         alert('显示时触发！');
         },
         onHide : function () {
         alert('隐藏时触发！');
         },
         */
        onClick : function (item) {
           switch(item.text){
               case '資安已加載':
                   var rows = $('#ipmanager').datagrid('getSelections');
                   if (rows.length !=1) {
                       $.messager.alert('警告操作！', '更新IP只能选定一条数据！', 'warning');
                   } else if (rows.length == 1) {
                       $.ajax({
                           url: 'bjza',
                           type: 'post',
                           data: {
                               id: rows[0].id,
                           },
                           beforeSend: function () {
                               $.messager.progress({
                                   text: '正在处理中...',
                               });
                           },
                           success: function (data, response, status) {
                               $.messager.progress('close');
                               if (data) {
                                   $('#ipmanager').datagrid('reload');
                                   $.messager.show({
                                       title : '提示',
                                       msg : '标记为資安已加載成功',
                                   });

                               }
                           }
                       });
                   }
                   break;
               case '資安已清除':
                   var rows = $('#ipmanager').datagrid('getSelections');
                   if (rows.length !=1) {
                       $.messager.alert('警告操作！', '更新IP只能选定一条数据！', 'warning');
                   } else if (rows.length == 1) {
                       $.ajax({
                           url: 'qcza',
                           type: 'post',
                           data: {
                               id: rows[0].id,
                           },
                           beforeSend: function () {
                               $.messager.progress({
                                   text: '正在处理中...',
                               });
                           },
                           success: function (data, response, status) {
                               $.messager.progress('close');
                               if (data) {
                                   $('#ipmanager').datagrid('reload');
                                   $.messager.show({
                                       title : '提示',
                                       msg : '标记为資安已清除成功',
                                   });

                               }
                           }
                       });
                   }
                   break;
               case '标记为离职':
                   var rows = $('#ipmanager').datagrid('getSelections');
                   if (rows.length !=1) {
                       $.messager.alert('警告操作！', '更新IP只能选定一条数据！', 'warning');
                   } else if (rows.length == 1) {
                       $.ajax({
                           url: 'bjlz',
                           type: 'post',
                           data: {
                               id: rows[0].id,
                           },
                           beforeSend: function () {
                               $.messager.progress({
                                   text: '正在处理中...',
                               });
                           },
                           success: function (data, response, status) {
                               $.messager.progress('close');
                               if (data) {
                                   $('#ipmanager').datagrid('reload');
                                   $.messager.show({
                                       title : '提示',
                                       msg : '标记为离职成功',
                                   });

                               }
                           }
                       });
                   }
                   break;
               case '标记为在职':
                   var rows = $('#ipmanager').datagrid('getSelections');
                   if (rows.length !=1) {
                       $.messager.alert('警告操作！', '更新IP只能选定一条数据！', 'warning');
                   } else if (rows.length == 1) {
                       $.ajax({
                           url: 'bjzz',
                           type: 'post',
                           data: {
                               id: rows[0].id,
                           },
                           beforeSend: function () {
                               $.messager.progress({
                                   text: '正在处理中...',
                               });
                           },
                           success: function (data, response, status) {
                               $.messager.progress('close');
                               if (data) {
                                   $('#ipmanager').datagrid('reload');
                                   $.messager.show({
                                       title : '提示',
                                       msg : '标记为离职成功',
                                   });

                               }
                           }
                       });
                   }
                   break;
               // case '绑定IP':
               //     break;
               // case '解绑IP':
               //     break;
               // default:
               //     alert('abc');
           }
        }
    });

    $('#ipmanager').datagrid({
        url:'getipmanager_data',
        fit : true,
        fitColumns : true,
        striped : true,
        rownumbers : true,
        border : true,
        pagination : true,
        pageSize : 15,
        pageList : [15, 30, 45, 60, 75],
        pageNumber : 1,
        sortName : 'iplan',
        sortOrder : 'asc',
        toolbar : '#manager_tool',
        // selectOnCheck:false,
        // checkOnSelect:false,
        columns : [[

            {field:'za',title:'資安',formatter:function(value,row,index){
                if(value==1){
                    return '<input type="checkbox" name="DataGridCheckbox" checked="checked">';
                    }
                else{
                    return '<input type="checkbox" name="DataGridCheckbox">';
                    }
                }},

            // {
            //     field : 'za',
            //     title : '資安',
            //     checkbox:true,
            // },
            {
                field : 'cname1',
                title : '名称1',
                width :40,
            },
            {
                field : 'cname2',
                title : '名称2',
                width : 40,
            },
            {
                field : 'username',
                title : '使用人',
                width : 70,
            },
            {
                field : 'iplan',
                title : '有线',
                width : 40,
            },
            {
                field : 'lmac',
                title : '有线MAC',
                width : 60,
            },
            {
                field : 'ipwlan',
                title : '无线',
                width : 40,
            },
            {
                field : 'wmac',
                title : '无线mac',
                width : 60,
            },
            {
                field : 'comment',
                title : '备注',
                width : 100,
            },
        ]],
        rowStyler:function(index,row){
            if (row.status=='LZ'){
                return 'color:red;font-weight:bold;';
                // return 'background-color:pink;color:blue;font-weight:bold;';
            }
        },
        onLoadSuccess: function (data) {
            for (var i = 0; i < data.rows.length; i++) {
                    //禁用checkbox
                    $(".datagrid-row[datagrid-row-index=" + i + "] input[type='checkbox']")[0].disabled = true;
            }
        }
});

    $('#cdhcp').dialog({
        width :420,
        title :'更新DHCP中IP',
        modal : true,
        closed : true,
        iconCls : 'icon-user-add',
        buttons : [{
            text : '更新LAN',
            iconCls : 'icon-add-new',
            handler : function () {
                if ($('#cdhcp').form('validate')) {
                    $.ajax({
                        url : 'updatedhcp',
                        type : 'post',
                        data : {
                            username:$('input[name="username3"]').val(),
                            cname1:$('input[name="cname3"]').val(),
                            iplan:$('input[name="iplan3"]').val(),
                            lmac:$('input[name="lmac3"]').val(),
                            ipwlan:$('input[name="ipwlan3"]').val(),
                            wmac:$('input[name="wmac3"]').val(),
                            serverip:$('input[name="serverip"]').val(),
                            UPTYPE:0,
                        },
                        beforeSend : function () {
                            $.messager.progress({
                                text : '正在更新IP中...',
                            });
                        },
                        success : function (data, response, status) {
                            $.messager.progress('close');
                            if (data > 0) {
                                    $.messager.show({
                                    title : '提示',
                                    msg : '更新DHCP成功',
                                });
                                $('#cdhcp').dialog('close').form('reset');
                                $('#ipmanager').datagrid('reload');
                            } else {
                                $.messager.alert('更新DHCP失败！', '请手工检查后，请重试！', 'warning');
                            }
                        }
                    });
                }
            },
        },
            {  text : '更新WLAN',
        iconCls : 'icon-add-new',
        handler : function () {
        if ($('#cdhcp').form('validate')) {
            $.ajax({
                url : 'updatedhcp',
                type : 'post',
                data : {
                    username:$('input[name="username3"]').val(),
                    cname1:$('input[name="cname3"]').val(),
                    iplan:$('input[name="iplan3"]').val(),
                    lmac:$('input[name="lmac3"]').val(),
                    ipwlan:$('input[name="ipwlan3"]').val(),
                    wmac:$('input[name="wmac3"]').val(),
                    serverip:$('input[name="serverip"]').val(),
                    UPTYPE:1,
                },
                beforeSend : function () {
                    $.messager.progress({
                        text : '正在更新IP中...',
                    });
                },
                success : function (data, response, status) {
                    $.messager.progress('close');
                    if (data > 0) {
                        $.messager.show({
                            title : '提示',
                            msg : '更新DHCP成功',
                        });
                        $('#cdhcp').dialog('close').form('reset');
                        $('#ipmanager').datagrid('reload');
                    } else {
                        $.messager.alert('更新DHCP失败！', '请手工检查后，请重试！', 'warning');
                    }
                }
            });
        }
    },
},
            {
            text : '取消',
            iconCls : 'icon-redo',
            handler : function () {
                $('#cdhcp').dialog('close').form('reset');
            },
        }],
    });


    $('#deldhcpf').dialog({
        width :420,
        title :'解除IP綁定P',
        modal : true,
        closed : true,
        iconCls : 'icon-user-add',
        buttons : [{
            text : '解除有线',
            iconCls : 'icon-add-new',
            handler : function () {
                if ($('#deldhcpf').form('validate')) {
                    $.ajax({
                        url : 'deldhcp1',
                        type : 'post',
                        data : {
                            username:$('input[name="username5"]').val(),
                            cname1:$('input[name="cname5"]').val(),
                            iplan:$('input[name="iplan5"]').val(),
                            lmac:$('input[name="lmac5"]').val(),
                            ipwlan:$('input[name="ipwlan5"]').val(),
                            wmac:$('input[name="wmac5"]').val(),
                            serverip:$('input[name="serverip1"]').val(),
                            UPTYPE:0,
                        },
                        beforeSend : function () {
                            $.messager.progress({
                                text : '正在更新IP中...',
                            });
                        },
                        success : function (data, response, status) {
                            $.messager.progress('close');
                            if (data > 0) {
                                $.messager.show({
                                    title : '提示',
                                    msg : '解除DHCP绑定成功',
                                });
                                $('#deldhcpf').dialog('close').form('reset');
                                $('#ipmanager').datagrid('reload');
                            } else {
                                $.messager.alert('解除DHCP绑定失败！', '请手工检查后，请重试！', 'warning');
                            }
                        }
                    });
                }
            },
        },
            {  text : '解除无线',
                iconCls : 'icon-add-new',
                handler : function () {
                    if ($('#deldhcpf').form('validate')) {
                        $.ajax({
                            url : 'deldhcp1',
                            type : 'post',
                            data : {
                                username:$('input[name="username5"]').val(),
                                cname1:$('input[name="cname5"]').val(),
                                iplan:$('input[name="iplan5"]').val(),
                                lmac:$('input[name="lmac5"]').val(),
                                ipwlan:$('input[name="ipwlan5"]').val(),
                                wmac:$('input[name="wmac5"]').val(),
                                serverip:$('input[name="serverip1"]').val(),
                                UPTYPE:1,
                            },
                            beforeSend : function () {
                                $.messager.progress({
                                    text : '正在更新IP中...',
                                });
                            },
                            success : function (data, response, status) {
                                $.messager.progress('close');
                                if (data > 0) {
                                    $.messager.show({
                                        title : '提示',
                                        msg : '解除DHCP绑定成功',
                                    });
                                    $('#deldhcpf').dialog('close').form('reset');
                                    $('#ipmanager').datagrid('reload');
                                } else {
                                    $.messager.alert('解除DHCP绑定失败！', '请手工检查后，请重试！', 'warning');
                                }
                            }
                        });
                    }
                },
            },
            {
                text : '取消',
                iconCls : 'icon-redo',
                handler : function () {
                    $('#deldhcpf').dialog('close').form('reset');
                },
            }],
    });


    $('#ipmanager_add').dialog({
        width : 420,
        title : '新增电脑',
        modal : true,
        closed : true,
        iconCls : 'icon-user-add',
        buttons : [{
            text : '提交',
            iconCls : 'icon-add-new',
            handler : function () {
                if ($('#ipmanager_add').form('validate')) {
                    $.ajax({
                        url : 'iptable',
                        type : 'post',
                        data : {
                            username:$('input[name="username1"]').val(),
                            cname1:$('input[name="cname11"]').val(),
                            cname2:$('input[name="cname21"]').val(),
                            iplan:$('input[name="iplan1"]').val(),
                            lmac:$('input[name="lmac1"]').val(),
                            ipwlan:$('input[name="ipwlan1"]').val(),
                            wmac:$('input[name="wmac1"]').val(),
                            comment:$('input[name="comment1"]').val(),
                            za:1,
                            lastdate:getdate(),
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
                                    msg : '新增电脑成功',
                                });
                                $('#ipmanager_add').dialog('close').form('reset');
                                $('#ipmanager').datagrid('reload');

                                // $('#fwd').combobox({
                                //     url : 'getnewip/'+$('#fwd').combobox('getText'),
                                //     type:'get',
                                //     onChange: function (newv, oldv) {
                                //
                                //            alert('ok');
                                //     // onLoadSuccess : function (node, data) {
                                //
                                //
                                //             if($fwd==20 || $fwd==21 || $fwd==26){
                                //                 $('#iplan1').html('10.3.20.'+newv);
                                //             }else{
                                //                 $('#ipwlan1').html('10.3.20.'+newv);
                                //             }
                                //
                                //
                                //     },
                                // });



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
                $('#ipmanager_add').dialog('close').form('reset');
            },
        }],
    });


    $('#fwd').combobox({
    onChange: function (newv,oldv) {
                if(newv==20 || newv==21 || newv==26){
                    $.get('getnewip/'+newv,function (result) {
                        document.getElementById('Aiplan1').value ='10.3.'+newv+'.'+result;
                    });
                }else{
                    $.get('getnewip/'+newv,function (result) {
                        document.getElementById('ipwlan1').value ='10.3.'+newv+'.'+result;
                    });
                }
            }
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

    //管理帐号
    $('input[name="manager"]').validatebox({
        required : true,
        validType : 'length[2,20]',
        missingMessage : '请输入管理名称',
        invalidMessage : '管理名称在 2-20 位',
    });

    //管理密码
    $('input[name="password"]').validatebox({
        required : true,
        validType : 'length[6,30]',
        missingMessage : '请输入管理密码',
        invalidMessage : '管理密码在 6-30 位',
    });

    //修改管理密码
    $('input[name="password_edit"]').validatebox({
        //required : true,
        validType : 'length[6,30]',
        missingMessage : '请输入管理密码',
        invalidMessage : '管理密码在 6-30 位',
    });

    // //分配权限
    // $('#auth').combotree({
    //     url : 'getnav',
    //     required : true,
    //     lines : true,
    //     multiple : true,
    //     checkbox : true,
    //     onlyLeafCheck : true,
    //     onLoadSuccess : function (node, data) {
    //         var _this = this;
    //         if (data) {
    //             $(data).each(function (index, value) {
    //                 if (this.state == 'closed') {
    //                     $(_this).tree('expandAll');
    //                 }
    //             });
    //         }
    //     },
    // });


    ipmanager_tool = {
        reload : function () {
            // $('#ipmanager').datagrid('reload');

            $('#ipmanager').datagrid('load', {
                username : '',
                cname1 : '',
                iplan : '',
                ipwlan : '',
                lmac :'',
                wmac : '',
                date_from : '',
                date_to : '',
            });

        },
        redo : function () {
            $('#ipmanager').datagrid('unselectAll');
        },
        dhcp : function() {
            var rows = $('#ipmanager').datagrid('getSelections');
            // if (rows.length > 1 || rows.length==0) {
            if (rows.length !=1) {
                $.messager.alert('警告操作！', '更新IP只能选定一条数据！', 'warning');
            } else if (rows.length == 1) {

                $.ajax({
                    url: 'iptable/' + rows[0].id + '/edit',
                    type: 'get',
                    data: {
                        id: rows[0].id,
                    },
                    beforeSend: function () {
                        $.messager.progress({
                            text: '正在获取中...',
                        });
                    },
                    success: function (data, response, status) {
                        $.messager.progress('close');
                        if (data) {
                            $('#cdhcp').form('load', {
                                id3: data[0].id,
                                username3: data[0].username,
                                cname3: data[0].cname1,
                                iplan3: data[0].iplan,
                                ipwlan3: data[0].ipwlan,
                                lmac3: data[0].lmac,
                                wmac3: data[0].wmac,
                            }).dialog('open');
                            $('input[name="serverip"]').focus();
                        }
                    }
                });
            }
        },
        deldhcp : function() {
            var rows = $('#ipmanager').datagrid('getSelections');
            // if (rows.length > 1 || rows.length==0) {
            if (rows.length !=1) {
                $.messager.alert('警告操作！', '一次只能选定一条数据！', 'warning');
            } else if (rows.length == 1) {
                $.ajax({
                    url: 'iptable/' + rows[0].id + '/edit',
                    type: 'get',
                    data: {
                        id: rows[0].id,
                    },
                    beforeSend: function () {
                        $.messager.progress({
                            text: '正在获取中...',
                        });
                    },
                    success: function (data, response, status) {
                        $.messager.progress('close');
                        if (data) {
                            $('#deldhcpf').form('load', {
                                id3: data[0].id,
                                username5: data[0].username,
                                cname5: data[0].cname1,
                                iplan5: data[0].iplan,
                                ipwlan5: data[0].ipwlan,
                                lmac5: data[0].lmac,
                                wmac5: data[0].wmac,
                            }).dialog('open');
                            $('input[name="serverip1"]').focus();
                        }
                    }
                });
            }
        },
        add: function () {
            $.ajax({
                type: 'get',
                url: 'getnewip/20',
                // beforeSend: function () {
                //     $('#ipmanager').datagrid('loading');
                // },
                success: function (data) {
                    if (data) {
                        $('#ipmanager_add').form('load', {
                            iplan1: '10.3.20.'+data,
                            // ipwlan1: data[0].ipwlan,
                        }).dialog('open');
                    }
                }
            });
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

                            //分配权限
                            // $('#ipauth_edit').combotree({
                            //     url : 'getnav',
                            //     required : true,
                            //     lines : true,
                            //     multiple : true,
                            //     checkbox : true,
                            //     onlyLeafCheck : true,
                            //     onLoadSuccess : function (node, data) {
                            //         var _this = this;
                            //         if (data) {
                            //             $(data).each(function (index, value) {
                            //                 if ($.inArray(value.text, auth) != -1) {
                            //                     $(_this).tree('check', value.target);
                            //                 }
                            //                 if (this.state == 'closed') {
                            //                     $(_this).tree('expandAll');
                            //                 }
                            //             });
                            //         }
                            //     },
                            // });

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
