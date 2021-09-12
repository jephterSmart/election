<header class="fixed w-full h-16 flex justify-between items-center
top-0 bg-purple-500 text-white mb-4 px-12 left-0">
    <div>Assesments</div>
    
    <nav>
        <ul class="w-full list-none flex justify-start">
            <li class="px-2 mx-2 pb-2 {{ request()->route()->getName() === 'assessment.one' ? 'active' : '' }}" > 
                <a href="{{route('assessment.one')}}"  > Assessment 1 </a> </li>
            <li class="px-2 mx-2 pb-2 {{ request()->route()->getName() === 'assessment.two' ? 'active' : '' }} "> <a href="/2" > Assessment 2 </a> </li>
            <li class="px-2 mx-2 pb-2 {{ request()->route()->getName() === 'assessment.three' ? 'active' : '' }}"> <a href="/3"  > Assessment 3 </a> </li>
        </ul>
    </nav>
   
</header>
