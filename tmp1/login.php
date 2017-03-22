<?php
include 'config.php';

if(isset($_SESSION['user']['authorized'])) {
	header("Location: index.php");
	exit;
} 

if(isset($_POST['submit'])) {
	$email = $_POST['email'];
	$password = $_POST['password'];
	$validate = TRUE;
	
	if($validate){
		if(!preg_match("^([_A-Za-z0-9-]+)(\.[_A-Za-z0-9-]+)*@([A-Za-z0-9-]+)(\.[A-Za-z0-9-]+)*(\.[A-Za-z]{2,4})$^", $_POST['email'])) {
			$errors['email'] = "email is not formatted properly";
			if(!isset($fieldFocus)) $fieldFocus = 'email';
			$email_Err = TRUE;
		}
		
		if(strlen($_POST['password']) < 3) {
			$errors['password'] = "you must create a password";
			if(!isset($fieldFocus)) $fieldFocus = 'password';
			$password_Err = TRUE;
		}		
	}
	
	
	if(count($errors) < 1) {
		$sql = "SELECT * FROM 3G_users AS u 
				WHERE email = '".$email."' 
				AND password = '".$password."' 
				AND active = 1 LIMIT 1";

		$rs = runQuery($sql);
	
		if(mysql_num_rows($rs) > 0) {
			$r = mysql_fetch_assoc($rs);
			setUserVars($r['user_id']);
			
			switch($_SESSION['user']['user_type']){

				case 3:
					$url = 'index.php';			
					break;

				case 2:
					$url = 'index.php';			
					break;
	
				case 1:
					$url = 'index.php';
					break;
			}
								
			if(isset($_GET['next'])){
				$next = str_replace('==AMP==','&',$_GET['next']);
				$url = '/'.$next;
			}
			
			header("Location: ". $url);
			exit;
			#dump('next: ' . $next);
			#dump('url: ' . $url);
			#dump('logging in to: <a href="'.$url.'">'.$url.'</a>');
		} else {
			$errorPrompts['email'] = 'email and password combination does not exist. please try again.';
			if(!isset($fieldFocus)) $fieldFocus = 'password';		
		}
	} else {
		$errors['invalid_login'] = 'Invalid username or password';
		$show_prompt = TRUE;
		$prompt = $errors['invalid_login'];
	}	
} else {
	$fieldFocus = 'email';
}



?>
<html>
<head>
	<title>3G Cardio User Login</title>
	<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
	<link href="styles.css" rel="stylesheet" type="text/css">
	<link rel="stylesheet" href="//code.jquery.com/ui/1.11.0/themes/smoothness/jquery-ui.css">
	<script src="//code.jquery.com/jquery-1.10.2.js"></script>
	<script src="//code.jquery.com/ui/1.11.0/jquery-ui.js"></script>
	<script src="poppers.js"></script>
	<link rel="stylesheet" href="/resources/demos/style.css">
	</head>

<body class="adminbody" onLoad='document.forms[0].<?=$fieldFocus?>.focus();document.forms[0].<?=$fieldFocus?>.select();'>

        <?php include 'hdr-login.php'; ?>
        <h1 class="titleH1">Login</h1>
        <br>
        <div class="textCenter blue1"><?php if(isset($show_prompt)) print $prompt?></div>
        <div class="marginCentered searchCreateTix">
          <form  action="<?= $_SERVER['REQUEST_URI']?>" method="post">
          <table width="600" border="0" cellspacing="2" cellpadding="2" style="margin:0 auto;">
            <tbody>
              <tr>
                <td width="40%" align="right">Email Address:</td>
                <td width="60%"><input type="text" name="email" id="email" size="30" value="<?php echo $_POST['email']?>"></td>
              </tr>
              <tr>
                <td align="right" valign="top">Password:</td>
                <td><input type="password" name="password" id="password" size="30" value="<?php echo $_POST['password']?>">
                <br>
                <a href="forgot_password.php" class="fontSml2">Forgot Password?</a></td>
              </tr>
            </tbody>
          </table><br>
            <div class="temp1"><input type="submit" name="submit" value="Login" class="submitButton"></div>
            <br>
          </form>
        </div>
        <br>
</body>
</html>