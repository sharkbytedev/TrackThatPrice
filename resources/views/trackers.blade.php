<x-app-layout>
<!DOCTYPE html>
<x-slot name="header">Your Trackers:</x-slot>
<body>
<title> Trackers - TrackThatPrice </title>

<br>
@if (count($products) > 0)
    @for($i = 0; $i < count($products); $i++)
        <div class="border-solid border-2 border-blue-900 rounded p-1 mx-auto max-x-l">
            <img src="{{$products[$i]->image_url}}" class="border-solid border-2 border-blue-900 float-left w-32 h-32 object-contain">

            <p class="text-xl max-x-xl"> <!-- Large product name text -->
                @if(strlen($products[$i]->product_name) < 75)
                    {{$products[$i]->product_name}} 
                @else
                    {{(substr($products[$i]->product_name, 0, 75). "...")}}
                @endif
                <br>
            </p>

            <p> 
                {{$products[$i]->store}} <br>
                {{$products[$i]->price}} <br>
                <!-- {{$products[$i]->product_url}} -->
            </p>
        </div>
        <br>
    @endfor
@else
    <p> No products found </p>
@endif

</body>
</html>
</x-app-layout>