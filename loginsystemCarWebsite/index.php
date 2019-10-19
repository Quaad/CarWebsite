<?php
  // To make sure we don't need to create the header section of the website on multiple pages, we instead create the header HTML markup in a separate file which we then attach to the top of every HTML page on our website. In this way if we need to make a small change to our header we just need to do it in one place. This is a VERY cool feature in PHP!
  require "header.php";
?>

    <main>
      <div class="wrapper-main">
        <section class="section-default">
          <!--
          We can choose whether or not to show ANY content on our pages depending on if we are logged in or not.
          -->
          <?php

          function displayUser($conn, $id) {
          $sql = "SELECT idUsers, uidUsers FROM users WHERE idUsers = '$id'";

          if($result = mysqli_query($conn, $sql)){
            $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
          	return $row;
          }
        }

        //If there is no session display the logged out text
        if (!isset($_SESSION['id'])) {
          echo '<p class="login-status">You are logged out!</p>';
        }
        //if a user is logged in display the welcome message from their stored session username
        else if (isset($_SESSION['id'])) {
          $row = displayUser($conn, $_SESSION["id"]);
          echo '<p class="login-status"> Welcome '.$row['uidUsers'];
        }

        //Error handlers
        if (isset($_GET["error"])) {
        if ($_GET["error"] == "emptyfields&mailuid=") {
        echo '<p class="signuperror">Fill in all fields!</p>';
        }
        else if ($_GET["error"] == "wrongdetails") {
        echo '<p class="signuperror">Fill in all fields!</p>';
        }
    }

          ?>
        </section>
      </div>
    </main>

<?php
  // footer.
  include "footer.php";
?>
