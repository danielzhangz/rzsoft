<?php

namespace App\Http\Controllers\Admin;


use App\Http\Model\rycs_group;
use App\Http\Model\employee;
use App\Http\Model\User;

use Illuminate\Http\Request;

use App\Http\Requests;
//use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;

class userController extends CommonController
{
    public function store()
    {
        $input = Input::except('_token');
        employee::create($input);
            return 1;
     }

    public function edit($id)
    {
//        $field =User::find($id);
        $data = employee::where('id',$id)->get();
        return $data;
//        return view('admin.edit',compact('field','data'));
    }

    public function get_jsdata()
    {
        $re = DB::select("select id,js_name,js_auth from rycs_group");
        return json_encode($re);
    }


    public function del_jsdata()
    {
        $ids=$_POST['ids'];
        $result=DB::table('group')->wherein('id',$ids)->delete();
        return $result;
    }


    public function updategroup()
    {
        $id = $_POST['id'];
        $groupname = $_POST['js_name'];
        $input = Input::except('_token');

        $userexist=DB::table('group')->where('js_name',$groupname)->where('id','<>',$id)->get();
        if ($userexist){
            return -3;
        }

        $group = rycs_group::find($id);
        if ($group->update($input)) {
            return 1;
        } else {
            return 0;
        }
    }

    public function get_group_byid()
    {
        $id=$_POST['id'];
        $grouplist=DB::select("select id,js_name,js_auth from rycs_group  where id=$id");
        return json_encode($grouplist,JSON_UNESCAPED_UNICODE);
    }

    public function addgroup()
    {
        $input = Input::except('_token');
        $js_name=$input['js_name'];
        $groupexist=DB::table('group')->where('js_name',$js_name)->get();
        if ($groupexist){
            return -3;
        }else {
            rycs_group::create($input);
            return 1;
        }
    }


    public function get_employee_byid()
    {
//        $id=isset($_POST['id'])?$_POST['id']:0;
        $id=$_POST['id'];
        $userlist=DB::select("select id,name,login_name,auth,comment,entry_time,dept_id,js_auth from rycs_employee  where id=$id");
//        $json1= json_encode($userlist);
//        var_dump($json1);
//        $json2= json_decode($json1);
//        foreach ($userlist as $item){
//            $item->{'user_pass'} = Crypt::decrypt($item->{'user_pass'});  // 修改数据
//        }

//            arrayRecursive($userlist, 'urlencode', true);
//            $json = json_encode($userlist);
//            return urldecode($json);

        return json_encode($userlist,JSON_UNESCAPED_UNICODE);
    }

    public function get_userbrow()
    {
      $dept_id=isset($_POST['dept_id'])?$_POST['dept_id']:9;
      $userlist=DB::select("select id,name,login_name,auth,js_auth,comment,entry_time from rycs_employee  where dept_id=$dept_id group by id");
      return json_encode($userlist);

    }

    public function get_dept2(){
        $id=isset($_POST['id'])?$_POST['id']:0;
        $result=DB::select("SELECT id,org_name as text,state,iconCls,org_leading1,org_leading2,url FROM rycs_org where nid='$id'");
        return json_encode($result);
    }

    public function get_auth()
    {
        $id=isset($_POST['id'])?$_POST['id']:0;
        $re=DB::select("select id,text,state,iconCls,url from view_nav where nid='$id' order by id");
        return json_encode($re);
    }

    public function get_auth2($login_name)
    {
//        $login_name=isset($_POST['login_name'])?$_POST['login_name']:'X0';  //没有就选个找不到的
        $re2=DB::select("select id,user_pass,login_name,name,auth,comment from rycs_employee where login_name='$login_name'");
        return json_encode($re2);
    }

    public function get_auth4()
    {
        $id=isset($_POST['session_user'])?$_POST['session_user']:0;
        $isdomain=isset($_POST['isdomain'])?$_POST['isdomain']:0;

        if ($id > 0){
            $re=DB::table('employee')->where('id',$id)->value('auth');     //取得用户本身的权限
            $str=DB::table('employee')->where('id',$id)->value('js_auth'); //取得用户ID对应的角色
            $jsarr=explode(',',$str);                                         //以下遍历角色获取角色对应权限
            foreach ($jsarr as $jsname){
                if ($jsname!=null&&$jsname>''){
                    $re2=DB::table('group')->where('js_name',$jsname)->value('js_auth');
                    $re=$re.$re2;
                }
            }
            return $re;
        }else{
            if ($isdomain){             //对于域用户，权限只适用于domain user角色所对应权限
                $re=DB::table('group')->where('js_name','domain user')->value('js_auth');
                return $re;
            }
            return 0;
        }
    }

    public function del_yfqx_user()
    {
        $ids=$_POST['ids'];
        $result=DB::table('employee')->wherein('id',$ids)->delete();
        return $result;
    }


    public function yfqx_edit_update()
    {
        $id = $_POST['id'];
        $input = Input::except('_token');

//        if (Empty($input['name'])||empty($input['login_name'])){
//            return -2;
//        }

        if (!empty($input['user_pass'])&&strlen($input['user_pass'])<8){
             return -2;
         }

        $login_name=$input['login_name'];
        $userexist=DB::table('employee')->where('login_name',$login_name)->where('id','<>',$input['id'])->get();
        if ($userexist){
            return -3;
        }

        $employee = employee::find($id);

        if (strlen($input['user_pass'])>7){
            $input['user_pass']=Hash::make($input['user_pass']);
        }else{
            $input['user_pass']=$employee['user_pass'];
        }

        if ($employee->update($input)) {
            return 1;
        } else {
            return 0;
        }
    }

    public function yfqx_add()
    {
        $input = Input::except('_token');

//        if (Empty($input['name'])||empty($input['login_name'])||strlen($input['user_pass'])<8){
//            return -2;
//        }
        $login_name=$input['login_name'];
        $userexist=DB::table('employee')->where('login_name',$login_name)->get();
    if ($userexist){
        return -3;
//            return back()->with('add_user_msg','登录帐号已经存在！');
    }else {
        $input['user_pass']=Hash::make($input['user_pass']);
        employee::create($input);
        return 1;
    }
    }

    public function memployee()
    {
        return view('admin.employee');
    }

    public function m_auth()
    {
        return view('admin.m_auth');
    }

    public function getuser_js()   //取得角色combox显示内容
    {
        $re=DB::select('select id,js_name from rycs_group');
        return json_encode($re);
    }

//    function arrayRecursive(&$array, $function, $apply_to_keys_also = false)
//    {
//        static $recursive_counter = 0;
//        if (++$recursive_counter > 1000) {
//            die('possible deep recursion attack');
//        }
//        foreach ($array as $key => $value) {
//            if (is_array($value)) {
//                arrayRecursive($array[$key], $function, $apply_to_keys_also);
//            } else {
//                $array[$key] = $function($value);
//            }
//
//            if ($apply_to_keys_also && is_string($key)) {
//                $new_key = $function($key);
//                if ($new_key != $key) {
//                    $array[$new_key] = $array[$key];
//                    unset($array[$key]);
//                }
//            }
//        }
//        $recursive_counter--;
//    }
}
