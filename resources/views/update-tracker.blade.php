<x-app-layout>
    <x-slot name="header">
        Update tracker
    </x-slot>
    <div class="h-full bg-white rounded-md p-2 mt-3 mx-auto w-full sm:w-1/2 shadow">
        <h1 class="w-full text-center">Update tracker settings</h1>
        <form method="POST" action="{{ route('trackers.edit', ['product_id'=>$tracker->product_id]) }}">
            @csrf
            @method('PATCH')
            <style>
                /* For hiding arrow buttons in number input */
                input::-webkit-outer-spin-button,
                input::-webkit-inner-spin-button {
                    -webkit-appearance: none;
                    margin: 0;
                }

                input[type=number] {
                    -moz-appearance: textfield;
                }
            </style>
            <label for="trackerName">Tracker name:</label>
            <br>
            <input class="rounded-md h-8" type="text" name="Tracker name" id="trackerName" value="{{ $tracker->tracker_name }}">
            <br>
            <sub>Name to give the tracker. This is different from the product name.</sub>
            <br>
            <br>
            <label for="compareDate">Compare date:</label>
            <br>
            <input class="rounded-md h-8" type="date" name="Compare date" id="compareDate" value="{{ explode(' ', $tracker->compare_time)[0] }}">
            <br>
            <sub>The date to use while watching for price drops.</sub>
            <br>
            <br>
            <div class="align-middle">
                <span class="mr-2 inline">Notify me when the price drops by:</span>
                <br>
                <div class="flex">
                    <input class="rounded-l-md h-8 p-0 inline border-r-0 text-center" style="width:3.5rem;" min="1" max="10" type="number" id="value" value="{{ $tracker->threshold }}">
                    <select class="rounded-r-md h-8 inline text-sm border-l-0" name="Compare type" id="type">
                        <option @selected($tracker->type == 'percent') value="percent">%</option>
                        <option @selected($tracker->type == 'flat') value="flat">$</option>
                    </select>
                </div>
            </div>
            <br>
            <div>
                <x-primary-button class="inline">Save</x-primary-button>
                <x-primary-button class="inline" onclick="window.history.back()">Cancel</x-primary-button>
            </div>

        </form>
    </div>
</x-app-layout>