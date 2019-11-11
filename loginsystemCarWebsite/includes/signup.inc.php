<?php
// check whether the user got to this page by clicking the proper signup button.
if (isset($_POST['signup-submit'])) {

  // include the connection script to use later.
  // don't have to close the MySQLi connection since it is done automatically.
  require 'dbh.inc.php';

  // grab all the data which was passed from the signup form so it can be used later.
  $username = $_POST['uid'];
  $email = $_POST['mail'];
  $password = $_POST['pwd'];
  $passwordRepeat = $_POST['pwd-repeat'];
  $forename = $_POST['fore'];
  $surname = $_POST['sur'];
  $postcode = $_POST['post'];
  $dob = $_POST['dob'];
  $telephone = $_POST['phone'];

  // error handling

  // check for any empty inputs.
  if (empty($username) || empty($email) || empty($password) || empty($passwordRepeat) || empty($forename) || empty($surname) || empty($postcode) || empty($dob) || empty($telephone)) {
    header("Location: ../signup.php?error=emptyfields&uid=".$username."&mail=".$email);
    exit();
  }
  // check for an invalid username AND invalid e-mail.
  else if (!preg_match("/^[a-zA-Z0-9]*$/", $username) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    header("Location: ../signup.php?error=invaliduidmail");
    exit();
  }
  // check for an invalid username. In this case ONLY letters and numbers.
  else if (!preg_match("/^[a-zA-Z0-9]*$/", $username)) {
    header("Location: ../signup.php?error=invaliduid&mail=".$email);
    exit();
  }
  // check for an invalid e-mail.
  else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    header("Location: ../signup.php?error=invalidmail&uid=".$username);
    exit();
  }
  // check if the repeated password is NOT the same.
  else if ($password !== $passwordRepeat) {
    header("Location: ../signup.php?error=passwordcheck&uid=".$username."&mail=".$email);
    exit();
  }
  else {

    // error handler that checks whether or the username is already taken.

    // create the statement that searches database table to check for any identical usernames.
    $sql = "SELECT uidUsers FROM users WHERE uidUsers=?;";
    // create a prepared statement.
    $stmt = mysqli_stmt_init($conn);
    // prepare our SQL statement and check if there are any errors with it.
    if (!mysqli_stmt_prepare($stmt, $sql)) {
      // If there is an error send the user back to the signup page.
      header("Location: ../signup.php?error=sqlerror");
      exit();
    }
    else {
      //  bind the type of parameters we expect to pass into the statement, and bind the data from the user.
      //  "s" means "string", "i" means "integer", "b" means "blob", "d" means "double".
      mysqli_stmt_bind_param($stmt, "s", $username);
      // execute the prepared statement and send it to the database!
      mysqli_stmt_execute($stmt);
      // store the result from the statement.
      mysqli_stmt_store_result($stmt);
      // get the number of result we received from our statement. This tells us whether the username already exists or not!
      $resultCount = mysqli_stmt_num_rows($stmt);
      // close the prepared statement!
      mysqli_stmt_close($stmt);
      // check if the username exists.
      if ($resultCount > 0) {
        header("Location: ../signup.php?error=usertaken&mail=".$email);
        exit();
      }
      else {


        //prepare the SQL statement to insert the users info into the database.

        // Prepared statements works by us sending SQL to the database first, and then later fill in the placeholders
        $sql = "INSERT INTO users (uidUsers, emailUsers, pwdUsers, foreUsers, surUsers, postUsers, dobUsers, telephoneUsers) VALUES (?, ?, ?, ?, ?, ?, ?, ?);";
        // initialize a new statement using the connection from the dbh.inc.php file.
        $stmt = mysqli_stmt_init($conn);
        // prepare the SQL statement and check if there are any errors with it.
        if (!mysqli_stmt_prepare($stmt, $sql)) {
          // If there is an error send the user back to the signup page.
          header("Location: ../signup.php?error=sqlerror");
          exit();
        }
        else {

          // hash the users password to make it un-readable
          $hashedPwd = password_hash($password, PASSWORD_DEFAULT);

          // bind the type of parameters we expect to pass into the statement, and bind the data from the user.
          mysqli_stmt_bind_param($stmt, "ssssssss", $username, $email, $hashedPwd, $forename, $surname, $postcode, $dob, $telephone);
          // execute the prepared statement and send it to the database
          // user is now registered
          mysqli_stmt_execute($stmt);
          // send the user back to the signup page with a success message
          header("Location: ../signup.php?signup=success");
          exit();

        }
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
