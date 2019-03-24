<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class rycs_org extends Model
{
    protected $table='org';
    protected $primaryKey='id';
    public $timestamps=false;
    protected $fillable=['org_name','org_leading1','org_leading2','state','iconCls','url','nid'];
}
