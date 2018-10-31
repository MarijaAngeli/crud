<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
<?php
require_once "db.php";
    $q = intval($_GET['q']);
    $sql="SELECT * FROM person WHERE id = '".$q."'";
    $result = mysqli_query($db,$sql);
    if (!$result) {
    printf("Error: %s\n", mysqli_error($db));
    exit();
}
    echo "<table>
<tr>
<th>Firstname</th>
<th>Lastname</th>
<th>Gender</th>
<th>Date of Birth</th>
</tr>";
while($row = mysqli_fetch_array($result)) {
    echo "<tr>";
    echo "<td>" . $row['firstName'] . "</td>";
    echo "<td>" . $row['lastName'] . "</td>";
    echo "<td>" . $row['gender'] . "</td>";
    echo "<td>" . $row['dateOfBirth'] . "</td>";
    echo "</tr>";
}
echo "</table>";
?>
</body>
</html>
