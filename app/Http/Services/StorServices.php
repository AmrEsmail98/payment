<?php

namespace App\Http\Services;
use Illuminate\Http\Request;
/*
******************************************************************************************
Disclaimer:- Important Note in Sample Pages
- This is a sample demonstration page only meant for demonstration, this page
should not be used in production.
- Transaction data should only be accepted once from a browser at the point
of input, and then kept in a way that does not allow others to modify it
(example server session, database etc..)
- Any information displayed to a customer such as amount, should
be passed only as display information and the actual transaction data should
be retrieved from a secure source at the end point of processing the transaction.
- Any information passed through the customer's browser can potentially be
modified/edited/changed/deleted by the customer, or even by third parties to
fraudulently alter the transaction data/information. Therefore, all transaction
information should not be passed through the browser to Payment Gateway in a way
that could potentially be modified (example hidden form fields).
******************************************************************************************
*/

/* Below is the list of parameters sent from PG to merchant.
========================================================= */
class StorServices
{
public function store(Request $request)
{
if(isset($request['ErrorText']) || isset($request['Error']))
{
$ResErrorText= $request['ErrorText']; 	  	//Error Text/message
$ResErrorNo = $request['Error'];           //Error Number
$ResTranData = null;
} else {
$ResErrorText= null;
$ResErrorNo = null;
$ResTranData= $request['trandata'];
}
$ResPaymentId = $request['paymentid'];		//Payment Id
$ResTrackID = $request['trackid'];       	//Merchant Track ID
$ResResult =  $request['result'];          //Transaction Result
$ResPosdate = $request['postdate'];        //Postdate
$ResTranId = $request['tranid'];           //Transaction ID
$ResAuth = $request['auth'];               //Auth Code
$ResRef = $request['ref'];                 //Reference Number also called Seq Number
$ResAmount = $request['amt'];              //Transaction Amount
$Resudf1 = $request['udf1'];               //UDF1
$Resudf2 = $request['udf2'];               //UDF2
$Resudf3 = $request['udf3'];               //UDF3
$Resudf4 = $request['udf4'];               //UDF4
$Resudf5 = $request['udf5'];
$termResourceKey="9185921704869185";
if($ResErrorText==null && $ResErrorNo==null && $ResTranData !=null)
{

//Decryption logice starts
$decrytedData=decrypt($ResTranData,$termResourceKey);

/* IMPORTANT NOTE - MERCHANT SHOULD UPDATE TRANACTION PAYMENT STATUS IN HIS DATABASE AT THIS POINT
AND THEN REDIRECT CUSTOMER TO THE RESULT PAGE. */


header("Location: https://www.yourwebsite.com/PHP/result.php?".$decrytedData);
exit();
}
else{
header("Location: https://www.yourwesbite.com/PHP/result.php?Error=".$ResErrorNo."&ErrorText=".$ResErrorText."&trackid=".$ResTrackID."&amt=".$ResAmount."&paymentid=".$ResPaymentId."&tranid=".$ResTranId."&result=".$ResResult);
exit();
}   //UDF5
}
/* Below Terminal resource Key is used to decrypt the response sent from Payment Gateway.
Terminal Resource Key is generated while creating terminal and this the Key that is used for decrypting
the response from PG. Please contact PGSupport@knet.com.kw to extract this key. */
//  $termResourceKey="9185921704869185";

/* Merchant (ME) checks, if error is NOT present,then go for decryption using required parameters */
/* NOTE - MERCHANT MUST LOG THE RESPONSE RECEIVED IN LOGS AS PER BEST PRACTICE */
// if($ResErrorText==null && $ResErrorNo==null && $ResTranData !=null)
// {

//Decryption logice starts
// $decrytedData=decrypt($ResTranData,$termResourceKey);

/* IMPORTANT NOTE - MERCHANT SHOULD UPDATE TRANACTION PAYMENT STATUS IN HIS DATABASE AT THIS POINT
AND THEN REDIRECT CUSTOMER TO THE RESULT PAGE. */


// header("Location: https://www.yourwebsite.com/PHP/result.php?".$decrytedData);
// exit();
// }
// else{
// header("Location: https://www.yourwesbite.com/PHP/result.php?Error=".$ResErrorNo."&ErrorText=".$ResErrorText."&trackid=".$ResTrackID."&amt=".$ResAmount."&paymentid=".$ResPaymentId."&tranid=".$ResTranId."&result=".$ResResult);
// exit();
// }

//Decryption Method for AES Algorithm Starts

public function decrypt($code,$key) {
// $code =  hex2ByteArray(trim($code));
// $code= byteArray2String($code);
$iv = $key;
$code = base64_encode($code);
$decrypted = openssl_decrypt($code, 'AES-128-CBC', $key, OPENSSL_ZERO_PADDING, $iv);
// return pkcs5_unpad($decrypted);
}

function hex2ByteArray($hexString) {
$string = hex2bin($hexString);
return unpack('C*', $string);
}


function byteArray2String($byteArray) {
$chars = array_map("chr", $byteArray);
return join($chars);
}


function pkcs5_unpad($text) {
$pad = ord($text[strlen($text)-1]);
if ($pad > strlen($text)) {
return false;
}
if (strspn($text, chr($pad), strlen($text) - $pad) != $pad) {
return false;
}
return substr($text, 0, -1 * $pad);
}
//Decryption Method for AES Algorithm Ends



public function send(){



/*
******************************************************************************************
Disclaimer:- Important Note in Sample Pages
- This is a sample demonstration page only meant for demonstration, this page
should not be used in production.
- Transaction data should only be accepted once from a browser at the point
of input, and then kept in a way that does not allow others to modify it
(example server session, database etc..)
- Any information displayed to a customer such as amount, should
be passed only as display information and the actual transaction data should
be retrieved from a secure source at the end point of processing the transaction.
- Any information passed through the customer's browser can potentially be
modified/edited/changed/deleted by the customer, or even by third parties to
fraudulently alter the transaction data/information. Therefore, all transaction
information should not be passed through the browser to Payment Gateway in a way
that could potentially be modified (example hidden form fields).
******************************************************************************************
*/

/*  The "&" sign is mandatory to mention with in the end of passed value, in below section this
to make the string  Merchant can use their own logic of creating the string with required
inputs, below is just a basic method on how to create a request string and pass the values
to Payment Gateway  */


/*Getting Transaction Amount from previous pages. Since this sample page for demonstration,
values from previous page is directly taken from browser and used for transaction processing.
Merchants SHOULD NOT follow this practice in production environment. */
$price = $_POST['price'];
$qty = $_POST['qty'];
$TranAmount = $price * $qty;

/* Tranportal ID is sensitive terminal information, merchant MUST ensure that Tranportal ID is never
passed to customer browser by any means. Merchant MUST ensure that Tranportal ID is stored in a secure
environment. Tranportal ID for test and production will be different, please contact PGSupport@knet.com.kw to
extract these details. */
$TranportalId="134501";
$ReqTranportalId="id=".$TranportalId;

/* Tranportal password is sensitive terminal information, merchant MUST ensure that Tranportal password
is never passed to customer browser by any means. Merchant MUST ensure that Tranportal password is stored in a secure
environment. Tranportal password for test and production will be different, please contact PGSupport@knet.com.kw to
extract these details. */
$TranportalPassword="134501pg";
$ReqTranportalPassword="password=".$TranportalPassword;

/* Transaction Amount that will be sent to payment gateway by merchant for processing
NOTE - Merchant MUST ensure amount is sent from merchant back-end system like database
and not from customer browser. */
$ReqAmount="amt=".$TranAmount;

/* To pass the merchant track id, in below sample merchant track id is hard-coded. Merchant
MUST pass his transaction ID (track ID) in this parameter. Track Id passed here should be
from merchant backend system like database and not from customer browser
Merchant must ensure that each transaction has a unique Track ID. */
$TranTrackid=mt_rand();
$ReqTrackId="trackid=".$TranTrackid;

/* Currency code of the transaction. this has to be set always to 414 (KD) */
$ReqCurrency="currencycode=414";

/* Transaction language, this has to be set always to USA or AR */
$ReqLangid="langid=USA";


/* Action Code of the transaction, this refers to type of transaction.
Action Code 1 stands of Purchase transaction  */
$ReqAction="action=1";


/* Response URL where Payment gateway will send response once transaction processing is completed
Merchant MUST esure that below points in Response URL
1- Response URL must start with https://
2- the Response URL SHOULD NOT have any additional paramteres or query strings  */
$ResponseUrl="https://www.yourwebsite.com/PHP/GetHandlerResponse.php";
$ReqResponseUrl="responseURL=".$ResponseUrl;


/* Error URL where Payment gateway will send response in case any issues while processing the transaction
Merchant MUST esure that below points in ErrorURL
1- error url must start with https://
2- the error url SHOULD NOT have any additional paramteres or query strings */
$ErrorUrl="https://www.yourwebsite.com/PHP/result2.php";
$ReqErrorUrl="errorURL=".$ErrorUrl;


/* User Defined Fields as per Merchant requirement. Merchant MUST ensure merchant is not passing junk values OR CRLF in any of the UDF.
In below sample UDF values are not utilized */
$ReqUdf1="udf1=test1";
$ReqUdf2="udf2=test2";
$ReqUdf3="udf3=test3";
$ReqUdf4="udf4=test4";
$ReqUdf5="udf5=test5";

/* Merchant should now do the below validations :
a) Transaction Amount should not be blank and should be only numeric
b) Language should always be USA or AR
c) Action Code should always be 1
d) UDF values should not have junk values and CRLF (line terminating parameters)Like--> [ !#$%^&*()+[]\\\';,{}|\":<>?~` ]
e) Merchant must save the amount, track id, udf 1-5 in his database */


/* Now merchant sets all the inputs in one string for encrypt and then passing to the Payment Gateway URL */
$param=$ReqTranportalId."&".$ReqTranportalPassword."&".$ReqAction."&".$ReqLangid."&".$ReqCurrency."&".$ReqAmount."&".$ReqResponseUrl."&".$ReqErrorUrl."&".$ReqTrackId."&".$ReqUdf1."&".$ReqUdf2."&".$ReqUdf3."&".$ReqUdf4."&".$ReqUdf5;

//==============================Encryption LOGIC CODE START===============================================================================
/* Below are the fields / parameters which will be used for Encryption using (AES (128 bit)) Encryption
   Algorithm. */

/* Terminal Resource Key is generated while creating terminal, And this the Key that is used for encrypting
  the request/response from Merchant To PG and vice Versa
  Please contact PGSupport@knet.com.kw to extract this key */

$termResourceKey="";
$param=encryptAES($param,$termResourceKey)."&tranportalId=".$TranportalId."&responseURL=".$ResponseUrl."&errorURL=".$ErrorUrl;

//==============================Encryption LOGIC CODE End=================================================================================

/* Log the complete request in the log file for future reference
Now creating a connection and sending request
Note - In PHP header function is used for redirecting request
*********UNCOMMENT THE BELOW REDIRECTION CODE TO CONNECT TO EITHER TEST OR PRODUCTION********* */
header("Location: https://kpaytest.com.kw/kpg/PaymentHTTP.htm?param=paymentInit"."&trandata=".$param); /* send request and redirect to TEST */
//header("Location: https://kpay.com.kw/kpg/PaymentHTTP.htm?param=paymentInit"."&trandata=".$param); /* send request and redirect to PRODUCTION */
exit();


//AES Encryption Method Starts
function encryptAES($str,$key) {
$str = pkcs5_pad($str);
$encrypted = openssl_encrypt($str, 'AES-128-CBC', $key, OPENSSL_ZERO_PADDING, $key);
$encrypted = base64_decode($encrypted);
$encrypted=unpack('C*', ($encrypted));
$encrypted=byteArray2Hex($encrypted);
$encrypted = urlencode($encrypted);
return $encrypted;
}

function pkcs5_pad ($text) {
$blocksize = 16;
$pad = $blocksize - (strlen($text) % $blocksize);
return $text . str_repeat(chr($pad), $pad);
    }
function byteArray2Hex($byteArray) {
$chars = array_map("chr", $byteArray);
$bin = join($chars);
return bin2hex($bin);
}
//AES Encryption Method Ends

}

}



