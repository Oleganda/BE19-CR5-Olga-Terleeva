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



if (isset($_POST["add"])) {
    $name = $_POST["name"];
    $address = $_POST["address"];
    $age = $_POST["age"];
    $size = $_POST["size"];
    $photo = uploadFile($_FILES["photo"], "animal");
    $breed = $_POST["breed"];
    $status = $_POST["status"];
    $vaccinated = $_POST["vaccinated"];
    $description = $_POST["description"];

    $sql = "INSERT INTO animals(`name`, `address`, `age`, `size`, `photo`, `description`, `breed`, `status`, `vaccinated`) VALUES ('$name','$address','$age','$size','$photo','$description','$breed','$status','$vaccinated')";

    if (mysqli_query($connect, $sql)) {
        echo "<div class=alert alert-info role=alert>
 Your have added a new dog!
</div>";
        header("refresh:3; url=animals_admin.php");
    } else {

        "<div class='alert alert-danger' role='alert'> Something went wrong. Try later.
</div>";
    }
}
?>

<body>
    <div class='container mt-5'>
        <div class="d-flex justify-content-center m-3">
            <h3>Add a New Dog</h3>
        </div>
        <form method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">Name</label>
                <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="Name" name="name">
            </div>
            <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">Picture</label>
                <input type="file" class="form-control" placeholder="Upload picture here" id="photo" name="photo">
            </div>
            <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">Breed</label>
                <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="Breed" name="breed">
            </div>
            <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">Age</label>
                <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="Age" name="age">
            </div>
            <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">Address</label>
                <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="Address" name="address">
            </div>
            <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">Size</label>
                <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="Size" name="size">
            </div>
            <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">Status</label>
                <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="Status" name="status">
            </div>
            <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">Vaccine</label>
                <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="Vaccine" name="vaccinated">
            </div>
            <div class="mb-3">
                <label for="exampleFormControlTextarea1" class="form-label">Description</label>
                <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="description"></textarea>
            </div>

            <div class="d-flex justify-content-center m-5 "><button name="add" type="submit" class="btn btn-danger">Add Dog</button></div>

        </form>
    </div>
</body>

</html>