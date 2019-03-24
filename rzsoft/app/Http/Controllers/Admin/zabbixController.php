<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\DB;
//require_once 'resources/org/code/Code.class.php';

class zabbixController extends CommonController
{
    public function get_zabbix()
    {
        $re=DB::connection('mysqlzabbix')->select("select from_unixtime(clock) as time,subject,message from alerts  where date_format(from_unixtime(clock),'%Y-%m-%d')=date_format(NOW(),'%Y-%m-%d') group by subject");
        return json_encode($re);
    }

    public function get1841_in()
    {
//        $in=DB::connection('mysqlzabbix')->select("select from_unixtime(clock) as dt,round((value/1000),2) as speed from history_uint  where itemid='30436' and from_unixtime(clock)>=DATE_ADD(Now(),INTERVAL -1 hour)");
        $in=DB::connection('mysqlzabbix')->select("select date_format(from_unixtime(clock),'%H:%i') as dt,itemid,round((value/1000/1000),2) as speed from history_uint  where (itemid='30436' or itemid='30448') and from_unixtime(clock)>=DATE_ADD(Now(),INTERVAL -1 hour)");
        return json_encode($in);
//         return $in;
//        $code1 = new \Code;
//        return $code1->my_get_token();
    }
}
