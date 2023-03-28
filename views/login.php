<?php
include '../src/Authentication/Authentication.php';
if ($_POST && !isset($_POST['confirm-password'])) {
    $Authentication = new Authentication();
    if (!$Authentication->isLoggedIn()){
        $log_in = $Authentication->login($_POST['username'] , $_POST['password']);
    }
} else if ($_POST && isset($_POST['confirm-password'])) {
//    var_dump($_POST);
//    die('sfjklds');
    if ($_POST['password'] == $_POST['confirm-password']){
        $Authentication = new Authentication();
        $register = $Authentication->register(['username'=>$_POST['username'] , 'password' => $_POST['password']]);
        var_dump($register);
    }

}
if (isset($log_in) || isset($register)) {
    session_start();
    $_SESSION['username'] = $_POST['username'];
    header("Location: /php_learning/all_solid/admin ");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login/Register Page</title>
    <link rel="stylesheet" href="views/css/App.css">
</head>
<body>
<div class="container">
    <div class="form-container">
        <form method="post" id="login-form">
            <h2>Login</h2>
            <label for="username">Username:</label>
            <input type="text" name="username" id="username" required>
            <label for="password">Password:</label>
            <input type="password" name="password" id="password" required>
            <button type="submit" class="btn">Login</button>
        </form>
        <form method="post" id="register-form">
            <h2>Register</h2>
            <label for="username">Username:</label>
            <input type="text" name="username" id="username" required>
            <label for="password">Password:</label>
            <input type="password" name="password" id="password" required>
            <label for="confirm-password">Confirm Password:</label>
            <input type="password" name="confirm-password" id="confirm-password" required>
            <button type="submit" class="btn">Register</button>
        </form>
    </div>
</div>
<script src="views/js/App.js"></script>
</body>
</html>
