<?php
  require_once 'model/ServerManager.class.php';
  require_once 'model/databaseHandler.class.php';
  require_once 'model/Security.class.php';
  require_once 'model/User.class.php';


  class serverController {
    private $ServerManager;
    private $Db;
    private $S;
    private $User;


    /**
     * Starts instans the other classes
     */
    function __construct() {
      $this->ServerManager = new ServerManager();
      $this->Db = new db();
      $this->S = new Security();
      $this->User = new User();
    }

    /**
     * No one can't be here because we don't have a dashboard for the user here
     * That is done by the dashboard ctrl so we send a client to there
     * @return [type] [description]
     */
    public function index() {
      header('Refresh:0; ' . $GLOBALS['config']['base_url'] . 'dashboard/');
    }

    /**
     * Gets the uptime from a server and present it to the view!
     */
    public function serverUptime($serverID = false) {
      $this->User->setPageAcces(['admin']);
      if ($this->User->checkIfUserHasAcces()) {
        if ($serverID != false) {

          $serverID = $serverID[0];
          $userID = $this->User->getUserID($_SESSION['userMail']);

          if ($this->ServerManager->checkIfServerIsFromUser($userID, $serverID)) {
            echo $this->ServerManager->getServerUptime($serverID);
          }

          else {
            // We don't have acces to that server
          }

        }

        else {
          // No server has been send
        }
      }

      else {
        // Not logged in
      }


    }

    /**
     * The controller method to add a new server to the DB
     */
    public function addServer() {
      $this->User->setPageAcces(['admin']);
      if ($this->User->checkIfUserHasAcces()) {
        if (ISSET($_POST['serverToevoegen']) && ISSET($_POST['serverName']) && ISSET($_POST['serverIP']) && ISSET($_POST['serverPort']) && ISSET($_POST['serverUsername']) && ISSET($_POST['serverPassword'])) {
          $this->ServerManager->addServer($_POST, $_SESSION['userMail']);
          header('Refresh:0; ' . $GLOBALS['config']['base_url'] . 'dashboard/');
        }

        else {
          // When there is missing a post value
          include 'view/header.php';
            include 'view/server/addServerForm.php';
          include 'view/footer.php';
        }

      }

      else {
        // No acces a user isn't logged in
        header('Refresh:0; ' . $GLOBALS['config']['base_url'] . '');
      }

    }

    /**
     * Create the view to add a server
     */
    public function addServerForm() {
      $this->User->setPageAcces(['admin']);
      if ($this->User->checkIfUserHasAcces()) {
        include 'view/header.php';
          include 'view/server/addServerForm.php';
        include 'view/footer.php';
      }

      else {
        // Not logged in
        header('Refresh:0; ' . $GLOBALS['config']['base_url'] . '');
      }

    }

  }

?>
