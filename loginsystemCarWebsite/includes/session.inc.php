
<!-- Check this page --> 

<?php
include('dbh.inc.php');
session_start();
//checking whether user is logged in
$user_check = $_SESSION["login_user"];
//selecting user from user table in database
$ses_sql = mysqli_query($conn,"SELECT userID FROM user WHERE userID = '$user_check' ");
$row = mysqli_fetch_array($ses_sql,MYSQLI_ASSOC);
//if a user isn't logged it, it will redirect them to the sign in page
if(!isset($_SESSION["login_user"])){
header("location:index.php");
}
?>
