<?php
  require_once 'config.php';
  require_once 'model/Router.class.php';

  $Router = new Router();

  $Router->installedPath = $GLOBALS['config']['base_url'];

  $Router->standardController = 'display';
  $Router->customURLs = array(
    "login" => "/user/login/",
    "logout" => "/user/logout/"
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
