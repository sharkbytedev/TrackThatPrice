<x-app-layout>
    <!DOCTYPE html>
        <x-slot name="header">
            <div class="w-full h-full flex flex-row">
                <h2 class="w-1/2 font-semibold text-xl text-gray-800 leading-tight justify-self-start dark:bg-gray-800 dark:text-slate-200">Your Trackers</h2>  
                <div class="w-1/2 h-full justify-items-end dark:bg-gray-800 dark:text-slate-200">
                    <a href="{{ route("trackers.new") }}" class="float-right">
                        <x-primary-button class="dark:border-slate-200 mr-1">
                            <b>Create a Tracker</b>
                        </x-primary-button>
                    </a>
                </div>
            </div>
        </x-slot>
        <body>
        
        <br>
        @if (count($products) > 0)
            @foreach($products as $product)
                @if($product->pivot->archived == false)
                    <div class="grid shadow rounded-xl m-2 bg-slate-50 md:flex md:p-1 md:mx-auto md:max-w-3xl overflow-hidden dark:bg-gray-700 dark:text-slate-200">
                        @if($product->image_url != null)
                            <img src="{{$product->image_url}}" class="justify-self-center bg-slate-200 rounded-xl w-32 h-32 object-contain break-after-column mt-1 md:mt-0 md:mr-1 md:float-left grow-0 shrink-0 dark:bg-gray-600" alt="{{$product->product_name != null ? ($product->product_name . "Image") : "Product Image"}}">
                        @else
                            <img src="/images/ImagePlaceholder.svg" class="justify-self-center bg-slate-200 rounded-xl w-32 h-32 object-contain break-after-column mt-1 md:mt-0 md:mr-1 md:float-left grow-0 shrink-0 dark:bg-gray-600" alt="Image not found!">
                        @endif
                        <div class="justify-items-center grid md:grow md:items-center md:justify-items-start">

                            <a href="{{ route('trackers.view', ['product_id'=>$product->id]) }}" class="hover:underline">    
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
                            </a>

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
                            <div>
                                <a href="{{ route('trackers.view', ['product_id'=>$product->id]) }}">
                                    <x-primary-button class="dark:border-slate-200 mr-1">
                                        <b>Product Info</b>
                                    </x-primary-button>
                                </a>
                                <a href="{{ route('trackers.archive', ['product_id'=>$product->id])}}">
                                    <x-primary-button class="dark:border-slate-200 mr-1">
                                        <b>Archive</b>
                                    </x-primary-button>
                                </a>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        @endif

        @if(auth()->user()->products()->wherePivot('archived', '1')->get()->first())
        <div class="mx-auto h-max md:max-w-3xl justify-items-end dark:bg-gray-800 dark:text-slate-200">
            <a href="{{ route("trackers.archived") }}" class="flex justify-end dark:bg-gray-800 dark:text-slate-200">
                <div class="flex text-slate-400  hover:underline">
                    <b>Archived ({{auth()->user()->products()->wherePivot('archived', '1')->get()->count()}})</b>
                </div>
            </a>
        </div>
        @endif

        @if(auth()->user()->products()->wherePivot('archived', '0')->get()->first() == false) <!-- if there aren't any unarchived trackers -->
            <p class="justify-items-center grid dark:bg-gray-800 dark:text-slate-200"> No trackers found! Create one using the "Create A Tracker" button! </p>
            <a href="{{ route("trackers.new") }}" class="justify-items-center grid dark:bg-gray-800 dark:text-slate-200">
                <x-primary-button class="flex-none  dark:border-slate-200 mr-1">
                    <b>Create a Tracker</b>
                </x-primary-button>
            </a>
        @endif

        </body>
    </html>
</x-app-layout>