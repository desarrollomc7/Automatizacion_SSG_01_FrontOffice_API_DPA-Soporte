<?php
    session_start();
    unset($_SESSION["Usuario"]);
    session_destroy();
    header("Location: login.php");
    exit;
?>