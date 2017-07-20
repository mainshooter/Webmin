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
    private $SshConnection;


    /**
     * Starts instans the other classes
     */
    function __construct() {
      $this->ServerManager = new ServerManager();
      $this->Db = new db();
      $this->S = new Security();
      $this->User = new User();
      $this->Sshconnection = new SshConnection();
    }

    /**
     * No one can't be here because we don't have a dashboard for the user here
     * That is done by the dashboard ctrl so we send a client to there
     * @return [type] [description]
     */
    public function index() {
      include 'view/header.php';
        include 'view/not-loggedin.php';
      include 'view/footer.php';
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
            include 'view/header.php';
              echo "<h2 class='col-6'>You don't have acces to that server!</h2>";
            include 'view/footer.php';
          }

        }

        else {
          // No server has been send
          include 'view/header.php';
            echo "<h2 class='col-6'>No server seelcted!</h2>";
          include 'view/footer.php';
        }
      }

      else {
        // Not logged in
        include 'view/header.php';
          include 'view/not-loggedin.php';
        include 'view/footer.php';
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
        include 'view/header.php';
          include 'view/not-loggedin.php';
        include 'view/footer.php';
      }

    }

    /**
     * Update controller that sends the update to the ServerManager
     * @param  [arr] $serverID [The ID from the server]
     */
    public function updateServer($serverID) {
      $serverID = $serverID[0];
      $this->User->setPageAcces(['admin']);
      if ($this->User->checkIfUserHasAcces()) {
        if (ISSET($_POST['serverToevoegen']) && ISSET($_POST['serverName']) && ISSET($_POST['serverIP']) && ISSET($_POST['serverPort']) && ISSET($_POST['serverUsername']) && ISSET($_POST['serverPassword'])) {
          $userID = $this->User->getUserID($_SESSION['userMail']);

          if ($this->ServerManager->checkIfServerIsFromUser($userID, $serverID)) {
            $this->ServerManager->updateServer($_POST, $serverID);
          }

          else {
            // Not our server
            include 'view/header.php';
              echo "<h2 class='col-6'>You don't have acces to that server!</h2>";
            include 'view/footer.php';
          }
        }

        else {
          // A user came here by exident
          $this->update($serverID);
        }
      }

      else {
        // Not logged in
        include 'view/header.php';
          include 'view/not-loggedin.php';
        include 'view/footer.php';
      }
    }

    /**
     * Creates a view to update a server
     */
    public function update($serverID) {
      $serverID = $serverID[0];
      $this->User->setPageAcces(['admin']);
      if ($this->User->checkIfUserHasAcces()) {

        $userID = $this->User->getUserID($_SESSION['userMail']);

        if ($this->ServerManager->checkIfServerIsFromUser($userID, $serverID)) {
          $serverName = $this->ServerManager->getServerName($serverID);
          $serverIP = $this->ServerManager->getServerIP($serverID);
          $serverPort = $this->ServerManager->getServerPort($serverID);
          $serverUsername = $this->ServerManager->getServerUsername($serverID);

          include 'view/header.php';
            include 'view/server/updateServerCredentials.php';
          include 'view/footer.php';
        }

        else {
          // Not the server from the client
          include 'view/header.php';
            echo "<h2 class='col-6'>You don't have acces to that server!</h2>";
          include 'view/footer.php';
        }
      }

      else {
        // Not logged in
        include 'view/header.php';
          include 'view/not-loggedin.php';
        include 'view/footer.php';
      }
    }


    /**
     * Gets the details from a server
     * @param  boolean - arr $serverID [If we don´t have a serverID we stop instance and if we have one it is a int]
     */
    public function details($serverID = false) {
      $serverID = $serverID[0];
      $this->User->setPageAcces(['admin']);
      if ($this->User->checkIfUserHasAcces()) {
        if ($serverID != false) {
          // If we have a server details
          // http://www.tonylea.com/2012/how-to-get-memory-and-cpu-usage-in-php/
          $userID = $this->User->getUserID($_SESSION['userMail']);
          if ($this->ServerManager->checkIfServerIsFromUser($userID, $serverID)) {
            $SSHCheckResult = $this->ServerManager->sshLogin($serverID);
            if ($SSHCheckResult) {
              // When we can u login
              $serverName = $this->ServerManager->getServerName($serverID);
              $serverIP = $this->ServerManager->getServerIP($serverID);

              $serverUptime = $this->ServerManager->getServerUptime($serverID);
              $serverRAMUsage = $this->ServerManager->getServerRamUsage($serverID);
              $serverCPU = $this->ServerManager->getServerCPUUsage($serverID);

              include 'view/header.php';
                include 'view/server/serverDetails.php';
              include 'view/footer.php';
            }

            else {
              // Wen we can't login it will display a error
              include 'view/header.php';
                echo "<h2>" . $SSHCheckResult . "</h2>";
              include 'view/footer.php';
            }

          }

          else {
            include 'view/header.php';
              echo "<h2 class='col-6'>You don't have acces to that server!</h2>";
            include 'view/footer.php';
          }

        }

        else {
          // No serverID
          include 'view/header.php';
            echo "<h2 class='col-6'>No serverID selected!</h2>";
          include 'view/footer.php';
        }
      }

      else {
        // Not logged in
        include 'view/header.php';
          include 'view/not-loggedin.php';
        include 'view/footer.php';
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
        include 'view/header.php';
          include 'view/not-loggedin.php';
        include 'view/footer.php';
      }

    }

  }

?>
