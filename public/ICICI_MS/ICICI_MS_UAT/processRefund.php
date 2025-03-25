<?php
ini_set('display_errors', 1);
error_reporting(E_ERROR | E_WARNING | E_PARSE);

if(!isset($_POST["SubmitRefund"])){
	exit;
}

require_once ('lib/Utility.php');
require_once('lib/config.php');

$data = array();
// get inputs

$utility = new Utility();
$logFilePath = 'refund_log.log';

$EncKey = ENC_KEY;
$SECURE_SECRET = SECURE_SECRET;
$RefundUrl = REFUNDURL;
$utility->validate(); // validate the config.php variables

/* Arrange the values in following order to generate hash */
$data['BankId'] = BANKID;
$data['MerchantId'] = $_POST['MerchantId'];
$data['PassCode'] = PASSCODE;
$refund_amount = (int)$_POST['refund_amount']*100;
$data['RefCancelId'] = time().$_POST['TxnRefNo'];
$data['RefundAmount'] = strval($refund_amount);
$data['RetRefNo'] = $_POST['RetRefNo'];
$data['TerminalId'] = $_POST['TerminalId'];
$data['TxnRefNo'] = $_POST['TxnRefNo'];
$data['TxnType'] = 'Refund';


/* Generate hash */
$SecureHash = $utility->generateSecurehash($data, $SECURE_SECRET);
$shArr = array('SecureHash' => strtoupper($SecureHash));
$postData = array();
$postData = array_merge($shArr,$data);
//echo '<br><br><pre>POST Data:';print_r($postData);echo '</pre><br>';

ksort($postData);

$postDataEncode = json_encode($postData);

//echo '<br><br><br>JSON data for post: <br>'.$postDataEncode.'<br><br>';

/* Post data to get the status */
$curl = curl_init();
curl_setopt_array($curl, array(
	CURLOPT_URL => $RefundUrl,
	CURLOPT_RETURNTRANSFER => true,
	CURLOPT_ENCODING => '',
	CURLOPT_MAXREDIRS => 10,
	CURLOPT_TIMEOUT => 0,
	CURLOPT_FOLLOWLOCATION => true,
	CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	CURLOPT_CUSTOMREQUEST => 'POST',
	CURLOPT_POSTFIELDS => $postDataEncode,
	CURLOPT_HTTPHEADER => array(
		'Content-Type: application/json',
		'Cookie: Path=/rbac-service'
		),
));
$response = curl_exec($curl);
curl_close($curl);

$responseArray = json_decode($response, true);

/* Print the response */
?>
<style type="text/css">
	* { font-family:sans-serif; }
	h1 {font-size: 20px;font-weight: 600;margin-bottom: 5px; color: #08185A;}
	h4 {text-align: center;}
	.shade { height:30px; background-color:#E1E1E1 }	
</style>
<center><h1>REFUND API RESPONSE</h1></center><hr>

<?php
if($responseArray != null || $responseArray != '') {
    $rA = array_filter($responseArray);
	showResponse($rA);	
} else {
	var_dump($responseArray);
}

//Log the request
$currentTime = date('d-m-Y H:i:s'); // Get current timestamp with date and time
$logRequest = 'Request:'."[$currentTime]"; // Include timestamp in the log message
$logRequest .= json_encode($data);
$logFile = fopen($logFilePath, 'a');
fwrite($logFile, $logRequest . PHP_EOL.PHP_EOL);
fclose($logFile);

//Show response received
function showResponse($responseArray)
{ ?>
	<table width="60%" align="center" border="0" cellpadding='0' cellspacing='0'>
		<?php
			$n = 0;
			foreach($responseArray as $key=>$_responseArray) { ?>
				<tr class="<?php if($n%2 == 0) { echo 'shade'; }?>">
			        <td><strong><em><?php echo $key; ?> </em></strong></td>
			        <td><?php echo $_responseArray; ?></td>
			    </tr>

			<?php $n++;
			}
		?>
	</table>

<?php	
}
?>
