<?php
session_start();

if (!isset($_SESSION['email'])) {
    $_SESSION['msg'] = "You must log in first";
    header('location: login.php');
}

if (isset($_GET['logout'])) {
    session_destroy();
    unset($_SESSION['email']);
    header("location: login.php");
}
?>
<?php include('server.php') ?>
<!DOCTYPE html>
<html>
    <head>
        <title>HOT Page</title>
        <link rel="stylesheet" type="text/css" href="style.css">
    </head>
    <body>
        <div class="header">
            <h2>HOT Page</h2>
        </div>

        <form method="post" action="hot.php">

            <?php include('errors.php'); ?>


            <div class="input-group">
                <label>Email</label>
                <input type="email" name="email" value="<?php echo $email; ?>">
            </div>

            <div class="input-group">
                <label>First Name</label>
                <input type="input" name="first_name">
            </div>

            <div class="input-group">
                <label>Last Name</label>
                <input type="input" name="last_name">
            </div>

            <div class="input-group">
                <label>Vacation</label>
                <input type="input" name="vacation">
            </div>

            <div class="input-group">
                <label>Home Office</label>
                <input type="input" name="ho">
            </div>

            <div class="input-group">
                <label>Visit To Doctor</label>
                <input type="input" name="vtd" >
            </div>

            <div class="input-group">
                <label>Visit To Doctor w Family Member</label>
                <input type="input" name="vtd_fm">
            </div>

            <div class="input-group">
                <label>Password</label>
                <input type="password" name="password_1">
            </div>
            <div class="input-group">
                <label>Confirm password</label>
                <input type="password" name="password_2">
            </div>
            <div class="input-group">
                <button type="submit" class="btn" name="reg_emp">Register</button>
            </div>
            <?php if (isset($_SESSION['email'])) : ?>
                <p>Welcome <strong><?php echo $_SESSION['email']; ?></strong></p>
                <p> <a href="index.php?logout='1'" style="color: red;">logout</a> </p>
            <?php endif ?>
        </form>
    </body>
</html>