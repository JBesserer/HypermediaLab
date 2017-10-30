<?php
/**
 * Created by PhpStorm.
 * User: Jeremy
 * Date: 2017-10-18
 * Time: 2:58 PM
 */

session_start();
error_reporting(0);
if(isset($_POST['init'])){
    echo $_SESSION["panierCount"];
}

if(isset($_POST["id"])){
    $_SESSION['idProduct'][$_SESSION['panierCount']] = $_POST['id'];
    echo ++$_SESSION["panierCount"];
}

