<?php

  class cookie {
    var $cookieName;

    public function createCookie() {
      setcookie($this->cookieName);
    }

    /**
     * Reads a cockie by the coockie name
     * @return [string / array] [Returns the value, values or array from a coockie]
     */
    public function readCookie() {
      return($_COOKIE[$this->cookieName]);
    }


    /**
     * Delets a coockie
     */
    public function deleteCookie() {
      unset($_COOKIE[$this->cookieName]);
    }
  }


?>
