<?php

/**
 * @file
 * Check if consumer token is set and if so send user to get a request token.
 */

/**
 * Exit with an error message if the CONSUMER_KEY or CONSUMER_SECRET is not defined.
 */
session_start();
require_once('config.php');
require_once('twitteroauth/twitteroauth.php');
if (CONSUMER_KEY === '' || CONSUMER_SECRET === '' || CONSUMER_KEY === 'CONSUMER_KEY_HERE' || CONSUMER_SECRET === 'CONSUMER_SECRET_HERE') {
  echo 'You need a consumer key and secret to test the sample code. Get one from <a href="https://dev.twitter.com/apps">dev.twitter.com/apps</a>';
  exit;
}

if(!empty($_SESSION['oauth_token']) && !empty($_SESSION['oauth_token_secret'])){
	$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $_SESSION['oauth_token'], $_SESSION['oauth_token_secret']);
	$login = true;
}else{
	$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET);
	$login = false;
}
$token_credentials = $connection->getAccessToken($_REQUEST['oauth_verifier']);
$_SESSION['oauth_access_token'] = $token_credentials['oauth_token'];
$_SESSION['oauth_access_token_secret'] = $token_credentials['oauth_token_secret'];
$connection=new TwitterOAuth(CONSUMER_KEY,CONSUMER_SECRET,$_SESSION['oauth_access_token'],$_SESSION['oauth_access_token_secret']);
$amigosID = $connection->get('friends/ids', array('screen_name' => $_SESSION['user']))->{'ids'};
$amigos = "";
$n = 0;
//$var_dump($amigosID);
foreach ($amigosID as $id) {
	if($n<99){
		if($amigos == ""){
			$amigos = $id;
		}else{
			$amigos = $amigos.",".$id;
		}
		$n = $n +1;
	}else{
		$amigos = $amigos.",".$id;
		$n = 0;
		//var_dump($amigos);
		$listAmigos = $connection->get('users/lookup', array('user_id' => $amigos));
		//var_dump($listAmigos);
		foreach ($listAmigos as $id) {
			if($login){
				$connection->post('friendships/create', array('user_id' => $id->{'id'}, 'follow' => true));
				usleep(300000);
				//$connection->post('friendships/destroy', array('user_id' => $id->{'id'}));
			}
		}
		$amigos = "";
	}
}
?>
<html>
	<head>
	    <meta charset="utf-8">
	    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	    <meta name="description" content="">
	    <meta name="author" content="">

	    <title>EasyFollow</title>

		<script src="jquery.min.js"></script>
	    <link href="bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
	    <script src="bootstrap/dist/js/bootstrap.min.js"></script>
		
	</head>
	<body>
		<div class="container" style="margin-top:1%">
			<div class="row">
		        <div class="span12">
		            <h1>Success!</h1>
		        </div>
			</div>
		</div>
	</body>
</html>
