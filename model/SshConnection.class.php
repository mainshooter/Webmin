<?php
  require_once 'model/databaseHandler.class.php';
  require_once 'model/Security.class.php';
  require_once 'model/User.class.php';

  class SshConnection {

    protected $serverIP;
    protected $serverPort;
    protected $serverUsername;
    protected $serverPassword;

    protected $sshShell;
    // The active ssh connection lives here

    protected $sshConnectionActive = false;
    // If the connection is active


    /**
     * Checks if the SSH connection will work
     * @param  [int] $serverID [description]
     * @return [boolean]           [Returns if the connection is a succes]
     */
    public function sshLogin($serverID) {
      $loginCredentialsResult = $this->getServerCredentials($serverID);
      if ($loginCredentialsResult) {
        $this->sshConnect();
        return(true);
      }

      else {
        return(false);
      }

    }

    /**
     * Starts a ssh connection
     * @return [string on fail or boolean on succes] [The result form the connection and auth]
     */
    protected function sshConnect() {
      $this->sshShell = ssh2_connect($this->serverIP, $this->serverPort);
      // Start the connection
      if ($this->sshShell != false) {
        // We can connect to the server
        if (ssh2_auth_password($this->sshShell, $this->serverUsername, $this->serverPassword)) {
          // connection is a succes
          $this->sshConnectionActive = true;
          return(true);
        }
        // Start the auth

        else {
          // The auth has failt
          $this->sshConnectionActive = false;
          die('Wrong server username or password');
        }
      }

      else {
        // The connection is failt
        die('No connection with the server');
      }
    }


    /**
     * Gets the server credentials and puts them in the class properties
     * @param [int] $serverID [The ID of the server]
     */
    protected function getServerCredentials($serverID) {
      $Db = new db();
      $S = new Security();

      $sql = "SELECT * FROM server WHERE idserver=:serverID";
      $input = array(
        "serverID" => $S->checkInput($serverID)
      );

      $result = $Db->readData($sql, $input);
      if (!empty($result)) {
        foreach ($result as $key) {
          $this->serverIP = $key['serverIP'];
          $this->serverPort = $key['serverPort'];
          $this->serverUsername = $key['serverUsername'];
          $this->serverPassword = $key['serverPassword'];
          break;
        }
        return(true);
      }

      else {
        // When there isn't a server
        return(false);
      }

    }
  }


?>
