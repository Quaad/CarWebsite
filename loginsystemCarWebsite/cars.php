<?php
require "header.php";
//if a user is not signed it, they will be unable to access this page
if(!isset($_SESSION['id'])){
header("location:index.php");
}
?>

<!-- search and submit button -->
<form class="form-inline my-2 my-lg-0"  action="cars.php" method="POST">
  <input class="form-control mr-sm-2" type="text" name="search" placeholder="Search" aria-label="Search">
  <button class="btn btn-outline-success my-2 my-sm-0" type="submit" name="submit-search">Search</button>
</form>


<!-- Saved Searches -->
<?php
if (isset($_POST['submit-search']) and ($_POST['search'] != "" )) {
                      $queryE = 'SELECT content FROM savedsearches WHERE idUsers="$id"';
                      $id = $_SESSION['id'];
                      $search = $_POST['search'];
                      $queryB = "INSERT INTO savedsearches (content,idUsers) VALUES ('$search', '$id')";
                      mysqli_query($conn, $queryB);
                      }
                      ?>
                  </form>
                  <form class="past_search" name="pastform" method="POST" >
                    <?php
                      $id = $_SESSION['id'];
                      $search = "SELECT * FROM savedsearches WHERE idUsers = '$id' ORDER BY idSaves DESC LIMIT 5 ";
                      $saved = mysqli_query($conn, $search);
                      $sResults = mysqli_num_rows($saved);
                      while ($row = mysqli_fetch_assoc($saved)) {
                      echo "<button id='past_searchBtn' value=".$row['content']." type='submit' name='past_searchBtn' >".$row['content']."</button>"
                    ;}


  ?>


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
                  <p> Date: ".$row['year']." </p>
                </div>
              </div>
              <div class='row'>
                <div class='col-md-6'>
                  <p> Colour: ".$row['colour']." </p>
                  </div>
                  <div class='col-md-6'>
                  <p> Engine Size: ".$row['engine']." </p>
                </div>
              </div>
              <button class='btn btn-outline-success my-2 my-sm-0' type='submit' name=''>Favourite</button>
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
    $sql = "SELECT * FROM cars WHERE make LIKE '%$search%' OR model LIKE '%$search%' OR colour LIKE '%$search%'
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
                  <p> Date: ".$row['year']." </p>
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
          </div>
        </div>
      </div>
    </div>
  </div>";
      }
    }

    //Saved Searches Links
    else if (isset($_POST['past_searchBtn'])) {
    $oldSearches = mysqli_real_escape_string ($conn, $_POST['past_searchBtn']);
    $query = "SELECT * FROM cars WHERE make LIKE '%$oldSearches%' OR  model LIKE '%$oldSearches%' OR colour LIKE '%$oldSearches%' OR engine LIKE '%$oldSearches%' OR year LIKE '%$oldSearches%'";
    $results = mysqli_query($conn, $query);
    $queryResults = mysqli_num_rows($results);
    while ($row = mysqli_fetch_assoc($results)) {
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
                <p> Date: ".$row['year']." </p>
              </div>
            </div>
            <div class='row'>
              <div class='col-md-6'>
                <p> Colour: ".$row['colour']." </p>
                </div>
                <div class='col-md-6'>
                <p> Engine Size: ".$row['engine']." </p>
              </div>
            </div>
            <button class='btn btn-outline-success my-2 my-sm-0' type='submit' name=''>Favourite</button>
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

 <?php
 //if a user is not signed it, they will be unable to access this page
 if(!isset($_SESSION['id'])){
 header("location:index.php");
 }
 ?>

</body>
</html>
