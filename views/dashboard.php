<?php
session_start();
if(isset($_SESSION['username'])) {
    echo "Welcome, ".$_SESSION['username']."!";
} else {
    header("Location: /php_learning/all_solid/login ");
}