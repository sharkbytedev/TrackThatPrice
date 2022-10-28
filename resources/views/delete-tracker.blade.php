<x-app-layout>
    <x-slot name="header">
        Delete tracker
    </x-slot>
    <div class="mt-2 w-full text-center mx-auto p-2">
        <h1 class="text-2xl w-full sm:text-center"><b>Are you sure you want to stop tracking this product?</b></h1>
        <h3 class="w-full text-center underline"><a href="{{ $product->product_url }}">{{ $product->product_name }}</a></h3>
        <br>
        <p>
            You will no longer recieve notifications about changes to the product's price. <br>
            Historical data will be kept, and can be viewed if you start tracking the product again.
        </p>
        <br>
        <x-primary-button onclick="window.history.back()">Nevermind</x-primary-button>
        <form class="inline" method="post">
            @csrf
            <x-primary-button>Yes, stop tracking</x-primary-button>
        </form>
    </div>
</x-app-layout>