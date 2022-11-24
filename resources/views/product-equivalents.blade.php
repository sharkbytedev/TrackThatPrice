<x-app-layout>
    <x-slot name="header">Other listings</x-slot>
    <div>
        @foreach (array_keys($products) as $key)
            <div class="bg-white rounded-md shadow-md w-2/3 mx-auto mt-3 p-2">
                <p class="text-xl mx-auto text-center"><b>{{ ucfirst($key) }}</b></p>
                <div id="{{ $key }}-products">
                    <hr class="my-2">
                    @foreach ($products[$key] as $product)
                        <div class="w-4/5 bg-slate-100 p-2 rounded-md mx-auto my-2">
                            <div class="flex items-center">
                                <p class="overflow-hidden truncate"><a href="{{ $product->product_url }}">{{ $product->product_name }}</a></p>
                                <button class="bg-white border-slate-500 hover:bg-slate-200 border-2 m-2 px-1">Track</button>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach

    </div>
    <script>
        const toggleTab = (store) => {
            let d = document.getElementById(`${store}-products`)
            if (d.style.display === 'none') d.style.display = 'block';
            else d.style.display = 'none';
        }
    </script>
</x-app-layout>