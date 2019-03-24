<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\User;
use App\Http\Model\easyui_nav;

use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class IndexController extends CommonController
{
    public function index()
    {
        return view('admin.main');
    }

    public function info()
{
    return view('admin.info');
}
    public function easy()
    {
        return view('admin.easy');
    }


    //更改超级管理员密码
    public function pass()
    {
        if($input = Input::all()){

            $rules = [
                'password'=>'required|between:6,20|confirmed',
            ];

            $message = [
                'password.required'=>'新密码不能为空！',
                'password.between'=>'新密码必须在6-20位之间！',
                'password.confirmed'=>'新密码和确认密码不一致！',
            ];

            $validator = Validator::make($input,$rules,$message);

            if($validator->passes()){
                $user = User::first();
                $_password = Crypt::decrypt($user->user_pass);
                if($input['password_o']==$_password){
                    $user->user_pass = Crypt::encrypt($input['password']);
                    $user->update();
                    return back()->with('errors','密码修改成功！');
                }else{
                    return back()->with('errors','原密码错误！');
                }
            }else{
                return back()->withErrors($validator);
            }

        }else{
            return view('admin.pass');
        }
    }

    public function get_data(){

        $result=DB::select('select cate_id,cate_name,cate_title from blog_category');
        return json_encode($result);
    }

    public function get_navdata($panel_id,$id){
//      $panel_id=isset($_POST['panel_id'])?$_POST['panel_id']:1;
        $id=isset($_POST['id'])?$_POST['id']:0;
//        $result=DB::select("SELECT nid,text,state,iconCls,url FROM rycs_nav where nid='$id' and panel_id='$panel_id' ");
        $result=DB::select("SELECT id,text,state,iconCls,url FROM rycs_nav where panel_id='$panel_id' and nid='$id'");
        return json_encode($result);
    }

    public function get_org(){
        $id=isset($_POST['id'])?$_POST['id']:0;
        $result=DB::select("SELECT id,org_name,state,iconCls,org_leading1,org_leading2,url FROM rycs_org where nid='$id'");
        return json_encode($result);
    }

}
