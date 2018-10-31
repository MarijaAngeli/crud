<?php
include 'db.php';

if (isset($_SESSION['username'])) : ?>
    	<p>Welcome <strong><?php echo $_SESSION['username']; ?></strong></p>
    <?php endif
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
    <!-- Latest compiled and minified CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
	<title>Task</title>
</head>
<body>
	<br>
	<div class="container">
		<div class="row">
	      <header class="header clearfix">
	        <nav>
	          <ul class="nav nav-pills float-right">
	            <li class="nav-item">
	              <a class="btn btn-info btn-xs nav-link" href="signup.php">Sign Up </a>
	            </li>
	            <li class="nav-item">
	              <a class="btn btn-info btn-xs nav-link" href="login.php">Log In</a>
	            </li>
	          </ul>
	          			<?php
        function fibonaci($index){
            $x=0;
            $y=1;
            $ar = array(1);
        
            for ($i=1; $i<$index ; $i++) {
                $t=$x+$y;
                $x=$y;
                $y=$t;
                // echo $t . "<br>";
                array_push($ar,$t);
            }
        print_r($ar);
    }
    fibonaci(10);
    echo "<br>";
    function fibonacci($index)
    {
        $x = 0;
        $y = 1;
        $n = array();
        for($i = 0; $i < $index; $i++)
        {
            $z = $x + $y;
            $x = $y;
            $y = $z;
            array_push($n, $z);
        }
        print_r($n);
    }

    print_r(fibonacci(10));
?>
	        </nav>
	      </header>
      <br/>
	</div>
</div>
</body>
</html>


