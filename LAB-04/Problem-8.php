<?php
    echo "Question 8 </br>";
  echo "<table border='1' style=border-collapse:collapse;>";
  $count = 1;
  for ($row = 1; $row <= 10; $row++) {
    echo "<tr>";
    for ($col = 1; $col <= 10; $col++) {
      echo "<td>$count</td>";
      $count++;
    }
    echo "</tr>";
  }
  echo "</table>";
  ?>