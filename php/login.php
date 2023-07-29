<?php
require_once "db_connect.php";
session_start(); // start the session and use super global variable. In suv we keep info about user and admin 
//it prevents from loginin in seeral time.

if (isset($_SESSION["user"])) {
    header("Location: animals.php");
}

if (isset($_SESSION["adm"])) {
    header("Location: animals_admin.php");
}


$email = $passwordError = $emailError = "";
$error = false;

function cleanInput($input)
{
    $data = trim($input);
    $data = strip_tags($data);
    $data = htmlspecialchars($data);

    return $data;
}

if (isset($_POST["login"])) {
    $email = cleanInput($_POST["email"]);
    $password = $_POST["password"];

    //validation of password 
    if (empty($password)) {
        $error = true;
        $passwordError = "Please, enter your password";
    } elseif (strlen($password) < 5) {
        $error = true;
        $passwordError = "Password must be longer than 5 characters";
    }


    if (!$error) {
        $password = hash("sha256", $password);
        $sql = "SELECT * FROM users WHERE email = '$email' AND password = '$password'";   //write a query and took all info about the user
        $result = mysqli_query($connect, $sql);                                           //run query
        $row = mysqli_fetch_assoc($result);                                                //fetch data

        if (mysqli_num_rows($result) == 1) {
            if ($row["status"] == "user")  //to check who is it user or admin
            {
                $_SESSION["user"] = $row["id"];         //if the user, save id there  
                header("Location: animals.php");
            } else {
                $_SESSION["adm"] = $row["id"];
                header("Location: animals_admin.php");
            }
        } else {
            echo   "
            <div class='alert alert-danger mt-5'>
               <p>Something went wrong, please try again later</p>
           </div>";
        }
    }
}
?>

<?php require_once "../inc/navbar-main.php"; ?>

<body>
    <div class="container login-container">
        <!-- Section: Design Block -->
        <section class="">
            <!-- Jumbotron -->

            <div class="px-4 py-5 px-md-5 text-center text-lg-start" style="background-color: hsl(0, 0%, 96%)">
                <div class="container">
                    <div class="row gx-lg-5 align-items-center">
                        <div class="col-lg-6 mb-5 mb-lg-0">
                            <h1 class="my-5 display-3 fw-bold ls-tight">
                                Friend For You.<br />
                                <span class="text-dark">Family For Me.</span>
                            </h1>
                            <p style="color: hsl(217, 10%, 50.8%)">
                                Find best friend for yourself
                                <br>
                                Sign Up for free or if
                                your already have an account Log In and adopt a pet.
                                <br>
                                More than 100 people have found already new pet on "Take me Home" website.
                            </p>
                        </div>

                        <div class="col-lg-6 mb-5 mb-lg-0">
                            <div class="card">
                                <div class="card-body py-5 px-md-5">
                                    <form method="POST" enctype="multipart/form-data">
                                        <div class="d-flex justify-content-center m-1">
                                            <h2>Log In</h2>
                                        </div>

                                        <!-- Email input -->
                                        <div class=" form-outline mb-4">
                                            <input type="text" class="form-control" id="exampleFormControlInput1" name="email" value="<?= $email ?>">

                                            <label class="form-label" for="form3Example4">Email</label>
                                            <span class=" text-danger"> <?= $emailError ?> </span>
                                        </div>

                                        <!-- Password input -->
                                        <div class="form-outline mb-4">
                                            <input type="password" class="form-control" id="exampleFormControlInput1" name="password">

                                            <label class="form-label" for="form3Example4">Password</label>
                                            <span class="text-danger"> <?= $passwordError ?> </span>
                                        </div>


                                        <!-- Submit button -->
                                        <div class="d-flex justify-content-center m-2 "><button name="login" type="submit" class="btn btn-danger">Log in</button></div>
                                        <div class="d-flex justify-content-center m-2 "></div>
                                        <div class="d-flex justify-content-center"><a class="btn btn-danger" href="regester.php">Regester Now</a></div>
                                </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </div>
    <!-- Jumbotron -->
    </section>
    <!-- Section: Design Block -->

    </div>


    <?php require_once "../inc/footer.php"; ?>