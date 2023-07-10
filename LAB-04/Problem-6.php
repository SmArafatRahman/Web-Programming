<?php
    echo "Question 6 </br>";
  echo "</br>";
  $string = 'The quick brown [dog].';
  $pattern = '/\[(.*?)\]/';

  preg_match($pattern, $string, $matches);
  $output = $matches[1];
  echo "Output : " .$output."</br>";

  ?>
