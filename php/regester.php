<?php require_once "db_connect.php";
require_once "upload_file.php";
require_once "../inc/navbar-main.php";

session_start();

if (isset($_SESSION["user"])) {
    header("Location: animals.php");
}

if (isset($_SESSION["adm"])) {
    header("Location: animals_admin.php");
}

$error = false; //if error == true, user/admin put not correct info

function cleanInput($input)
{
    $data = trim($input); //remove extra spaces, tabs, newlines out of the string. ex: user put extra spaces in name line
    $data = strip_tags($data); //removing HTML tags from the string, dont use if need original string
    $data = htmlspecialchars($data); //convertingHTML special charachters. ex: öüä 

    return $data;
}

$first_name = $last_name = $email = $phone_number = $address =  "";  //define variables and set them to empty string
$first_nameError = $last_nameError = $emailError = $phone_numberError = $addressError = $passwordError = ""; // in case of error, will be empty string


if (isset($_POST["submit"])) {                            //when button subit is clicked, we apply function to values, password could not 
    $first_name = cleanInput($_POST["first_name"]);      //be used with cleanInput function because user could use special characters in it
    $last_name = cleanInput($_POST["last_name"]);
    $email = cleanInput($_POST["email"]);
    $password = ($_POST["password"]);
    $phone_number = cleanInput($_POST["phone_number"]);
    $address = cleanInput($_POST["address"]);
    $picture = uploadFile($_FILES["picture"]);

    //validate if first name is correct 
    if (empty($first_name)) {       //if it is empty, we have to ask to put a value 
        $error == true;
        $first_nameError = "Please, enter your first name";
    } elseif (strlen($first_name) < 2) {     //if first name is too short 
        $error == true;
        $first_nameError = "First name can not be shorter than 2 characters";
    } elseif (!preg_match("/^[a-zA-Z\s]+$/", $first_name))    //to check if name contains special characters, which we dont want to accept
    {
        $error == true;
        $first_nameError = "First name must contain only letters and spaces";
    }

    //validate if last name is correct 

    if (empty($last_name)) {
        $error == true;
        $last_nameError = "Please, enter your last name";
    } elseif (strlen($last_name) < 2) {
        $error == true;
        $last_nameError = "Last name can not be shorter than 2 characters";
    } elseif (!preg_match("/^[a-zA-Z\s]+$/", $last_name)) {
        $error == true;
        $last_nameError = "Last name must contain only letters and spaces";
    }

    //validation of the phone_number

    if (empty($phone_number)) {     //it cannot be empty
        $error = true;
        $dateError = "Phone Number can't be empty!";
    }
    //validation of email

    if (!filter_var($email, FILTER_VALIDATE_EMAIL))             // if the provided text is not a format of an email, error will be true 
    {
        $error = true;
        $emailError = "Please enter a valid email address";
    } else {
        $query = "SELECT email FROM users WHERE email='$email'";     // check if email is already exists in the database
        $result = mysqli_query($connect, $query);                   //connect to db
        if (mysqli_num_rows($result) != 0) {                        //if result is not equal 0, means that email excists 
            $error = true;
            $emailError = "Email is already in use. Try to log in";
        }
    }

    //validation of password 
    if (empty($password)) {
        $error = true;
        $passwordError = "Please, enter your password";
    } elseif (strlen($password) < 5) {
        $error = true;
        $passwordError = "Password must be longer than 5 characters";
    }

    if (!$error)  //if there is no errors, we have to send it to the db, but hash password for security
    {
        $password = hash("sha256", $password);
        $sql = "INSERT INTO users (first_name, last_name, password, email, phone_number, picture, address) VALUES ('$first_name','$last_name', '$password', '$email', '$phone_number', '$picture[0]', '$address')";

        $result = mysqli_query($connect, $sql);

        if ($result) {
            echo   "<div class='alert alert-success'>
               <p>New account has been created, $picture[1]</p>
           </div>";
        } else {
            echo   "<div class='alert alert-danger'>
               <p>Something went wrong, please try again later ...</p>
           </div>";
        }
    }
}
?>


<!-- form -->
<div class='container mt-5'>
    <!-- Section: Design Block -->
    <section class="text-center text-lg-start">
        <!-- Jumbotron -->
        <div class="container py-4">
            <div class="row g-0 align-items-center">
                <div class="col-lg-6 mb-5 mb-lg-0">
                    <div class="card cascading-right" style="
            background: hsla(0, 0%, 100%, 0.55);
            backdrop-filter: blur(30px);
            ">
                        <div class="card-body p-5 shadow-5 text-center">
                            <h2 class="fw-bold mb-5">Sign up now</h2>
                            <form method="POST" enctype="multipart/form-data">
                                <!-- 2 column grid layout with text inputs for the first and last names -->
                                <div class="row">
                                    <div class="col-md-6 mb-4">
                                        <div class="form-outline">
                                            <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="First name" name="first_name" value="<?= $first_name ?>">

                                            <span class="text-danger"> <?= $first_nameError ?> </span>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-4">
                                        <div class="form-outline">
                                            <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="Last name" name="last_name" value="<?= $last_name ?>">

                                            <span class=" text-danger"> <?= $last_nameError ?> </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-4">
                                        <div class="form-outline">
                                            <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="Phone Number" name="phone_number" value="<?= $phone_number ?>">
                                            <span class=" text-danger"> <?= $phone_numberError ?> </span>

                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-4">
                                        <div class="form-outline">
                                            <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="Your email" name="email" value="<?= $email ?>">
                                            <span class=" text-danger"> <?= $emailError ?> </span>

                                        </div>
                                    </div>
                                </div>
                                <!-- Address input -->
                                <div class="form-outline mb-4">
                                    <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="Where do you live" name="address" value="<?= $address ?>">

                                </div>
                                <!-- Profile Photo input -->
                                <div class="form-outline mb-4">
                                    <input type="file" class="form-control" id="exampleFormControlInput1" placeholder="Upload your photo here" name="picture" value="<?= $picture ?>">
                                    <label class="form-label" for="form3Example3">Upload Profile Photo</label>
                                </div>

                                <!-- Password input -->
                                <div class="form-outline mb-4">
                                    <input type="password" class="form-control" id="exampleFormControlInput1" placeholder="Create a new password" name="password">
                                    <span class="text-danger"> <?= $passwordError ?> </span>
                                    <!-- <label class="form-label" for="form3Example4">Password</label> -->
                                </div>



                                <!-- Submit button -->
                                <button button name="submit" type="submit" type="submit" class="btn btn-danger btn-block mb-4">
                                    Sign up
                                </button>


                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 mb-5 mb-lg-0">
                    <img src="https://cdn.pixabay.com/photo/2018/03/31/06/31/dog-3277414_1280.jpg" class="w-100 rounded-4 shadow-4 img-dog-regester" alt="" />
                </div>
            </div>
        </div>

    </section>