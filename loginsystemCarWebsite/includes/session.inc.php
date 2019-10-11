
<!-- Check this page -->

<?php
session_start();
include_once "dbh.inc.php";
//checking whether user is logged in
$user_check = $_SESSION['id'];
//selecting user from user table in database
$ses_sql = mysqli_query($conn,"SELECT idUsers FROM users WHERE idUsers = '$user_check' ");
$row = mysqli_fetch_array($ses_sql,MYSQLI_ASSOC);
//if a user isn't logged it, it will redirect them to the sign in page
if(!isset($_SESSION['id'])){
header("location:index.php");
}
?>
