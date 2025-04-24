<?php
    session_set_cookie_params([
        'path' => '/',
        'domain' => $_SERVER['HTTP_HOST'],
        'secure' => false, // Set to true in HTTPS
        'httponly' => true
    ]);
    session_start();
    define("BASE_URL", "http://" . $_SERVER['HTTP_HOST'] . "/crop_insurance/");
?>