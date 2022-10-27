<x-app-layout>
<!DOCTYPE html>
<x-slot name="header">Your Trackers</x-slot>
<body>
<title> Trackers - TrackThatPrice </title>

<br>
@if (count($products) > 0)
    @foreach($products as $product)
        <div class="grid border-solid border-2 border-blue-900 m-2 rounded md:flex md:p-1 md:mx-auto md:max-w-3xl overflow-hidden">
            <img src="{{$product->image_url}}" class="justify-self-center border-solid border-2 border-blue-900 w-32 h-32 object-contain break-after-column md:mr-1 md:float-left grow-0 shrink-0" alt="{{$product->product_name}}">
            <div class="justify-items-center grid md:grow md:items-center md:justify-items-start">
                <p class="flex text-xl md:max-w-xl text-center md:text-left"> <!-- Large product name text -->
                    @if(mb_strlen($product->product_name) < 65)
                        {{$product->product_name}} 
                    @else
                        {{(mb_substr($product->product_name, 0, 65). "...")}}
                    @endif
                </p>

                <p class="text-3xl self-center md:ml-auto md:mr-0 md:text-xl">
                    @if(strlen($product->price) < 6)
                        {{$product->price / 100 . "$"}}
                    @else
                        {{(substr($product->price / 100, 0, 7). "...$")}}
                    @endif
                </p>

                <button class="rounded-md bg-sky-400 self-bottom max-w-[20%] md:py-2">
                    Product Info
                </button>
            </div>
        </div>
        <br>
    @endforeach
@else
    <p> No products found </p>
@endif

</body>
</html>
</x-app-layout>