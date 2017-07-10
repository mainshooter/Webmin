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
      $mail = $_POST['loginMail'];
      $password = $_POST['loginPassword'];

      $this->User->userLogin($mail, $password, '/dashboard/');
    }

    public function loginForm() {
      if ($this->User->checkIfUserHasAcces('admin')) {
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

  }


?>
