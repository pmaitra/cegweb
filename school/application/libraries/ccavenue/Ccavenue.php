<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ccavenue {
    
    const MARCHENT_ID = '137116';
    const WORKING_KEY = 'FDE880ADE5DAF2FDDB7AAE55C47CA1FF';
    const ACCESS_CODE = 'AVJC71EF24AM45CJMA';
    
    function submission($param)
    {
        // Success page URL
        $redirect_url=$param['return_url'];
        $cancel_url="http://qtsin.net/webiq/home/paycancel";

        $PG['custom_data']['tid'] = time();
        $PG['custom_data']['merchant_id'] = self::MARCHENT_ID;
        $PG['custom_data']['order_id'] = $param['application_id'];
        $PG['custom_data']['amount'] = $param['amount'];
        $PG['custom_data']['currency'] = 'INR';
        $PG['custom_data']['redirect_url'] = $redirect_url;
        $PG['custom_data']['cancel_url'] = $cancel_url;
        $PG['custom_data']['language'] = 'EN';

        //Billing
        $PG['custom_data']['billing_name'] = $param['candidate_details']['first_name'].' '.$param['candidate_details']['middle_name'].' '.$param['candidate_details']['last_name'];
        $PG['custom_data']['billing_address'] = $param['candidate_address']['street_address'].' '.$param['candidate_address']['address_line_2'];
        $PG['custom_data']['billing_city'] = $param['candidate_address']['city'];
        $PG['custom_data']['billing_state'] = $param['candidate_address']['state'];
        $PG['custom_data']['billing_zip'] = $param['candidate_address']['postal_code'];
        $PG['custom_data']['billing_country'] = getCountryById($param['candidate_address']['county_id']);
        $PG['custom_data']['billing_tel'] = $param['candidate_address']['mobile_no'];
        $PG['custom_data']['billing_email'] =  $param['candidate_details']['email_id'];

        // Shipping/Delivery
        $PG['custom_data']['delivery_name'] =  $param['candidate_details']['first_name'].' '.$param['candidate_details']['middle_name'].' '.$param['candidate_details']['last_name'];
        $PG['custom_data']['delivery_address'] = '';
        $PG['custom_data']['delivery_city'] = '';
        $PG['custom_data']['delivery_state'] = '';
        $PG['custom_data']['delivery_zip'] = '';
        $PG['custom_data']['delivery_country'] = 'IN';
        $PG['custom_data']['delivery_tel'] = $param['candidate_address']['mobile_no'];
        $PG['custom_data']['delivery_email'] = $param['candidate_details']['email_id'];;

        //Additional
        $PG['custom_data']['merchant_param1'] = $param['application_id'];
        $PG['custom_data']['merchant_param2'] = $param['amount'];
        $PG['custom_data']['merchant_param3'] = 2; //coupon id
        $PG['custom_data']['merchant_param4'] = 3;
        $PG['custom_data']['merchant_param5'] = 3 ; //coupon code;
        $merchant_data='';
        
        foreach ($PG['custom_data'] as $key => $value) 
        {
            $merchant_data.=$key . '=' . $value . '&';
        }

        $encrypted_data = $this->encrypt($merchant_data, self::WORKING_KEY); // Method for encrypting the data.        
        
        $production_url = 'https://secure.ccavenue.com/transaction/transaction.do?command=initiateTransaction&encRequest=' . $encrypted_data . '&access_code=' . self::ACCESS_CODE;

                    redirect($production_url);
        }
        
    function donationSubmission($param)
    {
        // Success page URL
        $redirect_url=$param['return_url'];
        $cancel_url="http://qtsin.net/webiq/home/paycancel";

        $PG['custom_data']['tid'] = time();
        $PG['custom_data']['merchant_id'] = self::MARCHENT_ID;
        $PG['custom_data']['order_id'] = $param['donationid'];
        $PG['custom_data']['amount'] = $param['amount'];
        $PG['custom_data']['currency'] = 'INR';
        $PG['custom_data']['redirect_url'] = $redirect_url;
        $PG['custom_data']['cancel_url'] = $cancel_url;
        $PG['custom_data']['language'] = 'EN';

        //Billing
        $PG['custom_data']['billing_name'] = $param['donation_details']['first_name'].' '.$param['donation_details']['last_name'];
        $PG['custom_data']['billing_address'] = $param['donation_details']['address'];
        $PG['custom_data']['billing_city'] = '';
        $PG['custom_data']['billing_state'] = '';
        $PG['custom_data']['billing_zip'] = '';
        $PG['custom_data']['billing_address'] = '';
        $PG['custom_data']['billing_city'] = '';
        $PG['custom_data']['billing_state'] = '';
        $PG['custom_data']['billing_zip'] = '';
        $PG['custom_data']['billing_country'] = '';
        $PG['custom_data']['billing_tel'] = $param['donation_details']['phone_no'];
        $PG['custom_data']['billing_email'] =  $param['donation_details']['email_id'];

        // Shipping/Delivery
        $PG['custom_data']['delivery_name'] =  $param['donation_details']['first_name'].' '.$param['donation_details']['last_name'];
        $PG['custom_data']['delivery_address'] = $param['donation_details']['address'];
        $PG['custom_data']['delivery_city'] = '';
        $PG['custom_data']['delivery_state'] = '';
        $PG['custom_data']['delivery_zip'] = '';
        $PG['custom_data']['delivery_country'] = 'IN';
        $PG['custom_data']['delivery_tel'] = $param['donation_details']['phone_no'];
        $PG['custom_data']['delivery_email'] = $param['donation_details']['email_id'];;

        //Additional
        $PG['custom_data']['merchant_param1'] = $param['donationid'];
        $PG['custom_data']['merchant_param2'] = $param['donation_details']['amount'];
        $PG['custom_data']['merchant_param3'] = 2; //coupon id
        $PG['custom_data']['merchant_param4'] = 3;
        $PG['custom_data']['merchant_param5'] = 3 ; //coupon code;
        $merchant_data='';
        //pr($PG['custom_data']);
        foreach ($PG['custom_data'] as $key => $value) 
        {
            $merchant_data.=$key . '=' . $value . '&';
        }

        $encrypted_data = $this->encrypt($merchant_data, self::WORKING_KEY); // Method for encrypting the data.        
        
        $production_url = 'https://secure.ccavenue.com/transaction/transaction.do?command=initiateTransaction&encRequest=' . $encrypted_data . '&access_code=' . self::ACCESS_CODE;

                    redirect($production_url);
        }
        
    function semesterPaymentSubmission($param)
    {
        // Success page URL
        $redirect_url=$param['return_url'];
        $cancel_url="http://qtsin.net/webiq/home/paycancel";

        $PG['custom_data']['tid'] = time();
        $PG['custom_data']['merchant_id'] = self::MARCHENT_ID;
        $PG['custom_data']['order_id'] = $param['application_id'];
        $PG['custom_data']['amount'] = $param['amount'];
        $PG['custom_data']['currency'] = 'INR';
        $PG['custom_data']['redirect_url'] = $redirect_url;
        $PG['custom_data']['cancel_url'] = $cancel_url;
        $PG['custom_data']['language'] = 'EN';

        //Billing
        $PG['custom_data']['billing_name'] = $param['candidate_details']['first_name'].' '.$param['candidate_details']['middle_name'].' '.$param['candidate_details']['last_name'];
        $PG['custom_data']['billing_address'] = $param['candidate_address']['street_address'].' '.$param['candidate_address']['address_line_2'];
        $PG['custom_data']['billing_city'] = $param['candidate_address']['city'];
        $PG['custom_data']['billing_state'] = $param['candidate_address']['state'];
        $PG['custom_data']['billing_zip'] = $param['candidate_address']['postal_code'];
        $PG['custom_data']['billing_country'] = 'IN';
        $PG['custom_data']['billing_tel'] = $param['candidate_details']['contact_number'];
        $PG['custom_data']['billing_email'] =  $param['candidate_details']['email_id'];

        // Shipping/Delivery
        $PG['custom_data']['delivery_name'] =  $param['candidate_details']['first_name'].' '.$param['candidate_details']['middle_name'].' '.$param['candidate_details']['last_name'];
        $PG['custom_data']['delivery_address'] = $param['candidate_address']['street_address'].' '.$param['candidate_address']['address_line_2'];
        $PG['custom_data']['delivery_city'] = $param['candidate_address']['city'];
        $PG['custom_data']['delivery_state'] = $param['candidate_address']['state'];
        $PG['custom_data']['delivery_zip'] = $param['candidate_address']['postal_code'];
        $PG['custom_data']['delivery_country'] = 'IN';
        $PG['custom_data']['delivery_tel'] = $param['candidate_details']['contact_number'];
        $PG['custom_data']['delivery_email'] = $param['candidate_details']['email_id'];;

        //Additional
        $PG['custom_data']['merchant_param1'] = $param['application_id'];
        $PG['custom_data']['merchant_param2'] = $param['amount'];
        $PG['custom_data']['merchant_param3'] = 2; //coupon id
        $PG['custom_data']['merchant_param4'] = 3;
        $PG['custom_data']['merchant_param5'] = 3 ; //coupon code;
        $merchant_data='';
        //pr($PG['custom_data']);
        foreach ($PG['custom_data'] as $key => $value) 
        {
            $merchant_data.=$key . '=' . $value . '&';
        }

        $encrypted_data = $this->encrypt($merchant_data, self::WORKING_KEY); // Method for encrypting the data.        
        
        $production_url = 'https://secure.ccavenue.com/transaction/transaction.do?command=initiateTransaction&encRequest=' . $encrypted_data . '&access_code=' . self::ACCESS_CODE;

                    redirect($production_url);
    }    


        
        function encrypt($plainText,$key)
	{
		$secretKey = $this->hextobin(md5($key));
		$initVector = pack("C*", 0x00, 0x01, 0x02, 0x03, 0x04, 0x05, 0x06, 0x07, 0x08, 0x09, 0x0a, 0x0b, 0x0c, 0x0d, 0x0e, 0x0f);
	  	$openMode = mcrypt_module_open(MCRYPT_RIJNDAEL_128, '','cbc', '');
	  	$blockSize = mcrypt_get_block_size(MCRYPT_RIJNDAEL_128, 'cbc');
		$plainPad = $this->pkcs5_pad($plainText, $blockSize);
	  	if (mcrypt_generic_init($openMode, $secretKey, $initVector) != -1) 
		{
		      $encryptedText = mcrypt_generic($openMode, $plainPad);
	      	      mcrypt_generic_deinit($openMode);
		      			
		} 
		return bin2hex($encryptedText);
	}
        
        #################################################################

        ############ CC Avenue Payment Response Handler #################

        #################################################################

        function decrypt($encryptedText,$key)
	{
		$secretKey = $this->hextobin(md5($key));
		$initVector = pack("C*", 0x00, 0x01, 0x02, 0x03, 0x04, 0x05, 0x06, 0x07, 0x08, 0x09, 0x0a, 0x0b, 0x0c, 0x0d, 0x0e, 0x0f);
		$encryptedText=$this->hextobin($encryptedText);
	  	$openMode = mcrypt_module_open(MCRYPT_RIJNDAEL_128, '','cbc', '');
		mcrypt_generic_init($openMode, $secretKey, $initVector);
		$decryptedText = mdecrypt_generic($openMode, $encryptedText);
		$decryptedText = rtrim($decryptedText, "\0");
	 	mcrypt_generic_deinit($openMode);
		return $decryptedText;
		
	}
	//*********** Padding Function *********************

	 function pkcs5_pad ($plainText, $blockSize)
	{
	    $pad = $blockSize - (strlen($plainText) % $blockSize);
	    return $plainText . str_repeat(chr($pad), $pad);
	}

	//********** Hexadecimal to Binary function for php 4.0 version ********

	function hextobin($hexString) 
   	{ 
        	$length = strlen($hexString); 
        	$binString="";   
        	$count=0; 
        	while($count<$length) 
        	{       
        	    $subString =substr($hexString,$count,2);           
        	    $packedString = pack("H*",$subString); 
        	    if ($count==0)
		    {
				$binString=$packedString;
		    } 
        	    
		    else 
		    {
				$binString.=$packedString;
		    } 
        	    
		    $count+=2; 
        	} 
  	        return $binString; 
    	} 
        
        public function payment_response()
        {
            try{
            ini_set('error_reporting', E_ALL);
            error_reporting(-1);
            ini_set("display_errors", 1);
            //$encResponse = $_POST["encResp"]; 
            //$encResponse = '6ed229717ff30b058da9b3189f26b3689c0edc97e0d0d5c4ed82f4b502cf29cb468fee30bfa001ecb8a0b95617e924b1354f0684358abdeba7bcffc011591cfac39f34344448675aa7718ec8f956149b8ca3ba69776e40b1c8363b121fbef4b9aab7fd331b7fd92c678e044a8a4205d981cf10f821402035e6a4c47fb2d8fc2e9996def1ac0d913824d1d232b00b69787789e24c35088992f362a8b2f3b96d31d9d9e4b6594ce0b3ed51b5bf7ffe3d52f3c3445d62d79b6e1ba62c83e188667f817d3e468bea53f919399407eaa3f0fa861f9c8558b69afd2aefa0954a919631870c20db4c9e2338318deb648da7f91abaa66690d777bcd1df86b6e23658ccb7f9173749dd1ff9979506b782155438673e798383ae8d7ac32f80c81c0882244b17ea9bdd9b104f6fd9710aedd2e5f6e7c4df8f979f6853c5b28e434782997c31e818d199821c67aab9cccd33bbe2498ee312c9d3d82b97d25d3df583b14528150b98076c83fd9f57cb6a19240ee1d006e4371edd8ecba6d89261ed9630377b89253f25c0e6dcb677601c4d02ec320fcb2ca79c968cdca7506c3812b7f7a8e62c946af589d9a5d93cc55fdfb84bd7c5b1e15bbd6caeac708facd40f7fea87b8cb18856ea57106fa937fe836da83b4fc70e8bd82b957e6ac93cc39c85db7048d7e1395f763f4450bf4b61b9d0a219b74ed13d32069a59ed49b9724bda174c21dd8e00fdc4662213d1860f81a4ab96972ade1a007bdac1999015b28238f14e705799fb3464ceb6ae340049b47949c03d9f75bcbbd0dbff58c2705bfa8e97ffc4e97084bb14404e1a01bb57645a818869045cbb05bb0b5757a3723180eaf712991a547d0a3c6765065fd543cde0f71ecea64732ab3cc0898b6329fa5283faec1cdc3e7d1b3093e83d55780dec09cb6b3dcfb7cd3e4e407221ea1a6ec7a2a727f5fe23644d97fc019da380599519c893b29aa200fee180effc19c1904ad1c341da753b09869f2e03e741ea2c7aa4012a9930e4f8439968ac81a2556e8c1ba39025003a827078945b28b77634a1872baf3e76d';
            //pr($encResponse);
            //This is the response sent by the CCAvenue Server
            //print_r($_POST["encResp"]);
            $rcvdString = $this->decrypt($encResponse, self::WORKING_KEY);  //Crypto Decryption used as per the specified working key.
            //pr($rcvdString);

            $decryptValues = explode('&', $rcvdString);
            $dataSize = sizeof($decryptValues);

            //$this->data['payment_response'] = array();

            $order_status = '';
            $order_id = '';
            $merchant_param2 = '';
            $payment_status_in_db = 'pending';
            $booking_status_in_db = 'pending';

            for ($i = 0; $i < $dataSize; $i++) {

                $information = explode('=', $decryptValues[$i]);

                if ($i == 0) {

                    $order_id = $information[1];

                }

                if ($i == 1) {

                    $tracking_id = $information[1];

                }

                if ($i == 2) {

                    $bank_ref_no = $information[1];

                }

                if ($i == 3) {

                    $order_status = $information[1];

                    if (strtolower($order_status) == 'success') {

                        $payment_status_in_db = 'successful';

                        $booking_status_in_db = 'successful';

                    }

                    if (strtolower($order_status) == 'aborted') {

                        $payment_status_in_db = 'cancelled';

                        $booking_status_in_db = 'failure';

                    }

                    if (strtolower($order_status) == 'failure') {

                        $payment_status_in_db = 'failure';

                        $booking_status_in_db = 'failure';

                    }

                }

                if ($i == 4) {

                    $failure_message = $information[1];

                }

                if ($i == 5) {

                    $payment_mode = $information[1];

                }

                if ($i == 6) {

                    $card_name = $information[1];

                }

                if ($i == 7) {

                    $status_code = $information[1];

                }

                if ($i == 8) {

                    $status_message = $information[1];

                }

                if ($i == 9) {

                    $currency = $information[1];

                }

                if ($i == 10) {

                    $amount = $information[1];

                }

                if ($i == 26) {

                    $merchant_param1 = $information[1]; // order_id (primary key)

                }

                if ($i == 27) {

                    $merchant_param2 = $information[1]; // log file name

                }

                if ($i == 28) {

                    $merchant_param3 = $information[1]; // applied coupon id

                }

                if ($i == 29) {

                    $merchant_param4 = $information[1]; // session id

                }

                if ($i == 30) {

                    $merchant_param5 = $information[1]; // coupon code

                }

            }




            $response_data = array(

                'order_id' => $merchant_param1, //order_id (primary key)

                'order_no' => $order_id, // order no

                'payment_reference_no' => $tracking_id,

                'payment_status' => strtolower($payment_status_in_db),

                'booking_status' => strtolower($booking_status_in_db),

                'payment_method' => $payment_mode,

                'payment_card_name' => $card_name,

                'log_file_name' => $merchant_param2,

                'applied_coupon_id' => $merchant_param3,

                'applied_coupon_code' => $merchant_param5,

                'session_id' => $merchant_param4,

                'failure_message' => $failure_message,

                'status_code' => $status_code,

                'status_message' => $status_message,

            );

            echo '<pre>';
            pr($response_data);
            }  catch (Exception $e)
            {
                pr($c);
            }

          }
          
      
      
}