@extends('layouts.admin')
@section('content')
    <script type="text/javascript" src="{{asset('resources/org/myjs/jsmanager.js')}}"></script>
    {{--<div id="v_auth" class="easyui-layout" data-options="fit:true">--}}
     	{{--<div data-options="region:'west'"  style="width:30%; ">--}}
            {{--<table id="v_auth1" style="fit:true"></table>--}}
        {{--</div>--}}
     	{{--<div data-options="region:'center',split:true"  >--}}
            {{--<table id="v_userbrow"></table>--}}
        {{--</div>--}}
    {{--</div>--}}
    <table id="jsmanager"></table>


    <div id="jsbrow_tool">
         <div style="margin-bottom:5px;">
            <a href="#" class="easyui-linkbutton" iconCls="icon-add-new" plain="true" onclick="jsbrow_tool.add();">添加</a>
            <a href="#" class="easyui-linkbutton" iconCls="icon-edit-new" plain="true" onclick="jsbrow_tool.edit();">修改</a>
            <a href="#" class="easyui-linkbutton" iconCls="icon-delete-new" plain="true" onclick="jsbrow_tool.remove();">删除</a>
            <a href="#" class="easyui-linkbutton" iconCls="icon-reload" plain="true"  onclick="jsbrow_tool.reload();">刷新</a>
            <a href="#" class="easyui-linkbutton" iconCls="icon-print" plain="true"  onclick="jsbrow_tool.print();">打印</a>
            {{--<a href="#" class="easyui-linkbutton" iconCls="icon-redo" plain="true" onclick="userbrow_tool.redo();">取消选择</a>--}}
        </div>
    </div>

        <form id="group_add"  method="post"  style="margin:0;padding:5px 0 0 25px;color:#333;">
            <p>角色名称：<input type="text" id="add_group_name" name="add_group_name" class="textbox" style="width:100px;" ></p>
            <p>分配权限：<input id="add_group_auth" class="textbox" name="add_group_auth"  style="width:275px;"></p>
            <input type="hidden" id="add_group_id" class="textbox" name="dept_id">
        </form>

        <form id="group_edit"  method="post"  style="margin:0;padding:5px 0 0 25px;color:#333;">
            <p>角色名称：<input type="text" id="edit_group_name" name="edit_group_name" class="textbox" style="width:100px;" ></p>
            <p>分配权限：<input id="edit_group_auth" class="textbox" name="edit_group_auth"  style="width:275px;"></p>
            <input type="hidden" id="edit_group_id" class="textbox" name="edit_group_id">
        </form>

    {{--<div id="qtool1" style="padding:0 0 0 7px;color:#333;">--}}
        {{--<p>使用者：<input type="text" class="textbox" name="username" style="width:110px">--}}
            {{--名称1：<input type="text" class="textbox" name="cname1" style="width:110px">--}}
            {{--有线IP：<input type="text" class="textbox" name="iplan" style="width:110px">--}}
            {{--有线MAC：<input type="text" class="textbox" name="lmac" style="width:130px"></p>--}}
        {{--无线IP：<input type="text" class="textbox" name="ipwlan" style="width:110px">--}}
        {{--无线MAC：<input type="text" class="textbox" name="wmac" style="width:130px">--}}
        {{--修改时间从：<input type="text" name="date_from" class="easyui-datebox" data-options="formatter:myformatter,parser:myparser" editable="true" style="width:110px">--}}
        {{--到：<input type="text" name="date_to" class="easyui-datebox" data-options="formatter:myformatter,parser:myparser"  editable="true" style="width:110px">--}}
        {{--<a href="#" class="easyui-linkbutton" iconCls="icon-search" onclick="obj.search();">查询</a>--}}
    {{--</div>--}}

@endsection
