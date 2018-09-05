<?php
/**
 * To create new accounts for the website
 * \File : signup.php
 */
require_once ('config.php');
require_once ('checkConnection.php');
$errors = [];
if($_SESSION['isConnected']){
    header('Location: index.php');
    exit();
}
elseif (isset($_POST['username']) && isset($_POST['password']) && isset($_POST['email']) && isset($_POST['passwordConf'])){
    if(!empty($_POST['username']) && !empty($_POST['password']) && !empty($_POST['email']) && !empty($_POST['passwordConf'])){
        if($_POST['password'] != $_POST['passwordConf']){
            $errors[] = "Passwords must match";
        }
        if(strlen($_POST['password']) < $MIN_PASS_LEN ){
            $errors[] = "The password must be " . $MIN_PASS_LEN . " characters or more.";
        }
        if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
            $errors[] = "Invalid email";
        }
        // TODO : Add check for username availability
    }
    else{
        $errors[] = "Please enter everything";
    }
    if(empty($errors)){
        // Can create account
        require_once ('db.php');
        $req = $db->prepare('INSERT INTO users(username, password, email, accessLevel, dateCreated) VALUES(:username, :hashedPass, :email , :access, NOW())');
        $req->execute(array(
            'username' => $_POST['username'],
            'hashedPass' => password_hash($_POST['password'], PASSWORD_DEFAULT),
            'email' => $_POST['email'],
            'access' => $DEFAULT_LEVEL
        ));
        // TODO : add error checking to account creation
        // account created, redirect
        header('Location: login.php?created=true');
    }
}
?>



</body>
</html>


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
            height: match;
            border-radius: 25px;
            margin-top: 100px;
            opacity: 0.97;
        }

    </style>

</head>


<body id="main" >

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

<center>
    <div id=box class="container-fluid">
        <br>
        <h1> <b> Sign up </b> </h1>
        <br>
        <form action="signup.php" method="post">
        <div  class="input-group mb-3">
            <div class="input-group mb-3">

                <input type="text" class="form-control" placeholder="Email" aria-label="Email" name="email" aria-describedby="basic-addon1">
            </div>

            <input type="text" class="form-control" placeholder="Username" aria-label="Username" name="username" aria-describedby="basic-addon1">
        </div>

        <div class="input-group mb-3">

            <input type="Password"  class="form-control" placeholder="Password" aria-label="Password" name="password" aria-describedby="basic-addon1">
        </div>

        <div class="input-group mb-3">

            <input type="Password" class="form-control" placeholder="Confirm Password" aria-label="Confirm Password" name = "passwordConf" aria-describedby="basic-addon1">
        </div>


        <button style="margin-bottom:20px"  type="submit" class="btn btn-primary">Submit</button>
        <a href="login.php"><button style="margin-bottom:20px"  type="button" class="btn btn-primary">Log in</button></a>
        <?php
        require ('errors.php');
        ?><br>
		</form>
        
    </div>

</center>

<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

</body>
</html>