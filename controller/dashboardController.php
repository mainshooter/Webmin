<?php
  require_once 'model/user.class.php';
  require_once 'model/Security.class.php';
  require_once 'model/ServerManager.class.php';

  class dashboardController {
    private $User;
    private $S;
    private $ServerManager;

    public function __construct() {
      $this->User = new User();
      $this->S = new Security();
      $this->ServerManager = new ServerManager();
    }

    public function index() {
      $this->getServers();
    }

    public function getServers() {
      $this->User->setPageAcces(['admin']);
      if ($this->User->checkIfUserHasAcces()) {
        $servers = $this->ServerManager->getServers();
        include 'view/header.php';
        if ($servers != false) {
          // If we have a server
            include 'view/dashboard/serversList.php';

        }

        else {
          // When we don't have any servers
          include 'view/dashbord/no-servers.html';
        }

        include 'view/footer.php';
      }

      else {
        // header('Refresh:0; ' . $GLOBALS['config']['base_url'] . '');
      }

    }

  }




?>
