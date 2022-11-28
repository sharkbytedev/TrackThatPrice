<x-app-layout>
<!DOCTYPE html>
<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">Your Trackers</h2>
</x-slot>
<body>

<br>
@if (count($products) > 0)
    @foreach($products as $product)
        <div class="grid shadow rounded-xl m-2 bg-slate-50 md:flex md:p-1 md:mx-auto md:max-w-3xl overflow-hidden">
            @if($product->image_url != null)
                <img src="{{$product->image_url}}" class="justify-self-center bg-slate-200 rounded-xl w-32 h-32 object-contain break-after-column mt-1 md:mt-0 md:mr-1 md:float-left grow-0 shrink-0" alt="{{$product->product_name != null ? ($product->product_name . "Image") : "Product Image"}}">
            @else
                <img src="/images/ImagePlaceholder.svg" class="justify-self-center bg-slate-200 rounded-xl w-32 h-32 object-contain break-after-column mt-1 md:mt-0 md:mr-1 md:float-left grow-0 shrink-0" alt="Image not found!">
            @endif
            <div class="justify-items-center grid md:grow md:items-center md:justify-items-start">
                <p class="flex text-xl md:max-w-xl text-center md:text-left {{$product->valid ? "" : "text-red-600"}}"> <!-- Large product name text -->
                    @if(mb_strlen($product->pivot->tracker_name) < 65)
                        {{$product->pivot->tracker_name}} 
                    @else
                        {{(mb_substr($product->pivot->tracker_name, 0, 65). "...")}}
                    @endif

                    @if($product->valid != true)
                    <span class="inline-flex">
                        <img src="/images/alert-triangle.svg" class="w-6 h-6" title="Tracker is missing information.  Product link may be invalid.">
                    </span>
                @endif
                </p>

                <p class="text-3xl self-center md:ml-auto md:mr-0 md:text-xl">
                    @if($product->price != null)
                        @if(strlen($product->price) < 7)
                            {{$product->price / 100 . "$"}}
                        @else
                            {{(substr($product->price / 100, 0, 7). "...$")}}
                        @endif
                    @else
                        N/A
                    @endif
                </p>

                <a href="{{ route('dashboard.view', ['product_id'=>$product->id]) }}" class="flex-none">
                    <x-primary-button class="flex-none  dark:border-slate-200 mr-1">
                        <b>Product Info</b>
                    </x-primary-button>
                </a>
            </div>
        </div>
    @endforeach
@else
    <p> No products found! </p>
@endif

</body>
</html>
</x-app-layout>