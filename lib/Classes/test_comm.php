<?php

define('APPLICATION_DEVLOPMENT', false);
ini_set("display_errors", "1");
 
// error handler
//E_COMPILE_WARNING | E_NOTICE | E_WARNING
//E_STRICT
//E_COMPILE_WARNING | E_NOTICE
error_reporting(E_ALL ^ E_NOTICE);
set_error_handler('__core_error_handler', E_ALL ^ E_NOTICE);

set_exception_handler('__core_exception_handler');
  
 
/**
 * debug print function
 * E.g. dprint('myobject', $Object1, $Object2);
 *
 * @param mix $msg
 */
function dprint($msg)
{
	echo "\n\n<pre>";
	$BackTrace = debug_backtrace();
	//var_dump($BackTrace);
	if (!empty($BackTrace[1]['class'])) {
		echo '<i><b>from:-  </i></b>' . $BackTrace[1]['class'].'::'.$BackTrace[1]['function'] . '';
	}
	else {
		if (isset($BackTrace[1]['function'])) {
			echo $BackTrace[1]['function'];
		}
	}
	echo "\n";
	$args = func_num_args();
	for( $i=0; $i<$args; $i++ ) {
		echo dprint_var(func_get_arg($i));
		echo "\n";
	}
	echo "</pre>\n\n";
}

/**
 * debug print function
 * E.g. debug_print( 'myobject', $Object1, $Object2 );
 *
 * @param mix $msg
 */
function debug_print_1($msg)
{
	echo "\n\n<pre>";
	$BackTrace = debug_backtrace();
	if (!empty($BackTrace[1]['class'])) {
		echo $BackTrace[1]['class'].'::'.$BackTrace[1]['function'];
	}
	else {
		echo $BackTrace[1]['function'];
	}
	echo "\n";
	$args = func_num_args();
	for ($i=0; $i<$args; $i++) {
		print_r(func_get_arg($i));
		echo "\n";
	}
	echo "</pre>\n\n";
}

/**
 * debug print back trace function
 */
function dprint_callstack()
{
	echo "\n\n<pre>debug_print_callstack\n\n";
	$BackTrace = debug_backtrace();
	echo dprint_var($BackTrace);
	echo "</pre>\n\n";
}


/**
 * Dump variable
 *
 * @access private
 * @param mix $var
 * @param int $depth
 * @param int $length
 * @return string
 */
function dprint_var($var, $depth = 0, $length = 40)
{
	$depth_limit = 4;
	
    $_replace = array("\n"=>'<i>&#92;n</i>', "\r"=>'<i>&#92;r</i>', "\t"=>'<i>&#92;t</i>');
    if (is_array($var)) {
        $results = "<b>Array (".count($var).")</b>";
		
		if($depth>$depth_limit)
			return $results;		
		
        foreach ($var as $curr_key => $curr_val) {
            $return = dprint_var($curr_val, $depth+1, $length);
            $results .= "<br>".str_repeat('&nbsp;', ($depth+1)*4)."<b>".strtr($curr_key, $_replace)."</b> =&gt; $return";
        }
    } else if (is_object($var)) {

		$count = 0;
		$results1 = '';
		$keys = array();
        if ($var instanceof Iterator || $var instanceof ArrayObject) {
			foreach ($var as $curr_key => $curr_val) {
				$keys[] = $curr_key;
	            $return = dprint_var($curr_val, $depth+1, $length);
	            $results1 .= "<br>".str_repeat('&nbsp;', ($depth+1)*4)."<b>$curr_key</b> =&gt; $return";
	            $count++;
			}
    	}
    	
    	$object_vars = get_object_vars($var);
    	$count += count($object_vars);
        $results = "<b>".get_class($var)." Object (".$count.")</b>";
		$results .= $results1;
		
		if($depth>$depth_limit)
			return $results;
			
        foreach ($object_vars as $curr_key => $curr_val) {
        	if (in_array($curr_key, $keys)) {
        		continue;
        	}
            $return = dprint_var($curr_val, $depth+1, $length);
            $results .= "<br>".str_repeat('&nbsp;', ($depth+1)*4)."<b>$curr_key</b> =&gt; $return";
        }
    } else if (is_resource($var)) {
        $results = '<b>resource</b>  '.(string)$var;
    } else if (empty($var) && $var != "0") {
        $results = '<i>empty</i>';
    }
    else if (is_bool($var)) {
    	$results = '<b>bool</b>  ' . ($var ? 'true' : 'false');
    } else if (is_string($var)) {
        $results = '<b>string(' . strlen($var) . ')</b>  ' . strtr(htmlspecialchars($var), $_replace);
    }
    else {
        $results = '<b>'. gettype($var) .'</b>  ' . $var;
    }
    return $results;
}

/**
 * error handler.
 * This method is invoked by PHP when an error happens.
 * It displays the error if the application state is in debug;
 * otherwise, it saves the error in log.
 */
function __core_error_handler($errno, $errstr, $errfile, $errline) 
{
	// varibale not found error genrated during debuging code in zend
	// below condition is write to overcome that error.
	// error inromation
	// [8] Undefined variable: Path @line variable expression in file 1 
	// var_dump($errno, $errstr, $errfile, $errline);
	// int(8) string(27) "Undefined variable: Control" string(19) "variable expression" int(1) 
	if ($errline == 1 || $errfile == 'variable expression') {
		//debug_print($errline);
		return ;
	}
	
	var_dump($errno, $errstr, $errfile, $errline);
	__print_error($errno, $errstr, $errfile, $errline, null, 1);
}

function __core_exception_handler($exception)
{
	$code = get_class($exception).", ".$exception->getCode();
	__print_error(		$code, 
						$exception->getMessage(),
						$exception->getLine(),
						$exception->getFile(),
						$exception->getTrace(), -1);	
}

function __print_error($errcode, $errstr, $errline, $errfile, $backtrace=null, $not_show=0)
{
	$Contents = ob_get_contents();
	ob_get_clean();

		$ErrorData .= '<h1>Error</h1>';
		$ErrorData .= "<pre style='background-color: #FFFFCC;font-weight: bold;'> \n";
		$ErrorData .= "[$errcode] <br>$errstr <br>@line $errline in file $errfile";
		$ErrorData .= " \n </pre>";
		
		// print debug trace
		if (!function_exists('debug_backtrace')) {
			return; 
		}
	
		if (!is_array($backtrace)) {
			$backtrace = debug_backtrace();
		}
	
		$ErrorData .= '<h2>Debug Backtrace</h2>';
		$ErrorData .= '<pre>';
		
		$index=-1;
		$index_line = 0;
		$index_file = 0;
		foreach($backtrace as $t) {
			$index++;
			if($index<=$not_show)  {// hide the backtrace of this function
				continue;
			}
			
			$index_line++;
			$ErrorData .= '#'.($index_line).' ';
			if(isset($t['file'])) {
				$ErrorData .= basename($t['file']) . ':' . $t['line']; 
			}
			else {
			   $ErrorData .= '<PHP inner-code>'; 
			}
			
			echo ' -- '; 
			if(isset($t['class'])) {
				$ErrorData .= $t['class'] . $t['type']; 
			}
			$ErrorData .= $t['function']; 
			if(isset($t['args']) && sizeof($t['args']) > 0) {
				$ErrorData .= '(...)'; 
			}
			else {
				$ErrorData .= '()'; 
			}
			
			if (isset($t['file']) && isset($t['line']) && $index_file < 5) {
				if( __print_file_code($t['file'], $t['line']) ) {
					$index_file++;
				}
			}
			else {
				$ErrorData .= "\n";
			}

			$ErrorData .= "\n";
			
		}
		$ErrorData .= '</pre>';
		$ErrorData .= $Contents;
	if (APPLICATION_DEVLOPMENT) {
		echo $ErrorData;
		exit(1);
	}
	else {
		
		$msg = $ErrorData. "[$errcode] $errstr <br>@line $errline in file $errfile";
		
		$msg = $msg."<br>".$_SERVER['SCRIPT_FILENAME'];//$SCRIPT_FILENAME;//reading the url in browser

		/*complete filename with extension from the url
		
		$FileNameWithExt=substr($FullFileName,strrpos($FullFileName,'/')+1,strlen($FullFileName));
				
		$headers 	 =  "From: chintan@radixweb.com\r\n";
		$headers 	.=  "Subject: Error Message(EHCI)\r\n ";
				
		if($FileNameWithExt == FILE_SEND_PDF_EMAILS)
		{
			error_log($msg, 1,"chintan@radixweb.com",$headers);
		}
		else 
		{
			require_once(DIR_WS_ROOT."/".FILE_ERROR_MESSAGE);
		}*/
		//send mail to client, agency, agent and underwriter.
		$mailsend = Preferences::SendMail("Error report for EHC",ERROR_REPORTING_FROM_EMAIL,ERROR_REPORTING_TO_EMAIL,'',ERROR_REPORTING_CC_EMAIL,'HTML',$msg,'','');			
	}
}

function __print_file_code($errfile, $errline)
{
	$dir_list = array(	//'RxCoreNS/Base'
					 );
	$filedir = str_replace( "\\", "/", dirname($errfile));
	foreach ($dir_list as $dir) {
		 if (strrpos($filedir, $dir)>0) {
		 	echo "\n";
		 	return false;
		 }
	}
	
	// print code lines
	$file_lines = @file($errfile);
	if (is_array($file_lines)) {
		if (isset($file_lines[$errline])) {
		
			echo "<pre style='background-color: #FFFFCC;'>";
			for ($i=$errline-3; $i<=$errline+3; $i++ ) {
				
				if (isset($file_lines[$i-1])) {
					$line = htmlspecialchars($file_lines[$i-1]);
				}
				else {
					continue;
				}
				
				echo $i.': ';
				if( $i==$errline ) {
					echo "<span style='color: #CC0000;font-weight: bold;'>".$line.'</span>';
				}
				else {
					echo $line;
				}
			}
			echo '</pre>';
		}
	}
	return true;			
}
?>