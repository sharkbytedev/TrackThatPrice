<div class="grid shadow rounded-xl m-2 bg-slate-50 md:flex md:p-1 md:mx-auto md:max-w-3xl overflow-hidden">
    @if($product->image_url != null)
        <img src="{{$product->image_url}}" class="justify-self-center bg-slate-200 rounded-xl w-32 h-32 object-contain break-after-column mt-1 md:mt-0 md:mr-1 md:float-left grow-0 shrink-0" alt="{{$product->product_name != null ? ($product->product_name . "Image") : "Product Image"}}">
    @else
        <img src="/images/ImagePlaceholder.svg" class="justify-self-center bg-slate-200 rounded-xl w-32 h-32 object-contain break-after-column mt-1 md:mt-0 md:mr-1 md:float-left grow-0 shrink-0" alt="Image not found!">
    @endif
    <div class="justify-items-center grid md:grow md:items-center md:justify-items-start px-2">
        <div class="w-full flex relative mt-2">
            <p class="w-3/4 text-xl max-w-xl text-left inline truncate {{$product->valid ? "" : "text-red-600"}}"> <!-- Large product name text -->
                @if (isset($product->pivot->tracker_name))
                    {{ $product->pivot->tracker_name }}
                @elseif (isset($product->product_name))
                    {{ $product->product_name }}
                @else
                    Name not specified
                @endif
    
                @if($product->valid != true)
                    <span class="inline">
                        <img src="/images/alert-triangle.svg" class="w-6 h-6" title="Tracker is missing information.  Product link may be invalid.">
                    </span>
                @endif
            </p>
    
            <p class="w-1/4 mr-1 self-center text-xl absolute right-0 text-right inline">
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

        </div>

        <a href="{{ route('trackers.view', ['product_id'=>$product->id]) }}" class="flex-none">
            <x-primary-button class="flex-none  dark:border-slate-200 mr-1">
                <b>Product Info</b>
            </x-primary-button>
        </a>
        <a href="{{ route('trackers.archive', ['product_id'=>$product->id])}}" class="flex-none">
            <x-primary-button class="flex-none  dark:border-slate-200 mr-1">
                <b>Archive</b>
            </x-primary-button>
        </a>
    </div>
</div>