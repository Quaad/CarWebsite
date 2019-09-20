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
          if (!isset($_SESSION['id'])) {
            echo '<p class="login-status">You are logged out!</p>';
          }
          else if (isset($_SESSION['id'])) {
            echo '<p class="login-status">You are logged in!</p>';
          }
            
            
            
            
            
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
  require "footer.php";
?>
