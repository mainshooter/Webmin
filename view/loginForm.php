<form method="post" class="col-6" action="<?php echo $GLOBALS['config']['base_url'] ?>user/login/">
  <label>Mail</label>
  <input type="mail" name="loginMail">
  <br>
  <label>Wachtwoord</label>
  <input type="password" name="loginPassword">

  <br>

  <input type="submit" name="login" value="Login">
</form>
