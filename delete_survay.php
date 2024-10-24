<?php
session_start();
require_once 'config.php';

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true || $_SESSION["is_admin"] != 1) {
    header("location: login.php");
    exit;
}

$id = isset($_GET['id']) ? intval($_GET['id']) : null;

if (!$id) {
   
