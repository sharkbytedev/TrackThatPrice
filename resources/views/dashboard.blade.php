<x-app-layout>
<!DOCTYPE html>
<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">Your Trackers</h2>
    <a href="{{ route("trackers.new") }}" class="flex-none">
        <x-primary-button class="flex-none  dark:border-slate-200 mr-1">
            <b>Create a Tracker</b>
        </x-primary-button>
    </a>

    @if(auth()->user()->products()->wherePivot('archived', '1')->get()->first())
        <a href="{{ route("trackers.archived") }}" class="flex-none">
            <x-primary-button class="flex-none  dark:border-slate-200 mr-1">
                <b>Archived Trackers</b>
            </x-primary-button>
        </a>
    @endif
</x-slot>
<body>

<br>
@if (count($products) > 0)
    @foreach($products as $product)
        @if($product->pivot->archived == false)
            <x-product-card :product="$product" />
        @endif
    @endforeach
@else
    <p class="justify-items-center grid"> No trackers found! Create one using the "Create A Tracker" button! </p>
@endif

</body>
</html>
</x-app-layout>