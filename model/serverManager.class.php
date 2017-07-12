<?php
  require_once 'model/databaseHandler.class.php';
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

    /**
     * Gets the server credentials and puts them in the class properties
     */
    public function getServerCredentials($serverID) {
      $Db = new db();
      $S = new Security();

      $sql = "SELECT * FROM server WHERE idserver=:serverID";
      $input = array(
        "serverID" => $s->checkInput($serverID)
      );

      $result = $Db->readData($sql, $input);
      foreach ($result as $key) {
        $this->serverIP = $key['serverIP'];
        $this->serverPort = $key['serverPort'];
        $this->serverUsername = $key['serverUsername'];
        $this->serverPassword = $key['serverPassword'];
        break;
      }
    }

    /**
     * Gets the online or offline server status
     * @param [string] $serverIP [The IP adress of the server]
     * @return [string] [With the status the server]
     */
    public function getServerStatus($serverIP) {
      $serverPing = exec("ping -n 1 $serverIP", $output, $status);
      // Ping result contains the text from the exec
      // status contains if the ping as been succeded
        if (0 == $status) {
            $status = "online";
        } else {
            $status = "offline";
        }

        return($status);
    }

  }


?>
