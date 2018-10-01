<?php

class Logger
{
	private $ROOT		=	"";
	private $WIN32		=	false;
	private $PID		=	PID;
	private $FORMAT		=	"%b %d %H:%M:%S";
	private $DEBUG		=	true;
	private $FILELIST	=	array();

	function __construct( $LogRoot )
	{
		if(empty($LogRoot))
		{
			return;
		}

		$this->set_root($LogRoot);

		return;
	}

	function log ($FileName, $Ident, $LogEntry)
	{
		global $php_errormsg;

		$filename = $this->ROOT . $FileName;
		$TimeStamp = strftime($this->FORMAT,time());
		$LogEntry = "$TimeStamp [$Ident] $LogEntry";

		if (!$this->FILELIST[$FileName])
		{
			$fd = fopen($filename,"a");
			if ( (!$fd) or (empty($fd)) )
			{
				return;
			}

			fwrite($fd,"$LogEntry\n");

			$this->FILELIST[$FileName] = $fd;
		}
		else
		{
			fwrite($this->FILELIST[$FileName],"$LogEntry\n");
		}

		return;
	}

	function __destruct()
	{
		foreach ($this->FILELIST as $Handle => $val )
		{
			if( isset($this->$Handle) && $this->$Handle)
			{
				fclose($this->$Handle);
				unset($this->$Handle);
			}
		}
	}

	function set_root ($root)
	{
		if ( empty( $this->WIN32 ) )
		{
			if( substr($root, -1) != "/" )
			{
				$root = "$root"."/";
			}
			if(is_dir($root))
			{
				$this->ROOT = $root;
			}
			else
			{
				$this->ROOT = "";
			}
		}
		else
		{
			// WIN32 box - no test

			if( substr($root, -1) != "\\" )
			{
				$root = "$root"."\\";
			}

			$this->ROOT = $root;
		}

	}   // End set_root()

}	// End class.Logger

?>
