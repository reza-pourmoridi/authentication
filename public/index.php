<?php
include '../src/helper/functions.php';
include '../config/DB.php';

//database connection
$DB = new DB('localhost'  , 'all_solid', 'root', '');


//roots
// Define the mapping between path components and file paths
$file_map = [
    'login' => '../views/login.php',
    'admin' => '../views/dashboard.php',
];
include_file('all_solid', $file_map);