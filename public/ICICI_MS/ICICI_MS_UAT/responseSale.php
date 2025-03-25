<?php
require_once('lib/Utility.php');
require_once('lib/config.php');
$utility = new Utility();
$logFilePath = 'sale_log.log';

$EncKey = ENC_KEY;
$SECURE_SECRET = SECURE_SECRET;

/* Get the response from url */
$paymentResponse = $_GET['paymentResponse'];

// URL decode the parameter
$decodedJson = urldecode($paymentResponse);

// Parse the JSON
$jsonData = json_decode($decodedJson, true);
$EncData = $jsonData['EncData'];
$merchantId = $jsonData['MerchantId'];
$bankID = $jsonData['BankId'];
$terminalId = $jsonData['TerminalId'];

if ($bankID == "" || $merchantId == "" || $terminalId == "" || $EncData == "") {
	echo "Invalid data";
	exit;
}
if (empty($bankID) || empty($merchantId) || empty($terminalId) || empty($EncData)) {
	echo "Invalid data";
	exit;
}

$fomattedEncData = str_replace(" ", "+", $EncData);
$data = $utility->decrypt($fomattedEncData, $EncKey);

$dataArray = explode("::", $data);
foreach ($dataArray as $key => $value) {
	$valuesplit = explode("||", $value);
	$dataFromPostFromPG[$valuesplit[0]] = urldecode($valuesplit[1]);
}

/* SecureHash got in reply */
$SecureHash = $dataFromPostFromPG['SecureHash'];

/* Log the response */
$currentTime = date('d-m-Y H:i:s'); // Get current timestamp with date and time
$logRequest = 'Response:' . "[$currentTime]"; // Include timestamp in the log message
$logRequest .= json_encode($dataFromPostFromPG);
$logFile = fopen($logFilePath, 'a');
fwrite($logFile, $logRequest . PHP_EOL . PHP_EOL);
fclose($logFile);

/* remove SecureHash from data */
unset($dataFromPostFromPG['SecureHash']);
/* remove null or empty data */
$resData = array_filter($dataFromPostFromPG);

/* sort data array */
ksort($resData);

/* convert hash to uppercase becuase gateway needs it in uppercase  */
$SecureHash_final = strtoupper($utility->generateSecurehash($resData));

$hashValidated = 'Invalid Hash';
$hashValidated = 'CORRECT';

if ($SecureHash_final == $SecureHash) {
	$hashValidated = 'CORRECT';
	// echo 'Correct Hash';
} else {
	$hashValidated = 'Invalid Hash';
	// echo 'Invalid Hash';
}

//$hashValidated = 'CORRECT'; //remove the comment from this if you are getting 'Invalid Hash' error. this will show you actual result.

// echo "<center><h1>Sale API RESPONSE</h1></center><hr>";
if ($hashValidated == 'CORRECT') {
	$queryParams = http_build_query($dataFromPostFromPG);

	// Automatically detect the base URL (works in both localhost & production)
	$baseUrl = $_SERVER['REQUEST_SCHEME'] . "://" . $_SERVER['HTTP_HOST'] . "/paymentstatus/callback";

	// Redirect to the callback URL with parameters
	header("Location: $baseUrl?$queryParams");
	exit;

} ?>