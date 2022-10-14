<!DOCTYPE html>
<body>
<?php 
use Illuminate\Support\Facades\Auth;

if (Auth::check() == false){
    header("Location: localhost:8000/login");
    exit();
}
//this will redirect the user to the login page if they arent already logged in.
//change localhost:8000/login to actual login page later
?>

All Trackers:
<?php 
$UserProducts = auth()->user()->products()->get();
if(count($UserProducts) > 0){
    for ($i = 0; $i < count($UserProducts); $i++){ 
        ?> <br> <?php
        echo $UserProducts[$i]->product_name;
    }
}
else{
    echo "No products found";
}

?>

</body>
</html>