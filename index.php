<?php

include('config.php');
authUser('1,2,3');

$mode = $_REQUEST['mode']; //add, edit, delete, search or blank = display
$entryID = $_REQUEST['entryID'];
$table_name = "3G_serial_numbers";
$sortOrder = $_GET['sortOrder'];
$sortType = $_GET['sortType'];

if ($sortOrder == "" && $sortType == "") {
	$sortOrder = "ASC";
	$sortType = "dealer_name";
}

if ($sortOrder == "ASC") {
	$sortOrderArrow = " &darr;";
	//$sortOrder = "DESC";
} else if ($sortOrder == "DESC") {
	$sortOrderArrow = " &uarr;";
	//$sortOrder = "ASC";
}

if ($sortType == "serial_number") {
	$sorter1 = $sortOrderArrow;	
	$sorterClass1 = "style='color:#F6DB5A;'";	
} else if ($sortType == "model") {
	$sorter2 = $sortOrderArrow;	
	$sorterClass2 = "style='color:#F6DB5A;'";	
} else if ($sortType == "dealer_name") {
	$sorter3 = $sortOrderArrow;	
	$sorterClass3 = "style='color:#F6DB5A;'";	
} else if ($sortType == "sold_date_dealer") {
	$sorter4 = $sortOrderArrow;	
	$sorterClass4 = "style='color:#F6DB5A;'";	
} else if ($sortType == "sold_date_customer") {
	$sorter5 = $sortOrderArrow;	
	$sorterClass5 = "style='color:#F6DB5A;'";	
} else if ($sortType == "customer_name") {
	$sorter6 = $sortOrderArrow;	
	$sorterClass6 = "style='color:#F6DB5A;'";	
} else if ($sortType == "warranty_status") {
	$sorter7 = $sortOrderArrow;	
	$sorterClass7 = "style='color:#F6DB5A;'";	
} else if ($sortType == "salesperson") {
	$sorter8 = $sortOrderArrow;	
	$sorterClass8 = "style='color:#F6DB5A;'";	
} else if ($sortType == "spiff_paid") {
	$sorter9 = $sortOrderArrow;	
	$sorterClass9 = "style='color:#F6DB5A;'";	
} else if ($sortType == "spiff_approved_date") {
	$sorter10 = $sortOrderArrow;	
	$sorterClass10 = "style='color:#F6DB5A;'";	
} else if ($sortType == "spiff_date") {
	$sorter11 = $sortOrderArrow;	
	$sorterClass11 = "style='color:#F6DB5A;'";	
} 




if (($mode == "search") || ($mode == "searchS")) {
	$q = $_REQUEST['q'];
	$s1 = $_REQUEST['s1'];
	$s2 = $_REQUEST['s2'];
	$s3 = $_REQUEST['s3'];
	$isSearch = "&mode=search&q=".$q."&s1=".$s1."&s2=".$s2."&s3=".$s3;
	$showAll = '<a href="index.php" class="addButton">&laquo; Back</a>';
} 

if($mode == 'edit' || $mode == 'view') { 
	$sql = "SELECT * FROM $table_name WHERE id='$entryID' ";
	$rs = mysqli_query($dbcnx, $sql);
	$r = mysqli_fetch_array($rs);
	$serial_number = $r['serial_number'];
	$serial_number_2 = $r['serial_number_2'];
	$serial_number_3 = $r['serial_number_3'];
	$model = $r['model'];
	$dealer_name = $r['dealer_name'];
	$po_number = $r['po_number'];
	$sold_date_dealer = $r['sold_date_dealer'];
	$sold_date_customer = $r['sold_date_customer'];
	$customer_name = $r['customer_name'];
	$customer_address = $r['customer_address'];
	$customer_city = $r['customer_city'];
	$customer_state = $r['customer_state'];
	$customer_zip = $r['customer_zip'];
	$customer_email = $r['customer_email'];
	$customer_phone = $r['customer_phone'];
	$warranty_status = $r['warranty_status'];
	$spiff_paid = $r['spiff_paid'];
	$spiff_date = $r['spiff_date'];
	$spiff_approved_date = $r['spiff_approved_date'];
	$spiff_check_num = $r['spiff_check_num'];
	$spiff_amount = $r['spiff_amount'];
	$salesperson_id = $r['salesperson_id'];
	$diagnosis = stripslashes($r['diagnosis']);
	$solution = stripslashes($r['solution']);
	$labor_claim_paid = stripslashes($r['labor_claim_paid']);
	$parts_sent_out = stripslashes($r['parts_sent_out']);
	$environment = $r['environment'];
}

if(isset($_POST['submit']) || $mode == 'delete') {
	if($mode == 'delete') {
		$sql = "DELETE FROM  $table_name WHERE id='$entryID' ";
		$mode = '';
		 if (@mysqli_query($dbcnx, $sql)) {
			$prompt = '<h2 class="prompt">Entry was successfully deleted.</h2><br><meta http-equiv="refresh" content="3;URL=index.php">'; 
		 } else { 
			$prompt = '<p>Error deleting submitted entry: ' . mysqli_error($dbcnx) . '</p>';
		 } 		
	} elseif($mode == 'add') {
		$mode = '';
		
	    $sql = "INSERT INTO $table_name SET 
		serial_number='".$_POST['serial_number']."',
		serial_number_2='".$_POST['serial_number_2']."',
		serial_number_3='".$_POST['serial_number_3']."',
		model='".$_POST['model']."',
		dealer_name='".$_POST['dealer_name']."',
		po_number='".$_POST['po_number']."',
		sold_date_dealer='".$_POST['sold_date_dealer']."',
		sold_date_customer='".$_POST['sold_date_customer']."',
		customer_name='".$_POST['customer_name']."',
		customer_address='".$_POST['customer_address']."',
		customer_city='".$_POST['customer_city']."',
		customer_state='".$_POST['customer_state']."',
		customer_zip='".$_POST['customer_zip']."',
		customer_email='".$_POST['customer_email']."',
		customer_phone='".$_POST['customer_phone']."',
		warranty_status='".$_POST['warranty_status']."',
		spiff_paid='".$_POST['spiff_paid']."',
		spiff_date='".$_POST['spiff_date']."',
		spiff_approved_date='".$_POST['spiff_approved_date']."',
		spiff_check_num='".$_POST['spiff_check_num']."',
		spiff_amount='".$_POST['spiff_amount']."',
		salesperson_id='".$_POST['salesperson_id']."',
		environment='".$_POST['environment']."',
		diagnosis='".addslashes($_POST['diagnosis'])."', 
		solution='".addslashes($_POST['solution'])."', 
		labor_claim_paid='".addslashes($_POST['labor_claim_paid'])."', 
		parts_sent_out='".addslashes($_POST['parts_sent_out'])."'";
  
		 if (@mysqli_query($dbcnx, $sql)) {
		 $entryID = mysqli_insert_id();
			$prompt = '<h2 class="prompt">Your entry has been added.</h2><br><meta http-equiv="refresh" content="0;URL=index.php?mode=view&entryID='.$entryID.'">'; 
		 } else { 
			$prompt = '<p>Error adding submitted entry: ' . mysqli_error($dbcnx) . '</p>';
		 } 
	} elseif ($mode == 'edit') {
		$mode = '';
		$sql = "UPDATE $table_name SET 
        serial_number='{$_POST['serial_number']}', 
        serial_number_2='{$_POST['serial_number_2']}', 
        serial_number_3='{$_POST['serial_number_3']}', 
        model='{$_POST['model']}', 
        dealer_name='{$_POST['dealer_name']}', 		
		 po_number='{$_POST['po_number']}',
        sold_date_dealer='{$_POST['sold_date_dealer']}', 
        sold_date_customer='{$_POST['sold_date_customer']}', 
        customer_name='{$_POST['customer_name']}', 
        customer_address='{$_POST['customer_address']}', 
        customer_city='{$_POST['customer_city']}', 
        customer_state='{$_POST['customer_state']}', 
        customer_zip='{$_POST['customer_zip']}', 
        customer_email='{$_POST['customer_email']}', 
        customer_phone='{$_POST['customer_phone']}', 
        warranty_status='{$_POST['warranty_status']}', 
        spiff_paid='{$_POST['spiff_paid']}', 
        spiff_date='{$_POST['spiff_date']}', 
        spiff_approved_date='{$_POST['spiff_approved_date']}', 
        spiff_check_num='{$_POST['spiff_check_num']}', 
        spiff_amount='{$_POST['spiff_amount']}', 
        salesperson_id='{$_POST['salesperson_id']}', 
		environment='{$_POST['environment']}',
		diagnosis='".addslashes($_POST['diagnosis'])."', 
		solution='".addslashes($_POST['solution'])."', 
		labor_claim_paid='".addslashes($_POST['labor_claim_paid'])."', 
		parts_sent_out='".addslashes($_POST['parts_sent_out'])."'
		  WHERE id='$entryID' ";		
		 if (@mysqli_query($dbcnx, $sql)) {
			$prompt = '<h2 class="prompt">Your entry has been updated.</h2><br><meta http-equiv="refresh" content="3;URL=index.php">'; 
		 } else { 
			$prompt = '<p>Error editing entry: ' . mysqli_error($dbcnx) . '</p>';
		 } 

	} 
	#
}
?>
<html>
<head>
<title>3G Serial Numbers Admin</title>
<meta http-equiv="Content-Type" 
    content="text/html; charset=ISO-8859-1" />
<link href="styles.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.0/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.0/jquery-ui.js"></script>
<link rel="stylesheet" href="/resources/demos/style.css">
<script>
  $(document).ready(function() {
    $("#datepicker").datepicker({
        dateFormat: 'yy-mm-dd'
    });
	$("#datepicker2").datepicker({
        dateFormat: 'yy-mm-dd'
    });
	$("#spiff_date").datepicker({
        dateFormat: 'yy-mm-dd'
    });
	$("#spiff_approved_date").datepicker({
        dateFormat: 'yy-mm-dd'
    });
  });
  
  
  
  </script>
<script type="text/javascript">
    $(document).ready(function(){
        $('#serial_number').keyup(function(){
            if($(this).val().length==$(this)[0].maxLength){
                $('#serial_number_2').focus();
            }
        });
    });
	
	$(document).ready(function(){
        $('#serial_number_2').keyup(function(){
            if($(this).val().length==$(this)[0].maxLength){
                $('#serial_number_3').focus();
            }
        });
    });
</script>
<script type="text/javascript">
    $(document).ready(function(){
        $('#s1').keyup(function(){
            if($(this).val().length==$(this)[0].maxLength){
                $('#s2').focus();
            }
        });
    });
	
	$(document).ready(function(){
        $('#s2').keyup(function(){
            if($(this).val().length==$(this)[0].maxLength){
                $('#s3').focus();
            }
        });
    });
</script>
</head>
<body class="adminbody">
<?php include("hdr.php"); ?>
<br>
<?php if(isset($prompt)) print $prompt?>
<?php if($mode == 'add' || $mode == 'edit') :?>

<div class="viewEditBox"> <a href="index.php?mode=view&entryID=<?php echo $entryID; ?>" class="addButton">Cancel</a><br>
  <br>
  <form action="index.php?mode=<?=$mode?>&entryID=<?=$entryID?>" method="post">
    <table cellpadding="3" cellspacing="3" border="0" width="100%">
      <tr>
        <td colspan="3" nowrap><h1><strong>Serial Number: </strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $serial_number."-".$serial_number_2."-".$serial_number_3;?></h1></td>
      </tr>
      <tr>
        <td colspan="3"><?php switch($mode) {
			case 'add':
				?>
          <h1>Add Entry:</h1>
          <?php
				break;
			case 'edit':
				?>
          <h1>Edit Entry:</h1>
          <?php
				break;			
		}
	?></td>
      </tr>
      
        <tr>
          <td nowrap><strong>Model</strong></td>
          <td>:</td>
          <td><select name="model" id="model">
            <?php

	
$model_array = array(
'' => 'Select One',
'80i' => '80i',
'Lite Runner' => 'Lite Runner',
'Pro Runner' => 'Pro Runner',
'Elite Runner' => 'Elite Runner',
'6 AVT' => '6 AVT',
'5 AVT' => '5 AVT',
'6.0' => '6.0',
'5.0' => '5.0',
'3.0' => '3.0',

);
foreach ($model_array as $val => $display){
   $selected = ($model == $val ? 'selected="selected"' : '');
   print "<option value='$val' $selected>$display</option>\n";
}

?>
          </select></td>
        </tr>
        <td width="1%" nowrap><strong>Serial Number</strong></td>
        <td>:</td>
        <td><input name="serial_number" type="text" id="serial_number"  value="<?php echo $serial_number;?>" size="13" maxlength="12">
          -
          <input name="serial_number_2" type="text" id="serial_number_2"  value="<?php echo $serial_number_2;?>" size="5" maxlength="4">
          -
          <input name="serial_number_3" type="text" id="serial_number_3" value="<?php echo $serial_number_3;?>" size="5" maxlength="3">
          
      
          
          </td>
      </tr>
      <tr>
        <td nowrap>Environment</td>
        <td>:</td>
        <td><select name="environment">
            <?php

	
$environment_array = array(
'' => 'Select One',
'Residential' => 'Residential',
'Commercial' => 'Commercial',
);
foreach ($environment_array as $val => $display){
   $selected = ($environment == $val ? 'selected="selected"' : '');
   print "<option value='$val' $selected>$display</option>\n";
}

?>
          </select></td>
      </tr>
      <tr>
        <td nowrap> Dealer Name</td>
        <td>:</td>
        <td><select name="dealer_name">
            <?php

	
$dealer_array = array(
'' => 'Select One',
'3G Cardio' => '3G Cardio',
'Amazon' => 'Amazon',
'Amazon Prime' => 'Amazon Prime',
'American Home Fitness' => 'American Home Fitness',
'At Home Fitness' => 'At Home Fitness',
'Colorado Home Fitness' => 'Colorado Home Fitness',
'Exercise Equipment Experts' => 'Exercise Equipment Experts',
'Fitness In Motion' => 'Fitness In Motion',
'Fitness Direct' => 'Fitness Direct',
'FoldFlatTreadmill.com' => 'FoldFlatTreadmill.com',
'Gym Source' => 'Gym Source',
'Health and Fitness Ohio' => 'Health and Fitness Ohio',
'Hest Fitness' => 'Hest Fitness',
'JFK Fitness Health' => 'JFK Fitness Health',
'LifeStyle Fitness' => 'LifeStyle Fitness',
'MedVibe' => 'MedVibe',
'OC Body Works' => 'OC Body Works',
'Precor Home Fitness' => 'Precor Home Fitness',
'Premier Fitness Source' => 'Premier Fitness Source',
'Push Pedal Pull' => 'Push Pedal Pull',
'Southeastern Fitness' => 'Southeastern Fitness',
'Sonic Wave Fitness' => 'Sonic Wave Fitness',
'Utah Home Fitness' => 'Utah Home Fitness',
'Vitality Health and Fitness' => 'Vitality Health and Fitness',
);
foreach ($dealer_array as $val => $display){
   $selected = ($dealer_name == $val ? 'selected="selected"' : '');
   print "<option value='$val' $selected>$display</option>\n";
}

?>
          </select></td>
      </tr>
      <tr>
        <td nowrap>PO Number</td>
        <td>:</td>
        <td><input name="po_number" type="text" id="po_number" value="<?php echo $po_number;?>" size="20"></td>
      </tr>
      <tr>
        <td nowrap> Sold to Dealer Date</td>
        <td>:</td>
        <td><input name="sold_date_dealer" type="text" id="datepicker" value="<?php echo $sold_date_dealer;?>"></td>
      </tr>
      <tr>
        <td nowrap> Sold to Customer Date</td>
        <td>:</td>
        <td><input name="sold_date_customer" type="text" id="datepicker2" value="<?php echo $sold_date_customer;?>"></td>
      </tr>
      <tr>
        <td nowrap> Customer Name</td>
        <td>:</td>
        <td><input name="customer_name" type="text" id="customer_name" value="<?php echo $customer_name;?>"></td>
      </tr>
        </tr>
      
      <tr>
        <td nowrap> Customer Address</td>
        <td>:</td>
        <td><input name="customer_address" type="text" id="customer_address" value="<?php echo $customer_address;?>" size="20"></td>
      </tr>
        </tr>
      
      <tr>
        <td nowrap> Customer City/State/Zip</td>
        <td>:</td>
        <td nowrap><input name="customer_city" type="text" id="customer_city" value="<?php echo $customer_city;?>">
          <select name="customer_state">
            <?php
            $customer_state_array = array(
            '' => 'Select One',
            'AL' => 'Alabama',
            'AK' => 'Alaska',
            'AZ' => 'Arizona',
            'AR' => 'Arkansas',
            'CA' => 'California',
            'CO' => 'Colorado',
            'CT' => 'Connecticut',
            'DE' => 'Delaware',
            'DC' => 'Dist of Columbia',
            'FL' => 'Florida',
            'GA' => 'Georgia',
            'HI' => 'Hawaii',
            'ID' => 'Idaho',
            'IL' => 'Illinois',
            'IN' => 'Indiana',
            'IA' => 'Iowa',
            'KS' => 'Kansas',
            'KY' => 'Kentucky',
            'LA' => 'Louisiana',
            'ME' => 'Maine',
            'MD' => 'Maryland',
            'MA' => 'Massachusetts',
            'MI' => 'Michigan',
            'MN' => 'Minnesota',
            'MS' => 'Mississippi',
            'MO' => 'Missouri',
            'MT' => 'Montana',
            'NE' => 'Nebraska',
            'NV' => 'Nevada',
            'NH' => 'New Hampshire',
            'NJ' => 'New Jersey',
            'NM' => 'New Mexico',
            'NY' => 'New York',
            'NC' => 'North Carolina',
            'ND' => 'North Dakota',
            'OH' => 'Ohio',
            'OK' => 'Oklahoma',
            'OR' => 'Oregon',
            'PA' => 'Pennsylvania',
            'RI' => 'Rhode Island',
            'SC' => 'South Carolina',
            'SD' => 'South Dakota',
            'TN' => 'Tennessee',
            'TX' => 'Texas',
            'UT' => 'Utah',
            'VT' => 'Vermont',
            'VA' => 'Virginia',
            'WA' => 'Washington',
            'WV' => 'West Virginia',
            'WI' => 'Wisconsin',
            'WY' => 'Wyoming',	);
            foreach ($customer_state_array as $val => $display){
               $selected = ($customer_state == $val ? 'selected="selected"' : '');
               print "<option value='$val' $selected>$display</option>\n";
            }
            
            ?>
          </select>
          <input name="customer_zip" type="text" id="customer_zip" value="<?php echo $customer_zip;?>" size="6"></td>
      </tr>
        </tr>
      
      <tr>
        <td nowrap> Customer Email</td>
        <td>:</td>
        <td><input name="customer_email" type="text" id="customer_email" value="<?php echo $customer_email;?>"></td>
      </tr>
        </tr>
      
      <tr>
        <td nowrap> Customer Phone</td>
        <td>:</td>
        <td><input name="customer_phone" type="text" id="customer_phone" value="<?php echo $customer_phone;?>"></td>
      </tr>
      <tr>
        <td nowrap> Warranty Status</td>
        <td>:</td>
        <td><select name="warranty_status">
            <?php
$query1 = "select warranty_status from $table_name WHERE id = $entryID";
$result1=@mysqli_query($dbcnx, $query1);
while ($row = @mysqli_fetch_array($result1)) {
$model = "{$row['warranty_status']}";
echo "<option selected value=\"$warranty_status\" >$warranty_status</option>\n";
	}

if ($model == "None") {
	echo "<option  value=\"Active\">Active</option>\n";
	echo "<option  value=\"Closed\">Closed</option>\n";
	echo "<option  value=\"Pending\">Pending</option>\n";
} elseif ($model == "Active") {
	echo "<option  value=\"None\">None</option>\n";
	echo "<option  value=\"Closed\">Closed</option>\n";
	echo "<option  value=\"Pending\">Pending</option>\n";
} elseif ($model == "Closed") {
	echo "<option  value=\"None\">None</option>\n";
	echo "<option  value=\"Active\">Active</option>\n";
	echo "<option  value=\"Pending\">Pending</option>\n";
} elseif ($model == "Pending") {
	echo "<option  value=\"None\">None</option>\n";
	echo "<option  value=\"Active\">Active</option>\n";
	echo "<option  value=\"Closed\">Closed</option>\n";
} elseif ($model == "") {
	echo "<option  value=\"None\">None</option>\n";
	echo "<option  value=\"Active\">Active</option>\n";
	echo "<option  value=\"Closed\">Closed</option>\n";
	echo "<option  value=\"Pending\">Pending</option>\n";
}
?>
          </select></td>
      </tr>
      <tr>
        <td nowrap> Spiff Paid?</td>
        <td>:</td>
        <td><select name="spiff_paid">
            <?
$query1 = "select spiff_paid from $table_name WHERE id = $entryID";
$result1=@mysqli_query($dbcnx, $query1);
while ($row = @mysqli_fetch_array($result1)) {
$model = "{$row['spiff_paid']}";
echo "<option selected value=\"$spiff_paid\" >$spiff_paid</option>\n";
	}

if ($model == "Yes") {
	echo "<option  value=\"No\">No</option>\n";
	echo "<option  value=\"Approved\">Approved</option>\n";
	echo "<option  value=\"Missing Info\">Missing Info</option>\n";
} elseif ($model == "No") {
	echo "<option  value=\"Yes\">Yes</option>\n";
	echo "<option  value=\"Approved\">Approved</option>\n";
	echo "<option  value=\"Missing Info\">Missing Info</option>\n";
} elseif ($model == "Approved") {
	echo "<option  value=\"Yes\">Yes</option>\n";
	echo "<option  value=\"No\">No</option>\n";
	echo "<option  value=\"Missing Info\">Missing Info</option>\n";
} elseif ($model == "Missing Info") {
	echo "<option  value=\"Yes\">Yes</option>\n";
	echo "<option  value=\"No\" selected>No</option>\n";
	echo "<option  value=\"Approved\">Approved</option>\n";
} elseif ($model == "") {
	echo "<option  value=\"Yes\">Yes</option>\n";
	echo "<option  value=\"No\" selected>No</option>\n";
	echo "<option  value=\"Approved\">Approved</option>\n";
	echo "<option  value=\"Missing Info\">Missing Info</option>\n";
}
?>
          </select></td>
      </tr>
      <tr>
        <td nowrap>Spiff Approved Date </td>
        <td>:</td>
        <td><input name="spiff_approved_date" type="text" id="spiff_approved_date" value="<?php echo $spiff_approved_date;?>"></td>
      </tr>
      <tr>
        <td nowrap>Spiff Paid Date </td>
        <td>:</td>
        <td><input name="spiff_date" type="text" id="spiff_date" value="<?php echo $spiff_date;?>"></td>
      </tr>
      <tr>
        <td nowrap>Spiff Check #</td>
        <td>:</td>
        <td><input name="spiff_check_num" type="text" id="spiff_check_num" value="<?php echo $spiff_check_num;?>"></td>
      </tr>
      <tr>
        <td nowrap>Spiff Amount</td>
        <td>:</td>
        <td>$
          <input name="spiff_amount" type="text" id="spiff_amount" value="<?php echo $spiff_amount;?>"></td>
      </tr>
      <tr>
        <td nowrap>Spiff Salesperson</td>
        <td>:</td>
        <td><select name="salesperson_id">
            <?
				$query2 = "SELECT * FROM 3G_serial_numbers_salesPersons ORDER BY fname ASC";
				$results2 = mysqli_query($dbcnx, $query2);
				
				if ($_POST['salesperson_id'] == "") {
						echo '<option>Select One</option> ';
				   }
				while($row2 = mysqli_fetch_array($results2)) {
					$salesID = $row2['salesperson_id'];
					$fname = $row2['fname'];
					$lname = $row2['lname'];
							
			   
				   
				   
				    echo '<option value="' . $salesID . '" ';
					if ($salesperson_id == $salesID) {
						echo 'selected="selected"';
						}
					echo '>'.$fname.' '.$lname.'</option>';
				}
				?>
          </select>
          &nbsp;- or -&nbsp;
          <input type=button onClick="parent.location='users.php?mode=add'" value='New Salesperson'></td>
      </tr>
      <tr>
        <td nowrap> Diagnosis:</td>
        <td>:</td>
        <td><textarea name="diagnosis" id="diagnosis" rows="6" cols="40"><?php echo $diagnosis; ?></textarea></td>
      </tr>
      <tr>
        <td nowrap> Solution:</td>
        <td>:</td>
        <td><textarea name="solution" id="solution" rows="6" cols="40"><?php echo $solution; ?></textarea></td>
      </tr>
      <tr>
        <td nowrap> Labor Claim Paid:</td>
        <td>:</td>
        <td><textarea name="labor_claim_paid" id="labor_claim_paid" rows="6" cols="40"><?php echo $labor_claim_paid; ?></textarea></td>
      </tr>
      <tr>
        <td nowrap> Parts Sent Out:</td>
        <td>:</td>
        <td><textarea name="parts_sent_out" id="parts_sent_out" rows="6" cols="40"><?php echo $parts_sent_out; ?></textarea></td>
      </tr>
      <tr>
        <td></td>
        <td>&nbsp;</td>
        <td><br />
          <input name="submit" type="submit" id="submit" value="SAVE" class="submitButton" />
          
          <br>
            <br>
            <br>
            <a href="index.php?mode=delete&entryID=<?=$entryID?>" onClick="javascript:return confirm('Are you sure you want to Delete Permanently?')" style='color:#dd0000;'>Delete</a>
            </td>
      </tr>
    </table>
  </form>
</div>
<?php elseif($mode == 'view') :?>
<div class="viewEditBox">
  
  <table width="100%" border="0" cellspacing="3" cellpadding="2">
    <tr>
      <td valign="middle" align="left"><a href="index.php" class="addButton">Close</a></td>
      <td valign="middle" align="right"><a href="index.php?mode=edit&entryID=<?php echo $entryID; ?>" class="addButton">Edit</a> 
      <!--<a href="index.php?mode=edit&entryID=<?php echo $entryID; ?>" class="addButton">E-Mail</a> -->
      <a href="serial-print.php?mode=view&entryID=<?php echo $entryID; ?>" class="addButton" target="_blank">Print</a></td>
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
      <td align="left" valign="top" nowrap="nowrap"><strong>Spiff Approved Date:</strong></td>
      <td align="left" valign="top"><?php echo $spiff_approved_date; ?></td>
    </tr>
    <tr>
      <td align="left" valign="top" nowrap="nowrap"><strong>Spiff Paid Date:</strong></td>
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
				$results2 = mysqli_query($dbcnx, $query2);
				while($row2 = mysqli_fetch_array($results2)) {
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
<?php  else: // Default page display ?>
<?php 

echo '<table cellpadding="2" cellspacing="2" border="0"><tr><td>';
//echo '<a href="' . $_SERVER['PHP_SELF'] . '?mode=add" class="addButton">Add Entry</a>';
//echo '</td><td>';
echo $showAll;
echo '</td></tr></table>';
echo '<br>'; 
echo '<form action="index.php" method="get">Search Serials: 
	<input name="s1" type="text" id="s1" size="13" maxlength="12"> 
	<input name="s2" type="text" id="s2" size="5" maxlength="4"> 
	<input name="s3" type="text" id="s3" size="5" maxlength="3"> 
	<input type="hidden" name="mode" value="searchS"><input type="submit"></form>';
echo '&nbsp;&nbsp;<form action="index.php" method="get">Search Keywords: <input type="text" name="q" id="q"><input type="hidden" name="mode" value="search"><input type="submit"></form>';

echo '&nbsp;&nbsp;<form action="index.php?q=approved&mode=search" method="get">Spiffs : <input type="hidden" name="q" id="q" value="approved"><input type="hidden" name="mode" value="search"><input type="submit" value="Approved Claims"></form>';

echo '<br>'; 
echo '<br>'; 

$targetpage = "index.php"; 	
$pager = $_REQUEST['pager'];
if ($pager == "none") {
	$limit = 1000000000;
} else {
	$limit = 100;
} 
	
if ($_REQUEST['q'] == "approved") {
	$query = "SELECT COUNT(*) as num FROM $table_name WHERE spiff_paid='Approved' ";
} else {	
	if($mode == 'search') {
		$query = "SELECT COUNT(*) as num FROM $table_name WHERE 
		serial_number LIKE '%" . $q .  "%' 
		OR serial_number_2 LIKE '%" . $q ."%' 
		OR serial_number_3 LIKE '%" . $q ."%' 
		OR model LIKE '%" . $q ."%' 
		OR dealer_name LIKE '%" . $q ."%' 
		OR po_number LIKE '%" . $q ."%'
		OR sold_date_dealer LIKE '%" . $q ."%' 
		OR sold_date_customer LIKE '%" . $q ."%' 
		OR customer_name LIKE '%" . $q ."%' 
		OR customer_address LIKE '%" . $q ."%' 
		OR customer_city LIKE '%" . $q ."%' 
		OR customer_state LIKE '%" . $q ."%' 
		OR customer_zip LIKE '%" . $q ."%' 
		OR customer_email LIKE '%" . $q ."%' 
		OR customer_phone LIKE '%" . $q ."%' 
		OR warranty_status LIKE '%" . $q ."%' 
		OR spiff_paid LIKE '%" . $q ."%' 
		OR diagnosis LIKE '%" . $q ."%' 
		OR solution LIKE '%" . $q ."%' 
		OR labor_claim_paid LIKE '%" . $q ."%' 
		OR parts_sent_out LIKE '%" . $q ."%' 
		OR environment LIKE '%" . $q ."%' 
		";
		//echo $query;
	} elseif($mode == 'searchS') {
		$query = "SELECT COUNT(*) as num FROM $table_name WHERE 
		serial_number LIKE '%" . $s1 .  "%' 
		AND serial_number_2 LIKE '%" . $s2 ."%' 
		AND serial_number_3 LIKE '%" . $s3 ."%' 
		";
	} else {
		$query = "SELECT COUNT(*) as num FROM $table_name";
	}
}
	
	$total_pages = mysqli_fetch_array(mysqli_query($dbcnx, $query));
	$total_pages = $total_pages[num];
	
	$stages = 3;
	$page = mysqli_escape_string($dbcnx, $_GET['page']);
	if($page){
		$start = ($page - 1) * $limit; 
	}else{
		$start = 0;	
		}	
	
    // Get page data

if ($_REQUEST['q'] == "approved") {
	$query = "SELECT * FROM $table_name WHERE spiff_paid='Approved' ";
} else {	
	if($mode == 'search') {
		$query = "SELECT * FROM $table_name WHERE 
		serial_number LIKE '%" . $q .  "%' 
		OR serial_number_2 LIKE '%" . $q .  "%' 
		OR serial_number_3 LIKE '%" . $q .  "%' 
		OR model LIKE '%" . $q ."%' 
		OR dealer_name LIKE '%" . $q ."%' 
		OR po_number LIKE '%" . $q ."%'
		OR sold_date_dealer LIKE '%" . $q ."%' 
		OR sold_date_customer LIKE '%" . $q ."%' 
		OR customer_name LIKE '%" . $q ."%' 
		OR customer_address LIKE '%" . $q ."%' 
		OR customer_city LIKE '%" . $q ."%' 
		OR customer_state LIKE '%" . $q ."%' 
		OR customer_zip LIKE '%" . $q ."%' 
		OR customer_email LIKE '%" . $q ."%' 
		OR customer_phone LIKE '%" . $q ."%' 
		OR warranty_status LIKE '%" . $q ."%' 
		OR spiff_paid LIKE '%" . $q ."%' 
		OR diagnosis LIKE '%" . $q ."%' 
		OR solution LIKE '%" . $q ."%' 
		OR labor_claim_paid LIKE '%" . $q ."%' 
		OR parts_sent_out LIKE '%" . $q ."%' 
		OR environment LIKE '%" . $q ."%' 
		  ORDER BY $sortType $sortOrder 
		  LIMIT $start, $limit";
	} elseif($mode == 'searchS') {
		$query = "SELECT * FROM $table_name WHERE 
		serial_number LIKE '%" . $s1 .  "%' 
		AND serial_number_2 LIKE '%" . $s2 .  "%' 
		AND serial_number_3 LIKE '%" . $s3 .  "%' 
		  ORDER BY $sortType $sortOrder 
		  LIMIT $start, $limit";
	} else {
		// $query = "SELECT * FROM $table_name ORDER BY $sortType $sortOrder LIMIT $start, $limit";
		$query = "SELECT * FROM 3G_serial_numbers AS s LEFT JOIN 3G_serial_numbers_salesPersons AS p ON s.salesperson_id = p.salesperson_id ORDER BY $sortType $sortOrder LIMIT $start, $limit";
	}
	
}
	$resulter = mysqli_query($dbcnx, $query);
	
	// Initial page num setup
	if ($page == 0){$page = 1;}
	$prev = $page - 1;	
	$next = $page + 1;							
	$lastpage = ceil($total_pages/$limit);		
	$LastPagem1 = $lastpage - 1;					
	
	$paginate = '';
	if($lastpage > 1)
	{	
	

	
	
		$paginate .= "<div class='paginate'>";
		// Previous
		if ($page > 1){
			$paginate.= "<a href='$targetpage?page=$prev$isSearch&sortOrder=".$sortOrder."&sortType=".$sortType."'>previous</a>";
		}else{
			$paginate.= "<span class='disabled'>previous</span>";	}
			

		
		// Pages	
		if ($lastpage < 7 + ($stages * 2))	// Not enough pages to breaking it up
		{	
			for ($counter = 1; $counter <= $lastpage; $counter++)
			{
				if ($counter == $page){
					$paginate.= "<span class='current'>$counter</span>";
				}else{
					$paginate.= "<a href='$targetpage?page=$counter$isSearch&sortOrder=".$sortOrder."&sortType=".$sortType."'>$counter</a>";}					
			}
		}
		elseif($lastpage > 5 + ($stages * 2))	// Enough pages to hide a few?
		{
			// Beginning only hide later pages
			if($page < 1 + ($stages * 2))		
			{
				for ($counter = 1; $counter < 4 + ($stages * 2); $counter++)
				{
					if ($counter == $page){
						$paginate.= "<span class='current'>$counter</span>";
					}else{
						$paginate.= "<a href='$targetpage?page=$counter$isSearch&sortOrder=".$sortOrder."&sortType=".$sortType."'>$counter</a>";}					
				}
				$paginate.= "...";
				$paginate.= "<a href='$targetpage?page=$LastPagem1$isSearch&sortOrder=".$sortOrder."&sortType=".$sortType."'>$LastPagem1</a>";
				$paginate.= "<a href='$targetpage?page=$lastpage$isSearch&sortOrder=".$sortOrder."&sortType=".$sortType."'>$lastpage</a>";		
			}
			// Middle hide some front and some back
			elseif($lastpage - ($stages * 2) > $page && $page > ($stages * 2))
			{
				$paginate.= "<a href='$targetpage?page=1$isSearch&sortOrder=".$sortOrder."&sortType=".$sortType."'>1</a>";
				$paginate.= "<a href='$targetpage?page=2$isSearch&sortOrder=".$sortOrder."&sortType=".$sortType."'>2</a>";
				$paginate.= "...";
				for ($counter = $page - $stages; $counter <= $page + $stages; $counter++)
				{
					if ($counter == $page){
						$paginate.= "<span class='current'>$counter</span>";
					}else{
						$paginate.= "<a href='$targetpage?page=$counter$isSearch&sortOrder=".$sortOrder."&sortType=".$sortType."'>$counter</a>";}					
				}
				$paginate.= "...";
				$paginate.= "<a href='$targetpage?page=$LastPagem1$isSearch&sortOrder=".$sortOrder."&sortType=".$sortType."'>$LastPagem1</a>";
				$paginate.= "<a href='$targetpage?page=$lastpage$isSearch&sortOrder=".$sortOrder."&sortType=".$sortType."'>$lastpage</a>";		
			}
			// End only hide early pages
			else
			{
				$paginate.= "<a href='$targetpage?page=1$isSearch&sortOrder=".$sortOrder."&sortType=".$sortType."'>1</a>";
				$paginate.= "<a href='$targetpage?page=2$isSearch&sortOrder=".$sortOrder."&sortType=".$sortType."'>2</a>";
				$paginate.= "...";
				for ($counter = $lastpage - (2 + ($stages * 2)); $counter <= $lastpage; $counter++)
				{
					if ($counter == $page){
						$paginate.= "<span class='current'>$counter</span>";
					}else{
						$paginate.= "<a href='$targetpage?page=$counter$isSearch&sortOrder=".$sortOrder."&sortType=".$sortType."'>$counter</a>";}					
				}
			}
		}
					
				// Next
		if ($page < $counter - 1){ 
			$paginate.= "<a href='$targetpage?page=$next$isSearch&sortOrder=".$sortOrder."&sortType=".$sortType."'>next</a> <a href=\"index.php?pager=none&sortOrder=".$sortOrder."&sortType=".$sortType."\">show all</a>";
		}else{
			$paginate.= "<span class='disabled'>next</span> <a href=\"index.php?pager=none&sortOrder=".$sortOrder."&sortType=".$sortType."\">show all</a>";
			}
			
		$paginate.= "</div>";		
	
	
}
 	if($mode == 'search' || $mode == 'searchS') {
		echo '<strong>SEARCH RESULTS FOR: </strong> <span class="searchResultsText">'.$q.'&nbsp;'.$s1.'&nbsp;'.$s2.'&nbsp;'.$s3.'</span><br>'. $total_pages.' Results';
	} else {
		echo $total_pages.' Results';	
		// test 
		// echo $s3;
	}// pagination
 echo $paginate;
 
if ($sortOrder == "ASC") {
	$sortOrder2 = "DESC";
} else if ($sortOrder == "DESC") {
	$sortOrder2 = "ASC";
} else {
	$sortOrder2 = "ASC";
}
	//--> change every other row color
 	$color1 = "#eaeaea"; 
	$color2 = "#ffffff"; 
	$row_count = 0; 
	echo"<table cellspacing='2' cellpadding='4' border='0' width='100%'>\n";
	echo "<tr>\n";	
	echo "<td class='visitorsTableHdr' nowrap>Details</td>\n"; 
	echo "<td class='visitorsTableHdr'><a href='index.php?sortOrder=$sortOrder2&sortType=serial_number' ".$sorterClass1." >SERIAL".$sorter1."</a></td>\n";  
	echo "<td class='visitorsTableHdr'><a href='index.php?sortOrder=$sortOrder2&sortType=model' ".$sorterClass2." >Model".$sorter2."</a></td>\n";  
	echo "<td class='visitorsTableHdr'><a href='index.php?sortOrder=$sortOrder2&sortType=dealer_name' ".$sorterClass3." >Dealer Name".$sorter3."</a></td>\n"; 
	echo "<td class='visitorsTableHdr'><a href='index.php?sortOrder=$sortOrder2&sortType=sold_date_dealer' ".$sorterClass4." >Sold 2 Dealer Date".$sorter4."</a></td>\n"; 
	echo "<td class='visitorsTableHdr'><a href='index.php?sortOrder=$sortOrder2&sortType=sold_date_customer' ".$sorterClass5." >Sold 2 Customer Date".$sorter5."</a></td>\n"; 
	echo "<td class='visitorsTableHdr'><a href='index.php?sortOrder=$sortOrder2&sortType=customer_name' ".$sorterClass6." >Customer Name".$sorter6."</a></td>\n"; 
	echo "<td class='visitorsTableHdr'><a href='index.php?sortOrder=$sortOrder2&sortType=warranty_status' ".$sorterClass7." >Warranty Status".$sorter7."</a></td>\n"; 
	echo "<td class='visitorsTableHdr'><a href='index.php?sortOrder=$sortOrder2&sortType=fname' ".$sorterClass8." >Salesperson".$sorter8."</a></td>\n"; 
	
	
	echo "<td class='visitorsTableHdr'><a href='index.php?sortOrder=$sortOrder2&sortType=spiff_amount' ".$sorterClass8." >Spiff Amount".$sorter8."</a></td>\n"; 


	echo "<td class='visitorsTableHdr'><a href='index.php?sortOrder=$sortOrder2&sortType=spiff_paid' ".$sorterClass9." >Spiff Paid".$sorter9."</a></td>\n"; 
	echo "<td class='visitorsTableHdr'><a href='index.php?sortOrder=$sortOrder2&sortType=spiff_approved_date' ".$sorterClass10." >Spiff Approved Date".$sorter10."</a></td>\n"; 
	echo "<td class='visitorsTableHdr'><a href='index.php?sortOrder=$sortOrder2&sortType=spiff_date' ".$sorterClass11." >Spiff Paid Date".$sorter11."</a></td>\n"; 
//	echo "<td class='visitorsTableHdr' style='background-color:#dd0000;'>Delete?</td>\n"; 
	echo "</tr>\n";

	while($row = mysqli_fetch_array($resulter)){
	 	
	$row_color = ($row_count % 2) ? $color1 : $color2;
    $id = "{$row['id']}";
	$truncate = 150; 
	$first50 = substr(nl2br($meta_description),0,$truncate); 
	
	$serial_number = "{$row['serial_number']}";
	$serial_number_2 = "{$row['serial_number_2']}";
	$serial_number_3 = "{$row['serial_number_3']}";
	$serial = $serial_number."-".$serial_number_2."-".$serial_number_3;
	
	$sold_date_dealer = "{$row['sold_date_dealer']}";
	if ($sold_date_dealer == "0000-00-00") {
		$sold_date_dealer = "";
	} else {
	$sold_date_dealer = date("m/d/y",strtotime($sold_date_dealer));
	}

	$sold_date_customer = "{$row['sold_date_customer']}";
	if ($sold_date_customer == "0000-00-00") {
		$sold_date_customer = "";
	} else {
	$sold_date_customer = date("m/d/y",strtotime($sold_date_customer));
	}
	
	$spiff_amount = "{$row['spiff_amount']}";
	number_format($spiff_amount, 2, ',', ' ');
	if ($spiff_amount == '') 
		{$spiffDollar = '';} 
	else 
		{$spiffDollar = '$';} 

	$spiff_date = "{$row['spiff_date']}";
	if ($spiff_date == "0000-00-00") {
		$spiff_date = "";
	} else 	if ($spiff_date == "") {
		$spiff_date = "";
	} else {
	$spiff_date = date("m/d/y",strtotime($spiff_date));
	}

	$spiff_approved_date = "{$row['spiff_approved_date']}";
	if ($spiff_approved_date == "0000-00-00") {
		$spiff_approved_date = "";
	} else if ($spiff_approved_date == "") {
		$spiff_approved_date = "";
	} else {
	$spiff_approved_date = date("m/d/y",strtotime($spiff_approved_date));
	}
	
	$diagnosis = "{$row['diagnosis']}";
	$diagnosis = stripslashes($diagnosis);
	$diagnosis = substr(nl2br($diagnosis),0,$truncate); 

	$solution = "{$row['solution']}";
	$solution = stripslashes($solution);
	$solution = substr(nl2br($solution),0,$truncate); 

	$labor_claim_paid = "{$row['labor_claim_paid']}";
	$labor_claim_paid = stripslashes($labor_claim_paid);
	$labor_claim_paid = substr(nl2br($labor_claim_paid),0,$truncate); 

	$parts_sent_out = "{$row['parts_sent_out']}";
	$parts_sent_out = stripslashes($parts_sent_out);
	$parts_sent_out = substr(nl2br($parts_sent_out),0,$truncate); 
	
	$salesperson_id = "{$row['salesperson_id']}";
	
	$query2 = "SELECT * FROM 3G_serial_numbers_salesPersons WHERE salesperson_id='$salesperson_id' ";
	$results2 = mysqli_query($dbcnx, $query2);
	$row2 = mysqli_fetch_array($results2);
	$salesID = $row2['salesperson_id'];
	$salesfname = $row2['fname'];
	$saleslname = $row2['lname'];

	
  echo "<tr>\n";
	 echo "<td bgcolor='$row_color' class='visitorsTableRow'><a href=\"" . $_SERVER['PHP_SELF'] . 
      "?mode=view&entryID=$id\" nowrap>Details</a></td>";
	echo "<td bgcolor='$row_color' class='visitorsTableRow' nowrap><b>$serial</b></td>\n";  
	echo "<td bgcolor='$row_color' class='visitorsTableRow'>{$row['model']}</td>\n";  
	echo "<td bgcolor='$row_color' class='visitorsTableRow'>{$row['dealer_name']}</td>\n";  
	echo "<td bgcolor='$row_color' class='visitorsTableRow'>$sold_date_dealer</td>\n";  
	echo "<td bgcolor='$row_color' class='visitorsTableRow'>$sold_date_customer</td>\n";  
	echo "<td bgcolor='$row_color' class='visitorsTableRow'>{$row['customer_name']}</td>\n";  
	echo "<td bgcolor='$row_color' class='visitorsTableRow'>{$row['warranty_status']}</td>\n";  
	echo "<td bgcolor='$row_color' class='visitorsTableRow'>$salesfname $saleslname</td>\n";  
	echo "<td bgcolor='$row_color' class='visitorsTableRow'>$spiffDollar$spiff_amount</td>\n"; 
	echo "<td bgcolor='$row_color' class='visitorsTableRow'>{$row['spiff_paid']}</td>\n"; 
	echo "<td bgcolor='$row_color' class='visitorsTableRow' nowrap>$spiff_approved_date</td>\n"; 
	echo "<td bgcolor='$row_color' class='visitorsTableRow' nowrap>$spiff_date</td>\n"; 
	 
//	echo "<td bgcolor='$row_color' class='visitorsTableRow'><a href=\"".$_SERVER['PHP_SELF']."?mode=delete&entryID=" . $id . "\" onClick=\"javascript:return confirm('Are you sure you want to delete  $serial_number?')\" style='color:#dd0000;'>Delete</a></td>\n"; 
	echo "</tr>\n";
	
	$row_count++;
  } 
  
  	echo "</table>";
	echo $paginate;
 	echo "<br>";



 ?>
<?php endif; ?>
</body>
</html>
