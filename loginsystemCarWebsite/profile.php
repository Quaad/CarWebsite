<!-- profile edit page -->

<?php
  require "header.php";
?>

<?php
//display user info by connecting to the database and matching the session id to the database  id
function displayUser($conn, $id) {
	//select from user database and give out the data from the table
	$sql = "SELECT idUsers, uidUsers, emailUsers, foreUsers, surUsers, dobUsers, telephoneUsers, postUsers FROM users WHERE idUsers = '$id'";
	//if there is a result, fetch and return the data
	$result = mysqli_query($conn,$sql);
	$row = mysqli_fetch_array($result,MYSQLI_ASSOC);
	return $row;
}

function updateUser($conn, $id) {
	//assigned to the text boxes on the page
	$uidUsers = mysqli_real_escape_string($conn,$_POST["txtuidUsers"]);
	$emailUsers = mysqli_real_escape_string($conn,$_POST["txtemailUsers"]);
	$foreUsers = mysqli_real_escape_string($conn,$_POST["txtForname"]);
	$surUsers = mysqli_real_escape_string($conn,$_POST["txtsurUsers"]);
	$dobUsers = mysqli_real_escape_string($conn,$_POST["numDate"]);
	$telephoneUsers = mysqli_real_escape_string($conn,$_POST["numPhone"]);
	$postUsers = mysqli_real_escape_string($conn,$_POST["txtpostcode"]);
	$session_idUsers = $_SESSION['id'];

  //ERROR HANDLERS AND EMAIL VALIDITY - CHECK THISSSSSSSS
  // check for any empty inputs.
  if (empty($uidUsers) || empty($emailUsers) || empty($foreUsers) || empty($surUsers) ||  empty($dobUsers) || empty($telephoneUsers || empty($postUsers))) {
    header("Location: profile.php?error=emptyfields&uid=".$username."&mail=".$email);
    exit();
  }
  // check for an invalid username AND invalid e-mail.
  else if (!preg_match("/^[a-zA-Z0-9]*$/", $uidUsers) && !filter_var($emailUsers, FILTER_VALIDATE_EMAIL)) {
    header("Location: profile.php?error=invaliduidmail");
    exit();
  }
  // check for an invalid username. In this case ONLY letters and numbers.
  else if (!preg_match("/^[a-zA-Z0-9]*$/", $uidUsers)) {
    header("Location: profile.php?error=invaliduid&mail=".$emailUsers);
    exit();
  }
  // check for an invalid e-mail.
  else if (!filter_var($emailUsers, FILTER_VALIDATE_EMAIL)) {
    header("Location: profile.php?error=invalidmail&uid=".$uidUsers);
    exit();
  }

	//update data in user table if the uidUsers and password are the same
	$sql = "UPDATE users SET uidUsers = '$uidUsers' , emailUsers = '$emailUsers', foreUsers ='$foreUsers', surUsers='$surUsers', dobUsers ='$dobUsers', telephoneUsers ='$telephoneUsers' WHERE idUsers = '$session_idUsers';";
	if (mysqli_query($conn, $sql)){

		$info = "User Update Completed ";
		echo "<br>".$info;
	}else{
		//if it does not connect then display error message
		$info = "An Error Occured Whilst Updating User: ". mysqli_error($conn);
		echo "<br>".$info;

	}
		$row = displayUser($conn, $_SESSION["id"]);
		return $info;
	}

  //update button
  if(isset($_POST["update-details"])){
  	$info = updateUser($conn, $_SESSION["id"]);
  }

  //displaying the data from the table of the logged in user
  $row = displayUser($conn, $_SESSION["id"]);

  //closing the connection
  mysqli_close($conn);

  ?>

      <!--header -->
     <header>
       <title> Profile </title>
      </header>
<div class="container-fluid">
<!-- Returned data from user table connected by names -->
<form  action = "" method = "post">

  <div class="form-row">

    <div class="form-group col-md-3">
      <label>Username: </label>
      <input type="text" class="form-control"  name = "txtuidUsers" value = "<?php echo $row["uidUsers"]?>">
    </div>
    <div class="form-group col-md-3">
      <label>Email: </label>
      <input type="text" class="form-control"  name = "txtemailUsers" value = "<?php echo $row["emailUsers"]?>">
    </div>
    <div class="form-group col-md-3">
      <label>Firstname: </label>
      <input type="text" class="form-control"  name = "txtForname" value = "<?php echo $row["foreUsers"]?>">
    </div>
    <div class="form-group col-md-3">
      <label>Surname: </label>
      <input type="text" class="form-control"  name = "txtsurUsers" value = "<?php echo $row["surUsers"]?>">
    </div>
    <div class="form-group col-md-4">
      <label>Date Of Birth: </label>
      <input type="date" class="form-control"  name = "numDate" value = "<?php echo $row["dobUsers"]?>">
    </div>
    <div class="form-group col-md-4">
      <label>Phone Number: </label>
      <input type="number" class="form-control"  name = "numPhone" value = "<?php echo $row["telephoneUsers"]?>">
    </div>
    <div class="form-group col-md-4">
      <label>Postcode: </label>
      <input type="text" class="form-control"  name = "txtpostcode" value = "<?php echo $row["postUsers"]?>">
    </div>

  </div>

  <button type="submit" class="btn btn-primary" name="update-details">Update</button>
</form>





      <!-- ERROR OUTPUTS CHECK THISSSSSSS -->
      <?php
      if (isset($_GET["error"])) {
        if ($_GET["error"] == "emptyfields") {
          echo '<p class="signuperror">Fill in all fields!</p>';
        }
        else if ($_GET["error"] == "invaliduidmail") {
          echo '<p class="signuperror">Invalid username and e-mail!</p>';
        }
        else if ($_GET["error"] == "invaliduid") {
          echo '<p class="signuperror">Invalid username!</p>';
        }
        else if ($_GET["error"] == "invalidmail") {
          echo '<p class="signuperror">Invalid e-mail!</p>';
        }
        else if ($_GET["error"] == "passwordcheck") {
          echo '<p class="signuperror">Your passwords do not match!</p>';
        }
        else if ($_GET["error"] == "usertaken") {
          echo '<p class="signuperror">Username is already taken!</p>';
        }
      }

      if(!isset($_SESSION['id'])){
      header("location:index.php");
      }

      ?>

</div>


  </body>
</html>
