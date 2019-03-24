@extends('layouts.admin')
@section('content')
    <script type="text/javascript" src="{{asset('resources/org/myjs/main.js')}}"></script>
    <script type="text/javascript" src="{{asset('resources/org/myjs/jquery.portal.js')}}"></script>
    <link rel="stylesheet" href="{{asset('resources/org/css/main.css')}}">
    <link rel="stylesheet" href="{{asset('resources/org/css/portal.css')}}">
    <script type="text/javascript" src="{{asset('resources/org/myjs/echarts.min.js')}}"></script>

    <script>
    $(function() {
        $('#pp').portal({
            border: false,
            fit: true
        });
//        $('#pp').portal('resize');
        $('#gjgrid').datagrid({
            url:'get_zabbix',
            fit : true,
//            fitColumns : true,
//            striped : true,
            rownumbers : true,
//            border : true,
//            pagination : true,
//            pageSize : 15,
//            pageList : [15, 30, 45, 60, 75],
//            pageNumber : 1,
//            sortName : 'time',
//            sortOrder : 'asc',
             columns : [[
                {
                    field : 'time',
                    title : '时间',
                    width :120,
                },
                {
                    field : 'subject',
                    title : '事件',
                    width : 600,
                },
                 {
                     field : 'message',
                     title : '明细',
                     width : 1500,
                 },
            ]],
        });

        $('#pf').combobox({
            	onSelect: function(rec){
                   var themename=rec.value;
                   var $easyuitheme=$('#mytheme');
                   var url=$easyuitheme.attr('href');
                   var href = url.substring(0, url.indexOf('themes')) + 'themes/' + themename + '/easyui.css';
                   $easyuitheme.attr('href', href);
                }
        });
    });

</script>


    <div id="cc" class="easyui-layout" data-options="fit:true">
        <div data-options="region:'north',noheader:true,split:false" style="height:60px;background:#2D93CA">
        {{--<div data-options="region:'north',noheader:true,split:false" style="height:60px">--}}
            <div class="logo">办公辅助管理</div>
            <div class="logout">
                主题<select id="pf" class="easyui-combobox"  style="float:right;width:88px;">
                    <option>default</option>
                    <option>black</option>
                    <option>bootstrap</option>
                    <option>gray</option>
                    <option>material</option>
                    <option>metro</option>
                </select>
                {{--@if(Session::has('user'))--}}
                &nbsp&nbsp您好，{{Session::get('user')}} | <a href="{{url('admin/quit')}}">退出</a>
                 {{--@endif   --}}
            </div>
        </div>
        <div data-options="region:'south',noheader:true,title:'South Title',split:true" style="height:35px;line-height:30px;text-align:center;">
              <table width=100% cellpadding="0" cellspacing="0">
                <tr>
                    <td align="left"  width="38%"><?php echo 'IP ADDRESS:'.getIp() ?></td>
                    <td  align="left"  width="60%">&Copy;2016-2026 [www.zenitron.com.tw] Powered by 增你强科技有限公司</td>
                    {{--<td>第三段文字</td>--}}
                </tr>
            </table>
            {{--欢迎使用本软件，欢迎提出辅助办公需求 ...--}}
        </div>
        <div data-options="region:'west',title:'导航',split:true,iconCls:'icon-world'" style="width:180px;padding:0px;">
             <div id="main_accordion" class="easyui-accordion"  data-options="fit:true"> </div>

            {{--<ul id="nav"></ul>--}}
        </div>

         <div region="center">
            <div id="tabs">
                <div title="首页" iconCls="icon-house"  style="padding:0px;">
                     {{--<div id="pp" fit="true"  class="portal"   style="position:relative">--}}
                    {{--<div id="pp" fit="true"  class="portal">--}}

                    <div id="pp" style="fit:true">
                         <div style="width:29%">
                             <div class="easyui-panel" title="公告" collapsible="true"  style="text-align:left;height:150px;padding;5px;border:1px">
                                 欢迎来到辅助管理系统!
                             </div>
                             <div  class="easyui-panel" title="通讯录" collapsible="true" style="text-align:left;height:150px;padding;5px;border:1px ">
                                <a href="http://10.1.1.133/upload/A02/1551665389963_深圳新office座位表20190301.xlsx" style="color:#000"> 座位表</a>
                             </div>
                             <div  class="easyui-panel" title="邮件" collapsible="true"  style="text-align:left;height:150px;padding;5px;border:1px">

                             </div>

                         </div>

                        <div style="width:39%">
                              <div  class="easyui-panel" title="ZABBIX警讯" collapsible="true"  style="text-align:left;height:310px;padding;5px;border:1px">
                                    <div id='gjgrid' class="easyui_datagrid">

                                     </div>
                              </div>
                         </div>   <div style="width:25%">
                            <div id="route1841"  class="easyui-panel" title="route 1841 流量" collapsible="true"  style="text-align:left;height:150px;padding;5px;border:1px">

                            </div>

                            <div  class="easyui-panel" title="日历" collapsible="true"  style="text-align:left;height:150px;padding;5px;border:1px">

                            </div>

                        </div>
                    </div>

                </div>

            </div>
        </div>

    </div>


    {{--<form id="session_ok"  method="post"  style="margin:0;padding:5px 0 0 25px;color:#333;">--}}
        <input type="hidden" id="session_user" value={{Session::get('login_id')}} class="textbox" name="session_user">
        <input type="hidden" id="session_domain" value={{Session::get('isdomain')}} class="textbox" name="session_domain">
    {{--</form>--}}


    <?php
    function getIp() {
        if (getenv("HTTP_CLIENT_IP") && strcasecmp(getenv("HTTP_CLIENT_IP"), "unknown"))
            $ip = getenv("HTTP_CLIENT_IP");
        else
            if (getenv("HTTP_X_FORWARDED_FOR") && strcasecmp(getenv("HTTP_X_FORWARDED_FOR"), "unknown"))
                $ip = getenv("HTTP_X_FORWARDED_FOR");
            else
                if (getenv("REMOTE_ADDR") && strcasecmp(getenv("REMOTE_ADDR"), "unknown"))
                    $ip = getenv("REMOTE_ADDR");
                else
                    if (isset ($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], "unknown"))
                        $ip = $_SERVER['REMOTE_ADDR'];
                    else
                        $ip = "unknown";
        return ($ip);
    }

    ?>

@endsection