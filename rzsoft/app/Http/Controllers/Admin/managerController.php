<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\iptable;
use Illuminate\Http\Request;
use App\Http\Model\user;
use App\Http\Requests;
use Illuminate\Routing\Console\ControllerMakeCommand;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Symfony\Component\Console\Tester\CommandTester;


class managerController extends CommonController
{
    public function vmanager()
    {
        return view('admin.manager');
 }

    public function ipmanager()
    {
        return view('admin.ipmanager');
    }

    public function getipmanager_data()
    {
        $page=$_POST['page'];
        $pageSize=$_POST['rows'];
        $first=$pageSize * ($page - 1);
        $order=$_POST['order'];
        $sort=$_POST['sort'];
        $vsql='';
        $vusername ='';
        $vcnmae1='';
        $vdate_from='';
        $vdate_to='';
        $viplan='';
        $vipwlan='';
        $vwmac='';
        $vlmac='';
        $vdate_from='';
        $vdate_to='';

        if (isset($_POST['username']) && !empty($_POST['username'])){
            $vusername="username like '%{$_POST['username']}%' and ";
            $vsql .=$vusername;
        }
        if (isset($_POST['cname1']) && !empty($_POST['cname1'])){
            $vcnmae1="cname1 like '%{$_POST['cname1']}%' and ";
            $vsql .=$vcnmae1;
        }
        if (isset($_POST['iplan']) && !empty($_POST['iplan'])){
            $viplan="iplan like '%{$_POST['iplan']}%' and ";
            $vsql .=$viplan;
        }
        if (isset($_POST['ipwlan']) && !empty($_POST['ipwlan'])){
            $vipwlan="ipwlan like '%{$_POST['ipwlan']}%' and ";
            $vsql .= $vipwlan;
        }
        if (isset($_POST['wmac']) && !empty($_POST['wmac'])){
            $vwmac="wmac like '%{$_POST['wmac']}%' and ";
            $vsql .=$vwmac;
        }
        if (isset($_POST['lmac']) && !empty($_POST['lmac'])){
            $vlmac="lmac like '%{$_POST['lmac']}%' and ";
            $vsql .=$vlmac;
        }
        if (isset($_POST['date_from']) && !empty($_POST['date_from'])){
            $vdate_from="lastdate >='{$_POST['date_from']}' and ";
            $vsql .=$vdate_from;
        }
        if (isset($_POST['date_to']) && !empty($_POST['date_to'])){
            $vdate_to="lastdate <='{$_POST['date_to']}' and ";
            $vsql .=$vdate_to;
        }

        if (isset($_POST['status']) ){
            if ($_POST['status']){
                $vlz="status ='LZ' and ";
                $vsql .=$vlz;
            }else{
//                $vlz="status ='' and ";
//                $vsql .=$vlz;
            }
        }

        if (isset($_POST['za'])){
            if ($_POST['za']){
                $vza="za =1  and ";
                $vsql .=$vza;
            }else{
                $vza="za =0  and ";
                $vsql .=$vza;
            }
        }

        if (isset($_POST['comment']) && !empty($_POST['comment'])){
            $vcom="comment like '%{$_POST['comment']}%' and ";
            $vsql .=$vcom;
        }

//        dd($vsql);
        if (!empty($vsql)){
            $vsql='where '.substr($vsql,0,-4);
         }
         $sqlstr='select * from rycs_iptable '.$vsql.' order by '.$sort.' '.$order.' limit '.$first.','.$pageSize;


//        $result=DB::table('iptable')->select('cname1','cname2','username','iplan','ipwlan','wmac','lmac','comment')->orderby($sort,$order)->skip($first)->take($pageSize)->get();
        $result=DB::select($sqlstr);
        $total=DB::table('iptable')->count();

        $json='';
        foreach ($result as $rval){
            $json.=json_encode($rval).',';
        }
        $json = substr($json, 0, -1);
        return '{"total":'.$total.',"rows":['.$json.']}';
    }

    public function deletemanager()
    {
        $ids=$_POST['ids'];
        $result=DB::table('iptable')->wherein('id',$ids)->delete();
        return $result;
    }

    public function bjlz()
    {
        $id=$_POST['id'];
        $result = DB::update("update rycs_iptable set status = 'LZ'  where id = ?",[$id]);
        return $result;
    }

    public function bjza()
    {
        $id=$_POST['id'];
        $result = DB::update("update rycs_iptable set za = 1  where id = ?",[$id]);
        return $result;
    }

    public function bjzz()
    {
        $id=$_POST['id'];
        $result = DB::update("update rycs_iptable set status = ''  where id = ?",[$id]);
        return $result;
    }

    public function qcza()
    {
        $id=$_POST['id'];
        $result = DB::update("update rycs_iptable set za = 0  where id = ?",[$id]);
        return $result;
    }

    public function ipupdate()
    {
        $id = $_POST['id'];
        $input = Input::except('_token');
        $iptable = iptable::find($id);
        if ($iptable->update($input)) {
            return 1;
        } else {
            return 0;
        }
    }


    public function updatedhcp()
    {
        $serverip = $_POST['serverip'];
        $username = $_POST['username'];
        $cname1 = $_POST['cname1'];
        $iplan = $_POST['iplan'];
        $lmac = str_replace('-','',$_POST['lmac']);
        $ipwlan = $_POST['ipwlan'];
        $wmac = str_replace('-','',$_POST['wmac']);
        $lscope=substr($iplan,0,strrpos($iplan,'.'));
        $wscope=substr($ipwlan,0,strrpos($ipwlan,'.'));
        $UTYPE=$_POST['UPTYPE'];
        if (empty($iplan) and $UTYPE==0){
            return 0;
        }
        if (empty($ipwlan) and $UTYPE==1){
            return 0;
        }
        //更新有線
        $strcope="11.253.20.0"; //这里随便定义一个缺省值
        if (($lscope=='10.3.20'  or $lscope=='10.3.21') and $UTYPE==0){
            $zlmac=" ";
            $strcope="10.3.20.0";
            $cmdshow="netsh dhcp server ".$serverip ." scope ".$strcope." show clients | findstr ".$iplan;
            $phpexec=exec($cmdshow,$res,$status);

            if($status==0){
                //查找到DHCP中原IP對應的MAC地址
                foreach ($res as $k =>$v) {
                    if (strpos($v, $iplan.' ') !== false) {
//   ip正則                 $regex="/(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)/";
                        $regex1="/[0-9A-Fa-f][0-9A-Fa-f]-[0-9A-Fa-f][0-9A-Fa-f]-[0-9A-Fa-f][0-9A-Fa-f]-[0-9A-Fa-f][0-9A-Fa-f]-[0-9A-Fa-f][0-9A-Fa-f]-[0-9A-Fa-f][0-9A-Fa-f]/";;
                        $str = $v;
                        $matches = array();
                        if(preg_match($regex1, $str, $matches)){
                            $zlmac = str_replace('-','',$matches[0]);
                        }
                    }
                }

                if ($zlmac>" "){
                    $cmddelstr="netsh dhcp server ".$serverip ." scope ".$strcope ." delete reservedip ".$iplan ." ".$zlmac;
                    $phpexec=exec($cmddelstr,$res,$status1);
                    if ($status1==0){
                        $cmdstr="netsh dhcp server ".$serverip ." scope ".$strcope ." add reservedip ".$iplan ." ".$lmac." ".$cname1." ".$username." both";
                        $phpexec=exec($cmdstr,$res,$status2);
                        if ($status2==0){
                            return 1;
                        }else{
                            return 0;
                        }
                    }else{
                        return 0;
                    }
                }else{
                    $cmdstr="netsh dhcp server ".$serverip ." scope ".$strcope ." add reservedip ".$iplan ." ".$lmac." ".$cname1." ".$username." both";
                    $phpexec=exec($cmdstr,$res,$status3);

                    if ($status3==0){
                        return 1;
                    }else{
                        return 0;
                    }
                }
            }else{
                $cmdstr="netsh dhcp server ".$serverip ." scope ".$strcope ." add reservedip ".$iplan ." ".$lmac." ".$cname1." ".$username." both";
                $phpexec=exec($cmdstr,$res,$status4);
                if ($status4==0){
                    return 1;
                }else{
                    return 0;
                }
            }
        }

        $strcope="11.253.20.0";
        if ($lscope=='10.3.26'  and $UTYPE==0){
            $zlmac=" ";
            $strcope="10.3.26.0";
            $cmdshow="netsh dhcp server ".$serverip ." scope ".$strcope." show clients | findstr ".$iplan;
            $phpexec=exec($cmdshow,$res,$status);

            if($status==0){
                //查找到DHCP中原IP對應的MAC地址
                foreach ($res as $k =>$v) {
                    if (strpos($v, $iplan.' ') !== false) {
//   ip正則                 $regex="/(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)/";
                        $regex1="/[0-9A-Fa-f][0-9A-Fa-f]-[0-9A-Fa-f][0-9A-Fa-f]-[0-9A-Fa-f][0-9A-Fa-f]-[0-9A-Fa-f][0-9A-Fa-f]-[0-9A-Fa-f][0-9A-Fa-f]-[0-9A-Fa-f][0-9A-Fa-f]/";;
                        $str = $v;
                        $matches = array();
                        if(preg_match($regex1, $str, $matches)){
                            $zlmac = str_replace('-','',$matches[0]);
                        }
                    }
                }

                if ($zlmac>" "){
                    $cmddelstr="netsh dhcp server ".$serverip ." scope ".$strcope ." delete reservedip ".$iplan ." ".$zlmac;
                    $phpexec=exec($cmddelstr,$res,$status1);
                    if ($status1==0){
                        $cmdstr="netsh dhcp server ".$serverip ." scope ".$strcope ." add reservedip ".$iplan ." ".$lmac." ".$cname1." ".$username." both";
                        $phpexec=exec($cmdstr,$res,$status2);
                        if ($status2==0){
                            return 1;
                        }else{
                            return 0;
                        }
                    }else{
                        return 0;
                    }
                }else{
                    $cmdstr="netsh dhcp server ".$serverip ." scope ".$strcope ." add reservedip ".$iplan ." ".$lmac." ".$cname1." ".$username." both";
                    $phpexec=exec($cmdstr,$res,$status3);

                    if ($status3==0){
                        return 1;
                    }else{
                        return 0;
                    }
                }
            }else{
                $cmdstr="netsh dhcp server ".$serverip ." scope ".$strcope ." add reservedip ".$iplan ." ".$lmac." ".$cname1." ".$username." both";
                $phpexec=exec($cmdstr,$res,$status4);
                if ($status4==0){
                    return 1;
                }else{
                    return 0;
                }
            }
        }
        //更新無線
        $strcope="11.253.20.0"; //这里随便定义一个缺省值
        if (($wscope=='10.3.22'  or $wscope=='10.3.23') and $UTYPE==1){
            $strcope="10.3.22.0";
            $cmdshow="netsh dhcp server ".$serverip ." scope ".$strcope." show clients | findstr ".$ipwlan;
            $phpexec=exec($cmdshow,$res,$status);
            $zlmac=" ";
            if($status==0){
                //查找到DHCP中原IP對應的MAC地址
                foreach ($res as $k =>$v) {
                    if (strpos($v, $ipwlan.' ') !== false) {
                        $regex1="/[0-9A-Fa-f][0-9A-Fa-f]-[0-9A-Fa-f][0-9A-Fa-f]-[0-9A-Fa-f][0-9A-Fa-f]-[0-9A-Fa-f][0-9A-Fa-f]-[0-9A-Fa-f][0-9A-Fa-f]-[0-9A-Fa-f][0-9A-Fa-f]/";;
                        $str = $v;
                        $matches = array();
                        if(preg_match($regex1, $str, $matches)){
                            $zlmac = str_replace('-','',$matches[0]);
                        }
                    }
                }

                if ($zlmac>" "){
                    $cmddelstr="netsh dhcp server ".$serverip ." scope ".$strcope ." delete reservedip ".$ipwlan ." ".$zlmac;
                    $phpexec=exec($cmddelstr,$res,$status1);
                    if ($status1==0){
                        $cmdstr="netsh dhcp server ".$serverip ." scope ".$strcope ." add reservedip ".$ipwlan ." ".$wmac." ".$cname1." ".$username." both";
                        $phpexec=exec($cmdstr,$res,$status2);
                        if ($status2==0){
                            return 1;
                        }else{
                            return 0;
                        }
                    }else{
                        return 0;
                    }
                }else{
                    $cmdstr="netsh dhcp server ".$serverip ." scope ".$strcope ." add reservedip ".$ipwlan ." ".$wmac." ".$cname1." ".$username." both";
                    $phpexec=exec($cmdstr,$res,$status3);

                    if ($status3==0){
                        return 1;
                    }else{
                        return 0;
                    }
                }
            }else{
                $cmdstr="netsh dhcp server ".$serverip ." scope ".$strcope ." add reservedip ".$ipwlan ." ".$wmac." ".$cname1." ".$username." both";
                $phpexec=exec($cmdstr,$res,$status4);
                if ($status4==0){
                    return 1;
                }else{
                    return 0;
                }
            }
        }
        $strcope="11.253.20.0"; //这里随便定义一个缺省值
        if ($wscope=='10.3.27' and $UTYPE==1){
            $strcope="10.3.26.0";
            $cmdshow="netsh dhcp server ".$serverip ." scope ".$strcope." show clients | findstr ".$ipwlan;
            $phpexec=exec($cmdshow,$res,$status);
            $zlmac=" ";
            if($status==0){
                //查找到DHCP中原IP對應的MAC地址
                foreach ($res as $k =>$v) {
                    if (strpos($v, $ipwlan.' ') !== false) {
                        $regex1="/[0-9A-Fa-f][0-9A-Fa-f]-[0-9A-Fa-f][0-9A-Fa-f]-[0-9A-Fa-f][0-9A-Fa-f]-[0-9A-Fa-f][0-9A-Fa-f]-[0-9A-Fa-f][0-9A-Fa-f]-[0-9A-Fa-f][0-9A-Fa-f]/";;
                        $str = $v;
                        $matches = array();
                        if(preg_match($regex1, $str, $matches)){
                            $zlmac = str_replace('-','',$matches[0]);
                        }
                    }
                }

                if ($zlmac>" "){
                    $cmddelstr="netsh dhcp server ".$serverip ." scope ".$strcope ." delete reservedip ".$ipwlan ." ".$zlmac;
                    $phpexec=exec($cmddelstr,$res,$status1);
                    if ($status1==0){
                        $cmdstr="netsh dhcp server ".$serverip ." scope ".$strcope ." add reservedip ".$ipwlan ." ".$wmac." ".$cname1." ".$username." both";
                        $phpexec=exec($cmdstr,$res,$status2);
                        if ($status2==0){
                            return 1;
                        }else{
                            return 0;
                        }
                    }else{
                        return 0;
                    }
                }else{
                    $cmdstr="netsh dhcp server ".$serverip ." scope ".$strcope ." add reservedip ".$ipwlan ." ".$wmac." ".$cname1." ".$username." both";
                    $phpexec=exec($cmdstr,$res,$status3);

                    if ($status3==0){
                        return 1;
                    }else{
                        return 0;
                    }
                }
            }else{
                $cmdstr="netsh dhcp server ".$serverip ." scope ".$strcope ." add reservedip ".$ipwlan ." ".$wmac." ".$cname1." ".$username." both";
                $phpexec=exec($cmdstr,$res,$status4);
                if ($status4==0){
                    return 1;
                }else{
                    return 0;
                }
            }
        }


}

    public function getmainbar()
    {
//       // $result=DB::table('nav')->select('panel_id','panel_title','panel_icon' as 'iconCls')->groupby('panel_id')->distinct()->get();
        $result=DB::select("select DISTINCT panel_id,panel_title,panel_icon as iconCls from rycs_nav where panel_title>' ' group by panel_id");
        return json_encode($result);
    }

   /* public function getmanager_data()
    {
        $page=$_POST['page'];
        $pageSize=$_POST['rows'];
        $first=$pageSize * ($page - 1);
        $order=$_POST['order'];
        $sort=$_POST['sort'];

//        $result=user::select('id','user_name','date','auth')->orderby($sort,$order)->limit($first,$pageSize)->get();
        $result=DB::table('user')->select('id','user_name','user_pass','auth','date')->orderby($sort,$order)->skip($first)->take($pageSize)->get();
        $total=DB::table('user')->count();
        $json='';
        foreach ($result as $rval){
            $json.=json_encode($rval).',';
        }
        $json = substr($json, 0, -1);
        return '{"total":'.$total.',"rows":['.$json.']}';
    }*/

    public function deldhcp1()
    {
        $serverip = $_POST['serverip'];
        $username = $_POST['username'];
        $cname1 = $_POST['cname1'];
        $iplan = $_POST['iplan'];
        $lmac = str_replace('-', '', $_POST['lmac']);
        $ipwlan = $_POST['ipwlan'];
        $wmac = str_replace('-', '', $_POST['wmac']);
        $lscope = substr($iplan, 0, strrpos($iplan, '.'));
        $wscope = substr($ipwlan, 0, strrpos($ipwlan, '.'));
        $UTYPE = $_POST['UPTYPE'];

        if (empty($iplan) and $UTYPE == 0) {
            return 0;
        }
        if (empty($ipwlan) and $UTYPE == 1) {
            return 0;
        }
        //更新有線

        $strcope = "11.253.20.0"; //这里随便定义一个缺省值
        if (($lscope == '10.3.20' or $lscope == '10.3.21') and $UTYPE == 0) {
            $zlmac = " ";
            $strcope = "10.3.20.0";
            $cmdshow = "netsh dhcp server " . $serverip . " scope " . $strcope . " show clients | findstr " . $iplan;
            $phpexec = exec($cmdshow, $res, $status);
//            dd($cmdshow);
            if ($status == 0) {
                //查找到DHCP中原IP對應的MAC地址
                foreach ($res as $k => $v) {
                    if (strpos($v, $iplan . ' ') !== false) {
//   ip正則                 $regex="/(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)/";
                        $regex1 = "/[0-9A-Fa-f][0-9A-Fa-f]-[0-9A-Fa-f][0-9A-Fa-f]-[0-9A-Fa-f][0-9A-Fa-f]-[0-9A-Fa-f][0-9A-Fa-f]-[0-9A-Fa-f][0-9A-Fa-f]-[0-9A-Fa-f][0-9A-Fa-f]/";;
                        $str = $v;
                        $matches = array();
                        if (preg_match($regex1, $str, $matches)) {
                            $zlmac = str_replace('-', '', $matches[0]);
                        }
                    }
                }

                if ($zlmac > " ") {
                    $cmddelstr = "netsh dhcp server " . $serverip . " scope " . $strcope . " delete reservedip " . $iplan . " " . $zlmac;
                    $phpexec = exec($cmddelstr, $res, $status1);
                    if ($status1 == 0) {
                        return 1;
                    } else {
                        return 0;
                    }
                } else {
                    return 0;
                }
            } else {
                return 0;
            }
        }


        $strcope = "11.253.20.0";
        if ($lscope == '10.3.26' and $UTYPE == 0) {
            $zlmac = " ";
            $strcope = "10.3.26.0";
            $cmdshow = "netsh dhcp server " . $serverip . " scope " . $strcope . " show clients | findstr " . $iplan;
            $phpexec = exec($cmdshow, $res, $status);

            if ($status == 0) {
                //查找到DHCP中原IP對應的MAC地址
                foreach ($res as $k => $v) {
                    if (strpos($v, $iplan . ' ') !== false) {
//   ip正則                 $regex="/(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)/";
                        $regex1 = "/[0-9A-Fa-f][0-9A-Fa-f]-[0-9A-Fa-f][0-9A-Fa-f]-[0-9A-Fa-f][0-9A-Fa-f]-[0-9A-Fa-f][0-9A-Fa-f]-[0-9A-Fa-f][0-9A-Fa-f]-[0-9A-Fa-f][0-9A-Fa-f]/";;
                        $str = $v;
                        $matches = array();
                        if (preg_match($regex1, $str, $matches)) {
                            $zlmac = str_replace('-', '', $matches[0]);
                        }
                    }
                }
                if ($zlmac > " ") {
                    $cmddelstr = "netsh dhcp server " . $serverip . " scope " . $strcope . " delete reservedip " . $iplan . " " . $zlmac;
                    $phpexec = exec($cmddelstr, $res, $status1);
                    if ($status1 == 0) {
                        return 1;
                    } else {
                        return 0;
                    }
                } else {
                    return 0;
                }
            } else {
                return 0;
            }
        }


        //更新無線
        $strcope = "11.253.20.0"; //这里随便定义一个缺省值
        if (($wscope == '10.3.22' or $wscope == '10.3.23') and $UTYPE == 1) {
            $zlmac = " ";
            $strcope = "10.3.22.0";
            $cmdshow = "netsh dhcp server " . $serverip . " scope " . $strcope . " show clients | findstr " . $ipwlan;
            $phpexec = exec($cmdshow, $res, $status);

            if ($status == 0) {
                //查找到DHCP中原IP對應的MAC地址
                foreach ($res as $k => $v) {
                    if (strpos($v, $ipwlan . ' ') !== false) {
//   ip正則                 $regex="/(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)/";
                        $regex1 = "/[0-9A-Fa-f][0-9A-Fa-f]-[0-9A-Fa-f][0-9A-Fa-f]-[0-9A-Fa-f][0-9A-Fa-f]-[0-9A-Fa-f][0-9A-Fa-f]-[0-9A-Fa-f][0-9A-Fa-f]-[0-9A-Fa-f][0-9A-Fa-f]/";;
                        $str = $v;
                        $matches = array();

                        if (preg_match($regex1, $str, $matches)) {
                            $zlmac = str_replace('-', '', $matches[0]);
                        }
                    }
                }
                if ($zlmac > " ") {
                    $cmddelstr = "netsh dhcp server " . $serverip . " scope " . $strcope . " delete reservedip " . $ipwlan . " " . $zlmac;
                    $phpexec = exec($cmddelstr, $res, $status1);
                    if ($status1 == 0) {
                        return 1;
                    } else {
                        return 0;
                    }
                } else {
                    return 0;
                }
            } else {
                return 0;
            }
        }


        $strcope = "11.253.20.0"; //这里随便定义一个缺省值
        if ($wscope == '10.3.27'  and $UTYPE == 1) {
            $zlmac = " ";
            $strcope = "10.3.26.0";
            $cmdshow = "netsh dhcp server " . $serverip . " scope " . $strcope . " show clients | findstr " . $ipwlan;
            $phpexec = exec($cmdshow, $res, $status);

            if ($status == 0) {
                //查找到DHCP中原IP對應的MAC地址
                foreach ($res as $k => $v) {
                    if (strpos($v, $ipwlan . ' ') !== false) {
//   ip正則                 $regex="/(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)/";
                        $regex1 = "/[0-9A-Fa-f][0-9A-Fa-f]-[0-9A-Fa-f][0-9A-Fa-f]-[0-9A-Fa-f][0-9A-Fa-f]-[0-9A-Fa-f][0-9A-Fa-f]-[0-9A-Fa-f][0-9A-Fa-f]-[0-9A-Fa-f][0-9A-Fa-f]/";;
                        $str = $v;
                        $matches = array();
                        if (preg_match($regex1, $str, $matches)) {
                            $zlmac = str_replace('-', '', $matches[0]);
                        }
                    }
                }
                if ($zlmac > " ") {
                    $cmddelstr = "netsh dhcp server " . $serverip . " scope " . $strcope . " delete reservedip " . $ipwlan . " " . $zlmac;
                    $phpexec = exec($cmddelstr, $res, $status1);
                    if ($status1 == 0) {
                        return 1;
                    } else {
                        return 0;
                    }
                } else {
                    return 0;
                }
            } else {
                return 0;
            }
        }

    }


}



