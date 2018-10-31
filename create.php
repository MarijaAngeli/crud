
<?php
// Include config file
require_once "db.php";

$firstName = $lastName = $gender = $dateOfBirth = "";

if (isset($_POST['create_person'])) {
  // receive all input values from the form
  $firstName = mysqli_real_escape_string($db, $_POST['firstName']);
  $lastName = mysqli_real_escape_string($db, $_POST['lastName']);
  $gender = mysqli_real_escape_string($db, $_POST['gender']);
  $dateOfBirth = mysqli_real_escape_string($db, $_POST['dateOfBirth']);

  //Check for errors
  if (empty($firstName)) { array_push($errors, "First Name is required"); }
  if (preg_replace('/[^a-zA-Z)]/', '', $firstName) != $firstName){ array_push($errors, "You can use only letters");}
  if (empty($lastName)) { array_push($errors, "Last Name is required"); }
  if (preg_replace('/[^a-zA-Z)]/', '', $lastName) != $lastName){ array_push($errors, "You can use only letters");}
  if (empty($gender)) { array_push($errors, "Please select gender"); }
   if(empty($dateOfBirth)){ array_push($errors, "Please select date of birth"); }
  strtotime($dateOfBirth,'%m-%d-%y');
   
//insert data in database
   $sql = "INSERT INTO person (firstName, lastName, gender, dateOfBirth) VALUES ('$firstName', '$lastName', '$gender', '$dateOfBirth')";

        mysqli_query($db, $sql);
        if(mysqli_query($db, $sql)){
      echo "Records added successfully.";
      header("location: person.php");
    } else{
      echo "ERROR: Could not able to execute $sql. " . mysqli_error($db);
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Record</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        .wrapper{
            width: 500px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header">
                        <h2>Create Record</h2>
                    </div>
                    <p>Please fill this form and submit to add person record to the database.</p>
                    <form action="create.php" method="post">
                        <div class="form-group">
                            <label>First Name</label>
                            <input type="text" name="firstName" class="form-control" value="<?php echo $firstName; ?>">   
                        </div>
                        <div class="form-group">
                            <label>Last Name</label>
                            <input type="text" name="lastName" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Gender</label>
                            <input type="radio" name="gender" value="Male">Male</input>
                            <input type="radio" name="gender" value="Female">Female</input><br>
                        </div>
                        <div class="form-group">
                          <label>Date of Birth</label>
                          <input type="date" name="dateOfBirth">
                        </div>

                        <input type="submit" class="btn btn-primary" name="create_person" value="Submit">

                        <a href="index.php" class="btn btn-default">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>



