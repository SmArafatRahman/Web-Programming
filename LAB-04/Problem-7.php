<?php
  echo "Question 7 </br>";
  $string = "This is a string with special characters !@#$%^&*-_=+\<>?/";
  $pattern = '/[^a-zA-Z0-9\s]/';
  $replacement = '';

  $cleaned_string = preg_replace($pattern, $replacement, $string);

  echo "Original string: " . $string . "</br>";
  echo "Cleaned string: " . $cleaned_string . "</br>";
  ?>