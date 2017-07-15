<?php
  require_once 'model/User.class.php';
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

    /**
     * Gets all servers from the serverManager
     */
    public function getServers() {
      $this->User->setPageAcces(['admin']);
      if ($this->User->checkIfUserHasAcces()) {
        $userID = $this->User->getUserID($_SESSION['userMail']);
        $servers = $this->ServerManager->getServers($userID);

        if ($servers != false) {
          // If we have a server
          $serverStatus;
          foreach ($servers as $key) {
            $serverStatus[] = $this->ServerManager->getServerStatus($key['serverIP']);
          }
            include 'view/header.php';
              include 'view/dashboard/serversList.php';
            include 'view/footer.php';

        }

        else {
          // When we don't have any servers
          include 'view/header.php';
            include 'view/dashboard/no-servers.html';
          include 'view/footer.php';
        }

      }

      else {
        include 'view/header.php';
          include 'view/not-loggedin.php';
        include 'view/footer.php';
      }

    }

  }




?>
