<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class employee extends Model
{
    protected $table='employee';
    protected $primaryKey='id';
    public $timestamps=false;
    protected $fillable=['login_name','name','dept_id','entry_time','comment','user_pass','auth','js_auth'];
}
