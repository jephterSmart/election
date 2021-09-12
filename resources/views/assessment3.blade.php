@extends('layouts.app')

@section('content')
    <main class="w-full px-4 mt-20">
        
        <h1 class="w-full text-center text-purple-500 font-bold text-xl">Welcome to Nigeria Polls Center </h1>
        <h2 class="pl-4 py-4 w-full  ">Assessment 3 - Register Parties for new Polling Units </h2>
            
          <form action="/3" method="post"  x-data="getFormData( {{ $states->toJson() }} )">
            @method('post')
              @csrf 
              <div  >
                <label for="state" class="block w-1/2 mx-auto my-4">Select State: </label>
                <select id="state"  x-model="stateId" @@change ="getLgas()" name="state"
                class="w-1/2 block p-4 border-2 border-grey-300 mx-auto focus:border-grey-500 mb-4 text-lg">
                    <option value="" selected="selected"> Select </option>
                    @foreach($states as $state)
                        <option value="{{ $state->state_id }}" 
                            class="bg-purple-500 text-white focus:bg-white focus:text-purple-500">
                            {{ $state->state_name  }}
                        </option>
                    @endforeach
                </select>
                
            </div>
            <div x-show="stateId !== '' " x-cloak>
                <label for="lga" class="block w-1/2 mx-auto my-4"
                x-text="`Select local government in ${stateName}`"></label>
                <select id="lga" x-model="lgaId" @@change="getWards()" name="lga"
                class="w-1/2 block p-4 border-2 border-grey-300 mx-auto focus:border-grey-500 mb-4 text-lg">
                    <option value="" selected="selected"> Select </option>
                    <template x-for="lga in lgas" :key="lga.lga_id">
                        <option :value="lga.lga_id" 
                            class="bg-purple-500 text-white focus:bg-white focus:text-purple-500"
                            x-text="lga.lga_name">
                            
                        </option>
                    </template>
                </select>
                
            </div>
            <div x-show="lgaId !== '' && stateId !== '' " >
                <label for="Ward" class="block w-1/2 mx-auto my-4"
                x-text="`Select Ward in ${lgaName}`"></label>
                <select id="ward" name="ward"
                class="w-1/2 block p-4 border-2 border-grey-300 mx-auto focus:border-grey-500 mb-4 text-lg">
                    <option value="" selected="selected"> Select </option>
                    <template x-for="ward in wards">
                        <option :value="ward.ward_id " 
                            class="bg-purple-500 text-white focus:bg-white focus:text-purple-500"
                            x-text="ward.ward_name">
                            
                        </option>
                    </template>
                </select>
                
            </div>
              <div x-show="lgaId !== '' && stateId !== '' " class="w-full">
                <label for='polling_unit_name' class="block w-1/2 mx-auto my-4" >Polling Unit Name</label>
                <input id='polling_unit_name'  x-model="unitName" name="unit_name"
                placeholder="The name of the polling unit to be created"
                class="w-1/2 block p-4 border-2 border-grey-300 mx-auto focus:border-grey-500 mb-4 text-lg"/>
              </div>
              <div x-show="unitName !== ''">
                <div class="w-full text-center text-lg">Type the party score for the registered party in the input box</div>
                <table class="w-full" >
                    <thead>
                        <tr><th class="w-1/2">Party Abbreviation</th>
                        <th class="w-1/2">Party Score</th></tr>
                    </thead>
                    <tbody>
                    @foreach($parties as $party)
                        @include('partytemplate')
                    @endforeach
                    </tbody>
                </table>
                
                <div class="text-center my-8"><button type='submit'
                class="rounded-md w-auto p-8 py-4 bg-purple-700 text-white text-md">Create new polling unit with scores </button>
              </div>

        </form>
        @push('functions')
            
              function getFormData(json){
                  return{
                      unitName:'',
                      stateId: '',
                      stateName: '',
                      states: JSON.parse(JSON.stringify(json)) || [],
                      lgaId:'',
                      lgaName:'',
                      lgas: [],
                      wards:[],
                      getLgas(){
                          let that = this;
                          
                          fetch('http://localhost:8000/api/get-lgas/'+that.stateId, {
                                header:{
                                    Accept: 'application/json'
                                }
                            })
                            .then(res => res.json())
                            .then(data => {
                                
                                that.stateName= that.states.find(state => {
                                   return state.state_id.toString() === that.stateId.toString()}).
                                        state_name;
                                  
                                    that.lgas = data;
                            } )
                            .catch(err=>{
                                console.log(err);
                            })
                      },
                      getWards(){
                          let that = this;
                         
                          fetch("http://localhost:8000/api/get-wards/"+that.lgaId, {
                                header:{
                                    Accept: 'application/json'
                                }
                            })
                            .then(res => res.json())
                            .then(data => {
                                console.log(data);
                                that.lgaName= that.lgas.find(lga => lga.lga_id == that.lgaId)?.
                                        lga_name;
                                that.wards= data;
                            } )
                            .catch(err=>{
                                console.log(err);
                            })
                      }
                  } //end of object
              } 
                
                
        @endpush
    </main>
@endsection