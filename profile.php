<?php
require_once realpath('vendor/autoload.php');
session_start();
//If usser is not logged in redirect user to register page
if (!isset($_SESSION['userEmail'])) {
    header('Location: register.php');
}
//Create new class instance and find user by its email
$user = new \App\Controllers\UserController;
$getUser = $user->findUserByEmail($_SESSION['userEmail']);

//Check if submit button was pressed
if (isset($_POST['submit'])) {
    //Save current time as last_loged_at
    $setLoginTime = $user->saveLastLoginTime($_SESSION['userEmail']);
    //Close session
    session_unset();
    session_destroy();
    header("Location: login.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profilis</title>
    <link rel="stylesheet" href="Public/css/app.css">
</head>
<body>
<div class="center-content">
    <div class="profile">
        <?php
            echo '<p>El. paštas: '.$getUser['email'].'</p>'; 
            echo '<p>Vardas: '.$getUser['name'].'</p>'; 
            echo '<p>Pavardė: '.$getUser['last_name'].'</p>'; 
            if (substr($getUser['phone'], 0, 4) === '3706') {
                echo '<p>Telefonas: +'.$getUser['phone'].'</p>';
            } else {
                echo '<p>Telefonas: '.$getUser['phone'].'</p>';
            }
            echo '<p>Vartotojas sukurtas: '.$getUser['registered_at'].'</p>'; 
            echo '<p>Paskutinis prisijungimas: '.$getUser['last_login_at'].'</p>'; 
        ?>
        <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
            <button class="btn" type="submit" name="submit">Atsijungti</button>
        </form>
    </div>
</div>
</body>
</html>