<?php

  class security {

    /**
     * Removes any HTML and javascript
     * @param  [string] $data [The data that needs the be checked]
     * @return [string]       [With the removed HTML and Javascript]
     */
    public function checkInput($data) {
      // This funcion checks the input
      $data = trim($data);
      $data = stripslashes($data);
      $data = htmlspecialchars($data);
      $data = htmlentities($data);
      return ($data);
    }

    /**
     * Generates a random number
     * @return [string] [of numbers]
     */
    public function generateRandomCode() {
        $output = rand(1,9);
        // Prefents the first number to be a 0

        for($i=0; $i<25; $i++) {
            $output .= rand(0,9);
        }

        return $output;
    }
  }


?>
