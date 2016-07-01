<?php
require_once dirname(dirname( dirname( dirname( dirname( __FILE__ ))))) . '/wp-load.php';
require_once dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR.'constants.php';
require_once KOS_PLUGIN_DIR.DIRECTORY_SEPARATOR.'kostenlosspielen.php';
require_once dirname(__FILE__).DIRECTORY_SEPARATOR.'KosRestAPI.php';

$restApi = new KosRestAPI();
$response = $restApi->execute($_REQUEST);

ob_end_clean();
header('Content-Type: application/json');
echo json_encode($response);