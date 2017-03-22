<?php


 $dbcnx = @mysqli_connect('localhost', 'root', 'password'); 
 // $dbcnx = @mysqli_connect('localhost','threeGeeXcart', 'd1oeeTkRnccM');
if (!$dbcnx) {
	echo( '<p>Unable to connect to the' .
		'database server at this time.</p>');
	exit();
	}

 if (! @mysqli_select_db('databaseName') ) {
	die( '<p>Unable to locate computer database at this time.</p>');
	}



$query1 = "select * from 3G_serial_numbers_salesPersons";
//$query2 = "select * from 3G_serial_numbers_salesPersons WHERE salesperson_id='$salesperson_id' ";
$results = @mysqli_query($dbcnx, $query1);

echo '<select name="salesperson_id">';
while($row = mysqli_fetch_array($results)) {
	$salesID = "{$row['salesperson_id']}";
	$fname = "{$row['fname']}";
	$lname = "{$row['lname']}";

        echo '<option value="' . $salesID . '" selected="selected">'.$fname.' '.$lname.'</option>';
}
echo '</select>';

?>    