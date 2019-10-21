<?php
require "header.php"
?>

<!-- search and submit button -->
<form class="form-inline my-2 my-lg-0"  action="cars.php" method="POST">
  <input class="form-control mr-sm-2" type="text" name="search" placeholder="Search" aria-label="Search">
  <button class="btn btn-outline-success my-2 my-sm-0" type="submit" name="submit-search">Search</button>
</form>

<h2>All Cars:</h2>

  <?php
  //if the button is not pressed output all info from database
  if (!isset($_POST['submit-search'])) {
  // Selecting from car table
    $sql = "SELECT * FROM cars";
    //getting a result
    $result = mysqli_query($conn, $sql);
    //creating a function
    $queryResults = mysqli_num_rows($result);

    //if there is a result echo the rows
    if ($queryResults > 0) {

      //while loop which outputs info from database
      while ($row = mysqli_fetch_assoc($result)) {
        echo "
        <div class='container-fluid '>
        <div class='card mb-3' style='max-width: 540px max-height: 200px;' >
        <div class='row no-gutters'>
          <div class='col-md-4'>
            <img src='".$row['image']."' class='card-img' alt='...'>
          </div>
            <div class='col-md-8'>
              <div class='card-body'>
                <h3 class='card-text'> ".$row['make']." </h3>
              <div class='row'>
                <div class='col-md-6'>
                  <p> Model: ".$row['model']." </p>
                  </div>
                  <div class='col-md-6'>
                  <p> Size: ".$row['size']." </p>
                </div>
              </div>
              <div class='row'>
                <div class='col-md-6'>
                  <p> Colour: ".$row['colour']." </p>
                  </div>
                  <div class='col-md-6'>
                  <p> Engine: ".$row['engine']." </p>
                </div>
              </div>
            <p> Date: ".$row['year']." </p>
          </div>
        </div>
      </div>
    </div>
  </div>";
      }
    }
  }

    //if submit button is pressed show results associated to what user typed in
    else if (isset($_POST['submit-search'])) {

    //no sql injection - safe data
    $search = mysqli_real_escape_string($conn, $_POST['search']);
    //searching the database for what the user typed
    $sql = "SELECT * FROM cars WHERE make LIKE '%$search%' OR model LIKE '%$search%' OR size LIKE '%$search%' OR colour LIKE '%$search%'
    OR engine LIKE '%$search%' OR year LIKE '%$search%'";
    $result = mysqli_query($conn, $sql);
    $queryResult = mysqli_num_rows($result);

    //checking for a result
    if ($queryResult > 0) {
      echo "There are ".$queryResult." results!";
      while ($row = mysqli_fetch_assoc($result)) {

        echo "
        <div class='container-fluid '>
        <div class='card mb-3' style='max-width: 540px max-height: 200px;' >
        <div class='row no-gutters'>
          <div class='col-md-4'>
            <img src='".$row['image']."' class='card-img' alt='...'>
          </div>
            <div class='col-md-8'>
              <div class='card-body'>
                <h3 class='card-text'> ".$row['make']." </h3>
              <div class='row'>
                <div class='col-md-6'>
                  <p> Model: ".$row['model']." </p>
                  </div>
                  <div class='col-md-6'>
                  <p> Size: ".$row['size']." </p>
                </div>
              </div>
              <div class='row'>
                <div class='col-md-6'>
                  <p> Colour: ".$row['colour']." </p>
                  </div>
                  <div class='col-md-6'>
                  <p> Engine: ".$row['engine']." </p>
                </div>
              </div>
            <p> Date: ".$row['year']." </p>
          </div>
        </div>
      </div>
    </div>
  </div>";
      }
    }
    //else echo out if there are no results related to the search
    else {
      echo "There are no results matching your search";
    }
  }

 ?>

</body>
</html>
