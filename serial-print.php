<?php

if(!isset($_SERVER['HTTPS']) || $_SERVER['HTTPS'] == ""){
    $redirect = "https://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
    header("Location: $redirect");
}

## ESTABLISH  DATABASE CONNECTION ##
$dbcnx = @mysql_connect('localhost','username', 'password');
if (!$dbcnx) {
	echo( '<p>Unable to connect to the database server at this time.</p>');
	exit();
}
if (! @mysql_select_db('databaseName') ) {
	die( '<p>Unable to locate computer database at this time.</p>');
}


$entryID = $_REQUEST['entryID'];
$table_name = "3G_serial_numbers";



?>

<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Print</title>
<link href="styles.css" rel="stylesheet" type="text/css">

</head>

<body onLoad="window.print();">

<div class="viewEditBox">
  <?php
$query1 = "select * from $table_name WHERE id = $entryID";
$result1=@mysql_query($query1);
while ($row = @mysql_fetch_array($result1)) {
	
	$serial_number = "{$row['serial_number']}";
	$serial_number_2 = "{$row['serial_number_2']}";
	$serial_number_3 = "{$row['serial_number_3']}";
	$model = "{$row['model']}";
	$dealer_name = "{$row['dealer_name']}";
	$po_number = "{$row['po_number']}";
	$customer_name = "{$row['customer_name']}";
	$customer_address = "{$row['customer_address']}";
	$customer_city = "{$row['customer_city']}";
	$customer_state = "{$row['customer_state']}";
	$customer_zip = "{$row['customer_zip']}";
	$customer_email = "{$row['customer_email']}";
	$customer_phone = "{$row['customer_phone']}";
	$spiff_paid = "{$row['spiff_paid']}";
	$spiff_date = "{$row['spiff_date']}";
	$spiff_check_num = "{$row['spiff_check_num']}";
	$spiff_amount = "{$row['spiff_amount']}";
	$salesperson_id = "{$row['salesperson_id']}";
	$warranty_status = "{$row['warranty_status']}";
	$environment = "{$row['environment']}";
	$sold_date_dealer = "{$row['sold_date_dealer']}";
	$sold_date_dealer = date("m/d/y",strtotime($sold_date_dealer));
	$sold_date_customer = "{$row['sold_date_customer']}";
	$sold_date_customer = date("m/d/y",strtotime($sold_date_customer));	
	//$diagnosis = "{$row['diagnosis']}";
	//$solution = "{$row['solution']}";
	//$labor_claim_paid = "{$row['labor_claim_paid']}";
	//$parts_sent_out = "{$row['parts_sent_out']}";
	$diagnosis = stripslashes($row['diagnosis']);
	$solution = stripslashes($row['solution']);
	$labor_claim_paid = stripslashes($row['labor_claim_paid']);
	$parts_sent_out = stripslashes($row['parts_sent_out']);

	
}
?>
  <table width="100%" border="0" cellspacing="3" cellpadding="2">
    <tr>
      <td align="left" valign="top" nowrap="nowrap"><p><a href="/serial/"><img src="/images/logo_home.png" height="50" /></a></p>
      <p>&nbsp;</p></td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top" nowrap="nowrap"><h1><strong>Serial Number:</strong></h1></td>
      <td align="left" valign="top"><h1><?php echo $serial_number."-".$serial_number_2."-".$serial_number_3;?></h1></td>
    </tr>
    <tr>
      <td align="left" valign="top" nowrap="nowrap"><strong>Model:</strong></td>
      <td align="left" valign="top"><?php echo $model;?></td>
    </tr>
    <tr>
      <td align="left" valign="top" nowrap="nowrap"><strong>Environment:</strong></td>
      <td align="left" valign="top"><?php echo $environment;?></td>
    </tr>
    <tr>
      <td align="left" valign="top" nowrap="nowrap"><strong>Dealer Name:</strong></td>
      <td align="left" valign="top"><?php echo $dealer_name;?></td>
    </tr>
    <tr>
      <td align="left" valign="top" nowrap="nowrap"><strong>PO Number:</strong></td>
      <td align="left" valign="top"><?php echo $po_number;?></td>
    </tr>
    <tr>
      <td align="left" valign="top" nowrap="nowrap"><strong>Sold to Dealer Date:</strong></td>
      <td align="left" valign="top"><?php echo $sold_date_dealer;?></td>
    </tr>
    <tr>
      <td align="left" valign="top" nowrap="nowrap"><strong>Sold to Customer Date</strong></td>
      <td align="left" valign="top"><?php echo $sold_date_customer;?></td>
    </tr>
    <tr>
      <td align="left" valign="top" nowrap="nowrap"><strong>Customer Info:</strong></td>
      <td align="left" valign="top"><?php echo $customer_name;?>
        <?php if ($customer_address !== "") {echo"<br>";}?>
        <?php echo $customer_address;?>
        <?php if ($customer_city !== "") {echo"<br>";}?>
        <?php echo $customer_city;?>
        <?php if ($customer_city !== "") {echo", ";}?>
        <?php echo $customer_state;?> <?php echo $customer_zip;?>
        <?php if ($customer_email !== "") {echo"<br>";}?>
        <a href="mailto:<?php echo $customer_email;?>"><?php echo $customer_email;?></a>
        <?php if ($customer_phone !== "") {echo"<br>";}?>
        <?php echo $customer_phone;?></td>
    </tr>
    <tr>
      <td align="left" valign="top" nowrap="nowrap"><strong>Warranty Status:</strong></td>
      <td align="left" valign="top"><?php echo $warranty_status; ?></td>
    </tr>
    <tr>
      <td align="left" valign="top" nowrap="nowrap"><strong>Spiff Paid?</strong></td>
      <td align="left" valign="top"><?php echo $spiff_paid; ?></td>
    </tr>
    <tr>
      <td align="left" valign="top" nowrap="nowrap"><strong>Spiff Date Paid:</strong></td>
      <td align="left" valign="top"><?php echo $spiff_date; ?></td>
    </tr>
    <tr>
      <td align="left" valign="top" nowrap="nowrap"><strong>Spiff Check # : </strong></td>
      <td align="left" valign="top"><?php echo $spiff_check_num; ?></td>
    </tr>
    <tr>
      <td align="left" valign="top" nowrap="nowrap"><strong>Spiff Amount:</strong></td>
      <td align="left" valign="top"><?php echo $spiff_amount; ?></td>
    </tr>
    <tr>
      <td align="left" valign="top" nowrap="nowrap"><strong>Spiff Salesperson:</strong></td>
      <td align="left" valign="top"><?php
				$query2 = "SELECT * FROM 3G_serial_numbers_salesPersons WHERE salesperson_id='$salesperson_id' ";
				$results2 = mysql_query($query2);				
				while($row2 = mysql_fetch_array($results2)) {
					$salesID = $row2['salesperson_id'];
					$fname = $row2['fname'];
					$lname = $row2['lname'];
				    echo $fname.' '.$lname;
				}
				
                
       // echo $salesperson_id; ?></td>
    </tr>
    <tr>
      <td align="left" valign="top" nowrap="nowrap"><strong>Diagnosis:</strong></td>
      <td align="left" valign="top"><?php echo $diagnosis; ?></td>
    </tr>
    <tr>
      <td align="left" valign="top" nowrap="nowrap"><strong>Solution:</strong></td>
      <td align="left" valign="top"><?php echo $solution; ?></td>
    </tr>
    <tr>
      <td align="left" valign="top" nowrap="nowrap"><strong>Labor Claim Paid:</strong></td>
      <td align="left" valign="top"><?php echo $labor_claim_paid; ?></td>
    </tr>
    <tr>
      <td align="left" valign="top" nowrap="nowrap"><strong>Parts Sent Out:</strong></td>
      <td align="left" valign="top"><?php echo $parts_sent_out; ?></td>
    </tr>
  </table>
</div>

</body>
</html>