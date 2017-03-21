<?php
session_start();

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

## database definitions 
define('DB_DATABASE','databaseName');
define('DB_HOST','localhost');
define('DB_USERNAME','username');
define('DB_PASSWORD','password');


/****************************************************************************************
** Function: runQuery                                                                  **
** Input: SQL statement, Mode, Database name - $sql, $mode, $database                  **
** Output: SQL Query Results or ID - $result, $id                                      **
****************************************************************************************/
function runQuery($sql, $mode = 'read', $database = DB_DATABASE) {
	$conn = mysql_connect(DB_HOST, DB_USERNAME, DB_PASSWORD) or die(mysql_error());
	mysql_select_db($database, $conn) or die(mysql_error());
	$error_desc = ($_GET['debugsql'] == 'true' ? "<pre>".$sql."</pre><br>Bad Query:" : "Bad Query:");
	$result = mysql_query($sql, $conn) or die ($error_desc . mysql_error()); 
	#$result = mysql_query($sql, $conn); 
	$id = mysql_insert_id();
	mysql_close();
	switch ($mode) {
		case 'write':
			return $id;
			break;
		case 'read':
			return $result;
			break;
	}
}


function setUserVars($userID){
	$sql = "SELECT * FROM 3G_users AS u WHERE user_id = '".$userID."' AND active = 1 LIMIT 1";
	$rs = runQuery($sql);
	$r = mysql_fetch_assoc($rs);
	
	$_SESSION['user']['id'] = $r['user_id'];
	$_SESSION['user']['user_id'] = $r['user_id'];		
	$_SESSION['user']['authorized'] = TRUE;		
	$_SESSION['user']['login_time'] = date('Y-m-d H:i:s');
	$_SESSION['user']['fname'] = $r['fname'];
	$_SESSION['user']['lname'] = $r['lname'];
	$_SESSION['user']['email'] = $r['email'];
	$_SESSION['user']['user_type'] = $r['user_type'];
}

function authUser($accessLevels){
	$next = getNextURL();

	if(empty($_SESSION['user']['authorized'])) {
		header("Location: /login.php?next=".$next);
		exit;
	} else {
		$levels = explode(',',$accessLevels);
		if(!in_array($_SESSION['user']['user_type'],$levels)){
			header("Location: /login.php?next=".$next);
			exit;			
		}
	}
}

function getNextURL(){
	$next = substr($_SERVER['REQUEST_URI'],1);
	$next = str_replace('members/','',$next); //cleans up the value when running on localhost
	$next = str_replace('&','==AMP==',$next);
	return $next;
}


?>