<?php
require('includes/session.php');

// include captcha class
require('includes/php-captcha.inc.php');


// define fonts
$aFonts = array('fonts/trebucbd.ttf','fonts/comic.ttf','fonts/arial.ttf','fonts/verdana.ttf');

// create new image
$oPhpCaptcha = new PhpCaptcha($aFonts, 200, 50,5,0);

$oPhpCaptcha->UseColour(true);
//$oPhpCaptcha->SetMinFontSize(16);
$oPhpCaptcha->SetBackgroundImage("images/site/captcha.jpg");
//$oPhpCaptcha->UseColour(true);

$oPhpCaptcha->Create();
?>