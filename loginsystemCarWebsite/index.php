<?php
  //adding the header.php (navbar) to the top of the page
  require "header.php";
?>

    <main>
      <div class="wrapper-main">
        <section class="section-default">
          <!--
          choose whether or not to show any content on the pages depending on if the user is logged in or not.
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
