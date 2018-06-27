<?php

if (!isset($_SESSION)) {
    session_start();
}

// variable declaration
$username = "";
$email = "";
$errors = array();
$_SESSION['success'] = "";

// connect to database
$db = mysqli_connect('172.20.10.3', 'root', 'Safepass18!', 'hackathon');
//$db = mysqli_connect('172.20.10.3', 'root', 'SafePass18!', 'hackathon');
// REGISTER USER
if (isset($_POST['reg_user'])) {
    // receive all input values from the form
    $email = mysqli_real_escape_string($db, $_POST['email']);
    $password_1 = mysqli_real_escape_string($db, $_POST['password_1']);
    $password_2 = mysqli_real_escape_string($db, $_POST['password_2']);

    // form validation: ensure that the form is correctly filled
    if (empty($email)) {
        array_push($errors, "Email is required");
    }
    if (empty($password_1)) {
        array_push($errors, "Password is required");
    }

    if ($password_1 != $password_2) {
        array_push($errors, "The two passwords do not match");
    }

    // register user if there are no errors in the form
    if (count($errors) == 0) {
        $password = md5($password_1); //encrypt the password before saving in the database
        $query = "INSERT INTO users (email, password, role, first_name, last_name, vacation, sick, ho, vtd, vtd_fm, team) 
					  VALUES('$email', '$password', '$role', '$first_name', '$last_name', '$vacation', '$ho', '$vtd', '$vtd_fm', '$team')";
        mysqli_query($db, $query);
		//komentar
        //$_SESSION['username'] = $email;
        //$_SESSION['success'] = "You are now logged in";
        header('location: index.php');
    }
}
//Reg head of team
if (isset($_POST['reg_hot'])) {
    // receive all input values from the form
    $email = mysqli_real_escape_string($db, $_POST['email']);
    $role = 'HOT';
    $first_name = mysqli_real_escape_string($db, $_POST['first_name']);
    $last_name = mysqli_real_escape_string($db, $_POST['last_name']);
    $vacation = mysqli_real_escape_string($db, $_POST['vacation']);
    $ho = mysqli_real_escape_string($db, $_POST['ho']);
    $vtd = mysqli_real_escape_string($db, $_POST['vtd']);
    $vtd_fm = mysqli_real_escape_string($db, $_POST['vtd_fm']);
    $team = md5(uniqid($_SESSION['email'], true));
    $password_1 = mysqli_real_escape_string($db, $_POST['password_1']);
    $password_2 = mysqli_real_escape_string($db, $_POST['password_2']);

    // form validation: ensure that the form is correctly filled
    if (empty($email)) {
        array_push($errors, "Email is required");
    }
    if (empty($password_1)) {
        array_push($errors, "Password is required");
    }

    if ($password_1 != $password_2) {
        array_push($errors, "The two passwords do not match");
    }

    // register user if there are no errors in the form
    if (count($errors) == 0) {
        $password = md5($password_1); //encrypt the password before saving in the database
        $query = "INSERT INTO users (email, password, role, first_name, last_name, vacation, ho, vtd, vtd_fm, team) 
					  VALUES('$email', '$password', '$role', '$first_name', '$last_name', '$vacation', '$ho', '$vtd', '$vtd_fm', '$team')";
        mysqli_query($db, $query);

        //$_SESSION['email'] = $email;
        //$_SESSION['success'] = "You are now logged in";
        //header('location: hot.php');
    }
}


if (isset($_POST['reg_emp'])) {
    // receive all input values from the form
    $email = mysqli_real_escape_string($db, $_POST['email']);
    $role = 'EMP';
    $first_name = mysqli_real_escape_string($db, $_POST['first_name']);
    $last_name = mysqli_real_escape_string($db, $_POST['last_name']);
    $vacation = mysqli_real_escape_string($db, $_POST['vacation']);
    $ho = mysqli_real_escape_string($db, $_POST['ho']);
    $vtd = mysqli_real_escape_string($db, $_POST['vtd']);
    $vtd_fm = mysqli_real_escape_string($db, $_POST['vtd_fm']);
    $password_1 = mysqli_real_escape_string($db, $_POST['password_1']);
    $em = $_SESSION['email'];
    $query = "SELECT team from users where email = '$em'";
    mysqli_query($db, $query);

    $team = $password_2 = mysqli_real_escape_string($db, $_POST['password_2']);

    // form validation: ensure that the form is correctly filled
    if (empty($email)) {
        array_push($errors, "Email is required");
    }
    if (empty($password_1)) {
        array_push($errors, "Password is required");
    }

    if ($password_1 != $password_2) {
        array_push($errors, "The two passwords do not match");
    }

    // register user if there are no errors in the form
    if (count($errors) == 0) {
        $password = md5($password_1); //encrypt the password before saving in the database
        $query = "INSERT INTO users (email, password, role, first_name, last_name, vacation, ho, vtd, vtd_fm) 
					  VALUES('$email', '$password', '$role', '$first_name', '$last_name', '$vacation', '$ho', '$vtd', '$vtd_fm')";
        mysqli_query($db, $query);

        //$_SESSION['email'] = $email;
        //$_SESSION['success'] = "You are now logged in";
        //header('location: hot.php');
    }
}

// ... 
// LOGIN USER
if (isset($_POST['login_user'])) {
    $email = mysqli_real_escape_string($db, $_POST['email']);
    $password = mysqli_real_escape_string($db, $_POST['password']);
    $role = mysqli_real_escape_string($db, $_POST['password']);


    if (empty($email)) {
        array_push($errors, "Email is required");
    }
    if (empty($password)) {
        array_push($errors, "Password is required");
    }

    if (count($errors) == 0) {
        $password = md5($password);
        $query = "SELECT * FROM users WHERE email='$email' AND password='$password'";
        $results = mysqli_query($db, $query);
        
        $rolequery = "SELECT role FROM users WHERE email='$email' AND password='$password'";
        $roleresult = mysqli_query($db, $rolequery);

        $_SESSION['role'] = $roleresult;
        
       
        if (mysqli_num_rows($results) == 1) {
            if ($_SESSION['role'] == 'ADM') {
                $_SESSION['email'] = $email;
                $_SESSION['success'] = "You are now logged in";
                header('location: admin.php');
            } else if ($_SESSION['role'] == 'HOT') {
                $_SESSION['email'] = $email;
                $_SESSION['success'] = "You are now logged in";
                header('location: hot.php');
            } else {

                $_SESSION['email'] = $email;
                $_SESSION['success'] = "You are now logged in";
                header('location: hot.php');
            }
        } else {
            array_push($errors, "Wrong username/password combination");
        }
    }
}
?>