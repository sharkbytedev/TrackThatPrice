//page for creating a new tracker
<!DOCTYPE html>
<body>
<?php use App\ProductHandlers\AmazonHandler; 

$servername = "localhost";
$username = "username";
$password = "password";
$dbname = "myDB";
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

<form action="create-new-tracker.blade.php" method="post">
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
$sql = "INSERT INTO  (product_name, store, product_url)
VALUES ($_POST["trackername"], $_POST["store"], $_POST["productURL"])";

if ($conn->query($sql) === TRUE) {
  echo "New record created successfully";
} else {
  echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>

</body>
</html>