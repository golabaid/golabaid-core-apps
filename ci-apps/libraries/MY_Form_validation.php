<?php defined('BASEPATH') OR exit('No direct script access allowed');

/***
 *
 * MY_Form_validation.php
 *
 * author		: Lucky Mahrus
 * copyright	: Lucky Mahrus (c) 2016
 * license		: https://webdev-lucky.com
 * file			: private/apps/libraries/MY_Form_validation.php
 * created		: 2016 July 28th / 08:00:00
 * last edit	: 2016 July 28th / 08:00:00
 * edited by	: Lucky Mahrus
 * version		: 1.0
 *
 */

class MY_Form_validation extends CI_Form_validation
{
	/**
	 * Reference to the CodeIgniter instance
	 *
	 * @var object
	 */
	protected $CI;

	/**
	 * Initialize Form_Validation class
	 *
	 * @param	array	$rules
	 * @return	void
	 */
	public function __construct($rules = array())
	{
		$this->CI =& get_instance();
	}

	/**
	 * Is Existed
	 *
	 * Check if the input value is existed
	 * in the specified database field.
	 *
	 * @param	string	$str
	 * @param	string	$field
	 * @return	bool
	 */
	public function is_existed($str, $field)
	{
		sscanf($field, '%[^.].%[^.]', $table, $field);

		return isset($this->CI->db)
			? ($this->CI->db->limit(1)->get_where($table, array($field => $str))->num_rows() === 1)
			: FALSE;
	}

	/**
	 * Strong Password
	 *
	 * @param	string
	 * @return	bool
	 */
	public function strong_password($str, $len='8,20')
	{
		return (bool) preg_match("#.*^(?=.{".$len."})(?=.*[a-z]{1,})(?=.*[A-Z]{1,})(?=.*[0-9]{1,}).*$#", $str);
	}

	/**
	 * Super Password
	 *
	 * @param	string
	 * @return	bool
	 */
	public function super_password($str, $len='8,20')
	{
		return (bool) preg_match("#.*^(?=.{".$len."})(?=.*[a-z]{1,})(?=.*[A-Z]{1,})(?=.*[0-9]{1,})(?=.*\W{1,}).*$#", $str);
	}

    public function clear_field_data()
    {

        $this->_field_data = array();
        return $this;
    }
}


/* End of file MY_Form_validation.php */
/* Location: private/apps/libraries/MY_Form_validation.php */


