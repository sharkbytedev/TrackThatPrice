<x-guest-layout class="h-full">
    <div class="w-full h-full flex dark:bg-slate-800 dark:text-slate-200">
        <div class="w-10/12 lg:w-1/3  m-auto shadow rounded-xl p-5 dark:bg-slate-700 bg-slate-50">
            <h1 class="text-center w-full text-xl m-b"><b>Register</b></h1>
            <br>
            <form action="{{ route('register') }}" method="POST">
                @csrf
                <x-auth-validation-errors class="mb-4" :errors="$errors" />

                <div class="flex-col justify-center flex">
                    <x-text-input id="name" class="dark:bg-slate-700 dark:placeholder:text-slate-200 block mb-2 w-full" type="text" name="name" :value="old('name')" placeholder="Name" required autofocus />
                    <x-text-input 
                        id="email" 
                        class="dark:bg-slate-700 dark:placeholder:text-slate-200 block mb-2 h-10" 
                        placeholder="Email" type="email" 
                        name="email" :value="old('email')" 
                        required 
                        autofocus 
                    />
                    <x-text-input 
                        id="password" 
                        class="dark:bg-slate-700 dark:placeholder:text-slate-200 block mb-2 h-10 w-full"
                        placeholder="Password"
                        type="password"
                        name="password"
                        required 
                        autocomplete="current-password" 
                    />
                    <x-text-input 
                        id="password_confirmation" 
                        class="dark:bg-slate-700 dark:placeholder:text-slate-200 block w-full mb-2"
                        type="password"
                        placeholder="Confirm password"
                        name="password_confirmation" 
                        required 
                    />

                    <div class="flex items-center justify-center mt-4">
                        <x-primary-button class="ml-3">
                            {{ __('Register') }}
                        </x-primary-button>
                    </div>
                    <br>
                    <div class="w-full flex-row flex">
                        <div class="w-1/2 justify-start flex">
                            @if (Route::has('login'))
                                <a class="underline text-sm dark:text-slate-200 dark:hover:text-slate-300 text-gray-600 hover:text-gray-900" href="{{ route('login') }}">
                                    {{ __('Already have an account?') }}
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>