<div class="col-6">
  <?php
  $teller = 0;
echo "<table>";
  echo "<tr>";
    echo "<th>Server naam</th>";
    echo "<th>Server IP</th>";
    echo "<th>Status</th>";
    echo "<th></th>";
    echo "<th></th>";
  echo "</tr>";
  foreach ($servers as $key) {
    echo "
      <tr>
        <td>" . $key['serverName'] . "</td>
        <td>" . $key['serverIP'] . "</td>
        <td>" . $serverStatus[$teller] . "</td>
        <td><a href='" . $GLOBALS['config']['base_url'] . "server/details/" . $key['idserver'] . "'>Server details</a></td>
        <td><a href='" . $GLOBALS['config']['base_url'] . "server/update/" . $key['idserver'] . "'>Update server credentials</a></td>
      </tr>
    ";
    $teller++;
  }
echo "</table>";

  ?>
</div>
