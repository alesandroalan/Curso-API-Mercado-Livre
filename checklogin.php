<?php
session_start();

if(!isset($_SESSION['access_token']) || empty($_SESSION['access_token']))
    header('Location: index.php');