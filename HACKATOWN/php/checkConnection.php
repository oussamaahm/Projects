<?php
/**
 * Created by PhpStorm.
 * User: MagicHack
 * Date: 2018-01-20
 * Time: 12:48
 */
session_start();

if(isset($_SESSION['username']) && isset($_SESSION['level']) && !empty($_SESSION['username']) && !empty($_SESSION['level'])){
    $_SESSION['isConnected'] = true;
}else{
    $_SESSION['isConnected'] = false;
}

?>
