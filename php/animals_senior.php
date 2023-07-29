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

$sql = "SELECT * FROM `animals` WHERE age > 5";
$result = mysqli_query($connect, $sql);
$layout = "";


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
    <h3 class='card-title'>{$row["name"]}</h3>
    <h4 class='card-title'>{$row["age"]} years old</h4>
    <p class='card-text'>Breed: {$row["breed"]}</p>
    <p class='card-text'>I am a {$row["size"]} dog</p>
    <p class='card-text'>I live in {$row["address"]}</p>
    <p class='card-text'>I am {$row["vaccinated"]}</p>
    <h3 class='card-text'> {$row["status"]}</h3>
      <div class='d-flex justify-content-center'>
    <a href='details.php?x={$row["id"]}'class='btn btn-danger'>More about {$row["name"]}</a>
    <a href='adopt_pet_user.php?i={$row["id"]}' name='adopt' class='btn btn-danger ms-1'>Adopt Me </a>
  </div>
  </div>
</div>
</div>";
}

?>
<div class="main_container">
  <div class='container mt-5 '>
    <div class="d-flex justify-content-around row row-lg-3 row-md-2 row-xs-1 p-2 g-col-6 p-2 g-col-6">
      <div class="d-flex justify-content-center m-3">
        <h3>Look at our Senior Dogs</h3>
      </div>
      <div class="d-flex justify-content-around row row-lg-3 row-md-2 row-xs-1 p-2 g-col-6 p-2 g-col-6 plan-main m-5">
        <?= $layout ?>
      </div>
    </div>
  </div>

</div>
</div>
<?= require_once "../inc/footer.php"; ?>