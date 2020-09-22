<?php
require_once realpath('vendor/autoload.php');
session_start();
//If users is loged in redirect user to profile page
if (isset($_SESSION['userEmail'])) {
    header('Location: profile.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prisijungimas</title>
    <link rel="stylesheet" href="Public/css/app.css">
</head>
<body>
<div class="center-content">
    <div class="error-messages">
        <?php
            // Check if submit button was pressed
            if (isset($_POST['submit'])){
                //Check if user exists if not get an error
                $user = new \App\Controllers\UserController;
                $errors = $user->checkPassword($_POST);
                //Print out all of the errors
                if (!empty($errors)) {
                    echo '<ul>';
                    foreach($errors as $error){
                        echo '<li class="error">' .$error. '</li>';
                    }
                    echo '</ul>';
                }
            }
        ?>
    </div>
    <div class="register-form register-dashboard">
       <form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST">
           <label class="form-label" for="email">El. paštas</label>
           <input class="form-group" type="email" name="email" id="email">
           <label class="form-label" for="password">Slaptažodis</label>
           <input class="form-group" type="password" name="password" id="password">
           <button class="btn" type="submit" name="submit">Prisijungti</button><a class="register-link" href="register.php">Registruotis?</a>
       </form>
    </div>
</div>
</body>
</html>