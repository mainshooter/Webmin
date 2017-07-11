<form class="col-6" method="post" action="<?php echo $GLOBALS['config']['base_url'] ?>user/register">
  <label>Mail</label>
  <input type="mail" name="registerMail">
  <label>Wachtwoord</label>
  <input type="password" name="registerPassword">
  <label>Wachtwoord bevesteging</label>
  <input type="password" name="registerPasswordConfirm">
  <br>
  <input type="submit" name="registerUser" value="Registeren">
</form>
