<?php
/**
 * @package Social
 * @version 0.6
 */
/* 
  Plugin Name: Social folowers 
  Author: Sergey Vygonnoj 
  Author URI: http://cutro.ru/me
  Version: 0.6
  Plugin URI: http://cutro.ru//
  Description: Счетчик подписчиков во всякой социальщине
*/ 
require_once('functions.php');
register_activation_hook( __FILE__, 'install');
register_deactivation_hook( __FILE__, 'deactivate');
add_action('admin_menu', 'create_menu');

?>