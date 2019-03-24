@extends('layouts.admin')
@section('content')
    <table id="ipmanager"  data-options="onRowContextMenu: function (e, rowIndex, rowData) {
          $('#ipbox').menu('show', { left: e.pageX, top: e.pageY }); e.preventDefault();}"></table>
     <script type="text/javascript" src="{{asset('resources/org/myjs/jmanager.js')}}"></script>

     <div id="manager_tool" style="padding:5px;">
         <div id="ipbox" class="easyui-menu" data-options="left:10,top:10,minWidth:120,hideOnUnhover:false, ">
             <div id="new">标记为离职</div>
             <div>标记为在职</div>

             {{--<div>--}}
                 {{--打开--}}
                 {{--<div>--}}
                     {{--<div>Word</div>--}}
                     {{--<div>Excel</div>--}}
                     {{--<div>PowerPoint</div>--}}
                 {{--</div>--}}
             {{--</div>--}}
             {{--<div data-options="iconCls:'icon-save',disabled:true">保存</div>--}}
             <div class="menu-sep"></div>
             <div id="zaok">資安已加載</div>
             <div id="zaqc">資安已清除</div>
             {{--<div>绑定IP</div>--}}
             {{--<div>解绑IP</div>--}}

         </div>


     <div style="margin-bottom:5px;">
         <a href="#" class="easyui-linkbutton" iconCls="icon-add-new" plain="true" onclick="ipmanager_tool.add();">添加</a>
         <a href="#" class="easyui-linkbutton" iconCls="icon-edit-new" plain="true" onclick="ipmanager_tool.edit();">修改</a>
         <a href="#" class="easyui-linkbutton" iconCls="icon-delete-new" plain="true" onclick="ipmanager_tool.remove();">删除</a>
         <a href="#" class="easyui-linkbutton" iconCls="icon-reload" plain="true"  onclick="ipmanager_tool.reload();">刷新</a>
         <a href="#" class="easyui-linkbutton" iconCls="icon-redo" plain="true" onclick="ipmanager_tool.redo();">取消选择</a>
         <a href="#" class="easyui-linkbutton" iconCls="icon-filter" plain="true" onclick="ipmanager_tool.dhcp();">綁定IP</a>
         <a href="#" class="easyui-linkbutton" iconCls="icon-filter" plain="true" onclick="ipmanager_tool.deldhcp();">清除綁定IP</a>
     </div>

     <div id="qtool" style="padding:0 0 0 7px;color:#333;">
         <p> 離職狀態：<input type="checkbox" name="iplz" value="" onclick="this.value=checked?'LZ':''" >&nbsp&nbsp 資安狀態:<input type="checkbox" name="ipza"  checked="1" value='1' onclick="this.value=checked?'1':'0'">&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp  備注：<input type="text" class="textbox" name="ipbz" tyle="width:320px"></p>
         <p>使用者：<input type="text" class="textbox" name="username" style="width:110px">
         名&nbsp&nbsp&nbsp&nbsp&nbsp称1：<input type="text" class="textbox" name="cname1" style="width:110px">
             &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp有&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp线IP：<input type="text" class="textbox" name="iplan" style="width:110px">
         有线MAC：<input type="text" class="textbox" name="lmac" style="width:130px"></p>
         无线IP：<input type="text" class="textbox" name="ipwlan" style="width:110px">
         无线MAC：<input type="text" class="textbox" name="wmac" style="width:130px">
         修改时间从：<input type="text" name="date_from" class="easyui-datebox" data-options="formatter:myformatter,parser:myparser" editable="true" style="width:110px">
         &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp到&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<input type="text" name="date_to" class="easyui-datebox" data-options="formatter:myformatter,parser:myparser"  editable="true" style="width:110px">
         <a href="#" class="easyui-linkbutton" iconCls="icon-search" onclick="obj.search();">查询</a>
     </div>
     </div>


     <form id="ipmanager_add" method="post" style="margin:0;padding:5px 0 0 25px;color:#333;">
         <p>使用者：<input type="text" class="textbox" name="username1" style="width:180px">
             網段：<select id="fwd" class="easyui-combobox" name="fwd" style="width:48px;">>
                 <option value=20>20</option>
                 <option>21</option>
                 <option>22</option>
                 <option>23</option>
                 <option>26</option>
                 <option>27</option>
             </select>

         </p>
         <p>名称1：<input type="text" class="textbox" name="cname11" style="width:110px">
            名称2：<input type="text" class="textbox" name="cname21" style="width:110px"></p>
         <p>有线IP：<input type="text" id="Aiplan1" class="textbox" name="iplan1" style="width:110px">
            有线MAC：<input type="text" class="textbox" name="lmac1" style="width:110px"></p>
         <p>无线IP：<input type="text" id="ipwlan1" class="textbox" name="ipwlan1" style="width:110px">
            无线MAC：<input type="text" class="textbox" name="wmac1" style="width:110px"></p>
          备注：<input type="text" class="textbox" name="comment1" style="width:280px">
         <input type="hidden" class="idate1" name="lastdate1" value=<?php date('Y-m-d')?>>
     </form>


     <form id="manager_edit" style="margin:0;padding:5px 0 0 25px;color:#333;">
         <p>使用者：<input type="text" class="textbox" name="username2" style="width:180px"></p>
         <p>名称1：<input type="text" class="textbox" name="cname12" style="width:110px">
             名称2：<input type="text" class="textbox" name="cname22" style="width:110px"></p>
         <p>有线IP：<input type="text" class="textbox" name="iplan2" style="width:110px">
             有线MAC：<input type="text" class="textbox" name="lmac2" style="width:130px"></p>
         <p>无线IP：<input type="text" class="textbox" name="ipwlan2" style="width:110px">
             无线MAC：<input type="text" class="textbox" name="wmac2" style="width:130px"></p>
         备注：<input type="text" class="textbox" name="comment2" style="width:280px">
         <input type="hidden" class="idate1" name="lastdate2" value=<?php date('Y-m-d')?>>
         <input type="hidden" class="idd" name="id2" value="">
     </form>

     <form id="cdhcp" method="post" style="margin:0;padding:5px 0 0 25px;color:#333;">
         <p>DHCP SERVER IP：<input type="text" class="textbox" name="serverip" value="10.3.21.8" style="width:110px"></p>
         <p>使用者：<input type="text" class="textbox" name="username3" style="width:180px"></p>
         <p>名  称：<input type="text" class="textbox" name="cname3" style="width:110px"></p>
         <p>有线IP：<input type="text" class="textbox" name="iplan3" readonly="readonly" style="width:110px">
            有线MAC：<input type="text" class="textbox" name="lmac3" readonly="readonly" style="width:130px"></p>
         <p>无线IP：<input type="text" class="textbox" name="ipwlan3" readonly="readonly" style="width:110px">
            无线MAC：<input type="text" class="textbox" name="wmac3" readonly="readonly" style="width:130px"></p>

     </form>

    <form id="deldhcpf" method="post" style="margin:0;padding:5px 0 0 25px;color:#333;">
        <p>DHCP SERVER IP：<input type="text" class="textbox" name="serverip1" value="10.3.21.8" style="width:110px"></p>
        <p>使用者：<input type="text" class="textbox" name="username5" style="width:180px"></p>
        <p>名  称：<input type="text" class="textbox" name="cname5" style="width:110px"></p>
        <p>有线IP：<input type="text" class="textbox" name="iplan5" readonly="readonly" style="width:110px">
            有线MAC：<input type="text" class="textbox" name="lmac5" readonly="readonly" style="width:130px"></p>
        <p>无线IP：<input type="text" class="textbox" name="ipwlan5" readonly="readonly" style="width:110px">
            无线MAC：<input type="text" class="textbox" name="wmac5" readonly="readonly" style="width:130px"></p>

    </form>

{{--<!--     --><?php //ob_end_flush(); ?>--}}
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
