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

function my_first_widget($args) {

    extract($args);
    
    echo $before_widget; 
    echo $before_title;
    echo get_option('my_widget_title'); 
    echo $after_title; 
    
    if (get_opt('twitter_show') == "true") {echo "Twitter: ".get_opt('twitter_last_count')."<br/><br/>";}
    if (get_opt('fburner_show') == "true") {echo "Feedburner: ".get_opt('fburner_last_count')."<br/><br/>";}
    if (get_opt('vk_friends_show') == "true") { echo "Друзей VK: ".get_opt('vk_last_friends_count')."<br/>";}
    if (get_opt('vk_group_show') == "true")  {echo "В группе VK: ".get_opt('vk_last_grmemb_count')."<br/>";}
    if (get_opt('vk_public_show') == "true") {echo "Подписаны на паблик VK: ".get_opt('vk_last_public_count')."<br/><br/>";}
    if (get_opt('facebook_show') == "true") {echo "Друзей Facbook: ".get_opt('facebook_last_count')."<br/><br/>";}
    if (get_opt('mymail_show') == "true") {echo "Друзей в моем мире: ".get_opt('mymail_last_count')."<br/><br/>";}

    echo $after_widget; 

}

function register_my_widget() {
    register_sidebar_widget('Social Followers', 'my_first_widget');
    register_widget_control('Social Followers', 'my_widget_control' );
}


function my_widget_control() {
    
    if (!empty($_REQUEST['my_widget_title'])) {
        update_option('my_widget_title', $_REQUEST['my_widget_title']);
    }
?>
    Заголовок&nbsp;:&nbsp;<input type="text" name="my_widget_title" />
<?

}

add_action('init', 'register_my_widget');

//add_action('init', 'social_followers_widget');

?>