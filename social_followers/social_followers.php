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
 ?>
   <style>
   .sf-counter {
    width:110px;
    height: 28px;
    float:left;
   }
   .sf-cimg {
    width: 25px;
    height: 25px;
    float: left;
   }
   .sf-cnmr {
    padding-top: 2px;
    padding-left: 5px;
    width: 70px;
    height: 25px;
    float: left;
    font-size: 10px;
   }
   </style>
<?php 
print '<div id="social-followers">';

    if (get_opt('twitter_show') == "true") {
      echo "<div class='sf-counter'>";
      echo '<div class="sf-cimg"><img src="' .plugins_url( 'social_followers/images/twt.png' , dirname(__FILE__) ). '" width="25" height="25"/></div>';
      echo "<div class='sf-cnmr'>".get_opt('twitter_last_count')."<br/>подписчиков</div>";
      echo "</div>";
    }

    if (get_opt('fburner_show') == "true") {
      echo "<div class='sf-counter'>";
      echo '<div class="sf-cimg"><img src="' .plugins_url( 'social_followers/images/feed.png' , dirname(__FILE__) ). '" width="25" height="25"/></div>';
      echo "<div class='sf-cnmr'>".get_opt('fburner_last_count')."<br/>читателей</div>";
      echo "</div>";
    }
    if (get_opt('vk_friends_show') == "true") {
       echo "<div class='sf-counter'>";
      echo '<div class="sf-cimg"><img src="' .plugins_url( 'social_followers/images/vk.png' , dirname(__FILE__) ). '" width="25" height="25"/></div>';
      echo "<div class='sf-cnmr'>".get_opt('vk_last_friends_count')."<br/>друзей</div>";
      echo "</div>";
    }
    if (get_opt('vk_group_show') == "true") {
       echo "<div class='sf-counter'>";
      echo '<div class="sf-cimg"><img src="' .plugins_url( 'social_followers/images/vk.png' , dirname(__FILE__) ). '" width="25" height="25"/></div>';
      echo "<div class='sf-cnmr'>".get_opt('vk_last_grmemb_count')."<br/>участников</div>";
      echo "</div>";
    }
    if (get_opt('vk_public_show') == "true") {
       echo "<div class='sf-counter'>";
      echo '<div class="sf-cimg"><img src="' .plugins_url( 'social_followers/images/vk.png' , dirname(__FILE__) ). '" width="25" height="25"/></div>';
      echo "<div class='sf-cnmr'>".get_opt('vk_last_public_count')."<br/>подписчиков</div>";
      echo "</div>";
    }
    if (get_opt('facebook_show') == "true") {
       echo "<div class='sf-counter'>";
      echo '<div class="sf-cimg"><img src="' .plugins_url( 'social_followers/images/fb.png' , dirname(__FILE__) ). '" width="25" height="25"/></div>';
      echo "<div class='sf-cnmr'>".get_opt('facebook_last_count')."<br/>друзей</div>";
      echo "</div>";
    }
    if (get_opt('mymail_show') == "true") {
      echo "<div class='sf-counter'>";
      echo '<div class="sf-cimg"><img src="' .plugins_url( 'social_followers/images/mail.png' , dirname(__FILE__) ). '" width="25" height="25"/></div>';
      echo "<div class='sf-cnmr'>".get_opt('mymail_last_count')."<br/>друзей</div>";
      echo "</div>";
    }
    if (get_opt('wppost_show') == "true") {
      echo "<div class='sf-counter'>";
      echo '<div class="sf-cimg"><img src="' .plugins_url( 'social_followers/images/wordpress.png' , dirname(__FILE__) ). '" width="25" height="25"/></div>';
      echo "<div class='sf-cnmr'>".get_totalposts()."<br/>постов</div>";
      echo "</div>";
    }
    if (get_opt('wpcomment_show') == "true") {
      echo "<div class='sf-counter'>";
      echo '<div class="sf-cimg"><img src="' .plugins_url( 'social_followers/images/wordpress.png' , dirname(__FILE__) ). '" width="25" height="25"/></div>';
      echo "<div class='sf-cnmr'>".get_totalcomments()."<br/>комментов</div>";
      echo "</div>";
    }




    
print '</div>';
    
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


add_action('socialfollowers_hourly_event', 'sf_do_this_hourly');

// The action will trigger when someone visits your WordPress site
function sf_cron_activation() {
    if ( !wp_next_scheduled( 'socialfollowers_hourly_event' ) ) {
        wp_schedule_event( current_time( 'timestamp' ), 'twicedaily', 'socialfollowers_hourly_event');
    }
}
add_action('wp', 'sf_cron_activation');

function sf_do_this_hourly() {

    if (ping('http://api.twitter.com')=='live'){
      set_opt('twitter_last_count',getTwtCount(get_opt("twitter_login")));
    }
    if (ping('http://feeds.feedburner.com/~fc/me')=='live'){
      set_opt('fburner_last_count',get_fburn(get_opt("fburner_login")));
    }
    if (ping('https://api.vk.com/method/friends.get')=='live'){
      if (get_opt('vk_token')!=="") { set_opt('vk_last_friends_count',getVKmeters('friends')); }
      if ((get_opt('vk_token')!=="") and ((get_opt('vk_group_id')!=="") )) { set_opt('vk_last_grmemb_count',getVKmeters('group_members',get_opt('vk_group_id')));}
      if ((get_opt('vk_token')!=="") and ((get_opt('vk_public_id')!==""))) { set_opt('vk_last_public_count',getVKmeters('public_followers',get_opt('vk_public_id')));}
    }
    if (ping('https://www.facebook.com/')=='live'){
      if ((get_opt("facebook_login")!=="") and (get_opt("facebook_appId")!=="") and (get_opt("facebook_appSecret")!=="")) {
    set_opt('facebook_last_count',getFacebookCount());
        }
    }

    if (ping('http://api.mail.ru')=='live'){
      if(get_opt('mymail_refresh_token')!==""){ set_opt('mymail_last_count',getMyMailCount());} 
    }   


}

?>