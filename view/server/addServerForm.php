<form class="col-6" method="post" action="<?php echo $GLOBALS['config']['base_url'] ?>server/addServer/">
  <label>Server naam</label>
  <input type="text" name="serverName" />

  <label>ServerIP</label>
  <input type="text" name="serverIP"/>

  <label>Server Port</label>
  <input type="number" name="serverPort">

  <label>Server username</label>
  <input type="text" name="serverUsername">

  <label>Server password</label>
  <input type="text" name="serverPassword">
  <br>
  <input type="submit" name="serverToevoegen" value="Toevoegen">
</form>
