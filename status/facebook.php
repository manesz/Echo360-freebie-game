<?php
//include_once("libs/facebook/FacebookJavaScriptLoginHelper.php");
//
//use libs\facebook\FacebookRequest;
//use libs\facebook\GraphUser;
//use libs\facebook\FacebookRequestException;
//use libs\facebook\FacebookJavaScriptLoginHelper;
//
//$helper = new FacebookRedirectLoginHelper('your redirect URL here');
//$loginUrl = $helper->getLoginUrl();
?>

<fb:login-button perms="email,publish_stream"
                 onlogin="window.location='index.php'">
</fb:login-button>