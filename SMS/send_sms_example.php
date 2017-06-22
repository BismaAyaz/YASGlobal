<?php

$client_number = '+923352244651';

$message = 'Hello Message Testing using NEXMO. This is Trial Version and work only for one number. Once Paid Started working on any number';

$ret = send_sms($client_number, $message);




function send_sms($mobile, $message)
{
	
	$mobile = preg_replace("/[^0-9]/", "", $mobile); //Remove all special characters like - + Space from the mobile number
	
	$base_url = "https://rest.nexmo.com/sms/json?";

	$params = array();

	$params['api_key'] = '53591a61';
	$params['api_secret'] = '557577776f21d3ac';
	$params['from'] = "NEXMO";
	$params['to'] = $mobile;
	$params['status-report-req'] = '1';  // Send status report to the Delivery Recipt URL (  http://sapnaedu.in/sms_delivery.php )
	$params['client-ref'] = '123456|Client-rambo456';  // Client Reference. This parameter is passed as-is to the Delivery Recipt URL 

	$params['text'] = $message;

	$params1 = http_build_query($params);
		
	$url = $base_url  . $params1;
	
	//Call the URL 
	$result = call_nexmo_url($url);
	var_dump($result);

	//Handle the delivery Response
	$message_count = $result['message-count'];
	$resultArr =  $result['messages'];
	
	$retArr = array();
	$retArr['status'] = 'failure';
	$retArr['balance'] = -1;
	$retArr['sms_cost'] = -1;
	$retArr['message'] = '';
	
	$success = 1;
	
	if($resultArr)
	{
		//To handle multiple SMS if the SMS lenght is greater than 160 characters
		foreach($resultArr as $row)
		{
			if($row['status'] == 0)
			{
				$retArr['status'] = 'success';
				$retArr['balance'] = $row['remaining-balance'];
				$retArr['sms_cost'] = $row['message-price'];
			}
			else
			{
				$retArr['message'] = $row['error-text'];
				//TODO : Handle Error message, Send Email to Admin
				//mail()
				$success = 0;
			}
		}
	}
	
	//Return success to indicate if the SMS was sent successfully
	return $success;
}



function call_nexmo_url($url1)
{
	try 
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url1);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
	
		curl_setopt($ch, CURLOPT_CAINFO, dirname(__FILE__) . '/cacert.pem');

		$result = curl_exec($ch);
		//var_dump($result);
		
		$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		
		if($httpCode == 404) 
		{
			/* Handle 404 here. */
			echo "Error";
		}
		

		if (FALSE === $result)
		{
			throw new Exception(curl_error($ch), curl_errno($ch));
		}
		
		curl_close($ch);
	
		$response = json_decode($result, true); 
		
	}
	catch(Exception $e) 
	{
		$response = $e->getCode() . " " .  $e->getMessage();
	}
	return $response;
}


?>