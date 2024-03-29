<x-app-layout class="bg-white">
    <x-slot name="header">
        <h1 class="text-xl">Track a product</h1>
        <a href="{{ route("dashboard") }}" class="flex-none">
            <x-primary-button class="flex-none  dark:border-slate-200 mr-1">
                <b>All Trackers</b>
            </x-primary-button>
        </a>
    </x-slot>
    <div class="w-full">
        <div class=" h-10/12 w-fit m-auto shadow rounded-xl mt-5 p-5 bg-slate-50">
            <form action="" method="post">
                @csrf
                <div class="flex-column">
                    <label for="trackerName">Tracker name:</label><br>
                    <input id="trackerName" name="trackerName" class="rounded-lg h-7 mb-5" type="text" required><br>
                    <label for="productURL">Product URL:</label><br>
                    <input
                        type="url"
                        id="productURL"
                        name="productURL"
                        placeholder="URL"
                        class="rounded-lg h-7 mb-5"
                        required
                    >
                    <br>
                    <div class="w-full flex-row">
                        <select class="h-9 text-sm mb-5" name="store" id="store" required>
                            <option value="" disabled selected>Select a store</option>
                            <option value="amazon">Amazon</option>
                            <option value="ebay">Ebay</option>
                            <option value="alibaba">Alibaba</option>
                        </select>
                        <button class="bg-white ml-5 h-9 border border-black disabled:border-gray-500 p-1 disabled:text-gray-500" id="submit" name="submit" type="submit" disabled>Create tracker</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @if(isset($warnings))
        <p class="flex justify-center text-center">
            @foreach($warnings as $warning)
                {{"Product could not be created.  Reason: " . $warning}}
                <br>
            @endforeach
        </p>
    @endif
    <script src="{{ asset('js/new-tracker-page.js') }}"></script>
</x-app-layout>
