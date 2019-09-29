<!-- profile edit page --> 



<?php
include('includes/session.inc.php');
//displaying user info
function displayUser($conn, $login_user) {
//select from user database and return data
$sql = "SELECT userID, Username, Password, Email FROM user
WHERE userID = '$login_user' ";
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
$sql = "UPDATE user SET Username = '$myusername', Password = '$mypassword', Email =
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
  <title>Dashboard</title>

	</head>


  <body>

    <!--Import jQuery before materialize.js-->
  <script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
  <script type="text/javascript" src="js/materialize.min.js"></script>
  <script type="text/javascript" src="main.js"></script>

          <!--header -->
          <header>

            <!-- navbar -->
            <nav>
              <!-- link to top -->
            <a id="top"> </a>

            <!-- brand logo -->
              <div class="nav-wrapper blue-grey darken-2">
           <a href="index.html" class="brand-logo"><img src="assets/logo3.jpg" width="200" height="64"></a>

           <!-- mobile menu -->
           <a href="#" data-activates="mobile-demo" class="button-collapse"><i class="material-icons">menu</i></a>
				  <ul class="right hide-on-med-and-down"> </ul>

              <!-- buttons -->
              <ul id="nav-mobile" class="right hide-on-med-and-down">
				  <li><a href="blog.php" class="waves-effect waves-light btn blue-grey darken-4">Blog</a></li>
             <li><a href="champions.php"class="waves-effect waves-light btn blue-grey darken-4">Champions</a></li>
             <li><a href="Tactics.php"class="waves-effect waves-light btn blue-grey darken-4">Tactics and Strategy</a></li>
			 <li><a href="contact.php"class="waves-effect waves-light btn blue-grey darken-4">Contact Us</a></li>
           </ul>
         </div>
                    <!-- mobile menu -->
                   <ul class="side-nav" id="mobile-demo">
          <li><a href="index.html">Home</a></li>
          <li><a href="champions.html">Champions</a></li>
          <li><a href="Tactics.html">Tactics and Strategy</a></li>
          </ul>

                 </nav>
                  <!-- end of navar -->


      <!-- header-->
      </header>

<div class="container">

<!-- Returned data from user table connected by names -->
<form action = "" method = "post">
<label>Username :</label><input type = "text" name = "txtUsername" value = "<?php
echo $row["Username"]?>" class = "box"/><br /><br />
<label>Password :</label><input type = "text" name = "txtPassword" value = "<?php
echo $row["Password"]?>" class = "box"/><br /><br />
<label>Email :</label><input type = "text" name = "txtEmail" value = "<?php
echo $row["Email"]?>" class = "box"/><br /><br />

	<!-- update button -->
<button type="submit" name="update">Update</button>
	<!-- delete button -->
<button type="submit" name="delete">Delete</button>
</form>

	<!-- logout button -->
	<a href="logout.php" class="waves-effect waves-light btn blue-grey darken-4">Logout</a>

	<!-- echo the info from top -->
	<?php echo $info;
?>

	  </div>

	  <br />

 <!-- parallax image -->
  <div class="parallax-container">
    <div class="parallax"> <img class="responsive-img" src="assets/plaxImg.jpg"/></div>
  </div>

<?php
	include ("footer.php")
		?>

  </body>
</html>
