<?php
/**
 * Controls connection to the website
 * \File : login.php
 * \Author : Émile Larose-Levac
 */

require_once('config.php');

try
{
    // Edit the credentials in config.php
    $db = new PDO('mysql:host=localhost;dbname=' . $dbName . ';charset=utf8', $dbUser, $dbPasswd);
}
catch (Exception $e)
{
    die('Error : ' . $e->getMessage());
}
?>