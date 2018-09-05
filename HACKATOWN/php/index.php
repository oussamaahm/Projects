<?php

require_once ('config.php');

require_once ('checkConnection.php');



?>

<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <link rel="stylesheet" href="../css/main.css">

    <title>Parking - HackaTown2K18</title>
</head>
<body id="main">

<nav id="nav" class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="index.php">Parking</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <?php
                if($_SESSION['isConnected']){
                echo '<span class="nav-link">Welcome, '. $_SESSION['username'];
                ?>
            <li>
                <a class="nav-link" href="map1.php">Map<span class="sr-only">(current)</span></a>
            </li>
            <li>
                <a class="nav-link" href="disconnect.php">Disconnect<span class="sr-only">(current)</span></a>
            </li>
            </li>
            <?php
            }
            else{
                ?>
                <a class="nav-link" href="signup.php">Log in / Sign up<span class="sr-only">(current)</span></a>
                </li>
                <?php
            }
            ?>
        </ul>
    </div>
</nav>


<div id="jumbotron2" >
    <h1><b>Hello, world!</b></h1>
    <p class="lead">Welcome to our first version of ParkingSlot !</p>
    <hr class="my-4">
    <p>This website allows you to ...</p>
    <div id="alert" class="alert alert-success" role="alert">
        Last Update : 20/01/2018 - 13h00
    </div>
</div>
<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>
