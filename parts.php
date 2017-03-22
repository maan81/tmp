<?php
include('config.php');
authUser('1,2,3');

	
$mode = $_REQUEST['mode']; //add, edit, delete, search or blank = display
$model_id = $_REQUEST['model_id'];
$entryID = $_REQUEST['entryID'];
$table_name = "3G_serial_numbers_parts";

if ($mode == "search") {
	$q = $_REQUEST['q'];
	$isSearch = "&mode=search&q=".$q;
	$showAll = '<a href="/serial/parts.php" class="addButton">Show All</a>';
}

if($mode == 'edit') { 
	$sql = "SELECT * FROM $table_name WHERE id='$entryID' ";
	$rs = mysqli_query($dbcnx, $sql);
	$r = mysqli_fetch_array($rs);
	$id = $r['id'];
	$model_id = $r['model_id'];
	$part_name = $r['part_name'];
	$part_num = $r['part_num'];
	$part_kind = $r['part_kind'];
	$part_serial_num = $r['part_serial_num'];
	$part_size = $r['part_size'];
	$part_set = $r['part_set'];
	$part_cost = $r['part_cost'];
	$part_msrp = $r['part_msrp'];
	$min_qty = $r['min_qty'];
	$actual_qty = $r['actual_qty'];
	$order_qty = $r['order_qty'];
}

if(isset($_POST['submit']) || $mode == 'delete') {
	if($mode == 'delete') {
		$sql = "DELETE FROM  $table_name WHERE id='$entryID' ";
		$mode = '';
		 if (@mysqli_query($dbcnx, $sql)) {
			$prompt = '<h2 class="prompt">Entry was successfully deleted.</h2><br><meta http-equiv="refresh" content="3;URL=parts.php">'; 
		 } else { 
			$prompt = '<p>Error adding submitted entry: ' . mysqli_error($dbcnx) . '</p>';
		 } 		
	} elseif($mode == 'add') {
		$mode = '';
	    $sql = "INSERT INTO $table_name SET 
		model_id='".$_POST['model_id']."',
		part_name='".$_POST['part_name']."',
		part_num='".$_POST['part_num']."',
		part_kind='".$_POST['part_kind']."',
		part_serial_num='".$_POST['part_serial_num']."',
		part_size='".$_POST['part_size']."',
		part_set='".$_POST['part_set']."',
		part_msrp='".$_POST['part_msrp']."',
		min_qty='".$_POST['min_qty']."',
		actual_qty='".$_POST['actual_qty']."',
		order_qty='".$_POST['order_qty']."',
		part_cost='".$_POST['part_cost']."'
		";
  
		 if (@mysqli_query($dbcnx, $sql)) {
			$prompt = '<h2 class="prompt">Your entry has been added.</h2><br><meta http-equiv="refresh" content="3;URL=parts.php">'; 
		 } else { 
			$prompt = '<p>Error adding submitted entry: ' . mysqli_error($dbcnx) . '</p>';
		 } 
	} elseif ($mode == 'edit') {
		$mode = '';
		$sql = "UPDATE $table_name SET 

        part_name='{$_POST['part_name']}', 
        part_num='{$_POST['part_num']}', 
        part_kind='{$_POST['part_kind']}', 
        part_serial_num='{$_POST['part_serial_num']}', 
        part_size='{$_POST['part_size']}', 
        part_set='{$_POST['part_set']}', 
        part_msrp='{$_POST['part_msrp']}', 
        min_qty='{$_POST['min_qty']}', 
        actual_qty='{$_POST['actual_qty']}', 
        order_qty='{$_POST['order_qty']}', 
        part_cost='{$_POST['part_cost']}'
			WHERE id='$entryID' ";		
		 if (@mysqli_query($dbcnx, $sql)) {
			$prompt = '<h2 class="prompt">Your entry has been updated.</h2><br><meta http-equiv="refresh" content="3;URL=parts.php?model_id='.$model_id.'">'; 
		 } else { 
			$prompt = '<p>Error editing entry: ' . mysqli_error($dbcnx) . '</p>';
		 } 

	} 
	#
}
?>
<html>
<head>
<title>3G Parts</title>
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
<div class="viewEditBox"> <a href="/serial/parts.php" class="addButton">Cancel</a><br>
  <br>
  <form action="<?= $_SERVER['PHP_SELF']?>?mode=<?=$mode?>&entryID=<?=$entryID?>" method="post">
    <table cellpadding="3" cellspacing="3" border="0" width="100%">
      <tr>
        <td colspan="3" ><h3>Model: 
        <?php
        $query1 = "select * from 3G_serial_numbers_models WHERE model_id = $model_id";
        $result1=@mysqli_query($dbcnx, $query1);
        while ($row = @mysqli_fetch_array($result1)) {
		echo $row['name'];
		}
		?>
        </h3><h1><?php echo $part_name;?></h1></td>
      </tr>
      <tr>
        <td colspan="3"><?php switch($mode) {
			case 'add':
				?>
          <h3>Add Entry:</h3>
          <?php
				break;
			case 'edit':
				?>
          <h3>Edit Entry:</h3>
          <?php
				break;			
		}
	?></td>
      </tr>
      <tr>
        <td width="1%" nowrap><strong> part_name</strong></td>
        <td width="1%">:</td>
        <td><input name="part_name" type="text" id="part_name" value="<?php echo $part_name;?>" ></td>
      </tr>
      <tr>
        <td nowrap>part_num</td>
        <td>:</td>
        <td><input name="part_num" type="text" id="part_num" value="<?php echo $part_num;?>" ></td>
      </tr>
      <tr>
        <td nowrap>part_kind</td>
        <td>:</td>
        <td><select name="part_kind" id="part_kind">
            <?php

	
$part_kind_array = array(
'' => 'Select One',
'free' => 'free',
'free_unknown' => 'free_unknown',
'set' => 'set',
	);
foreach ($part_kind_array as $val => $display){
   $selected = ($part_kind == $val ? 'selected="selected"' : '');
   print "<option value='$val' $selected>$display</option>\n";
}

?>
          </select></td>
      </tr>
      <tr>
        <td nowrap>part_serial_num</td>
        <td>:</td>
        <td><input name="part_serial_num" type="text" id="part_serial_num" value="<?php echo $part_serial_num;?>"></td>
      </tr>
      <tr>
        <td nowrap>part_size</td>
        <td>:</td>
        <td><input name="part_size" type="text" id="part_size" value="<?php echo $part_size;?>"></td>
      </tr>
      <tr>
        <td nowrap>part_set</td>
        <td>:</td>
        <td><input name="part_set" type="text" id="part_set" value="<?php echo $part_set;?>"></td>
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
        <td>
        
        <select name="min_qty" id="min_qty">
            <?php

	
$min_qty_array = array(
""=>"Choose",
"0"=>"0",
"1"=>"1",
"2"=>"2",
"3"=>"3",
"4"=>"4",
"5"=>"5",
"6"=>"6",
"7"=>"7",
"8"=>"8",
"9"=>"9",
"10"=>"10",
"11"=>"11",
"12"=>"12",
"13"=>"13",
"14"=>"14",
"15"=>"15",
"16"=>"16",
"17"=>"17",
"18"=>"18",
"19"=>"19",
"20"=>"20",
"21"=>"21",
"22"=>"22",
"23"=>"23",
"24"=>"24",
"25"=>"25",
"26"=>"26",
"27"=>"27",
"28"=>"28",
"29"=>"29",
"30"=>"30",
"31"=>"31",
"32"=>"32",
"33"=>"33",
"34"=>"34",
"35"=>"35",
"36"=>"36",
"37"=>"37",
"38"=>"38",
"39"=>"39",
"40"=>"40",
"41"=>"41",
"42"=>"42",
"43"=>"43",
"44"=>"44",
"45"=>"45",
"46"=>"46",
"47"=>"47",
"48"=>"48",
"49"=>"49",
"50"=>"50",
	);
foreach ($min_qty_array as $val => $display){
   $selected = ($min_qty == $val ? 'selected="selected"' : '');
   print "<option value='$val' $selected>$display</option>\n";
}

?>
          </select>
        
        </td>
      </tr>
      <tr>
        <td>actual_qty</td>
        <td>:</td>
        <td>
        <select name="actual_qty" id="actual_qty">
            <?php

	
$actual_qty_array = array(
""=>"Choose",
"0"=>"0",
"1"=>"1",
"2"=>"2",
"3"=>"3",
"4"=>"4",
"5"=>"5",
"6"=>"6",
"7"=>"7",
"8"=>"8",
"9"=>"9",
"10"=>"10",
"11"=>"11",
"12"=>"12",
"13"=>"13",
"14"=>"14",
"15"=>"15",
"16"=>"16",
"17"=>"17",
"18"=>"18",
"19"=>"19",
"20"=>"20",
"21"=>"21",
"22"=>"22",
"23"=>"23",
"24"=>"24",
"25"=>"25",
"26"=>"26",
"27"=>"27",
"28"=>"28",
"29"=>"29",
"30"=>"30",
"31"=>"31",
"32"=>"32",
"33"=>"33",
"34"=>"34",
"35"=>"35",
"36"=>"36",
"37"=>"37",
"38"=>"38",
"39"=>"39",
"40"=>"40",
"41"=>"41",
"42"=>"42",
"43"=>"43",
"44"=>"44",
"45"=>"45",
"46"=>"46",
"47"=>"47",
"48"=>"48",
"49"=>"49",
"50"=>"50",
	);
foreach ($actual_qty_array as $val => $display){
   $selected = ($actual_qty == $val ? 'selected="selected"' : '');
   print "<option value='$val' $selected>$display</option>\n";
}

?>
          </select>
        
        </td>
      </tr>
      <tr>
        <td>order_qty</td>
        <td>:</td>
        <td>
        
        <select name="order_qty" id="order_qty">
            <?php

	
$order_qty_array = array(
""=>"Choose",
"0"=>"0",
"1"=>"1",
"2"=>"2",
"3"=>"3",
"4"=>"4",
"5"=>"5",
"6"=>"6",
"7"=>"7",
"8"=>"8",
"9"=>"9",
"10"=>"10",
"11"=>"11",
"12"=>"12",
"13"=>"13",
"14"=>"14",
"15"=>"15",
"16"=>"16",
"17"=>"17",
"18"=>"18",
"19"=>"19",
"20"=>"20",
"21"=>"21",
"22"=>"22",
"23"=>"23",
"24"=>"24",
"25"=>"25",
"26"=>"26",
"27"=>"27",
"28"=>"28",
"29"=>"29",
"30"=>"30",
"31"=>"31",
"32"=>"32",
"33"=>"33",
"34"=>"34",
"35"=>"35",
"36"=>"36",
"37"=>"37",
"38"=>"38",
"39"=>"39",
"40"=>"40",
"41"=>"41",
"42"=>"42",
"43"=>"43",
"44"=>"44",
"45"=>"45",
"46"=>"46",
"47"=>"47",
"48"=>"48",
"49"=>"49",
"50"=>"50",
	);
foreach ($order_qty_array as $val => $display){
   $selected = ($order_qty == $val ? 'selected="selected"' : '');
   print "<option value='$val' $selected>$display</option>\n";
}

?>
          </select>
        
        </td>
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
$query1 = "select * from $table_name WHERE id = $entryID";
$result1=@mysqli_query($dbcnx. $query1);
while ($row = @mysqli_fetch_array($result1)) {
	
	$id = "{$row['id']}";
	$model_id = "{$row['model_id']}";
	$part_name = "{$row['part_name']}";
	$part_num = "{$row['part_num']}";
	$part_kind = "{$row['part_kind']}";
	$part_serial_num = "{$row['part_serial_num']}";
	$part_size = "{$row['part_size']}";
	$part_set = "{$row['part_set']}";
	$part_cost = "{$row['part_cost']}";
	$part_msrp = "{$row['part_msrp']}";
	$min_qty = "{$row['min_qty']}";
	$actual_qty = "{$row['actual_qty']}";
	$order_qty = "{$row['order_qty']}";
	
}
?>
  <table width="100%" border="0" cellspacing="3" cellpadding="2">
    <tr>
      <td width="1%" align="left" valign="middle"><a href="/serial/parts.php" class="addButton">Close</a></td>
      <td valign="middle" align="right"><a href="parts.php?mode=edit&entryID=<?php echo $entryID; ?>" class="addButton">Edit</a></td>
    </tr>
    <tr>
      <td align="left" valign="top" nowrap="nowrap"><strong> part_name</strong></td>
      <td align="left" valign="top"><?php echo $part_name;?></td>
    </tr>
    <tr>
      <td align="left" valign="top" nowrap="nowrap">part_num</td>
      <td align="left" valign="top"><?php echo $part_num;?></td>
    </tr>
    <tr>
      <td align="left" valign="top" nowrap="nowrap">part_kind</td>
      <td align="left" valign="top"><?php echo $part_kind;?></td>
    </tr>
    <tr>
      <td align="left" valign="top" nowrap="nowrap">part_serial_num</td>
      <td align="left" valign="top"><?php echo $part_serial_num;?></td>
    </tr>
    <tr>
      <td align="left" valign="top" nowrap="nowrap">part_size</td>
      <td align="left" valign="top"><?php echo $part_size;?></td>
    </tr>
    <tr>
      <td align="left" valign="top" nowrap="nowrap">part_set</td>
      <td align="left" valign="top"><?php echo $part_set;?></td>
    </tr>
    <tr>
      <td align="left" valign="top" nowrap="nowrap">part_cost</td>
      <td align="left" valign="top"><?php echo $part_cost;?></td>
    </tr>
    <tr>
      <td align="left" valign="top" nowrap="nowrap">part_msrp</td>
      <td align="left" valign="top"><?php echo $part_msrp;?></td>
    </tr>
    <tr>
      <td align="left" valign="top" nowrap="nowrap">min_qty</td>
      <td align="left" valign="top"><?php echo $min_qty;?></td>
    </tr>
    <tr>
      <td align="left" valign="top" nowrap="nowrap">actual_qty</td>
      <td align="left" valign="top"><?php echo $actual_qty;?></td>
    </tr>
  </table>
  
  
  
        
        
</div>
<?php  else: // Default page display ?>

<?php if ($model_id == "") { ?>
<div class="temp1">
	<div id="access" >
          <div class="menu-header">
            <ul id="menu-menu" class="menu">
                  <li><a href="parts.php?model_id=3">6.0</a></li>
                  <li><a href="parts.php?model_id=2">5.0</a></li>
                  <li><a href="parts.php?model_id=1">3.0</a></li>
                  <li><a href="parts.php?model_id=4">Elite Runner</a></li>
                  <li><a href="parts.php?model_id=5">Pro Runner</a></li>
                  <li><a href="parts.php?model_id=6">80i</a></li>
                </ul>
              
          </div>
        </div>
</div>
<?php } else { ?>

<h3 style="text-align:center;">Model: 
        <?php
        $query1 = "select * from 3G_serial_numbers_models WHERE model_id = $model_id";
        $result1=@mysqli_query($dbcnx, $query1);
        while ($row = @mysqli_fetch_array($result1)) {
		echo $row['name'];
		}
		?>
        </h3>
<?php 

echo '<table cellpadding="2" cellspacing="2" border="0"><tr><td>';
//echo '<a href="' . $_SERVER['PHP_SELF'] . '?mode=add" class="addButton">Add Entry</a>';
//echo '</td><td>';
echo $showAll;
echo '</td></tr></table>';
/*echo '<br>'; 
echo '<form action="parts.php" method="get">Search: <input type="text" name="q" id="q"><input type="hidden" name="mode" value="search"><input type="submit"></form>';
echo '<br>'; 
echo '<br>'; 
*/
$targetpage = "parts.php"; 	
$limit = 10000000; 
	
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
		$query = "SELECT COUNT(*) as num FROM $table_name WHERE model_id='$model_id' ";
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
		$query1 = "SELECT * FROM $table_name WHERE model_id='$model_id' ORDER BY part_num ASC LIMIT $start, $limit ";
	}
	$result = mysqli_query($dbcnx, $query1);
	
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
	echo "<td class='visitorsTableHdr2' width='1%' nowrap>EDIT</td>\n"; 
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
	echo "<td class='visitorsTableHdr2' nowrap>SUBTOTAL</td>\n"; 
	//echo "<td class='visitorsTableHdr2' style='background-color:#dd0000;' width='1%' nowrap>Delete?</td>\n"; 
	echo "</tr>\n";
	
	while($row = mysqli_fetch_array($result)){
	 	
	$row_color = ($row_count % 2) ? $color1 : $color2;
    $id = "{$row['id']}";
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
	$actual_qty = "{$row['actual_qty']$results3 = mysqli_query($dbcnx, $query}";
	$order_qty = "{$row['order_qty']}";
	
	 
	$query3 = "SELECT name FROM 3G_serial_numbers_models WHERE model_id='$model_id' ";
	$results3 = mysqli_query($dbcnx, $query3);
	$row3 = mysqli_fetch_array($results3);
	$name = $row3['name'];
				
  echo "<tr >\n";
	echo "<td  class=' bdr1 ".$part_kind."' width='1%'><a href=\"" . $_SERVER['PHP_SELF'] . 
      "?mode=edit&entryID={$row['id']}\" nowrap>EDIT</a></td>\n";  
	echo "<td  class=' bdr1 ".$part_kind."' width='1%'>$name</td>\n";  
	echo "<td  class=' bdr1 ".$part_kind."' >$part_num</td>\n";  
	echo "<td  class=' bdr1 ".$part_kind."' >$part_serial_num</td>\n";  
	echo "<td  class=' bdr1 ".$part_kind."' >$part_kind</td>\n";  
	echo "<td  class=' bdr1 ".$part_kind."' ><b>$part_name</b></td>\n";  
	echo "<td  class=' bdr1 ".$part_kind."' >$part_size</td>\n";  
	echo "<td  class=' bdr1 ".$part_kind."' >$part_set</td>\n";  
	echo "<td  class=' bdr1 ".$part_kind."' >$$part_cost</td>\n";  
	echo "<td  class=' bdr1 ".$part_kind."' >$$part_msrp</td>\n";  
	echo "<td  class=' bdr1 ".$part_kind."' align='center'>$min_qty</td>\n";  
	echo "<td  class=' bdr1 ".$part_kind."' align='center'>$actual_qty</td>\n";  
	echo "<td  class=' bdr1 ".$part_kind."' align='center'>$order_qty</td>\n";  
	echo "<td  class=' bdr1 ".$part_kind."' nowrap >$";
	$subtotal = ($order_qty * $part_cost); 
	$subtotal = number_format($subtotal, 2, '.', ''); 
	echo $subtotal;
	$grandTotal += $subtotal;
	$grandTotal = number_format($grandTotal, 2, '.', ''); 
	echo"</td>\n"; 
	 
	//echo "<td  class='' width='1%'><a href=\"".$_SERVER['PHP_SELF']."?mode=delete&entryID=" . $id . "\" onClick=\"javascript:return confirm('Are you sure you want to delete  $serial_number?')\" style='color:#dd0000;'>Delete</a></td>\n"; 
	echo "</tr>\n";
	
	$row_count++;
	$subtotal++;
  } 
  
  	echo "</table>";
	echo $paginate;
 	echo "<br>";



 ?>
 
 <div style="float:right; margin:0px 20px 100px 20px; "><table border='0'><tr><td style="text-align:right;"><h2><span style="font-weight:normal;">Grand Total:</span> $<?php echo $grandTotal; ?></h2></td></tr></table></div>
 
<?php } ?>

 
<?php endif; ?>


</body>
</html>
