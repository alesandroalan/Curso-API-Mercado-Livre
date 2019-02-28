<?php
session_start();

if(!isset($_SESSION['access_token']) || empty($_SESSION['access_token'])){
    header('Location: index.php');
}else{
    if(isset($_SESSION['expires_in']) && ($_SESSION['expires_in']  < time())) {
        header('Location: index.php');
    }
}
