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

$sql = "SELECT * FROM users WHERE id = {$_SESSION["adm"]}";
$result = mysqli_query($connect, $sql);
$row = mysqli_fetch_assoc($result);

$sqlUsers = "SELECT * FROM users WHERE status != 'adm'";
$resultUsers = mysqli_query($connect, $sqlUsers);
$layout = "";

if (mysqli_num_rows($resultUsers)) {
  while ($userRow = mysqli_fetch_assoc($resultUsers)) {
    $layout .= "
        <div>
        <div class='card mb-3' style='max-width: 540px;'>
  <div class='row g-0'>
    <div class='col-md-4'>
      <img src='../photos/{$userRow["picture"]}' class='img-fluid rounded-start' alt='...'>
    </div>
    <div class='col-md-8'>
      <div class='card-body'>
        <h5 class='card-title'>{$userRow["first_name"]} {$userRow["last_name"]}</h5>
        <p class='card-text'>{$userRow["email"]}</p>
        <p class='card-text'>{$userRow["phone_number"]}</p>
         <p class='card-text'>{$userRow["address"]}</p>
        <a href='update_users.php?id={$userRow["id"]}' class='btn btn-light'>Update</a> 
        
       
      </div>
    </div>
  </div>
</div>
</div>";
  }
} else {
  $layout .= "No resulta found";
}

?>

<h2 class="d-flex justify-content-center m-5">Hello, <?= $row["first_name"] ?>!</h2>
<h3 class="d-flex justify-content-center m-5">These are regestered users of the website</h2>
  <div class="container main_container">
    <div class="row row-cols-lf-3 row-cols-md-2 row-cols-sm-1 row-cols-xs-1">
      <?= $layout ?>
    </div>
  </div>


  </html>

  <?= require_once "../inc/footer.php"; ?>