<?php defined('BASEPATH') OR exit('No direct script access allowed');

/***
 *
 * MY_url_helper.php
 *
 * author		: Lucky Mahrus
 * copyright	: Lucky Mahrus (c) 2015
 * license		: http://www.webdev-lucky.com/
 * file			: private/application/apps/helpers/MY_url_helper.php
 * created		: 2015 October 21th / 23:20:46
 * last edit	: 2015 October 21th / 23:20:46
 * edited by	: Lucky Mahrus
 * version		: 1.0
 *
 */


if ( ! function_exists('main_url'))
{
	function main_url($uri = '', $protocol = NULL)
	{
		return get_instance()->config->main_url($uri, $protocol);
	}
}

if ( ! function_exists('api_url'))
{
	function api_url($uri = '', $protocol = NULL)
	{
		return get_instance()->config->api_url($uri, $protocol);
	}
}

if ( ! function_exists('admin_url'))
{
	function admin_url($uri = '', $protocol = NULL)
	{
		return get_instance()->config->admin_url($uri, $protocol);
	}
}

if ( ! function_exists('cdn_url'))
{
	function cdn_url($uri = '', $protocol = NULL)
	{
		return get_instance()->config->cdn_url($uri, $protocol);
	}
}

if ( ! function_exists('files_url'))
{
	function files_url($uri = '', $protocol = NULL)
	{
		return get_instance()->config->files_url($uri, $protocol);
	}
}

if ( ! function_exists('assets_url'))
{
	function assets_url($uri = '', $protocol = NULL)
	{
		return get_instance()->config->assets_url($uri, $protocol);
	}
}

if ( ! function_exists('site_name'))
{
	function site_name()
	{
		return get_instance()->config->site_name();
	}
}
	
if ( ! function_exists('encode_string'))
{
	function encode_string($e) {
		$output = '';
		for ($i = 0; $i < strlen($e); $i++)
		{
			$output .= '&#'.ord($e[$i]).';';
		}
		return $output;
	}
}

 
/* End of file MY_url_helper.php */
/* Location: private/application/apps/helpers/MY_url_helper.php */

