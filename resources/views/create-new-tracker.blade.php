//page for creating a new tracker
<!DOCTYPE html>
<body>
<?php use App\ProductHandlers\AmazonHandler; 
class productTracker{
    public string $name;
    public string $store;
    public string $URL;

    public function constructTracker(string $name, string $store, string $URL){
        $this->$name = $name;
        $this->$store = $store;
        $this->$URL = $URL;
    }
}

?>
<form action="trackers.blade.php" method="post">
Tracker Name: <input type="text" name="trackerName"><br>
Store:  
<select name="store">  
    <option value="">Select a Store</option>}  
    <option value="Amazon">Amazon</option>
    <option value="Ebay">Ebay</option>
</select>
Product URL: <input type="text" name="productURL"><br>

<input type="submit">
</form> 

<?php
$newTrack = constructTracker($_POST["trackerName"], $_POST["store"], $_POST)

?>

</body>
</html>