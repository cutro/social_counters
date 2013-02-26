<?php
require_once('fburn.class.php');
require_once('src/facebook.php');
function create_menu(){
    //Проверим существует ли функция add_options_page 
    if (function_exists('add_options_page'))
    {
        //Добавляем пункт меню в Параметры
        add_options_page('Social Followers - Настройки', 'Social Followers', 8, 'socialfollowers', 'soc_cPageOptions');
    }
}


function soc_cPageOptions()
{

if ($_REQUEST['save_twitter']) {
    set_opt('twitter_login',$_POST["twitter_login"]);
    if ($_POST["twitter_show"]) {
      set_opt('twitter_show','true');
    } else {set_opt('twitter_show','false');}

  set_opt('twitter_last_count',getTwtCount($_POST["twitter_login"]));
}

if ($_REQUEST['save_feedburner']) {
    set_opt('fburner_login',$_POST["fburner_login"]);
    if ($_POST["fburner_show"]) { set_opt('fburner_show','true'); } else {set_opt('fburner_show','false');}
    set_opt('fburner_last_count',get_fburn($_POST["fburner_login"]));
}

if ($_REQUEST['save_vk']) {
 
  set_opt('vk_login',$_POST["vk_login"]);
  set_opt('vk_appId',$_POST["vk_appId"]);
  set_opt('vk_SecureKey',$_POST["vk_SecureKey"]);
  set_opt('vk_token',$_POST["vk_token"]);
  set_opt('vk_group_id',$_POST["vk_group_id"]);
  set_opt('vk_public_id',$_POST["vk_public_id"]);

    if ($_POST["vk_friends_show"]) { set_opt('vk_friends_show','true'); } else {set_opt('vk_friends_show','false');}
    if ($_POST["vk_group_show"]) { set_opt('vk_group_show','true'); } else {set_opt('vk_group_show','false');}
    if ($_POST["vk_public_show"]) { set_opt('vk_public_show','true'); } else {set_opt('vk_public_show','false');}
    if (get_opt('vk_token')!=="") { set_opt('vk_last_friends_count',getVKmeters('friends')); }
    if ((get_opt('vk_token')!=="") and ((get_opt('vk_group_id')!=="") or ($_POST["vk_group_id"]!==""))) { set_opt('vk_last_grmemb_count',getVKmeters('group_members',$_POST["vk_group_id"]));}
    if ((get_opt('vk_token')!=="") and ((get_opt('vk_public_id')!=="") or ($_POST["vk_public_id"]!==""))) { set_opt('vk_last_public_count',getVKmeters('public_followers',$_POST["vk_public_id"]));}
}

if ($_REQUEST['save_facebook']) {
  set_opt('facebook_login',$_POST["facebook_login"]);
  set_opt('facebook_appId',$_POST["facebook_appId"]);
  set_opt('facebook_appSecret',$_POST["facebook_appSecret"]);
  if ($_POST["facebook_show"]) { set_opt('facebook_show','true'); } else {set_opt('facebook_show','false');}
  if (($_POST["facebook_login"]!=="") and ($_POST["facebook_appId"]!=="") and ($_POST["facebook_appSecret"]!=="")) {
    set_opt('facebook_last_count',getFacebookCount());
  }
   
}

if ($_REQUEST['save_mymail']) {
  set_opt('mymail_id',$_POST["mymail_id"]);
  set_opt('mymail_Secret',$_POST["mymail_Secret"]);
  if ($_POST["mymail_show"]) { set_opt('mymail_show','true'); } else {set_opt('mymail_show','false');}
 if(get_opt('mymail_refresh_token')!==""){ set_opt('mymail_last_count',getMyMailCount());}
   
}


//global scope
 $out_rediretBack = "http://".$_SERVER['SERVER_NAME'].$_SERVER['PHP_SELF']."?page=socialfollowers";
 $out_rediretBackMymail = "http://".$_SERVER['SERVER_NAME'].$_SERVER['PHP_SELF']."?page=socialfollowers";
//twitter scope
$out_twitter_login = get_opt('twitter_login');
$out_twitter_last_count = get_opt('twitter_last_count');
if (get_opt('twitter_show') == "true") {$out_twitter_active = " checked ";};
//feedburner scope
$out_fburner_login = get_opt('fburner_login');
$out_fburner_last_count = get_opt('fburner_last_count');
if (get_opt('fburner_show') == "true") {$out_fburner_active = " checked ";};
//vk scope
$out_vk_login = get_opt('vk_login');
$out_vk_group_id = get_opt('vk_group_id');
$out_vk_public_id = get_opt('vk_public_id');
$out_vk_appId = get_opt('vk_appId');
$out_vk_SecureKey = get_opt('vk_SecureKey');
$out_vk_token = get_opt('vk_token');
$out_vk_last_friends_count = get_opt('vk_last_friends_count');
$out_vk_last_grmemb_count = get_opt('vk_last_grmemb_count');
$out_vk_last_public_count = get_opt('vk_last_public_count');
$out_vk_getTokenLink = "http://api.vk.com/oauth/authorize?client_id=".$out_vk_appId."&redirect_uri=".$out_rediretBack."&scope=friends,pages,offline&display=page&response_type=token";
if (get_opt('vk_friends_show') == "true") {$out_vk_friends_show = " checked ";};
if (get_opt('vk_group_show') == "true") {$out_vk_group_show = " checked ";};
if (get_opt('vk_public_show') == "true") {$out_vk_public_show = " checked ";};
//facebook scope
$out_facebook_last_count = get_opt('facebook_last_count');
$out_facebook_login = get_opt('facebook_login');
$out_facebook_appId = get_opt('facebook_appId');
$out_facebook_appSecret = get_opt('facebook_appSecret');
if (get_opt('facebook_show') == "true") {$out_facebook_active = " checked ";};
//mymail scope
$out_mymail_last_count = get_opt('mymail_last_count');
$out_mymail_id = get_opt('mymail_id');
$out_mymail_Secret = get_opt('mymail_Secret');
$out_mymail_tokenLink = "https://connect.mail.ru/oauth/authorize?client_id=".$out_mymail_id."&response_type=code&scope=stream&redirect_uri=".$out_rediretBackMymail;
if (get_opt('mymail_show') == "true") {$out_mymail_active = " checked ";};
//


?>
  <script type='text/javascript'> jQuery(document).ready(function() { 
    var hashcode = document.location.hash;
    hashcode = hashcode.split('&',1);
    hashcode = hashcode[0].substr(14);
    if (hashcode.length > 10) {alert ("Скопируйте это в поле token: "+hashcode);}
  }); </script>
<?php
if (@$_GET['code']) {
  if (get_opt('mymail_refresh_token')==""){
 //print "<h1>".$_GET['code']."</h1>";
 $codes = $_GET['code'];
      //Собираем все данные и формируем отправку POST
 $cid = get_opt('mymail_id');
 $msct = get_opt('mymail_Secret');
      $params = array(
          "client_id" => $cid,
          "client_secret" => $msct,
          "grant_type" => "authorization_code",
          "scope" => "stream",
          "code" => $codes,
          "redirect_uri" => $out_rediretBackMymail,
        );
      $post = http_build_query($params);;
      $url = "https://connect.mail.ru/oauth/token";
      $headers = array("POST /oauth/token HTTP/1.1
                       Host: connect.mail.ru
                       Accept: */*
                       Content-Length: ".strlen($post)."
                       Content-Type: application/x-www-form-urlencoded");
      $ch5 = curl_init();
      curl_setopt($ch5, CURLOPT_URL, $url);
      curl_setopt($ch5, CURLOPT_RETURNTRANSFER, 1);
      curl_setopt($ch5, CURLOPT_SSL_VERIFYPEER, 0);
      curl_setopt($ch5, CURLOPT_TIMEOUT, 60);
      curl_setopt($ch5, CURLOPT_HTTPHEADER, $headers);
      curl_setopt($ch5, CURLOPT_POST, 1);
      curl_setopt($ch5, CURLOPT_POSTFIELDS, $post);
      $result = curl_exec($ch5);
      curl_close($ch5);
      $obj = json_decode($result);
      $refresh_token = $obj->{'refresh_token'}; // refresh token для обновления ключа access token
      echo "<h1>".$refresh_token."</h1>";
      set_opt('mymail_refresh_token',$refresh_token);
    }
}

$html_out = <<<EOD
<div class="wrap">
<div id="icon-options-general" class="icon32"><br></div>
<h2>Social Counters</h2>
<table class="form-table">
<tbody>

<form method="post" action="" enctype="multipart/form-data">
<tr valign="top"><td><h2>Twitter ($out_twitter_last_count)</h2></td></tr>
<tr valign="top">
<th scope="row"><label for="twitter_login">Логин</label></th>
<td><input name="twitter_login" type="text" id="twitter_login" value="$out_twitter_login" class="regular-text"></td>
</tr>
<tr valign="top">
<th scope="row">Настройки</th>
<td> <fieldset><legend class="screen-reader-text"><span></span></legend><label for="twitter_show">
<input name="twitter_show" type="checkbox" id="twitter_show" $out_twitter_active />
Включить счетчик</label>
</fieldset></td>
</tr>
<tr valign="top"><td><input type="submit" name="save_twitter" id="submit" class="button button-primary" value="Сохранить изменения"></td></tr>
</form>

<form method="post" action="" enctype="multipart/form-data">
<tr valign="top"><td><h2>FeedBurner ($out_fburner_last_count)</h2></td></tr>
<tr valign="top">
<th scope="row"><label for="fburner_login">Логин</label></th>
<td><input name="fburner_login" type="text" id="fburner_login" value="$out_fburner_login" class="regular-text"></td>
</tr>
<tr valign="top">
<th scope="row">Настройки</th>
<td> <fieldset><legend class="screen-reader-text"></legend><label for="fburner_show">
<input name="fburner_show" type="checkbox" id="fburner_show" $out_fburner_active />
Включить счетчик</label>
</fieldset></td>
</tr>
<tr valign="top"><td><input type="submit" name="save_feedburner" id="submit" class="button button-primary" value="Сохранить изменения"></td></tr>
</form>

<form method="post" action="/wp-admin/options-general.php?page=socialfollowers" enctype="multipart/form-data">
<tr valign="top"><td><h2>ВКонтакте ($out_vk_last_friends_count/$out_vk_last_grmemb_count/$out_vk_last_public_count)</h2></td></tr>
<tr valign="top">
<th scope="row"><label for="vk_login">Имя профиля / ID</label></th>
<td><input name="vk_login" type="text" id="vk_login" value="$out_vk_login" class="regular-text"></td>
</tr>
<tr valign="top">
<th scope="row"><label for="vk_appId">ID приложения</label></th>
<td><input name="vk_appId" type="text" id="vk_appId" value="$out_vk_appId" class="regular-text"></td>
</tr>
<tr valign="top">
<th scope="row"><label for="vk_SecureKey">Ключ приложения</label></th>
<td><input name="vk_SecureKey" type="text" id="vk_SecureKey" value="$out_vk_SecureKey" class="regular-text"></td>
</tr>
<tr valign="top">
<th scope="row"><label for="vk_token">token</label></th>
<td><input name="vk_token" type="text" id="vk_token" value="$out_vk_token" class="regular-text">
<p class="description">Заполните первые три поля, нажмите сохранить, после этого <a href="$out_vk_getTokenLink">получите token</a><br/>затем снова нажмите сохранить.</p></td>
</tr>

<tr valign="top">
<th scope="row"><label for="vk_group_id">Имя группы / ID</label></th>
<td><input name="vk_group_id" type="text" id="vk_group_id" value="$out_vk_group_id" class="regular-text"></td>
</tr>
<tr valign="top">
<th scope="row"><label for="vk_public_id">Имя public страницы / ID</label></th>
<td><input name="vk_public_id" type="text" id="vk_public_id" value="$out_vk_public_id" class="regular-text"></td>
</tr>

<tr valign="top">
<th scope="row">Настройки</th>
<td> <fieldset><legend class="screen-reader-text"><span></span></legend>
<label for="vk_friends_show"><input name="vk_friends_show" type="checkbox" id="vk_friends_show" $out_vk_friends_show />
Включить счетчик друзей</label><br/>
<label for="vk_group_show"><input name="vk_group_show" type="checkbox" id="vk_group_show"  $out_vk_group_show />
Включить счетчик участников группы</label><br/>
<label for="vk_public_show"><input name="vk_public_show" type="checkbox" id="vk_public_show" $out_vk_public_show />
Включить счетчик подписчиков public страницы</label><br/>
</fieldset></td>
</tr>
<tr valign="top"><td><input type="submit" name="save_vk" id="vk_save" class="button button-primary" value="Сохранить изменения"></td></tr>
</form>

<form method="post" action="" enctype="multipart/form-data">
<tr valign="top"><td><h2>Facebook ($out_facebook_last_count)</h2></td></tr>
<tr valign="top">
<th scope="row"><label for="facebook_login">Логин</label></th>
<td><input name="facebook_login" type="text" id="facebook_login" value="$out_facebook_login" class="regular-text"></td>
</tr>
<tr valign="top">
<th scope="row"><label for="facebook_appId">App ID/API Key</label></th>
<td><input name="facebook_appId" type="text" id="facebook_appId" value="$out_facebook_appId" class="regular-text"></td>
</tr>
<tr valign="top">
<th scope="row"><label for="facebook_appSecret">Секрет приложения</label></th>
<td><input name="facebook_appSecret" type="text" id="facebook_appSecret" value="$out_facebook_appSecret" class="regular-text"></td>
</tr>
<tr valign="top">
<th scope="row">Настройки</th>
<td> <fieldset><legend class="screen-reader-text"><span></span></legend><label for="twitter_show">
<input name="facebook_show" type="checkbox" id="facebook_show" $out_facebook_active />
Включить счетчик</label>
</fieldset></td>
</tr>
<tr valign="top"><td><input type="submit" name="save_facebook" id="submit" class="button button-primary" value="Сохранить изменения"></td></tr>
</form>


<form method="post" action="" enctype="multipart/form-data">
<tr valign="top"><td><h2>Мой мир ($out_mymail_last_count)</h2></td></tr>
<tr valign="top">
<th scope="row"><label for="mymail_id">ID Сайта</label></th>
<td><input name="mymail_id" type="text" id="mymail_id" value="$out_mymail_id" class="regular-text"></td>
</tr>
<tr valign="top">
<th scope="row"><label for="mymail_Secret">Secret Сайта</label></th>
<td><input name="mymail_Secret" type="text" id="mymail_Secret" value="$out_mymail_Secret" class="regular-text">
<p class="description">Заполните все поля, нажмите сохранить, после этого <a href="$out_mymail_tokenLink">разрешите получать данные</a><br/> с mail.ru.</p></td>
</tr>
<tr valign="top">
<th scope="row">Настройки</th>
<td> <fieldset><legend class="screen-reader-text"><span></span></legend><label for="mymail_show">
<input name="mymail_show" type="checkbox" id="mymail_show" $out_mymail_active />
Включить счетчик</label>
</fieldset></td>
</tr>
<tr valign="top"><td><input type="submit" name="save_mymail" id="submit" class="button button-primary" value="Сохранить изменения"></td></tr>
</form>

</tbody></table>
</div>
EOD;
echo $html_out;
print get_opt('sf_opt');
}



function get_opt($opt){
    global $wpdb;
    $dbtable = $wpdb->prefix."socialfollowers";
    $newtable = $wpdb->get_results( "SELECT * FROM ".$dbtable." WHERE `option`='".$opt."';" );
    return $newtable[0]->value;
}
function set_opt($opt,$value){
    global $wpdb;
    $dbtable = $wpdb->prefix."socialfollowers";
    $newtable = $wpdb->query( "UPDATE ".$dbtable." SET `value`='".$value."' WHERE `option`='".$opt."';" );
    return $newtable;
}

function install(){
    global $wpdb;
    $wpdb->query("CREATE TABLE `".$wpdb->prefix."socialfollowers` (
        `ID` INT(10) UNSIGNED NULL AUTO_INCREMENT,
        `option` VARCHAR(40),
        `value` TEXT,
        PRIMARY KEY (`ID`))");
    $wpdb->query("INSERT INTO `".$wpdb->prefix."socialfollowers` VALUES('','fburner_login','')");
    $wpdb->query("INSERT INTO `".$wpdb->prefix."socialfollowers` VALUES('','fburner_last_count','-0')");
    $wpdb->query("INSERT INTO `".$wpdb->prefix."socialfollowers` VALUES('','fburner_show','false')");

    $wpdb->query("INSERT INTO `".$wpdb->prefix."socialfollowers` VALUES('','twitter_login','')");
    $wpdb->query("INSERT INTO `".$wpdb->prefix."socialfollowers` VALUES('','twitter_last_count','-0')");
    $wpdb->query("INSERT INTO `".$wpdb->prefix."socialfollowers` VALUES('','twitter_show','false')");

    $wpdb->query("INSERT INTO `".$wpdb->prefix."socialfollowers` VALUES('','facebook_login','')");
    $wpdb->query("INSERT INTO `".$wpdb->prefix."socialfollowers` VALUES('','facebook_last_count','-0')");
    $wpdb->query("INSERT INTO `".$wpdb->prefix."socialfollowers` VALUES('','facebook_appId','')");
    $wpdb->query("INSERT INTO `".$wpdb->prefix."socialfollowers` VALUES('','facebook_appSecret','')");
    $wpdb->query("INSERT INTO `".$wpdb->prefix."socialfollowers` VALUES('','facebook_token','')");
    $wpdb->query("INSERT INTO `".$wpdb->prefix."socialfollowers` VALUES('','facebook_show','false')");

    $wpdb->query("INSERT INTO `".$wpdb->prefix."socialfollowers` VALUES('','vk_login','')");
    $wpdb->query("INSERT INTO `".$wpdb->prefix."socialfollowers` VALUES('','vk_group_id','')");
    $wpdb->query("INSERT INTO `".$wpdb->prefix."socialfollowers` VALUES('','vk_public_id','')");
    $wpdb->query("INSERT INTO `".$wpdb->prefix."socialfollowers` VALUES('','vk_last_friends_count','-0')");
    $wpdb->query("INSERT INTO `".$wpdb->prefix."socialfollowers` VALUES('','vk_last_grmemb_count','-0')");
    $wpdb->query("INSERT INTO `".$wpdb->prefix."socialfollowers` VALUES('','vk_last_public_count','-0')");
    $wpdb->query("INSERT INTO `".$wpdb->prefix."socialfollowers` VALUES('','vk_appId','')");
    $wpdb->query("INSERT INTO `".$wpdb->prefix."socialfollowers` VALUES('','vk_SecureKey','')");
    $wpdb->query("INSERT INTO `".$wpdb->prefix."socialfollowers` VALUES('','vk_token','')");
    $wpdb->query("INSERT INTO `".$wpdb->prefix."socialfollowers` VALUES('','vk_friends_show','false')");
    $wpdb->query("INSERT INTO `".$wpdb->prefix."socialfollowers` VALUES('','vk_group_show','false')");
    $wpdb->query("INSERT INTO `".$wpdb->prefix."socialfollowers` VALUES('','vk_public_show','false')");

    $wpdb->query("INSERT INTO `".$wpdb->prefix."socialfollowers` VALUES('','mymail_id','')");
    $wpdb->query("INSERT INTO `".$wpdb->prefix."socialfollowers` VALUES('','mymail_Secret','')");
    $wpdb->query("INSERT INTO `".$wpdb->prefix."socialfollowers` VALUES('','mymail_refresh_token','')");
    $wpdb->query("INSERT INTO `".$wpdb->prefix."socialfollowers` VALUES('','mymail_last_count','')");
    $wpdb->query("INSERT INTO `".$wpdb->prefix."socialfollowers` VALUES('','mymail_show','false')");

    $wpdb->query("INSERT INTO `".$wpdb->prefix."socialfollowers` VALUES('','refresh_time','24')");
}

function deactivate(){
    global $wpdb;
    $wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}socialfollowers");
}


function getTwtCount($name){
      $twUrl = 'http://api.twitter.com/1/users/show.xml?screen_name=' . $name;
      $followers = 0;
      $timeout = intval($options['requestTimeOut']);
      $errorCode = '';
      $avatar = '';
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
      curl_setopt($ch, CURLOPT_TIMEOUT, 20);
      curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.9.0.3) Gecko/2008092417 Firefox/3.0.3');
      curl_setopt($ch, CURLOPT_URL, $twUrl);
      $xml = curl_exec($ch);
      $info = curl_getinfo($ch);
      curl_close($ch);
      $http_code = $info['http_code'];
      if ($http_code == 200) {
        $user = new SimpleXMLElement($xml);
        $followers = (string) $user->followers_count;
        $avatar = (string) $user->profile_image_url;
      }
      return $followers;
    }

function getVKmeters($response,$id=''){
      $token = get_opt('vk_token');
      if ($response=="friends") {
        $sRequest = "https://api.vk.com/method/friends.get?fields=first_name,last_name&access_token=".$token;  
        $oResponce = json_decode(file_get_contents($sRequest));
        return count($oResponce->response);
      }
      if ($response=="group_members") {
        $gRequest = "https://api.vk.com/method/groups.getMembers?gid=".$id."&access_token=".$token;
        $gResponce = json_decode(file_get_contents($gRequest));
        return $gResponce->response->count;
      }
      if ($response=="public_followers") {
        $pRequest = "https://api.vk.com/method/groups.getMembers?gid=".$id."&access_token=".$token;
        $pResponce = json_decode(file_get_contents($pRequest));
        return $pResponce->response->count;
      }
    }

function getFacebookCount() {
  $appId = get_opt('facebook_appId');
  $appSecret = get_opt('facebook_appSecret');
  $login = get_opt('facebook_login');
  $response = file_get_contents("https://graph.facebook.com/{$login}");
  $json = json_decode($response);
  $userId = $json->id;

  $response = file_get_contents("https://graph.facebook.com/oauth/access_token?client_id={$appId}&client_secret={$appSecret}&grant_type=client_credentials");
  parse_str($response, $params);
  $appAccess = $params['access_token'];
  // Create our Application instance (replace this with your appId and secret).
  $facebook = new Facebook(array(
  'appId'  => $appId,
  'secret' => $appSecret,
  'cookie' => true,
));
$facebook->setAccessToken($appAccess);
 try {
            $fql = "SELECT friend_count FROM user WHERE uid = $userId";
            $fqlData = $facebook->api(array(
              'method' => 'fql.query',
              'query' => $fql,
            ));
            $fc = $fqlData[0]['friend_count'];
          }
          catch( FacebookApiException $e ) {
            //  error_log($e);
            $fc = -1;

            $fbPic = '';
            $fbLink = '';
            $error = $e->__toString();
}

return $fc;


}
  function getMyMailCount(){
  $cid = get_opt('mymail_id');
 $msct = get_opt('mymail_Secret');
    $params = array(
          "client_id" => $cid,
          "client_secret" => $msct,
          "grant_type" => "refresh_token",
          "refresh_token" => get_opt('mymail_refresh_token'),
 
        );
      $post = http_build_query($params);;
      $url = "https://connect.mail.ru/oauth/token";
      $headers = array("POST /oauth/token HTTP/1.1
                       Host: connect.mail.ru
                       Accept: */*
                       Content-Length: ".strlen($post)."
                       Content-Type: application/x-www-form-urlencoded");
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, $url);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
      curl_setopt($ch, CURLOPT_TIMEOUT, 60);
      curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
      curl_setopt($ch, CURLOPT_POST, 1);
      curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
      $result = curl_exec($ch);
      curl_close($ch);
     

      // Получаем JSON и начнем его обрабатывать
      $obj = json_decode($result);

      // Полученные данные
      $muid = $obj->{'x_mailru_vid'}; // ID сессии пользователя
      $sess_key = $obj->{'access_token'}; // Полученный access token (24 часа действует)
      $refresh_token = $obj->{'refresh_token'}; // refresh token для обновления ключа access token
      $expires_in = $obj->{'expires_in'}; // Время жизни ключа access token в секундах

       // Формируем запрос данных users.getInfo
       $params = array(
          "format" => "xml", // xml or json
          "method" => "users.getInfo",
          "app_id" => $cid,
          "session_key" => $sess_key,
          "uids" => $muid,
          "secure" => "1"
        );

      // Получаем данные
      $url = "http://www.appsmail.ru/platform/api?".http_build_query($params)."&sig=".sign_server_server($params,$msct);
      $response = file_get_contents($url);
      $xmlc = simplexml_load_string($response);
      return $xmlc->user->friends_count;
}

// Формируем подпись SING (функция для моего мира)
      function sign_server_server(array $request_params, $secret_key) {
          ksort($request_params);
          $params = '';
          foreach ($request_params as $key => $value) {
              if ($key!='sig') {
                  $params .= "$key=$value";
                }
            }
         return md5($params.$secret_key);
        }

function SF_widget() {
  print "вывод виджета социальщины";
}
?>