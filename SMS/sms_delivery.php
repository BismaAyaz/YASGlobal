<?php

//$response=$_REQUEST;
$frm = $_GET;


$client_ref = $frm['client-ref'];
if(isset($client_ref))
{
	$status = $frm['status'];
	$price = $frm['price'];
	$err = $frm['err-code'];
	$ref = explode('|', $client_ref);
	
	$userid = $ref[0];
	$sms_id = $ref[1];
	
	//TODO 
	//Update the Database may be, if there is any error
	/*
	$q = "update sms_sent set 
		`status`='" . $status .  "',
		`price`='" . $price .  "',
		`err_code`='" . $err .  "' where `id`='" . $sms_id . "'";
	$db->query($q);
	
	*/
	
	if( ( $status == 'failed' ) || ($status =='failure'))
	{
		//TODO : Handle Error message, Send Email to Admin
		//mail()
		//Failure
		
	}
	
	
	####LOG THE MESSAGE#####

	$text = "";
	foreach ($frm as $key=>$value) 
	{
		$text .= "$key=$value, \n";
	}
	$log_file = '.sms_log.txt';

	$fp=fopen($log_file,'a');
	fwrite($fp, $text . "\n\n");
	fclose($fp);  // close file
		
}


?>