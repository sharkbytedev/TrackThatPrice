<x-guest-layout class="h-full">
    <div class="w-full h-full flex dark:bg-slate-800 dark:text-slate-200">
        <div class="w-10/12 lg:w-1/3 m-auto shadow rounded-xl p-5 bg-slate-50 dark:bg-slate-700">
            <h1 class="text-center w-full text-xl m-b"><b>Login</b></h1>
            <br>
            <form action="{{ route('login') }}" method="POST">
                @csrf
                <x-auth-validation-errors class="mb-4" :errors="$errors" />

                <div class="flex-col justify-center flex">
                    <x-text-input 
                        id="email" 
                        class="block dark:placeholder:text-slate-200 dark:bg-slate-700 mb-2 h-10" 
                        placeholder="Email" type="email" 
                        name="email" :value="old('email')" 
                        required 
                        autofocus 
                    />
                    <x-text-input 
                        id="password" 
                        class="block dark:placeholder:text-slate-200 dark:bg-slate-700 mt-1 h-10 w-full"
                        placeholder="Password"
                        type="password"
                        name="password"
                        required 
                        autocomplete="current-password" 
                    />
                    <div class="block mt-4">
                        <label for="remember_me" class="inline-flex items-center">
                            <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" name="remember">
                            <span class="ml-2 text-sm dark:text-slate-200">{{ __('Remember me') }}</span>
                        </label>
                    </div>
                    <div class="flex items-center justify-center mt-4">
                        <x-primary-button class="ml-3">
                            {{ __('Log in') }}
                        </x-primary-button>
                    </div>
                    <br>
                    <div class="w-full flex-row flex">
                        <div class="w-1/2 flex justify-start">
                            @if (Route::has('password.request'))
                                <a class="underline text-sm dark:text-slate-200 dark:hover:text-slate-300 text-gray-600 hover:text-gray-900" href="{{ route('password.request') }}">
                                    {{ __('Forgot your password?') }}
                                </a>
                            @endif
                        </div>
                        <div class="w-1/2 justify-end flex">
                            @if (Route::has('register'))
                                <a class="underline text-sm dark:text-slate-200 dark:hover:text-slate-300 text-gray-600 hover:text-gray-900" href="{{ route('register') }}">
                                    {{ __('Don\'t have an account?') }}
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>