<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// To use reCAPTCHA, you need to sign up for an API key pair for your site.
// link: http://www.google.com/recaptcha/admin
// $config['recaptcha_site_key'] = '6LcejzEUAAAAAJypQB8hUNoNW5bWOywUpOTSwW_d';
// $config['recaptcha_secret_key'] = '6LcejzEUAAAAALXGGAWJ5ZeH65yGxI56zVHHN9yP';

$config['recaptcha_site_key'] = '6LcejzEUAAAAAJypQB8hUNoNW5bWOywUpOTSwW_d';
$config['recaptcha_secret_key'] = '6LcejzEUAAAAALXGGAWJ5ZeH65yGxI56zVHHN9yP';

// reCAPTCHA supported 40+ languages listed here:
// https://developers.google.com/recaptcha/docs/language
$config['recaptcha_lang'] = 'en';

/* End of file recaptcha.php */
/* Location: ./application/config/recaptcha.php */
