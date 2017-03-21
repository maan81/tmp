<?php
include('config.php');
authUser('1,2,3');

	
$mode = $_REQUEST['mode']; //add, edit, delete, search or blank = display
$entryID = $_REQUEST['entryID'];
$table_name = "3G_serial_numbers_salesPersons";

if ($mode == "search") {
	$q = $_REQUEST['q'];
	$isSearch = "&mode=search&q=".$q;
	$showAll = '<a href="/serial/users.php" class="addButton">Show All</a>';
}


if($mode == 'edit') { 
	$sql = "SELECT * FROM $table_name WHERE salesperson_id='$entryID' ";
	$rs = mysql_query($sql); 
	$r = mysql_fetch_array($rs);
	$salesperson_id = $r['salesperson_id'];
	$fname = $r['fname'];
	$lname = $r['lname'];
	$ssn = $r['ssn'];
	$address = $r['address'];
	$city = $r['city'];
	$state = $r['state'];
	$zip = $r['zip'];
	$email = $r['email'];
	$phone = $r['phone'];
	$store_id = $r['store_id'];
	$mailing_pref = $r['mailing_pref'];
}

if(isset($_POST['submit']) || $mode == 'delete') {
	if($mode == 'delete') {
		$sql = "DELETE FROM  $table_name WHERE salesperson_id='$entryID' ";
		$mode = '';
		 if (@mysql_query($sql)) { 
			$prompt = '<h2 class="prompt">Entry was successfully deleted.</h2><br><meta http-equiv="refresh" content="3;URL=users.php">'; 
		 } else { 
			$prompt = '<p>Error adding submitted entry: ' . mysql_error() . '</p>'; 
		 } 		
	} elseif($mode == 'add') {
		$mode = '';
	    $sql = "INSERT INTO $table_name SET 
		fname='".$_POST['fname']."',
		lname='".$_POST['lname']."',
		ssn='".$_POST['ssn']."',
		address='".$_POST['address']."',
		city='".$_POST['city']."',
		state='".$_POST['state']."',
		email='".$_POST['email']."',
		phone='".$_POST['phone']."',
		store_id='".$_POST['store_id']."',
		mailing_pref='".$_POST['mailing_pref']."',
		zip='".$_POST['zip']."'
		";
  
		 if (@mysql_query($sql)) { 
			$prompt = '<h2 class="prompt">Your entry has been added.</h2><br><meta http-equiv="refresh" content="3;URL=users.php">'; 
		 } else { 
			$prompt = '<p>Error adding submitted entry: ' . mysql_error() . '</p>'; 
		 } 
	} elseif ($mode == 'edit') {
		$mode = '';
		$sql = "UPDATE $table_name SET 
        fname='{$_POST['fname']}', 
        lname='{$_POST['lname']}', 
        ssn='{$_POST['ssn']}', 
        address='{$_POST['address']}', 
        city='{$_POST['city']}', 
        state='{$_POST['state']}', 
        email='{$_POST['email']}', 
        phone='{$_POST['phone']}', 
        store_id='{$_POST['store_id']}', 
        mailing_pref='{$_POST['mailing_pref']}', 
        zip='{$_POST['zip']}'
			WHERE salesperson_id='$entryID' ";		
		 if (@mysql_query($sql)) { 
			$prompt = '<h2 class="prompt">Your entry has been updated.</h2><br><meta http-equiv="refresh" content="3;URL=users.php">'; 
		 } else { 
			$prompt = '<p>Error editing entry: ' . mysql_error() . '</p>'; 
		 } 

	} 
	#
}
?>
<html>
<head>
<title>3G Sales Persons Admin</title>
<meta http-equiv="Content-Type" 
    content="text/html; charset=ISO-8859-1" />
<link href="styles.css" rel="stylesheet" type="text/css">
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.0/jquery-ui.js"></script>
<script src="masked.js" type="text/javascript"></script>
<script type="text/javascript">

jQuery(function($){
  // $("#date").mask("99/99/9999");
   $("#phone").mask("(999) 999-9999");
  // $("#tin").mask("99-9999999");
   $("#ssn").mask("999-99-9999");
});

</script>
</head>
<body class="adminbody">
<?php include("hdr.php"); ?>
<br>
<?php if(isset($prompt)) print $prompt?>
<?php if($mode == 'add' || $mode == 'edit') :?>
<div class="viewEditBox"> <a href="/serial/users.php" class="addButton">Cancel</a><br>
  <br>
  <form action="<?= $_SERVER['PHP_SELF']?>?mode=<?=$mode?>&entryID=<?=$entryID?>" method="post">
    <table cellpadding="3" cellspacing="3" border="0" width="100%">
      <tr>
        <td colspan="3" nowrap><h1><strong>Salesperson: </strong>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $fname." ".$lname;?></h1></td>
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
        <td width="1%" nowrap><strong>First Name</strong></td>
        <td>:</td>
        <td><input name="fname" type="text" id="fname" tabindex="1" value="<?php echo $fname;?>" ></td>
      </tr>
      <tr>
        <td nowrap><strong>Last Name</strong></td>
        <td>:</td>
        <td><input name="lname" type="text" id="lname" tabindex="2" value="<?php echo $lname;?>" ></td>
      </tr>
      <tr>
        <td nowrap>SSN</td>
        <td>:</td>
        <td><input name="ssn" type="text" id="ssn" tabindex="2" value="<?php echo $ssn;?>" size="11" maxlength="9"  ></td>
      </tr>
      <tr>
        <td nowrap>Address</td>
        <td>:</td>
        <td><input name="address" type="text" id="address" value="<?php echo $address;?>" size="45"></td>
      </tr>
      <tr>
        <td nowrap>City</td>
        <td>:</td>
        <td><input name="city" type="text" id="city" value="<?php echo $city;?>"></td>
      </tr>
      <tr>
        <td nowrap>State</td>
        <td>:</td>
        <td><select name="state">
            <?php

	
$state_array = array(
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
foreach ($state_array as $val => $display){
   $selected = ($state == $val ? 'selected="selected"' : '');
   print "<option value='$val' $selected>$display</option>\n";
}

?>
          </select></td>
      </tr>
      <tr>
        <td nowrap>Zip</td>
        <td>:</td>
        <td><input name="zip" type="text" id="zip" value="<?php echo $zip;?>"></td>
      </tr>
      <tr>
        <td>Email</td>
        <td>:</td>
        <td><input name="email" type="text" id="email" value="<?php echo $email;?>"></td>
      </tr>
      <tr>
        <td>Phone</td>
        <td>:</td>
        <td><input name="phone" type="text" id="phone" value="<?php echo $phone;?>"></td>
      </tr>
      <tr>
        <td>Store</td>
        <td>:</td>
        <td><select name="store_id">
            <option value="">Choose One</option>
            <?
				$query2 = "SELECT * FROM dealers3G ORDER BY name ASC";
				$results2 = mysql_query($query2);				
				while($row2 = mysql_fetch_array($results2)) {
					$id = $row2['id'];
					$name = $row2['name'];
					$state = $row2['state'];
				    echo '<option value="' . $id . '" ';
					if ($store_id == $id) {
						echo 'selected="selected"';
						}
					echo '>'.$name.' '.$state.'</option>';
				}
				?>
          </select></td>
      </tr>
      <tr>
        <td nowrap>Mailing Pref</td>
        <td>:</td>
        <td><select name="mailing_pref">
            <?php
$mailing_array = array(
'' => 'Select One',
'Home' => 'Home',
'Store' => 'Store',	);
foreach ($mailing_array as $val => $display){
   $selected = ($mailing_pref == $val ? 'selected="selected"' : '');
   print "<option value='$val' $selected>$display</option>\n";
}

?>
          </select></td>
      </tr>
      <tr>
        <td></td>
        <td>&nbsp;</td>
        <td><br />
          <input name="submit" type="submit" id="submit" value="SUBMIT" /></td>
      </tr>
    </table>
  </form>
</div>
<?php elseif($mode == 'view') :?>
<div class="viewEditBox">
  <?php
$query1 = "select * from $table_name WHERE salesperson_id = $entryID";
$result1=@mysql_query($query1);
while ($row = @mysql_fetch_array($result1)) {
	
	$salesperson_id = "{$row['salesperson_id']}";
	$fname = "{$row['fname']}";
	$lname = "{$row['lname']}";
	$ssn = "{$row['ssn']}";
	$address = "{$row['address']}";
	$city = "{$row['city']}";
	$state = "{$row['state']}";
	$zip = "{$row['zip']}";
	$email = "{$row['email']}";
	$phone = "{$row['phone']}";
	$store_id = "{$row['store_id']}";
	$mailing_pref = "{$row['mailing_pref']}";
	$diagnosis = "{$row['diagnosis']}";
	
}
?>
  <table width="100%" border="0" cellspacing="3" cellpadding="2">
    <tr>
      <td valign="middle" align="left"><a href="/serial/users.php" class="addButton">Close</a></td>
      <td valign="middle" align="right"><a href="users.php?mode=edit&entryID=<?php echo $entryID; ?>" class="addButton">Edit</a></td>
    </tr>
    <tr>
      <td align="left" valign="top" nowrap="nowrap"><h1><strong>Salesperson:</strong></h1></td>
      <td align="left" valign="top"><h1><?php echo $fname." ".$lname;?></h1></td>
    </tr>
    <tr>
      <td align="left" valign="top" nowrap="nowrap"><strong>SSN:</strong></td>
      <td align="left" valign="top"><?php echo $ssn;?></td>
    </tr>
    <tr>
      <td align="left" valign="top" nowrap="nowrap"><strong>Address:</strong></td>
      <td align="left" valign="top"><?php echo $address;?></td>
    </tr>
    <tr>
      <td align="left" valign="top" nowrap="nowrap"><strong>City:</strong></td>
      <td align="left" valign="top"><?php echo $city;?></td>
    </tr>
    <tr>
      <td align="left" valign="top" nowrap="nowrap"><strong>State:</strong></td>
      <td align="left" valign="top"><?php echo $state;?></td>
    </tr>
    <tr>
      <td align="left" valign="top" nowrap="nowrap"><strong>Zip:</strong></td>
      <td align="left" valign="top"><?php echo $zip;?></td>
    </tr>
    <tr>
      <td align="left" valign="top" nowrap="nowrap"><strong>Email:</strong></td>
      <td align="left" valign="top"><?php echo $email;?></td>
    </tr>
    <tr>
      <td align="left" valign="top" nowrap="nowrap"><strong>Phone:</strong></td>
      <td align="left" valign="top"><?php echo $phone;?></td>
    </tr>
    <tr>
      <td align="left" valign="top" nowrap="nowrap"><strong>Store:</strong></td>
      <td align="left" valign="top"><?php
	  $query2 = "SELECT * FROM dealers3G WHERE id='$store_id' ";
				$results2 = mysql_query($query2);				
				while($row2 = mysql_fetch_array($results2)) {
					echo $row2['name'];
				}
      ?></td>
    </tr>
    <tr>
      <td align="left" valign="top" nowrap="nowrap"><strong>Mailing Pref:</strong></td>
      <td align="left" valign="top"><?php echo $mailing_pref;?></td>
    </tr>
  </table>
  <h2>Spiff Totals:</h2>
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tbody>
    
      <tr>
    
    <td class="spiffTD"><h3>2016</h3>
      <table class="spiffTable1">
        <tbody>
          <tr>
            <th>Spiff Date</th>
            <th>Spiff Check Num</th>
            <th>Spiff Amount</th>
          </tr>
          <?php 
		$totalSpiff = 0;
		$sql = "SELECT * FROM 3G_serial_numbers WHERE salesperson_id='$entryID' AND spiff_amount!='' AND spiff_date BETWEEN '2016-01-01' AND '2016-12-31' ORDER BY spiff_date DESC ";
		$results2 = mysql_query($sql);				
				while($row2 = mysql_fetch_array($results2)) {
					$spiff_date = $row2['spiff_date'];
					$spiff_check_num = $row2['spiff_check_num'];
					$spiff_amount = $row2['spiff_amount'];
					
					$totalSpiff += $spiff_amount;
					
					echo '<tr>';
					echo '<td>'.$spiff_date.'</td>';
					echo '<td>'.$spiff_check_num.'</td>';
					echo '<td>$'.$spiff_amount.'</td>';
					echo '<tr>';
				}
		?>
        
          <td colspan="2" align="right"><strong>Total:</strong></td>
          <td><strong>$<?php echo $totalSpiff; ?></strong></td>
        </tr>
          </tr>
        
          </tbody>
        
      </table></td>
    
      <td class="spiffTD"><h3>2015</h3>
        <table class="spiffTable1">
          <tbody>
            <tr>
              <th>Spiff Date</th>
              <th>Spiff Check Num</th>
              <th>Spiff Amount</th>
            </tr>
            <?php 
		$totalSpiff = 0;
		$sql = "SELECT * FROM 3G_serial_numbers WHERE salesperson_id='$entryID' AND spiff_amount!='' AND spiff_date BETWEEN '2015-01-01' AND '2015-12-31' ORDER BY spiff_date DESC ";
		$results2 = mysql_query($sql);				
				while($row2 = mysql_fetch_array($results2)) {
					$spiff_date = $row2['spiff_date'];
					$spiff_check_num = $row2['spiff_check_num'];
					$spiff_amount = $row2['spiff_amount'];
					
					$totalSpiff += $spiff_amount;
					
					echo '<tr>';
					echo '<td>'.$spiff_date.'</td>';
					echo '<td>'.$spiff_check_num.'</td>';
					echo '<td>$'.$spiff_amount.'</td>';
					echo '<tr>';
				}
		?>
          
            <td colspan="2" align="right"><strong>Total:</strong></td>
            <td><strong>$<?php echo $totalSpiff; ?></strong></td>
          </tr>
            </tr>
          
            </tbody>
          
        </table></td>
    </tr>
      <tr>
    
    <td class="spiffTD"><h3>2014</h3>
      <table class="spiffTable1">
        <tbody>
          <tr>
            <th>Spiff Date</th>
            <th>Spiff Check Num</th>
            <th>Spiff Amount</th>
          </tr>
          <?php 
		$totalSpiff = 0;
		$sql = "SELECT * FROM 3G_serial_numbers WHERE salesperson_id='$entryID' AND spiff_amount!='' AND spiff_date BETWEEN '2014-01-01' AND '2014-12-31' ORDER BY spiff_date DESC ";
		$results2 = mysql_query($sql);				
				while($row2 = mysql_fetch_array($results2)) {
					$spiff_date = $row2['spiff_date'];
					$spiff_check_num = $row2['spiff_check_num'];
					$spiff_amount = $row2['spiff_amount'];
					
					$totalSpiff += $spiff_amount;
					
					echo '<tr>';
					echo '<td>'.$spiff_date.'</td>';
					echo '<td>'.$spiff_check_num.'</td>';
					echo '<td>$'.$spiff_amount.'</td>';
					echo '<tr>';
				}
		?>
        
          <td colspan="2" align="right"><strong>Total:</strong></td>
          <td><strong>$<?php echo $totalSpiff; ?></strong></td>
        </tr>
          </tr>
        
          </tbody>
        
      </table></td>
    
      <td class="spiffTD"><h3>2013</h3>
        <table class="spiffTable1">
          <tbody>
            <tr>
              <th>Spiff Date</th>
              <th>Spiff Check Num</th>
              <th>Spiff Amount</th>
            </tr>
            <?php 
		$totalSpiff = 0;
		$sql = "SELECT * FROM 3G_serial_numbers WHERE salesperson_id='$entryID' AND spiff_amount!='' AND spiff_date BETWEEN '2013-01-01' AND '2013-12-31' ORDER BY spiff_date DESC ";
		$results2 = mysql_query($sql);				
				while($row2 = mysql_fetch_array($results2)) {
					$spiff_date = $row2['spiff_date'];
					$spiff_check_num = $row2['spiff_check_num'];
					$spiff_amount = $row2['spiff_amount'];
					
					$totalSpiff += $spiff_amount;
					
					echo '<tr>';
					echo '<td>'.$spiff_date.'</td>';
					echo '<td>'.$spiff_check_num.'</td>';
					echo '<td>$'.$spiff_amount.'</td>';
					echo '<tr>';
				}
		?>
          
            <td colspan="2" align="right"><strong>Total:</strong></td>
            <td><strong>$<?php echo $totalSpiff; ?></strong></td>
          </tr>
            </tr>
          
            </tbody>
          
        </table></td>
    </tr>
      <tr>
    
    <td class="spiffTD"><h3>2012</h3>
      <table class="spiffTable1">
        <tbody>
          <tr>
            <th>Spiff Date</th>
            <th>Spiff Check Num</th>
            <th>Spiff Amount</th>
          </tr>
          <?php 
		$totalSpiff = 0;
		$sql = "SELECT * FROM 3G_serial_numbers WHERE salesperson_id='$entryID' AND spiff_amount!='' AND spiff_date BETWEEN '2012-01-01' AND '2012-12-31' ORDER BY spiff_date DESC ";
		$results2 = mysql_query($sql);				
				while($row2 = mysql_fetch_array($results2)) {
					$spiff_date = $row2['spiff_date'];
					$spiff_check_num = $row2['spiff_check_num'];
					$spiff_amount = $row2['spiff_amount'];
					
					$totalSpiff += $spiff_amount;
					
					echo '<tr>';
					echo '<td>'.$spiff_date.'</td>';
					echo '<td>'.$spiff_check_num.'</td>';
					echo '<td>$'.$spiff_amount.'</td>';
					echo '<tr>';
				}
		?>
        
          <td colspan="2" align="right"><strong>Total:</strong></td>
          <td><strong>$<?php echo $totalSpiff; ?></strong></td>
        </tr>
          </tr>
        
          </tbody>
        
      </table></td>
      </tr>
    
      </tbody>
    
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
echo '<form action="users.php" method="get">Search: <input type="text" name="q" id="q"><input type="hidden" name="mode" value="search"><input type="submit"></form>';
echo '<br>'; 
echo '<br>'; 

$targetpage = "users.php"; 	
$limit = 100; 
	
	if($mode == 'search') {
		$query = "SELECT COUNT(*) as num FROM $table_name WHERE 
		fname LIKE '%" . $q .  "%' 
		OR lname LIKE '%" . $q ."%' 
		OR ssn LIKE '%" . $q ."%' 
		OR address LIKE '%" . $q ."%' 
		OR city LIKE '%" . $q ."%' 
		OR state LIKE '%" . $q ."%' 
		OR zip LIKE '%" . $q ."%' 
		";
	} else {
		$query = "SELECT COUNT(*) as num FROM $table_name";
	}
	$total_pages = mysql_fetch_array(mysql_query($query));
	$total_pages = $total_pages[num];
	
	$stages = 3;
	$page = mysql_escape_string($_GET['page']);
	if($page){
		$start = ($page - 1) * $limit; 
	}else{
		$start = 0;	
		}	
	
    // Get page data
	if($mode == 'search') {
		$query1 = "SELECT * FROM $table_name WHERE 
		fname LIKE '%" . $q .  "%' 
		OR lname LIKE '%" . $q ."%' 
		OR ssn LIKE '%" . $q ."%' 
		OR address LIKE '%" . $q ."%' 
		OR city LIKE '%" . $q ."%' 
		OR state LIKE '%" . $q ."%' 
		OR zip LIKE '%" . $q ."%' 
		 ORDER BY fname ASC
		 LIMIT $start, $limit";
	} else {
		$query1 = "SELECT * FROM $table_name ORDER BY fname ASC LIMIT $start, $limit ";
	}
	$result = mysql_query($query1);
	
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
			$paginate.= "<a href='$targetpage?page=$prev$isSearch'>previous</a>";
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
					$paginate.= "<a href='$targetpage?page=$counter$isSearch'>$counter</a>";}					
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
						$paginate.= "<a href='$targetpage?page=$counter$isSearch'>$counter</a>";}					
				}
				$paginate.= "...";
				$paginate.= "<a href='$targetpage?page=$LastPagem1$isSearch'>$LastPagem1</a>";
				$paginate.= "<a href='$targetpage?page=$lastpage$isSearch'>$lastpage</a>";		
			}
			// Middle hide some front and some back
			elseif($lastpage - ($stages * 2) > $page && $page > ($stages * 2))
			{
				$paginate.= "<a href='$targetpage?page=1$isSearch'>1</a>";
				$paginate.= "<a href='$targetpage?page=2$isSearch'>2</a>";
				$paginate.= "...";
				for ($counter = $page - $stages; $counter <= $page + $stages; $counter++)
				{
					if ($counter == $page){
						$paginate.= "<span class='current'>$counter</span>";
					}else{
						$paginate.= "<a href='$targetpage?page=$counter$isSearch'>$counter</a>";}					
				}
				$paginate.= "...";
				$paginate.= "<a href='$targetpage?page=$LastPagem1$isSearch'>$LastPagem1</a>";
				$paginate.= "<a href='$targetpage?page=$lastpage$isSearch'>$lastpage</a>";		
			}
			// End only hide early pages
			else
			{
				$paginate.= "<a href='$targetpage?page=1$isSearch'>1</a>";
				$paginate.= "<a href='$targetpage?page=2$isSearch'>2</a>";
				$paginate.= "...";
				for ($counter = $lastpage - (2 + ($stages * 2)); $counter <= $lastpage; $counter++)
				{
					if ($counter == $page){
						$paginate.= "<span class='current'>$counter</span>";
					}else{
						$paginate.= "<a href='$targetpage?page=$counter$isSearch'>$counter</a>";}					
				}
			}
		}
					
				// Next
		if ($page < $counter - 1){ 
			$paginate.= "<a href='$targetpage?page=$next$isSearch'>next</a>";
		}else{
			$paginate.= "<span class='disabled'>next</span>";
			}
			
		$paginate.= "</div>";		
	
	
}
 	if($mode == 'search') {
		echo '<strong>SEARCH RESULTS FOR: </strong> <span class="searchResultsText">'.$q.'</span><br>'. $total_pages.' Results';
	} else {
		echo $total_pages.' Results';	
	}// pagination
 echo $paginate;
 

	//--> change every other row color
 	$color1 = "#eaeaea"; 
	$color2 = "#ffffff"; 
	$row_count = 0; 
	echo"<table cellspacing='2' cellpadding='4' border='0' width='100%'>\n";
	echo "<tr>\n";	
	echo "<td class='visitorsTableHdr2' width='10%' nowrap>Details</td>\n"; 
	echo "<td class='visitorsTableHdr2' width='10%' nowrap>Name</td>\n";  
	echo "<td class='visitorsTableHdr2' width='10%' nowrap>City</td>\n";  
	echo "<td class='visitorsTableHdr2' width='10%' nowrap>State</td>\n"; 
	echo "<td class='visitorsTableHdr2' width='10%' nowrap>Zip</td>\n"; 
	echo "<td class='visitorsTableHdr2' width='15%' nowrap>Email</td>\n"; 
	echo "<td class='visitorsTableHdr2'>Store</td>\n"; 
	//echo "<td class='visitorsTableHdr2' style='background-color:#dd0000;' width='1%' nowrap>Delete?</td>\n"; 
	echo "</tr>\n";
	
	while($row = mysql_fetch_array($result)){ 
	 	
	$row_color = ($row_count % 2) ? $color1 : $color2;
    $salesperson_id = "{$row['salesperson_id']}";
	$fname = "{$row['fname']}";
	$lname = "{$row['lname']}";
	$city = "{$row['city']}";
	$state = "{$row['state']}";
	$zip = "{$row['zip']}";
	$email = "{$row['email']}";
	$phone = "{$row['phone']}";
	$store_id = "{$row['store_id']}";
	
	$diagnosis = "{$row['diagnosis']}";
	 
	$query3 = "SELECT name FROM dealers3G WHERE id='$store_id' ";
	$results3 = mysql_query($query3);				
	$row3 = mysql_fetch_array($results3);
	$name = $row3['name'];
				
  echo "<tr>\n";
	 echo "<td bgcolor='$row_color' class='visitorsTableRow'   width='10%' nowrap><a href=\"" . $_SERVER['PHP_SELF'] . 
      "?mode=view&entryID={$row['salesperson_id']}\" nowrap>Details</a></td>";
	echo "<td bgcolor='$row_color' class='visitorsTableRow'  width='10%' nowrap nowrap><b>$fname $lname</b></td>\n";  
	echo "<td bgcolor='$row_color' class='visitorsTableRow'  width='10%' nowrap>$city</td>\n";  
	echo "<td bgcolor='$row_color' class='visitorsTableRow'  width='10%' nowrap>$state</td>\n";  
	echo "<td bgcolor='$row_color' class='visitorsTableRow'  width='10%' nowrap>$zip</td>\n";  
	echo "<td bgcolor='$row_color' class='visitorsTableRow'  width='15%' nowrap><a href='mailto:$email'>$email</a></td>\n";  
	echo "<td bgcolor='$row_color' class='visitorsTableRow'>$name</td>\n";  
	 
	//echo "<td bgcolor='$row_color' class='visitorsTableRow' width='1%'><a href=\"".$_SERVER['PHP_SELF']."?mode=delete&entryID=" . $salesperson_id . "\" onClick=\"javascript:return confirm('Are you sure you want to delete  $serial_number?')\" style='color:#dd0000;'>Delete</a></td>\n"; 
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
