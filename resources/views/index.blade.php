<x-guest-layout>
    <x-nav-bar/>
    <div class="dark:bg-slate-800 dark:text-slate-200">
        <br>
        <br>
        <br>
        <div id="about" class="text-center">
            {{-- Page header --}}
            <h1 class="text-2xl"><b>Track That Price</b></h1>
            <br>
            <div class="text-left sm:text-center w-4/5 sm:w-2/3 m-auto">
                <p class="w-full">
                    Track that price allows you to quickly and easily track price data for online products across a variety of different online stores.
                    Get notifications for price changes and view historical price data so that you know you're getting the best price. 
                </p>
            </div>
            <br>
            <br>
            {{-- Features section --}}
            <div id="features">
                <h3 class="text-xl"><b>Features</b></h3>
                <div class="sm:flex flex-column justify-center w-4/5 text-center m-auto">
                    <div class="border-0 p-4 w-full sm:w-1/3 m-2 rounded-xl shadow-md bg-slate-700 flex-none">
                        <b>Get notified</b>
                        <p class="text-left">Set when you want to be notified about a price change, and we'll let you know via email and/or desktop notification.</p>
                        <div class="justify-center flex text-center w-full">
                            <img class="select-none m-2" src="/images/bell.svg" alt="" srcset="">
                        </div>
                    </div>
                    <div class="border-0 p-4 w-full sm:w-1/3 m-2 rounded-xl shadow-md bg-slate-700 flex-none">
                        <b>Wide support</b>
                        <p class="text-left">With over {insert number of stores} stores supported, you can track prices on any of your favourite online stores.</p>
                        <div class="justify-center flex text-center w-full">
                            <img class="select-none m-2" src="/images/tool.svg" alt="" srcset="">
                        </div>
                    </div>
                    <div class="border-0 p-4 w-full sm:w-1/3 m-2 rounded-xl shadow-md bg-slate-700 flex-none">
                        <b>Historical data</b>
                        <p class="text-left">See the history of the price of a product, with data being collected as long as someone is tracking that product.</p>
                        <div class="justify-center flex text-center w-full">
                            <img class="select-none m-2" src="/images/bar-chart-2.svg" alt="" srcset="">
                        </div>
                    </div>
                </div>
            </div>
            <br>
            <br>
            {{-- Prices --}}
            <div id="prices">
                <h3 class="text-xl"><b>Pricing</b></h3>
                <div class="w-5/6 sm:w-2/3 m-auto sm:flex flex-column sm:flex-row justify-center">
                    <div class="dark:bg-slate-700 my-2  sm:my-2 sm:mx-2 p-2 w-full sm:w-1/2 flex-none shadow-md rounded-xl bg-slate-50">
                        <p class="text-lg"><b>Basic</b></p>
                        <div class="text-left">
                            <p><img class="inline m-1 select-none" src="/images/check.svg" alt=""/>Track any product</p>
                            <p><img class="inline m-1 select-none" src="/images/check.svg" alt=""/>View historical price data</p>
                            <p><img class="inline m-1 select-none" src="/images/check.svg" alt=""/>Get notifications about price changes</p>
                            <br>
                            <div class="text-center">
                                <p class="text-2xl">Price: $0.00</p>
                            </div>
                        </div>
                    </div>
                    <div class="dark:bg-slate-700 my-2  sm:my-2 sm:mx-2 p-2 w-full sm:w-1/2 flex-none shadow-md rounded-xl bg-slate-50">
                        <p class="text-lg"><b>Premium</b></p>
                        <div class="text-left">
                            <p><img class="inline m-1 select-none" src="/images/check.svg" alt=""/>More frequent price updates</p>
                            <p><img class="inline m-1 select-none" src="/images/check.svg" alt=""/>TBD</p>
                            <p><img class="inline m-1 select-none" src="/images/check.svg" alt=""/>TBD</p>
                            <br>
                            <div class="text-center">
                                <p class="text-2xl">Price: $TBD<span class="text-sm"> / month</span></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <br>
        <br>
        <br>
    </div>
</x-guest-layout>