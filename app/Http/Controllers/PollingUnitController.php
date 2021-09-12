<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PollingUnitController extends Controller
{
    public function index(){
        $units = DB::table('polling_unit')->get();
        return view('welcome')
        ->with('units', $units);
    }

    //This is going to be reached via a rest api endpoint to get record for a
    //particular unit
    public function getUnitPolls($id = null){
    
        if($id === null)
        { 
            $data = [];
        }else{
            $data = DB::table('announced_pu_results')
                ->where('polling_unit_uniqueid',$id)
                ->get(); 
        }
       
        return response()->json($data,200);
        
    }
}
