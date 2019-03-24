$(function () {
    $.ajax({
        url: 'getmainbar',
        type: 'post',
        async: false,
        dataType: 'json',
        success: function (data) {
            $(data).each(function (i, item) {
                $('#main_accordion').accordion('add',
                    {
                        title: item.panel_title,
                        iconCls: item.iconCls,
                        id: 'p' + item.panel_id

                    }
                );
                $('#p' + item.panel_id).html('<ul id="ctrltree' + item.panel_id + '" style="margin-top: 5px;"></ul>');

                $('#ctrltree' + item.panel_id).tree({
                    url: 'getnav/'+item.panel_id+'/'+item.id,
                    type:'post',
                    // lines: true,
                    onLoadSuccess: function (node, data) {
                        if (data) {
                            $(data).each(function (index, value) {
                                if (this.state == 'closed') {
                                    $('#ctrltree' + item.panel_id).tree('expandAll');
                                }
                            });
                        }
                    },
                    onClick: function (node) {
                        if (node.url) {
                            if ($('#tabs').tabs('exists', node.text)) {
                                $('#tabs').tabs('select', node.text);
                            } else {
                               // var vid=$('#session_user').attr('value');
                                $.ajax({
                                   url:'get_auth4',
                                   type:'post',
                                   data:{
                                       session_user:$('#session_user').attr('value'),
                                       isdomain:$('#session_domain').attr('value'),
                                   },
                                   success:function(data){
                                       if (data.indexOf(node.text) > -1){
                                           $('#tabs').tabs('add', {
                                               title: node.text,
                                               iconCls: node.iconCls,
                                               closable: true,
                                               href: node.url,
                                           });
                                       }else{
                                           $.messager.show({
                                               title : '提示',
                                               msg :  '您没有权限执行这个选项！',
                                               timeout:2000,
                                           });
                                       }

                                   }
                                });
                            }
                        }
                    }
                });

            });
        }

    });

    $('#main_accordion').accordion({
          // multiple:true,
          selected:0,
  });

    $('#tabs').tabs({
        fit : true,
        border : false,
    });

    $('#route1841').panel({
        fit:true,
      });

       // var tokenvalue="";
       //  $.ajax({
       //      url: 'http://10.3.20.8/zabbix/api_jsonrpc.php',
       //      type: 'post',
       //      // async: false,
       //      contentType: 'application/json',
       //      data:'{"jsonrpc": "2.0","method": "user.login","params": {"user": "Admin","password": "g@6N7cSa"},"id": 1,"auth": null}',
       //      success: function (data) {
       //              var tokenvalue=data.result;
       //  },
       // });
       //


    var myChart = echarts.init(document.getElementById('route1841'));

    var option = {
        title: {
            text: '流量(M/S)'
        },
        tooltip: {},
        legend: {
            data:['time']
        },
        xAxis: {
            // type:'category',
            data:[]
        },
        yAxis: {},
        series: [{
            name:'in',
            type:'line',
            data:[]
        },{
            name:'out',
            type:'line',
            data:[]
        }]
    };
    // 使用刚指定的配置项和数据显示图表。
    myChart.showLoading();

    var adt = [];
    var aspeed = [];
    var ospeed=[];
    // 异步加载图表数据

    $.ajax({
        url: 'get1841_in',
        // async:false,
        data: {},
        type: 'post',
        dataType: 'json',
        success: function (json) {
            if (json) {
                for (var i = 0; i < json.length; i++) {

                    if (json[i].itemid=='30436'){
                        adt.push(json[i].dt);
                        aspeed.push(json[i].speed);
                    }else{
                        ospeed.push(json[i].speed);
                    }
                }
                myChart.hideLoading();
                myChart.setOption({
                    xAxis: {
                        data: adt
                    },
                    series: [{
                        name: 'in',
                        data: aspeed,
                        lineStyle: {
                            normal: {
                                color: 'rgba(29,175,250,0.3)',
                            }
                        }
                    },{
                        name:'out',
                        data:ospeed,
                        lineStyle:{
                            normal:{
                                color:'red',
                            }
                        }
                    }]
                });
            }
        },
        erro:function (errorMsg) {
            $.messager.show({
                title : '提示',
                msg :  '流量图表取值班不成功！',
                timeout:2000,
            });
            myChart.hideLoading();
        }
    });


    myChart.setOption(option);
    //



});