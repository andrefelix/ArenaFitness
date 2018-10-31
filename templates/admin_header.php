<?php

require_once 'util/session.php';

if (!isset($_SESSION['userID'])) {
    endSession();
}

?>

<!doctype html>
<html lang="pt">
<head>
    <title>Arena Fitness</title>
    <meta charset="utf-8">
    <!-- Set the viewport width to device width for mobile -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/bootstrap.modified.css">
    <script src="../js/jquery/jquery-3.1.1.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
</head>
<body class="body">
    <header class="mainHeader">
        <div class="navbar navbar-inverse navbar-static-top">
            <div class="container">
                <a href="#" class="navbar-brand">Arena Fitness</a>
                <button class="navbar-toggle" data-toggle="collapse" data-target=".navHeaderCollapse">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <div class="collapse navbar-collapse navHeaderCollapse">
                    <ul class="nav navbar-nav">
                        <li class="active"><a href="index.php">Home</a></li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Cliente <b class="caret"></b></a>
                            <ul class="dropdown-menu">
                                <li><a href="controller.php?action=registerClientsView">Cadastrar</a></li>
                                <li><a href="controller.php?action=listClients">Listar</a></li>
                            </ul>
                        </li>
                        <li><a href="#">Funcionário</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </header>
    <!--
    <body class="body">
    <header class="mainHeader">
    <img src="../images/mysql_logo.png">
    <nav><ul>
        <li class="active"><a href="index.php">Home</a></li>
        <li><a href="controller.php?action=registerClientsView">Cadastrar Clientes</a></li>
        <li><a href="controller.php?action=listClients">Listar Clientes</a></li>
    </ul></nav>
    </header>
    -->