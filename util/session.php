<?php

session_start();

function initSession() {
    if (isset($_SESSION['userID'])) {
        $uri = $_SERVER['REQUEST_URI'];
        $dirs = explode('/', $uri);
    
        if (isset($dirs[3]))
            header('Location: ../admin/index.php');
        else
            header('Location: admin/index.php');
    }
}

function endSession($message='') {
    if (isset($_SESSION['userID']))
        unset($_SESSION['userID']);

    if (!empty($_SESSION))
        session_destroy();

    $uri = $_SERVER['REQUEST_URI'];
    $dirs = explode('/', $uri);
    
    if (isset($dirs[3]))
        header('Location: ../index.php?message='.$message);
    else
        header('Location: index.php?message='.$message);
}

?>