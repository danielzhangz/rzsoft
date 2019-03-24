<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\iptable;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;

class iptableController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {

         $input = Input::except('_token');
//        $ar1=[#input['id'],];
        iptable::create($input);
        return 1;

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
       $result=DB::table('iptable')->where('id',$id)->get();
        return $result;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

//        $input = Input::except('_token');


//        $iptable= iptable::find($id);
//        if  ($iptable->update($input)){
//            return 1;
//        }else{
//            return 0;
//        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

    }

    public function getnewip($wd)
    {
        $fip="10.3.".$wd.".";
//        echo $fip;
        if($wd==20 or $wd==21 or $wd==26) {
            $result = DB::select("select SUBSTR(iplan,9) as iplan from rycs_iptable where iplan like '$fip%' ");
        }else{
            $result = DB::select("select SUBSTR(ipwlan,9) as iplan from rycs_iptable where ipwlan like '$fip%' ");
        }
//        dd($result);
        $findip = 0;
        for ($i = 31; $i < 210; $i++) {
            $finded = 0;
            foreach ($result as $value) {
                $v = $value->iplan;

                if ($i == $v) {
                    $finded = 1;
                    break 1;
                }
            }
            if ($finded == 0) {
                $findip = $i;
                break;
            }
        }
        return $findip;
    }

//    public function getwd()
//    {
//        $result = DB::select("select right(wd,2) as wd from rycs_wd");
//        return json_encode($result);
//    }

}
