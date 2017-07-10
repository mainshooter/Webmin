<?php

  class Router {
    public $installedPath = '';
    public $standardController = '';
    public $standardMethod = 'index';

    public $translateControllerNames;
    // $translateControllerNames[name of the translation] = the name of the real controller
    // Contains the new value for a controller name

    public $customURLs;
    // Contains a customer url
    // When someone does /login/
    // It will replace that with the correct controller and method
    // So that will be /user/login/

    private $url;
    private $path;
    private $controller;
    private $method;
    private $parameters;

    public function __construct() {
      $this->url = $this->getUrl();
    }

    /**
     * Transform the url to a customer url
     * So when someone goes the /login/
     * We go to our custom url we defined for it
     * We define the url as property in the $customerURLs as a array
     * array(
     *  "login" => "user/logout";
     * );
     */
    public function customUrl() {
      $url = str_replace($this->installedPath, '', $this->url);
      // To get our current URL

      $url = str_replace('/', '', $this->url);
      // To remove any / after the word
      if (!empty($this->customURLs)) {
        // If we have any customer urls
        foreach ($this->customURLs as $key => $value) {
          if ($key == $url) {
            $this->url = $value;
            break;
          }
        }
      }
    }

    /**
     * Parse the url to a array
     */
    public function parseUrl() {
        $this->path = str_replace($this->installedPath, '', $this->url);
        // We remove the installed path from the url
        // So we get the correct url
        $this->path = explode('/', $this->path);
    }


    private function translateControllerName() {
      if (ISSET($this->translateControllerNames[$this->controller])) {
        // If there is a array in the translate arr with the value we need
        $this->controller = $this->translateControllerNames[$this->controller];
      }
    }

    /**
     * Parse the router calls the controller, method and send some parameters
     */
    public function parseRouter() {
      require_once 'controller/' . $this->controller . "Controller.php";

      $this->controller = $this->controller . 'Controller';
      $controller = new $this->controller;
      $method = $this->method;
      $parameters = $this->parameters;
      call_user_func_array(array($controller, $method), [$parameters]);
    }

    /**
     * Gets the controller from the path
     * We first check if there is a ctrl
     * If there isn't a ctrl set we set the default ctrl
     */
    public function getController() {
      if (!empty($this->path[0])) {
        // Check if there is a path
        $controller = $this->path[0];
        if (file_exists('controller/' . $controller . 'Controller.php')) {
          // Check if there is a controller
          $this->controller = $controller;
        }
        else {
          // We will set the default controller to be used
          $this->controller = $this->standardController;
        }
      }

      else {
        $this->controller = $this->standardController;
      }
    }

    /**
     * Gets the method
     * If the method doens't exists we set a default method
     */
    public function getMethod() {
      if (!empty($this->path[1])) {
        // To check if we have a method comeing in
        $method = $this->path[1];
        if (method_exists($this->controller, $method)) {
          $this->method = $method;
        }

        else {
          $this->method = $this->standardMethod;
        }
      }

      else {
        $this->method = $this->standardMethod;
      }
    }

    /**
     * gets the parameters from the path
     * We first check if there is any parameters
     */
    public function getParameters() {
      if (!empty($this->path[0]) && !empty($this->path[1])) {
        $parameters = $this->path;
        unset($parameters[0]);
        unset($parameters[1]);
        // To remove the method and the controller
        $this->parameters = $parameters;
      }
      else {
        $this->parameters = array();
      }

    }

    public function routerDebug() {
      echo '<div style="font-size: 1.6em;padding: 1em;">';
        echo "<h2 style='padding: 0; margin: 4px;'>Router debug</h2>";
        echo "Url: " . $this->url;
        echo "<br>";
        echo "Path: ";
        echo "<pre>";
          var_dump($this->path);
        echo "</pre>";
        echo "<br>";
        echo "Controller: " . $this->controller;
        echo "<br>";
        echo "Methode: " . $this->method;
        echo "<br>";
        echo "Parameters: ";
        echo "<pre>";
        var_dump($this->parameters);
        echo "</pre>";
        echo "</br>";
        echo "Custom URLs";
        echo "<pre>";
          var_dump($this->customURLs);
        echo "</pre>";
      echo "</div>";
    }

    /**
     * gets the url
     * @return [string] [The url]
     */
    public function getUrl() {
      $url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
      return($url);
    }
  }


?>
