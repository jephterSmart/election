<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class LgaResultController extends Controller
{
    public function index(){
        $lgas = DB::table('lga')->get();
        return view('assessment2')
        ->with('lgas', $lgas);
    }

    public function getLgaPolls($id = null){
    
        if($id === null)
        { 
            $data = [];
        }else{
            $pollingUnits= DB::table('polling_unit')
                ->where('lga_id',$id)
                ->get(); 
                $totalVotesPerUnit = [];
                $partiesScores = [];
            foreach($pollingUnits as $unit){
                // dd($unit);
                $builder = DB::table('announced_pu_results')
                ->where('polling_unit_uniqueid', $unit->polling_unit_id);
                $totalVotesPerUnit[] = $builder->sum('party_score');
                $partiesScores[] = $builder->select('party_score','party_abbreviation')
                                ->get();

            }
            
            $totalVotesPerLga = array_sum($totalVotesPerUnit);
            // dd($totalVotesPerUnit,$totalVotesPerLga);
            
            $totalVotesPerPartyForLga = array_reduce($partiesScores, function($acc, $partiesScore){
                
                foreach($partiesScore as  $partyScore){
                    
                    $acc[$partyScore->party_abbreviation] = isset($acc[$partyScore->party_abbreviation]) ? 
                            $acc[$partyScore->party_abbreviation] + $partyScore->party_score : 
                            $partyScore->party_score ; 
                }
             

                return $acc;
    
            },[]);
            
            
            $data=[
                'lgaTotalVotes' => $totalVotesPerLga,
                'lgaTotalVotesPerParty' => $totalVotesPerPartyForLga
            ];
        }
       
        return response()->json($data,200);
        
    }

    public function create(){
        return view('assessment3')
                ->with('parties',DB::table('party')->get())
                ->with('states',DB::table('states')->get());
    }
    public function getLgasForState($id = null){
        if(is_null($id)){
            $data =[];
        }else{
            $data = DB::table('lga')->where('state_id', $id)->get();
        }
        return response()->json($data,200);
    }
    public function getWardsForLga($id = null){
        if(is_null($id)){
            $data =[];
        }else{
            $data = DB::table('ward')->where('lga_id', $id)->get();
        }
        return response()->json($data,200);
    }

    public function store(Request $request){
        
        $input = $request->validate([
            'ward'=>'required',
            'lga'=>'required',
            'unit_name'=>'required'
            
        ]);
       
       $id =  DB::table('polling_unit')
        ->insert([
            'ward_id' => $input('ward'),
            'lga_id'=> $input('lga'),
            'polling_unit_id' => 14,
            'polling_unit_name' => $input('unit_name'),
            'polling_unit_description' => "Created via web browser"
        ]);
    // $dataCount = DB::insert("insert INTO polling_unit (ward_id, lga_id) VALUE 
    // (?,?)",[$input('ward'),$input('lga')]);
        dd($dataCount);
        return "Polling unit successfully created!!! $dataCount";
    }
}

