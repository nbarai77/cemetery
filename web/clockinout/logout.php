<?php
    session_start();
    $_SESSION['is_user'] = '';
    $_SESSION['title'] = '';
    $_SESSION['name'] = '';
    session_destroy();
    header('Location: /clockinout/login.php');
?>