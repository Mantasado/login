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
    <title>Authentication</title>
    <link rel="stylesheet" href="Public/css/app.css">
</head>
<body>
    
<div class="center-content">
    <div class="error-messages">
        <?php
            // Check if submit button was pressed
            if (isset($_POST['submit'])){
                //Create new instance of UserValidation Class
                $validation = new \App\Controllers\UserValidationController($_POST);
                $errors = $validation->validateForm();
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
    <div class="register-dashboard">
        <h1 class="form-title" >Registracijos forma</h1>
        <form class="register-form" action="<?php $_SERVER['PHP_SELF'] ?>" method="POST">
            <label class="form-label" for="email">El. paštas</label>
            <input class="form-group <?php echo htmlspecialchars(isset($errors['email']) ? 'error-field' : '')?>" type="email" name="email" id="email" value="<?php echo htmlspecialchars($_POST['email'] ?? '')?>" placeholder="vardas@domentas.lt">
            <label class="form-label" for="name">Vardas</label>
            <input class="form-group <?php echo htmlspecialchars(isset($errors['name']) ? 'error-field' : '')?>" type="text" name="name" id="name" value="<?php echo htmlspecialchars($_POST['name'] ?? '')?>">
            <label class="form-label" for="last_name">Pavardė</label>
            <input class="form-group <?php echo htmlspecialchars(isset($errors['last_name']) ? 'error-field' : '')?>" type="text" name="last_name" id="last_name" value="<?php echo htmlspecialchars($_POST['last_name'] ?? '')?>">
            <label class="form-label" for="phone">Telefonas</label>
            <input class="form-group <?php echo htmlspecialchars(isset($errors['phone']) ? 'error-field' : '')?>" type="number" name="phone" id="phone" value="<?php echo htmlspecialchars($_POST['phone'] ?? '')?>" placeholder="37061234567">
            <label class="form-label" for="password">Slaptažodis</label>
            <input class="form-group <?php echo htmlspecialchars(isset($errors['password']) ? 'error-field' : '')?>" type="password" name="password" id="password" value="<?php echo htmlspecialchars($_POST['password'] ?? '')?>">
            <label class="form-label" for="repeat_password">Pakartoti slaptažodį</label>
            <input class="form-group <?php echo htmlspecialchars(isset($errors['password']) ? 'error-field' : '')?>" type="password" name="repeat_password" id="repeat_password" onkeyup="confirmPassword(this.value)" value="<?php echo htmlspecialchars($_POST['repeat_password'] ?? '')?>">
            <p id="error">Slaptažodžiai nesutampa</p>
            <button class="btn" type="submit" name="submit">Registruotis</button>
        </form>
    </div>
</div>

<script>
    function confirmPassword(confirmPassword) {
        var password = document.getElementById("password").value;
        var message = document.getElementById("error");
        // Check if passwords match
        if (password != confirmPassword) {
            // Display message that passwords don't match
            message.style.visibility = "visible";
        } else {
            // Hide message that passwords don't match
            message.style.visibility = "hidden";
        }
    }
</script>
</body>
</html>