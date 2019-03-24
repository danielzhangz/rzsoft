<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class rycs_group extends Model
{
    protected $table='group';
    protected $primaryKey='id';
    public $timestamps=false;
    protected $fillable=['js_name','js_auth'];
}
