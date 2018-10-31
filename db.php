<?php

$username = "";

$errors = array();
$db = mysqli_connect('localhost', 'root', '', 'test');

// Check connection
if (mysqli_connect_errno()) {
       echo "Failed to connect to MySQL: " . mysqli_connect_error();
       echo "<br>";
}

// REGISTER USER
if (isset($_POST['reg_user'])) {
  // receive all input values from the form
  $username = mysqli_real_escape_string($db, $_POST['username']);
  $password = mysqli_real_escape_string($db, $_POST['password']);

  // form validation: ensure that the form is correctly filled ...
  // by adding (array_push()) corresponding error unto $errors array
  if (empty($username)) { array_push($errors, "Username is required"); }
  if (preg_replace('/[^a-zA-Z0-9)]/', '', $username) != $username){ array_push($errors, "You can use only letters, numbers");}
  if (empty($password)) { array_push($errors, "Password is required"); }
  elseif(strlen($password)<8){ array_push($errors, "Password must have minumum 8 char");}

 // first check the database to make sure 
  // a user does not already exist with the same username
  $user_check_query = "SELECT * FROM users WHERE username='$username'  LIMIT 1";
  $result = mysqli_query($db, $user_check_query);
  //Fetch a result row as an associative array
  $user = mysqli_fetch_assoc($result);
  
  if ($user) { // if user exists
    if ($user['username'] === $username) {
      array_push($errors, "Username already exists");
    }
  }
  // Finally, register user if there are no errors in the form
  if (count($errors) == 0) {
    $password = password_hash($password, PASSWORD_BCRYPT);//encrypt the password before saving in the database

    $query = "INSERT INTO users (username, password) 
          VALUES('$username', '$password')";
    mysqli_query($db, $query);
    $_SESSION['username'] = $username;
    $_SESSION['success'] = "You are now logged in";
    header('location: person.php');
  }
}
// LOGIN USER
if (isset($_POST['login_user'])) {
  $username = mysqli_real_escape_string($db, $_POST['username']);
  $password = mysqli_real_escape_string($db, $_POST['password']);

  if (empty($username)) {
    array_push($errors, "Username is required");
  }else {
  	if (empty($password)) {
    	array_push($errors, "Password is required");
  	}
  }

  if (count($errors) == 0) {
    $query = "SELECT * FROM users WHERE username='$username'";
    $result = mysqli_query($db, $query);
   	if (mysqli_num_rows($result) == 1) {
   		$row = mysqli_fetch_assoc($result);
   		$password_encrypted = $row['password'];
      //Verifies that a password matches a hash
   		if (password_verify($password, $password_encrypted)) {
    	$_SESSION['username'] = $username;
        $_SESSION['success'] = "You are now logged in";
        header('location: person.php'); 
   		}else {
      		array_push($errors, "Wrong password!");
    	}
   	} else {
   		array_push($errors, "Wrong username!");
   	}
  }
}
?>