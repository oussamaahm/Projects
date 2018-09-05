<?php
/**
 * Controls connection to the website
 * \File : login.php
 */
require_once ('config.php');
require_once('checkConnection.php');
$errors = [];
if($_SESSION['isConnected']){
    header('Location: index.php');
    exit();
}
// Put in a function??
elseif(isset($_POST['username']) && isset($_POST['password']) AND !empty($_POST['username']) && !empty($_POST['password'])){
    require_once ('db.php');

    $req = $db->prepare('SELECT * FROM users WHERE username = :username');
    $req->execute(array(
        'username' => $_POST['username']
        ));
    $loginSuccess = false;
    $data = $req->fetch();

    if(password_verify($_POST['password'], $data['password'])){
        if($data['accessLevel'] >= $ACTIVATION_LEVEL) {
            // setting sessions variables that verifies connection
            $_SESSION['isConnected'] = true;
            $_SESSION['username'] = $data['username'];
            $_SESSION['level'] = $data['accessLevel'];
            header('Location: map1.php');
        }
        else{
            $errors[] = "Your account is not currently activated";
        }
    }
    else{
        // Wrong password
        $errors[] = "Wrong username or password";
    }
}
?>


<!DOCTYPE html>
<head>

    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <link rel="stylesheet" href="../css/main.css">

    <title>Parking - HackaTown2K18</title>

    <style>
        #main{

            background-image: url("../img/wallpaper.jpg");
            vertical-align: center;

        }
        #box{
            background-color: white;
            width : 400px;
            height: 50%;
            border-radius: 25px;
            margin-top: 160px
        }

    </style>

</head>
<body id="main" >

<center>

    <nav id="nav" class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="index.php">Parking</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="signup.php">Log in / Sign up<span class="sr-only">(current)</span></a>
                </li>
            </ul>
        </div>
    </nav>

    <div id=box class="container-fluid">
        <br>
        <h1> <b> Login </b> </h1>
        <br>
        <form action="login.php" method="post">
        <div  class="input-group mb-3">
            <input type="text" class="form-control" placeholder="Username" aria-label="Username" name="username" aria-describedby="basic-addon1">
        </div>
        <br>
        <div class="input-group mb-3">

            <input type="Password" class="form-control" placeholder="Password" aria-label="Password" name="password" aria-describedby="basic-addon1">
        </div>
        <button style="margin-bottom:20px" type="submit" class="btn btn-primary">Login</button>
        <a href="signup.php"> <button style="margin-bottom:20px"  type="button" class="btn btn-primary">Sign up</button> </a>
        </form>
        <?php
        require ('errors.php');
        ?>

    </div>

</center>

<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

</body>
</html>


