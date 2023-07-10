<?php
  echo "Question 2 </br>";
 for($i = 5; $i>=0; $i--){
    
    
    for($j = 5; $j>=$i; $j--){
   	echo "&nbsp;&nbsp;";
    }
    
    for($k = 0; $k<=$i; $k++){
    echo "*";
    }
    echo "</br>";
    }


 for($i = 0; $i<=5; $i++){
    
    
    for($j = 5; $j>=$i; $j--){
   	echo "&nbsp;&nbsp;";
    }
    
    for($k = 0; $k<=$i; $k++){
    echo "*";
    }
    echo "</br>";
    }

    
for($i = 0; $i<=5; $i++){
    
    for($j = 5; $j>=$i; $j--){
    echo "*";
    }
    echo "</br>";
    }
    
 for($i = 1; $i<=5; $i++){
    
    
    for($j = 5; $j>=$i; $j--){
    echo " ";
    }
    
    for($k = 0; $k<=$i; $k++){
    echo "*";
    }
    echo "</br>";
    }

 echo "Print Exercise Problem: </br>";

    for($i = 0; $i < 5; $i++) {
        for($j = 0; $j < $i; $j++) {
            echo "&nbsp;&nbsp;";
        }
        
        for($k = 0; $k < 2 * (5 - $i) - 1; $k++) {
            echo "*";
        }
        echo "<br>";
    }

    
    for($i = 1; $i < 5; $i++) {
        for($j = 0; $j < 5 - $i - 1; $j++) {
            echo "&nbsp;&nbsp;";
        }
        for($k = 0; $k < 2 * $i + 1; $k++) {
            echo "*";
        }
        echo "<br>";
    } 
?>