page for creating a new tracker
<!DOCTYPE html>
<body>

<form method="post" action="\routes\web.php">
    @csrf
    Product URL: <input type="text" name="productURL"><br>
    Store: <select name="store">
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

</body>
</html>