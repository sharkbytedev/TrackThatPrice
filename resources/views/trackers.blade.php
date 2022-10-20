<x-app-layout>
<!DOCTYPE html>
<x-slot name="header">Your Trackers:</x-slot>
<body>
<title> Trackers - TrackThatPrice </title>

<br>
@if (count($products) > 0)
    @foreach($products as $product)
        <div class="border-solid border-2 border-blue-900 rounded p-1 mx-auto max-w-3xl overflow-hidden">
            <img src="{{$product->image_url}}" class="border-solid border-2 border-blue-900 float-left w-32 h-32 object-contain mr-1">

            <p class="text-xl max-x-xl"> <!-- Large product name text -->
                @if(strlen($product->product_name) < 75)
                    {{$product->product_name}} 
                @else
                    {{(substr($product->product_name, 0, 75). "...")}}
                @endif
                <br>
            </p>

            <p> 
                {{$product->store}} <br>
                {{$product->price / 100 . "$"}} <br>
                <!-- {{$product->product_url}} -->
            </p>
        </div>
        <br>
    @endforeach
@else
    <p> No products found </p>
@endif

</body>
</html>
</x-app-layout>