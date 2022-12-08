<x-app-layout>
    <x-slot name="header">
        <div class="w-full h-full flex flex-row">
            <div class="w-1/2 h-full overflow-hidden text-ellipsis px-1">
                <p>{{ $product->product_name }}</p>
            </div>
            <div class="w-1/2 h-full justify-items-end">
                <a href="{{ route('trackers.remove', ['product_id'=>$product->id]) }}">
                    <button class="float-right p-1 hover:bg-slate-200 rounded" type="button">
                        <img src="/images/trash-2.svg" width="20" height="20"  alt="Delete tracker">
                    </button>
                </a>
                <a href="{{ route('trackers.update', ['product_id'=>$product->id]) }}">
                    <button class="float-right p-1 hover:bg-slate-200 rounded">
                        <img src="/images/settings.svg" width="20" height="20" alt="Update tracker">
                    </button>
                </a>
            </div>
        </div>
    </x-slot>
    <div class="p-3 border-t">
        <h1 class="w-full text-center text-2xl">
            <b>
                <a class="underline hover:text-gray-500 {{ $product->valid ? '' : 'text-red-500' }} break-words" href="{{ $product->product_url }}" target="_blank">{{ $product->product_name }} </a>
            </b>
            @if (!$product->valid)
                <a href="#invalidNotice">
                    <button type="button">
                        <img src="/images/alert-triangle.svg" alt="Alert: Product is invalid" class="m-auto inline mx-2">
                    </button>
                </a>
            @endif
        </h1>
        @if (isset($product->price))
            <h3 class="w-full text-center text-xl">Most recent price: {{$product->price/100.0}}</h3>
            <p class="w-full text-center text-sm text-gray-500">Last updated: {{$product->updated_at}}</p>
        @else
            <h3>No price data currently. Check back later</h3>
        @endif

        @if (isset($product->image_url))
            <img class="m-auto" src="{{ $product->image_url }}" alt="{{ $product->product_name }}">
        @endif
        <br>
        <div class="m-auto p-2 w-1/2 bg-slate-200 relative">
            @if (count($prices) <= 0)
                <div class="text-center w-full h-full absolute left-0 z-10 top-0 backdrop-blur-sm table">
                    <span class="text-2xl table-cell align-middle">There is currently no price history</span>
                </div>
            @endif
            <h3 class="w-full text-center text-xl"><b>Historical data</b></h3>
            <canvas id="priceHistory" class="m-auto text-center w-full bg-slate-200">
            </canvas>
            <div>
                <button id="YTDButton" title="Show data from the past 12 months" class="bg-slate-300 mx-1 p-2 rounded-lg hover:bg-slate-400">Year</button>
                <button id="monthButton" title="Show data from the past 30 days" class="bg-slate-300 mx-1 p-2 rounded-lg hover:bg-slate-400">Month</button>
                <button id="weekButton" title="Show data from the past 7 days" class="bg-slate-300 mx-1 p-2 rounded-lg hover:bg-slate-400">Week</button>
            </div>
        </div>
    </div>
    @if (!$product->valid)
        <div class="mx-2 sm:w-1/2 sm:mx-auto mt-3 shadow rounded-md p-3 bg-slate-200" id="invalidNotice">
            <h3 class="w-full text-center text-xl"><b>Invalid product</b></h3>
            <p>
                This product is no longer valid, meaning we could not get the required from the store.
                Please make sure the product still exists at the link you provided. If it does not, delete this tracker and make a new one with the updated link
            </p>
            <p>
                If this is a problem on our end, we will be fix it as soon as possible. 
                You can still view the last known product information and historical data, however it will likely become out of date.
            </p>
        </div>
    @endif
    <script>
        const raw_prices = {{ json_encode($prices) }};
        const raw_timestamps = {!! json_encode($labels, JSON_HEX_TAG) !!};
    </script>
    @if (isset($target))
        <script>
            const raw_target_data = {!! json_encode($target, JSON_HEX_TAG) !!};
        </script>
    @else
        <script>
            const raw_target_data = null;
        </script>
    @endif
    @vite(['resources/js/graphs/priceHistory.js'])
</x-app-layout>