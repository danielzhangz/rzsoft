<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\CommonController;
use App\Http\Model\rycs_org;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;

class orgmanagerController extends CommonController
{
    public function orgmanager()
    {
      return view('admin.vorgbrow');
   }

    public function get_dept_byid()
    {
        $id=$_POST['id'];
        $bm_data=DB::table('org')->where('id',$id)->get();
        return $bm_data;
    }

    public function bm_add()
{
    $input = Input::except('_token');
    $bm_name=$_POST['name'];
    $bm_z1=$input['z1'];
    $bm_z2=$input['z2'];
    $bm_nid=$input['nid'];

    $deptexist=DB::table('org')->where('org_name',$input['name'])->get();
    if ($deptexist){
        return  -3;
    }

    DB::beginTransaction();
    try{
        $re1=DB::update("update rycs_org set state='closed',iconCls='icon-group' where id=?",[$bm_nid]);
        $re=DB::insert('insert into rycs_org (org_name,org_leading1,org_leading2,state,nid)  values (?,?,?,?,?)',[$bm_name,$bm_z1,$bm_z2,"open",$bm_nid]);

        DB::commit();
    }catch(\Illuminate\Database\QeuryException $EX){
        DB::rollback();
        return 0;
    }
    return 1;
}

    public function bm_edit()
    {
        $input = Input::except('_token');
        $bm_name=$input['name'];
        $bm_z1=$input['z1'];
        $bm_z2=$input['z2'];
        $bm_id=(int)$input['id'];

        $deptexist=DB::table('org')->where('org_name',$input['name'])->where('id','!=',$bm_id)->value('org_name');
//        dd($deptexist);
//        if ($deptexist!=null){
        if ($deptexist){
//            if ($deptexist==$bm_name) {
                return -3;
//            }
        }

        DB::beginTransaction();
        try{
            $re1=DB::update('update rycs_org set org_name=?,org_leading1=?,org_leading2=?  where id=?',array($bm_name,$bm_z1,$bm_z2,$bm_id));
            DB::commit();
        }catch(\Illuminate\Database\QeuryException $EX){
            DB::rollback();
            return 0;
        }
        return 1;
    }

    public function del_select_dept()
    {
        $ids=$_POST['ids'];
        if ($ids==0){
            return -3; //不能删除根部门，只能改名
        }
        $re=DB::table('org')->where('nid',$ids)->count();
        if ($re>0){
            return -1;  //还有子部门，不能删除
        }
        $nid=DB::table('org')->where('id',$ids)->value('nid'); //取得父项ID
        $re2=DB::table('employee')->where('dept_id',$ids)->count();
        if ($re2>0){
            return -2;  //部门还有人员，不能删除
        }
        $re1=DB::table('org')->where('nid',$nid)->count();
//        dd($re1);
        if ($re1==1){
            //当最后一个子项被删除时，需改变上层STATE 为OPEN状态，清除图标

            DB::beginTransaction();
            try{
                $re1=DB::update("update rycs_org set state='open',iconCls='' where id=?",[$nid]);
                $result=DB::table('org')->where('id',$ids)->delete();
                DB::commit();
            }catch(\Illuminate\Database\QeuryException $EX){
                DB::rollback();
                return 0;
            }
            return 1;
        }else{
            DB::beginTransaction();
            try{
                $result=DB::table('org')->where('id',$ids)->delete();
                DB::commit();
            }catch(\Illuminate\Database\QeuryException $EX){
                DB::rollback();
                return 0;
            }
            return 1;
        }

   }


   
}
