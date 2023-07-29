<?php require_once "db_connect.php";
require_once "upload_file.php";
require_once "../inc/navbar-user.php";

session_start();

if (isset($_SESSION["adm"])) {
    header("Location: animals_admin.php");
}

if (!isset($_SESSION["user"]) && !isset($_SESSION["adm"])) {
    header("Location: regester.php");
}

$id = $_GET["i"];
if (isset($_POST["adopt"])) {
    $adoption_date = $_POST["adoption_date"];
    $owner_address = $_POST["owner_address"];
    $user_id = $_SESSION["user"];
    $pet_id = $_POST["pet_id"];

    $sql = "INSERT INTO `pet_adoption`(`adoption_date`, `owner_address`, `user_id`, `pet_id`) VALUES ('$adoption_date','$owner_address','$user_id','$pet_id')";
    // $sql = "SELECT * FROM `animals` JOIN pet_adoption ON animals.id = pet_adoption.adoption_id  WHERE id = $id";   
    // $sql = "SELECT * FROM `users` JOIN pet_adoption ON users.id = pet_adoption.adoption_id  WHERE id = $id";
    if (mysqli_query($connect, $sql)) {
        echo "<div class='alert alert-success' role='alert'>
        You have adopted a dog!";
        header("refresh:3; url=animals.php");
    } else {
        echo "Error adopting the pet. Try later";
    }
}

?>
<div class="container">
    <form method="POST" enctype="multipart/form-data">

        <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Name of Future Owner</label>
            <input type="text" class="form-control" id="exampleFormControlInput1" name="user_id">
        </div>
        <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Name of the Dog</label>
            <input type="text" class="form-control" id="exampleFormControlInput1" name="pet_id" value="<?= $id ?>">
        </div>
        <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Date of Pick Up</label>
            <input type="date" class="form-control" id="exampleFormControlInput1" name="adoption_date" placeholder="yyyy-mm-dd">
        </div>
        <div class="mb-3">
            <label for="exampleFormControlTextarea1" class="form-label">Address</label>
            <input type="text" class="form-control" id="exampleFormControlInput1" name="owner_address" placeholder="Your address">
        </div>
        <button type="submit" name="adopt" class="btn btn-danger">Adopt Me</button>
    </form>

</div>