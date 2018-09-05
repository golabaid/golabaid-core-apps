<?php defined('BASEPATH') OR exit('No direct script access allowed');

/***
 *
 * Members_lib.php
 *
 * author       : Lucky Mahrus
 * copyright    : Lucky Mahrus (c) 2018
 * license      : https://webdev-lucky.com
 * file         : private/ci-apps/libraries/Members_lib.php
 * created      : 2018 July 2st / 20:00:00
 * last edit    : 2018 July 2st / 20:00:00
 * edited by    : Lucky Mahrus
 * version      : 1.0
 *
 */



class Members_lib extends General_lib
{
	/**
	 * __get
	 *
	 * Enables the use of CI super-global without having to define an extra variable.
	 *
	 * I can't remember where I first saw this, so thank you if you are the original author. -Militis
	 *
	 * @param    string $var
	 *
	 * @return    mixed
	 */
	public function __get($var)
	{
		return get_instance()->$var;
	}

	public function __construct()
	{

	}
}
