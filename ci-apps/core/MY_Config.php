<?php defined('BASEPATH') OR exit('No direct script access allowed');

/***
 *
 * MY_Config.php
 *
 * author		: Lucky Mahrus
 * copyright	: Lucky Mahrus (c) 2015
 * license		: http://www.webdev-lucky.com/
 * file			: private/application/apps/core/MY_Config.php
 * created		: 2015 October 21th / 23:20:46
 * last edit	: 2015 October 21th / 23:20:46
 * edited by	: Lucky Mahrus
 * version		: 1.0
 *
 */

/* load the MX_Loader class */
require APPPATH."third_party/MX/Config.php";

class MY_Config extends MX_Config
{
	public function main_url($uri = '', $protocol = NULL)
	{
		$main_url = $this->slash_item('main_url');

		if (isset($protocol))
		{
			// For protocol-relative links
			if ($protocol === '')
			{
				$main_url = substr($main_url, strpos($main_url, '//'));
			}
			else
			{
				$main_url = $protocol.substr($main_url, strpos($main_url, '://'));
			}
		}

		return $main_url.ltrim($this->_uri_string($uri), '/');
	}

	public function api_url($uri = '', $protocol = NULL)
	{
		$api_url = $this->slash_item('api_url');

		if (isset($protocol))
		{
			// For protocol-relative links
			if ($protocol === '')
			{
				$api_url = substr($api_url, strpos($api_url, '//'));
			}
			else
			{
				$api_url = $protocol.substr($api_url, strpos($api_url, '://'));
			}
		}

		return $api_url.ltrim($this->_uri_string($uri), '/');
	}

	public function admin_url($uri = '', $protocol = NULL)
	{
		$admin_url = $this->slash_item('admin_url');

		if (isset($protocol))
		{
			// For protocol-relative links
			if ($protocol === '')
			{
				$admin_url = substr($admin_url, strpos($admin_url, '//'));
			}
			else
			{
				$admin_url = $protocol.substr($admin_url, strpos($admin_url, '://'));
			}
		}

		return $admin_url.ltrim($this->_uri_string($uri), '/');
	}

	public function cdn_url($uri = '', $protocol = NULL)
	{
		$cdn_url = $this->slash_item('cdn_url');

		if (isset($protocol))
		{
			// For protocol-relative links
			if ($protocol === '')
			{
				$cdn_url = substr($cdn_url, strpos($cdn_url, '//'));
			}
			else
			{
				$cdn_url = $protocol.substr($cdn_url, strpos($cdn_url, '://'));
			}
		}

		return $cdn_url.ltrim($this->_uri_string($uri), '/');
	}

	public function files_url($uri = '', $protocol = NULL)
	{
		$files_url = $this->slash_item('files_url');

		if (isset($protocol))
		{
			// For protocol-relative links
			if ($protocol === '')
			{
				$files_url = substr($files_url, strpos($files_url, '//'));
			}
			else
			{
				$files_url = $protocol.substr($files_url, strpos($files_url, '://'));
			}
		}

		return $files_url.ltrim($this->_uri_string($uri), '/');
	}

	public function assets_url($uri = '', $protocol = NULL)
	{
		$assets_url = $this->slash_item('assets_url');

		if (isset($protocol))
		{
			// For protocol-relative links
			if ($protocol === '')
			{
				$assets_url = substr($assets_url, strpos($assets_url, '//'));
			}
			else
			{
				$assets_url = $protocol.substr($assets_url, strpos($assets_url, '://'));
			}
		}

		return $assets_url.ltrim($this->_uri_string($uri), '/');
	}

	public function site_name()
	{
		$site_name = $this->slash_item('site_name');

		return $site_name;
	}
}


/* End of file MY_Config.php */
/* Location: private/application/apps/core/MY_Config.php */

