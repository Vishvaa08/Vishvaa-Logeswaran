<?php
// Start the session
session_start();

if (!(isset($_SESSION['email']) && isset($_SESSION['password']))) {
  echo "<script>alert('Session Email or password is not properly set up.');window.location.replace('index.php');</script>";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- Latest compiled and minified CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

  <!-- jQuery library -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

  <!-- Popper JS -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>

  <!-- Latest compiled JavaScript -->
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="\style.min.css" type="text/css">
  <title>Movie Ticket Booking</title>
</head>

<body>
  <header class="header">
    <div class="header_logo">
      <a href="index.php"><img src="\img\movie_ticket_logo.png" style="width:65px; height:65px;" alt="Logo"></a>
    </div>
    <div class="header__nav">

      <span class="line"></span>
      <button class="header__nav__button">
        <a href="history.php"><img src="\img\history.svg" style="width:24px; height:24px;" alt="History" /></a>
      </button>
      <span class="line"></span>
    </div>
  </header>

  <?php
  $email = $_SESSION['email'];
  $password = $_SESSION['password'];

  $con = mysqli_connect("localhost","root","","data");
  $userSQL = "SELECT * FROM user WHERE email='$email';";
  $result = mysqli_query($con, $userSQL);
  $row = mysqli_fetch_row($result);
  $userDetails = array('id' => $row[0], 'firstName' => $row[1], 'lastName' => $row[2], 'phoneNumber' => $row[3], 'email' => $row[4], 'password' => $row[5]);
  $packageId = '';

  if (password_verify($password, $userDetails['password'])) {
    // if package existed
    if (isset($_GET['action']) && isset($_GET['id'])) {
      $action = $_GET['action'];
      $packageId = $_GET['id'];

      // 1: book
      if ($action == 1) {
        // booking insertion here
        $insertSQL = "INSERT INTO booking VALUES(null,$packageId,'{$userDetails['email']}');";
        $insertion = mysqli_query($con, $insertSQL);

        if (mysqli_affected_rows($con) > 0) {

          $query = "SELECT * FROM menu WHERE id=" . $packageId;
          $result = mysqli_query($con, $query);
          $row = mysqli_fetch_row($result);

          // successful insertion, 1 row affected
          ?>

          <div class="col-lg-12">
            <h3 id="booking" class="text-center">Booking</h3>
            <hr>
            <div class="row" id="result">

              <div class="col-md-3 mb-2" style="position: absolute; left: 50%; top: 480%; transform: translate(-50%, -50%);">
                <div class="card border-secondary">
                  <img style="height:200px;" src="<?php echo $row[6] ?>">
                  <div class="card-img-top">
                    <h6 style="margin-top:15px;" class="text-light bg-info text-center rounded p-1"><?php echo $row[1] ?></h6>
                  </div>
                  <div class="card-body">
                    <h4 style="color:blue;">Rating: <?php echo $row[2] ?> Star/s</h4>
                    <p>
                      Total Time: <?php echo $row[3] ?><br>
                      Movie Intereval: <?php echo $row[4] ?><br>
                      Price: RM <?php echo $row[5] ?>.00<br>
                    </p>
                    <a href="booking.php?action=0&id=<?php echo $row[0] ?>" class="btn btn-dark btn-primary btn-sm btn-book">Cancel Booking</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <?php
    }
    else {
      // duplicate insertion, handle here
      echo "<script>alert('Duplicated booking! Please select another one.');window.location.replace('index.php');</script>";
    }

  }
  // 0: clear
  else if ($action == 0) {
    // try to cancel the booking if packageId and user login present
    $removeSQL = "DELETE FROM booking WHERE packageId=$packageId AND email='{$userDetails['email']}';";
    mysqli_query($con, $removeSQL);

    echo "<h3 id='booking' class='text-center'>Booking</h3>";
    echo "<hr>";
    echo "<p class='empty' style='position: absolute; left: 50%; top: 50%; transform: translate(-50%, -50%);'><b>Empty</b></p>";
  }
  else {
    // no booking
    echo "<h3 id='booking' class='text-center'>Booking</h3>";
    echo "<hr>";
    echo "<p class='empty' style='position: absolute; left: 50%; top: 50%; transform: translate(-50%, -50%);'><b>Empty</b></p>";
  }
}
else {
  // no booking
  echo "<h3 id='booking' class='text-center'>Booking</h3>";
  echo "<hr>";
  echo "<p class='empty' style='position: absolute; left: 50%; top: 50%; transform: translate(-50%, -50%);'><b>Empty</b></p>";
}
}
else {
  // invalid login, should redirect to index.php
  echo "<script>alert('Incorrect email or password.');window.location.replace('index.php');</script>";
}

// close database connection
mysqli_close($con);
?>
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>