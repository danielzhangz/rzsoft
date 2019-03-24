<?php

namespace App\Http\Controllers\Admin;
use App\Http\Model\employee;
use App\Http\Model\iptable;
use Illuminate\Http\Request;
use \Exception;
use App\Http\Requests;
//use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;

require_once 'resources/org/code/Code.class.php';

class LoginController extends CommonController
{
    public function login()
    {
        if($input = Input::except('object')){
             $code = new \Code;
             $_code = $code->get();
             if(strtoupper($input['code'])!=$_code){
                 return back()->with('msg','验证码错误！');
             }


            $isdomain=0;
            if (substr_count($input['user_name'],'zenitronhq\\')||substr_count($input['user_name'],'@zenitron.com.')) {
                try {
                    $ldapconnect = ldap_connect('10.3.21.13', '389') or die('域服务器不能连接');
                    if ($ldapconnect && $code->pingAddress('10.3.21.13')) {
                        $bind = ldap_bind($ldapconnect, $input['user_name'], $input['user_pass']) or die('域帐号密码错误！');
                        if ($bind) {
                            session(['user' => $input['user_name']]);
                            session(['login_id' => 0]);
                            session(['isdomain' => 1]);
                            ldap_close($ldapconnect);
                            return redirect('admin/index');
                        } else {
                            $isdomain = 0;
                        }
                    } else {
                        $isdomain = 0;
                    }
                    ldap_close($ldapconnect);
                } catch (\Exception $e) {
                    ldap_close($ldapconnect);
                    session(['isdomain' => 0]);
                    return back()->with('msg', '域帐号错或密码验证错误！');
                }
            }


            $employee= employee::where('login_name',$input['user_name'])->first();
            if(!$employee){
                return back()->with('msg','登录帐号不存在！');
            }
//            if($employee->login_name != $input['user_name'] || !hash::check($input['user_pass'],$employee->user_pass)){
            if(!hash::check($input['user_pass'],$employee->user_pass)){
                 return back()->with('msg','密码验证错误！');
             }

             session(['user' => $employee->login_name]);
             session(['login_id'=>$employee->id]);
             session(['isdomain'=>$isdomain]);
//            return Redirect('admin/index/?'.'user='.session(['user']);
//            return redirect()->action('Admin\IndexController@index',session(['user']));
              return redirect('admin/index');
            }else {
               return view('admin.login');
           }

    }

    public function quit()
    {
        session(['user'=>null]);
        return redirect('admin/login');
    }

    public function code()
    {
        $code = new \Code;
        $code->make();
    }

//
//    public function ipinfo()
//    {
//        $zname=isset($_GET['info'])?$_GET['info']:"all";
//        if ($zname!="all"){
//            $result=DB::select("select * from rycs_iptable where (username like '%$zname%'  or ipwlan like '%$zname%'   or iplan like '%$zname%' or wmac like '%$zname%' or wmac like '%$zname%'");
//        }else{
////            $result=iptable::select('username','cname1','cname2','iplan','ipwlan','lmac','wmac')->get();
//            $result=iptable::select('za','comment','status','username','cname1','cname2','iplan','ipwlan','lmac','wmac')->get();
//        }
//        return json_encode($result,JSON_UNESCAPED_UNICODE);
//    }

    public function showcode()
    {
       $zname=isset($_GET['name'])?$_GET['name']:"all";
       if ($zname!="all"){
//           $result=iptable::select('username','cname1','cname2','iplan','ipwlan','lmac','wmac')->where('username',$zname)->get();
           $result=DB::select("select * from rycs_iptable where username like '%$zname%'");
       }else{
           $result=iptable::select('za','comment','status','username','cname1','cname2','iplan','ipwlan','lmac','wmac')->get();
       }
        return json_encode($result,JSON_UNESCAPED_UNICODE);
    }


//        return  Hash::make('12345678');
//        return Crypt::encrypt('12345678');
       // return date("Y-m-d");
//    }
//    public function showcode2()
//    {
//
//        $page=1;
//        $pageSize=20;
//        $first=$pageSize * ($page - 1);
//        $order='desc';
//        $sort='date';
//
////        $result=user::select('id','user_name','date','auth')->orderby($sort,$order)->limit($first,$pageSize)->get();
//        $result=DB::table('user')->select('id','user_name','user_pass','auth')->orderby($sort,$order)->skip(0)->take($pageSize)->get();
////        $total=DB::table('user')->count();
////        $json='';
////        foreach ($result as $rval){
////            $json.=json_encode($rval).',';
////        }
////        $json = substr($json, 0, -1);
////        return '{"total":'.$total.',"rows":['.$json.']}';
////       dd($json);
//        dd($result);
//    }

}
