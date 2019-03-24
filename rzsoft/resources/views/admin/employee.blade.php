@extends('layouts.admin')
@section('content')
    <script type="text/javascript" src="{{asset('resources/org/myjs/orgbrow.js')}}"></script>
    {{--<script type="text/javascript" src="{{asset('resources/org/myjs/UserAuth.js')}}"></script>--}}
    <div id="lemployee" class="easyui-layout" data-options="fit:true">
     	<div data-options="region:'west'"  style="width:27%; ">
            <table id="vemployee" style="fit:true"></table>
        </div>
     	<div data-options="region:'center',split:true"  >
            <table id="userbrow"></table>
        </div>
    </div>

    <div id="userbrow_tool2" style="padding:5px;">
        <div style="margin-bottom:5px;">
            <a href="#" class="easyui-linkbutton" iconCls="icon-add-new" plain="true" onclick="brow_tool2.add2();">添加</a>
            <a href="#" class="easyui-linkbutton" iconCls="icon-edit-new" plain="true" onclick="brow_tool2.edit2();">修改</a>
            <a href="#" class="easyui-linkbutton" iconCls="icon-delete-new" plain="true" onclick="brow_tool2.remove2();">删除</a>
            <a href="#" class="easyui-linkbutton" iconCls="icon-reload" plain="true"  onclick="brow_tool2.reload2();">刷新</a>
            {{--<a href="#" class="easyui-linkbutton" iconCls="icon-login" plain="true" onclick="brow_tool2.pwd2();">密码变更</a>--}}
            {{--<a href="#" class="easyui-linkbutton" iconCls="icon-system" plain="true" onclick="brow_tool2.auth2();">权限变更</a>--}}
         </div>
    </div>

    <form id="mauth5_add"  method="post"  style="margin:0;padding:5px 0 0 25px;color:#333;">

        <p>用户名称：<input type="text" id="yfqx_add_name" name="yfqx_add_name" class="textbox" style="width:100px;" >
        登录帐号：<input type="text" id="yfqx_add_login_name" name="yfqx_add_login_name"  class="textbox" style="width:100px;"></p>
        <p>用户密码：<input type="password" id="yfqx_add_user_pass" name="yfqx_add_user_pass"  class="textbox" style="width:100px;">
        备&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;注：<input type="text" class="textbox" name="yfqx_add_comment" style="width:100px;"></p>
        <p>分配权限：<input id="yfqx_add_auth" class="textbox" name="yfqx_add_auth"  style="width:275px;"></p>
        <p> 用户角色：<input  id="yfqx_add_js" name ="yfqx_add_js" class="easyui-combogrid" style="width:200px;"></p>
        <input type="hidden" id="yfqx_add_dept_id" class="textbox" name="dept_id">
    </form>

    <form id="mauth5_edit" style="margin:0;padding:5px 0 0 25px;color:#333;">
        <p>用户名称：<input type="text"  id="yfqx_edit_name"        name="yfqx_edit_name"         class="textbox" style="width:100px;" >
            登录帐号：<input type="text" id="yfqx_edit_login_name" name="yfqx_edit_login_name"  class="textbox" style="width:100px;"></p>
        <p>用户密码：<input type="password" id="yfqx_edit_user_pass" name="yfqx_edit_user_pass" class="textbox" style="width:100px;">
            备&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;注：<input type="text" class="textbox" name="yfqx_edit_comment" style="width:100px;"></p>
        <p>分配权限：<input  type="text" id="yfqx_edit_auth_combotree" class="textbox" name="yfqx_edit_auth_combotree"  style="width:275px;"></p>
        <p> 用户角色：<input  id="yfqx_edit_js" name ="yfqx_edit_js" class="easyui-combogrid" style="width:200px;"></p>
        <input type="hidden" class="textbox" name="yfqx_edit_dept_id">
        <input type="hidden" class="textbox" name="yfqx_edit_id">
    </form>

@endsection
