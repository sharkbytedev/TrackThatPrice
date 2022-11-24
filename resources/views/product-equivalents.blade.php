<x-app-layout>
    <x-slot name="header">Other listings</x-slot>
    <div>
        @foreach (array_keys($products) as $key)
            <div class="bg-white rounded-md shadow-md w-full md:w-2/3 mx-auto mt-3 p-2">
                <p class="text-xl mx-auto text-center"><b>{{ ucfirst($key) }}</b></p>
                <div id="{{ $key }}-products sm:w-4/5">
                    <hr class="my-2">
                    @foreach ($products[$key] as $product)
                        <div class="w-full lg:w-4/5 bg-slate-100 p-2 rounded-md mx-auto my-2">
                            <div class="flex items-center">
                                <div class="w-3/4 items-center flex">
                                    <p class="underline hover:text-gray-500 overflow-hidden truncate"><a target="_blank" href="{{ $product->product_url }}">{{ $product->product_name }}</a></p>
                                </div>
                                <div class="w-1/4 justify-items-end flex">
                                    <div class="flex items-center ml-auto">
                                        <p class=" inline">{{ $product->price/100 }}</p>
                                        <button class="bg-white border-slate-500 hover:bg-slate-200 border-2 ml-2 px-1 float-right w-20">Tracking</button>
                                    </div>
                                </div>
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