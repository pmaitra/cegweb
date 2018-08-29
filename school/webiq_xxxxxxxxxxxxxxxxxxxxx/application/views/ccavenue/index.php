<?php
set_time_limit(100);
ini_set('error_reporting', E_ALL);
error_reporting(-1);
ini_set("display_errors", 1);



	function decrypt($encryptedText,$key)
	{
		$secretKey = hextobin(md5($key));
		$initVector = pack("C*", 0x00, 0x01, 0x02, 0x03, 0x04, 0x05, 0x06, 0x07, 0x08, 0x09, 0x0a, 0x0b, 0x0c, 0x0d, 0x0e, 0x0f);
		$encryptedText=hextobin($encryptedText);
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
          
// Merchant id provided by CCAvenue
$Merchant_Id = "137116";
// Item amount for which transaction perform
$Amount = "1";
// Unique OrderId that should be passed to payment gateway
$Order_Id = "006789";
// Unique Key provided by CCAvenue
$WorkingKey= "FDE880ADE5DAF2FDDB7AAE55C47CA1FF";
// Success page URL
$Redirect_Url=" http://qtsin.net/webiq/home/paysuccess";

    $PG['custom_data']['tid'] = time();

                    $PG['custom_data']['merchant_id'] = '137116';

                    $PG['custom_data']['order_id'] = '111';

                    $PG['custom_data']['amount'] = '1';

                    $PG['custom_data']['currency'] = 'INR';

                    $PG['custom_data']['redirect_url'] = $Redirect_Url;

                    $PG['custom_data']['cancel_url'] = $Redirect_Url;

                    $PG['custom_data']['language'] = 'EN';



                    //Billing

                    $PG['custom_data']['billing_name'] = 'Sayak';

                    $PG['custom_data']['billing_address'] = 'Sayak';

                    $PG['custom_data']['billing_city'] = 'Kolkata';

                    $PG['custom_data']['billing_state'] = 'West Bengal';

                    $PG['custom_data']['billing_zip'] = 711200;

                    $PG['custom_data']['billing_country'] = 'India';

                    $PG['custom_data']['billing_tel'] = '012287878';

                    $PG['custom_data']['billing_email'] =  'sayak2011@gmail.com';



                    // Shipping/Delivery

                    $PG['custom_data']['delivery_name'] =  'kk';

                    $PG['custom_data']['delivery_address'] = '';

                    $PG['custom_data']['delivery_city'] = '';

                    $PG['custom_data']['delivery_state'] = '';

                    $PG['custom_data']['delivery_zip'] = '';

                    $PG['custom_data']['delivery_country'] = 'IN';

                    $PG['custom_data']['delivery_tel'] = '012287878';

                    $PG['custom_data']['delivery_email'] = 'sayak2011@gmail.com';



                    //Additional

                    $PG['custom_data']['merchant_param1'] = '1';

                    $PG['custom_data']['merchant_param2'] = '1';

                    $PG['custom_data']['merchant_param3'] = 2; //coupon id

                    $PG['custom_data']['merchant_param4'] = 3;

                    $PG['custom_data']['merchant_param5'] = 3 ; //coupon code;
                    $merchant_data='';
                    foreach ($PG['custom_data'] as $key => $value) {

                        $merchant_data.=$key . '=' . $value . '&';

                    }

                    $encrypted_data = encrypt($merchant_data, $WorkingKey); // Method for encrypting the data.        
                    $access_code = 'AVJC71EF24AM45CJMA';
                    $production_url = 'https://secure.ccavenue.com/transaction/transaction.do?command=initiateTransaction&encRequest=' . $encrypted_data . '&access_code=' . $access_code;

                    redirect($production_url);
?>
<!DOCTYPE html>
<html>
<head>
<title>Page Title</title>
</head>
<body>
<form id="ccavenue" method="post" action="https://test.ccavenue.com/transaction/transaction.do?command=initiateTransaction">
<input type=hidden name="Merchant_Id" value="<?php echo $Merchant_Id; ?>">
<input type="hidden" name="Amount" value="100">
<input type="hidden" name="Order_Id" value="<?php echo $Order_Id; ?>">
<input type="hidden" name="Redirect_Url" value="<?php echo $Redirect_Url; ?>">
<input type="hidden" name="Checksum" value="<?php echo $Checksum; ?>"> 
<input type="hidden" name="Cancel_Url" value="<?php echo $Redirect_Url; ?>">
<input type="hidden" name="TxnType" value="A">
<input type="hidden" name="ActionID" value="TXNs">

<input type="hidden" name="billing_cust_name" value="Sayak">
<input type="hidden" name="billing_cust_address" value="182 Mirpara">
<input type="hidden" name="billing_cust_country" value="India">
<input type="hidden" name="billing_cust_state" value="West Bengal">
<input type="hidden" name="billing_cust_city" value="Kolkata">
<input type="hidden" name="billing_zip" value="700100">
<input type="hidden" name="billing_cust_tel" value="7827686886">
<input type="hidden" name="billing_cust_email" value="sayak.mukherjee@qtsin.net">
<input type="hidden" name="delivery_cust_name" value="Sayak">
<input type="hidden" name="delivery_cust_address" value="182 Mirpara">
<input type="hidden" name="delivery_cust_country" value="India">
<input type="hidden" name="delivery_cust_state" value="West Bengal">
<input type="hidden" name="delivery_cust_tel" value="7827686886">
<input type="hidden" name="delivery_cust_notes" value="this is a test">
<input type="hidden" name="Merchant_Param" value="">
<input type="hidden" name="billing_zip_code" value="700100">
<input type="hidden" name="delivery_cust_city" value="Kolkata">
<input type="submit" value="Pay Now" />
</form>
</body>