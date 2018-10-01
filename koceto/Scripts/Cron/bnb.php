<?php
$website1	=	'http://bnb.bg/';

$curl = new Curl();
$curl->get($website1);

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

		$container 	= $doc->getElementById("more_information");
		$children 	= $container->childNodes;

		$items['EUR']	=	$items['USD']	=	$items['GBP']	=	$items['CHF']	=	'';

		foreach ($children as $child) {
			if($child->DOMText) {
				continue;
			}
			if($child->textContent){
				$tmp_items			=	explode(' ', (string) strip_tags($child->textContent));
				$cnt_tmp_items		=	count($tmp_items);
				$tmp				=	array();
				for ($i=0; $i<$cnt_tmp_items; $i++){
					if( strlen(trim($tmp_items[$i])) > 0 ) {
						$tmp[]		=	(string) $tmp_items[$i];
					}
				}
				$cnt_tmp			=	count($tmp);
				if($cnt_tmp>1) {
					for ($i=0; $i<$cnt_tmp; $i++){
						if($tmp[$i] == '1' && $tmp[$i+1] == 'EUR' && !$items['EUR']) {
							$items['EUR']	=	$tmp[$i+3];
						}
						if($tmp[$i] == '1' && $tmp[$i+1] == 'USD' && !$items['USD']) {
							$items['USD']	=	$tmp[$i+3];
						}
						if($tmp[$i] == '1' && $tmp[$i+1] == 'GBP' && !$items['GBP']) {
							$items['GBP']	=	$tmp[$i+3];
						}
						if($tmp[$i] == '1' && $tmp[$i+1] == 'CHF' && !$items['CHF']) {
							$items['CHF']	=	$tmp[$i+3];
						}
					}
				}
			}

		}

		if( $items['EUR'] || $items['USD'] || $items['GBP'] || $items['CHF'] ) {
			do_db_query ( "INSERT INTO `website_currencies` SET WebSiteID = '1', `EUR` = '{$items['EUR']}',`USD` = '{$items['USD']}',`GBP` = '{$items['GBP']}',`CHF` = '{$items['CHF']}', `CreateDate` = NOW();" );
		}

		show($items);
	}
}
?>