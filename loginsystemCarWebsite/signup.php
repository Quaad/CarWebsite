<?php
  //  header HTML markup in a separate file which we then attach to the top of every HTML page on our website.
  require "header.php";
?>

    <main>
          <h1 class="header-one">Signup</h1>
          <?php
          // create an error message if the user made an error trying to sign up.
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
          // create a success message if the new user was created.
          else if (isset($_GET["signup"])) {
            if ($_GET["signup"] == "success") {
              echo '<p class="signupsuccess">Signup successful!</p>';
            }
          }
          ?>
          <div class="container-fluid">
          <form class="form-row" action="includes/signup.inc.php" method="post">
            <?php
            // check if the user already tried submitting data.

            // check username.
            if (!empty($_GET["uid"])) {
              echo '<input type="text" name="uid" placeholder="Username" value="'.$_GET["uid"].'"> ';
            }
            else {
              //username form
              echo '<div class="form-group col-md-4"> <input type="text" class="form-control" name="uid" placeholder="Username"> </div>';
            }

            // check e-mail.
            if (!empty($_GET["mail"])) {
              echo '<input type="text" name="mail" placeholder="E-mail" value="'.$_GET["mail"].'">';
            }
            else {
              //email form
              echo '<div class="form-group col-md-4"><input type="text" class="form-control" name="mail" placeholder="E-mail"> </div>';
            }
            ?>

            <!-- Form -->
            <div class="form-group col-md-4">
              <input type="password" class="form-control"  name = "pwd" placeholder="Password">
            </div>
            <div class="form-group col-md-4">
              <input type="password" class="form-control"  name = "pwd-repeat" placeholder="Repeat Password">
            </div>
            <div class="form-group col-md-4">
              <input type="text" class="form-control"  name = "fore" placeholder="Forename">
            </div>
            <div class="form-group col-md-4">
              <input type="text" class="form-control"  name = "sur" placeholder="Surname">
            </div>
            <div class="form-group col-md-4">
              <input type="text" class="form-control"  name = "post" placeholder="Postcode">
            </div>
            <div class="form-group col-md-4">
              <input type="date" class="form-control"  name = "dob" placeholder="Date Of Birth">
            </div>
            <div class="form-group col-md-4">
              <input type="tel" class="form-control"  name = "phone" placeholder="Telephone">
            </div>

            <!-- signup button -->
            <button type="submit" id="btn" class="btn btn-primary hvr-pulse-grow" name="signup-submit">Signup</button>


        </div>

        <!-- end of form -->
        </form>

    </main>

<?php
  //footer
  include "footer.php";
?>
