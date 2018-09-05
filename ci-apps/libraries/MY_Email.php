<?php defined('BASEPATH') OR exit('No direct script access allowed');

/***
 *
 * MY_Email.php
 *
 * author       : Lucky Mahrus
 * copyright    : Lucky Mahrus (c) 2018
 * license      : https://webdev-lucky.com
 * file         : private/ci-apps/libraries/MY_Email.php
 * created      : 2018 July 2st / 20:00:00
 * last edit    : 2018 July 2st / 20:00:00
 * edited by    : Lucky Mahrus
 * version      : 1.0
 *
 */


class MY_Email extends CI_Email
{
	protected $_attachment_files 	= array();

	protected $_debug_msgs 			= array();

	protected $_subject_original	= '';

	protected $_original_recipient	= '';

	protected $_sender_email		= '';

	protected $_sender_name			= '';

	/**
	 * config items
	 */
	protected $email_development;
	protected $developer_email;
	protected $email_templates;
	protected $email_base_template;
	protected $default_sender_name;
	protected $default_sender_email;
	protected $default_replyto_name;
	protected $default_replyto_email;
	protected $default_returned_emails;
	protected $execute_send_email;

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

	/**
	 * Initialize preferences
	 *
	 * @param	array	$config
	 * @return	CI_Email
	 */
	public function initialize(array $config = array())
	{
		$this->clear();

		foreach ($config as $key => $val)
		{
			if (isset($this->$key))
			{
				$method = 'set_'.$key;

				if (method_exists($this, $method))
				{
					$this->$method($val);
				}
				else
				{
					$this->$key = $val;
				}
			}
			else
			{
				$this->$key = $val;
			}
		}

		$this->charset = strtoupper($this->charset);
		$this->_smtp_auth = isset($this->smtp_user[0], $this->smtp_pass[0]);

		return $this;
	}

	/**
	 * Assign file attachments
	 *
	 * @param	string	$file	Can be local path, URL or buffered content
	 * @param	string	$disposition = 'attachment'
	 * @param	string	$newname = NULL
	 * @param	string	$mime = ''
	 * @return	CI_Email
	 */
	public function attach($file, $disposition = '', $newname = NULL, $mime = '')
	{
		if ($mime === '')
		{
			if (strpos($file, '://') === FALSE && ! file_exists($file))
			{
				$this->_set_error_message('lang:email_attachment_missing', $file);
				return FALSE;
			}

			if ( ! $fp = @fopen($file, 'rb'))
			{
				$this->_set_error_message('lang:email_attachment_unreadable', $file);
				return FALSE;
			}

			$file_content = stream_get_contents($fp);
			$mime = $this->_mime_types(pathinfo($file, PATHINFO_EXTENSION));
			fclose($fp);
		}
		else
		{
			$file_content =& $file; // buffered file
		}

		$this->_attachment_files[]	= $file;

		$this->_attachments[]	= array(
			'name'			=> array($file, $newname),
			'disposition'	=> empty($disposition) ? 'attachment' : $disposition,  // Can also be 'inline'  Not sure if it matters
			'type'			=> $mime,
			'content'		=> chunk_split(base64_encode($file_content)),
			'multipart'		=> 'mixed'
		);

		return $this;
	}

	/**
	 * Set Message
	 *
	 * @param	string	$msg
	 * @param	string	$val = ''
	 * @return	void
	 */
	protected function _set_error_message($msg, $val = '')
	{
		$CI =& get_instance();
		$CI->lang->load('email');

		if (sscanf($msg, 'lang:%s', $line) !== 1 OR FALSE === ($line = $CI->lang->line($line)))
		{
			$this->_debug_msg[] = str_replace('%s', $val, $msg).'<br />';
			$this->_debug_msgs[] = trim(str_replace('%s', '', $msg));
		}
		else
		{
			$this->_debug_msg[] = str_replace('%s', $val, $line).'<br />';
			$this->_debug_msgs[] = trim(str_replace('%s', '', $line));
		}

		$this->_email_logs();
	}

	protected function _email_logs()
	{
		$this->load->model('email_logs_model','email_logs');

		$sqlData['src_controller']		= $this->router->class;
		$sqlData['src_method']			= $this->router->method;
		$sqlData['sender_email']		= $this->_sender_email;
		$sqlData['sender_name']			= $this->_sender_name;
		$sqlData['subject']				= $this->_subject;
		$sqlData['subject_original']	= $this->_subject_original;
		$sqlData['body']				= $this->_body;
		$sqlData['finalbody']			= $this->_finalbody;
		$sqlData['header_str']			= $this->_header_str;
		$sqlData['replyto_flag']		= $this->_replyto_flag;
		$sqlData['recipients']			= ((is_array($this->_recipients))			? implode(',',$this->_recipients) 			: $this->_recipients);
		$sqlData['original_recipient']	= ((is_array($this->_original_recipient))	? implode(',',$this->_original_recipient) 	: $this->_original_recipient);
		$sqlData['cc_array']			= ((is_array($this->_cc_array))				? implode(',',$this->_cc_array) 			: $this->_cc_array);
		$sqlData['bcc_array']			= ((is_array($this->_bcc_array))			? implode(',',$this->_bcc_array) 			: $this->_bcc_array);
		$sqlData['headers']				= ((is_array($this->_headers))				? implode(',',$this->_headers) 				: $this->_headers);
		$sqlData['debug_msg']			= ((is_array($this->_debug_msg))			? implode(',',$this->_debug_msg) 			: $this->_debug_msg);
		$sqlData['attachment_files']	= ((is_array($this->_attachment_files))		? implode(',',$this->_attachment_files) 	: $this->_attachment_files);


		if(in_array(trim(str_replace('%s', '', $this->lang->line('email_sent'))), $this->_debug_msgs))
		{
			$sqlData['status']		= 'SENT';
		}
		elseif(in_array(trim(str_replace('%s', '', $this->lang->line('email_outbox'))), $this->_debug_msgs))
		{
			$sqlData['status']		= 'OUTBOX';
		}
		elseif(
			in_array(trim(str_replace('%s', '', $this->lang->line('email_must_be_array'))), $this->_debug_msgs)			||
			in_array(trim(str_replace('%s', '', $this->lang->line('email_invalid_address'))), $this->_debug_msgs)		||
			in_array(trim(str_replace('%s', '', $this->lang->line('email_attachment_missing'))), $this->_debug_msgs)	||
			in_array(trim(str_replace('%s', '', $this->lang->line('email_attachment_unreadable'))), $this->_debug_msgs)	||
			in_array(trim(str_replace('%s', '', $this->lang->line('email_no_from'))), $this->_debug_msgs)				||
			in_array(trim(str_replace('%s', '', $this->lang->line('email_no_recipients'))), $this->_debug_msgs)			||
			in_array(trim(str_replace('%s', '', $this->lang->line('email_send_failure_phpmail'))), $this->_debug_msgs)	||
			in_array(trim(str_replace('%s', '', $this->lang->line('email_send_failure_sendmail'))), $this->_debug_msgs)	||
			in_array(trim(str_replace('%s', '', $this->lang->line('email_send_failure_smtp'))), $this->_debug_msgs)		||
			in_array(trim(str_replace('%s', '', $this->lang->line('email_no_socket'))), $this->_debug_msgs)				||
			in_array(trim(str_replace('%s', '', $this->lang->line('email_no_hostname'))), $this->_debug_msgs)			||
			in_array(trim(str_replace('%s', '', $this->lang->line('email_smtp_error'))), $this->_debug_msgs)			||
			in_array(trim(str_replace('%s', '', $this->lang->line('email_no_smtp_unpw'))), $this->_debug_msgs)			||
			in_array(trim(str_replace('%s', '', $this->lang->line('email_failed_smtp_login'))), $this->_debug_msgs)		||
			in_array(trim(str_replace('%s', '', $this->lang->line('email_smtp_auth_un'))), $this->_debug_msgs)			||
			in_array(trim(str_replace('%s', '', $this->lang->line('email_smtp_auth_pw'))), $this->_debug_msgs)			||
			in_array(trim(str_replace('%s', '', $this->lang->line('email_smtp_data_failure'))), $this->_debug_msgs)		||
			in_array(trim(str_replace('%s', '', $this->lang->line('email_exit_status'))), $this->_debug_msgs)		
		)
		{
			$sqlData['status']		= 'FAILED';
		}
		else
		{
			$sqlData['status']		= 'OUTBOX';
		}

		$this->email_logs->insert($sqlData);
	}

	public function prepare($sender_name=NULL,$sender_email=NULL,$recipients=NULL,$cc=NULL,$bcc=NULL,$subject=NULL,$data=NULL,$template=NULL,$attachment=NULL,$realtime_execution=NULL)
	{
        $oldData    = $data;
        if(is_object($oldData))
        {
            $data = array();
            foreach ($oldData as $key => $value)
            {
                $data[$key] = $value;
            }
        }

		$this->email->clear(TRUE);

        if(!is_null($attachment))
        {
	        if(is_array($attachment) && count($attachment) > 0)
	        {
	            foreach ($attachment as $idxA => $file)
	            {
	                $this->email->attach($file);
	                $this->email->attachment_cid($file);
	            }
	        }
	        else
	        {
                $this->email->attach($attachment);
                $this->email->attachment_cid($attachment);
	        }
        }

        $this->_sender_email	= $sender_email;
        $this->_sender_name		= $sender_name;

		$this->email->from($sender_email, $sender_name, $this->default_returned_emails);

		if(isset($this->default_replyto_email) && $this->default_replyto_email <> '')
		{
			$this->email->reply_to($this->default_replyto_email, ((isset($this->default_replyto_name)) ? $this->default_replyto_name : ''));
		}

		$original_recipient	= $recipients;
		if(isset($this->email_development) && $this->email_development == TRUE)
		{
			$recipients 					= $this->developer_email;
			$body['original_recipient']	= $data['original_recipient']	= $this->_original_recipient	= $original_recipient;
		}
		$this->email->to($recipients);

		if(!is_null($cc))
		{
			$this->email->cc($cc);
		}

		if(!is_null($bcc))
		{
			$this->email->bcc($bcc);
		}

		$this->_subject_original	= $subject;
		$this->email->subject($subject);

		if(!is_null($template))
		{
	        $message = $this->load->view($this->email_templates.$template, $data, true);

	        if(isset($this->email_base_template) && !is_null($this->email_base_template))
	        {
	        	$body['text']	= $message;
	        	$message = $this->load->view($this->email_base_template, $body, true);
	        }
		}
		else
		{
	        $message = $data;
		}
		$this->email->message($message);

		if($realtime_execution)
		{
			$this->execute_send_email = 'Instant';
		}

		return $this->email->send();
	}

	/**
	 * Spool mail to the mail server
	 *
	 * @return	bool
	 */
	protected function _spool_email()
	{
		$this->_unwrap_specials();

		$protocol = $this->_get_protocol();
		$method   = '_send_with_'.$protocol;

		if(!isset($this->execute_send_email) || (isset($this->execute_send_email) && (is_null($this->execute_send_email) || empty($this->execute_send_email) || $this->execute_send_email == 'Instant')))
		{
			if (! $this->$method())
			{
				$this->_set_error_message('lang:email_send_failure_'.($protocol === 'mail' ? 'phpmail' : $protocol));
				return FALSE;
			}

			$this->_set_error_message('lang:email_sent', $protocol);
		}
		else
		{
			$this->_set_error_message('lang:email_outbox');
		}

		return TRUE;
	}
}