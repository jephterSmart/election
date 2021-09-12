@extends('layouts.app')

@section('content')
    <main class="w-full px-4 mt-20">
        
        <h1 class="w-full text-center text-purple-500 font-bold text-xl">Welcome to Nigeria Polls Center </h1>
        <h2 class="pl-4 py-4 w-48  ">Assessment 1 </h2>
            
        <div x-data="getState( {{ $units }} )"  >
            <label for="polling" class="block w-1/2 mx-auto my-4">Select polling unit: </label>
            <select x-model="unit"  id="polling" @@change="getVotes()"
            class="w-1/2 block p-4 border-2 border-grey-300 mx-auto focus:border-grey-500 mb-4 text-lg">
                <option value="" selected="selected"> Select </option>
                @foreach($units as $unit)
                    <option value="{{ $unit->uniqueid }}" 
                        class="bg-purple-500 text-white focus:bg-white focus:text-purple-500">
                        {{ $unit->polling_unit_name  }}
                    </option>
                @endforeach
            </select>
            <div x-show="unitName !== '' && unit !== '' "  
            class="mx-auto w-full md:w-1/2 rounded-md bg-purple-500 px-4 text-white pb-4">
                <div x-text="`Polling Unit - ${unitName}`"
                class="font-bold text-lg py-8 text-center"></div>
                <table class="w-full">
                    <thead>
                        <tr><th class="w-1/2">Party Abbreviation</th>
                        <th class="w-1/2">Party Score</th></tr>
                    </thead>
                    <tbody>
                        <template x-for="partyVotes in unitPolls" :key="partyVotes.result_id">
                            <tr> 
                                <td x-text="`${partyVotes.party_abbreviation}`"
                                class="w-1/2 text-center"></td>
                                <td x-text="`${partyVotes.party_score}`" class="text-center"></td>
                            </tr>
                        </template>
                    </tbody>
                </table>
                <div x-text="`Registered by - ${unitPolls[0]?.entered_by_user}`"
                class="text-md text-center mt-4 italic"></div>
        </div>
        @push('functions')
            
               
                
                function getState(json){
                    
                    return {
                        unit:'',
                        units: JSON.parse(JSON.stringify(json)),
                        unitName: '',
                        unitPolls: [],
                        getVotes: function(){
                            let that = this;
                            fetch('http://localhost:8000/api/unit-result/'+ that.unit,{
                                header:{
                                    Accept: 'application/json'
                                }
                            })
                            .then(res => {
                                
                                return res.json()})
                            .then(data => {
                                console.log(data);
                                if(data.length === 0){
                                    that.unitName='';
                                    that.unitPolls = data;
                                    return;
                                }
                                that.unitPolls = data;
                                that.unitName = that.units.find(unit => unit.uniqueid.toString() == that.unit).
                                                polling_unit_name;
                            })
                            .catch(err => {console.log(err)})
                        }
                    }
                }
            
        @endpush
    </main>
@endsection