<?php
include_once "connection.php";
session_unset();
session_destroy();
header("Location:index.php");
?>