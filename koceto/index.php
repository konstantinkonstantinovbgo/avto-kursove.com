<?php
require( dirname(__FILE__).DIRECTORY_SEPARATOR.'includes'.DIRECTORY_SEPARATOR.'connect_new.php' );

require_once DOCROOT.'session.php';
require_once DOCROOT.'paging.class.php';

$page	  = ( $_GET["page"] ? $_GET["page"] : 'index' );
?>
<!DOCTYPE html>
<!--<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">-->
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Administration</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="robots" content="noindex">
	<link rel="stylesheet" type="text/css" href="css/admin_styles.css">
	<link rel="icon" href="../animated_favicon1.gif" type="image/x-icon">
<?php
    if( isset($_SESSION["user_id"]) ){
?>
	<script type="text/javascript" src="js/mail_check.js"></script>
        <script language="javascript" type="text/javascript">

        function validateForm(){

        if(document.edit_link.cat_id.selectedIndex==0)
        {
            alert("Моля, изберете подкатегория");
            document.edit_link.cat_id.focus();
            return false;
        }
        return true;
        }

	var popUpWin=0;
	function popUpWindow(URLStr, left, top, width, height)
	{
	  if(popUpWin)
	  {
		if(!popUpWin.closed) popUpWin.close();
	  }
	  popUpWin = open(URLStr, '_blank', 'toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=no,copyhistory=yes,width='+width+',height='+height+',left='+left+', top='+top+',screenX='+left+',screenY='+top+'');
	}

	function change(){
		var div_chart = document.getElementById('container_chart');
		var num = parseInt(document.getElementById('num').value);
		var nodes = new Array();

		for(var i=0;i<div_chart.childNodes.length;i++){
			if(div_chart.childNodes[i].nodeType==1){
				nodes[nodes.length]=div_chart.childNodes[i];
			}
		}
		for(i=0;i<nodes.length;i++){
			div_chart.removeChild(nodes[i]); //premaxvane na redovete
		}

		for(i=0;i<num;i++){
			var inp = document.createElement('INPUT');	//nov input

			inp.id = 'input_chart_'+i;						//id = ...
			inp.name = 'input_chart_'+i;					//name koeto se submit-va
			inp.type = 'text';							//tip
			inp.className="inp";
			div_chart.appendChild(inp);
		}

	}

	function changep(){
		var divf = document.getElementById('containerp');
		var divn = document.getElementById('containern');
		var num = parseInt(document.getElementById('nump').value);
		var nodes = new Array();

			for(var i=0;i<divf.childNodes.length;i++){
				if(divf.childNodes[i].nodeType==1){
					nodes[nodes.length]=divf.childNodes[i];
				}
			}
			for(i=0;i<nodes.length;i++){
				divf.removeChild(nodes[i]); //premaxvane na redovete
			}

		var nodes = new Array();

			for(var i=0;i<divn.childNodes.length;i++){
				if(divn.childNodes[i].nodeType==1){
					nodes[nodes.length]=divn.childNodes[i];
				}
			}
			for(i=0;i<nodes.length;i++){
				divn.removeChild(nodes[i]); //premaxvane na redovete
			}

		for(i=0;i<num;i++){
			var inp = document.createElement('INPUT');	//nov input

			inp.id = 'pic'+i;						//id = ...
			inp.name = 'pic'+i;					//name koeto se submit-va
			inp.type = 'file';							//tip
			divf.appendChild(inp);
		}


		for(i=0;i<num;i++){
			var inpn = document.createElement('INPUT');	//nov input

			inpn.id = 'input_name_'+i;						//id = ...
			inpn.name = 'input_name_'+i;					//name koeto se submit-va
			inpn.type = 'text';							//tip
			inpn.setAttribute("maxlength","20");
			divn.appendChild(inpn);
		}

	}
</script>
<?php } ?>
</head>
<body>

<table border="0" cellpadding="0" cellspacing="0">
  <tr valign="top">
    <td>
    <?php
		require_once(MODULES_DIR.'menu.php');
    ?>
    </td>
    <td width="100px">&nbsp;</td>
    <td>
        <?php
        if($log){
                echo "<center><h3>".$log."</h3></center>";
        }
        require_once(MODULES_DIR.$page.'.php');
        ?>
    </td>
</tr>
</table>
</body>
</html>