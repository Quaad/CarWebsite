<!-- profile edit page --> 



<?php

//displaying user info
function displayUser($conn, $login_user) {
//select from user database and return data
$sql = "SELECT idUsers, uidUsers, emailUsers, pwdUsers FROM users
WHERE idUsers = '$login_user' ";
//if there is a result, fetch and return the row
$result = mysqli_query($conn,$sql);
$row = mysqli_fetch_array($result,MYSQLI_ASSOC);
return $row;
}

//update function
function updateUser($conn, $login_user) {
////username, password and email assignned to the two txt boxes on the page.
$myusername = mysqli_real_escape_string($conn,$_POST["txtUsername"]);
$mypassword = mysqli_real_escape_string($conn,$_POST["txtPassword"]);
$myemail = mysqli_real_escape_string($conn,$_POST["txtEmail"]);
//update data in user table where the UserID matches the logged in UserID
$sql = "UPDATE users SET uidUsers = '$myusername', Password = '$mypassword', Email =
'$myemail' WHERE userID = '$_SESSION[login_user]' ";
//if it connects, run the sql
if (mysqli_query($conn, $sql)) {
//return message when updated
$info = "Updated User successfully ";
}
else {
//return error message
$info = "Error updating User: ". mysqli_error($conn);
}
return $info;
}
//delete function
function deleteUser($conn, $login_user) {
$sql = "DELETE FROM user WHERE user.UserID=" . $_SESSION[login_user] . " ";
if (mysqli_query($conn, $sql, $sql2)) {
	  header("location:SignIn.php");
} else {
$info = "Error deleting User: " . mysqli_error($conn);
}
return $info;
}
//update button
if(isset($_POST["update"])){
$info = updateUser($conn, $_SESSION["login_user"]);
}
//delete button
else if (isset($_POST["delete"])){
//connnected to function by deleteUser
$info = deleteUser($conn, $_SESSION["login_user"]);
}
//displaying the data from the table of the logged in user
$row = displayUser($conn, $_SESSION["login_user"]);
//closing the connection
mysqli_close($conn);
?>

<html>
  <head>
    <!--Import Google Icon Font-->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!--Import materialize.css-->
    <link type="text/css" rel="stylesheet" href="css/materialize.min.css"  media="screen,projection"/>
    <!-- my style sheet -->
    <link href="myStylesheets.css" type="text/css" rel="stylesheet"/>

    <!--Let browser know website is optimized for mobile-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Profile</title>

	</head>


  <body>



      <!--header -->
     <header>

            
      <!-- header-->
      </header>

<div class="container">

<!-- Returned data from user table connected by names -->
<form action = "" method = "post">
<label>Username :</label><input type = "text" name = "txtUsername" value = "<?php
echo $row["uidUsers"]?>" class = "box"/><br /><br />
<label>Password :</label><input type = "text" name = "txtPassword" value = "<?php
echo $row["pwdUsers"]?>" class = "box"/><br /><br />
<label>Email :</label><input type = "text" name = "txtEmail" value = "<?php
echo $row["emailUsers"]?>" class = "box"/><br /><br />

	<!-- update button -->
<button type="submit" name="update">Update</button>
	<!-- delete button -->
<button type="submit" name="delete">Delete</button>
</form>


	<!-- echo the info from top -->
	<?php echo $info;
?>

	  </div>


<?php
	include ("footer.php")
		?>

  </body>
</html>
