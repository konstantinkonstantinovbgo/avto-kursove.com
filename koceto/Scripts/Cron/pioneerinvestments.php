<?php
$website2	=	'http://www.pioneerinvestments.bg/Fund/ActualInfo.asp?fund=PFUSResearchGrowth&class=EUR';

$curl = new Curl();
$curl->get($website2);

if ($curl->error) {
    error('get_currencies',$curl->error_code,$curl->error_message);
}
else {

	$doc = new DomDocument();

	// We need to validate our document before refering to the id
	$doc->validateOnParse = true;
	$doc->recover=true;

	libxml_use_internal_errors(true);
	if (!$doc->loadHTML($curl->response)) {

		error('get_currencies','libxml_get_errors',libxml_get_errors());
		libxml_clear_errors();

	} else {

		#$share_price	=	'Ценазадял';#Цена за дял
		$share_price	=	'Цена за дял';#Цена за дял

		$container 	= $doc->getElementById("ContentColumn");
		$children 	= $container->childNodes;

		$items		=	array();

		$items['SHARE_PRICE']	=	'';

		foreach ($children as $child) {
			if($child->DOMText) {
				continue;
			}
			if($child->textContent){
				$tmpTextContent		=	(string) strip_tags($child->textContent);
				$tmpPrice 			= 	strstr($tmpTextContent, $share_price);
				if($tmpPrice){
					$tmpPrice		=	str_replace(',','.',$tmpPrice);
					$tmpPriceArr	=	explode(' ',$tmpPrice);
					foreach( $tmpPriceArr as $price) {
						$price	=	floatval($price);
						if($price) {
							$items['SHARE_PRICE']	=	$price;
							$items['SHARE_TEXT']	=	addslashes($tmpPrice);
						}
					}
				}
			}
		}

		if( $items['SHARE_PRICE'] ) {
			do_db_query ( "INSERT INTO `website_currencies` SET `WebSiteID` = '2', `SHARE_PRICE` = '{$items['SHARE_PRICE']}', `SHARE_TEXT` = '{$items['SHARE_TEXT']}', `CreateDate` = NOW();" );
		}

		show($items);
	}
}
?>