<?php defined('BASEPATH') OR exit('No direct script access allowed');

/***
 *
 * MY_text_helper.php
 *
 * author		: Lucky Mahrus
 * copyright	: Lucky Mahrus (c) 2015
 * license		: http://www.luckymahrus.com/
 * file			: private/application/apps/helpers/MY_text_helper.php
 * created		: 2015 October 21th / 23:20:46
 * last edit	: 2015 October 21th / 23:20:46
 * edited by	: Lucky Mahrus
 * version		: 1.0
 *
 */

if ( ! function_exists('padding_left'))
{
    function padding_left($s, $c, $n)
    {
        if (strlen($s) >= $n)
        {
            return $s;
        }
        $max = ($n - strlen($s))/strlen($c);
        for ($i = 0; $i < $max; $i++)
        {
            $s = $c.$s;
        }
        return $s;
    }
}

if ( ! function_exists('padding_right'))
{
    function padding_right($s, $c, $n)
    {
        if (strlen($s) >= $n)
        {
            return $s;
        }
        $max = ($n - strlen($s))/strlen($c);
        for ($i = 0; $i < $max; $i++)
        {
            $s = $s.$c;
        }
        return $s;
    }
}

if ( ! function_exists('if_date_convert'))
{
    function if_date_convert($text, $delimiter="-", $date_format="Y-m-d")
    {
		$regex1 = '/[0-9]{1,2}-[0-9]{1,2}-[0-9]{4}/';
		$regex2 = '/[0-9]{4}-[0-9]{1,2}-[0-9]{1,2}/';

		if (preg_match($regex1, $text))
		{
			list($date,$month,$year) = explode($delimiter, $text);

			return date($date_format, mktime(0,0,0,padding_left($month,'0',2),padding_left($date,'0',2),$year));
		}
		elseif (preg_match($regex2, $text))
		{
			list($year,$month,$date) = explode($delimiter, $text);

			return date($date_format, mktime(0,0,0,padding_left($month,'0',2),padding_left($date,'0',2),$year));
		}
		else
		{
		    return $text;
		}

		return FALSE;
    }
}

if ( ! function_exists('is_date'))
{
	function is_date( $str )
	{
	    try
	    {
	        $dt = new DateTime( trim($str) );
	    }
	    catch( Exception $e )
	    {
	        return false;
	    }

	    $month = $dt->format('m');
	    $day = $dt->format('d');
	    $year = $dt->format('Y');
	    
	    if( checkdate($month, $day, $year) )
	    {
	        return true;
	    }
	    else
	    {
	        return false;
	    }
	}
}

if ( ! function_exists('is_decimal_convert'))
{
    function is_decimal_convert($text, $delimiter=".",$decimal_number=2)
    {
		$regex = '/[-]{0,1}[0-9]{1}[.]{0,1}[0-9]{0,}/';

		$exploded = explode($delimiter, $text);

		if (preg_match($regex, $text))
		{
			if(isset($exploded[1]))
			{
				list($number,$decimal) = $exploded;
				$decimal_length = strlen($decimal);
				if($decimal_length > $decimal_number) $decimal_number = $decimal_length; 
			}
			else
			{
				$number	 = $text;
				$decimal = '0';	
			}

			return floatval($number.$delimiter.padding_right($decimal,'0',$decimal_number));
		}
		else
		{
		    return $text;
		}

		return FALSE;
    }
}


if ( ! function_exists('file_language'))
{
	function file_language($filename)
	{
        $CI =& get_instance();

        if( ! isset($CI))
        {
            $CI = new CI_Controller();
        }
		$file_languages = $CI->config->item('file_language');
		foreach ($file_languages as $lang => $lang_code)
		{
			$format = "/^(".$lang_code['iso']."_|".$lang_code['lang']."_)|(_".$lang_code['iso']."|_".$lang_code['lang'].")$/";
			preg_match($format, strtolower($filename),$matches,PREG_OFFSET_CAPTURE);
			if(!empty($matches) && !is_null($matches)) return $lang;
		}
		return NULL;
	}
}

if ( ! function_exists('json_validate'))
{
	function json_validate($string)
	{
	    // decode the JSON data
	    $result = json_decode($string);

	    // switch and check possible JSON errors
	    switch (json_last_error())
	    {
	        case JSON_ERROR_NONE:
	            $error = ''; // JSON is valid // No error has occurred
	            break;
	        case JSON_ERROR_DEPTH:
	            $error = 'The maximum stack depth has been exceeded.';
	            break;
	        case JSON_ERROR_STATE_MISMATCH:
	            $error = 'Invalid or malformed JSON.';
	            break;
	        case JSON_ERROR_CTRL_CHAR:
	            $error = 'Control character error, possibly incorrectly encoded.';
	            break;
	        case JSON_ERROR_SYNTAX:
	            $error = 'Syntax error, malformed JSON.';
	            break;
	        // PHP >= 5.3.3
	        case JSON_ERROR_UTF8:
	            $error = 'Malformed UTF-8 characters, possibly incorrectly encoded.';
	            break;
	        // PHP >= 5.5.0
	        case JSON_ERROR_RECURSION:
	            $error = 'One or more recursive references in the value to be encoded.';
	            break;
	        // PHP >= 5.5.0
	        case JSON_ERROR_INF_OR_NAN:
	            $error = 'One or more NAN or INF values in the value to be encoded.';
	            break;
	        case JSON_ERROR_UNSUPPORTED_TYPE:
	            $error = 'A value of a type that cannot be encoded was given.';
	            break;
	        default:
	            $error = 'Unknown JSON error occured.';
	            break;
	    }

        // throw the Exception or exit // or whatever :)
        return $error;
	}
}

if ( ! function_exists('encode_email'))
{
	function encode_email($e) {
		$output = '';
		for ($i = 0; $i < strlen($e); $i++)
		{
			$output .= '&#'.ord($e[$i]).';';
		}
		return $output;
	}
}

if ( ! function_exists('time_elapsed_string'))
{
	function time_elapsed_string($datetime, $full = false) {
	    $now = new DateTime;
	    $ago = new DateTime($datetime);
	    $diff = $now->diff($ago);

	    $diff->w = floor($diff->d / 7);
	    $diff->d -= $diff->w * 7;

	    $string = array(
	        'y' => 'year',
	        'm' => 'month',
	        'w' => 'week',
	        'd' => 'day',
	        'h' => 'hour',
	        'i' => 'minute',
	        's' => 'second',
	    );
	    foreach ($string as $k => &$v) {
	        if ($diff->$k) {
	            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
	        } else {
	            unset($string[$k]);
	        }
	    }

	    if (!$full) $string = array_slice($string, 0, 1);
	    return $string ? implode(', ', $string) . ' ago' : 'just now';
	}
}
