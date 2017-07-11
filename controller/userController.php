<?php
  require_once 'model/User.class.php';
  require_once 'model/Security.class.php';


  class userController {

    private $User;

    function __construct() {
      $this->User = new User();
      $this->S = new Security();
    }

    /**
     * The default method in the controller
     * It calls the loginForm method
     */
    public function index() {
      $this->loginForm();
    }

    public function login() {
      if (ISSET($_POST['loginMail']) && ISSET($_POST['loginPassword'])) {
        // When there is a login request the come here
        $mail = $_POST['loginMail'];
        $password = $_POST['loginPassword'];

        $loginResult = $this->User->userLogin($mail, $password, $GLOBALS['config']['base_url'] . 'dashboard/');

        if (!$loginResult) {
          // When the login fails
          include 'view/header.php';
          echo "<h2 class='col-6'>Combinatie klopt niet!</h2>";
            include 'view/loginForm.php';
          include 'view/footer.php';
        }
      }
      else {
        // When a user comes here by /user/login it comes here and goes to the login form
        $this->loginForm();
      }

    }

    /**
     * Shows to login form when someone comes here
     * But is someone is logged in we will redirect it to the dashboard
     * @return [type] [description]
     */
    public function loginForm() {
      $this->User->setPageAcces(['admin']);
      if ($this->User->checkIfUserHasAcces()) {
        // Redirect to the dashboard
        echo "We are logged in";
      }
      else {
        // View for the login
        include 'view/header.php';
          include 'view/loginForm.php';
        include 'view/footer.php';
      }
    }

    /**
     * Shows the register form to register a user
     */
    public function registerForm() {
      include 'view/header.php';
        include 'view/registerUser.php';
      include 'view/footer.php';
    }


    public function register() {
      // Check if there is a register with everything filled in
      if (ISSET($_POST['registerMail']) && ISSET($_POST['registerPassword']) && ISSET($_POST['registerPasswordConfirm']) && $_POST['registerUser']) {

        if ($_POST['registerPassword'] === $_POST['registerPasswordConfirm']) {
          // Same password
          $mail = $_POST['registerMail'];
          $password = $_POST['registerPassword'];
          $registerResult = $this->User->registerNewUser($mail, $password, 'admin');
          if ($registerResult) {
            // If the register is succesed
            include 'view/header.php';
              include 'view/accountIsRegisterd.php';
              include 'view/loginForm.php';
            include 'view/footer.php';
          }
          else {
            // If it is faild
            include 'view/header.php';
            echo "<h2 class='col-6'>Deze gebruiker bestaat al</h2>";
              include 'view/registerUser.php';
            include 'view/footer.php';
          }

        }
      }

      else {
          // No user register
          // A user came here by excident
          $this->registerForm();
      }
    }

  }


?>
