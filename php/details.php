<?php require_once "db_connect.php";
require_once "upload_file.php";
require_once "../inc/navbar-user.php";

session_start();

if (!isset($_SESSION["user"]) && !isset($_SESSION["adm"])) {
    header("Location: regester.php");
}


$id = $_GET["x"];

$sql = "SELECT * FROM `animals` WHERE id = $id";
// $sql = "SELECT * FROM `animals` JOIN suppliers ON products.fk_supplierId = suppliers.supplierId WHERE Id = $id";
$result = mysqli_query($connect, $sql);

$row = mysqli_fetch_assoc($result);
?>

<div class="card main-card m-4">
    <div class="container text-center bg-light">
        <div class="row text-container">
            <div class="col-md-8 background-text">
                <div class="card-body text">
                    <h2 class="card-title"><?= $row["name"] ?></h2>
                    <h4 class="card-title"><?= $row["breed"] ?></h4>
                    <p class="card-text"><small class="text-body-secondary"> <?= $row["description"] ?></small></p>
                    <a href='adopt_pet_user.php?i={$row["id"]}' name='adopt' class='btn btn-danger ms-1'>Adopt Me </a>
                </div>
            </div>

            <div class="col-6 col-md-4"><img src="../photos/<?= $row["photo"] ?>" width="420px" height="500px" alt=""></div>
        </div>
    </div>
</div>
<?= require_once "../inc/footer.php"; ?>