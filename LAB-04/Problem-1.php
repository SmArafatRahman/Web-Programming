  <?php
    echo "Question 1 </br>";

  function isPrime($num)
  {
    if ($num <= 1) {
      return false;
    }
    for ($i = 2; $i <= sqrt($num); $i++) {
      if ($num % $i == 0) {
        return false;
      }
    }
    return true;
  }
  $sum = 0;
  for ($i = 1000; $i <= 3000; $i++) {
    if (isPrime($i)) {
      $sum += $i;
    }
  }
  echo "The sum of all prime numbers between 1000 and 3000 is: " . $sum;
  ?>