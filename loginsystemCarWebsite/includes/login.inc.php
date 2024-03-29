<?php
// check whether the user got to this page by clicking the proper login button.
if (isset($_POST['login-submit'])) {

  // include the connection script.
  require 'dbh.inc.php';

  // grabbing all the data which we passed from the signup form so we can use it later.
  $mailuid = $_POST['mailuid'];
  $password = $_POST['pwd'];

  // error handling to catch any errors made by the user.

      //check for any empty inputs.
      if (empty($mailuid) || empty($password)) {
        header("Location: ../index.php?error=emptyfields&mailuid=".$mailuid);
        exit();
      }
      else {

      // getting the password from the user in the database that has the same username as what the user typed in, then de-hash it and check if it matches the password the user typed into the login form.

      // connect to the database using prepared statements which work by sending SQL to the database first, then fill in the placeholders by sending the users data.
      $sql = "SELECT * FROM users WHERE uidUsers=? OR emailUsers=?;";
      // initialize a new statement using the connection from the dbh.inc.php file.
      $stmt = mysqli_stmt_init($conn);
      // prepare SQL statement AND check if there are any errors with it.
      if (!mysqli_stmt_prepare($stmt, $sql)) {
        // If there is an error send the user back to the signup page.
        header("Location: ../index.php?error=sqlerror");
        exit();
      }
      else {

      // If there is no error then continue the script!

      // bind the type of parameters we expect to pass into the statement, and bind the data from the user
      mysqli_stmt_bind_param($stmt, "ss", $mailuid, $mailuid);
      // execute the prepared statement and send it to the database
      mysqli_stmt_execute($stmt);
      // get the result from the statement.
      $result = mysqli_stmt_get_result($stmt);
      // store the result into a variable.
      if ($row = mysqli_fetch_assoc($result)) {
      // match the password from the database with the password the user submitted. The result is returned as a boolean
      $pwdCheck = password_verify($password, $row['pwdUsers']);
      // If they don't match then create an error message
      if ($pwdCheck == false) {
      // If there is an error send the user back to the signup page
      header("Location: ../index.php?error=wrongdetails");
      exit();
      }
      // if they match, then it is the correct user
      else if ($pwdCheck == true) {

      // Next create session variables based on the users information from the database. If these session variables exist, then the website will know that the user is logged in

      //storing data in session variables which are a type of variables that can be used on all pages that has a session running in it.
      //start a session to create the variables
      session_start();
      // createing the session variables.
      $_SESSION['id'] = $row['idUsers'];
      $_SESSION['uid'] = $row['uidUsers'];
      $_SESSION['email'] = $row['emailUsers'];
      // user is registered as logged in and taken back to front page
      header("Location: ../index.php?login=success");
      exit();
      }
    }
      else {
        header("Location: ../index.php?login=wronguidpwd");
        exit();
      }
    }
  }
  // close the prepared statement and the database connection
  mysqli_stmt_close($stmt);
  mysqli_close($conn);
}
else {
  // If the user tries to access this page an inproper way, they are sent back to the signup page.
  header("Location: ../signup.php");
  exit();
}
