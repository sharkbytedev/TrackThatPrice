<x-app-layout>
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
    <div class="w-full md:w-2/3 m-auto">
        @foreach($products as $product)
            <x-product-card :product="$product" />
        @endforeach
        <div class="w-full flex align-middle">
            <div class="w-4/5 inline">
                {{ $products->links() }}
            </div>
            <div class="inline h-full align-middle">
                <a href="{{ route('trackers.archived') }}">
                    <button class="text-xs bg-slate-200 mt-1 mx-2 p-2">Archived trackers ({{ $archived_count }})</button>
                </a>
            </div>
        </div>
    </div>
@else
    <p class="justify-items-center grid"> No trackers found! Create one using the "Create A Tracker" button! </p>
@endif

</body>
</x-app-layout>