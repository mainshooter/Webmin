<?php
  class HtmlGenerator {


    /**
     * generates a Table
     * @param  [array] $header [The header names]
     * @param  [assoc array] $rows   [The rows content]
     * @return [string / html]         [The table]
     */
    public function generateTable($header, $rows) {
      $table = '
        <table>
      ';

        $table .= '<tr>';
        foreach ($header as $key) {
          $table .= '<th>' . $key . '</th>';
        }
        $table .= '</tr>';

      foreach ($rows as $row) {
        $table .= '<tr>';
        foreach ($row as $key => $value) {
          $table .= '<td>' . $value . '</td>';
        }
        $table .= '</tr>';
      }

      $table .= '</table>';
      return($table);
    }

}

?>
