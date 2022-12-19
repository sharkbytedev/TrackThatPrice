<div x-data="{open: false}" class="flex flex-row w-full dark:border-slate-600 dark:bg-slate-800 dark:text-slate-200 text-black bg-white border-b-2 fixed">
    {{-- Title --}}
    <div class="p-3 w-48 flex-none h-full justify-start">
        <div class="text-center mr-2 px-1 h-full">
            <b>Track That Price</b>
        </div>
    </div>
    {{-- Nav links --}}
    <div class="hidden sm:flex w-full h-full flex-row">
        <div class="flex-none w-32 text-center border-r-2 py-3 dark:border-slate-600">
            <x-nav-link :href="'#prices'" class="dark:text-slate-200 text-black">
                Prices
            </x-nav-link>
        </div>
    </div>
    
    {{-- Login/register button --}}
    <div class="fixed top-0 right-0 sm:static py-2 px-1 w-48 flex-none justify-end sm:justify-center sm:h-full border-l-2  dark:border-slate-600">
        <div class="text-center mr-2 px-1 h-full flex-row flex">
            @if(Auth::check())
                <a href="{{ route("dashboard") }}" class="flex-none">
                    <x-primary-button class="flex-none  dark:border-slate-200 mr-1">
                        <b>Dashboard</b>
                    </x-primary-button>
                </a>
            @else
                <a href="{{ route("register") }}" class="flex-none">
                    <x-primary-button class="flex-none  dark:border-slate-200 mr-1">
                        <b>Sign up</b>
                    </x-primary-button>
                </a>
                <a href="{{ route("login") }}" class="flex-none">
                    <x-primary-button class="flex-none  dark:border-slate-200">
                        <b>Log in</b>
                    </x-primary-button>
                </a>
            @endif
        </div>
    </div>
    
   
</div>