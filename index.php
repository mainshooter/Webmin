<?php
session_start();

ini_set('display_errors', 1);
error_reporting(E_ALL);
ini_set("display_errors", 1);

  require_once 'config.php';
  require_once 'model/Router.class.php';

  $Router = new Router();

  $Router->installedPath = $GLOBALS['config']['base_url'];

  $Router->standardController = 'user';
  $Router->customURLs = array(
    "login" => "user/loginForm/",
    "logout" => "user/logout/",
    "register" => "user/registerForm/",
    "serverToevoegen" => "server/addServerForm/"
  );
  $Router->customUrl();
  $Router->parseUrl();

  $Router->getController();
  $Router->getMethod();
  $Router->getParameters();

  $Router->parseRouter();

  if ($GLOBALS['config']['router-debug'] == true) {
    $Router->routerDebug();
  }


?>
