<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

define('UPLOAD_PATH', 'upload/');

$ci=& get_instance();
$ci->load->helper('url');

$config['sender_email'] = 'politikei@politikei.org';
$config['contact_email'] = 'guga.guerchon@gmail.com';
$config['admin_email'] = 'guga.guerchon@gmail.com';
$config['encode_code_word'] = 'azerty123456';
$config['default_avatar'] = base_url('/assets/img/avatar.png');
$config['default_avatar_fake'] = base_url('/assets/img/avatar_fake.png');
$config['default_image'] = base_url('/assets/img/image.png');

$config['available_languages'] = array('pt' => 'portugues-br'); //, 'en' => 'english');
$config['available_locales'] = array('pt' => 'pt_BR'); //, 'en' => 'en_US');
$config['locale'] = 'pt_BR';

/*
$config['root_path'] = APPPATH.'../';
$config['upload_path'] = 'upload/';
$config['media_path'] = UPLOAD_PATH.'medias/';
$config['cache_path'] = UPLOAD_PATH.'cache/';
$config['cache_media'] = TRUE;
*/

/* old custom.php file
define('SENDER_EMAIL', 'hhlets@gmail.com');
define('CONTACT_EMAIL', 'hhlets@gmail.com');
define('ADMIN_EMAIL', 'thierry@thde.pro');
define('ENCODE_CODE_WORD', 'azerty123456');
define('ROOT_PATH',APPPATH.'../');
define('UPLOAD_PATH', 'upload/');
define('MEDIA_PATH', UPLOAD_PATH.'medias/');
define('CACHE_PATH', UPLOAD_PATH.'cache/');
define('DEFAULT_AVATAR', '/assets/img/avatar.png');
define('DEFAULT_AVATAR_FAKE', '/assets/img/avatar_fake.png');
define('DEFAULT_IMAGE', '/assets/img/image.png');
define('CACHE_MEDIA', TRUE);
*/

/* End of file custom.php */
/* Location: ./application/config/custom.php */