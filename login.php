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

$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET);

$request_token = $connection->getRequestToken(OAUTH_CALLBACK);
$request_link = $connection->getAuthorizeURL($request_token);
var_dump($request_token);
var_dump($request_link);

/* Save temporary credentials to session. */
$_SESSION['oauth_token'] = $token = $request_token['oauth_token'];
$_SESSION['oauth_token_secret'] = $request_token['oauth_token_secret'];
if(substr($_POST['user'], 0, 1) === "@"){
	$_SESSION['user'] = substr($_POST['user'], 1);
}else{
	$_SESSION['user'] = $_POST['user'];
}

	 
/* If last connection failed don't display authorization link. */
switch ($connection->http_code) {
	case 200:
	    $url = $connection->getAuthorizeURL($token);
	    header('Location: ' . $url);
	    break;
	default:
	    echo 'Could not connect to Twitter. Refresh the page or try again later.';
}