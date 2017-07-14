<?php
require_once 'databaseHandler.class.php';
require_once 'Security.class.php';

 class User {
   private $mail;
   private $password;
   private $loginToken;
   private $pageAcces;

   function __construct() {
     $this->loginToken = 'h79vr29hu3pqhf-249pgae';
   }

   /**
    * User login handler
    * @param  [string] $userInputMail     [The mail adress that the user filled in]
    * @param  [string] $userInputPassword [The password the user filled in]
    * @param [string] $redirectLocation The location that we need the user to redirect to
    * @param [boolean] [If the login is not succesed we send a false]
    */
   public function userLogin($userInputMail, $userInputPassword, $redirectLocation) {
     if ($this->checkIfEmailExists($userInputMail)) {

       $orginalHashedPassword = $this->getOrginalPassword($userInputMail);

       if ($this->validatePassword($userInputPassword, $orginalHashedPassword)) {
         $this->saveUserCredentials($userInputMail);
         $this->setLoginToken();
         $this->setUserGroup($userInputMail);
         header("Refresh:0; " . $redirectLocation);
       }
       else {
          return(false);
       }
     }

     else {
       return(false);
     }
   }

   /**
    * Gets the userID from a user by mail
    * @param  [string] $userMail [The mail adress of a user]
    * @return [int]           [The userID of the user]
    */
   public function getUserID($userMail) {
     $Db = new db();
     $S = new Security();

       $sql = "SELECT iduser FROM user WHERE `mail`=:mail LIMIT 1";
       $input = array(
         "mail" => $S->checkInput($userMail)
       );
       $result = $Db->readData($sql, $input);
       foreach ($result as $key) {
         return($key['iduser']);
         break;
       }
   }

   /**
    * Gets the mail from a user by the userID
    * @param  [int] $userID [The ID of the user]
    * @return [string]         [The mail adress from the user or a error message that nothing has been found]
    */
   public function getUserMail($userID) {
     $Db = new db();
     $S = new Security();

     $sql = "SELECT `mail` FROM user WHERE iduser=:userID LIMIT 1";
     $input = array(
       "userID" => $S->checkInput($userID)
     );
     $result = $Db->readData($userID);

     if (!empty($result)) {
       foreach ($result as $key) {
         return($key['mail']);
         break;
       }
     }

     else {
       return("No result from DB");
     }
   }

   /**
    * Logs a user out
    * @param [string] $redirectLocation [Were a client needs to go to after the logout]
    */
   public function userLogout($redirectLocation) {
     unset($_SESSION['loginToken']);
     unset($_SESSION['userMail']);
     unset($_SESSION['userGroup']);

     header("Refresh:0; " . $redirectLocation);
   }

   /**
    * Registers a new user
    * If the mail adress isn't in our db
    * @param  [string] $newEmail    [The mail adress from the user]
    * @param  [string] $newPassword [The password that the user wants]
    * @return [boolean]              [If we succesed or not with registering a new user]
    */
   public function registerNewUser($newEmail, $newPassword, $group) {
     $db = new db();
     $s = new Security();

     $password = $this->generateHashPassword($s->checkInput($newPassword));

     if (!$this->checkIfEmailExists($newEmail)) {
       $sql = "INSERT INTO `user`(`mail`, `password`, `group`) VALUES (:mail, :password, :group)";
       $input = array(
         "mail" => $s->checkInput($newEmail),
         "password" => $s->checkInput($password),
         "group" => $s->checkInput($group)
       );

       $db->createData($sql, $input);

       return(true);
     }
     else {
       return(false);
     }
   }

   /**
    * This function checks if a client has acces
    * It checks if we have a login token
    * And if we can acces it with our group
    * @return [boolean] [If we have acces or not]
    */
   public function checkIfUserHasAcces() {
     if ($this->checkLoginToken() == true) {
       if ($this->checkUserGroup() == true) {
         return(true);
       }

       else {
         // false
         return(false);
       }

     }

     else {
       return(false);
     }
   }

   /**
    * Sets the acces for a page
    * @param [array] $groups [The groups]
    */
   public function setPageAcces($groups) {
     $this->pageAcces = $groups;
   }

   /**
    * This function saves the mail from a logged in user in a session
    * @param  [string] $mail [The mail of the user]
    */
   private function saveUserCredentials($mail) {
     $S = new Security();

     $_SESSION['userMail'] = $S->checkInput($mail);
   }

   /**
    * Checks if a user has acces to a page
    * @return [boolean] [description]
    */
   private function checkUserGroup() {
     foreach ($this->pageAcces as $key) {
       if ($key == $_SESSION['userGroup'] || $_SESSION['userGroup'] == 'admin') {
         $result = true;
         break;
         // We break the loop, other wise it could overwrite the result that someone has acces
       }
       else {
         $result = false;
       }
     }
     return($result);

   }

   /**
    * This function sets the group of a user in the session
    * @param [string] $mail [The mail account of the loged in user]
    */
   private function setUserGroup($mail) {
     $Db = new db();
     $S = new Security();

     $sql = "SELECT `group` FROM user WHERE `mail`=:mail";
     $input = array(
       "mail" => $S->checkInput($mail)
     );
     $result = $Db->readData($sql, $input);

     foreach ($result as $key) {
       $_SESSION['userGroup'] = $key['group'];
     }
   }

   /**
    * Sets the login token when the client has succesfully logged in
    */
   private function setLoginToken() {
     $_SESSION['loginToken'] = $this->loginToken;
   }

   /**
    * Checks if a email exists in the db
    * @param  [stirng] $userMailInput [The input from the user that contains the mail adress]
    * @return [boolean]                [If the mail exists in the db]
    */
   private function checkIfEmailExists($userMailInput) {
     $db = new db();
     $s = new Security();

     $sql = "SELECT `mail` FROM user WHERE `mail`=:mail";
     $input = array(
       "mail" => $s->checkInput($userMailInput)
     );
     $result = $db->countRows($sql, $input);

     if ($result > 0) {
       return(true);
     }
     else if ($result == 0) {
       return(false);
     }
   }

   /**
    * Validate a if the password that was filled in was correct
    * @param  [string] $userInputPassword [The password that the client filled in]
    * @param  [hashed string] $hashedPassword    [The hashed password from the db]
    * @return [boolean]      [If the passwords are the same]
    */
   private function validatePassword($userInputPassword, $hashedPassword) {

     if (password_verify($userInputPassword, $hashedPassword)) {
       $result = true;

     }
     else if (!password_verify($userInputPassword, $hashedPassword)) {
       $result = false;

     }

     return($result);
   }

   /**
    * Gets the orginal hashed password from the database
    * @param  [stirng] $userMail [The mail of the user]
    * @return [string]           [The hashed password from the db]
    */
   private function getOrginalPassword($userMail) {
     $db = new db();
     $s = new Security();

     $sql = "SELECT password FROM user WHERE `mail`=:mail";
     $input = array(
       "mail" => $s->checkInput($userMail)
     );
     $result = $db->readData($sql, $input);

     foreach ($result as $key) {
       return($key['password']);
       break;
     }
   }

   /**
    * Generates a hashed password
    * @param  [string] $password [The incomeping unhashed password]
    * @return [string hashed] [The new password]
    */
   private function generateHashPassword($password) {
     $s = new Security();
     $password = $s->checkInput($password);

     $password = password_hash($password, PASSWORD_DEFAULT);

     return($password);
   }


   /**
    * Checks the login token for a user
    * @return [boolean] [Returns if the login token is the same]
    */
   private function checkLoginToken() {
     // Checks if the user has the same login token
     // Returns true or false
     if (ISSET($_SESSION['loginToken'])) {
       if ($_SESSION['loginToken'] === $this->loginToken) {
         return(true);
       }
       else {
         return(false);
       }
     }
     else {
       return(false);
     }
   }

   public function isLogedIn() {
     return($this->checkLoginToken());
   }
 }

// $user = new User();
// $user->registerNewUser("admin@multiversum.nl", '1234');



?>
