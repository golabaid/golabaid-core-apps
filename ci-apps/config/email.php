<?php defined('BASEPATH') OR exit('No direct script access allowed');

$config['use_ci_email'] = TRUE; 										// Send Email using the builtin CI email class, if false it will return the code and the identity

/*
Original CI Email Config    | ION AUTH Email Config 												| Default Values 				| Options 							| Descriptions
*/

$config['useragent']		= $config['email_config']['useragent']		= 'PHIMEX';					// Default: CodeIgniter			| Options: None						| Description: The “user agent”.
//$config['protocol']		= $config['email_config']['protocol']		= 'mail';					// Default: mail				| Options: mail, sendmail, or smtp	| Description: The mail sending protocol
//$config['mailpath']		= $config['email_config']['mailpath']		= '/usr/sbin/sendmail';		// Default: /usr/sbin/sendmail	| Options: None						| Description: The server path to Sendmail
//$config['smtp_host']		= $config['email_config']['smtp_host']		= '';						// Default: No Default			| Options: None						| Description: SMTP Server Address
//$config['smtp_user']		= $config['email_config']['smtp_user']		= '';						// Default: No Default			| Options: None						| Description: SMTP Username
//$config['smtp_pass']		= $config['email_config']['smtp_pass']		= '';						// Default: No Default			| Options: None						| Description: SMTP Password
//$config['smtp_port']		= $config['email_config']['smtp_port']		= '25';						// Default: 23					| Options: None						| Description: SMTP Port
//$config['smtp_timeout']	= $config['email_config']['smtp_timeout']	= '5';						// Default: 5					| Options: None						| Description: SMTP Timeout (in seconds)
//$config['smtp_keepalive']	= $config['email_config']['smtp_keepalive']	= FALSE;					// Default: FALSE				| Options: TRUE or FALSE (boolean)	| Description: Enable persistent SMTP connections
//$config['smtp_crypto']	= $config['email_config']['smtp_crypto']	= '';						// Default: No Default			| Options: tls or ssl				| Description: SMTP Encryption
//$config['wordwrap']		= $config['email_config']['wordwrap']		= TRUE;						// Default: TRUE				| Options: TRUE or FALSE (boolean)	| Description: Enable word-wrap
//$config['wrapchars']		= $config['email_config']['wrapchars']		= '76';						// Default: 76					| Options: None						| Description: Character count to wrap at
$config['mailtype']			= $config['email_config']['mailtype']			= 'html';					// Default: text				| Options: text or html				| Description: Type of mail. If you send HTML email you must send it as a complete web page. Make sure you don’t have any relative links or relative image paths otherwise they will not work
//$config['validate']		= $config['email_config']['validate']		= FALSE;					// Default: FALSE				| Options: TRUE or FALSE (boolean)	| Description: Whether to validate the email address
$config['priority']			= $config['email_config']['priority']			= '1';						// Default: 3					| Options: 1, 2, 3, 4, 5			| Description: Email Priority. 1 = highest. 5 = lowest. 3 = normal
//$config['crlf']			= $config['email_config']['crlf']			= '\n';						// Default: \n					| Options: “\r\n” or “\n” or “\r”	| Description: Newline character. (Use “\r\n” to comply with RFC 822)
//$config['newline']		= $config['email_config']['newline']		= '\n';						// Default: \n					| Options: “\r\n” or “\n” or “\r”	| Description: Newline character. (Use “\r\n” to comply with RFC 822)
//$config['bcc_batch_mode']	= $config['email_config']['bcc_batch_mode']	= FALSE;					// Default: FALSE				| Options: TRUE or FALSE (boolean)	| Description: Enable BCC Batch Mode
//$config['bcc_batch_size']	= $config['email_config']['bcc_batch_size']	= '200';					// Default: 200					| Options: None						| Description: Number of emails in each BCC batch
//$config['dsn']			= $config['email_config']['dsn']			= FALSE;					// Default: FALSE				| Options: TRUE or FALSE (boolean)	| Description: Enable notify message from server


$config['email_development']  = TRUE;
$config['execute_send_email'] = 'Cron';																// Default: Instant				| Options: Instant or Cron          | Description: Send email mode, send in realtime or using cron
$config['developer_email'][]  = 'lukman@u-digital.nl';
$config['developer_email'][]  = 'bastian@u-digital.nl';
$config['developer_email'][]  = 'faiz@u-digital.nl';


$config['default_sender_name']		= 'PHIMEX System';
$config['default_sender_email']		= 'no-reply@phimex.nl';
$config['default_replyto_name']		= 'PHIMEX Admin';
$config['default_replyto_email']	= 'admin@phimex.nl';
$config['default_returned_emails']	= 'lukman@u-digital.nl';



/*
 | -------------------------------------------------------------------------
 | Email Template Lists
 | -------------------------------------------------------------------------
 */
$config['email_templates']	   = 'email/';
$config['email_base_template'] = $config['email_templates'].'base_template.tpl.php';

$config['email_activate'] 				  = 'activate.tpl.php';	 		// Activate Account Email Template
$config['email_forgot_password'] 		  = 'forgot_password.tpl.php';	// Forgot Password Email Template
$config['email_forgot_password_complete'] = 'new_password.tpl.php'; 	//Forgot Password Complete Email Template
$config['email_new_registration'] 		  = 'new_registration.tpl.php'; 	//new registration template