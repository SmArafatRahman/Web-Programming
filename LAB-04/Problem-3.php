<?php
  
    echo "Question 3 </br>";
    echo "output: </br>";
  
  function changeCase($arr, $case = "lower")
  {
    $newArr = array();
    foreach ($arr as $key => $value) {
      if ($case == "lower") {
        $newArr[$key] = strtolower($value);
      } else {
        $newArr[$key] = strtoupper($value);
      }
    }
    return $newArr;
  }

  $Color = array('A' => 'Blue', 'B' => 'Green', 'c' => 'Red');
  echo "Values are in lower case.\n";
  print_r(changeCase($Color, "lower"));
  echo "Values are in upper case.\n";
  print_r(changeCase($Color, "upper"));
  ?>