<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class ssdj extends Model
{
    protected $table='ssdj';
    protected $primaryKey='id';
    public $timestamps=false;
    protected $fillable=['jc','id','nid','state','address','zyrq','qzrq','zq','lxr','lxdh','isp','isp_acc','isp_pwd','route_type','route_manage_pwd','wifi_ssd1','wifi_ssd2','ispwxr','wifi_ssd1_pwd','wifi_ssd2_pwd','isp_qzrq','isp_regster','bz','kdje','kdzs'];
}
