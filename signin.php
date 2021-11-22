<?php
session_start();

if (isset($_POST['submitted']) == 'true') {

  $email=$_POST['email'];
  $password=$_POST['password'];

  if (isset($_POST['password']) && $_POST['password'] != '')
    $_SESSION['password'] = $_POST['password'];

  extract($_POST);
  $link = mysqli_connect("localhost", "root", "", "data");
  //Check connection
  if($link === false) {
    die("Error: Could not connect. " . mysqli_connect_error());
  }
  $sql=mysqli_query($link,"SELECT * FROM user where email='$email'");
  $row  = mysqli_fetch_array($sql);
  if(is_array($row))
  {

    $_SESSION['id'] = $row['id'];
    $_SESSION['firstname']=$row['first_name'];
    $_SESSION['lastname']=$row['last_name'];
    $_SESSION['phone']=$row['phone'];
    $_SESSION['email']=$row['email'];

    if (password_verify($password, $row['password'])) {
      echo "<script type='text/javascript'>
      alert('Log in successfully');
      window.location='index.php';
      </script>";
    }
    else {
      echo "<script type='text/javascript'>
      alert('Invalid Email/Password');
      window.location='signin.php';
      </script>";
    }
  }

  else
  {
    echo "<script type='text/javascript'>
    alert('Invalid Email/Password');
    window.location='signin.php';
    </script>";
  }

  // close database connection
  mysqli_close($link);
}

?>
<?php include 'header.php';?>

<div class="signin" style='position: absolute; left: 50%; top: 50%; transform: translate(-50%, -50%);'>
<h2>Sign In</h2><br>

            <form action="signin.php" method = "post" class="contact_form">
              <p style="color:black;"><b>Email:</b> &nbsp<input style="background-color: white; color:black; margin-left:45px;" type="email" required name="email" placeholder="Email">
                <span class="error">*</span></p>
                <p style="color:black;"><b>Password:</b> <input style="background-color: white; color:black; margin-left:20px;" type="password" name="password"  pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" required placeholder="Password">
                  <span class="error">*</span></p>
                  <br><p class="error">* required field</p><br>
                  <input class="btn btn-dark" type="submit" name="submitted" value="Log In">
                </form>
</div>