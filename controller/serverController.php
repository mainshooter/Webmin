<?php
  require_once 'model/serverManager.class.php';
  require_once 'model/databaseHandler.class.php';
  require_once 'model/Security.class.php';


  class serverController {
    private $ServerManager;
    private $Db;
    private $S;


    /**
     * Starts instans the other classes
     */
    function __construct() {
      $this->ServerManager = new ServerManager();
      $this->Db = new db();
      $this->S = new Security();
    }

    public function index() {
      header('Refresh:0; ' . $GLOBALS['config']['base_url'] . 'dashboard/');
    }

    public function addServer() {

    }

    public function addServerForm() {
      include 'view/header.php';
        include 'view/server/addServerForm.php';
      include 'view/footer.php';
    }

  }

?>
