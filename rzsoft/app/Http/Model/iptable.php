<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class iptable extends Model
{
    protected $table='iptable';
    protected $primaryKey='id';
    public $timestamps=false;
    protected $fillable=['username','cname1','cname2','iplan','ipwlan','wmac','lmac','comment','lastdate','za','status'];
}
