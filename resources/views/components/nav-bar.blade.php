<div x-data="{open: false}" class="flex flex-row w-full bg-white border-b-2 fixed">
    {{-- Title --}}
    <div class="p-3 w-48 flex-none h-full justify-start">
        <div class="text-center mr-2 px-1 h-full">
            <b>Track That Price</b>
        </div>
    </div>
    {{-- Nav links --}}
    <div class="w-full h-full flex flex-row">
        <div class="flex-none w-32 text-center border-x-2 py-3">
            <x-nav-link :href="'#about'" class="text-black">
                About
            </x-nav-link>
        </div>
        <div class="flex-none w-32 text-center border-r-2 py-3">
            <x-nav-link :href="'#prices'" class="text-black">
                Prices
            </x-nav-link>
        </div>
    </div>
    
    {{-- Login/register button --}}
    <div class="py-2 px-1 w-48 flex-none justify-center h-full border-l-2">
        <div class="text-center mr-2 px-1 h-full flex-row flex">
            
            <a href="{{ route("register") }}" class="flex-none">
                <x-primary-button class="flex-none mr-1">
                    <b>Sign up</b>
                </x-primary-button>
            </a>
            <a href="{{ route("login") }}" class="flex-none">
                <x-primary-button class="flex-none">
                    <b>Log in</b>
                </x-primary-button>
            </a>
        </div>
    </div>
    
   
</div>