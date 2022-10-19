page for creating a new tracker
<!DOCTYPE html>
<body>
<?php 
use App\ProductHandlers\Details;
use Illuminate\Support\Facades\Auth;

if (Auth::check() == false){
    header("Location: localhost:8000/login");
    exit();
}
?>

<form method="get" action="<?=$_SERVER["PHP_SELF"]?>">
Product URL: <input type="text" name="productURL"><br>
Store: <select name="store">
	<option value="">Select a store</option>
	<option value="amazon">Amazon</option>
	<option value="ebay">Ebay</option>
	<option value="wayfair">Wayfair</option>
</select><br>
<input type="submit" value="Submit" name="Submit1">
</form> 

<?php
$product = new App\Models\Product();
if(isset($_GET["Submit1"])){
    $product->store = $_GET["store"];
    $product->product_url = $_GET["productURL"];

    $handler = App\ProductHandlers\ProductHandlerFactory::new($product);
    $product_details = $handler::crawl($product);

    if($product_details->name != null){
        $product->product_name = $product_details->name;
    }
    else{
        $product->product_name = "Product";
    }
    $product->update_interval = 0;
    if($product_details->image_url != null){
        $product->image_url = $product_details->image_url;
    }
    else{
        $product->image_url = "https://cdn.discordapp.com/attachments/620091571521454082/1027339673225396285/unknown.png"; //this is a placeholder
    }
    $product->price = $product_details->price;
    $product->save();
    $lastid = $product->id;
    Auth::user()->products()->attach($lastid);
    
    echo ($product->product_name . " tracker created successfully!");
}

?>

</body>
</html>