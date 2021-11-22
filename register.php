<?php include 'header.php';?>

<div class="register" style='position: absolute; left: 50%; top: 55%; transform: translate(-50%, -50%);'>
  <h2>Registration</h2><br>

  <form action="register.php" method = "post" class="contact_form">
    <p style="color:black;"><b>ID:</b> &nbsp<input style="background-color: white; margin-left:110px;" type="number" name="id" min="100000" max="999999" required placeholder="ID">
      <span class="error">*</p>
        <p style="color:black;"><b>First Name:</b> <input style="background-color: white; margin-left:50px" type="text" name="first_name" required  onkeypress="return (event.charCode > 64 && event.charCode < 91) || (event.charCode > 96 && event.charCode < 123) || (event.charCode==32)" placeholder="First Name">
          <span class="error">*</span></p>
          <p style="color:black;"><b>Last Name:</b> <input style="background-color: white; margin-left:50px" type="text" name="last_name" required  onkeypress="return (event.charCode > 64 && event.charCode < 91) || (event.charCode > 96 && event.charCode < 123) || (event.charCode==32)" placeholder="Last Name">
            <span class="error">*</span></p>
            <p style="color:black;"><b>Phone No. :</b> &nbsp<input style="background-color: white; margin-left:41px;" type="number" name="phone" min="100000000" max="999999999" required placeholder="Phone No.">
              <span class="error">*</span></p>
              <p style="color:black;"><b>Email:</b> &nbsp<input style="background-color: white; margin-left:83px;" type="email" required name="email" placeholder="Email">
                <span class="error">*</span></p>
                <p style="color:black;"><b>Password:</b> <input style="background-color: white; margin-left:58px;" type="password" name="password"  pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" required placeholder="Password">
                  <span class="error">*</span></p>
                  <br><p class="error">* required field</p><br>
                  <input class="btn btn-dark" type="submit" name="submitted" value="Register"><br><br>
                </form>
              </div>

              <?php

              if (isset($_POST['submitted']) == 'true') {

                $id=$_POST['id'];
                $first_name=$_POST['first_name'];
                $last_name=$_POST['last_name'];
                $phone=$_POST['phone'];
                $email=$_POST['email'];
                $password=$_POST['password'];
                //hash password
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);

                $link = mysqli_connect("localhost", "root", "", "data");

                //Check connection
                if($link === false) {
                  die("Error: Could not connect. " . mysqli_connect_error());
                }

                //Escape user input for security
                $id = mysqli_real_escape_string($link, $_REQUEST['id']);
                $first_name = mysqli_real_escape_string($link, $_REQUEST['first_name']);
                $last_name = mysqli_real_escape_string($link, $_REQUEST['last_name']);
                $phone = mysqli_real_escape_string($link, $_REQUEST['phone']);
                $email = mysqli_real_escape_string($link, $_REQUEST['email']);
                $password = mysqli_real_escape_string($link, $_REQUEST['password']);

                //Attempt insert query execution
                $sql = "INSERT INTO user (id, first_name, last_name, phone, email, password) VALUES ('$id', '$first_name', '$last_name', '$phone', '$email', '$hashed_password')";
                if(mysqli_query($link, $sql)) {
                  echo "<script type='text/javascript'>
                  alert('Registration is successful');
                  </script>";
                } else{
                  echo "<script type='text/javascript'>
                  alert('ERROR: Registration is unsuccessful!');
                  </script>";
                }

                //Close connection
                mysqli_close($link);
              }
              ?>