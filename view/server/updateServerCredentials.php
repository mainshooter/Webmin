<form class="col-6" method="post" action="<?php echo $GLOBALS['config']['base_url'] ?>server/updateServer/">

  <label>Server name<label>
  <input type="text" name="serverName" value="<?php echo $serverName ?>">

  <label>Server IP</label>
  <input type="text" name="serverIP" value="<?php echo $serverIP ?>">

  <label>Server port</label>
  <input type="text" name="serverPort" value="<?php echo $serverPort ?>">

  <label>Server username</label>
  <input type="text" name="serverUsername" value="<?php echo $serverUsername ?>">

  <label>Server password</label>
  <input type="password" name="serverPassword">

  <label>Server password confirmation</label>
  <input type="password" name="serverPasswordConfirm">
  <br>
  <input type="submit" name="serverUpdate">
</form>
