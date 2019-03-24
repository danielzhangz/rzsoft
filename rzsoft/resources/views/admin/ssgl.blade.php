@extends('layouts.admin')
@section('content')
    <script type="text/javascript" src="{{asset('resources/org/myjs/ssgl.js')}}"></script>

    <div id="ssmanager" class="easyui-layout" data-options="fit:true">
     	<div data-options="region:'west'"  style="width:25%; ">
            <table id="sslist"  data-options="onContextMenu: function (e, rowIndex, rowData) {
                                     $('#ssglbox').menu('show', { left: e.pageX, top: e.pageY }); e.preventDefault();}"></table>
        </div>

        <div data-options="region:'center',split:true"  >

            <a id="savebtn" href="#">保存</a>
            <form id="ssdet">
                <p>宿舍簡稱：<input type="text" id="ssjc" name="jc" class="textbox" style="width:100px;" ></p>
                <p>宿舍地址：<input type="text" id="ssdz" name="address"  class="textbox" style="width:380px;"></p>
                <p>宿舍联系人：<input type="text" id="sslxr" name="lxr"  class="textbox" style="width:100px;">
                宿舍联系人电话：<input type="text" id="sslxrdh" name="lxrdh"  class="textbox" style="width:100px;"></p>
                <p>   起租日期：<input type="text" id="ssqzrq" class="easyui-datebox" data-options="formatter:myformatter,parser:myparser" name="qzrq" style="width:110px;">
                <p>租凭期限：<input id="sszq" class="textbox" name="zq"  style="width:275px;"></p>
                <p>寬帶廠商：<input id="ssisp" class="textbox" name="isp"  style="width:275px;"></p>
                {{--<p> 宿舍ISP：<select id="ssisp" name ="isp" class="easyui-combox" style="width:200px;">--}}
                        {{--<option value="中國電信">中國電信</option>--}}
                        {{--<option>中國聯通</option>--}}
                        {{--<option>長城寬帶</option>--}}
                        {{--<option>小區寬帶</option>--}}
                        {{--<option>其它</option>     </select> </p>--}}
                ISP办理人：<input type="text" id="ispblr" name="isp_regster" class="textbox" style="width:100px;" >
                ISP維修人及电话：<input type="text" id="ispwxr" name="ispwxr" class="textbox" style="width:260px;" >
                <p>ISP帐号：<input type="text" id="ispzh" name="isp_acc" class="textbox" style="width:100px;" >
                    ISP密码：<input type="text" id="ispmm" name="isp_pwd"  class="textbox" style="width:100px;"></p>
                ISP租凭期：<input type="text" id="isp_qzrq" name="isp_qzrq" class="textbox" style="width:200px;" >
                <p>寬帶金額：<input type="text" id="kdje" name="kdje" class="textbox" style="width:100px;" >
                   寬帶兆數：<input type="text" id="kdzs" name="kdzs"  class="textbox" style="width:100px;"></p>
                <p>备注： <textarea id="ssbz" name="bz" rows="3" cols="50" style="vertical-align: top"> </textarea></p>
                <input type="hidden" id="sstype" name="sstype"  class="textbox" style="width:100px;">
                <input type="hidden" id="ssid" name="ssid"  class="textbox" style="width:100px;">
            </form>
        </div>
    </div>

    <div id="ssglbox" class="easyui-menu" data-options="left:10,top:10,minWidth:120,hideOnUnhover:false, ">
        <div>增加宿舍</div>
            <div class="menu-sep"></div>
        <div>刪除宿舍</div>
    </div>

    <div id="ssdet_tool" style="padding:5px;">
        <div style="margin-bottom:5px;">
            <a href="#" class="easyui-linkbutton" iconCls="icon-save" plain="true" onclick="ssdet_tool.save();">保存</a>
         </div>
    </div>

    <script type="text/javascript">
        function myformatter(date){
            var y = date.getFullYear();
            var m = date.getMonth()+1;
            var d = date.getDate();
            return y+'-'+(m<10?('0'+m):m)+'-'+(d<10?('0'+d):d);
        }
        function myparser(s){
            if (!s) return new Date();
            var ss = (s.split('-'));
            var y = parseInt(ss[0],10);
            var m = parseInt(ss[1],10);
            var d = parseInt(ss[2],10);
            if (!isNaN(y) && !isNaN(m) && !isNaN(d)){
                return new Date(y,m-1,d);
            } else {
                return new Date();
            }
        }
    </script>

@endsection
