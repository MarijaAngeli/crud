<?php
// Include config file
require_once "db.php";
 
// Define variables 
    $firstName = "";
    $lastName = "";
    $gender = "";
    $dateOfBirth = "";

    $firstNameErr = "";
    $lastNameErr = "";
    $genderErr = "";
    $dateOfBirthErr = "";
 
// Processing form data when form is submitted
if(isset($_POST["id"]) && !empty($_POST["id"])){
    // Get hidden input value
    $id = $_POST["id"];
    
    // Validate first name
    $input_firstName = trim($_POST["firstName"]);
    if(empty($input_firstName)){
        $firstNameErr = "Please enter a name.";
    } elseif(!filter_var($input_firstName, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $firstNameErr = "Please enter a valid name.";
    } else{
        $firstName = $input_firstName;
    }
    
    // Validate last name
    $input_lastName = trim($_POST["lastName"]);
    if(empty($input_lastName)){
        $lastNameErr = "Please enter a name.";
    } elseif(!filter_var($input_lastName, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $lastNameErr = "Please enter a valid name.";
    } else{
        $lastName = $input_lastName;
    }
    
    // Validate gender
    $input_gender = trim($_POST["gender"]);
    if(empty($input_gender)){
        $genderErr = "Please select the gender.";     
    } else{
        $gender = $input_gender;
     }

     // Validate date of birth
    $input_dateOfBirth = trim($_POST["dateOfBirth"]);
    if(empty($input_dateOfBirth)){
        $dateOfBirthErr = "Please select date of birth.";   
    } else{
        strtotime($dateOfBirth);
        $dateOfBirth = $input_dateOfBirth;
        //strtotime($dateOfBirth, '%m-%d-%y');
        echo $dateOfBirth; 
        //echo $dateOfBirthup; 
     }
    // echo $firstNameErr;
    // echo $lastNameErr;
    // echo $genderErr;
    // echo $dateOfBirth;
    // Check input errors before inserting in database
    if(empty($firstNameErr) && empty($lastNameErr) && empty($genderErr) && empty($dateOfBirthErr)){
        // Prepare an update statement
        $sql = "UPDATE person SET firstName=?, lastName=?, gender=?, dateOfBirth=? WHERE id=?";
         
        if($stmt = mysqli_prepare($db, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ssssi", $param_firstName, $param_lastName, $param_gender,$param_dateOfBirth, $param_id);
            
            // Set parameters
            $param_firstName = $firstName;
            $param_lastName = $lastName;
            $param_gender = $gender;
            $param_dateOfBirth = $dateOfBirth;
            $param_id = $id;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Records updated successfully. Redirect to landing page
                header("location: person.php");
                exit();
            } else{
                echo "Something went wrong. Please try again later.";
            }
        }
         
        // Close statement
        mysqli_stmt_close($stmt);
    }
    
    // Close connection
    mysqli_close($db);
} else{
    // Check existence of id parameter before processing further
    if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
        // Get URL parameter
        $id =  trim($_GET["id"]);
        
        // Prepare a select statement
        $sql = "SELECT * FROM person WHERE id = ?";
        if($stmt = mysqli_prepare($db, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "i", $param_id);
            
            // Set parameters
            $param_id = $id;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                $result = mysqli_stmt_get_result($stmt);
    
                if(mysqli_num_rows($result) == 1){
                    
                    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                    // Retrieve individual field value
                    $firstName = $row["firstName"];
                    $lastName = $row["lastName"];
                    $gender = $row["gender"];
                    $dateOfBirth = $row["dateOfBirth"];
                } else{
                    // URL doesn't contain valid id. Redirect to error page
                    header("location: error.php");
                    exit();
                }
                
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
        
        // Close statement
        mysqli_stmt_close($stmt);
        
        // Close connection
        mysqli_close($db);
    }  else{
        // URL doesn't contain id parameter. Redirect to error page
        header("location: error.php");
        exit();
    }
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Record</title>
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
                        <h2>Update Record</h2>
                    </div>
                    <p>Please edit the form.</p>
                    <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
                        <div class="form-group <?php echo (!empty($firstNameErr)) ? 'has-error' : ''; ?>">
                            <label>Name</label>
                            <input type="text" name="firstName" class="form-control" value="<?php echo $firstName; ?>">
                            <span class="help-block"><?php echo $firstNameErr;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty(lastNameErr)) ? 'has-error' : ''; ?>">
                            <label>Last Name</label>
                            <textarea name="lastName" class="form-control"><?php echo $lastName; ?></textarea>
                            <span class="help-block"><?php echo $lastNameErr;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($genderErr)) ? 'has-error' : ''; ?>">
                            <label>Gender</label>

                           <?php if($gender == "Male") {?>
                            <input type="radio" name="gender" class="form-control" value="Male"checked>Male</input></br> 
                            <input type="radio" name="gender" class="form-control" value="Female">Female</input></br> 
                            <?php }else { ?>
                                <input type="radio" name="gender" class="form-control" value="Male">Male</input></br> 
                                <input type="radio" name="gender" class="form-control" value="Female" checked>Female</input></br>  
                            <?php } ?>
                            
                            <span class="help-block"><?php echo $genderErr;?></span>
                        </div>
                        <div class="form-group">
                          <label>Date of Birth</label>
                          <input type="date" name="dateOfBirth" value="<?php echo $dateOfBirth; ?>">
                        </div>
                        <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="index.php" class="btn btn-default">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>