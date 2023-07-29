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

$id = $_GET["x"];
$sql = "SELECT * FROM animals WHERE id = $id";
$result = mysqli_query($connect, $sql);
$row = mysqli_fetch_assoc($result);

$backBtn = "users_admin.php";

if (isset($_SESSION["adm"])) {
    $backBtn = "animals_admin.php";
}

if (isset($_POST["update"])) {
    $name = $_POST["name"];
    $address = $_POST["address"];
    $age = $_POST["age"];
    $size = $_POST["size"];
    $photo = uploadFile($_FILES["photo"], "animal");
    $breed = $_POST["breed"];
    $status = $_POST["status"];
    $vaccinated = $_POST["vaccinated"];
    $description = $_POST["description"];

    if ($_FILES["photo"]["error"] == 0) {
        if ($row["photo"] != "pets.png") {
            unlink("../photos/$row[photo]");
        }
        $sql = "UPDATE `animals` SET `name`='$name',`address`='$address',`age`='$age',`size`='$size', `photo` ='$photo[0]',`description`='$description',`breed`='$breed',`status`='$status',`vaccinated`='$vaccinated' WHERE id = $id";
    } else {
        $sql = "UPDATE `animals` SET `name`='$name',`address`='$address',`age`='$age',`size`='$size',`description`='$description',`breed`='$breed',`status`='$status',`vaccinated`='$vaccinated' WHERE id = $id";
    }

    if (mysqli_query($connect, $sql)) {
        echo "<div class='alert alert-success' role='alert'>
        Information was updated {$photo[1]}</div>";
        header("refresh:3; url=$backBtn");
    } else {
        echo "<div class='alert alert-danger' role='alert'>
        error found, {$photo[1]}
      </div>";
    }
}
?>


<!-- form -->

<div class='container mt-5'>
    <div class="d-flex justify-content-center m-3">
        <h3>Add a New Dog</h3>
    </div>
    <form method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Name</label>
            <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="Name" name="name" value="<?= $row["name"] ?>">
        </div>
        <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Picture</label>
            <input type="file" class="form-control" id="exampleFormControlInput1" placeholder="Upload picture here" id="photo" name="photo">
        </div>
        <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Breed</label>
            <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="Breed" name="breed" value="<?= $row["breed"] ?>">
        </div>
        <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Age</label>
            <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="Age" name="age" value="<?= $row["age"] ?>">
        </div>
        <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Address</label>
            <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="Address" name="address" value="<?= $row["address"] ?>">
        </div>
        <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Size</label>
            <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="Size" name="size" value="<?= $row["size"] ?>">
        </div>
        <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Status</label>
            <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="Status" name="status" value="<?= $row["status"] ?>">
        </div>
        <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Vaccine</label>
            <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="Vaccine" name="vaccinated" value="<?= $row["vaccinated"] ?>">
        </div>
        <div class="mb-3">
            <label for="exampleFormControlTextarea1" class="form-label">Description</label>
            <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="description"></textarea>
        </div>

        <div class="d-flex justify-content-center m-5 ">

            <button name="update" type="submit" class="btn btn-danger">Update</button>

        </div>

    </form>
</div>
</body>

</html>