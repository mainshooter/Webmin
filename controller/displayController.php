<?php
  require_once 'model/DatabaseHandler.class.php';

  class displayController {

    /**
     * The default method of the controller that present the default view
     */
    public function index() {
      include 'view/header.php';
        include 'view/result.php';
        include 'view/sidebar.html';
      include 'view/footer.php';
    }
  }

?>
