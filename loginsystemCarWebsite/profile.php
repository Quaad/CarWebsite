<!-- profile edit page --> 



<?php
echo "were on the profile";
include 'includes/session.inc.php';

if (isset($_SESSION['id'])) {
    echo "session is set";
    include_once "includes/dbh.inc.php";
    $user_check = $_SESSION['id'];
    
    //select from user database and return data
    $sql = "SELECT * FROM users WHERE idUsers='$user_check';";
    //if there is a result, fetch and return the row
    $result = mysqli_query($conn,$sql);
  
    $resultCheck = mysqli_num_rows($result);
    if ($resultCheck > 0) {
        echo "results are ok";
        if ($row = mysqli_fetch_assoc($result)){
           echo $user_check; 
            echo $row['uidUsers'];
        }        
    } else {
        echo "no results";
    }
    
    
   
    //displaying user info

//$user_check = $_SESSION["login_user"];



}

?>  

<html>
  <head>

    <!--Let browser know website is optimized for mobile-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Profile</title>

	</head>


  <body>

<div class="container">

    <!-- Returned data from user table connected by names -->
    <form action="" method="post">
    <label>Username :</label>
    <input type="text" name="txtUsername" value="<?php echo $row['uidUsers']; ?>" class = "box"/><br /><br />
    <label>Password :</label>
    <input type = "text" name = "txtPassword" value = "<?php
    echo $row["pwdUsers"]; ?>" class = "box"/><br /><br />
    <label>Email :</label><input type = "text" name = "txtEmail" value = "<?php
    echo $row["emailUsers"]; ?>" class = "box"/><br /><br />

        <!-- update button -->
    <button type="submit" name="update">Update</button>
        <!-- delete button -->
    <button type="submit" name="delete">Delete</button>
    </form>


  </div>


  </body>
</html>
