@extends('layouts.admin')
@section('content')
    <script type="text/javascript" src="{{asset('resources/org/myjs/orgbrow2.js')}}"></script>
    <table id="vorg" style="fit:true"></table>

    <div id="orgbrow_tool1" style="padding:5px;">
        <div style="margin-bottom:5px;">
            <a href="#" class="easyui-linkbutton" iconCls="icon-add-new" plain="true" onclick="orgbrow_tool1.add_bm();">添加子部门</a>
            {{--<a href="#" class="easyui-linkbutton" iconCls="icon-login" plain="true" onclick="orgbrow_tool1.add_cbm();">添加子部门</a>--}}
            <a href="#" class="easyui-linkbutton" iconCls="icon-edit-new" plain="true" onclick="orgbrow_tool1.edit();">修改</a>
            <a href="#" class="easyui-linkbutton" iconCls="icon-delete-new" plain="true" onclick="orgbrow_tool1.remove();">删除</a>
            <a href="#" class="easyui-linkbutton" iconCls="icon-reload" plain="true"  onclick="orgbrow_tool1.reload();">刷新</a>
        </div>
    </div>

    <form id="orgbrow_add"  method="post"  style="margin:0;padding:5px 0 0 25px;color:#333;">
        <p>部门名称：<input type="text" id="add_bm_name" name="add_bm_name" class="textbox" style="width:280px;" ></p>
        <p>负责人1 ：<input type="text" id="add_z1_name" name="add_z1_name"  class="textbox" style="width:280px;"></p>
        <p>负责人2 ：<input type="text" id="add_z2_name" name="add_z2_name"  class="textbox" style="width:280px;"></p>
        <input type="hidden" id="add_bm_nid" class="textbox" name="add_bm_nid">
    </form>

    <form id="orgbrow_edit"  method="post"  style="margin:0;padding:5px 0 0 25px;color:#333;">
        <p>部门名称：<input type="text" id="edit_bm_name" name="edit_bm_name" class="textbox" style="width:280px;" ></p>
        <p>负责人1 ：<input type="text" id="edit_z1_name" name="edit_z1_name"  class="textbox" style="width:280px;"></p>
        <p>负责人2 ：<input type="text" id="edit_z2_name" name="edit_z2_name"  class="textbox" style="width:280px;"></p>
        <input type="hidden" id="edit_bm_id" class="textbox" name="edit_bm_id">
        {{--<input type="hidden" id="edit_bm_state" class="textbox" name="edit_bm_state">--}}
        {{--<input type="hidden" id="edit_bm_iconCls" class="textbox" name="edit_bm_iconCls">--}}
        {{--<input type="hidden" id="edit_bm_nid" class="textbox" name="edit_bm_nid">--}}
    </form>

    {{--<form id="orgbrow_edit" style="margin:0;padding:5px 0 0 25px;color:#333;">--}}
        {{--<p>用户名称：<input type="text"  id="yfqx_edit_name"        name="yfqx_edit_name"         class="textbox" style="width:100px;" >--}}
            {{--登录帐号：<input type="text" id="yfqx_edit_login_name" name="yfqx_edit_login_name"  class="textbox" style="width:100px;"></p>--}}
        {{--<p>用户密码：<input type="password" id="yfqx_edit_user_pass" name="yfqx_edit_user_pass" class="textbox" style="width:100px;">--}}
            {{--备&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;注：<input type="text" class="textbox" name="yfqx_edit_comment" style="width:100px;"></p>--}}
        {{--<p>分配权限：<input  type="text" id="yfqx_edit_auth_combotree" class="textbox" name="yfqx_edit_auth_combotree"  style="width:275px;"></p>--}}
        {{--<input type="hidden" class="textbox" name="yfqx_edit_dept_id">--}}
        {{--<input type="hidden" class="textbox" name="yfqx_edit_id">--}}
    {{--</form>--}}

@endsection
