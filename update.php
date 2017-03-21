<?php
$response = NULL;
$status = http_response_code(406);
if(!empty($_POST)){
    include "config.php"; //Including Database Settings
    foreach($_POST as $key=>$value){
        $key = strip_tags(trim($key));
        $value = strip_tags(trim($value));
        $explode = explode(":",$key);
        $user_id = $explode[1];
        $field_name = $explode[0];
        if(isset($user_id)){
            $update = mysql_query("UPDATE test1 SET $field_name='{$value}' WHERE id='$user_id'"); //Update the test1 Table
            $update = true;
            if($update){
                $response = "User Details Updated";
                http_response_code(200); //Setting HTTP Code to 200 i.e OK
            }else{
                $response = "Not Modified";
                http_response_code(304); //Setting HTTP Code to 304 i.e Not Modified
            }
        }else{
            $response = "Not Acceptable";
        }
    }
}
echo json_encode(array(
    "status"=>$status,
    "response"=>$response
));