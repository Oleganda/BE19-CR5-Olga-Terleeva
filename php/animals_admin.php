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

$sql = "SELECT * FROM `animals`";
$result = mysqli_query($connect, $sql);
$layout = "";

if (mysqli_num_rows($result) > 0) {
  while ($row = mysqli_fetch_assoc($result)) {
    $layout .= "
        <div class ='card p-0 mt-3' style='width: 300px; 'height = 70px rounded-0'>
<div class='card'>
  <div class='view overlay'>
    <img src='../photos/{$row["photo"]}' class='card-img-top dog' alt='...'>
      <div class='mask rgba-white-slight'></div>
    </a>
  </div>
  <div class='card-body'>
    <h4 class='card-title'>{$row["name"]}. {$row["age"]} years old</h4>
    <p class='card-text'>Breed: {$row["breed"]}</p>
    <p class='card-text'>I am a {$row["size"]} dog</p>
    <p class='card-text'>I live in {$row["address"]}</p>
    <p class='card-text'>I am {$row["vaccinated"]} </p>
     <h4 class='card-text mt-3'>{$row["status"]} </h4>
      <div class='d-flex justify-content-center'>
    <a href='details.php?x={$row["id"]}'class='btn btn-danger'>Info</a>
    <a href='update_dog_admin.php?x={$row["id"]}'class='btn btn-danger ms-1'>Update</a>
    <a href='delete_admin.php?x={$row["id"]}'class='btn btn-danger ms-1'>Delete</a>
  </div>
  </div>
</div>
</div>";
  }
} else {
  $layout .= "<div class ='m-3 d-flex justify-content-center'>No pets to adopt.</div>";
}

?>
<!-- form -->
<div class='container mt-5 main_container'>

  <div class="d-flex justify-content-around row row-lg-3 row-md-2 row-xs-1 p-2 g-col-6 p-2 g-col-6">
    <div class="d-flex justify-content-center"><a href="add_dog_admin.php" class="btn btn-danger m-5">Add New Dog</a></div>
    <?= $layout ?>
  </div>
</div>



<?php require_once "../inc/footer.php"; ?>