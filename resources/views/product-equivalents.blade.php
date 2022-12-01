<x-app-layout>
    <x-slot name="header">Other listings</x-slot>
    <script>
        const csrf = '{{ csrf_token() }}';
        const base_url = '{{ route("trackers.quickTrack", ["product_id"=>"id"]) }}'.slice(0, -2);
    </script>
    @vite(['resources/js/quick_track.js'])
    <div>
        @foreach (array_keys($products) as $key)
            <div class="bg-white rounded-md shadow-md w-full md:w-2/3 mx-auto mt-3 p-2 relative">
                <p class="text-xl mx-auto text-center"><b>{{ ucfirst($key) }}</b></p>
                <button onclick="toggleTab('{{ $key }}')" id="{{ $key }}-open" class="absolute right-1 top-2 hover:bg-slate-300 rounded-md">
                    <img src="/images/chevron-up.svg" alt="" srcset="">
                </button>
                <button onclick="toggleTab('{{ $key }}')" id="{{ $key }}-close" class="hidden absolute right-1 top-2 hover:bg-slate-300 rounded-md">
                    <img src="/images/chevron-down.svg" alt="" srcset="">
                </button>
                <div id="{{ $key }}-products" class="">
                    <hr class="my-2">
                    @foreach ($products[$key] as $product)
                        <div class="w-full lg:w-4/5 bg-slate-100 p-2 rounded-md mx-auto my-2">
                            <div class="flex items-center">
                                <div class="w-2/3 md:w-3/4 items-center flex">
                                    <p class="underline hover:text-gray-500 overflow-hidden truncate"><a target="_blank" href="{{ $product->product_url }}">{{ $product->product_name }}</a></p>
                                </div>
                                <div class="w-1/3 md:w-1/4 justify-items-end flex">
                                    <div class="flex items-center ml-auto">
                                        <p class="inline">{{ $product->price/100 }}</p>
                                        <button
                                            id="{{ $product->id }}"
                                            onclick="trackProduct('{{ $product->id }}')"
                                            {{ $tracked->contains($product) ? 'disabled' : '' }}
                                            class="{{$tracked->contains($product)? 'bg-green-300 border-green-500' : 'enabled:hover:bg-slate-200 bg-white border-slate-500'}} border-2 ml-2 px-1 float-right w-20"
                                        >{{ $tracked->contains($product) ? 'Tracking' : 'Track' }}</button>
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
            console.log(`${store}-products`);
            let d = document.getElementById(`${store}-products`)
            console.log(d)
            let open = document.getElementById(`${store}-open`)
            let close = document.getElementById(`${store}-close`)
            if (d.style.display === 'none') {
                d.style.display = 'block';
                close.style.display = 'none';
                open.style.display = 'block';
            }
            else {
                d.style.display = 'none';
                open.style.display = 'none';
                close.style.display = 'block';
            }
        }
    </script>
</x-app-layout>