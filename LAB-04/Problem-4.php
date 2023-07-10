<?php
echo "Question 4 </br>";
  function bubbleSort($arr)
  {
    $n = count($arr);
    for ($i = 0; $i < $n; $i++) {
      for ($j = $i + 1; $j < $n; $j++) {
        if ($arr[$i] < $arr[$j]) {
          $temp = $arr[$i];
          $arr[$i] = $arr[$j];
          $arr[$j] = $temp;
        }
      }
    }
    return $arr;
  }
  echo "</br>";
  $number = array(1, 8, 5, 3, 5);
  echo "Original List :" . implode(",", $number) . "\n";
  echo "</br>";
  $sorted = bubbleSort($number);
  echo "Sorted List :" . implode(",", $sorted) . "\n";
  echo "</br>";
  ?>