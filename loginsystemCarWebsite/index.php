<?php
  //adding the header.php to the top of the page
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

        <!-- Carousel -->
        <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
          <div class="carousel-inner">
            <div class="carousel-item active">
              <img src="img/logoNav.png" class="d-block w-100" alt="...">
            </div>
            <div class="carousel-item">
              <img src="img/logoTest.png" class="d-block w-100" alt="...">
            </div>
            <div class="carousel-item">
              <img src="img/logoNav.png" class="d-block w-100" alt="...">
            </div>
          </div>
          <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
          </a>
          <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
          </a>
        </div>
        </section>
      </div>
    </main>

<?php
  // footer.php
  include "footer.php";
?>
