<?php require_once "db_connect.php";
require_once "upload_file.php";
require_once "../inc/navbar-admin.php";

$id = $_GET["x"];

$sql = "DELETE FROM animals WHERE id = $id";
if (mysqli_query($connect, $sql)) {
    header("location: animals_admin.php");
} else {
    echo "Error";
}
