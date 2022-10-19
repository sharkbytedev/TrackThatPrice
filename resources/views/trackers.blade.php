<!DOCTYPE html>
<body>
<title> Trackers - TrackThatPrice </title>
<?php 
use Illuminate\Support\Facades\Auth;

if (Auth::check() == false){
    header("Location: localhost:8000/login");
    exit();
}
//this will redirect the user to the login page if they arent already logged in.
//change localhost:8000/login to actual login page later
?>
<h1>
    Your Trackers:
</h1>

<br>
<?php 
$userProducts = auth()->user()->products()->get();
if(count($userProducts) > 0){
    for ($i = 0; $i < count($userProducts); $i++){
        ?>
        <div class="border-solid border-2 border-blue-900 rounded p-1 mx-auto max-x-3xl">
            <img src="<?php echo $userProducts[$i]->image_url;?>" class="border-solid border-2 border-blue-900 float-left w-32 h-32 object-contain">

            <p class="text-xl max-x-xl"> <!-- Large product name text -->
                <?php 
                if(strlen($userProducts[$i]->product_name) < 75){
                    echo $userProducts[$i]->product_name; 
                }
                else{
                    echo (substr($userProducts[$i]->product_name, 0, 75). "...");
                }
                ?> <br>
            </p>

            <p> 
                <?php
                echo $userProducts[$i]->store; ?> <br> <?php
                echo $userProducts[$i]->price; ?> <br> <?php
                //echo $userProducts[$i]->product_url;
                ?>
            </p>
        </div>
        <br>
        <?php
    }
}
else{
    echo "No products found";
}

?>

</body>
</html>