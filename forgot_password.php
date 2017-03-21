<?php

include('config.php');

?>

<html>
<head>
<title>3G Cardio User Login</title>
<meta http-equiv="Content-Type" 
content="text/html; charset=ISO-8859-1" />
<link href="styles.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="https://code.jquery.com/ui/1.11.0/themes/smoothness/jquery-ui.css">
<script src="https://code.jquery.com/jquery-1.10.2.js"></script>
<script src="https://code.jquery.com/ui/1.11.0/jquery-ui.js"></script>
<script src="poppers.js"></script>
<link rel="stylesheet" href="/resources/demos/style.css">
</head>

<body class="adminbody" onLoad='document.forms[1].<?=$fieldFocus?>.focus();document.forms[1].<?=$fieldFocus?>.select();'>

        <?php include 'hdr-login.php'; ?>
    
        <div class="marginCentered searchCreateTix">
    
    <?PHP
ini_set('display_errors',0);


$show_form = TRUE;
$show_errors = FALSE;
$success = FALSE;

if(isset($_POST['email'])){
	
	$email = $_POST['email']; 
	
	//validate
	//if(!preg_match(REGEX_EMAIL, $email)) {
		//	$errors[] = "Email is not fomatted properly";
	//}

	if($email == "") {
		$errors[] = "Please enter an email address";
	}
	
	if(count($errors) > 0) {
		$show_errors = TRUE; // if there are errors, then show the error box
	} else {
		$query  = "SELECT * FROM 3G_users WHERE email='$email' LIMIT 1 ";         
		$result = runQuery($query);

		if(mysql_num_rows($result) == 0){ 
        	echo("<div class='ErrorMessage'><p>That email address is not registered in our system. Please <a href='mailto:webmaster@3GCardio.com'>contact the webmaster</a> for assistance.</p></div>"); 
		} else {
			$row = mysql_fetch_assoc($result);
			$email = $row['email'];
	   		$password = $row['password'];
			if(empty($password)){
				$update = "UPDATE 3G_users SET password = '@tempPa33w0rD' WHERE email = '$email'";
				runQuery($update);
				$row = mysql_fetch_assoc(runQuery($query));
				$email = $row['email'];
				$password = $row['password'];
			}
	
	   		$subject = 'Your password reminder';
	   		$body = "Here is your login information:\n Email: $email \n Password: $password \n Login URL: http://www.3GCardio.com/orders/login.php";
			@mail($email, $subject, $body,"From: no-reply@3GCardio.com\r\n" ."CC: ");
			echo '<h2 class="prompt">Your password has been sent to your email.</h2> <a href="login.php"><p>Click Here to Login &raquo;</a></p>'; 
					
			$show_form = FALSE;	
		}		
	}
}


?>

<?php
	printErrors($errors,$show_errors);
?>
          <?php if($success) : ?>
          <br />
          <h1 align="center">Thank you.</h1><br />
            Your password has been sent to your email address. 
          <?php endif; ?>
          <?php if($show_form) : ?>

<h1>Password Recovery </h1>
<p>Enter your email address: </p>
<form name="form" style="display:inline;" action="<?=$_SERVER['PHP_SELF'];?>" method="post">
  <input name="email" type="text" id="email" />
    <input type="submit" name="submit" id="submit" value="Submit" />
  </form>
  <p>&nbsp;</p>
<?php endif; ?>
</div>

<?php


// it would be a good idea to put these in a globally included functions file
function printErrors($errors,$show_errors){
	if($show_errors) {
		print "<div class='ErrorMessage'><span style='font-size:18px; white-space:nowrap;'>Please correct the following errors:</span><br />";
		foreach($errors as $error)
			print "&bull; ".$error. "<br />";
		print "<br /><br /></div>";
	}	
}


?>

    
  </div>
</div>

</body>
</html>