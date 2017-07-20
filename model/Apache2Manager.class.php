<?php
  require_once 'model/ServerManager.class.php';
  require_once 'model/Security.class.php';

  class Apache2Manager extends ServerManager {

    private $S;

    /**
     * Enables all needed classes
     */
    function __construct() {
      $this->S = new Security();
    }

    public function newWebsite() {

    }

    public function deleteWebsite() {

    }

    /**
     * Enables a website trough Apache2
     * @param  [INT] $serverID   [The ID of the server]
     * @param  [string] $websiteURL [The URL of the website]
     * @return [boolean]             [On succes returns true on fail it returns false]
     */
    public function enableWebsite($serverID, $websiteURL) {
      $serverID = $S->checkInput($serverID);
      $websiteURL = $S->checkInput($websiteURL);

      if ($this->sshLogin($serverID)) {
        $this->executeSshCommand('sudo su');
        $this->executeSshCommand($this->serverPassword);
        $this->executeSshCommand('cd /etc/apache2/sites-available/');
        $this->executeSshCommand('a2ensite ' . $websiteURL . '.conf');
        return(true);
      }
      else {
        return(false);
      }
    }

    /**
     * Gata all websites from a server
     * @param  [int] $serverID [The ID of the server]
     * @return [type]           [description]
     */
    public function getAllWebsites($serverID) {
      $serverID = $S->checkInput($serverID);

      if ($this->sshLogin($serverID)) {
        $this->executeSshCommand('sudo su');
        $this->executeSshCommand($this->serverPassword);
        $directoryContent = $this->executeSshCommand('ls /etc/apache2/sites-available/');
      }
      else {
        return(false);
      }
    }

    public function disableWebsite() {

    }


  }




?>
