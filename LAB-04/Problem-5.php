<?php
    echo "Question 5 </br>";
  $sequence = "1-2_3#4_5-6#7-8_9#10";
  echo "input :" . $sequence;
  echo "</br>";

  echo "output:";
  $sequenceArr = explode("-_", $sequence);

  foreach ($sequenceArr as $key => $value) {
    if ($key == 0) {
      $value = ltrim($value, "-#_");
    } elseif ($key == count($sequenceArr) - 1) {
      $value = rtrim($value, "-#_");
    }
    echo $value;
  }
  echo "</br>";
  echo "</br>";
  ?>