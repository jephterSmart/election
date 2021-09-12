@extends('layouts.app')

@section('content')
    <main class="w-full px-4 mt-20">
        
        <h1 class="w-full text-center text-purple-500 font-bold text-xl">Welcome to Nigeria Polls Center </h1>
        <h2 class="pl-4 py-4 w-48  font-2xl">Assessment 2 </h2>
            
        <div x-data="getData( {{ $lgas }} )" x-cloak >
            <label for="polling" class="block w-1/2 mx-auto my-4">Select local government area (LGA): </label>
            <select x-model="lga"  id="polling" @@change="getVotes()"
            class="w-1/2 block p-4 border-2 border-grey-300 mx-auto focus:border-grey-500 mb-4 text-lg">
                <option value="" selected="selected"> Select LGA </option>
                @foreach($lgas as $lga)
                    <option value="{{ $lga->lga_id }}" 
                        class="bg-purple-500 text-white focus:bg-white focus:text-purple-500">
                        {{ $lga->lga_name  }} in Delta
                    </option>
                @endforeach
            </select>
            <div x-show="lgaName !== '' && lga !== '' "  
            class="mx-auto w-full md:w-1/2 rounded-md bg-purple-500 px-4 text-white pb-4">
                <div x-text="`Polling lga - ${lgaName}`"
                class="font-bold text-lg py-8 text-center"></div>
                <table class="w-full" x-show="lgaTotalVotes > 0">
                    <thead>
                        <tr><th class="w-1/2">Party Abbreviation</th>
                        <th class="w-1/2">Party Score</th></tr>
                    </thead>
                    <tbody>
                        <template x-for="partyVotes, ind in lgaPolls" :key="ind">
                            <tr> 
                                <td x-text="`${ind}`"
                                class="w-1/2 text-center"></td>
                                <td x-text="`${partyVotes}`" class="text-center"></td>
                            </tr>
                        </template>
                    </tbody>
                </table>
                <div x-text="`The total number of voters is - ${lgaTotalVotes}`"
                class="text-lg text-center mt-4 italic" x-show="lgaTotalVotes > 0"></div>
                <div x-show="lgaTotalVotes === 0"
                class="text-2xl text-center mt-4 italic"> 
                There are no records for this local government area</div>
        </div>
        @push('functions')
            
               
                
                function getData(json){
                    
                    return {
                        lga:'',
                        lgas: JSON.parse(JSON.stringify(json)),
                        lgaName: '',
                        lgaPolls: [],
                        lgaTotalVotes: 0,
                        getVotes: function(){
                            let that = this;
                            fetch('http://localhost:8000/api/lga-results/'+ that.lga,{
                                header:{
                                    Accept: 'application/json'
                                }
                            })
                            .then(res => {
                                
                                return res.json()})
                            .then(data => {
                                console.log(data);
                                if(data.length === 0){
                                    that.lgaName='';
                                    that.lgaPolls = data.lgaTotalVotesPerParty;
                                    that.lgaTotalVotes = data.lgaTotalVotes;
                                    return;
                                }
                                that.lgaPolls = data.lgaTotalVotesPerParty;
                                that.lgaTotalVotes = data.lgaTotalVotes;
                                that.lgaName = that.lgas.find(lga => lga.lga_id.toString() == that.lga).
                                                lga_name;
                                console.log(that.lgaName, that.lga);
                            })
                            .catch(err => {console.log(err)})
                        }
                    }
                }
            
        @endpush
    </main>
@endsection