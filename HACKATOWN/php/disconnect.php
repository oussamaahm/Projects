<?php
/**
 * Created by PhpStorm.
 * User: MagicHack
 * Date: 2018-01-20
 * Time: 20:19
 */

require_once ('checkConnection.php');

if($_SESSION['isConnected']){
    session_destroy();
}


header('Location: index.php');