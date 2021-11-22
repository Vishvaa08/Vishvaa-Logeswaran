<?php
// Start the session
session_start();

include 'header.php';
?>
<div <div class="col-md-8">
  <h4 id='history' class='text-center' style="margin-top:10px;">History</h4>
  <hr style="margin-top:0px;">
  <div class="info">
    <?php
    include 'config.php';
    $packageIdArray = array();

    if (isset($_SESSION['email'])) {
      // get all package id
      $historySQL = "SELECT packageId FROM booking WHERE email='{$_SESSION['email']}';";
      $query = $con->query($historySQL);

      $index = 0;
      while ($row = $query->fetch_assoc()) {
        $packageIdArray[$index] = $row['packageId'];
        $index++;
      }

      // get packages
      $historySQL = 'id IN(';
      for ($i = 0; $i < sizeof($packageIdArray); $i++)
      $historySQL .= $packageIdArray[$i] . ',';

      // remove comma
      $size = strlen($historySQL);
      if (substr($historySQL, $size-1, 1) == ',')
      $historySQL = substr($historySQL, 0, $size-1);
      $historySQL .= ')';

      $result=$con->query("SELECT * FROM menu WHERE $historySQL");

      // make sure the result contains row(s)
      if ($result != false && $result->num_rows > 0) {
        while($row=$result->fetch_assoc()) {
          ?>
          <div class="image">
            <img style="height:170px;" src="<?= $row['image']; ?>">
          </div>
          <div class="destination">
            <h6 class="text-light bg-info text-center rounded p-1"><?= $row['movies']; ?></h6>
          </div>
          <p class="details">
            <b>
              Rating: <?= number_format((double)$row['rating'],1,'.',''); ?> Star/s &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
              Total Time: <?= $row['total']; ?> &nbsp&nbsp&nbsp<br><br>
              Movie Categories: <?= $row['categories']; ?> &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
              Price: RM<?= $row['price']; ?>.00 &nbsp&nbsp&nbsp
            </b>
          </p>
          <div class="under">
          </div>
          <?php
        }
      }
      else {
        // show empty
        echo "<p class='empty' style='position: absolute; left: 50%; top: 800%; transform: translate(-50%, -50%);'><b>Empty</b></p>";
      }

      // close connection
      $con->close();
    }
    ?>
  </div>
</div>