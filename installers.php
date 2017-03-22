<?php
include('config.php');
authUser('1,2,3');

	
$mode = $_REQUEST['mode']; //add, edit, delete, search or blank = display
$entryID = $_REQUEST['entryID'];
$table_name = "3G_serial_numbers_installers";

if ($mode == "search") {
	$q = $_REQUEST['q'];
	$isSearch = "&mode=search&q=".$q;
	$showAll = '<a href="/installers.php" class="addButton">Show All</a>';
}


if($mode == 'edit') { 
	$sql = "SELECT * FROM $table_name WHERE installer_id='$entryID' ";
	$rs = mysqli_query($dbcnx, $sql); 
	$r = mysqli_fetch_array($rs);
	$installer_id = $r['installer_id'];
	$fname = $r['fname'];
	$lname = $r['lname'];
	$biz_name = $r['biz_name'];
	$address = $r['address'];
	$city = $r['city'];
	$state = $r['state'];
	$zip = $r['zip'];
	$email = $r['email'];
	$phone = $r['phone'];
	$notes = $r['notes'];
	$nationwide = $r['nationwide'];
	$rating = $r['rating'];
	$labor_rate = $r['labor_rate'];

}

if(isset($_POST['submit']) || $mode == 'delete') {
	if($mode == 'delete') {
		$sql = "DELETE FROM  $table_name WHERE installer_id='$entryID' ";
		$mode = '';
		 if (@mysqli_query($dbcnx, $sql)) { 
			$_SESSION['prompt'] = '<h2 class="prompt" id="alert">Entry was successfully deleted.</h2>'; 
			header('Location:installers.php');
		 } else { 
			$prompt = '<p>Error adding submitted entry: ' . mysqli_error($dbcnx) . '</p>'; 
		 } 		
	} elseif($mode == 'add') {
		unset($_SESSION['prompt']);
		$mode = '';
	    $sql = "INSERT INTO $table_name SET 
		fname='".$_POST['fname']."',
		lname='".$_POST['lname']."',
		biz_name='".$_POST['biz_name']."',
		address='".$_POST['address']."',
		city='".$_POST['city']."',
		state='".$_POST['state']."',
		email='".$_POST['email']."',
		phone='".$_POST['phone']."',
		notes='".$_POST['notes']."',
		nationwide='".$_POST['nationwide']."',
		rating='".$_POST['rating']."',
		labor_rate='".$_POST['labor_rate']."',
		zip='".$_POST['zip']."'
		";
  
		 if (@mysqli_query($dbcnx, $sql)) { 
			$_SESSION['prompt'] = '<h2 class="prompt" id="alert">Your entry has been added.</h2>'; 
			header('Location:installers.php');
		 } else { 
			$prompt = '<p>Error adding submitted entry: ' . mysqli_error($dbcnx) . '</p>'; 
		 } 
	} elseif ($mode == 'edit') {
		unset($_SESSION['prompt']);
		$mode = '';
		$sql = "UPDATE $table_name SET 
        fname='{$_POST['fname']}', 
        lname='{$_POST['lname']}', 
        biz_name='{$_POST['biz_name']}', 
        address='{$_POST['address']}', 
        city='{$_POST['city']}', 
        state='{$_POST['state']}', 
        email='{$_POST['email']}', 
        phone='{$_POST['phone']}', 
        notes='{$_POST['notes']}', 
        nationwide='{$_POST['nationwide']}', 
        labor_rate='{$_POST['labor_rate']}', 
        rating='{$_POST['rating']}', 
        zip='{$_POST['zip']}'
			WHERE installer_id='$entryID' ";		
		 if (@mysqli_query($dbcnx, $sql)) { 
			$_SESSION['prompt'] = '<h2 class="prompt" id="alert">Your entry has been edited.</h2>'; 
			header('Location:installers.php?mode=view&entryID='.$entryID.'');
		 } else { 
			$prompt = '<p>Error editing entry: ' . mysqli_error($dbcnx) . '</p>'; 
		 } 

	} 
	#
}
?>
<html>
<head>
<title>3G Installers Admin</title>
<meta http-equiv="Content-Type" 
    content="text/html; charset=ISO-8859-1" />
<link href="styles.css" rel="stylesheet" type="text/css">
<link href="//netdna.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
<script src="//code.jquery.com/jquery-3.1.1.min.js"></script>
<script src="//code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
<script src="masked.js" type="text/javascript"></script>
<script type="text/javascript">
function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}
</script>
</head>
<body class="adminbody">
<?php include("hdr.php"); ?>
<br>
<?php if(isset($_SESSION['prompt'])) {
			print $_SESSION['prompt'];
		} else {
			unset($_SESSION['prompt']);
		}
?>
<?php if($mode == 'add' || $mode == 'edit') :?>
<?php unset($_SESSION['prompt']); ?>
<div class="viewEditBox"> <a href="/installers.php" class="addButton">Close</a><br>
  <br>
  <form action="<?= $_SERVER['PHP_SELF']?>?mode=<?=$mode?>&entryID=<?=$entryID?>" method="post">
    <table cellpadding="3" cellspacing="3" border="0" width="100%">
      <tr>
        <td colspan="3" nowrap><h1><strong>Installers: </strong>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $fname." ".$lname;?></h1></td>
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
        <td width="1%" nowrap>First Name</td>
        <td>:</td>
        <td><input name="fname" type="text" id="fname" tabindex="1" value="<?php echo $fname;?>" ></td>
      </tr>
      <tr>
        <td nowrap>Last Name</td>
        <td>:</td>
        <td><input name="lname" type="text" id="lname" tabindex="2" value="<?php echo $lname;?>" ></td>
      </tr>
      <tr>
        <td nowrap>Business Name</td>
        <td>:</td>
        <td><input name="biz_name" type="text" id="biz_name" tabindex="3" value="<?php echo $biz_name;?>"   ></td>
      </tr>
      <tr>
        <td nowrap>Address</td>
        <td>:</td>
        <td><input name="address" type="text" id="address" tabindex="4" value="<?php echo $address;?>" size="45"></td>
      </tr>
      <tr>
        <td nowrap>City</td>
        <td>:</td>
        <td><input name="city" type="text" id="city" tabindex="5" value="<?php echo $city;?>"></td>
      </tr>
      <tr>
        <td nowrap>State</td>
        <td>:</td>
        <td><select name="state" tabindex="6">
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
   print "<option value='$val' $selected>$display</option>";
}

?>
          </select>
          &nbsp;&nbsp;Nationwide?
          <input type="checkbox" name="nationwide" id="nationwide" value="yes" <?php if($nationwide == 'yes') echo 'checked'?>></td>
      </tr>
      <tr>
        <td nowrap>Zip</td>
        <td>:</td>
        <td><input name="zip" type="text" id="zip" tabindex="7" value="<?php echo $zip;?>"></td>
      </tr>
      <tr>
        <td>Email</td>
        <td>:</td>
        <td><input name="email" type="text" id="email" tabindex="8" value="<?php echo $email;?>"></td>
      </tr>
      <tr>
        <td>Phone</td>
        <td>:</td>
        <td><input name="phone" type="text" id="phone" tabindex="9" value="<?php echo $phone;?>"></td>
      </tr>
      <tr>
        <td>Labor Rate</td>
        <td>:</td>
        <td><input name="labor_rate" type="text" id="labor_rate" tabindex="9" value="<?php echo $labor_rate;?>"></td>
      </tr>
      <tr>
        <td nowrap="nowrap">Quality of Service</td>
        <td>:</td>
        <td><fieldset class="rating">
            <input type="radio" id="star5" name="rating" value="5" <?php if($rating == '5') echo 'checked'?>  />
            <label class = "full" for="star5" title="Awesome - 5 stars"></label>
            <input type="radio" id="star4half" name="rating" value="4.5" <?php if($rating == '4.5') echo 'checked'?> />
            <label class="half" for="star4half" title="Pretty good - 4.5 stars"></label>
            <input type="radio" id="star4" name="rating" value="4" <?php if($rating == '4') echo 'checked'?> />
            <label class = "full" for="star4" title="Pretty good - 4 stars"></label>
            <input type="radio" id="star3half" name="rating" value="3.5" <?php if($rating == '3.5') echo 'checked'?> />
            <label class="half" for="star3half" title="Meh - 3.5 stars"></label>
            <input type="radio" id="star3" name="rating" value="3" <?php if($rating == '3') echo 'checked'?> />
            <label class = "full" for="star3" title="Meh - 3 stars"></label>
            <input type="radio" id="star2half" name="rating" value="2.5" <?php if($rating == '2.5') echo 'checked'?> />
            <label class="half" for="star2half" title="Kinda bad - 2.5 stars"></label>
            <input type="radio" id="star2" name="rating" value="2" <?php if($rating == '2') echo 'checked'?> />
            <label class = "full" for="star2" title="Kinda bad - 2 stars"></label>
            <input type="radio" id="star1half" name="rating" value="1.5" <?php if($rating == '1.5') echo 'checked'?> />
            <label class="half" for="star1half" title="Meh - 1.5 stars"></label>
            <input type="radio" id="star1" name="rating" value="1" <?php if($rating == '1') echo 'checked'?> />
            <label class = "full" for="star1" title="Sucks big time - 1 star"></label>
            <input type="radio" id="starhalf" name="rating" value="0.5" <?php if($rating == '0.5') echo 'checked'?> />
            <label class="half" for="starhalf" title="Sucks big time - 0.5 stars"></label>
          </fieldset></td>
      </tr>
      <tr>
        <td>Notes</td>
        <td>:</td>
        <td><textarea name="notes" id="notes" cols="35" rows="5"><?php echo $notes;?></textarea></td>
      </tr>
      <tr>
        <td></td>
        <td>&nbsp;</td>
        <td><br />
          <input name="submit" type="submit" id="submit" value="SUBMIT" class="btn" />
          <br>
          <br>
          <br>
          <?php echo "<a href=\"".$_SERVER['PHP_SELF']."?mode=delete&entryID=" . $entryID . "\" onClick=\"javascript:return confirm('Are you sure you want to delete  $biz_name?')\">Delete</a>" ?></td>
      </tr>
    </table>
  </form>
</div>
<?php elseif($mode == 'view') :?>
<?php unset($_SESSION['prompt']); ?>
<div class="viewEditBox">
  <?php
$query1 = "select * from $table_name WHERE installer_id = $entryID";
$result1=@mysqli_query($dbcnx, $query1);
while ($row = @mysqli_fetch_array($result1)) {
	
	$installer_id = "{$row['installer_id']}";
	$fname = "{$row['fname']}";
	$lname = "{$row['lname']}";
	$biz_name = "{$row['biz_name']}";
	$address = "{$row['address']}";
	$city = "{$row['city']}";
	$state = "{$row['state']}";
	$zip = "{$row['zip']}";
	$email = "{$row['email']}";
	$phone = "{$row['phone']}";
	$nationwide = "{$row['nationwide']}";
	$labor_rate = "{$row['labor_rate']}";
	$rating = "{$row['rating']}";
	$notes = "{$row['notes']}";

}
?>
  <table width="100%" border="0" cellspacing="3" cellpadding="2">
    <tr>
      <td valign="middle" align="left"><a href="/installers.php" class="addButton">Close</a></td>
      <td valign="middle" align="right"><a href="installers.php?mode=edit&entryID=<?php echo $entryID; ?>" class="addButton">Edit</a></td>
    </tr>
    <tr>
      <td colspan="2" align="left" valign="top" nowrap="nowrap"><h1><strong>Installer Name:</strong></h1>        <h2><?php echo $biz_name;?></h2></td>
    </tr>
    <tr>
      <td align="left" valign="top" nowrap="nowrap"><strong>First/Last Name:</strong></td>
      <td align="left" valign="top"><?php echo $fname." ".$lname;?></td>
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
      <td align="left" valign="top" nowrap="nowrap"><strong>Nationwide?</strong></td>
      <td align="left" valign="top"><?php echo $nationwide;?></td>
    </tr>
    <tr>
      <td align="left" valign="top" nowrap="nowrap"><strong>Rating</strong></td>
      <td align="left" valign="top"><fieldset class="rating">
            <input type="radio" id="star5" name="rating" value="5" <?php if($rating == '5') echo 'checked'?> disabled />
            <label class = "full" for="star5" title="Awesome - 5 stars"></label>
            <input type="radio" id="star4half" name="rating" value="4.5" <?php if($rating == '4.5') echo 'checked'?> disabled/>
            <label class="half" for="star4half" title="Pretty good - 4.5 stars"></label>
            <input type="radio" id="star4" name="rating" value="4" <?php if($rating == '4') echo 'checked'?> disabled/>
            <label class = "full" for="star4" title="Pretty good - 4 stars"></label>
            <input type="radio" id="star3half" name="rating" value="3.5" <?php if($rating == '3.5') echo 'checked'?> disabled/>
            <label class="half" for="star3half" title="Meh - 3.5 stars"></label>
            <input type="radio" id="star3" name="rating" value="3" <?php if($rating == '3') echo 'checked'?> disabled/>
            <label class = "full" for="star3" title="Meh - 3 stars"></label>
            <input type="radio" id="star2half" name="rating" value="2.5" <?php if($rating == '2.5') echo 'checked'?> disabled/>
            <label class="half" for="star2half" title="Kinda bad - 2.5 stars"></label>
            <input type="radio" id="star2" name="rating" value="2" <?php if($rating == '2') echo 'checked'?> disabled/>
            <label class = "full" for="star2" title="Kinda bad - 2 stars"></label>
            <input type="radio" id="star1half" name="rating" value="1.5" <?php if($rating == '1.5') echo 'checked'?> disabled/>
            <label class="half" for="star1half" title="Meh - 1.5 stars"></label>
            <input type="radio" id="star1" name="rating" value="1" <?php if($rating == '1') echo 'checked'?> disabled/>
            <label class = "full" for="star1" title="Sucks big time - 1 star"></label>
            <input type="radio" id="starhalf" name="rating" value="0.5" <?php if($rating == '0.5') echo 'checked'?> disabled/>
            <label class="half" for="starhalf" title="Sucks big time - 0.5 stars"></label>
          </fieldset></td>
    </tr>
    <tr>
      <td align="left" valign="top" nowrap="nowrap"><strong>Labor Rate</strong></td>
      <td align="left" valign="top"><?php echo $labor_rate;?></td>
    </tr>
    <tr>
      <td align="left" valign="top" nowrap="nowrap"><strong>Notes</strong></td>
      <td align="left" valign="top"><?php echo $notes;?></td>
    </tr>
  </table>
</div>
<?php  else: // Default page display ?>
<div class="statesTable">
  <select onChange="MM_jumpMenu('parent',this,1)">
    <option selected="SELECTED">Installers by State</option>
    <option value="installers.php">SHOW ALL</option>
    <option value="installers.php?stater=AL">ALABAMA</option>
    <option value="installers.php?stater=AK">ALASKA</option>
    <option value="installers.php?stater=AZ">ARIZONA</option>
    <option value="installers.php?stater=AR">ARKANSAS</option>
    <option value="installers.php?stater=CA">CALIFORNIA</option>
    <option value="installers.php?stater=CO">COLORADO</option>
    <option value="installers.php?stater=CT">CONNECTICUT</option>
    <option value="installers.php?stater=DE">DELAWARE</option>
    <option value="installers.php?stater=DC">DISTRICT OF COLUMBIA</option>
    <option value="installers.php?stater=FL">FLORIDA</option>
    <option value="installers.php?stater=GA">GEORGIA</option>
    <option value="installers.php?stater=HI">HAWAII</option>
    <option value="installers.php?stater=ID">IDAHO</option>
    <option value="installers.php?stater=IL">ILLINOIS</option>
    <option value="installers.php?stater=IN">INDIANA</option>
    <option value="installers.php?stater=IA">IOWA</option>
    <option value="installers.php?stater=KS">KANSAS</option>
    <option value="installers.php?stater=KY">KENTUCKY</option>
    <option value="installers.php?stater=LA">LOUISIANA</option>
    <option value="installers.php?stater=ME">MAINE</option>
    <option value="installers.php?stater=MD">MARYLAND</option>
    <option value="installers.php?stater=MA">MASSACHUSETTS</option>
    <option value="installers.php?stater=MI">MICHIGAN</option>
    <option value="installers.php?stater=MN">MINNESOTA</option>
    <option value="installers.php?stater=MS">MISSISSIPPI</option>
    <option value="installers.php?stater=MO">MISSOURI</option>
    <option value="installers.php?stater=MT">MONTANA</option>
    <option value="installers.php?stater=NE">NEBRASKA</option>
    <option value="installers.php?stater=NV">NEVADA</option>
    <option value="installers.php?stater=NH">NEW HAMPSHIRE</option>
    <option value="installers.php?stater=NJ">NEW JERSEY</option>
    <option value="installers.php?stater=NM">NEW MEXICO</option>
    <option value="installers.php?stater=NY">NEW YORK</option>
    <option value="installers.php?stater=NC">NORTH CAROLINA</option>
    <option value="installers.php?stater=ND">NORTH DAKOTA</option>
    <option value="installers.php?stater=OH">OHIO</option>
    <option value="installers.php?stater=OK">OKLAHOMA</option>
    <option value="installers.php?stater=OR">OREGON</option>
    <option value="installers.php?stater=PA">PENNSYLVANIA</option>
    <option value="installers.php?stater=RI">RHODE ISLAND</option>
    <option value="installers.php?stater=SC">SOUTH CAROLINA</option>
    <option value="installers.php?stater=SD">SOUTH DAKOTA</option>
    <option value="installers.php?stater=TN">TENNESSEE</option>
    <option value="installers.php?stater=TX">TEXAS</option>
    <option value="installers.php?stater=UT">UTAH</option>
    <option value="installers.php?stater=VT">VERMONT</option>
    <option value="installers.php?stater=VA">VIRGINIA</option>
    <option value="installers.php?stater=WA">WASHINGTON</option>
    <option value="installers.php?stater=WV">WEST VIRGINIA</option>
    <option value="installers.php?stater=WI">WISCONSIN</option>
    <option value="installers.php?stater=WY">WYOMING</option>
  </select>
</div>
<?php 

if (isset($_REQUEST['stater'])) {
	echo "<h1>Installers in: ".$_REQUEST['stater']."</h1>";
}
echo '<table cellpadding="2" cellspacing="2" border="0"><tr><td>';
//echo '<a href="' . $_SERVER['PHP_SELF'] . '?mode=add" class="addButton">Add Entry</a>';
//echo '</td><td>';
echo $showAll;
echo '</td></tr></table>';
echo '<br>'; 
echo '<form action="installers.php" method="get">Search: <input type="text" name="q" id="q"><input type="hidden" name="mode" value="search"><input type="submit"></form>';
echo '<br>'; 
echo '<br>'; 

$targetpage = "installers.php"; 	
$limit = 100; 
	
	if($mode == 'search') {
		$query = "SELECT COUNT(*) as num FROM $table_name WHERE 
		fname LIKE '%" . $q .  "%' 
		OR lname LIKE '%" . $q ."%' 
		OR biz_name LIKE '%" . $q ."%' 
		OR address LIKE '%" . $q ."%' 
		OR city LIKE '%" . $q ."%' 
		OR state LIKE '%" . $q ."%' 
		OR zip LIKE '%" . $q ."%' 
		";
	} else {
		$query = "SELECT COUNT(*) as num FROM $table_name";
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
		fname LIKE '%" . $q .  "%' 
		OR lname LIKE '%" . $q ."%' 
		OR biz_name LIKE '%" . $q ."%' 
		OR address LIKE '%" . $q ."%' 
		OR city LIKE '%" . $q ."%' 
		OR state LIKE '%" . $q ."%' 
		OR zip LIKE '%" . $q ."%' 
		 ORDER BY fname ASC
		 LIMIT $start, $limit";
	} else {
		if (isset($_REQUEST['stater'])) {
			$stater = $_REQUEST['stater'];
			$query1 = "SELECT * FROM $table_name WHERE state LIKE '%" . $stater .  "%' OR nationwide='yes' ORDER BY fname ASC ";
		} else {
			$query1 = "SELECT * FROM $table_name ORDER BY rating DESC LIMIT $start, $limit ";
		}
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
		unset($_SESSION['prompt']);
		echo '<strong>SEARCH RESULTS FOR: </strong> <span class="searchResultsText">'.$q.'</span><br>'. $total_pages.' Results';
	} else {
		//echo $total_pages.' Results';	
	}// pagination
 echo $paginate;
 

	//--> change every other row color
 	$color1 = "#eaeaea"; 
	$color2 = "#ffffff"; 
	$row_count = 0; 
	$starID = 1;
	echo"<table cellspacing=\"2\" cellpadding=\"4\" border=\"0\" width=\"100%\">";
	echo "<tr>";	
	echo "<td class=\"visitorsTableHdr2\"  nowrap>Details</td>"; 
	echo "<td class=\"visitorsTableHdr2\"  nowrap>Rating</td>"; 
	echo "<td class=\"visitorsTableHdr2\"  nowrap>Business Name</td>";  
	echo "<td class=\"visitorsTableHdr2\"  nowrap>Phone</td>";  
	echo "<td class=\"visitorsTableHdr2\"  nowrap>City</td>";  
	echo "<td class=\"visitorsTableHdr2\"  nowrap>State</td>"; 
	echo "<td class=\"visitorsTableHdr2\"  nowrap>Zip</td>"; 
	echo "<td class=\"visitorsTableHdr2\" width=\"1%\" nowrap>Nationwide?</td>"; 
	echo "<td class=\"visitorsTableHdr2\"  nowrap>Email</td>"; 
	//echo "<td class=\"visitorsTableHdr2\" style=\"background-color:#dd0000;\" width=\"1%\" nowrap>Delete?</td>"; 
	echo "</tr>";
	
	while($row = mysqli_fetch_array($result)){ 
	 	
	$row_color = ($row_count % 2) ? $color1 : $color2;
    $installer_id = "{$row['installer_id']}";
	$fname = "{$row['fname']}";
	$lname = "{$row['lname']}";
	$city = "{$row['city']}";
	$state = "{$row['state']}";
	$zip = "{$row['zip']}";
	$email = "{$row['email']}";
	$phone = "{$row['phone']}";
	$biz_name = "{$row['biz_name']}";
	
	if ($biz_name == "") {
		$biz_name = $fname." ".$lname;
	}
	
	$nationwide = "{$row['nationwide']}";
	$rating = "{$row['rating']}";
	
	if ($rating =="5") {
		$var5 = "checked";
		$var45 = " ";
		$var4 = " ";
		$var35 = " ";
		$var3 = " ";
		$var25 = " ";
		$var2 = " ";
		$var15 = " ";
		$var1 = " ";
		$var05 = " ";
	} else if ($rating =="4.5") {
		$var5 = " ";
		$var45 = "checked";
		$var4 = " ";
		$var35 = " ";
		$var3 = " ";
		$var25 = " ";
		$var2 = " ";
		$var15 = " ";
		$var1 = " ";
		$var05 = " ";
	} else if ($rating =="4") {
		$var5 = " ";
		$var45 = " ";
		$var4 = "checked";
		$var35 = " ";
		$var3 = " ";
		$var25 = " ";
		$var2 = " ";
		$var15 = " ";
		$var1 = " ";
		$var05 = " ";
	} else if ($rating =="3.5") {
		$var5 = " ";
		$var45 = " ";
		$var4 = " ";
		$var35 = "checked";
		$var3 = " ";
		$var25 = " ";
		$var2 = " ";
		$var15 = " ";
		$var1 = " ";
		$var05 = " ";
	} else if ($rating =="3") {
		$var5 = " ";
		$var45 = " ";
		$var4 = " ";
		$var35 = " ";
		$var3 = "checked";
		$var25 = " ";
		$var2 = " ";
		$var15 = " ";
		$var1 = " ";
		$var05 = " ";
	} else if ($rating =="2.5") {
		$var5 = " ";
		$var45 = " ";
		$var4 = " ";
		$var35 = " ";
		$var3 = " ";
		$var25 = "checked";
		$var2 = " ";
		$var15 = " ";
		$var1 = " ";
		$var05 = " ";
	} else if ($rating =="2") {
		$var5 = " ";
		$var45 = " ";
		$var4 = " ";
		$var35 = " ";
		$var3 = " ";
		$var25 = " ";
		$var2 = "checked";
		$var15 = " ";
		$var1 = " ";
		$var05 = " ";
	} else if ($rating =="1.5") {
		$var5 = " ";
		$var45 = " ";
		$var4 = " ";
		$var35 = " ";
		$var3 = " ";
		$var25 = " ";
		$var2 = " ";
		$var15 = "checked";
		$var1 = " ";
		$var05 = " ";
	} else if ($rating =="1") {
		$var5 = " ";
		$var45 = " ";
		$var4 = " ";
		$var35 = " ";
		$var3 = " ";
		$var25 = " ";
		$var2 = " ";
		$var15 = " ";
		$var1 = "checked";
		$var05 = " ";
	} else if ($rating =="0.5") {
		$var5 = " ";
		$var45 = " ";
		$var4 = " ";
		$var35 = " ";
		$var3 = " ";
		$var25 = " ";
		$var2 = " ";
		$var15 = " ";
		$var1 = " ";
		$var05 = "checked";
	}
		
	
			
  echo "<tr>";
	 echo "<td bgcolor=\"$row_color\" class=\"visitorsTableRow\"    nowrap><a href=\"" . $_SERVER['PHP_SELF'] . 
      "?mode=view&entryID={$row['installer_id']}\" nowrap>Details</a></td>";
	echo "<td bgcolor=\"$row_color\" class=\"visitorsTableRow\"   nowrap><b>$rating</b></td>";  
	/*echo "<td bgcolor=\"$row_color\" class=\"visitorsTableRow\" nowrap>
    <fieldset class=\"rating\" id=\"".$biz_name."\">
            <input type=\"radio\" id=\"star5".$starID."\" name=\"rating\" value=\"5\" ".$var5." disabled  />
            <label class = \"full\" for=\"star5".$starID."\" title=\"Awesome - 5 stars\"></label>
            <input type=\"radio\" id=\"star4half".$starID."\" name=\"rating\" value=\"4.5\" ".$var45." disabled />
            <label class=\"half\" for=\"star4half".$starID."\" title=\"Pretty good - 4.5 stars\"></label>
            <input type=\"radio\" id=\"star4".$starID."\" name=\"rating\" value=\"4\"  ".$var4." disabled />
            <label class = \"full\" for=\"star4".$starID."\" title=\"Pretty good - 4 stars\"></label>
            <input type=\"radio\" id=\"star3half".$starID."\" name=\"rating\" value=\"3.5\"  ".$var35." disabled />
            <label class=\"half\" for=\"star3half".$starID."\" title=\"Meh - 3.5 stars\"></label>
            <input type=\"radio\" id=\"star3".$starID."\" name=\"rating\" value=\"3\"  ".$var3." disabled />
            <label class = \"full\" for=\"star3".$starID."\" title=\"Meh - 3 stars\"></label>
            <input type=\"radio\" id=\"star2half".$starID."\" name=\"rating\" value=\"2.5\"  ".$var25." disabled />
            <label class=\"half\" for=\"star2half".$starID."\" title=\"Kinda bad - 2.5 stars\"></label>
            <input type=\"radio\" id=\"star2".$starID."\" name=\"rating\" value=\"2\"  ".$var2." disabled />
            <label class = \"full\" for=\"star2".$starID."\" title=\"Kinda bad - 2 stars\"></label>
            <input type=\"radio\" id=\"star1half".$starID."\" name=\"rating\" value=\"1.5\"  ".$var15." disabled />
            <label class=\"half\" for=\"star1half".$starID."\" title=\"Meh - 1.5 stars\"></label>
            <input type=\"radio\" id=\"star1".$starID."\" name=\"rating\" value=\"1\"  ".$var1." disabled />
            <label class = \"full\" for=\"star1".$starID."\" title=\"Sucks big time - 1 star\"></label>
            <input type=\"radio\" id=\"starhalf".$starID."\" name=\"rating\" value=\"0.5\"  ".$var05." disabled />
            <label class=\"half\" for=\"starhalf".$starID."\" title=\"Sucks big time - 0.5 stars\"></label>
          </fieldset>
    </td>";  */
	echo "<td bgcolor=\"$row_color\" class=\"visitorsTableRow\"   nowrap><b>$biz_name</b></td>";  
	echo "<td bgcolor=\"$row_color\" class=\"visitorsTableRow\"   nowrap>$phone</td>";  
	echo "<td bgcolor=\"$row_color\" class=\"visitorsTableRow\"   nowrap>$city</td>";  
	echo "<td bgcolor=\"$row_color\" class=\"visitorsTableRow\"   nowrap>$state</td>";  
	echo "<td bgcolor=\"$row_color\" class=\"visitorsTableRow\"   nowrap>$zip</td>";  
	echo "<td bgcolor=\"$row_color\" class=\"visitorsTableRow\"   nowrap>$nationwide</td>";  
	echo "<td bgcolor=\"$row_color\" class=\"visitorsTableRow\"   nowrap><a href=\"mailto:$email\">$email</a></td>";  
	 
	echo "</tr>";
	
	$row_count++;
	$starID++;
	unset($rating);
	unset($var05);
	unset($var1);
	unset($var15);
	unset($var2);
	unset($var25);
	unset($var3);
	unset($var35);
	unset($var4);
	unset($var45);
	unset($var5);
  } 
  
  	echo "</table>";
	echo $paginate;
 	echo "<br>";



 ?>
<?php endif; ?>
<script>
$('#alert').fadeIn('fast').delay(7000).fadeOut('fast');
</script>


</body>
</html>
