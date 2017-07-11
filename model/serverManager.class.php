<?php
  require_once 'model/databaseHander.class.php';
  require_once 'model/User.class.php';

  class ServerManager {

    private $serverIP;
    private $serverPort;
    private $serverUsername;
    private $serverPassword;

    /**
     * Gets all servers from the DB by a userID
     * @return [boolean or arr] [Resturns a boolean if we don't have a server or a assoc array when we have servers]
     */
    public function getServers() {
      $Db = new Db();
      $User = new User();

      $userID = $User->getUserID($_SESSION['userMail']);

      $sql = "SELECT idserver, serverName, serverIP FROM server";
      $input = array();

      $Rows = $Db->countRows($sql, $input);
      if ($Rows >= 1) {
        // If we have a server
        $result = $Db->readData($sql, $input);
        return($result);
      }

      else {
        // We dont have a server
        return(false);
      }
    }

  }


?>
