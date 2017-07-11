<div class="col-6">
  <?php
echo "<table>";
  echo "<tr>";
    echo "<th>Server naam</th>";
    echo "<th>Server IP</th>";
    echo "<th></th>";
  echo "</tr>";
  foreach ($servers as $key) {
    echo "
      <tr>
        <td>" . $key['serverName'] . "</td>
        <td>" . $key['serverIP'] . "</td>
        <td><a href='" . $GLOBALS['config']['base_url'] . "server/details/" . $key['idserver'] . "'>Server details</td>
      </tr>
    ";
  }
echo "</table>";

  ?>
</div>
