<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\ssdj;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;

class ssglController extends CommonController
{
    public function get_sslist()
    {
        $id=isset($_POST['id'])?$_POST['id']:0;
        $result=DB::select("SELECT id,jc as text,state FROM rycs_ssdj where nid='$id'");
        return json_encode($result);
   }

    public function ssdj()
    {
        return view("admin.ssgl");
   }

    public function savess()
    {
        $input = Input::except('_token');
        if ($input['sstype']==0){
            $num= DB::insert('insert into rycs_ssdj (nid,state,jc,address,lxr,lxrdh,qzrq,zq,isp,isp_regster,ispwxr,isp_acc,isp_pwd,kdje,kdzs,bz,isp_qzrq) VALUES (1,"open",?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)',[$input['jc'],$input['address'],$input['lxr'],$input['lxrdh'],$input['qzrq'],$input['zq'],$input['isp'],$input['isp_regster'],$input['ispwxr'],$input['isp_acc'],$input['isp_pwd'],$input['kdje'],$input['kdzs'],$input['bz'],$input['isp_qzrq']]);
//            ssdj::create($input);
        }else{

            $num= DB::update('update rycs_ssdj set jc = ?,address=?,lxr=?,lxrdh=?,qzrq=?,zq=?,isp=?,isp_regster=?,ispwxr=?,isp_acc=?,isp_pwd=?,kdje=?,kdzs=?,bz=?,isp_qzrq=? where id = ?', [$input['jc'],$input['address'],$input['lxr'],$input['lxrdh'],$input['qzrq'],$input['zq'],$input['isp'],$input['isp_regster'],$input['ispwxr'],$input['isp_acc'],$input['isp_pwd'],$input['kdje'],$input['kdzs'],$input['bz'],$input['isp_qzrq'],$input['ssid']]);
        }

   }

    public function delss()
    {
        $id=$_POST['id'];
        if ($id>1){   //不能刪除樹根
            $result=DB::delete("delete FROM rycs_ssdj where id=?",array($id));
            return $result;
        }else{
            return 0;
        }
   }

    public function getss()
    {
        $id=$_POST['id'];
//        if ($id>1){   //不能取樹根
            $result=DB::select("select * FROM rycs_ssdj where id=?",array($id));
            return json_encode($result);
//        }else{
//            return 0;
//        }
   }
}
