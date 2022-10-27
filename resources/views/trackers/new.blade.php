<x-app-layout>
<!DOCTYPE html>
<x-slot name="header">Create New Tracker</x-slot>
<body>
    <div class="flex grid items-center justify-items-center">
        <form method="post" action="">
            @csrf
            Product URL: <input type="text" name="productURL" class="my-2"><br>
            Store: <select name="store" class="my-2">
                <option value="">Select a store</option>
                <option value="amazon">Amazon</option>
                <option value="ebay">Ebay</option>
                <option value="wayfair">Wayfair</option>
            </select><br>
            <input type="submit" value="Submit" name="Submitted">
        </form> 

        @if($productCreated)
            <p> {{$product->product_name . " tracker created successfully!"}} </p>
        @endif
    </div>
</body>
</html>
</x-app-layout>