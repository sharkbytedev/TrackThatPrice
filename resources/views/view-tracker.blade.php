<x-app-layout>
    <x-slot name="header">
        {{ $product->product_name }}
    </x-slot>
    <div class="p-3 border-t bg-white">
        <h1 class="w-full text-center text-2xl">
            <b>
                <a class="underline hover:text-gray-500 {{ $product->valid ? '' : 'text-red-500' }}" href="{{ $product->product_url }}" target="_blank">{{ $product->product_name }} </a>
            </b>
            <button type="button">
                <img src="/images/alert-triangle.svg" alt="Alert: Product is invalid" class="m-auto inline mx-2">
            </button>
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
        <h3 class="w-full text-center text-xl"><b>Historical data</b></h3>
        <div class="m-auto p-9 text-center w-1/3 bg-slate-200">
            <h1 class="text-xl">Coming soon</h1>
        </div>
    </div>
</x-app-layout>