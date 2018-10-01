<?php
exit;
error_reporting(E_ALL & ~E_NOTICE);
echo 'Current PHP version: ' . phpversion();

require_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'includes'.DIRECTORY_SEPARATOR.'connect_forex.php');

define( "PHPCURLCLASS_DIR", DOCROOT . "..". DS .'PHPCurlClass'.DS.'src'.DS.'Curl'.DS,1);
require_once PHPCURLCLASS_DIR.'Curl.php';
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
    </head>
    <body>
		<?php
			require_once('bnb.php');
			require_once('pioneerinvestments.php');
		?>
    </body>
</html>