$(function () {
    // $('#yfqx_add_name').validatebox({
    //     required:true,
    //     missingMessage:'请输入用户显示名称',
    //     invalidMessage:'用户名称不得为空',
    // });
    //
    // $('#yfqx_add_login_name').validatebox({
    //     required:true,
    //     missingMessage:'请输入用户登录名称',
    //     invalidMessage:'用户登录名称不得为空',
    // });
    //
    // $('#yfqx_add_user_pass').validatebox({
    //     required:true,
    //     validtype:'length[8,15]',
    //     missingMessage:'用户密码8-15位',
    //     invalidMessage:'密码不得为空',
    // });
    //
    // $('#yfqx_edit_name').validatebox({
    //     required:true,
    //     missingMessage:'请输入用户显示名称',
    //     invalidMessage:'用户名称不得为空',
    // });
    //
    // $('#yfqx_edit_login_name').validatebox({
    //     required:true,
    //     missingMessage:'请输入用户登录名称',
    //     invalidMessage:'用户登录名称不得为空',
    // });
    //
    // $('#yfqx_edit_user_pass').validatebox({
    //     // required:true,
    //     validtype:'length[8,15]',
    //     missingMessage:'用户密码8-15位或为空不修改',
    //     invalidMessage:'用户密码8-15位或为空不修改',
    // });

    // $('#dg').datagrid({
    //     url:'ipinfo?info='+$('#info2').val(),
    //     fit : true,
    //     fitColumns : true,
    //     striped : true,
    //     rownumbers : true,
    //     border : true,
    //     pagination : true,
    //     pageSize : 15,
    //     pageList : [15, 30, 45, 60, 75],
    //     pageNumber : 1,
    //     sortName : 'iplan',
    //     sortOrder : 'asc',
    //     // toolbar : '#manager_tool',
    //     // selectOnCheck:false,
    //     // checkOnSelect:false,
    //     columns : [[
    //
    //         {field:'za',title:'資安'+$('#info2').value,formatter:function(value,row,index){
    //             if(value==1){
    //                 return '<input type="checkbox" name="DataGridCheckbox" checked="checked">';
    //             }
    //             else{
    //                 return '<input type="checkbox" name="DataGridCheckbox">';
    //             }
    //         }},
    //
    //         // {
    //         //     field : 'za',
    //         //     title : '資安',
    //         //     checkbox:true,
    //         // },
    //         {
    //             field : 'cname1',
    //             title : '名称1',
    //             width :40,
    //         },
    //         {
    //             field : 'cname2',
    //             title : '名称2',
    //             width : 40,
    //         },
    //         {
    //             field : 'username',
    //             title : '使用人',
    //             width : 70,
    //         },
    //         {
    //             field : 'iplan',
    //             title : '有线',
    //             width : 40,
    //         },
    //         {
    //             field : 'lmac',
    //             title : '有线MAC',
    //             width : 60,
    //         },
    //         {
    //             field : 'ipwlan',
    //             title : '无线',
    //             width : 40,
    //         },
    //         {
    //             field : 'wmac',
    //             title : '无线mac',
    //             width : 60,
    //         },
    //         {
    //             field : 'comment',
    //             title : '备注',
    //             width : 100,
    //         },
    //     ]],
    //     rowStyler:function(index,row){
    //         if (row.status=='LZ'){
    //             return 'color:red;font-weight:bold;';
    //             // return 'background-color:pink;color:blue;font-weight:bold;';
    //         }
    //     },
    //     onLoadSuccess: function (data) {
    //         for (var i = 0; i < data.rows.length; i++) {
    //             //禁用checkbox
    //             $(".datagrid-row[datagrid-row-index=" + i + "] input[type='checkbox']")[0].disabled = true;
    //         }
    //     }
    // });


    $('#sslist').tree({
        url:'get_sslist',
        type:'post',
        fit:true,
        onLoadSuccess: function (node, data) {
            if($.isEmptyObject(node)){

            }else{
               if(node.text=='增你强宿舍'){
                   $('#sslist').tree('select', node.target);
               }
            }
            if (data) {
                    $(data).each(function (index, value) {
                    if (this.state == 'closed') {
                        $('#sslist').tree('expandAll');
                    }
                });
            }
        },
        onSelect:function (node) {
            // console.log(node.id);
            $.ajax({
                url: 'getss',
                type: 'post',
                data: {
                    id: node.id
                },
                success: function (data, response, status) {
                    var obj=$.parseJSON(data);

                    $('#ssdet').form('load', {
                        jc:obj[0].jc,
                        address:obj[0].address,
                        lxr:obj[0].lxr,
                        qzrq:obj[0].qzrq,
                        lxrdh:obj[0].lxrdh,
                        zq:obj[0].zq,
                        isp:obj[0].isp,
                        isp_regster:obj[0].isp_regster,
                        ispwxr:obj[0].ispwxr,
                        isp_acc:obj[0].isp_acc,
                        isp_pwd:obj[0].isp_pwd,
                        bz:obj[0].bz,
                        kdje:obj[0].kdje,
                        kdzs:obj[0].kdzs,
                        isp_qzrq:obj[0].isp_qzrq,
                        nid:1,
                        state:'open',
                        sstype:1,
                        ssid:node.id
                    });
                }
            });
        }
});

    $('#savebtn').linkbutton({
        iconCls: 'icon-save',
        onClick:function () {
              $.ajax({
                   url:'savess',
                  type:'post',
                  data:{
                      jc:$('input[name="jc"]').val(),
                      address:$('input[name="address"]').val(),
                      lxr:$('input[name="lxr"]').val(),
                      lxrdh:$('input[name="lxrdh"]').val(),
                      qzrq:$('input[name="qzrq"]').val(),
                      zq:$('input[name="zq"]').val(),
                      isp:$('input[name="isp"]').val(),
                      isp_regster:$('input[name="isp_regster"]').val(),
                      ispwxr:$('input[name="ispwxr"]').val(),
                      isp_acc:$('input[name="isp_acc"]').val(),
                      isp_pwd:$('input[name="isp_pwd"]').val(),
                      sstype:$('input[name="sstype"]').val(),
                      ssid:$('input[name="ssid"]').val(),
                      kdje:$('input[name="kdje"]').val(),
                      kdzs:$('input[name="kdzs"]').val(),
                      bz:$('#ssbz').val(),
                      isp_qzrq:$('input[name="isp_qzrq"]').val(),
                      nid:1,
                      state:'open'
                  },
                  success : function (data, response, status) {
                      $.messager.show({
                          title : '提示',
                          msg : '變動宿舍資 料成功！',
                      });
                      $('#sslist').tree('reload');
                  }
            });
        }
    });

    $('#ssglbox').menu({
        onClick : function (item) {
            switch(item.text){
                case '增加宿舍':
                     $('#ssdet').form('load', {
                             jc:"新宿舍",
                             address:" ",
                             lxr:' ',
                             qzrq:' ',
                             lxrdh:' ',
                             zq:' ',
                             isp:' ',
                             isp_regster:' ',
                             ispwxr:' ',
                             isp_acc:' ',
                             isp_pwd:' ',
                             bz:' ',
                             kdje:' ',
                             kdzs:' ',
                             isp_qzrq:' ',
                             sstype:0,
                             nid:1,
                             state:'open'
                     });
                    break;
                case '刪除宿舍':
                     $chosetext=$('#sslist').tree('getSelected').text;
                    $cid=$('#sslist').tree('getSelected').id;
                    if ($cid==1){
                        $.messager.show({
                            title : '提示',
                            msg : '根結點不能刪除！',
                        });
                        return 0;
                    }
                     $.messager.confirm('確認', '確定要刪除宿舍:'+$chosetext+'記錄?', function(r){
                        	if (r){
                                $cid=$('#sslist').tree('getSelected').id;
                                $.ajax({
                                    url:'delss',
                                    type:'post',
                                    data:{
                                        id:$cid,
                                    },
                                    success : function (data, response, status) {
                                        $.messager.show({
                                            title : '提示',
                                            msg : '刪除宿舍資料成功！',
                                        });
                                        $('#sslist').tree('reload');
                                    }
                                });
                            	}
                        });
                    break;
            }
        },
    });
});
