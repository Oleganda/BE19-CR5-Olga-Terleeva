<?php require_once "db_connect.php";
require_once "upload_file.php";
require_once "../inc/navbar-admin.php";

session_start();

if (isset($_SESSION["user"])) {
    header("Location: animals.php");
}

if (!isset($_SESSION["user"]) && !isset($_SESSION["adm"])) {
    header("Location: regester.php");
}

$id = $_GET["id"];
$sql = "SELECT * FROM users WHERE id = $id";
$result = mysqli_query($connect, $sql);
$row = mysqli_fetch_assoc($result);

$backBtn = "users_admin.php";

if (isset($_SESSION["adm"])) {
    $backBtn = "users_admin.php";
}

if (isset($_POST["update"])) {
    $first_name = ($_POST["first_name"]);
    $last_name = ($_POST["last_name"]);
    $phone_number = ($_POST["phone_number"]);
    $email = ($_POST["email"]);
    $picture = uploadFile($_FILES["picture"]);
    $address = ($_POST["address"]);
    //checking if picture already excists 
    if ($_FILES["picture"]["error"] == 0) {
        if ($row["picture"] != "profile.jpg") {
            unlink("../photos/$row[picture]");
        }
        $sql = "UPDATE users SET first_name = '$first_name', last_name = '$last_name', picture = '$picture[0]', phone_number = '$phone_number', email = '$email', address = '$address' WHERE id = {$id}";
    } else {
        $sql = "UPDATE users SET first_name = '$first_name', last_name = '$last_name', phone_number = '$phone_number', email = '$email', address = '$address' WHERE id = {$id}";
    }

    if (mysqli_query($connect, $sql)) {
        echo  "<div class='alert alert-success' role='alert'>
       Profile has been updated {$picture[1]}                            
     </div>";
        header("refresh: 3; url=$backBtn");
    } else {
        echo   "<div class='alert alert-danger' role='alert'>
       Error was found {$picture[1]}
     </div>";
    }
}


?>
<div class='container mt-5'>


    <form method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">First Name</label>
            <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="Name" name="first_name" value="<?= $row["first_name"] ?>">

        </div>
        <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Last Name</label>
            <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="Name" id="last_name" name="last_name" value="<?= $row["last_name"] ?>">

        </div>
        <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Picture</label>
            <input type="file" class="form-control" id="exampleFormControlInput1" placeholder="Upload your photo here" id="picture" name="picture">

        </div>
        <div class=" mb-3">
            <label for="exampleFormControlInput1" class="form-label">E-mail</label>
            <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="Your email" name="email" value="<?= $row["email"] ?>">

        </div>
        <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Phone Number</label>
            <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="+43 xx xx xxx" id="date_of_birth" name="phone_number" value="<?= $row["phone_number"] ?>">

        </div>
        <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Address</label>
            <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="Address" id="address" name="address" value="<?= $row["address"] ?>">

        </div>

        <div class="d-flex justify-content-center m-5 ">
            <button name="update" type="update" class="btn btn-danger">Update</button>
            <a href="users_admin.php" name="back " type="back" class="btn btn-danger ms-1">Back</a>
        </div>
    </form>



    <?= require_once "../inc/footer.php"; ?>