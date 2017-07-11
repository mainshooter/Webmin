<?php
  require_once 'model/User.class.php';


  class userController {

    private $User;

    function __construct() {
      $this->User = new User();
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

        $this->User->userLogin($mail, $password, '/dashboard/');
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
          $this->User->registerNewUser($mail, $password, 'admin');
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
