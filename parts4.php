<?php
include('config.php');


	
$mode = $_REQUEST['mode']; //add, edit, delete, search or blank = display
$entryID = $_REQUEST['entryID'];
$table_name = "3G_serial_numbers_parts";

if ($mode == "search") {
	$q = $_REQUEST['q'];
	$isSearch = "&mode=search&q=".$q;
	$showAll = '<a href="/serial/parts.php" class="addButton">Show All</a>';
}


if($mode == 'edit') { 
	$sql = "SELECT * FROM $table_name WHERE part_id='$entryID' ";
	$rs = mysql_query($sql); 
	$r = mysql_fetch_array($rs);
	$part_id = $r['part_id'];
	$model_id = $r['model_id'];
	$part_num = $r['part_num'];
	$part_kind = $r['part_kind'];
	$part_serial_num = $r['part_serial_num'];
	$part_size = $r['part_size'];
	$part_set = $r['part_set'];
	$part_cost = $r['part_cost'];
	$part_msrp = $r['part_msrp'];
	$min_qty = $r['min_qty'];
	$actual_qty = $r['actual_qty'];
}

if(isset($_POST['submit']) || $mode == 'delete') {
	if($mode == 'delete') {
		$sql = "DELETE FROM  $table_name WHERE part_id='$entryID' ";
		$mode = '';
		 if (@mysql_query($sql)) { 
			$prompt = '<h2 class="prompt">Entry was successfully deleted.</h2><br><meta http-equiv="refresh" content="3;URL=users.php">'; 
		 } else { 
			$prompt = '<p>Error adding submitted entry: ' . mysql_error() . '</p>'; 
		 } 		
	} elseif($mode == 'add') {
		$mode = '';
	    $sql = "INSERT INTO $table_name SET 
		model_id='".$_POST['model_id']."',
		part_num='".$_POST['part_num']."',
		part_kind='".$_POST['part_kind']."',
		part_serial_num='".$_POST['part_serial_num']."',
		part_size='".$_POST['part_size']."',
		part_set='".$_POST['part_set']."',
		part_msrp='".$_POST['part_msrp']."',
		min_qty='".$_POST['min_qty']."',
		actual_qty='".$_POST['actual_qty']."',
		part_cost='".$_POST['part_cost']."'
		";
  
		 if (@mysql_query($sql)) { 
			$prompt = '<h2 class="prompt">Your entry has been added.</h2><br><meta http-equiv="refresh" content="3;URL=users.php">'; 
		 } else { 
			$prompt = '<p>Error adding submitted entry: ' . mysql_error() . '</p>'; 
		 } 
	} elseif ($mode == 'edit') {
		$mode = '';
		$sql = "UPDATE $table_name SET 
        model_id='{$_POST['model_id']}', 
        part_num='{$_POST['part_num']}', 
        part_kind='{$_POST['part_kind']}', 
        part_serial_num='{$_POST['part_serial_num']}', 
        part_size='{$_POST['part_size']}', 
        part_set='{$_POST['part_set']}', 
        part_msrp='{$_POST['part_msrp']}', 
        min_qty='{$_POST['min_qty']}', 
        actual_qty='{$_POST['actual_qty']}', 
        part_cost='{$_POST['part_cost']}'
			WHERE part_id='$entryID' ";		
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
<script src="https://code.jquery.com/jquery-1.10.2.js"></script>
<script src="https://code.jquery.com/ui/1.11.0/jquery-ui.js"></script>
<script src="masked.js" type="text/javascript"></script>
<script type="text/javascript">

jQuery(function($){
  // $("#date").mask("99/99/9999");
   $("#phone").mask("(999) 999-9999");
  // $("#tin").mask("99-9999999");
   $("#ssn").mask("999-99-9999");
   // wrong $("#subtotal4").mask("9.99");
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
        <td colspan="3" nowrap><h1><strong>Salesperson: </strong>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $model_id." ".$part_num;?></h1></td>
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
        <td><input name="model_id" type="text" id="model_id" tabindex="1" value="<?php echo $model_id;?>" ></td>
      </tr>
      <tr>
        <td nowrap><strong>Last Name</strong></td>
        <td>:</td>
        <td><input name="part_num" type="text" id="part_num" tabindex="2" value="<?php echo $part_num;?>" ></td>
      </tr>
      <tr>
        <td nowrap>part_kind</td>
        <td>:</td>
        <td><input name="part_kind" type="text" id="part_kind" tabindex="2" value="<?php echo $part_kind;?>" size="11" maxlength="9"  ></td>
      </tr>
      <tr>
        <td nowrap>part_serial_num</td>
        <td>:</td>
        <td><input name="part_serial_num" type="text" id="part_serial_num" value="<?php echo $part_serial_num;?>" size="45"></td>
      </tr>
      <tr>
        <td nowrap>part_size</td>
        <td>:</td>
        <td><input name="part_size" type="text" id="part_size" value="<?php echo $part_size;?>"></td>
      </tr>
      <tr>
        <td nowrap>part_set</td>
        <td>:</td>
        <td><select name="part_set">
            <?php

	
$part_set_array = array(
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
foreach ($part_set_array as $val => $display){
   $selected = ($part_set == $val ? 'selected="selected"' : '');
   print "<option value='$val' $selected>$display</option>\n";
}

?>
          </select></td>
      </tr>
      <tr>
        <td nowrap>part_cost</td>
        <td>:</td>
        <td><input name="part_cost" type="text" id="part_cost" value="<?php echo $part_cost;?>"></td>
      </tr>
      <tr>
        <td>part_msrp</td>
        <td>:</td>
        <td><input name="part_msrp" type="text" id="part_msrp" value="<?php echo $part_msrp;?>"></td>
      </tr>
      <tr>
        <td>min_qty</td>
        <td>:</td>
        <td><input name="min_qty" type="text" id="min_qty" value="<?php echo $min_qty;?>"></td>
      </tr>
      <tr>
        <td>Store</td>
        <td>:</td>
        <td><select name="actual_qty">
        <option value="">Choose One</option>
            <?
				$query2 = "SELECT * FROM dealers3G ORDER BY name ASC";
				$results2 = mysql_query($query2);				
				while($row2 = mysql_fetch_array($results2)) {
					$id = $row2['id'];
					$name = $row2['name'];
					$part_set = $row2['part_set'];
				    echo '<option value="' . $id . '" ';
					if ($actual_qty == $id) {
						echo 'selected="selected"';
						}
					echo '>'.$name.' '.$part_set.'</option>';
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
$query1 = "select * from $table_name WHERE part_id = $entryID";
$result1=@mysql_query($query1);
while ($row = @mysql_fetch_array($result1)) {
	
	$part_id = "{$row['part_id']}";
	$model_id = "{$row['model_id']}";
	$part_num = "{$row['part_num']}";
	$part_kind = "{$row['part_kind']}";
	$part_serial_num = "{$row['part_serial_num']}";
	$part_size = "{$row['part_size']}";
	$part_set = "{$row['part_set']}";
	$part_cost = "{$row['part_cost']}";
	$part_msrp = "{$row['part_msrp']}";
	$min_qty = "{$row['min_qty']}";
	$actual_qty = "{$row['actual_qty']}";
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
      <td align="left" valign="top"><h1><?php echo $model_id." ".$part_num;?></h1></td>
    </tr>
    <tr>
      <td align="left" valign="top" nowrap="nowrap"><strong>part_kind:</strong></td>
      <td align="left" valign="top"><?php echo $part_kind;?></td>
    </tr>
    <tr>
      <td align="left" valign="top" nowrap="nowrap"><strong>part_serial_num:</strong></td>
      <td align="left" valign="top"><?php echo $part_serial_num;?></td>
    </tr>
    <tr>
      <td align="left" valign="top" nowrap="nowrap"><strong>part_size:</strong></td>
      <td align="left" valign="top"><?php echo $part_size;?></td>
    </tr>
    <tr>
      <td align="left" valign="top" nowrap="nowrap"><strong>part_set:</strong></td>
      <td align="left" valign="top"><?php echo $part_set;?></td>
    </tr>
    <tr>
      <td align="left" valign="top" nowrap="nowrap"><strong>part_cost:</strong></td>
      <td align="left" valign="top"><?php echo $part_cost;?></td>
    </tr>
    <tr>
      <td align="left" valign="top" nowrap="nowrap"><strong>part_msrp:</strong></td>
      <td align="left" valign="top"><?php echo $part_msrp;?></td>
    </tr>
    <tr>
      <td align="left" valign="top" nowrap="nowrap"><strong>min_qty:</strong></td>
      <td align="left" valign="top"><?php echo $min_qty;?></td>
    </tr>
    <tr>
      <td align="left" valign="top" nowrap="nowrap"><strong>Store:</strong></td>
      <td align="left" valign="top"><?php
	  $query2 = "SELECT * FROM dealers3G WHERE id='$actual_qty' ";
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
        <h3>2014</h3>
        <table class="spiffTable1">
        <tbody>
        <tr><th>Spiff Date</th><th>Spiff Check Num</th><th>Spiff Amount</th></tr>
        
          <?php 
		$totalSpiff = 0;
		$sql = "SELECT * FROM 3G_serial_numbers WHERE part_id='$entryID' AND spiff_amount!='' AND spiff_date BETWEEN '2014-01-01' AND '2014-12-31' ORDER BY spiff_date DESC ";
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
        <td colspan="2" align="right"><strong>Total:</strong></td><td> <strong>$<?php echo $totalSpiff; ?></strong></td></tr>
        </tr>
        </tbody>
        </table>
        

        
        <h3>2013</h3>
  <table class="spiffTable1">
        <tbody>
        <tr><th>Spiff Date</th><th>Spiff Check Num</th><th>Spiff Amount</th></tr>
        
          <?php 
		$totalSpiff = 0;
		$sql = "SELECT * FROM 3G_serial_numbers WHERE part_id='$entryID' AND spiff_amount!='' AND spiff_date BETWEEN '2013-01-01' AND '2013-12-31' ORDER BY spiff_date DESC ";
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
        <td colspan="2" align="right"><strong>Total:</strong></td><td> <strong>$<?php echo $totalSpiff; ?></strong></td></tr>
        </tr>
        </tbody>
        </table>
        
        
         <h3>2012</h3>
  <table class="spiffTable1">
        <tbody>
        <tr><th>Spiff Date</th><th>Spiff Check Num</th><th>Spiff Amount</th></tr>
        
          <?php 
		$totalSpiff = 0;
		$sql = "SELECT * FROM 3G_serial_numbers WHERE part_id='$entryID' AND spiff_amount!='' AND spiff_date BETWEEN '2012-01-01' AND '2012-12-31' ORDER BY spiff_date DESC ";
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
        <td colspan="2" align="right"><strong>Total:</strong></td><td> <strong>$<?php echo $totalSpiff; ?></strong></td></tr>
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
		model_id LIKE '%" . $q .  "%' 
		OR part_num LIKE '%" . $q ."%' 
		OR part_kind LIKE '%" . $q ."%' 
		OR part_serial_num LIKE '%" . $q ."%' 
		OR part_size LIKE '%" . $q ."%' 
		OR part_set LIKE '%" . $q ."%' 
		OR part_cost LIKE '%" . $q ."%' 
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
		model_id LIKE '%" . $q .  "%' 
		OR part_num LIKE '%" . $q ."%' 
		OR part_kind LIKE '%" . $q ."%' 
		OR part_serial_num LIKE '%" . $q ."%' 
		OR part_size LIKE '%" . $q ."%' 
		OR part_set LIKE '%" . $q ."%' 
		OR part_cost LIKE '%" . $q ."%' 
		 ORDER BY model_id ASC
		 LIMIT $start, $limit";
	} else {
		$query1 = "SELECT * FROM $table_name ORDER BY model_id ASC LIMIT $start, $limit ";
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
	$row_count = 1; 
	$subtotal = 0;
	echo"<table cellspacing='3' cellpadding='3' border='0' width='100%'>\n";
	echo "<tr>\n";	
	echo "<td class='visitorsTableHdr2' width='1%' nowrap>MODEL</td>\n"; 
	echo "<td class='visitorsTableHdr2' nowrap>PART #</td>\n";  
	echo "<td class='visitorsTableHdr2' nowrap>SERIAL</td>\n";  
	echo "<td class='visitorsTableHdr2' nowrap>KIND</td>\n";  
	echo "<td class='visitorsTableHdr2' nowrap>NAME</td>\n";  
	echo "<td class='visitorsTableHdr2' nowrap>SIZE</td>\n";  
	echo "<td class='visitorsTableHdr2' nowrap>SET</td>\n"; 
	echo "<td class='visitorsTableHdr2' nowrap>COST</td>\n"; 
	echo "<td class='visitorsTableHdr2' nowrap>MSRP</td>\n"; 
	echo "<td class='visitorsTableHdr2' nowrap>MIN QTY</td>\n"; 
	echo "<td class='visitorsTableHdr2' nowrap>ACTUAL QTY</td>\n"; 
	echo "<td class='visitorsTableHdr2' nowrap>ORDER QTY</td>\n"; 
	echo "<td class='visitorsTableHdr2' nowrap>ORDER COST</td>\n"; 
	echo "<td class='visitorsTableHdr2' nowrap>SUBTOTAL</td>\n"; 
	//echo "<td class='visitorsTableHdr2' style='background-color:#dd0000;' width='1%' nowrap>Delete?</td>\n"; 
	echo "</tr>\n";
	
	while($row = mysql_fetch_array($result)){ 
	 	
	$row_color = ($row_count % 2) ? $color1 : $color2;
    $part_id = "{$row['part_id']}";
	$model_id = "{$row['model_id']}";
	$part_num = "{$row['part_num']}";
	$part_name = "{$row['part_name']}";
	$part_kind = "{$row['part_kind']}";
	if ($part_kind == "") {$part_kind = "none";}
	$part_serial_num = "{$row['part_serial_num']}";
	$part_size = "{$row['part_size']}";
	$part_set = "{$row['part_set']}";
	$part_cost = "{$row['part_cost']}";
	$part_msrp = "{$row['part_msrp']}";
	$min_qty = "{$row['min_qty']}";
	$actual_qty = "{$row['actual_qty']}";
	
	$diagnosis = "{$row['diagnosis']}";
	 
	$query3 = "SELECT name FROM 3G_serial_numbers_models WHERE model_id='$model_id' ";
	$results3 = mysql_query($query3);				
	$row3 = mysql_fetch_array($results3);
	$name = $row3['name'];
				
  echo "<tr >\n";
	echo "<td  class=' bdr1 ".$part_kind."' width='1%'>$name</td>\n";  
	echo "<td  class=' bdr1 ".$part_kind."' >$part_num</td>\n";  
	echo "<td  class=' bdr1 ".$part_kind."' >$part_serial_num</td>\n";  
	echo "<td  class=' bdr1 ".$part_kind."' >$part_kind</td>\n";  
	echo "<td  class=' bdr1 ".$part_kind."' ><b>$part_name</b></td>\n";  
	echo "<td  class=' bdr1 ".$part_kind."' >$part_size</td>\n";  
	echo "<td  class=' bdr1 ".$part_kind."' >$part_set</td>\n";  
	echo "<td  class=' bdr1 ".$part_kind."' >$part_cost</td>\n";  
	echo "<td  class=' bdr1 ".$part_kind."' >$part_msrp</td>\n";  
	echo "<td  class=' bdr1 ".$part_kind."' >$min_qty</td>\n";  
	echo "<td  class=' bdr1 ".$part_kind."' >$actual_qty</td>\n";  
	echo "<td  class=' bdr1 ".$part_kind."' ><input type='text' size='4' name='q".$row_count."' id='q".$row_count."' onchange='totFields(this);' value='".$_POST['q1']."' /></td>\n";  
	echo "<td  class=' bdr1 ".$part_kind."' ><INPUT TYPE='text' NAME='prod".$subtotal."' id='prod".$subtotal."' SIZE='10'  onchange='totFields(this);' value='".$part_cost."' readonly style='background:none;'  /></td>\n"; 
	echo "<td  class=' bdr1 ".$part_kind."' ><input name='subtotal".$subtotal."'  class='formReadOnly' id='subtotal".$subtotal."' size='10' readonly style='background:none;' TYPE='text' /></td>\n"; 
	 
	//echo "<td  class='' width='1%'><a href=\"".$_SERVER['PHP_SELF']."?mode=delete&entryID=" . $part_id . "\" onClick=\"javascript:return confirm('Are you sure you want to delete  $serial_number?')\" style='color:#dd0000;'>Delete</a></td>\n"; 
	echo "</tr>\n";
	
	$row_count++;
	$subtotal++;
  } 
  
  	echo "</table>";
	echo $paginate;
 	echo "<br>";



 ?>
 
 <div style="float:right;"><table cellspacing='3' cellpadding='3' border='0' width='100%'><tr><td>Grand Total: <input name="gtotal" type="text" class="formReadOnly" id="gtotal" value="<?php echo $_POST['gtotal']; ?>" size="10" readonly  /></td></tr></table></div>
 
<?php endif; ?>

<script type="text/javascript"> 



String.prototype.trim=function()
{
	a=this.replace(/^\s+/,'');
	return a.replace(/\s+$/,'');
};



function totFields(thisObj)
{ 
	var value = thisObj.value.trim();
	if ( value.length == 0 || isNaN(value) )
	{
		alert("can't put a non-numeric value here. I am resetting the value to 0");
		thisObj.value = 0;
		return;
	}

	var allInputsInSameRow = thisObj.parentNode.parentNode.getElementsByTagName("input") ;
	//alert(allInputsInSameRow.length);

	var subtotal = 1;
	for ( var counter = 0; counter < (allInputsInSameRow.length - 1); counter++)
	{
		var value = allInputsInSameRow[ counter ].value.trim();
           // alert("value: " + value);
            if ( !isNaN(value) && value.length > 0)
            {
                  //alert("multiplying");
                    subtotal = subtotal * parseFloat(value);
            }      
	}
	document.getElementById(allInputsInSameRow[counter].getAttribute("id")).value = subtotal;
	//alert(subtotal);

	var total = 0;

	var allInputsInAllRows = thisObj.parentNode.parentNode.parentNode.getElementsByTagName("input");
	for ( var counter = 0; counter < (allInputsInAllRows.length - 1); counter++)
	{
		 var input = allInputsInAllRows[ counter ];
            var value = input.value.trim();
            var id = input.getAttribute("id");
            if ( id.indexOf("subtotal") == 0 )
            {
                  if ( !isNaN(value) && value.length > 0)
                  {
                        total += parseFloat(input.value);
                  }      
            }
	}
	
	document.getElementById("gtotal").value = total;
} 

</script>
</body>
</html>
