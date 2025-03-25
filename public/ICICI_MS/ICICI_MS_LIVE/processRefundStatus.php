<?php
ini_set('display_errors', 1);
error_reporting(E_ERROR | E_WARNING | E_PARSE);

// get inputs
if(!isset($_POST["SubmitRefund"])){
	exit;
}

require_once ('lib/Utility.php');
require_once('lib/config.php');
$utility = new Utility();

$data = array();

$EncKey = ENC_KEY;
$SECURE_SECRET = SECURE_SECRET;
$statusURL = STATUSURL;
$utility->validate(); // validate the config.php variables

$data['BankId'] = BANKID;
$data['MerchantId'] = $_POST['MerchantId'];
$data['PassCode'] = PASSCODE;
$data['RefCancelId'] = $_POST['RefCancelId'];
$data['TerminalId'] = $_POST['TerminalId'];
$data['TxnRefNo'] = $_POST['TxnRefNo'];
$data['TxnType'] = 'Refund';

//echo '<pre>';print_r($data);
/* Generate hash */
$SecureHash = $utility->generateSecurehash($data, $SECURE_SECRET);
$shArr = array('SecureHash' => strtoupper($SecureHash));
$postData = array();
$postData = array_merge($shArr,$data);

//echo '<br><br>';print_r($postData);echo '</pre><br>';

$postDataEncode = json_encode($postData);

//echo '<br>JSON data for post: '.$postDataEncode.'<br><br>';

/* Post data to get the status */
$curl = curl_init();
curl_setopt_array($curl, array(
	CURLOPT_URL => $statusURL,
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
<center><h1>REFUND STATUS API RESPONSE</h1></center><hr>

<?php
if($responseArray != null || $responseArray != '') {
    $rA = array_filter($responseArray);
	showResponse($rA);	
} else {
	var_dump($responseArray);
}

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
