<?php
/**
 * Created by PhpStorm.
 * User: MagicHack
 * Date: 2018-01-20
 * Time: 14:39
 */

if(!empty($errors)){
    echo "<p class='errors'>";
    foreach ($errors as $e){
        echo $e . "<br>";
    }
    echo "</p>";
}
?>